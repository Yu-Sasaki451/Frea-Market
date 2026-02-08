<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikedTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねで登録、合計値が増加()
    {
        $user = $this->createUser();
        $product = $this->createProduct();

        $this->actingAs($user)
            ->get("/item/{$product->id}")
            ->assertStatus(200);

        $this->actingAs($user)
            ->post("/item/{$product->id}");

        $this->assertDatabaseHas('product_likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('<span class="count">1</span>', false);
    }

    public function test_いいねで色が変化()
    {
        $user = $this->createUser();
        $product = $this->createProduct();

        $this->actingAs($user)
            ->get("/item/{$product->id}")
            ->assertStatus(200);

        $this->actingAs($user)
            ->post("/item/{$product->id}");

        $response = $this->actingAs($user)->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('product-action--like is-liked', false);
    }

    public function test_再度いいねで解除、合計値が減少()
    {
        $user = $this->createUser();
        $product = $this->createProduct();

        $this->likeProduct($user, $product);

        $this->actingAs($user)
            ->get("/item/{$product->id}")
            ->assertStatus(200);

        $this->actingAs($user)
            ->post("/item/{$product->id}");

        $this->assertDatabaseMissing('product_likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('<span class="count">0</span>', false);
        $response->assertDontSee('product-action--like is-liked', false);
    }
}
