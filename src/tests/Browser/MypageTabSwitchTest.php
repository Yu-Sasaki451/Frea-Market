<?php

namespace Tests\Browser;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MypageTabSwitchTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_マイページで購入タブへ切り替わる(): void
    {
        $seller = User::factory()->create();
        $user = User::factory()->create();

        $this->createBrowserProfile($user);

        Product::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);

        $purchasedProduct = Product::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入商品',
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $purchasedProduct->id,
            'name' => $purchasedProduct->name,
            'price' => $purchasedProduct->price,
            'payment' => 'card',
            'post_code' => '123-4567',
            'address' => '東京都港区1-2-3',
            'building' => 'テストビル101',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/mypage')
                ->assertPresent('#tab-purchase')
                ->assertPresent('#panel-purchase')
                ->assertAttribute('#panel-purchase', 'hidden', 'true')
                ->click('#tab-purchase')
                ->pause(200)
                ->assertMissing('#panel-purchase[hidden]')
                ->assertPresent('#panel-sell[hidden]')
                ->assertAttribute('#tab-purchase', 'aria-selected', 'true')
                ->assertSee('購入商品');
        });
    }
}
