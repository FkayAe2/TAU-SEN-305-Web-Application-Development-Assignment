# Laravel Blog System

A fully functional blog application with admin panel and RESTful APIs built with Laravel 10.

## Features

### Frontend Features
- **Blog Display**: Show published posts with categories and comments
- **Search**: Search posts by title, content, and excerpt
- **Categories**: Filter posts by categories
- **Comments**: Nested comment system with approval workflow
- **Responsive Design**: Mobile-friendly UI using Tailwind CSS

### Admin Features
- **Admin Dashboard**: Overview of blog statistics and recent activity
- **Post Management**: Create, edit, publish, archive, and delete posts
- **Comment Management**: Approve, reject, and moderate comments
- **Category Management**: Create and organize blog categories
- **User Management**: Manage users and admin roles
- **Role-based Access**: Admin-only access to management features

### API Features
- **RESTful APIs**: Complete CRUD operations for all entities
- **Authentication**: Token-based authentication using Laravel Sanctum
- **Admin APIs**: Protected endpoints for admin operations
- **Public APIs**: Public endpoints for blog content
- **Validation**: Comprehensive input validation and error handling

## Database Structure

### Tables
- **users**: User accounts with role-based access (admin/user)
- **posts**: Blog posts with status management (draft/published/archived)
- **categories**: Blog categories with color coding
- **comments**: Nested comments with approval workflow
- **post_category**: Many-to-many relationship between posts and categories

### Relationships
- User has many Posts and Comments
- Post belongs to User and has many Categories
- Category has many Posts
- Comment belongs to Post and User, with self-referencing for replies

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd blog-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - Set up your database in `.env` file
   - Configure `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

5. **Run migrations and seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## Demo Accounts

After running the seeders, you can use these accounts:

### Admin Account
- **Email**: admin@blog.com
- **Password**: password
- **Access**: Full admin dashboard and API access

### User Account
- **Email**: user@blog.com
- **Password**: password
- **Access**: Basic user access

## API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `POST /api/register` - User registration
- `GET /api/user` - Get current user

### Public Blog APIs
- `GET /api/blog/posts` - Get all published posts
- `GET /api/blog/posts/{post}` - Get single post
- `GET /api/blog/posts/{post}/comments` - Get post comments
- `POST /api/blog/posts/{post}/comments` - Create comment
- `GET /api/blog/categories` - Get all categories
- `GET /api/blog/categories/{category}` - Get category posts
- `GET /api/blog/popular-posts` - Get popular posts
- `GET /api/blog/recent-posts` - Get recent posts
- `GET /api/blog/search` - Search posts

### Admin APIs (Protected)
All admin endpoints require authentication and admin role.

#### Posts Management
- `GET /api/admin/posts` - List all posts
- `POST /api/admin/posts` - Create post
- `GET /api/admin/posts/{post}` - Get post details
- `PUT /api/admin/posts/{post}` - Update post
- `DELETE /api/admin/posts/{post}` - Delete post
- `PATCH /api/admin/posts/{post}/publish` - Publish post
- `PATCH /api/admin/posts/{post}/archive` - Archive post

#### Comments Management
- `GET /api/admin/comments` - List all comments
- `POST /api/admin/comments` - Create comment
- `GET /api/admin/comments/{comment}` - Get comment details
- `PUT /api/admin/comments/{comment}` - Update comment
- `DELETE /api/admin/comments/{comment}` - Delete comment
- `PATCH /api/admin/comments/{comment}/approve` - Approve comment
- `PATCH /api/admin/comments/{comment}/reject` - Reject comment
- `GET /api/admin/comments/pending` - Get pending comments
- `POST /api/admin/comments/bulk-approve` - Bulk approve comments
- `POST /api/admin/comments/bulk-reject` - Bulk reject comments
- `POST /api/admin/comments/bulk-delete` - Bulk delete comments

#### Categories Management
- `GET /api/admin/categories` - List all categories
- `POST /api/admin/categories` - Create category
- `GET /api/admin/categories/{category}` - Get category details
- `PUT /api/admin/categories/{category}` - Update category
- `DELETE /api/admin/categories/{category}` - Delete category
- `PATCH /api/admin/categories/{category}/activate` - Activate category
- `PATCH /api/admin/categories/{category}/deactivate` - Deactivate category
- `GET /api/admin/categories/active` - Get active categories

#### Users Management
- `GET /api/admin/users` - List all users
- `POST /api/admin/users` - Create user
- `GET /api/admin/users/{user}` - Get user details
- `PUT /api/admin/users/{user}` - Update user
- `DELETE /api/admin/users/{user}` - Delete user
- `PATCH /api/admin/users/{user}/make-admin` - Promote to admin
- `PATCH /api/admin/users/{user}/remove-admin` - Remove admin role
- `GET /api/admin/users/admins` - Get admin users
- `GET /api/admin/users/regular` - Get regular users

## Web Routes

### Public Routes
- `/` - Home page with recent posts
- `/blog` - Blog listing page
- `/blog/{post}` - Single post view
- `/category/{category}` - Category posts
- `/search` - Search results
- `/login` - Login page

### Admin Routes (Protected)
- `/admin` - Admin dashboard
- `/dashboard` - Admin dashboard (alternative)

## API Usage Examples

### Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@blog.com", "password": "password"}'
```

### Create Post (Admin)
```bash
curl -X POST http://localhost:8000/api/admin/posts \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "title": "My New Post",
    "content": "This is the content of my post",
    "excerpt": "Brief description",
    "status": "published",
    "category_ids": [1, 2]
  }'
```

### Get Posts
```bash
curl http://localhost:8000/api/blog/posts
```

## Security Features

- **Authentication**: Laravel Sanctum for API authentication
- **Authorization**: Role-based access control
- **Validation**: Comprehensive input validation
- **CSRF Protection**: Web routes protected by CSRF tokens
- **SQL Injection Prevention**: Eloquent ORM prevents SQL injection
- **XSS Protection**: Blade templates auto-escape output

## Technologies Used

- **Backend**: Laravel 10, PHP 8.1+
- **Database**: MySQL/MariaDB
- **Frontend**: Blade templates, Tailwind CSS
- **Authentication**: Laravel Sanctum
- **API**: RESTful JSON APIs

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
php artisan pint
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## License

This project is open-sourced software licensed under the MIT license.
