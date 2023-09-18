<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecordContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 20件のデータを生成します
        for ($i = 1; $i <= 20; $i++) {
            $data = [
                'user_id' => 1,
                'category_id' => 1,
                'menu_id' => 1,
                'record_state_id' =>rand(1, 10),
                // 'weight' => rand(20,100),
                // バッチ処理テスト用
                'weight' => null,
                'right_weight' => null,
                'left_weight' => null,
                'set' => rand(1, 4),
                'rep' => rand(5, 9),
                'memo' => 'Sample Memo ' . $i, // メモの例
                'created_at' => now(),
                'updated_at' => null,
            ];

            DB::table('record_contents')->insert($data);
        }
    }
}
