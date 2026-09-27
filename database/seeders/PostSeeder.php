<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    // Post::factory()
    //         ->count(50)
    //         ->create();
      $users = User::where('role', 'author')->get();
        $categories = Category::all();
        $media = Media::all();

           Post::factory()
            ->count(20)
            ->make()
            ->each(function (Post $post) use ($users, $categories, $media) {

                $post->user_id = $users->random()->id;
                $post->category_id = $categories->random()->id;

                $featuredImage = $media->random();

                $post->featured_image = $featuredImage->path;

                $post->save();
            });
    }
}
