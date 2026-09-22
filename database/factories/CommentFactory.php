<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
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

            'user_id' => fake()->boolean(70)
                ? User::factory()
                : null,

            'name' => fake()->name(),
            'email' => fake()->safeEmail(),

            'content' => fake()->paragraph(),

            'status' => fake()->randomElement([
                'pending',
                'approved',
                'rejected',
            ]),
        ];
    }
}
