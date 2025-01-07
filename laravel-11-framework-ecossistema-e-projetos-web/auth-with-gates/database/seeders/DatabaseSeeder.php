<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
            'permissions' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => bcrypt('123456'),
            'role' => 'guest',
            'permissions' => 'guest'
        ]);
    }
}
