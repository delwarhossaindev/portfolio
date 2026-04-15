# Portfolio Application

A modern, admin-managed portfolio website built with Laravel 11 and Blade templating. This application allows administrators to showcase their professional experience, projects, and manage visitor inquiries through an intuitive dashboard.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Admin Credentials](#admin-credentials)
- [Project Structure](#project-structure)
- [Key Routes](#key-routes)
- [Usage](#usage)

## Features

- **Portfolio Showcase**: Display professional experience and projects
- **Admin Dashboard**: Manage portfolio content, permissions, and users
- **Role-Based Access Control**: Spatie permissions integration for granular access control
- **Contact Form**: Visitor inquiries with admin management
- **User Management**: Add and manage admin users with different roles
- **Responsive Design**: Mobile-friendly interface
- **Terminal Panel**: Execute artisan commands directly from the admin panel
- **SQLite Database**: Default local database setup

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js (for Vite asset compilation)
- npm or yarn

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd portfolio
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Generate Environment File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Create Database and Run Migrations

```bash
php artisan migrate:fresh --seed
```

This will create the SQLite database and seed it with initial roles, permissions, and admin user.

### 6. Create Storage Link

```bash
php artisan storage:link
```

Or visit `http://localhost/storage-link` in your browser.

### 7. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

## Configuration

### Environment Variables

Key configuration in `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### Database

The application uses SQLite by default. The database file is located at `database/database.sqlite`.

## Database Setup

The project includes database migrations and seeders:

- **Migrations**: Create all necessary tables (users, contacts, experiences, projects, etc.)
- **Seeders**: 
  - `RolesAndPermissionsSeeder`: Creates admin, user roles and associated permissions
  - `DatabaseSeeder`: Creates initial admin user

### Run Migrations

```bash
php artisan migrate
```

### Seed Database

```bash
php artisan db:seed
```

### Fresh Migration with Seeding

```bash
php artisan migrate:fresh --seed
```

## Admin Credentials

Default admin user created during seeding:

- **Email**: `admin@demo.com`
- **Password**: `123456`

> **Note**: Change these credentials immediately after first login in a production environment.

## Project Structure

```
portfolio/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Application controllers
│   │   │   ├── AdminAuthController.php
│   │   │   ├── PortfolioController.php
│   │   │   ├── ExperienceController.php
│   │   │   ├── ProjectController.php
│   │   │   └── ...
│   ├── Models/                   # Eloquent models
│   │   ├── User.php
│   │   ├── Contact.php
│   │   ├── Experience.php
│   │   ├── Project.php
│   │   └── PortfolioContent.php
│   └── Providers/                # Service providers
├── database/
│   ├── migrations/               # Database schema migrations
│   ├── seeders/                  # Database seeders
│   └── factories/                # Model factories for testing
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── portfolio.blade.php   # Public portfolio page
│   │   ├── terminal-panel.blade.php
│   │   ├── welcome.blade.php
│   │   └── admin/                # Admin panel views
│   ├── css/                      # Stylesheets
│   └── js/                       # JavaScript assets
├── routes/
│   └── web.php                   # Web routes
├── config/                       # Configuration files
└── storage/                      # File storage (logs, uploads, etc.)
```

## Key Routes

### Public Routes

- `GET /` - Home page (portfolio showcase)
- `POST /contact` - Submit contact form

### Admin Routes

- `GET /admin/login` - Admin login page
- `POST /admin/login` - Login submission
- `GET /admin/dashboard` - Admin dashboard (requires authentication)

### Admin Authenticated Routes (Protected)

- `POST /admin/logout` - Logout
- `GET /admin/home` - Edit home/portfolio content
- `PUT /admin/home` - Update portfolio content
- `GET /admin/experiences` - List experiences
- `GET /admin/experiences/create` - Create experience
- `POST /admin/experiences` - Store experience
- `GET /admin/experiences/{id}/edit` - Edit experience
- `PUT /admin/experiences/{id}` - Update experience
- `DELETE /admin/experiences/{id}` - Delete experience

Similar RESTful routes exist for:
- `/admin/projects` - Project management
- `/admin/contacts` - Manage contact inquiries
- `/admin/users` - Manage users
- `/admin/roles` - Manage roles
- `/admin/permissions` - Manage permissions

### Utility Routes

- `GET /storage-link` - Create storage symlink
- `GET /migrate` - Run database migrations (force)

## Usage

### Accessing the Application

1. **Public Portfolio**: Visit `http://localhost` to see the portfolio
2. **Admin Panel**: Visit `http://localhost/admin/login`
3. **Login**: Use credentials:
   - Email: `admin@demo.com`
   - Password: `123456`

### Managing Content

In the admin dashboard, you can:

- **Edit Portfolio**: Update home page content and profile information
- **Manage Experiences**: Add, edit, or delete work experience entries
- **Manage Projects**: Showcase your projects with descriptions and links
- **View Contacts**: See messages from visitors through the contact form
- **User Management**: Add or remove admin users
- **Roles & Permissions**: Configure access levels for different users

### Running Commands

Access the Terminal Panel (`/terminal-panel`) to execute artisan commands directly through the web interface.

## Development Workflow

### Build Assets

```bash
# Development build with hot reload
npm run dev

# Production build
npm run build
```

### Run Local Server

```bash
php artisan serve
```

Then visit `http://localhost:8000`

### Run Tests

```bash
php artisan test
```

## License

This project is open-sourced software licensed under the MIT license.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
