<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BCAAlgoChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('b_c_a_algo_charts')->insert([
            'text' => 'Excellent',
            'image' => 'abc.png',
            'level_id' => 2,
            'activities' => 1,
        ]);
        DB::table('b_c_a_algo_charts')->insert([
            'text' => 'Very Good',
            'image' => 'abc.png',
            'level_id' => 2,
            'activities' => 2,
        ]);
        DB::table('b_c_a_algo_charts')->insert([
            'text' => 'Good',
            'image' => 'abc.png',
            'level_id' => 1,
            'activities' => 3,
        ]);
        DB::table('b_c_a_algo_charts')->insert([
            'text' => 'No Activity',
            'image' => 'No Activity',
            'level_id' => 1,
            'activities' => 4,
        ]);        
    }
}
