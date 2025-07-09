# Island Tours

A Laravel-based island tours booking system with Livewire components for managing tour bookings, packages, and user interactions.

## Features

- **User Booking System**: Customers can browse and book tour packages
- **Admin Panel**: Complete administrative interface for managing bookings
- **Package Management**: Create and manage different tour packages
- **Date Availability**: Manage available dates for tours
- **Booking Notifications**: Automated email notifications for booking status changes
- **User Authentication**: Secure login system for users and administrators
- **Payment Integration**: Handle booking payments
- **Responsive Design**: Built with Tailwind CSS for mobile-friendly interface

## Tech Stack

- **Backend**: Laravel 12.x with PHP 8.2+
- **Frontend**: Livewire 3.x, Alpine.js, Tailwind CSS
- **Database**: SQLite (development) / MySQL/PostgreSQL (production)
- **Build Tools**: Vite
- **Testing**: Pest PHP

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Local Development

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- Git

### Installation

1. **Clone the repository:**
```bash
git clone https://github.com/yourusername/island-tours.git
cd island-tours
```

2. **Install PHP dependencies:**
```bash
composer install
```

3. **Install JavaScript dependencies:**
```bash
npm install
```

4. **Create environment file:**
```bash
copy .env.example .env
```

5. **Generate application key:**
```bash
php artisan key:generate
```

6. **Create and setup database:**
```bash
# Create SQLite database file
type nul > database\database.sqlite

# Run migrations
php artisan migrate

# (Optional) Seed the database
php artisan db:seed
```

7. **Build frontend assets:**
```bash
npm run build
# Or for development with hot reload:
npm run dev
```

8. **Start the development server:**
```bash
php artisan serve
```

Visit `http://localhost:8000` to view the application.

## Deployment Options

### Option 1: Railway (Recommended - Free Tier Available)

Railway is perfect for Laravel applications and offers a generous free tier.

1. **Push your code to GitHub** (see instructions below)
2. **Visit [Railway.app](https://railway.app)**
3. **Sign up with your GitHub account**
4. **Click "Deploy from GitHub repo"**
5. **Select your island-tours repository**
6. **Railway will automatically detect it's a Laravel app**
7. **Set environment variables:**
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY=` (Railway will generate this)
   - `APP_URL=` (Railway will provide the URL)

### Option 2: Heroku

1. **Install Heroku CLI**
2. **Login to Heroku:**
```bash
heroku login
```

3. **Create a new Heroku app:**
```bash
heroku create your-island-tours-app
```

4. **Set environment variables:**
```bash
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY=$(php artisan key:generate --show)
```

5. **Deploy:**
```bash
git push heroku main
```

### Option 3: Vercel (Static Export)

For a static version of your site:

1. **Install Vercel CLI:**
```bash
npm i -g vercel
```

2. **Deploy:**
```bash
vercel
```

## Environment Variables for Production

Essential environment variables to set in your hosting platform:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
DB_CONNECTION=sqlite
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## Pushing to GitHub

If you haven't already pushed your code to GitHub:

1. **Initialize git repository (if not already done):**
```bash
git init
```

2. **Add all files:**
```bash
git add .
```

3. **Commit your changes:**
```bash
git commit -m "Initial commit: Island Tours booking system"
```

4. **Create a new repository on GitHub** (visit github.com)

5. **Add remote origin:**
```bash
git remote add origin https://github.com/yourusername/island-tours.git
```

6. **Push to GitHub:**
```bash
git push -u origin main
```

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
