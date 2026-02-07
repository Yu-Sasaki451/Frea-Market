<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class ProductIndexAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品一覧表示、ログインユーザー(){
        $user = User::factory()->create();
        $this->actingAs($user);

        $productA = Product::factory()->create(['name' => '商品A']);
        $productB = Product::factory()->create(['name' => '商品B', 'user_id' => $user->id]);
        $productC = Product::factory()->create(['name' => '商品C']);
        $productD = Product::factory()->create(['name' => '商品D']);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $productD->id,
            'name' => $productD->name,
            'price' => $productD->price,
            'payment' => 'card',
            'address' => '東京都',
            'building' => null,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertDontSee('商品B');
        $response->assertSee('商品C');
        $response->assertSee('商品D');
        $response->assertSeeInOrder(['商品D', 'Sold']);
        $this->assertSame(1, substr_count($response->getContent(), 'Sold'));
    }

}
