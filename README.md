# Professional Portfolio

A premium, database-driven personal portfolio for software engineers — built with Laravel 12, React, Inertia, MySQL/SQLite, and Tailwind CSS v4.

## Features

- **Premium public site** — Hero, about, services, projects (with case studies), experience, skills, blog, packages, contact, resume, search
- **CMS admin panel** — CRUD for projects, blog, services, packages, experience, skills, testimonials, messages, and site settings
- **REST API** — `/api/projects`, `/api/blog`, `/api/services`, `/api/contact`, `/api/search`
- **Interactions** — Command palette (⌘K), dark/light mode, scroll reveals, and responsive navigation
- **React frontend** — Public, admin, authentication, and profile pages are rendered with React and Inertia while Laravel continues to handle routes, sessions, validation, and persistence
- **Production-ready** — CSRF protection, rate limiting, validation, queued notifications, SEO metadata, structured data

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12, PHP 8.2+ |
| Database | MySQL 8+ (SQLite for local dev) |
| Frontend | React 19, Inertia.js, Tailwind CSS v4 |
| Auth | Laravel session authentication |
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

### WhatsApp Contact Notifications

Contact form submissions can be sent to the configured number through the WhatsApp Business Cloud API. Add these values to the server's `.env` file (do not put the access token in frontend/Vite variables):

```env
WHATSAPP_CLOUD_ACCESS_TOKEN=your_permanent_access_token
WHATSAPP_CLOUD_PHONE_NUMBER_ID=your_business_phone_number_id
WHATSAPP_CLOUD_TO=923446622635
WHATSAPP_CLOUD_TEMPLATE_NAME=new_contact_inquiry
WHATSAPP_CLOUD_TEMPLATE_LANGUAGE=en_US
WHATSAPP_CLOUD_API_VERSION=v23.0
```

Create and get approval for a WhatsApp message template named `new_contact_inquiry` in WhatsApp Manager. Its body should contain one text placeholder (for example, `New portfolio inquiry:\n{{1}}\n\nPlease review and reply.`); the application fills that placeholder with the submitter's details and message. A template is required because the visitor's website form submission does not open a WhatsApp conversation with the business. After changing environment values, clear Laravel's cached config with `php artisan config:clear` (or rebuild the config cache for production). API/configuration failures are recorded in the Laravel log; contact submissions are still saved in the admin inbox.

## Project Structure

```
app/
├── Http/Controllers/       # Public, API, Admin controllers
├── Models/                 # Eloquent models
├── Services/               # Site settings and WhatsApp notification services
└── Http/Middleware/        # Shared Inertia props

resources/
├── css/                    # Public and admin design systems
├── js/
│   ├── app.jsx             # Inertia bootstrap with lazy page loading
│   ├── Components.jsx      # Shared React UI
│   └── Pages/              # Portfolio, admin, auth, and profile pages
└── views/app.blade.php     # Inertia document shell

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

Public and admin pages use lazy-loaded Inertia page modules, so a visit downloads the shared React runtime and only the current page module. Subsequent Inertia navigation avoids full document reloads. This is a client-rendered setup; React by itself does not reduce the initial document's rendering work.

## Security

- Admin routes require authentication + `is_admin` flag
- Contact form: CSRF, rate limiting (5/hour), file upload validation
- Never commit `.env` or credentials

## License

MIT
