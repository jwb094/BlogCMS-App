<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Articles about technology, software, digital innovation, and the latest developments in the tech world.',
                'meta_description' => 'Articles about technology, software, digital innovation, and the latest developments in the tech world.',
                'meta_title' => 'Technology | Blog',
            ],

            [
                'name' => 'Programming',
                'slug' => 'programming',
                'description' => 'Programming tutorials, development practices, coding techniques, and software development insights.',
                'meta_description' => 'Programming tutorials, development practices, coding techniques, and software development insights.',
                'meta_title' => 'Programming | Blog',
            ],

            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Articles covering web development, frontend, backend, frameworks, APIs, and modern web technologies.',
                'meta_description' => 'Articles covering web development, frontend, backend, frameworks, APIs, and modern web technologies.',
                'meta_title' => 'Web Development | Blog',
            ],

            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Business insights, entrepreneurship, startups, management, and trends shaping modern businesses.',
                'meta_description' => 'Business insights, entrepreneurship, startups, management, and trends shaping modern businesses.',
                'meta_title' => 'Business | Blog',
            ],

            [
                'name' => 'Finance',
                'slug' => 'finance',
                'description' => 'Articles covering personal finance, investing, economics, money management, and financial trends.',
                'meta_description' => 'Articles covering personal finance, investing, economics, money management, and financial trends.',
                'meta_title' => 'Finance | Blog',
            ],

            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Lifestyle articles covering everyday life, habits, experiences, personal development, and wellbeing.',
                'meta_description' => 'Lifestyle articles covering everyday life, habits, experiences, personal development, and wellbeing.',
                'meta_title' => 'Lifestyle | Blog',
            ],

            [
                'name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Travel guides, destinations, travel experiences, tips, and inspiration for your next journey.',
                'meta_description' => 'Travel guides, destinations, travel experiences, tips, and inspiration for your next journey.',
                'meta_title' => 'Travel | Blog',
            ],

            [
                'name' => 'Food',
                'slug' => 'food',
                'description' => 'Recipes, cooking advice, food culture, restaurant experiences, and culinary inspiration.',
                'meta_description' => 'Recipes, cooking advice, food culture, restaurant experiences, and culinary inspiration.',
                'meta_title' => 'Food | Blog',
            ],

            [
                'name' => 'Health & Fitness',
                'slug' => 'health-fitness',
                'description' => 'Articles about fitness, exercise, healthy habits, nutrition, and maintaining an active lifestyle.',
                'meta_description' => 'Articles about fitness, exercise, healthy habits, nutrition, and maintaining an active lifestyle.',
                'meta_title' => 'Health & Fitness | Blog',
            ],

            [
                'name' => 'Entertainment',
                'slug' => 'entertainment',
                'description' => 'News and commentary about movies, television, music, books, gaming, and popular culture.',
                'meta_description' => 'News and commentary about movies, television, music, books, gaming, and popular culture.',
                'meta_title' => 'Entertainment | Blog',
            ],

            [
                'name' => 'Science',
                'slug' => 'science',
                'description' => 'Articles exploring science, research, discoveries, technology, and our understanding of the world.',
                'meta_description' => 'Articles exploring science, research, discoveries, technology, and our understanding of the world.',
                'meta_title' => 'Science | Blog',
            ],

            [
                'name' => 'News',
                'slug' => 'news',
                'description' => 'News, current events, analysis, and stories covering important developments around the world.',
                'meta_description' => 'News, current events, analysis, and stories covering important developments around the world.',
                'meta_title' => 'News | Blog',
            ],

            [
                'name' => 'Opinion',
                'slug' => 'opinion',
                'description' => 'Opinion pieces, commentary, perspectives, and personal viewpoints on current topics and issues.',
                'meta_description' => 'Opinion pieces, commentary, perspectives, and personal viewpoints on current topics and issues.',
                'meta_title' => 'Opinion | Blog',
            ],

            [
                'name' => 'Personal Development',
                'slug' => 'personal-development',
                'description' => 'Advice and ideas for personal growth, productivity, motivation, learning, and building better habits.',
                'meta_description' => 'Advice and ideas for personal growth, productivity, motivation, learning, and building better habits.',
                'meta_title' => 'Personal Development | Blog',
            ],

            [
                'name' => 'Culture',
                'slug' => 'culture',
                'description' => 'Articles exploring culture, society, history, communities, ideas, and changing social trends.',
                'meta_description' => 'Articles exploring culture, society, history, communities, ideas, and changing social trends.',
                'meta_title' => 'Culture | Blog',
            ],
        ];

        Category::insert($categories);
    }
}
