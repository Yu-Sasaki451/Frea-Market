<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * トップ画面のマイリストタブ領域抽出
     */
    protected function mylistSection(string $content): string
    {
        $this->assertStringContainsString('id="panel-mylist"', $content);

        return Str::after($content, 'id="panel-mylist"');
    }

    /**
     * マイページの出品タブ領域抽出
     */
    protected function sellSection(string $content): string
    {
        $this->assertStringContainsString('id="panel-sell"', $content);

        return Str::after($content, 'id="panel-sell"');
    }

    /**
     * マイページの購入タブ領域抽出
     */
    protected function purchaseSection(string $content): string
    {
        $this->assertStringContainsString('id="panel-purchase"', $content);

        return Str::after($content, 'id="panel-purchase"');
    }

    /**
     * ログイン系テストで使う固定ユーザーを作成
     */
    protected function makeUser(array $overrides = []): User
    {
        $data = array_merge([
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ], $overrides);

        return User::create($data);
    }

    /**
     * User Factoryでユーザーを作成
     */
    protected function createUser(array $overrides = []): User
    {
        return User::factory()->create($overrides);
    }

    /**
     * プロフィールを作成
     */
    protected function createProfile(User $user, array $overrides = []): Profile
    {
        $data = array_merge([
            'user_id' => $user->id,
            'name' => 'テストネーム',
            'image' => 'profiles/default-test.png',
            'post_code' => '123-4567',
            'address' => '東京都港区1-2-3',
            'building' => 'テストビル101',
        ], $overrides);

        return Profile::create($data);
    }

    /**
     * ユーザー作成とプロフィール作成をまとめてやる
     */
    protected function createUserWithProfile(array $userOverrides = [], array $profileOverrides = []): User
    {
        $user = $this->createUser($userOverrides);
        $this->createProfile($user, $profileOverrides);

        return $user;
    }

    /**
     * Product Factoryで商品作成
     */
    protected function createProduct(array $overrides = []): Product
    {
        return Product::factory()->create($overrides);
    }

    /**
     * 購入レコード作成
     */
    protected function createPurchase(User $user, Product $product, array $overrides = []): Purchase
    {
        $data = array_merge([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'payment' => 'card',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => null,
        ], $overrides);

        return Purchase::create($data);
    }

    /**
     * 購入POSTで使うリクエスト配列
     */
    protected function purchasePayload(Product $product, array $overrides = []): array
    {
        $data = array_merge([
            'name' => $product->name,
            'price' => $product->price,
            'post_code' => '123-4567',
            'address' => '東京都港区1-2-3',
            'building' => 'テストビル101',
            'payment' => 'card',
        ], $overrides);

        return $data;
    }

    /**
     * 指定ユーザーが指定商品へいいね
     */
    protected function likeProduct(User $user, Product $product): void
    {
        $user->likedProducts()->attach($product->id);
    }
}
