<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BCALevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('b_c_a_levels')->insert([
            'name' => 'Level A',
        ]);
        DB::table('b_c_a_levels')->insert([
            'name' => 'Level B',
        ]);
    }
}
