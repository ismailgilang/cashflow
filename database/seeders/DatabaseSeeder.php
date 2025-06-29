<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('1234567'), // atau Hash::make('1234567')
        ]);

        // Membuat admin
        User::factory()->create([
            'name' => 'Admin super',
            'email' => 'admins@gmail.com',
            'role' => 'super',
            'password' => bcrypt('1234567'), // atau Hash::make('1234567')
        ]);
    }
}
