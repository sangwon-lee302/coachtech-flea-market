<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // アップロードした画像を、実際のディスクではなくテスト用のディスクに保存する
        Storage::fake();
    }

    /**
     * @return array<string, array{array<string, string>, string, string}>
     */
    public static function invalidInputs(): array
    {
        return [
            'ユーザー名が空' => [['name' => ''], 'name', 'ユーザー名を入力してください。'],
            'ユーザー名が21文字' => [['name' => str_repeat('あ', 21)], 'name', 'ユーザー名は20文字以下で入力してください。'],
            '郵便番号が空' => [['postal_code' => ''], 'postal_code', '郵便番号を入力してください。'],
            '郵便番号にハイフンがない' => [['postal_code' => '1234567'], 'postal_code', '郵便番号は「123-4567」のように、半角数字とハイフンで入力してください。'],
            '郵便番号が全角' => [['postal_code' => '１２３-４５６７'], 'postal_code', '郵便番号は「123-4567」のように、半角数字とハイフンで入力してください。'],
            '住所が空' => [['address' => ''], 'address', '住所を入力してください。'],
            '住所が256文字' => [['address' => str_repeat('あ', 256)], 'address', '住所は255文字以下で入力してください。'],
            '建物名が256文字' => [['building' => str_repeat('あ', 256)], 'building', '建物名は255文字以下で入力してください。'],
        ];
    }

    public function test_guest_cannot_open_profile_page(): void
    {
        $this->get('/mypage/profile')->assertRedirect('/login');
    }

    public function test_guest_cannot_update_profile(): void
    {
        $this->patch('/mypage/profile', $this->validInput())->assertRedirect('/login');
    }

    public function test_unverified_user_is_redirected_to_notice(): void
    {
        $this->actingAs(User::factory()->unverified()->create())
            ->get('/mypage/profile')
            ->assertRedirect('/email/verify');
    }

    public function test_profile_page_can_be_rendered(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/mypage/profile')
            ->assertOk()
            ->assertViewIs('profile.edit')
            ->assertSee('enctype="multipart/form-data"', false);
    }

    public function test_avatar_input_points_to_preview_element(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/mypage/profile')
            ->assertOk()
            ->assertSee('id="avatar-preview"', false)
            ->assertSee('data-preview="avatar-preview"', false);
    }

    public function test_fields_are_filled_with_current_values(): void
    {
        $user = User::factory()->create([
            'name' => '現在の名前',
            'avatar_path' => 'avatars/current.png',
            'postal_code' => '987-6543',
            'address' => '大阪府大阪市北区梅田4-5-6',
            'building' => '梅田ビル202',
        ]);

        $this->actingAs($user)
            ->get('/mypage/profile')
            ->assertOk()
            ->assertSee('/storage/avatars/current.png"', false)
            ->assertSee('value="現在の名前"', false)
            ->assertSee('value="987-6543"', false)
            ->assertSee('value="大阪府大阪市北区梅田4-5-6"', false)
            ->assertSee('value="梅田ビル202"', false);
    }

    public function test_no_image_is_shown_when_avatar_is_not_set(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/mypage/profile')
            ->assertOk()
            ->assertDontSee('alt="プロフィール画像"', false);
    }

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/mypage/profile', [...$this->validInput(), 'avatar' => UploadedFile::fake()->image('avatar.jpg')])
            ->assertRedirect('/mypage');

        $this->assertDatabaseHas('users', ['id' => $user->id, ...$this->validInput()]);
        $path = $user->refresh()->avatar_path;
        $this->assertNotNull($path);
        Storage::assertExists($path);
    }

    public function test_uploaded_avatar_is_shown(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->followingRedirects()
            ->patch('/mypage/profile', [...$this->validInput(), 'avatar' => UploadedFile::fake()->image('avatar.png')])
            ->assertOk()
            ->assertSee('/storage/'.$user->refresh()->avatar_path.'"', false);
    }

    public function test_replacing_avatar_deletes_old_image(): void
    {
        Storage::put('avatars/old.png', 'old');
        $user = User::factory()->create(['avatar_path' => 'avatars/old.png']);

        $this->actingAs($user)
            ->patch('/mypage/profile', [...$this->validInput(), 'avatar' => UploadedFile::fake()->image('new.png')])
            ->assertSessionHasNoErrors();

        Storage::assertMissing('avatars/old.png');
        $path = $user->refresh()->avatar_path;
        $this->assertNotNull($path);
        $this->assertNotSame('avatars/old.png', $path);
        Storage::assertExists($path);
    }

    public function test_avatar_is_kept_when_no_image_is_selected(): void
    {
        Storage::put('avatars/current.png', 'current');
        $user = User::factory()->create(['avatar_path' => 'avatars/current.png']);

        $this->actingAs($user)
            ->patch('/mypage/profile', $this->validInput())
            ->assertSessionHasNoErrors();

        $this->assertSame('avatars/current.png', $user->refresh()->avatar_path);
        Storage::assertExists('avatars/current.png');
    }

    public function test_building_can_be_cleared(): void
    {
        $user = User::factory()->create(['building' => '梅田ビル202']);

        $this->actingAs($user)
            ->patch('/mypage/profile', [...$this->validInput(), 'building' => ''])
            ->assertSessionHasNoErrors();

        $this->assertNull($user->refresh()->building);
    }

    public function test_name_of_exactly_20_characters_is_accepted(): void
    {
        $this->actingAs(User::factory()->create())
            ->patch('/mypage/profile', [...$this->validInput(), 'name' => str_repeat('あ', 20)])
            ->assertSessionHasNoErrors();
    }

    /**
     * @param  array<string, string>  $overrides
     */
    #[DataProvider('invalidInputs')]
    public function test_invalid_input_shows_japanese_error(array $overrides, string $field, string $message): void
    {
        $user = User::factory()->create(['name' => '現在の名前']);

        $this->actingAs($user)
            ->patch('/mypage/profile', [...$this->validInput(), ...$overrides])
            ->assertSessionHasErrors([$field => $message]);

        $this->assertSame('現在の名前', $user->refresh()->name);
    }

    public function test_avatar_other_than_jpeg_and_png_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())
            ->patch('/mypage/profile', [...$this->validInput(), 'avatar' => UploadedFile::fake()->image('avatar.gif')])
            ->assertSessionHasErrors(['avatar' => 'プロフィール画像には次のいずれかの形式のファイルを指定してください: jpeg, png']);

        $this->assertSame([], Storage::allFiles());
    }

    public function test_avatar_larger_than_2048_kilobytes_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())
            ->patch('/mypage/profile', [...$this->validInput(), 'avatar' => UploadedFile::fake()->image('avatar.png')->size(2049)])
            ->assertSessionHasErrors(['avatar' => 'プロフィール画像には2048KB以下のファイルを指定してください。']);

        $this->assertSame([], Storage::allFiles());
    }

    public function test_errors_are_shown_under_each_field(): void
    {
        $this->actingAs(User::factory()->create())
            ->from('/mypage/profile')
            ->followingRedirects()
            ->patch('/mypage/profile', ['avatar' => UploadedFile::fake()->image('avatar.gif')])
            ->assertOk()
            ->assertSeeInOrder([
                '画像を選択する',
                'プロフィール画像には次のいずれかの形式のファイルを指定してください: jpeg, png',
                'ユーザー名',
                'ユーザー名を入力してください。',
                '郵便番号',
                '郵便番号を入力してください。',
                '住所',
                '住所を入力してください。',
                '建物名',
            ]);
    }

    public function test_entered_values_are_kept_after_validation_error(): void
    {
        $this->actingAs(User::factory()->create(['name' => '現在の名前']))
            ->from('/mypage/profile')
            ->followingRedirects()
            ->patch('/mypage/profile', [...$this->validInput(), 'postal_code' => ''])
            ->assertOk()
            ->assertSee('value="テストユーザー"', false)
            ->assertDontSee('value="現在の名前"', false);
    }

    /**
     * @return array<string, string>
     */
    private function validInput(): array
    {
        return [
            'name' => 'テストユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
            'building' => '千駄ヶ谷マンション101',
        ];
    }
}
