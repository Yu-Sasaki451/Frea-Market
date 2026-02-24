<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_配送先住所変更、購入画面に反映()
    {
        $user = $this->createUserWithProfile();

        $product = $this->createProduct();

        $addressResponse = $this->actingAs($user)->post("/purchase/address/{$product->id}", [
            'post_code' => '987-6543',
            'address' => '東京都新宿区4-5-6',
            'building' => 'サンプルマンション202',
        ]);

        $addressResponse->assertStatus(302);

        $purchaseResponse = $this->get("/purchase/{$product->id}");
        $purchaseResponse->assertStatus(200);
        $purchaseResponse->assertSeeText('〒987-6543');
        $purchaseResponse->assertSeeText('東京都新宿区4-5-6');
        $purchaseResponse->assertSeeText('サンプルマンション202');
    }

    /**
     * @return void
     */
    public function test_配送先変更、購入情報に変更配送先保存()
    {
        $buyer = $this->createUserWithProfile();

        $product = $this->createProduct();

        $this->actingAs($buyer)->post("/purchase/address/{$product->id}", [
            'post_code' => '111-2222',
            'address' => '東京都渋谷区7-8-9',
            'building' => 'テストビル303',
        ]);

        $purchaseResponse = $this->post(
            "/purchase/{$product->id}",
            $this->purchasePayload($product, [
                'post_code' => '111-2222',
                'address' => '東京都渋谷区7-8-9',
                'building' => 'テストビル303',
                'payment' => 'convenience',
            ])
        );

        $purchaseResponse->assertRedirect('/');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'post_code' => '111-2222',
            'address' => '東京都渋谷区7-8-9',
            'building' => 'テストビル303',
        ]);
    }
}
