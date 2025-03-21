<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@tecxra.com',
            'user_type' => config('MYT.user_type.admin'),
            'password' => Hash::make('12345678'),
        ]);
    }
}
