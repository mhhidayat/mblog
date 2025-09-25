<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Welcome to M-Blog',
                'slug' => 'welcome-to-m-blog',
                'excerpt' => 'This is the first post on our new blog platform built with Laravel and Livewire.',
                'content' => 'Welcome to M-Blog! This is our brand new blog platform built with the latest technologies including Laravel 12, Livewire 3, and Tailwind CSS. We\'re excited to share amazing content with you.

This platform features real-time search, responsive design, and a clean, modern interface. Our goal is to provide you with high-quality content about web development, programming best practices, and the latest technology trends.

Stay tuned for more exciting posts as we explore the world of modern web development together!',
                'published' => true,
                'published_at' => now()->subDays(2),
                'featured_image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'title' => 'Getting Started with Laravel Livewire',
                'slug' => 'getting-started-with-laravel-livewire',
                'excerpt' => 'Learn the basics of Laravel Livewire and how it can transform your web development workflow.',
                'content' => 'Laravel Livewire is a full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.

With Livewire, you can build modern, reactive, dynamic interfaces using server-side rendering. No need to write JavaScript for basic interactions! This revolutionary approach allows developers to create interactive web applications using only PHP.

Livewire handles the complexity of managing state, validation, and real-time updates seamlessly. Whether you\'re building forms, dashboards, or interactive components, Livewire provides an elegant solution that feels natural to Laravel developers.

The framework excels at real-time validation, file uploads, pagination, search functionality, and much more. It\'s perfect for developers who want to build modern web applications without the complexity of a separate frontend framework.',
                'published' => true,
                'published_at' => now()->subDays(1),
                'featured_image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'title' => 'Building Beautiful UIs with Tailwind CSS',
                'slug' => 'building-beautiful-uis-with-tailwind-css',
                'excerpt' => 'Discover how Tailwind CSS can help you create stunning user interfaces quickly and efficiently.',
                'content' => 'Tailwind CSS is a utility-first CSS framework that provides low-level utility classes to build custom designs directly in your markup.

Unlike traditional CSS frameworks that provide pre-built components, Tailwind gives you the building blocks to create your own unique designs. This approach offers unprecedented flexibility while maintaining consistency across your application.

The framework promotes rapid development through its comprehensive set of utility classes. You can style elements directly in your HTML without writing custom CSS, leading to faster development cycles and easier maintenance.

Tailwind\'s mobile-first approach ensures your designs work perfectly across all devices. The framework also includes built-in design tokens for spacing, colors, typography, and more, helping you maintain a consistent design system throughout your project.',
                'published' => true,
                'published_at' => now()->subHours(12),
                'featured_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'title' => 'The Future of Web Development',
                'slug' => 'the-future-of-web-development',
                'excerpt' => 'Exploring upcoming trends and technologies that will shape the future of web development.',
                'content' => 'Web development is constantly evolving, and staying up-to-date with the latest trends is crucial for developers who want to remain competitive in this fast-paced industry.

Server-side rendering is making a strong comeback as developers realize the benefits of improved SEO and faster initial page loads. This shift represents a move away from purely client-side applications toward more balanced architectures.

Progressive Web Apps continue to gain traction, offering native app-like experiences through web technologies. These applications provide offline functionality, push notifications, and improved performance while maintaining the accessibility of web applications.

Artificial intelligence and machine learning integration are becoming increasingly common in web applications. From chatbots to personalized content recommendations, AI is transforming how users interact with web platforms.

The future looks bright for web developers who embrace these new technologies and methodologies while maintaining focus on user experience and performance.',
                'published' => true,
                'published_at' => now()->subHours(6),
                'featured_image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
            ],
            [
                'title' => 'Best Practices for Modern PHP Development',
                'slug' => 'best-practices-for-modern-php-development',
                'excerpt' => 'Learn essential best practices that every PHP developer should follow in 2025.',
                'content' => 'PHP has evolved significantly since its early days, and modern PHP development follows strict standards and best practices that ensure code quality, security, and maintainability.

Using the latest PHP versions is crucial for accessing new features, performance improvements, and security updates. PHP 8.3 and newer versions offer powerful features like union types, attributes, and improved error handling that make code more robust and expressive.

Following PSR (PHP Standards Recommendations) ensures your code is consistent and interoperable with other PHP projects. These standards cover everything from coding style to autoloading and HTTP message interfaces.

Proper error handling and logging are essential for maintaining production applications. Implementing comprehensive exception handling and using structured logging helps identify and resolve issues quickly.

Dependency injection and the use of containers promote loose coupling and make your code more testable and maintainable. Modern PHP frameworks like Laravel make dependency injection straightforward and powerful.

Writing comprehensive tests, including unit tests and integration tests, ensures your code works as expected and makes refactoring safer. Tools like PHPUnit provide excellent testing capabilities for PHP applications.',
                'published' => true,
                'published_at' => now()->subHours(3),
                'featured_image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'
            ],
        ];

        foreach ($posts as $postData) {
            \App\Models\Post::create($postData);
        }
    }
}
