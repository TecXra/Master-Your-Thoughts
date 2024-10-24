<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class VideoApiSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('video_api_settings')->insert([
            'type' => 'vimeo',
            'client_id' => 'ab80fd97b6f85cac59b523976dcfd4554d0fb10d',
            'client_secret' => 'WmFHFKwyDUHRvcR7HEZc0R64hZATJcw1cI1S3wznw8LRn5VuQB2Llf7xT9s9SF5p8wTyVq8g4ONW3Y+alU3H/YRu9qifGGRqvvA14NsBt3ljg5SSNaCgT2diwhUFoH3E',
            'personal_access_token' => '58d9e28b55262a08f780086dd0d48f1f',
        ]);
    }
}
