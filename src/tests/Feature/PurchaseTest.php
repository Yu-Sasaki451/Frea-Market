<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_購入処理、Soldの表示()
    {
        $seller = $this->createUser();
        $buyer = $this->createUserWithProfile();

        $product = $this->createProduct([
            'user_id' => $seller->id,
        ]);

        $this->actingAs($buyer);

        $response = $this->get("/purchase/{$product->id}");
        $response->assertStatus(200);

        $purchaseResponse = $this->post("/purchase/{$product->id}", [
            'name' => $product->name,
            'price' => $product->price,
            'post_code' => '123-4567',
            'address' => '東京都港区1-2-3',
            'building' => 'テストビル101',
            'payment' => 'card',
        ]);

        $purchaseResponse->assertRedirect('/');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'payment' => 'card',
            'post_code' => '123-4567',
            'address' => '東京都港区1-2-3',
            'building' => 'テストビル101',
        ]);

        $indexResponse = $this->get('/');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSeeText($product->name);
        $indexResponse->assertSee('Sold');
    }

    /**
     * @return void
     */
    public function test_商品購入、マイページに購入商品表示()
    {
        $seller = $this->createUser();
        $buyer = $this->createUserWithProfile();

        $product = $this->createProduct([
            'user_id' => $seller->id,
        ]);

        $this->actingAs($buyer);

        $response = $this->get("/purchase/{$product->id}");
        $response->assertStatus(200);

        $purchaseResponse = $this->post("/purchase/{$product->id}", [
            'name' => $product->name,
            'price' => $product->price,
            'post_code' => '123-4567',
            'address' => '東京都港区1-2-3',
            'building' => 'テストビル101',
            'payment' => 'card',
        ]);

        $purchaseResponse->assertRedirect('/');

        $mypageResponse = $this->get('/mypage');
        $mypageResponse->assertStatus(200);
        $mypageResponse->assertSeeText($product->name);
    }
}
