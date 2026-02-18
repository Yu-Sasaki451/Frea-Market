<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function base(): array{

        return [
            'email' => 'test@example.com',
            'password' => ('12345678'),
        ];
    }

    public function test_メールアドレス未入力(){

        $this->makeUser();

        $data = $this->base();
        $data['email'] = '';

        $this->from('/login')
        ->post('/login',$data)
        ->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_パスワード未入力(){

        $this->makeUser();

        $data = $this->base();
        $data['password'] = '';

        $this->from('/login')
        ->post('/login',$data)
        ->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_メールアドレス不一致(){

        $this->makeUser();

        $data = $this->base();
        $data['email'] = 'test@exam.com';

        $response = $this->from('/login')
            ->post('/login',$data);
        $response->assertSessionHasErrors(['email']);
        $this->assertStringContainsString(
            'ログイン情報が登録されていません',
            session('errors')->first('email')
        );

    }

    public function test_パスワード不一致(){

        $this->makeUser();

        $data = $this->base();
        $data['password'] = '12345689';

        $response = $this->from('/login')
            ->post('/login',$data);
        $response->assertSessionHasErrors(['email']);
        $this->assertStringContainsString(
            'ログイン情報が登録されていません',
            session('errors')->first('email')
        );

    }

    public function test_ログイン成功()
    {
        $user = $this->makeUser();

        $data = $this->base();

        $this->post('/login', $data)
            ->assertRedirect(route('index'));

        $this->assertAuthenticatedAs($user);
    }

}
