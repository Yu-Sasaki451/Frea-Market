<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditionIds = DB::table('conditions')->pluck('id', 'name');

        DB::table('products')->insert([
            [
                'condition_id' => $conditionIds['良好'],
                'name' => '腕時計',
                'image' => 'public/image/watch.jpg',
                'brand' => 'Rolax',
                'price' => '15000',
                'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            ],
            [
                'condition_id' => $conditionIds['目立った傷や汚れなし'],
                'name' => 'HDD',
                'image' => 'public/image/hdd.jpg',
                'brand' => '西芝',
                'price' => '5000',
                'detail' => '高速で信頼性の高いハードディスク',
            ],
            [
                'condition_id' => $conditionIds['やや傷や汚れあり'],
                'name' => '玉ねぎ3束',
                'image' => 'public/image/onion.jpg',
                'brand' => 'なし',
                'price' => '300',
                'detail' => '新鮮な玉ねぎ3束のセット',
            ],
            [
                'condition_id' => $conditionIds['状態が悪い'],
                'name' => '革靴',
                'image' => 'public/image/shoes.jpg',
                'brand' => '',
                'price' => '4000',
                'detail' => 'クラシックなデザインの革靴',
            ],
            [
                'condition_id' => $conditionIds['良好'],
                'name' => 'ノートPC',
                'image' => 'public/image/note_pc.jpg',
                'brand' => '',
                'price' => '45000',
                'detail' => '高性能なノートパソコン',
            ],
            [
                'condition_id' => $conditionIds['目立った傷や汚れなし'],
                'name' => 'マイク',
                'image' => 'public/image/mic.jpg',
                'brand' => 'なし',
                'price' => '8000',
                'detail' => '高音質のレコーディング用マイク',
            ],
            [
                'condition_id' => $conditionIds['やや傷や汚れあり'],
                'name' => 'ショルダーバッグ',
                'image' => 'public/image/bag.jpg',
                'brand' => '',
                'price' => '3500',
                'detail' => 'おしゃれなショルダーバッグ',
            ],
            [
                'condition_id' => $conditionIds['状態が悪い'],
                'name' => 'タンブラ-',
                'image' => 'public/image/tumbler.jpg',
                'brand' => 'なし',
                'price' => '500',
                'detail' => '使いやすいタンブラー',
            ],
            [
                'condition_id' => $conditionIds['良好'],
                'name' => 'コーヒーミル',
                'image' => 'public/image/coffee_mill.jpg',
                'brand' => 'Starbacks',
                'price' => '4000',
                'detail' => '手動のコーヒーミル',
            ],
            [
                'condition_id' => $conditionIds['目立った傷や汚れなし'],
                'name' => 'メイクセット',
                'image' => 'public/image/make_set.jpg',
                'brand' => '',
                'price' => '2500',
                'detail' => '便利なメイクアップセット',
            ],
        ]);
    }
}
