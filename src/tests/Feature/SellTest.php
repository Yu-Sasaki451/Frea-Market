<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SellTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_商品の出品、情報保存()
    {
        Storage::fake('public');

        $user = $this->createUserWithProfile();
        $condition = Condition::factory()->create();
        $category1 = Category::create(['name' => 'カテゴリA']);
        $category2 = Category::create(['name' => 'カテゴリB']);

        $response = $this->actingAs($user)->post('/sell', [
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト説明文',
            'categories' => [$category1->id, $category2->id],
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'テスト説明文',
        ]);

        $product = Product::where('user_id', $user->id)
            ->where('name', 'テスト商品')
            ->firstOrFail();

        Storage::disk('public')->assertExists($product->image);

        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category1->id,
        ]);
        $this->assertDatabaseHas('product_categories', [
            'product_id' => $product->id,
            'category_id' => $category2->id,
        ]);
    }
}
