<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerifyTest extends TestCase
{
    use RefreshDatabase;

    public function test_会員登録時に認証メールが送信される()
    {
        Notification::fake();

        $data = [
            'name' => 'テスト',
            'email' => 'verify-test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->post('/register', $data);

        $user = User::where('email', 'verify-test@example.com')->first();

        $this->assertNotNull($user);
        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
