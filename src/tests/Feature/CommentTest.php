<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;


class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ログイン済みコメント送信(){

        $user = $this->createUser();
        $product = $this->createProduct();

        $this->actingAs($user);
        $beforeCount = Comment::count();

        $response = $this->post(route('comment.store',$product->id),
        [
            'content' => 'テストコメント',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('product_comments',
        [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'content' => 'テストコメント'
        ]);

        $this->assertSame($beforeCount + 1, Comment::count());
    }

    public function test_未ログインでコメントしてもできない(){

        $product = $this->createProduct();

        $beforeCount = Comment::count();

        $response = $this->post(route('comment.store',$product->id),[
            'content' => 'テストコメント'
        ]);

        $response->assertRedirect(route('login.form'));

        $this->assertSame($beforeCount, Comment::count());

        $this->assertDatabaseMissing('product_comments', [
            'product_id' => $product->id,
            'content' => 'テストコメント'
        ]);
    }

    public function test_コメント未入力(){
        $user = $this->createUser();
        $product = $this->createProduct();

        $response = $this->actingAs($user)->post(route('comment.store',$product->id),[
            'content' => '']);

        $response->assertSessionHasErrors(['content']);

        $this->assertDatabaseMissing('product_comments', [
            'product_id' => $product->id,
            'content' => '',
        ]);

    }

    public function test_文字数255文字以上(){
        $user = $this->createUser();
        $product = $this->createProduct();
        $comment = str_repeat('a',256);

        $response = $this->actingAs($user)->post(route('comment.store',$product->id),[
            'content' => $comment]);

        $response->assertSessionHasErrors(['content']);

        $this->assertDatabaseMissing('product_comments', [
            'product_id' => $product->id,
            'content' => $comment,
        ]);

    }
}
