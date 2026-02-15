<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MypageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_マイページ表示(){

        $user = $this->createUserWithProfile();
        $seller = $this->createUser();

        $purchasedProduct = $this->createProduct([
            'user_id' => $seller->id,
            'name' => '購入した商品',
            'image' => 'products/sell-product.jpg'
        ]);
        $sellProduct = $this->createProduct([
            'user_id' => $user->id,
            'name' => '出品した商品',
            'image' => 'products/buy-product.jpg'
        ]);

        $this->createPurchase($user, $purchasedProduct);

        $response = $this->actingAs($user)->get("/mypage");
        $response->assertStatus(200);
        $response->assertSeeText('テストネーム');
        $response->assertSee('storage/profiles/default-test.png');

        $sellSection = $this->sellSection($response->getContent());
        $this->assertStringContainsString($sellProduct->name, $sellSection);

        $purchaseSection = $this->purchaseSection($response->getContent());
        $this->assertStringContainsString($purchasedProduct->name, $purchaseSection);

    }
}
