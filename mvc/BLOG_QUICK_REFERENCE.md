# 🚀 Blog Commands Quick Reference

## Common Commands

### Setup & Database
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migrate (WARNING: deletes data)
php artisan migrate:fresh

# Seed database
php artisan db:seed

# Seed only blog
php artisan db:seed --class=BlogSeeder

# Fresh migrate with seed
php artisan migrate:fresh --seed

# Check database
php artisan tinker
>>> Post::all();
>>> User::all();
>>> Comment::all();
```

### Development
```bash
# Start dev server
php artisan serve

# Clear all cache
php artisan cache:clear

# Clear routes
php artisan route:cache

# Clear config
php artisan config:cache

# View routes
php artisan route:list

# Tinker shell
php artisan tinker
```

### File Management
```bash
# Create symbolic link for storage
php artisan storage:link

# Fix storage permissions
chmod -R 775 storage bootstrap/cache

# Clear storage
rm -rf storage/app/public/posts/*
```

### Testing
```bash
# Run tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ExampleTest.php

# Generate test file
php artisan make:test BlogTest
```

---

## Model Quick Reference

### Post Model
```php
// Find post
Post::find(1);
Post::where('slug', 'my-post')->first();

// Get published posts
Post::published()->get();

// Get draft posts
Post::draft()->get();

// With relationships
Post::with('author', 'comments')->get();

// Create post
Post::create([
    'user_id' => 1,
    'title' => 'My Post',
    'slug' => 'my-post-123',
    'content' => 'Content here',
    'status' => 'published',
    'published_at' => now(),
]);

// Update post
$post->update(['status' => 'archived']);

// Delete post
$post->delete();

// Relationships
$post->author;
$post->comments;
$post->approvedComments;
```

### Comment Model
```php
// Find comment
Comment::find(1);

// Get approved comments
Comment::approved()->get();

// Create comment
Comment::create([
    'post_id' => 1,
    'user_id' => 1,
    'content' => 'Great post!',
    'status' => 'approved',
]);

// Relationships
$comment->post;
$comment->user;
```

### User Model
```php
// Find user
User::find(1);
User::where('email', 'user@example.com')->first();

// User's posts
$user->posts;

// Create user
User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password'),
]);
```

---

## Blade Template Snippets

### Check Authentication
```blade
@auth
  <p>Welcome, {{ auth()->user()->name }}</p>
@endauth

@guest
  <p>Please log in</p>
@endguest
```

### Loop Posts
```blade
@foreach($posts as $post)
  <div>
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->content }}</p>
  </div>
@endforeach
```

### Show Errors
```blade
@if ($errors->any())
  <div>
    @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
    @endforeach
  </div>
@endif
```

### CSRF Protection
```blade
<form method="POST" action="">
  @csrf
  <!-- form fields -->
</form>
```

### Image Display
```blade
<img src="{{ asset('storage/' . $post->featured_image) }}" alt="">
```

---

## Routes Cheat Sheet

### Generate URLs
```php
// To route
route('blog.index');           // /blog
route('blog.show', $post->slug);  // /blog/slug-123
route('blog.create');          // /blog/create
route('blog.edit', $post);     // /blog/1/edit

// To URL
url('/blog');
url('/blog/' . $post->slug);
```

### Link Helpers
```blade
<a href="{{ route('blog.index') }}">Blog</a>
<a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
<form action="{{ route('blog.store') }}" method="POST">
```

---

## HTTP Methods

| Method | Meaning | Example |
|--------|---------|---------|
| GET | Retrieve resource | View post |
| POST | Create resource | Create post |
| PUT | Update resource | Update post |
| DELETE | Delete resource | Delete post |
| PATCH | Partial update | Update one field |

---

## Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Success |
| 201 | Created - Resource created |
| 302 | Found - Redirect |
| 400 | Bad Request - Invalid data |
| 401 | Unauthorized - Auth required |
| 403 | Forbidden - Not allowed |
| 404 | Not Found - Resource doesn't exist |
| 422 | Unprocessable - Validation failed |
| 500 | Server Error |

---

## Validation Rules

```php
// Create/Update Post
[
    'title' => 'required|string|max:255',
    'content' => 'required|string',
    'excerpt' => 'nullable|string|max:500',
    'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'status' => 'required|in:draft,published,archived',
]

// Add Comment
[
    'content' => 'required|string|min:5|max:5000',
    'name' => 'required_if:user_id,null|string|max:255',
    'email' => 'required_if:user_id,null|email|max:255',
]
```

---

## Environment Variables (.env)

```bash
APP_NAME="Blog"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

---

## Useful Artisan Commands

```bash
# Generate class
php artisan make:model Post
php artisan make:migration create_posts_table
php artisan make:controller BlogController
php artisan make:seeder BlogSeeder
php artisan make:policy PostPolicy

# Generate resource
php artisan make:model Post -m  # with migration
php artisan make:model Post -c  # with controller
php artisan make:model Post -mcr # all together

# List available routes
php artisan route:list
php artisan route:list | grep blog

# Clear everything
php artisan optimize:clear
```

---

## SQL Queries (Debugging)

```php
// Enable query logging
\DB::enableQueryLog();

// Get queries
\DB::getQueryLog();

// Raw query
DB::statement('SELECT * FROM posts WHERE status = ?', ['published']);

// Raw select
DB::select('SELECT * FROM posts WHERE status = ?', ['published']);
```

---

## Testing Queries in Tinker

```bash
php artisan tinker

# List all posts
>>> Post::all()

# Count posts
>>> Post::count()

# Get published posts
>>> Post::where('status', 'published')->get()

# Find specific post
>>> Post::find(1)

# Get user's posts
>>> User::find(1)->posts

# Create test post
>>> Post::create(['user_id' => 1, 'title' => 'Test', 'slug' => 'test-' . time(), 'content' => 'Test content', 'status' => 'published', 'published_at' => now()])

# Update post
>>> $post = Post::find(1); $post->update(['title' => 'New Title'])

# Delete post
>>> Post::find(1)->delete()

# Exit tinker
>>> exit()
```

---

## Git Commands

```bash
# Initialize git
git init

# Add files
git add .

# Commit
git commit -m "Add blog system"

# Create branch
git checkout -b feature/blog

# Merge branch
git checkout main
git merge feature/blog

# View status
git status

# View log
git log --oneline
```

---

## Useful Links

- [Laravel Docs](https://laravel.com/docs)
- [Blade Docs](https://laravel.com/docs/blade)
- [Eloquent Docs](https://laravel.com/docs/eloquent)
- [Tailwind CSS](https://tailwindcss.com)
- [Composer Packages](https://packagist.org)
- [Laracasts](https://laracasts.com)

---

## Debug Tips

```php
// Print and dump
dd($variable);           // Die and dump
dump($variable);         // Print
var_dump($variable);     // PHP var dump

// Log
\Log::info('Message', ['context' => $data]);
\Log::error('Error message');

// Log file location
storage/logs/laravel.log

// Check log
tail -f storage/logs/laravel.log
```

---

## Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| 404 errors | Run `php artisan migrate` |
| CSRF errors | Clear cache with `php artisan cache:clear` |
| Auth issues | Check `.env` database config |
| Storage issues | Run `php artisan storage:link` |
| View not found | Check file path and blade syntax |
| Database errors | Verify `.env` credentials |
| Page blank | Check `storage/logs/laravel.log` |

---

**Keep this handy while developing! 📝**
