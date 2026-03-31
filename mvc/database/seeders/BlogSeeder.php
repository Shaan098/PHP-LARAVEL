<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample tags
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'description' => 'Laravel framework posts'],
            ['name' => 'PHP', 'slug' => 'php', 'description' => 'PHP programming posts'],
            ['name' => 'Web Development', 'slug' => 'web-development', 'description' => 'Web development tips and tricks'],
            ['name' => 'Database', 'slug' => 'database', 'description' => 'Database design and optimization'],
            ['name' => 'Tutorial', 'slug' => 'tutorial', 'description' => 'Step-by-step tutorials'],
            ['name' => 'Tips & Tricks', 'slug' => 'tips-tricks', 'description' => 'Helpful tips and tricks'],
            ['name' => 'API', 'slug' => 'api', 'description' => 'API development posts'],
            ['name' => 'Testing', 'slug' => 'testing', 'description' => 'Software testing posts'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }

        // Create a test user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'blogger@example.com'],
            [
                'name' => 'John Blogger',
                'password' => bcrypt('password123'),
            ]
        );

        // Create sample blog posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'excerpt' => 'Learn the basics of Laravel framework and start building amazing web applications.',
                'content' => 'Laravel is a powerful PHP framework that makes web development enjoyable and productive. With its elegant syntax and powerful features, you can build robust applications in no time. In this post, we\'ll explore the basics of Laravel and get you started on your journey.
                
Key Topics:
- Installation and setup
- Project structure
- Routing basics
- Controllers and views
- Database migrations
- Eloquent ORM',
                'status' => 'published',
            ],
            [
                'title' => 'Building a RESTful API with Laravel',
                'excerpt' => 'Create a scalable and maintainable REST API using Laravel and best practices.',
                'content' => 'RESTful APIs are the backbone of modern web applications. Learn how to build a robust and scalable API using Laravel\'s built-in features. We\'ll cover resource controllers, authentication, and best practices for API design.
                
Topics Covered:
- API structure and organization
- Resource controllers
- Authentication with Laravel Sanctum
- Rate limiting
- Testing your API
- Documentation',
                'status' => 'published',
            ],
            [
                'title' => 'Database Design Best Practices',
                'excerpt' => 'Tips and tricks for designing efficient and scalable database schemas.',
                'content' => 'Good database design is crucial for application performance and maintainability. This post explores best practices for designing efficient schemas, choosing the right data types, and optimizing queries.
                
Key Points:
- Normalization vs denormalization
- Indexing strategies
- Foreign key constraints
- Query optimization
- Migration management
- Backup and recovery',
                'status' => 'published',
            ],
            [
                'title' => 'Advanced Laravel Features',
                'excerpt' => 'Explore advanced features that will take your Laravel skills to the next level.',
                'content' => 'Once you\'re comfortable with Laravel basics, it\'s time to explore advanced features. Learn about service containers, service providers, facades, and more.
                
Topics:
- Service Container
- Service Providers
- Facades
- Middleware
- Events and Listeners
- Job Queues',
                'status' => 'draft',
            ],
        ];

        foreach ($posts as $postData) {
            $postData['slug'] = Str::slug($postData['title']) . '-' . uniqid();
            $postData['user_id'] = $user->id;
            
            if ($postData['status'] === 'published') {
                $postData['published_at'] = now()->subDays(rand(1, 30));
            }

            $post = Post::create($postData);

            // Add sample comments to published posts
            if ($post->status === 'published') {
                Comment::create([
                    'post_id' => $post->id,
                    'name' => 'Jane Doe',
                    'email' => 'jane@example.com',
                    'content' => 'Great post! I learned a lot from this.',
                    'status' => 'approved',
                ]);

                Comment::create([
                    'post_id' => $post->id,
                    'name' => 'John Smith',
                    'email' => 'john@example.com',
                    'content' => 'Very helpful! Can you do a follow-up post on this topic?',
                    'status' => 'approved',
                ]);
            }
        }
    }
}
