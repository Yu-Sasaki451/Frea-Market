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

    protected function mylistSection(string $content): string
    {
        $this->assertStringContainsString('id="panel-mylist"', $content);

        return Str::after($content, 'id="panel-mylist"');
    }

    protected function makeUser(array $overrides = []): User
    {
        $data = array_merge([
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
        ], $overrides);

        return User::create($data);
    }

    protected function createUser(array $overrides = []): User
    {
        return User::factory()->create($overrides);
    }

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

    protected function createUserWithProfile(array $userOverrides = [], array $profileOverrides = []): User
    {
        $user = $this->createUser($userOverrides);
        $this->createProfile($user, $profileOverrides);

        return $user;
    }

    protected function createProduct(array $overrides = []): Product
    {
        return Product::factory()->create($overrides);
    }

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

    protected function likeProduct(User $user, Product $product): void
    {
        $user->likedProducts()->attach($product->id);
    }
}
