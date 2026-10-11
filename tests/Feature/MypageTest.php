<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_mypage(): void
    {
        $this->get('/mypage')->assertRedirect('/login');
    }

    public function test_unverified_user_is_redirected_to_notice(): void
    {
        $this->actingAs(User::factory()->unverified()->create())
            ->get('/mypage')
            ->assertRedirect('/email/verify');
    }

    public function test_mypage_can_be_rendered(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/mypage')
            ->assertOk()
            ->assertViewIs('profile.show');
    }

    public function test_avatar_and_name_are_shown(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'avatar_path' => 'avatars/current.png',
        ]);

        $this->actingAs($user)
            ->get('/mypage')
            ->assertOk()
            ->assertSee('/storage/avatars/current.png"', false)
            ->assertSee('テストユーザー');
    }

    public function test_no_image_is_shown_when_avatar_is_not_set(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/mypage')
            ->assertOk()
            ->assertDontSee('alt="プロフィール画像"', false);
    }

    public function test_mypage_links_to_profile_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/mypage')
            ->assertOk()
            ->assertSee('プロフィールを編集')
            ->assertSee('href="'.route('profile.edit').'"', false);
    }

    public function test_header_links_logged_in_user_to_mypage(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertOk()
            ->assertSee('マイページ')
            ->assertSee('href="'.route('profile.show').'"', false);
    }

    public function test_header_links_guest_to_mypage(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('マイページ')
            ->assertSee('href="'.route('profile.show').'"', false);
    }

    #[TestWith(['/login'])]
    #[TestWith(['/register'])]
    public function test_header_hides_mypage_link_on_guest_only_page(string $uri): void
    {
        $this->get($uri)
            ->assertOk()
            ->assertDontSee('マイページ');
    }

    public function test_header_hides_mypage_link_on_verification_notice_page(): void
    {
        $this->actingAs(User::factory()->unverified()->create())
            ->get('/email/verify')
            ->assertOk()
            ->assertDontSee('マイページ');
    }
}
