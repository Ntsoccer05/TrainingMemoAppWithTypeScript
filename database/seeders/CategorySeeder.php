<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params =[
            [
                'user_id' => 1,
                'content' => '胸',
            ],
            [
                'user_id' => 1,
                'content' => '背中',
            ],
            [
                'user_id' => 1,
                'content' => '足',
            ],
            [
                'user_id' => 1,
                'content' => '腕',
            ],
        ];

        foreach($params as $param){
            DB::table('categories')->insert($param);
        }
    }
}
