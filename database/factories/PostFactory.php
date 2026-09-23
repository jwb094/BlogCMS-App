<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'slug'  => Str::slug($title . '-' . fake()->unique()->numberBetween(100, 999)),
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

            'featured_image' => fake()->imageUrl(
                1200,
                800,
                'blog'
            ),

            'featured_image_caption' => fake()->sentence(10),
            'content' => collect(range(1, fake()->numberBetween(5, 8)))
                ->map(function ($index) {
                    return match (fake()->numberBetween(1, 5)) {
                        1 => '<p>' . fake()->paragraph(5) . '</p>',

                        2 => '<h2>' . fake()->sentence(5) . '</h2>',

                        3 => '<p>' . fake()->paragraph(5) . '</p>'
                            . '<p>' . fake()->paragraph(5) . '</p>',

                        4 => '<ul>'
                            . collect(fake()->sentences(3))
                            ->map(fn($item) => '<li>' . $item . '</li>')
                            ->implode('')
                            . '</ul>',

                        5 => '<blockquote>' . fake()->sentence(15) . '</blockquote>',
                    };
                })
                ->implode("\n"),
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
