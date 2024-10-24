<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_settings')->insert([
            'slide_show_default_view' => config('MYT.default_view.slide_show'),
            'slide_show_interval' => 5,
            'user_id' => 1
        ]);
    }
}
