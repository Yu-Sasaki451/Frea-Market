<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductIndexAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品一覧表示、ログインユーザー(){
        $user = $this->createUser();
        $buyer = $this->createUser();

        $productA = $this->createProduct(['name' => '商品A']);
        $productB = $this->createProduct(['name' => '商品B', 'user_id' => $user->id]);
        $productC = $this->createProduct(['name' => '商品C']);
        $productD = $this->createProduct(['name' => '商品D']);

        $this->createPurchase($buyer, $productD);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertDontSee('商品B');
        $response->assertSee('商品C');
        $response->assertSee('商品D');
        $response->assertSeeInOrder(['商品D', 'Sold']);
        $this->assertSame(1, substr_count($response->getContent(), 'Sold'));
    }

}
