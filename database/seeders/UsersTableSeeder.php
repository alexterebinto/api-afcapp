<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' =>'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' =>'1',
        ]);
    }
}
