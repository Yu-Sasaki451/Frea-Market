<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LogoutTest extends TestCase
{

    use RefreshDatabase;

    public function test_ログアウト(){

        $user = User::create([
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login_form'));
    }
}
