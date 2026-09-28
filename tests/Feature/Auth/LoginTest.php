<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_user_can_log_in(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_shows_japanese_error(): void
    {
        $user = User::factory()->create();

        $this->from('/login')
            ->followingRedirects()
            ->post('/login', ['email' => $user->email, 'password' => 'wrong-password'])
            ->assertSee('ログイン情報が登録されていません。');

        $this->assertGuest();
    }

    public function test_unregistered_email_shows_japanese_error(): void
    {
        $this->post('/login', ['email' => 'nobody@example.com', 'password' => 'password'])
            ->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません。']);

        $this->assertGuest();
    }

    public function test_empty_input_shows_japanese_errors(): void
    {
        $this->post('/login', [])
            ->assertSessionHasErrors([
                'email' => 'メールアドレスを入力してください。',
                'password' => 'パスワードを入力してください。',
            ]);
    }

    public function test_logged_in_user_is_redirected_from_login_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/login')
            ->assertRedirect('/');
    }
}
