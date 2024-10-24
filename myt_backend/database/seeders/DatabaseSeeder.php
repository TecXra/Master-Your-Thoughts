<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(UserSettingSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(VideoApiSettingSeeder::class);
        $this->call(MytResponsesSeeder::class);
        $this->call(LoopingDurationsSeeder::class);
        $this->call(UserThemeSettingSeeder::class);
        $this->call(TimeZoneTableSeeder::class);
        $this->call(BCALevelSeeder::class);
        $this->call(BCAAlgoChartSeeder::class);
        $this->call(BCAAlgoActivitySeeder::class);
    }
}
