<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\PostSecondaryCategory;
use App\Models\Category;
use Illuminate\Database\Seeder;

class PostSecondaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $posts = Post::all();
        $categories = Category::all();

        foreach ($posts as $post) {

            $secondaryCategories = $categories
                ->where('id', '!=', $post->category_id)
                ->random(rand(0, 2));

            foreach ($secondaryCategories as $category) {
                PostSecondaryCategory::create([
                    'post_id' => $post->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
