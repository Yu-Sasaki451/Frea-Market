<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_未ログイン時は空_ログイン時はいいね商品のみ表示()
    {
        $user = User::factory()->create();

        $likedProduct = Product::factory()->create([
            'name' => 'いいね商品',
        ]);
        $notLikedProduct = Product::factory()->create([
            'name' => '未いいね商品',
        ]);

        $user->likedProducts()->attach($likedProduct->id);

        $guestResponse = $this->get('/');
        $guestResponse->assertStatus(200);

        $guestMylistSection = $this->mylistSection($guestResponse->getContent());
        $this->assertStringNotContainsString('いいね商品', $guestMylistSection);
        $this->assertStringNotContainsString('未いいね商品', $guestMylistSection);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);

        $mylistSection = $this->mylistSection($response->getContent());
        $this->assertStringContainsString('いいね商品', $mylistSection);
        $this->assertStringNotContainsString('未いいね商品', $mylistSection);
    }

    public function test_購入済み商品にはSOLDが表示される()
    {
        $user = User::factory()->create();

        $soldProduct = Product::factory()->create([
            'name' => '購入済み商品',
        ]);

        $user->likedProducts()->attach($soldProduct->id);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $soldProduct->id,
            'name' => $soldProduct->name,
            'price' => $soldProduct->price,
            'payment' => 'card',
            'address' => '東京都',
            'building' => null,
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);

        $mylistSection = $this->mylistSection($response->getContent());
        $this->assertStringContainsString('購入済み商品', $mylistSection);
        $this->assertStringContainsString('Sold', $mylistSection);
    }

}
