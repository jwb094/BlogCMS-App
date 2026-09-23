<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'description' => 'Articles, tutorials, and insights about Laravel development.',
                'meta_description' => 'Articles, tutorials, and insights about Laravel development.',
                'meta_title' => 'Laravel | Blog',
            ],

            [
                'name' => 'PHP',
                'slug' => 'php',
                'description' => 'Articles, tutorials, and development insights about PHP.',
                'meta_description' => 'Articles, tutorials, and development insights about PHP.',
                'meta_title' => 'PHP | Blog',
            ],

            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                'description' => 'Articles covering JavaScript development, techniques, and modern web applications.',
                'meta_description' => 'Articles covering JavaScript development, techniques, and modern web applications.',
                'meta_title' => 'JavaScript | Blog',
            ],

            [
                'name' => 'React',
                'slug' => 'react',
                'description' => 'Articles and tutorials about React development and frontend applications.',
                'meta_description' => 'Articles and tutorials about React development and frontend applications.',
                'meta_title' => 'React | Blog',
            ],

            [
                'name' => 'Python',
                'slug' => 'python',
                'description' => 'Python programming tutorials, development practices, and useful techniques.',
                'meta_description' => 'Python programming tutorials, development practices, and useful techniques.',
                'meta_title' => 'Python | Blog',
            ],

            [
                'name' => 'MySQL',
                'slug' => 'mysql',
                'description' => 'Articles covering MySQL databases, SQL queries, and database development.',
                'meta_description' => 'Articles covering MySQL databases, SQL queries, and database development.',
                'meta_title' => 'MySQL | Blog',
            ],

            [
                'name' => 'APIs',
                'slug' => 'apis',
                'description' => 'Articles about APIs, REST APIs, integration, and backend development.',
                'meta_description' => 'Articles about APIs, REST APIs, integration, and backend development.',
                'meta_title' => 'APIs | Blog',
            ],

            [
                'name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'description' => 'Articles exploring artificial intelligence, applications, and emerging technologies.',
                'meta_description' => 'Articles exploring artificial intelligence, applications, and emerging technologies.',
                'meta_title' => 'Artificial Intelligence | Blog',
            ],

            [
                'name' => 'Machine Learning',
                'slug' => 'machine-learning',
                'description' => 'Articles about machine learning concepts, applications, and developments.',
                'meta_description' => 'Articles about machine learning concepts, applications, and developments.',
                'meta_title' => 'Machine Learning | Blog',
            ],

            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'description' => 'Articles about cybersecurity, online safety, threats, and security practices.',
                'meta_description' => 'Articles about cybersecurity, online safety, threats, and security practices.',
                'meta_title' => 'Cybersecurity | Blog',
            ],

            [
                'name' => 'Cloud Computing',
                'slug' => 'cloud-computing',
                'description' => 'Articles covering cloud platforms, infrastructure, services, and development.',
                'meta_description' => 'Articles covering cloud platforms, infrastructure, services, and development.',
                'meta_title' => 'Cloud Computing | Blog',
            ],

            [
                'name' => 'Productivity',
                'slug' => 'productivity',
                'description' => 'Tips and ideas for improving productivity, organisation, and efficiency.',
                'meta_description' => 'Tips and ideas for improving productivity, organisation, and efficiency.',
                'meta_title' => 'Productivity | Blog',
            ],

            [
                'name' => 'Career',
                'slug' => 'career',
                'description' => 'Career advice, professional development, job searching, and workplace insights.',
                'meta_description' => 'Career advice, professional development, job searching, and workplace insights.',
                'meta_title' => 'Career | Blog',
            ],

            [
                'name' => 'Remote Work',
                'slug' => 'remote-work',
                'description' => 'Articles about remote working, distributed teams, and modern work practices.',
                'meta_description' => 'Articles about remote working, distributed teams, and modern work practices.',
                'meta_title' => 'Remote Work | Blog',
            ],

            [
                'name' => 'Startups',
                'slug' => 'startups',
                'description' => 'Articles covering startups, startup culture, growth, and entrepreneurship.',
                'meta_description' => 'Articles covering startups, startup culture, growth, and entrepreneurship.',
                'meta_title' => 'Startups | Blog',
            ],

            [
                'name' => 'Entrepreneurship',
                'slug' => 'entrepreneurship',
                'description' => 'Entrepreneurship advice, business ideas, and insights for business owners.',
                'meta_description' => 'Entrepreneurship advice, business ideas, and insights for business owners.',
                'meta_title' => 'Entrepreneurship | Blog',
            ],

            [
                'name' => 'Investing',
                'slug' => 'investing',
                'description' => 'Articles about investing, markets, financial planning, and investment concepts.',
                'meta_description' => 'Articles about investing, markets, financial planning, and investment concepts.',
                'meta_title' => 'Investing | Blog',
            ],

            [
                'name' => 'Personal Finance',
                'slug' => 'personal-finance',
                'description' => 'Personal finance advice covering budgeting, saving, money management, and financial planning.',
                'meta_description' => 'Personal finance advice covering budgeting, saving, money management, and financial planning.',
                'meta_title' => 'Personal Finance | Blog',
            ],

            [
                'name' => 'Fitness',
                'slug' => 'fitness',
                'description' => 'Articles about fitness, exercise, training, and maintaining an active lifestyle.',
                'meta_description' => 'Articles about fitness, exercise, training, and maintaining an active lifestyle.',
                'meta_title' => 'Fitness | Blog',
            ],

            [
                'name' => 'Nutrition',
                'slug' => 'nutrition',
                'description' => 'Articles about nutrition, healthy eating, food, and dietary habits.',
                'meta_description' => 'Articles about nutrition, healthy eating, food, and dietary habits.',
                'meta_title' => 'Nutrition | Blog',
            ],
        ];

        Tag::insert($tags);
    }
}
