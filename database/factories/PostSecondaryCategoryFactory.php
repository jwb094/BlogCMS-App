<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostSecondaryCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostSecondaryCategory>
 */
class PostSecondaryCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
