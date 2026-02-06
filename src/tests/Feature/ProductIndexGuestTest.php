<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductIndexGuestTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品一覧表示、ゲスト(){
        Product::factory()->create(['name' => '商品A']);
        Product::factory()->create(['name' => '商品B']);
        Product::factory()->create(['name' => '商品C']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
        $response->assertSee('商品C');
    }
}
