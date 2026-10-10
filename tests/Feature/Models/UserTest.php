<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_address_is_not_included_in_json(): void
    {
        $user = User::factory()->make([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
            'building' => '千駄ヶ谷マンション101',
        ]);

        $json = json_decode($user->toJson(), true);

        $this->assertIsArray($json);
        $this->assertArrayHasKey('name', $json);
        $this->assertArrayNotHasKey('postal_code', $json);
        $this->assertArrayNotHasKey('address', $json);
        $this->assertArrayNotHasKey('building', $json);
    }
}
