<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Author User',
            'email' => 'author@example.com',
            'password' => Hash::make('password'),
            'role' => 'author',
            'email_verified_at' => now(),
        ]);

        User::factory()
            ->count(8)
            ->create([
                'role' => 'author',
            ]);
    }
}
