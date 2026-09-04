# Professional Portfolio

A premium, database-driven personal portfolio for software engineers — built with Laravel 12, MySQL/SQLite, Tailwind CSS v4, GSAP, and Lenis smooth scrolling.

## Features

- **Premium public site** — Hero, about, services, projects (with case studies), experience, skills, blog, packages, contact, resume, search
- **CMS admin panel** — CRUD for projects, blog, services, packages, experience, skills, testimonials, messages, and site settings
- **REST API** — `/api/projects`, `/api/blog`, `/api/services`, `/api/contact`, `/api/search`
- **Interactions** — Command palette (⌘K), dark/light mode, scroll reveals, magnetic buttons, custom cursor (desktop)
- **Production-ready** — CSRF protection, rate limiting, validation, queued notifications, SEO metadata, structured data

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12, PHP 8.2+ |
| Database | MySQL 8+ (SQLite for local dev) |
| Frontend | Tailwind CSS v4, GSAP, Lenis |
| Auth | Laravel Breeze |
| Build | Vite 7 |

> **Note:** Laravel 13 requires PHP 8.3+. This project uses Laravel 12 on PHP 8.2.

## Quick Start

```bash
# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database (SQLite default)
touch database/database.sqlite   # if using SQLite
php artisan migrate:fresh --seed

# Build assets
npm run dev   # development
npm run build # production

# Serve
php artisan serve
```

Visit `http://localhost:8000`

### Default Admin Credentials

- **URL:** `/admin`
- **Email:** `admin@portfolio.test`
- **Password:** `password`

## Environment Variables

See `.env.example` for full list. Key variables:

```env
APP_NAME="Your Name"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite        # or mysql
DB_DATABASE=database/database.sqlite

MAIL_MAILER=log             # contact notifications
QUEUE_CONNECTION=database   # queued notifications
```

## Project Structure

```
app/
├── Http/Controllers/       # Public, API, Admin controllers
├── Models/                 # Eloquent models
├── Services/               # SiteSettingsService
└── View/Composers/         # Global view data

resources/
├── css/app.css             # Design tokens & components
├── js/app.js               # GSAP, Lenis, command palette
└── views/
    ├── layouts/portfolio.blade.php
    ├── components/portfolio/
    └── pages/

routes/
├── web.php                 # Public routes
├── api.php                 # REST API
└── admin.php               # Admin CMS
```

## Customization

1. **Site content** — Edit via Admin → Settings, or update `database/seeders/PortfolioSeeder.php`
2. **Placeholder data** — Replace `[Company Name]`, project names, and experience entries with real information
3. **Design tokens** — See `DESIGN_SYSTEM.md` and `resources/css/app.css`

## Testing

```bash
php artisan test
```

## Security

- Admin routes require authentication + `is_admin` flag
- Contact form: CSRF, rate limiting (5/hour), file upload validation
- Never commit `.env` or credentials

## License

MIT
