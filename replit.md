# JMedi – Smart Medical Platform

## Overview
A complete SaaS medical platform built with pure PHP and PostgreSQL. Powered by JNVWeb.
Design inspired by the Medilink WordPress theme with professional medical UI.

## Tech Stack
- **Backend**: PHP 8.2, PostgreSQL, PDO prepared statements
- **Frontend**: HTML5, CSS3, Bootstrap 5.3, JavaScript, Swiper.js
- **Font**: Plus Jakarta Sans (Google Fonts)
- **Icons**: Font Awesome 6.5
- **Server**: PHP built-in server via `php -S 0.0.0.0:5000 router.php`

## Project Structure
```
/public          - Frontend pages (index, doctors, departments, appointment, blog, contact)
/public/api      - AJAX API endpoints (doctors-by-dept)
/admin           - Admin panel pages (dashboard, hero-sliders, doctors, departments, appointments, blog, testimonials, settings, menu-manager, pages)
/includes        - Shared PHP files (db.php, auth.php, functions.php, header/footer templates)
/assets/css      - Stylesheets (style.css, hero-slider.css for frontend, admin.css for admin panel)
/assets/js       - JavaScript (main.js - animations/counters/swiper, hero-slider.js - carousel/parallax/transitions)
/assets/uploads  - User-uploaded images
/database        - SQL schema file
router.php       - URL router for PHP built-in server
.htaccess        - Apache rewrite rules for cPanel deployment
```

## Database
- PostgreSQL (Replit built-in)
- Tables: admins, departments, doctors, appointments, posts, testimonials, settings, hero_slides, menus, pages
- Connection via DATABASE_URL environment variable

## Admin Access
- URL: `/admin/login.php`
- Default credentials: `admin` / `password`

## Key Features
- Dynamic Hero Slider with admin CRUD (background images, text animations, transitions, parallax)
- Doctor management with department filtering and search
- Appointment booking system with admin approval workflow
- Blog CMS with publish/draft status
- Testimonials management with Swiper carousel
- Website settings (site name, colors, contact info, social links)
- CSRF protection, password hashing, XSS protection
- AJAX login modal in navbar with CSRF-protected API endpoint (`/public/api/login.php`)
- Medcare-style admin dashboard: green/teal theme, Chart.js patient statistics, weekly calendar widget, approval rate donut, content stats cards
- CMS: Menu Manager with drag-and-drop ordering, Page Editor with CKEditor WYSIWYG
- Logo management (frontend + admin), WhatsApp number setting
- Floating WhatsApp chat button and appointment button on frontend
- Dynamic navigation loaded from menus DB table
- Responsive design with Bootstrap 5

## UI Design (Medilink-Inspired)
- Dynamic Hero Slider: Bootstrap carousel with parallax background, per-slide text animations (fadeIn/slideUp/slideLeft/zoomIn), transition effects (slide/fade/zoom), floating medical icons, gradient overlays, and navigation arrows/dots
- Admin manages slides at /admin/hero-sliders.php (add/edit/delete, image upload, animation/transition selection, sort order, enable/disable)
- Info-strip bar (Request Appointment, Find Doctors, Find Locations, Emergency)
- About section with experience badge and feature checklist
- Department cards with hover animations and gradient bottom borders
- Doctor cards with overlay social icons on hover
- Process section with numbered steps (01-04)
- Stats section with animated counter numbers
- Testimonial carousel with avatar initials and quote styling
- Blog cards with date badges and read-more arrows
- Dual CTA sections with gradient backgrounds
- Scroll-triggered fade-in/scale-in animations via IntersectionObserver

## Brand Colors
- Primary: Medical Blue #0D6EFD
- Secondary: Medical Green #20C997
- Dark Navy: #0f2137 (topbar, footer backgrounds)
- Light Background: #f5f9fc

## Seed Data (Realistic Hospital Content)
- **8 Doctors**: Dr. James Wilson (Cardiology), Dr. Sarah Chen (Neurology), Dr. Michael Roberts (Orthopedics), Dr. Emily Johnson (Pediatrics), Dr. David Park (Dermatology), Dr. Lisa Anderson (Dental), Dr. Rachel Martinez (Cardiac EP), Dr. Andrew Thompson (Neurosurgery) — with detailed bios, qualifications, and randomuser.me photos
- **6 Departments**: Cardiology, Neurology, Orthopedics, Pediatrics, Dermatology, Dental Care — with comprehensive descriptions and detailed service lists
- **6 Blog Posts**: Heart Health Tips, Regular Checkups, Robotic Joint Replacement, Child Healthcare Guide, Managing Diabetes, Dental Care Essentials — with full-length article content
- **3 Hero Slides**: "Advanced Medical Care You Can Trust", "Modern Diagnostic Services", "Your Health Is Our Priority" — with per-slide animations and transitions
- **4 Testimonials**: Detailed patient stories referencing specific doctors and departments

## GitHub Repository
- https://github.com/NAGA-JUNA/JMedi-JNVWEB
