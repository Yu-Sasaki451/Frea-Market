<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_プロフィール変更ページ開く(){

        $user = $this->createUserWithProfile();

        $response = $this->actingAs($user)->get("/mypage/profile");
        $response->assertStatus(200);
        $response->assertSee('テストネーム');
        $response->assertSee('default-test.png');
        $response->assertSee('123-4567');
        $response->assertSee('東京都港区1-2-3');
        $response->assertSee('テストビル101');
    }
}
