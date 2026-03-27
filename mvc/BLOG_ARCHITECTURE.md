# Blog Website Architecture & Flow

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────┐
│                    BLOG WEBSITE                          │
├─────────────────────────────────────────────────────────┤
│                                                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐   │
│  │   Frontend   │  │  Controller  │  │   Database   │   │
│  │  (Blade      │  │ (Laravel     │  │  (MySQL/     │   │
│  │   Views)     │  │  Built-in)   │  │   SQLite)    │   │
│  └──────────────┘  └──────────────┘  └──────────────┘   │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

## 📊 Entity Relationship Diagram

```
┌─────────────────────────────────────────────────────────┐
│                                                           │
│         ┌──────────┐        ┌──────────┐               │
│         │  Users   │────1:N─│  Posts   │               │
│         └──────────┘        └──────────┘               │
│             ▲                    │                      │
│             │                    │                      │
│             │                    1:N                    │
│             │                    ▼                      │
│             │              ┌──────────┐                │
│             │              │Comments  │                │
│             └──────────────┘──────────┘                │
│                        (optional user)                  │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

## 🔄 User Journey

### Reader Journey
```
Start
  │
  ▼
Visit Blog (/blog)
  │
  ├─→ Browse Posts List
  │    │
  │    ▼
  │  Click Post
  │    │
  │    ▼
  │  View Post + Comments
  │    │
  │    ├─→ Read Comments
  │    │    │
  │    │    ▼
  │    └─→ Submit Comment
  │         (as Guest or User)
  │
  └─→ Back to Posts
```

### Author Journey (Authenticated User)
```
Login
  │
  ▼
Visit Blog (/blog)
  │
  ├─→ Click "Write Post"
  │    │
  │    ▼
  │  Fill Form (/blog/create)
  │    ├─ Title
  │    ├─ Content
  │    ├─ Excerpt
  │    ├─ Featured Image
  │    └─ Status (Draft/Publish)
  │    │
  │    ▼
  │  Submit
  │    │
  │    ▼
  │  View Post
  │    │
  │    ├─→ Edit Post (/blog/{id}/edit)
  │    │    │
  │    │    ▼
  │    │  Update Post
  │    │
  │    └─→ Delete Post
  │         │
  │         ▼
  │      Confirm & Delete
  │
  └─→ Back to Blog List
```

## 📁 Directory Structure

```
mvc/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── BlogController.php ✨
│   ├── Models/
│   │   ├── User.php (✏️ updated)
│   │   ├── Post.php ✨
│   │   └── Comment.php ✨
│   └── Policies/
│       └── PostPolicy.php ✨
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_posts_table.php ✨
│   │   └── ..._create_comments_table.php ✨
│   └── seeders/
│       ├── BlogSeeder.php ✨
│       └── DatabaseSeeder.php (✏️ updated)
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php ✨
│       └── blog/
│           ├── index.blade.php ✨
│           ├── show.blade.php ✨
│           ├── create.blade.php ✨
│           └── edit.blade.php ✨
│
├── bootstrap/
│   └── providers.php (✏️ updated)
│
├── routes/
│   └── web.php (✏️ updated)
│
└── Documentation (✨ new files)
    ├── BLOG_README.md
    ├── BLOG_ROUTES.md
    ├── BLOG_SETUP_CHECKLIST.md
    └── BLOG_IMPLEMENTATION_SUMMARY.md
```

## 🔄 Request Flow

### View Blog Posts (GET /blog)
```
Client Request
    │
    ▼
Router (routes/web.php)
    │
    ▼
BlogController@index
    │
    ├─ Query published posts
    ├─ Paginate (10 per page)
    └─ Return view with posts
    │
    ▼
blog/index.blade.php
    │
    ├─ Display post list
    ├─ Show author & date
    └─ Render navigation
    │
    ▼
Client (HTML Response)
```

### Create Blog Post (POST /blog)
```
Client Request (authenticated)
    │
    ▼
Router (routes/web.php)
    │
    ├─ Check Authentication
    │   (middleware 'auth')
    │
    ▼
BlogController@store
    │
    ├─ Validate Input
    ├─ Check Authorization
    │   (PostPolicy@create)
    ├─ Generate Slug
    ├─ Upload Image
    ├─ Create Post in DB
    │
    ▼
Redirect to Post
    │
    └─ Success Message
```

### View Single Post (GET /blog/{slug})
```
Client Request
    │
    ▼
Router
    │
    ▼
BlogController@show
    │
    ├─ Find post by slug
    ├─ Check if published
    ├─ Get approved comments
    │
    ▼
blog/show.blade.php
    │
    ├─ Display post content
    ├─ Show featured image
    ├─ List comments
    └─ Show comment form
    │
    ▼
Client (HTML Response)
```

## 🗄️ Database Query Examples

### Get All Published Posts
```php
Post::published()
    ->with('author')
    ->paginate(10);
```

### Get Single Post with Comments
```php
Post::where('slug', $slug)
    ->published()
    ->with('author', 'approvedComments')
    ->firstOrFail();
```

### Create Post
```php
Post::create([
    'user_id' => auth()->id(),
    'title' => $validated['title'],
    'slug' => Str::slug($title) . '-' . uniqid(),
    'content' => $validated['content'],
    'status' => 'published',
    'published_at' => now(),
]);
```

## 🔐 Authorization Flow

### Edit Post
```
Request to /blog/{id}/edit
    │
    ▼
Check Authentication
    ├─ If not authenticated
    │   └─ Redirect to login
    │
    ▼
Check Authorization (PostPolicy@update)
    ├─ Is current user the author?
    │   ├─ Yes → Allow
    │   └─ No → 403 Forbidden
    │
    ▼
Load Post
    │
    ▼
Show Edit Form
```

## 📱 Responsive Breakpoints

```
Mobile          Tablet          Desktop
┌────────┐     ┌─────────┐     ┌──────────────┐
│ Single │     │  Two    │     │  Three/Flex  │
│ Column │     │ Columns │     │   Layout     │
└────────┘     └─────────┘     └──────────────┘
< 768px        768px-1024px     > 1024px
```

## 🔃 State Management

### Post States
```
┌──────┐
│Draft │──────────┐
└──────┘          │
                  ▼
            ┌──────────┐
            │Published │
            └──────────┘
                  │
                  ▼
            ┌──────────┐
            │Archived  │
            └──────────┘
```

### Comment States
```
┌─────────┐      ┌──────────┐      ┌──────────┐
│ Pending │──→  │ Approved │      │ Rejected │
└─────────┘      └──────────┘      └──────────┘
  (needs                 │
   approval)         (visible)
```

## 🔄 File Upload Flow

```
User Uploads Image
        │
        ▼
Validate File
├─ Is image?
├─ Max 2MB?
└─ Allowed format?
        │
        ▼
Store File
├─ Path: storage/app/public/posts/
├─ Filename: randomized
└─ Return path
        │
        ▼
Save Path to Database
├─ featured_image column
└─ Store relative path
        │
        ▼
Display Image
└─ asset('storage/' . $post->featured_image)
```

## 📊 Data Flow

### Create Post Flow
```
HTML Form
    │
    ▼
POST /blog (CSRF protected)
    │
    ▼
BlogController@store
    │
    ├─ Validate Data
    ├─ Handle File Upload
    ├─ Generate Slug
    ├─ Set published_at
    │
    ▼
Model (Post::create)
    │
    ▼
Database (INSERT)
    │
    ▼
Redirect Response
```

## 🎯 Key Interactions

| Action | Endpoint | Method | Auth | View |
|--------|----------|--------|------|------|
| Browse Posts | /blog | GET | ❌ | index.blade.php |
| View Post | /blog/{slug} | GET | ❌ | show.blade.php |
| New Post Form | /blog/create | GET | ✅ | create.blade.php |
| Create Post | /blog | POST | ✅ | (redirect) |
| Edit Form | /blog/{id}/edit | GET | ✅ | edit.blade.php |
| Update Post | /blog/{id} | PUT | ✅ | (redirect) |
| Delete Post | /blog/{id} | DELETE | ✅ | (redirect) |
| Add Comment | /blog/{id}/comments | POST | ❌/✅ | (redirect) |

## 🛡️ Security Layers

```
Request
    │
    ├─→ [HTTPS/SSL] Transport Layer
    │
    ├─→ [CSRF Token] Form Protection
    │
    ├─→ [Authentication] User Verification
    │
    ├─→ [Authorization/Policies] Action Permission
    │
    ├─→ [Input Validation] Data Quality
    │
    ├─→ [Eloquent ORM] SQL Injection Prevention
    │
    └─→ [Mass Assignment] Protected Fields
```

## 📈 Performance Considerations

```
Optimization Layer
├─ Pagination (10 posts/page)
├─ Eager Loading (with relationships)
├─ Database Indexing (status, published_at, slug)
├─ Query Caching (config)
├─ Asset Minification (mix/vite)
└─ CDN for Static Assets (optional)
```

---

This architecture ensures a secure, scalable, and maintainable blog system!
