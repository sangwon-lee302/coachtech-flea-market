<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_shows_logout_button_to_logged_in_user(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertSee('ログアウト');
    }

    public function test_header_hides_logout_button_from_guest(): void
    {
        $this->get('/')->assertDontSee('ログアウト');
    }

    public function test_user_can_log_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
