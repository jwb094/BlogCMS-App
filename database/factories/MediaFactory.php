<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      $filename = fake()->uuid() . '.jpg';

        return [
            'filename' => $filename,
            'path' => 'media/' . $filename,
            'mime_type' => 'image/jpeg',
            'file_size' => fake()->numberBetween(50_000, 5_000_000),
            'width' => fake()->numberBetween(800, 2400),
            'height' => fake()->numberBetween(600, 1600),
            'user_id' => User::factory(),
        ];
    }
}
