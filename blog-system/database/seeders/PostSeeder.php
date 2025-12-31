<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@blog.com')->first();
        $categories = Category::all();

        $posts = [
            [
                'title' => 'Getting Started with Laravel 10',
                'slug' => 'getting-started-with-laravel-10',
                'excerpt' => 'Learn the basics of Laravel 10 and build your first application.',
                'content' => 'Laravel 10 is the latest version of the popular PHP framework. In this comprehensive guide, we will explore the new features and improvements that make Laravel 10 the best choice for modern web development. From the new artisan commands to the improved performance, Laravel 10 brings exciting new possibilities for developers.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'views' => 150,
            ],
            [
                'title' => 'Building RESTful APIs with Laravel',
                'slug' => 'building-restful-apis-with-laravel',
                'excerpt' => 'A complete guide to creating RESTful APIs using Laravel and JWT authentication.',
                'content' => 'RESTful APIs are the backbone of modern web applications. Laravel provides powerful tools for building robust APIs that can handle complex business logic. In this article, we will explore how to create a complete API system with authentication, validation, and error handling.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'views' => 230,
            ],
            [
                'title' => 'Modern Web Design Trends for 2024',
                'slug' => 'modern-web-design-trends-2024',
                'excerpt' => 'Discover the latest design trends that will dominate the web in 2024.',
                'content' => 'Web design is constantly evolving, and staying updated with the latest trends is crucial for creating engaging user experiences. From minimalist designs to bold typography, we will explore the design trends that will shape the web in 2024.',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views' => 180,
            ],
            [
                'title' => 'Database Optimization Techniques',
                'slug' => 'database-optimization-techniques',
                'excerpt' => 'Learn how to optimize your database queries for better performance.',
                'content' => 'Database performance is critical for application success. This article covers essential optimization techniques including indexing strategies, query optimization, and caching mechanisms that can dramatically improve your application speed.',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'views' => 95,
            ],
            [
                'title' => 'The Future of Web Development',
                'slug' => 'future-of-web-development',
                'excerpt' => 'Exploring emerging technologies and trends in web development.',
                'content' => 'Web development is rapidly evolving with new technologies like WebAssembly, Progressive Web Apps, and AI integration. This article explores what the future holds for web developers and how to prepare for upcoming changes.',
                'status' => 'draft',
                'views' => 0,
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create(array_merge($postData, [
                'user_id' => $admin->id,
            ]));

            // Attach random categories to each post
            $post->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')
            );
        }
    }
}
