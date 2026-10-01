<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_sends_verification_email_and_redirects_to_notice(): void
    {
        Notification::fake();

        $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/email/verify');

        $user = User::where('email', 'test@example.com')->firstOrFail();
        $this->assertFalse($user->hasVerifiedEmail());
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_unverified_user_is_redirected_to_notice_after_login(): void
    {
        $user = User::factory()->unverified()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/email/verify');

        $this->assertAuthenticatedAs($user);
    }

    public function test_notice_page_can_be_rendered(): void
    {
        $this->actingAs(User::factory()->unverified()->create())
            ->get('/email/verify')
            ->assertOk()
            ->assertViewIs('auth.verify-email');
    }

    public function test_notice_page_links_to_inbox_when_configured(): void
    {
        config(['mail.inbox_url' => 'http://localhost:8025']);

        $this->actingAs(User::factory()->unverified()->create())
            ->get('/email/verify')
            ->assertSee('認証はこちらから')
            ->assertSee('href="http://localhost:8025"', false);
    }

    public function test_notice_page_hides_inbox_link_when_not_configured(): void
    {
        config(['mail.inbox_url' => null]);

        $this->actingAs(User::factory()->unverified()->create())
            ->get('/email/verify')
            ->assertDontSee('認証はこちらから');
    }

    public function test_verification_email_can_be_resent(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->from('/email/verify')
            ->followingRedirects()
            ->post('/email/verification-notification')
            ->assertSee('認証メールを再送しました。');

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_is_verified_and_redirected_to_home_via_email_link(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get($this->verificationUrl($user, $user->email))
            ->assertRedirect('/?verified=1');

        $this->assertTrue($user->fresh()?->hasVerifiedEmail());
    }

    public function test_user_returns_after_verification_to_page_opened_before_login(): void
    {
        Route::middleware(['web', 'auth', 'verified'])->get('/verified-only', fn () => 'ok');
        $user = User::factory()->unverified()->create();

        $this->get('/verified-only')->assertRedirect('/login');

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/email/verify');

        $this->get($this->verificationUrl($user, $user->email))
            ->assertRedirect('/verified-only');
    }

    public function test_user_is_not_verified_with_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get($this->verificationUrl($user, 'wrong@example.com'))
            ->assertForbidden();

        $this->assertFalse($user->fresh()?->hasVerifiedEmail());
    }

    public function test_unverified_user_cannot_open_page_requiring_verification(): void
    {
        Route::middleware(['web', 'auth', 'verified'])->get('/verified-only', fn () => 'ok');

        $this->actingAs(User::factory()->unverified()->create())
            ->get('/verified-only')
            ->assertRedirect('/email/verify');
    }

    public function test_verified_user_can_open_page_requiring_verification(): void
    {
        Route::middleware(['web', 'auth', 'verified'])->get('/verified-only', fn () => 'ok');

        $this->actingAs(User::factory()->create())
            ->get('/verified-only')
            ->assertOk();
    }

    private function verificationUrl(User $user, string $email): string
    {
        return URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
            'id' => $user->id,
            'hash' => sha1($email),
        ]);
    }
}
