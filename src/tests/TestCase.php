<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use App\Models\User;
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
}
