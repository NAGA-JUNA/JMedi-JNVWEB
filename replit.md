# JMedi – Smart Medical Platform

## Overview
A complete SaaS medical platform built with pure PHP and PostgreSQL. Powered by JNVWeb.

## Tech Stack
- **Backend**: PHP 8.2, PostgreSQL, PDO prepared statements
- **Frontend**: HTML5, CSS3, Bootstrap 5.3, JavaScript
- **Server**: PHP built-in server via `php -S 0.0.0.0:5000 router.php`

## Project Structure
```
/public          - Frontend pages (index, doctors, departments, appointment, blog, contact)
/public/api      - AJAX API endpoints (doctors-by-dept)
/admin           - Admin panel pages (dashboard, doctors, departments, appointments, blog, testimonials, settings)
/includes        - Shared PHP files (db.php, auth.php, functions.php, header/footer templates)
/assets/css      - Stylesheets (style.css for frontend, admin.css for admin panel)
/assets/js       - JavaScript (main.js)
/assets/uploads  - User-uploaded images
/database        - SQL schema file
router.php       - URL router for PHP built-in server
```

## Database
- PostgreSQL (Replit built-in)
- Tables: admins, departments, doctors, appointments, posts, testimonials, settings
- Connection via DATABASE_URL environment variable

## Admin Access
- URL: `/admin/login.php`
- Default credentials: `admin` / `password`

## Key Features
- Doctor management with department filtering and search
- Appointment booking system with admin approval workflow
- Blog CMS with publish/draft status
- Testimonials management
- Website settings (site name, colors, contact info, social links)
- CSRF protection, password hashing, XSS protection
- Responsive design with Bootstrap 5

## Brand Colors
- Primary: Medical Blue #0D6EFD
- Secondary: Medical Green #20C997
