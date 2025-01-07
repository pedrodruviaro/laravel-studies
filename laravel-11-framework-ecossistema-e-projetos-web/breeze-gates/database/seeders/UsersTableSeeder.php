<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@email.com',
                'password' => bcrypt('Aa123456'),
                'role' => 'admin'
            ],
            [
                'name' => 'Normal User',
                'email' => 'normal@email.com',
                'password' => bcrypt('Aa123456'),
                'role' => 'normal_user'
            ],
            [
                'name' => 'Visitor',
                'email' => 'visitor@email.com',
                'password' => bcrypt('Aa123456'),
                'role' => 'visitor'
            ]
        ];

        DB::table('users')->insert($users);
    }
}
