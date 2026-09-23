<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            Media::factory()
                ->count(rand(2, 5))
                ->create([
                    'user_id' => $user->id,
                ]);
        }
    }
}
