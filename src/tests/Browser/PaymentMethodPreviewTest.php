<?php

namespace Tests\Browser;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentMethodPreviewTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_支払い方法選択でプレビューが更新される(): void
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();

        $this->createBrowserProfile($buyer);

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $this->browse(function (Browser $browser) use ($buyer, $product) {
            $browser->loginAs($buyer)
                ->visit("/purchase/{$product->id}")
                ->assertPresent('#paymentSelect')
                ->assertPresent('#paymentPreview')
                ->select('#paymentSelect', 'convenience')
                ->waitForTextIn('#paymentPreview', 'コンビニ支払い')
                ->select('#paymentSelect', 'card')
                ->waitForTextIn('#paymentPreview', 'カード支払い');
        });
    }
}
