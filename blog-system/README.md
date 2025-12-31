# Farouk's Blog System

A complete Laravel blog system with admin dashboard and JWT APIs for mobile applications.

## 🌟 Features

### **Web Application**
- **Beautiful Blog Interface** - Modern, responsive design with Tailwind CSS
- **Admin Dashboard** - Complete blog management system
- **Post Management** - Create, edit, delete blog posts
- **Category System** - Organize posts by categories
- **Comment System** - User engagement with comments
- **Authentication** - Secure admin login/logout

### **Mobile APIs**
- **JWT Authentication** - Secure API access for mobile apps
- **Blog Endpoints** - Fetch posts, categories, comments
- **CRUD Operations** - Full post and comment management
- **Search Functionality** - Find posts by title or content

## 🚀 Quick Start

### **Prerequisites**
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Laravel 10

### **Installation**
```bash
git clone <repository-url>
cd blog-system
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### **Admin Credentials**
- **Email**: `farouk.ahmad@blogsystem.com`
- **Password**: `password`

### **Access URLs**
- **Blog**: `http://localhost:8000`
- **Admin**: `http://localhost:8000/admin`
- **API**: `http://localhost:8000/api`

## 📱 API Endpoints

### **Public Blog APIs**
```
GET    /api/blog/posts              # All published posts
GET    /api/blog/posts/{slug}       # Single post by slug
GET    /api/blog/posts/{slug}/comments # Post comments
POST   /api/blog/posts/{slug}/comments # Submit comment
GET    /api/blog/categories          # All categories
GET    /api/blog/categories/{category} # Posts by category
GET    /api/blog/search             # Search posts
```

### **Admin APIs (JWT Protected)**
```
GET    /api/admin/posts             # Manage posts
POST   /api/admin/posts             # Create post
PUT    /api/admin/posts/{post}      # Update post
DELETE /api/admin/posts/{post}      # Delete post
```

## 🎨 Project Structure

```
blog-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BlogController.php
│   │   │   ├── AuthController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       └── PostController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Post.php
│       ├── Comment.php
│       └── Category.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── blog/
│       │   ├── home.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           └── posts/
│               └── create.blade.php
└── routes/
    ├── web.php
    └── api.php
```

## 🔧 Technologies Used

- **Backend**: Laravel 10, PHP 8.1+
- **Database**: MySQL with Eloquent ORM
- **Authentication**: JWT (tymon/jwt-auth)
- **Frontend**: Tailwind CSS, Blade Templates
- **Icons**: Font Awesome 6
- **API**: RESTful with JSON responses

## 📝 Features Implemented

### **Blog Features**
- ✅ Post creation with rich text editor
- ✅ Category management
- ✅ Comment system with approval
- ✅ Search functionality
- ✅ Responsive design
- ✅ SEO-friendly URLs (slugs)
- ✅ Soft deletes for posts and comments

### **Admin Features**
- ✅ Beautiful dashboard with statistics
- ✅ Post management (CRUD)
- ✅ Quick actions sidebar
- ✅ Recent activity tracking
- ✅ Role-based access control

### **API Features**
- ✅ JWT authentication
- ✅ Public blog endpoints
- ✅ Admin-protected endpoints
- ✅ Pagination support
- ✅ Error handling

## 🎯 University Assignment

This project was developed as a university assignment demonstrating:
- **Full-stack Laravel development**
- **RESTful API design**
- **Database relationships and migrations**
- **Authentication and authorization**
- **Modern frontend development**
- **Mobile API integration**

## 👤 Author

**Created by Farouk Ahmad**

A complete blog system showcasing modern web development skills with Laravel framework.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
