# 📝 BlogCMS-app

A Laravel blog content management system for publishing posts, managing categories, organizing tags, and moderating comments in a clean admin workflow.

This project is designed as a practical Laravel application for exploring content-driven web apps, user authentication, CMS administration, comment moderation, and relationship-based data modeling in a real-world publishing workflow.

---

## 📋 Table of Contents

* [About](#-about)
* [Features](#-features)
* [Technology Stack](#-technology-stack)
* [Application Structure](#-application-structure)
* [Database Structure](#-database-structure)
* [Authentication & Roles](#-authentication--roles)
* [Installation](#-installation)
* [Environment Configuration](#-environment-configuration)
* [Database Setup](#-database-setup)
* [Running the Application](#-running-the-application)
* [Project Architecture](#-project-architecture)
* [Validation](#-validation)
* [Security Considerations](#-security-considerations)
* [Future Improvements](#-future-improvements)
* [Learning Objectives](#-learning-objectives)
* [Project Status](#-project-status)

---

## 📖 About

BlogCMS-app is a Laravel-based content management system built to handle blog publishing and content organization. It includes a public-facing blog front end and an administrative backend where authors and admins can manage posts, categories, tags, comments, and media.

Users can:

* Browse published posts and blog categories
* View blog content by category or tag
* Search for content across the blog
* Submit comments on blog posts
* Register and sign in as authenticated users
* Manage blog posts from an admin dashboard
* Organize post categories and tags
* Moderate comments and manage media assets

The project is being used as a portfolio and learning application to build experience with Laravel MVC architecture, Eloquent relationships, CMS workflows, validation, and admin dashboard design.

---

## ✨ Features

### 👤 Authentication & User Access

* User registration and login
* Authenticated admin access
* Protected admin routes
* Email verification support
* Session-based authorization

### 📰 Blog Publishing

* Create, edit, and delete blog posts
* Publish and archive content
* Category and tag assignment
* Post metadata and content organization
* Content management from a dedicated dashboard

### 🗂️ Categories & Tags

* Create and manage categories
* Organize content with tags
* Browse posts by category or tag
* Support structured content discovery

### 💬 Comments & Interaction

* Post comments from public readers
* Moderation workflow for comments
* IP tracking and validation for submissions
* Support for comment status management

### 🖼️ Media Management

* Media index and view support
* Manage uploaded content assets
* Support content publishing workflows with media attachments

---

## 📸 Application Preview

The screenshots below show the public blog on desktop and mobile, along with the desktop content-management dashboard.

### Public Frontend

**Desktop — home page**
<p align="center">
  <img src="doc/images/Screenshot%202026-11-13%20at%2011.01.56.png" alt="BlogCMS public home page on desktop" width="760" />
</p>

**Mobile — home page and article**
<p align="center">
  <img src="doc/images/Screenshot%202026-11-13%20at%2010.57.21.png" alt="BlogCMS public home page on mobile" width="280" />
  <img src="doc/images/Screenshot%202026-11-13%20at%2010.57.41.png" alt="BlogCMS article page on mobile" width="280" />
</p>

### Backend Administration — Desktop

<p align="center">
  <img src="doc/images/Screenshot%202026-11-13%20at%2011.05.40.png" alt="BlogCMS admin dashboard on desktop" width="760" />
  <img src="doc/images/Screenshot%202026-11-13%20at%2011.05.54.png" alt="BlogCMS post management page on desktop" width="760" />
</p>

---

## 🛠️ Technology Stack

### Backend

* PHP
* Laravel
* Laravel Eloquent ORM
* SQLite

### Frontend

* Blade templates
* Tailwind CSS
* HTML5
* CSS3
* JavaScript

### Development Tools

* Composer
* npm
* Laravel Herd
* Vite

---

## 📁 Application Structure

The application follows Laravel's standard structure with custom controllers, models, services, and admin routes for the blog CMS.

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
│
├── Models/
│   ├── User.php
│   ├── Post.php
│   ├── Category.php
│   ├── Tag.php
│   ├── Comment.php
│   └── Media.php
│
├── Services/
│   └── ...
│
└── ...
```

---

## 🗄️ Database Structure

The main entities are:

```text
User
 ├── Posts
 └── Comments

Post
 ├── Category
 ├── Tags
 ├── Comments
 └── Media

Category
 └── Posts

Tag
 └── Posts
```

### Users

Stores blog authors and administrators.

Example fields:

```text
id
name
email
password
role
email_verified_at
created_at
updated_at
```

### Posts

Stores published and draft blog entries.

Example:

```text
id
title
slug
content
excerpt
user_id
category_id
status
created_at
updated_at
deleted_at
```

### Categories

Stores blog content categories.

Example:

```text
id
name
slug
created_at
updated_at
```

### Tags

Stores content tags used for organization and filtering.

Example:

```text
id
name
slug
created_at
updated_at
```

### Comments

Stores reader comments for blog posts.

Example:

```text
id
post_id
user_id
name
email
content
status
ip_address
created_at
updated_at
```

### Relationships

A post belongs to a user:

```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

A post belongs to a category:

```php
public function category()
{
    return $this->belongsTo(Category::class);
}
```

A post can have many comments:

```php
public function comments()
{
    return $this->hasMany(Comment::class);
}
```

A post can have many tags through a pivot table:

```php
public function tags()
{
    return $this->belongsToMany(Tag::class);
}
```

---

## 🔐 Authentication & Roles

The application uses Laravel authentication and protected admin routes to keep blog management functionality available only to authenticated users.

The general flow is:

```text
Landing Page
    ↓
User Login / Register
    ↓
Controller
    ↓
Middleware / Auth Check
    ↓
Admin Dashboard / Protected Area
```

This allows separate experiences for:

* public visitors
* authenticated article writers/admins
* protected CMS management routes

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
```

Navigate into the project:

```bash
cd BlogCMS-app
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Create the Environment File

```bash
cp .env.example .env
```

### 5. Generate the Application Key

```bash
php artisan key:generate
```

### 6. Create the SQLite Database File (if needed)

```bash
touch database/database.sqlite
```

### 7. Run Migrations

```bash
php artisan migrate
```

Alternatively, the project includes a setup script:

```bash
composer run setup
```

---

## ⚙️ Environment Configuration

Configure the `.env` file with the appropriate app and database settings.

Example:

```env
APP_NAME="BlogCMS-app"
APP_ENV=local
APP_KEY=
APP_DEBUG=true

DB_CONNECTION=sqlite
```

For SQLite, ensure the database file exists and is writable:

```bash
touch database/database.sqlite
```

---

## 🗃️ Database Setup

Run the database migrations:

```bash
php artisan migrate
```

If you want to rebuild the database from scratch:

```bash
php artisan migrate:fresh
```

> ⚠️ `migrate:fresh` deletes all existing tables and data.

If database seeders are available:

```bash
php artisan db:seed
```

Or:

```bash
php artisan migrate --seed
```

---

## ▶️ Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

Start Vite for frontend assets:

```bash
npm run dev
```

The application can then be viewed in the browser using the local Laravel URL.

---

## 🏗️ Project Architecture

The application aims to keep controllers focused on HTTP concerns while moving business logic into services and request validation where appropriate.

The general flow is:

```text
HTTP Request
     ↓
Route
     ↓
Controller
     ↓
Request Validation
     ↓
Service / Action
     ↓
Eloquent Model
     ↓
Database
```

### Controllers

Controllers coordinate public-facing routes, admin operations, and content management actions.

### Form Requests

Request classes validate incoming input before it reaches the controller logic.

Typical validation includes:

* required title and content fields
* category and tag existence checks
* email validation for comments
* string and length checks
* nullable fields for optional metadata

### Services

Services are used for reusable logic such as:

* blog post creation and updates
* comment handling
* category and tag management
* public blog feed generation

---

## ✅ Validation

Validation is handled through Laravel form request classes and controller checks rather than placing all logic directly in views or routes.

Typical validation includes:

* required post content and metadata
* valid category and tag assignments
* safe comment submission data
* email validation for author and commenter fields
* status and moderation logic for user comments

---

## 🔒 Security Considerations

Blog CMS applications require careful attention to user-generated content and admin access.

Important considerations include:

* Passwords should never be stored as plain text.
* Authentication should use Laravel's hashing and built-in auth features.
* Protected admin routes should be guarded by middleware.
* User input should always be validated.
* CSRF protection should remain enabled.
* Comment and post content should be sanitized appropriately.
* Production deployments should use HTTPS.
* Secrets and credentials should never be committed to version control.

> **Important:** This project is primarily a Laravel learning and portfolio application and should not be treated as a production-ready publishing platform without a more thorough security review and additional protections.

---

## 🔮 Future Improvements

Potential future features include:

* [ ] Draft and scheduled publishing
* [ ] Rich text editor support
* [ ] Advanced search and filtering
* [ ] Post author profiles
* [ ] Email subscriptions and newsletters
* [ ] Role-specific permissions for editors and admins
* [ ] Content approval workflows
* [ ] Better media library management
* [ ] SEO metadata support
* [ ] Comment moderation dashboard
* [ ] Automated tests and feature coverage
* [ ] Improved accessibility and responsive layout
* [ ] Dark mode

---

## 📚 Learning Objectives

This project is designed to provide hands-on experience with:

* Laravel MVC architecture
* Routing and middleware
* Controllers and form requests
* Eloquent ORM and model relationships
* Authentication and protected admin areas
* Database migrations and schema design
* Tailwind and responsive front-end layout
* CRUD operations for blog content and comments
* CMS workflow design and publication logic

---

## 📌 Project Status

**Work in Progress**

The application is actively being developed as a practical Laravel portfolio project focused on content publishing, blog administration, and editorial workflows.
