<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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

            for ($i = 1; $i <= 3; $i++) {

                // Generate a unique filename
                $filename = fake()->uuid() . '.jpg';

                // Download image
                $image = Http::get(
                    'https://picsum.photos/1200/800'
                );

                // Make sure the download was successful
                if ($image->successful()) {

                    // Store the image
                    Storage::disk('public')->put(
                        'media/' . $filename,
                        $image->body()
                    );

                    // Create database record
                    Media::create([
                        'filename' => $filename,
                        'path' => 'media/' . $filename,
                        'mime_type' => 'image/jpeg',
                        'file_size' => strlen($image->body()),
                        'width' => 1200,
                        'height' => 800,
                        'user_id' => $user->id,
                    ]);
                }
            }
        }
    }
}
