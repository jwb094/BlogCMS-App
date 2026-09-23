<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {

            Comment::factory()
                ->count(rand(0, 5))
                ->create([
                    'post_id' => $post->id,
                    'user_id' => fake()->boolean(70)
                    ? $users->random()->id
                    : null,
                ]);
        }
    }
}
