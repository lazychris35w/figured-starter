<?php

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
            'name' => 'Admin',
            'email' => 'admin@testing.com',
            'password' => bcrypt('admin'),
            'role' => '2',
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@testing.com',
            'password' => bcrypt('secret'),
            'role' => '1',
        ]);
    }
}
