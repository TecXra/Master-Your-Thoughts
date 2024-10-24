<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserThemeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_theme_settings')->insert([
            'font_family' => 1,
            'navbar_style' => config('MYT.navbar_style.transparent'),
            'navbar_color'=> null,
            'sidebar_color' => 'golden',
            'default_theme' => config('MYT.default_theme.light'),
            'user_id' => 1
        ]);

        // DB::table('user_theme_settings')->insert([
        //     'font_family' => 1,
        //     'navbar_style' => config('MYT.navbar_style.transparent'),
        //     'navbar_color'=> null,
        //     'sidebar_color' => 'golden',
        //     'default_theme' => config('MYT.default_theme.light'),
        //     'user_id' => 2
        // ]);
    }
}
