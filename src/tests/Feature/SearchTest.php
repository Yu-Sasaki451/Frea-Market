<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_検索後にいいねしてマイリストでも保持()
    {
        $user = User::factory()->create();

        $matchProduct = Product::factory()->create(['name' => '青いシャツ']);
        $notMatchProduct = Product::factory()->create(['name' => '赤い帽子']);

        $this->actingAs($user);

        $response = $this->get('/?keyword=シャツ');

        $response->assertStatus(200);
        $response->assertSee('value="シャツ"', false);
        $response->assertSee($matchProduct->name);
        $response->assertDontSee($notMatchProduct->name);

        $this->post("/item/{$matchProduct->id}");

        $response = $this->get('/?keyword=シャツ');

        $response->assertStatus(200);
        $response->assertSee('value="シャツ"', false);

        $mylistSection = $this->mylistSection($response->getContent());
        $this->assertStringContainsString($matchProduct->name, $mylistSection);
        $this->assertStringNotContainsString($notMatchProduct->name, $mylistSection);
    }
}
