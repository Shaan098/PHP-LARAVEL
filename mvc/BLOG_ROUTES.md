# Blog Routes & API Reference

## Public Routes (No Authentication Required)

### List All Blog Posts
- **Endpoint:** `GET /blog`
- **Route Name:** `blog.index`
- **Description:** Display paginated list of published blog posts
- **Returns:** View with posts collection
- **Example:** `http://localhost:8000/blog`

### View Single Post
- **Endpoint:** `GET /blog/{slug}`
- **Route Name:** `blog.show`
- **Description:** Display a published blog post with comments
- **Parameters:**
  - `slug` (string): URL-friendly post identifier
- **Returns:** View with post details and comments
- **Example:** `http://localhost:8000/blog/getting-started-with-laravel-60d1a2f3`

### Submit Comment on Post
- **Endpoint:** `POST /blog/{post}/comments`
- **Route Name:** `blog.comments.store`
- **Description:** Add a new comment to a blog post
- **Authentication:** Optional (guest or authenticated user)
- **Parameters:**
  - `post` (integer): Post ID
  - `name` (string): Commenter name (required if not authenticated)
  - `email` (string): Commenter email (required if not authenticated)
  - `content` (string): Comment text (required, 5-5000 characters)
- **Returns:** Redirect to post with success message
- **Example:**
```bash
curl -X POST http://localhost:8000/blog/1/comments \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "content": "Great post! Very helpful."
  }'
```

---

## Protected Routes (Authentication Required)

### Create Post Form
- **Endpoint:** `GET /blog/create`
- **Route Name:** `blog.create`
- **Description:** Display form to create new blog post
- **Authentication:** Required ✅
- **Returns:** View with create form
- **Example:** `http://localhost:8000/blog/create`

### Store New Post
- **Endpoint:** `POST /blog`
- **Route Name:** `blog.store`
- **Description:** Save new blog post to database
- **Authentication:** Required ✅
- **Parameters:**
  - `title` (string): Post title (required, max 255 characters)
  - `content` (string): Post content (required)
  - `excerpt` (string): Short summary (optional, max 500 characters)
  - `featured_image` (file): Cover image (optional, max 2MB, types: jpeg/png/jpg/gif)
  - `status` (string): Status - 'draft' or 'published' (required)
- **Returns:** Redirect to post with success message
- **Example:**
```bash
curl -X POST http://localhost:8000/blog \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "title=My First Post" \
  -F "content=This is my first blog post" \
  -F "status=published"
```

### Edit Post Form
- **Endpoint:** `GET /blog/{post}/edit`
- **Route Name:** `blog.edit`
- **Description:** Display form to edit existing post
- **Authentication:** Required ✅
- **Authorization:** Must be post author
- **Parameters:**
  - `post` (integer): Post ID or Post model instance
- **Returns:** View with edit form
- **Example:** `http://localhost:8000/blog/1/edit`

### Update Post
- **Endpoint:** `PUT /blog/{post}`
- **Route Name:** `blog.update`
- **Description:** Save changes to existing blog post
- **Authentication:** Required ✅
- **Authorization:** Must be post author
- **Parameters:**
  - `post` (integer): Post ID
  - `title` (string): Post title (required, max 255 characters)
  - `content` (string): Post content (required)
  - `excerpt` (string): Short summary (optional, max 500 characters)
  - `featured_image` (file): Cover image (optional, max 2MB)
  - `status` (string): Status - 'draft', 'published', or 'archived' (required)
- **Returns:** Redirect to post with success message
- **Example:**
```bash
curl -X PUT http://localhost:8000/blog/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d "title=Updated Title&content=Updated content&status=published"
```

### Delete Post
- **Endpoint:** `DELETE /blog/{post}`
- **Route Name:** `blog.destroy`
- **Description:** Delete a blog post
- **Authentication:** Required ✅
- **Authorization:** Must be post author
- **Parameters:**
  - `post` (integer): Post ID
- **Returns:** Redirect to blog index with success message
- **Example:**
```bash
curl -X DELETE http://localhost:8000/blog/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Response Examples

### Post Object
```json
{
  "id": 1,
  "user_id": 1,
  "title": "Getting Started with Laravel",
  "slug": "getting-started-with-laravel-60d1a2f3",
  "content": "Lorem ipsum dolor sit amet...",
  "excerpt": "Learn the basics of Laravel framework",
  "featured_image": "posts/image.jpg",
  "status": "published",
  "published_at": "2024-01-15 10:30:00",
  "created_at": "2024-01-15 10:30:00",
  "updated_at": "2024-01-15 10:30:00",
  "author": {
    "id": 1,
    "name": "John Blogger",
    "email": "john@example.com"
  }
}
```

### Comment Object
```json
{
  "id": 1,
  "post_id": 1,
  "user_id": null,
  "name": "Jane Doe",
  "email": "jane@example.com",
  "content": "Great post! I learned a lot.",
  "status": "approved",
  "created_at": "2024-01-15 11:00:00",
  "updated_at": "2024-01-15 11:00:00"
}
```

---

## HTTP Status Codes

| Code | Meaning | Example |
|------|---------|---------|
| 200 | OK | Successfully retrieved post |
| 201 | Created | Post successfully created |
| 302 | Found | Redirect (after form submission) |
| 400 | Bad Request | Invalid input data |
| 401 | Unauthorized | Authentication required |
| 403 | Forbidden | Not authorized to perform action |
| 404 | Not Found | Post doesn't exist |
| 422 | Unprocessable Entity | Validation failed |
| 500 | Internal Server Error | Server error |

---

## Testing with cURL Examples

### Create a Blog Post
```bash
curl -X POST http://localhost:8000/blog \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "title=My Blog Post&content=This is my content&status=published"
```

### Get All Posts
```bash
curl http://localhost:8000/blog
```

### View Single Post
```bash
curl http://localhost:8000/blog/getting-started-with-laravel-60d1a2f3
```

### Add Comment
```bash
curl -X POST http://localhost:8000/blog/1/comments \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "name=Guest User&email=guest@example.com&content=Great post!"
```

### Update Post
```bash
curl -X PUT http://localhost:8000/blog/1 \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "title=Updated Title&content=Updated content&status=published"
```

### Delete Post
```bash
curl -X DELETE http://localhost:8000/blog/1 \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN"
```

---

## Validation Rules

### Create/Update Post
```php
[
    'title' => 'required|string|max:255',
    'content' => 'required|string',
    'excerpt' => 'nullable|string|max:500',
    'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'status' => 'required|in:draft,published,archived',
]
```

### Add Comment
```php
[
    'name' => 'required_if:user_id,null|string|max:255',
    'email' => 'required_if:user_id,null|email|max:255',
    'content' => 'required|string|min:5|max:5000',
]
```

---

## Query Parameters

### Blog Index (Pagination)
```
GET /blog?page=1
GET /blog?page=2
```

The blog posts are paginated with 10 posts per page.

---

## Headers Required

All POST, PUT, DELETE requests require:
- `X-CSRF-TOKEN`: CSRF token (automatically included in forms)
- `Content-Type`: application/x-www-form-urlencoded or application/json

Authentication can be passed via:
- Session cookies (for web requests)
- Bearer token (for API requests)

---

## Error Responses

### Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "content": ["The content field is required."]
  }
}
```

### Authorization Error
```json
{
  "message": "This action is unauthorized.",
  "status": 403
}
```

### Not Found Error
```json
{
  "message": "Post not found.",
  "status": 404
}
```
