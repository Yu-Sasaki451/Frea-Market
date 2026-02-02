<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Condition;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition():array
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => Condition::factory(),
            'name' => 'テスト商品',
            'image' => 'dummy.jpg',
            'brand' => null,
            'price' => 1000,
            'description' => 'テスト説明文',
        ];
    }
}
