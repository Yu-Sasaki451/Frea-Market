<?php

namespace Tests\Browser;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MylistTabSwitchTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_トップ画面でマイリストタブへ切り替わる(): void
    {
        $seller = User::factory()->create();
        $user = User::factory()->create();

        $this->createBrowserProfile($user);

        $likedProduct = Product::factory()->create([
            'user_id' => $seller->id,
            'name' => 'いいね商品',
        ]);

        $user->likedProducts()->attach($likedProduct->id);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->assertPathIs('/')
                ->assertScript('return window.location.search;', '')
                ->assertPresent('#tab-mylist')
                ->assertPresent('#panel-mylist')
                ->assertAttribute('#panel-mylist', 'hidden', 'true')
                ->click('#tab-mylist')
                ->pause(200)
                ->assertScript('return window.location.search;', '?tab=mylist')
                ->assertMissing('#panel-mylist[hidden]')
                ->assertPresent('#panel-recommend[hidden]')
                ->assertAttribute('#tab-mylist', 'aria-selected', 'true')
                ->click('#tab-recommend')
                ->pause(200)
                ->assertScript('return window.location.search;', '')
                ->assertSee('いいね商品');
        });
    }
}
