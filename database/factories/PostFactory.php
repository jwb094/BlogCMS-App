<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => fake()->unique()->slug(),
            'subheading' => fake()->sentence(10),
            'excerpt' => fake()->paragraph(),

            'status' => fake()->randomElement([
                'draft',
                'live',
                'scheduled',
            ]),

            'allow_comments' => fake()->boolean(80)
                ? 'allow'
                : 'forbidden',

            'featured_image' => fake()->optional()->imageUrl(
                1200,
                800,
                'blog'
            ),

            'featured_image_caption' => fake()->optional()->sentence(10),
            'content' => fake()->paragraphs(10, true),
            'meta_title' => $title,
            'meta_description' => fake()->sentence(20),
            'user_id' => User::query()->inRandomOrder()->value('id'),
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'published_at' => fake()->optional()->dateTimeBetween(
                '-2 year',
                'now'
            ),
            'deleted_at' => null,
        ];
    }
}
