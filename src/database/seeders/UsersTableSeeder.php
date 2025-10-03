<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '山田 太郎',
            'email' => 'test@example.com',
            'password' => Hash::make('coachtech1106')
        ];
        DB::table('users')->insert($param);
    }
}
