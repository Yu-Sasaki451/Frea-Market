<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function base(): array{

        return [
            'email' => 'test@example.com',
            'password' => ('12345678'),
        ];
    }

    private function seedUser(): User{

        return User::create([
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
        ]);
    }

    public function test_メールアドレス未入力(){

        $this->seedUser();

        $data = $this->base();
        $data['email'] = '';

        $this->from('/login')
        ->post('/login',$data)
        ->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_パスワード未入力(){

        $this->seedUser();

        $data = $this->base();
        $data['password'] = '';

        $this->from('/login')
        ->post('/login',$data)
        ->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_メールアドレス不一致(){

        $this->seedUser();

        $data = $this->base();
        $data['email'] = 'test@exam.com';

        $this->from('/login')
        ->post('/login',$data)
        //->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
        ->assertSessionHasErrors(['email']);

    }

    public function test_パスワード不一致(){

        $this->seedUser();

        $data = $this->base();
        $data['password'] = '12345689';

        $this->from('/login')
        ->post('/login',$data)
        //->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
        ->assertSessionHasErrors(['email']);

    }

    public function test_ログイン成功()
    {
        $user = $this->seedUser();

        $data = $this->base();

        $this->post('/login', $data)
            ->assertRedirect(route('index'));

        $this->assertAuthenticatedAs($user);
    }
}
