<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{array<string, string>, string, string}>
     */
    public static function invalidInputs(): array
    {
        return [
            'ユーザー名が空' => [['name' => ''], 'name', 'ユーザー名を入力してください。'],
            'メールアドレスが空' => [['email' => ''], 'email', 'メールアドレスを入力してください。'],
            'メールアドレスの形式が不正' => [['email' => 'not-an-email'], 'email', 'メールアドレスには有効なメールアドレスを入力してください。'],
            'パスワードが空' => [['password' => '', 'password_confirmation' => ''], 'password', 'パスワードを入力してください。'],
            'パスワードが7文字' => [['password' => '1234567', 'password_confirmation' => '1234567'], 'password', 'パスワードは8文字以上で入力してください。'],
            '確認用パスワードが一致しない' => [['password_confirmation' => 'different'], 'password', 'パスワードと確認用の入力が一致しません。'],
        ];
    }

    public function test_register_page_can_be_rendered(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function test_user_can_register_and_is_logged_in(): void
    {
        $response = $this->post('/register', $this->validInput());

        $response->assertRedirect('/');
        $user = User::where('email', 'test@example.com')->firstOrFail();
        $this->assertSame('テストユーザー', $user->name);
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertAuthenticatedAs($user);
    }

    public function test_password_of_exactly_8_characters_is_accepted(): void
    {
        $this->post('/register', [
            ...$this->validInput(),
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ])->assertSessionHasNoErrors();

        $this->assertAuthenticated();
    }

    /**
     * @param  array<string, string>  $overrides
     */
    #[DataProvider('invalidInputs')]
    public function test_invalid_input_shows_japanese_error(array $overrides, string $field, string $message): void
    {
        $this->post('/register', [...$this->validInput(), ...$overrides])
            ->assertSessionHasErrors([$field => $message]);

        $this->assertGuest();
    }

    public function test_email_already_registered_is_rejected(): void
    {
        User::factory()->create(['email' => 'test@example.com']);

        $this->post('/register', $this->validInput())
            ->assertSessionHasErrors(['email' => 'このメールアドレスはすでに使われています。']);

        $this->assertGuest();
    }

    public function test_errors_are_shown_under_each_field(): void
    {
        $this->from('/register')
            ->followingRedirects()
            ->post('/register', [])
            ->assertSeeInOrder([
                'ユーザー名',
                'ユーザー名を入力してください。',
                'メールアドレス',
                'メールアドレスを入力してください。',
                'パスワード',
                'パスワードを入力してください。',
                '確認用パスワード',
            ]);
    }

    /**
     * @return array<string, string>
     */
    private function validInput(): array
    {
        return [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
    }
}
