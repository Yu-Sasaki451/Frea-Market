<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_検索後にいいねしてマイリストでも保持()
    {
        $user = $this->createUser();

        $matchProduct = $this->createProduct(['name' => '青いシャツ']);
        $notMatchProduct = $this->createProduct(['name' => '赤い帽子']);

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
