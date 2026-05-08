# Furniture Laravel Project

An e-commerce furniture website built with Laravel 10, MySQL, Blade templates, and Vite.
with a new

## Features

- Client storefront: home page, products, categories, cart, checkout, blog posts, contact
- Authentication: register/login/logout, forgot/reset password
- Social login support: Google and Facebook
- Admin dashboard: products, categories, comments, orders, users, menus, posts, images, addresses, email templates/logs
- CKEditor integration for rich content management

## Tech Stack

- PHP `^8.1`
- Laravel `^10`
- MySQL `8+` (or compatible MariaDB)
- Node.js `18+` and npm (for Vite assets)
- Composer `2+`

## Prerequisites

Make sure these are installed on your machine:

- PHP (CLI) with common extensions (`openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`)
- Composer
- MySQL server
- Node.js + npm
- Git

## Project Setup (Step by Step)

### 1) Clone project

```bash
git clone <your-repository-url>
cd Furniture-laravel-project
```

### 2) Install PHP dependencies

```bash
composer install
```

### 3) Install Node dependencies

```bash
npm install
```

### 4) Create environment file

```bash
copy .env.example .env
```

If you are using Git Bash on Windows, use:

```bash
cp .env.example .env
```

### 5) Configure `.env`

Open `.env` and update database + app URL values:

```env
APP_NAME="Furniture"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=furniture_db
DB_USERNAME=root
DB_PASSWORD=
```

Optional (for social login):

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT=${APP_URL}/auth/facebook/callback
```

### 6) Generate application key

```bash
php artisan key:generate
```

### 7) Create database

Create a database manually in MySQL (example name: `furniture_db`), then make sure the same name is set in `.env`.

### 8) Run migrations

```bash
php artisan migrate
```

### 9) Create storage symlink

```bash
php artisan storage:link
```

## First Admin Bootstrap (Important)

This project currently does not include default seeders, so you should create role data and an admin user manually.

### Option A: Insert with `tinker`

Run:

```bash
php artisan tinker
```

Then paste:

```php
\DB::table('role')->insert([
    ['name' => 'Admin', 'description' => 'System administrator', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'User', 'description' => 'Customer', 'created_at' => now(), 'updated_at' => now()],
]);

\App\Models\User::create([
    'username' => 'admin',
    'email' => 'admin@example.com',
    'phone_number' => '0123456789',
    'password' => bcrypt('admin123'),
    'role' => 1,
]);
```

Type `exit` to quit tinker.

## Run Tutorial

You need **2 terminals**:

### Terminal 1: Run Laravel server

```bash
php artisan serve
```

Default app URL:

- [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Terminal 2: Run Vite dev server

```bash
npm run dev
```

Keep both terminals running while developing.

## Access URLs

- Client site: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- Admin login form: [http://127.0.0.1:8000/logon](http://127.0.0.1:8000/logon)

## Build for Production

```bash
npm run build
```

Then deploy with your preferred web server (Nginx/Apache) pointing document root to `public/`.

## Useful Commands

- Clear app/cache/view config:

```bash
php artisan optimize:clear
```

- Re-run migration from scratch (danger: deletes data):

```bash
php artisan migrate:fresh
```

- Run tests:

```bash
php artisan test
```

## Troubleshooting

- `SQLSTATE[HY000] [1045] Access denied`:
    - Check `DB_USERNAME` and `DB_PASSWORD` in `.env`
- `Base table or view not found`:
    - Run `php artisan migrate`
- Images not showing:
    - Run `php artisan storage:link`
- Asset 404 or CSS/JS missing:
    - Run `npm install` and `npm run dev`
- Social login errors:
    - Check Google/Facebook credentials and callback URLs in `.env`

## Notes

- Admin middleware allows only users with `role = 1`.
- Routes use Vietnamese slugs for many client/admin pages.
- If you want sample data, add seeders/factories and run `php artisan db:seed`.
