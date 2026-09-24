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
        User::updateOrCreate([
            'name' => 'Admin User',
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate([
            'name' => 'Author User',
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => 'author@example.com',
            'password' => Hash::make('password'),
            'role' => 'author',
            'email_verified_at' => now(),
            'instagram' => fake()->optional(0.7)->userName(),
            'facebook' => fake()->optional(0.7)->userName(),
            'linkedin' => fake()->optional(0.7)->userName(),
            'twitter' => fake()->optional(0.7)->userName(),
            'bio' => fake()->optional(0.8)->paragraph(3),
        ]);

        User::factory()
            ->count(8)
            ->create([
                'role' => 'author',
            ]);
    }
}
