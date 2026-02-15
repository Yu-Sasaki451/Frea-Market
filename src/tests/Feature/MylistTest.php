<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_未ログイン時はマイリストに商品が表示されない()
    {
        $user = $this->createUser();

        $likedProduct = $this->createProduct([
            'name' => 'いいね商品',
        ]);
        $notLikedProduct = $this->createProduct([
            'name' => '未いいね商品',
        ]);

        $this->likeProduct($user, $likedProduct);

        $guestResponse = $this->get('/');
        $guestResponse->assertStatus(200);

        $guestMylistSection = $this->mylistSection($guestResponse->getContent());
        $this->assertStringNotContainsString('いいね商品', $guestMylistSection);
        $this->assertStringNotContainsString('未いいね商品', $guestMylistSection);
    }

    public function test_ログイン時はいいね商品のみ表示される()
    {
        $user = $this->createUser();

        $likedProduct = $this->createProduct([
            'name' => 'いいね商品',
        ]);
        $notLikedProduct = $this->createProduct([
            'name' => '未いいね商品',
        ]);

        $this->likeProduct($user, $likedProduct);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);

        $mylistSection = $this->mylistSection($response->getContent());
        $this->assertStringContainsString('いいね商品', $mylistSection);
        $this->assertStringNotContainsString('未いいね商品', $mylistSection);
    }

    public function test_購入済み商品にはSOLDが表示される()
    {
        $user = $this->createUser();

        $soldProduct = $this->createProduct([
            'name' => '購入済み商品',
        ]);

        $this->likeProduct($user, $soldProduct);
        $this->createPurchase($user, $soldProduct);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);

        $mylistSection = $this->mylistSection($response->getContent());
        $this->assertStringContainsString('購入済み商品', $mylistSection);
        $this->assertStringContainsString('Sold', $mylistSection);
    }

}
