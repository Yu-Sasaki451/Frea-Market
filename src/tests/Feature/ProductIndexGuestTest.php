<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductIndexGuestTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品一覧表示、ゲスト(){
        $this->createProduct(['name' => '商品A']);
        $this->createProduct(['name' => '商品B']);
        $this->createProduct(['name' => '商品C']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
        $response->assertSee('商品C');
    }
}
