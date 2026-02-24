<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_コンビニ払いで購入完了する()
    {
        [$buyer, $product] = $this->preparePurchaseContext();

        $response = $this->get("/purchase/{$product->id}");
        $response->assertStatus(200);

        $purchaseResponse = $this->post("/purchase/{$product->id}", $this->purchasePayload($product, [
            'payment' => 'convenience',
        ]));
        $purchaseResponse->assertRedirect('/');

        $this->assertPurchaseSaved($buyer, $product, 'convenience');
    }

    public function test_カード払いで購入完了する()
    {
        [$buyer, $product] = $this->preparePurchaseContext();

        $response = $this->get("/purchase/{$product->id}");
        $response->assertStatus(200);

        config(['services.stripe.secret' => 'sk_test_dummy']);
        Http::fake([
            'https://api.stripe.com/v1/checkout/sessions' => Http::response([
                'id' => 'cs_test_card_only',
                'url' => 'https://checkout.stripe.test/session/cs_test_card_only',
            ], 200),
            'https://api.stripe.com/v1/checkout/sessions/*' => Http::response([
                'id' => 'cs_test_card_only',
                'payment_status' => 'paid',
            ], 200),
        ]);

        $purchaseResponse = $this->post("/purchase/{$product->id}", $this->purchasePayload($product, [
            'payment' => 'card',
        ]));
        $purchaseResponse->assertRedirect('https://checkout.stripe.test/session/cs_test_card_only');

        $successResponse = $this->get("/purchase/{$product->id}/stripe/success?session_id=cs_test_card_only");
        $successResponse->assertRedirect('/');

        $this->assertPurchaseSaved($buyer, $product, 'card');
    }

    public function test_Sold表示される()
    {
        $seller = $this->createUser();
        $buyer = $this->createUserWithProfile();
        $product = $this->createProduct([
            'user_id' => $seller->id,
        ]);
        $this->createPurchase($buyer, $product);

        $indexResponse = $this->get('/');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSeeText($product->name);
        $indexResponse->assertSee('Sold');
    }

    public function test_マイページに購入商品が表示される()
    {
        $seller = $this->createUser();
        $buyer = $this->createUserWithProfile();
        $product = $this->createProduct([
            'user_id' => $seller->id,
        ]);
        $this->createPurchase($buyer, $product);
        $this->actingAs($buyer);

        $mypageResponse = $this->get('/mypage');
        $mypageResponse->assertStatus(200);

        $purchaseSection = $this->purchaseSection($mypageResponse->getContent());
        $this->assertStringContainsString($product->name, $purchaseSection);
    }
}
