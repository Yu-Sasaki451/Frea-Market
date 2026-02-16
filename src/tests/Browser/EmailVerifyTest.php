<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\URL;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EmailVerifyTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_メール認証導線から認証サイトを表示できる(): void
    {
        $user = User::factory()->create([
            'email' => 'verify-dusk@example.com',
            'email_verified_at' => null,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/mypage/profile')
                ->assertPathIs('/email/verify')
                ->assertSee('登録していただいたメールアドレスに認証メールを送付しました。')
                ->assertSeeLink('認証はこちらから');

            $browser->script("document.querySelector('.verify-email__button').removeAttribute('target');");

            $browser->clickLink('認証はこちらから')
                ->pause(500);

            $this->assertStringContainsString('8025', $browser->driver->getCurrentURL());
        });
    }

    public function test_メール認証完了後にプロフィール設定画面を表示できる(): void
    {
        $user = User::factory()->create([
            'email' => 'verify-complete@example.com',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $this->browse(function (Browser $browser) use ($user, $verificationUrl) {
            $browser->loginAs($user)
                ->visit($verificationUrl)
                ->visit('/mypage/profile')
                ->assertPathIs('/mypage/profile')
                ->assertSee('プロフィール設定');
        });

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
