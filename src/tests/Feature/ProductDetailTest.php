<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_商品詳細ページ表示()
    {
        $seller = $this->createUser();
        $likedUserA = $this->createUser();
        $likedUserB = $this->createUser();
        $commentUser = $this->createUser([
            'name' => 'コメント太郎',
        ]);

        $this->createProfile($commentUser, [
            'image' => 'profiles/comment-user.png',
        ]);

        $condition = Condition::create([
            'name' => '良好',
        ]);

        $categoryA = Category::create([
            'name' => 'メンズ',
        ]);
        $categoryB = Category::create([
            'name' => 'トップス',
        ]);

        $product = $this->createProduct([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'name' => 'テストTシャツ',
            'image' => 'products/detail-product.jpg',
            'brand' => 'テストブランド',
            'price' => 12000,
            'description' => '詳細表示テスト用の商品説明です。',
        ]);

        $product->categories()->attach([$categoryA->id, $categoryB->id]);

        $likedUserA->likedProducts()->attach($product->id);
        $likedUserB->likedProducts()->attach($product->id);

        Comment::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'content' => 'コメント本文の表示テストです。',
        ]);

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('storage/products/detail-product.jpg', false);
        $response->assertSeeText('テストTシャツ');
        $response->assertSeeText('テストブランド');
        $response->assertSeeText('12,000');
        $response->assertSee('<span class="count">2</span>', false);
        $response->assertSee('<span class="count">1</span>', false);
        $response->assertSeeText('詳細表示テスト用の商品説明です。');
        $response->assertSeeText('良好');
        $response->assertSeeText('メンズ');
        $response->assertSeeText('トップス');
        $response->assertSeeText('コメント(1)');
        $response->assertSee('storage/profiles/comment-user.png', false);
        $response->assertSeeText('コメント太郎');
        $response->assertSeeText('コメント本文の表示テストです。');
    }

    public function test_出品時に選択した複数カテゴリが商品詳細ページに表示される()
    {
        Storage::fake('public');

        $seller = $this->createUserWithProfile();
        $condition = Condition::create(['name' => '良好']);
        $categoryA = Category::create(['name' => 'アウター']);
        $categoryB = Category::create(['name' => 'レディース']);

        $sellResponse = $this->actingAs($seller)->post('/sell', [
            'condition_id' => $condition->id,
            'name' => 'カテゴリ反映商品',
            'image' => UploadedFile::fake()->create('detail.jpg', 100, 'image/jpeg'),
            'brand' => 'カテゴリ反映ブランド',
            'price' => 7000,
            'description' => 'カテゴリ反映テスト用の説明',
            'categories' => [$categoryA->id, $categoryB->id],
        ]);
        $sellResponse->assertRedirect('/');

        $product = Product::where('user_id', $seller->id)
            ->where('name', 'カテゴリ反映商品')
            ->firstOrFail();

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);
        $response->assertSeeText('アウター');
        $response->assertSeeText('レディース');
    }
}
