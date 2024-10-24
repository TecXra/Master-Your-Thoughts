<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BCAAlgoActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'LearnDash Lectures',
            'level_id' => 2,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'LearnDash Exercises',
            'level_id' => 2,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'Daily Video Review',
            'level_id' => 1,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'Practice Check',
            'level_id' => 1,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'Points of Faith & Fuel',
            'level_id' => 1,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'Max-relaxation',
            'level_id' => 2,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'Banking',
            'level_id' => 2,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'Vision Chart',
            'level_id' => 2,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'The Harmonizer',
            'level_id' => 2,
        ]);
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'The Visualizer',
            'level_id' => 2,
        ]);                                
        DB::table('b_c_a_algo_activities')->insert([
            'name' => 'The Attraction Wall',
            'level_id' => 2,
        ]);
    }
}
