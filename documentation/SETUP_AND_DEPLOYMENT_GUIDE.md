# VetConnect V2 Setup and Deployment Guide

Document Control
- Project: VetConnect V2
- Version: 1.0
- Date: [Insert date]
- Prepared by: [Insert names]

## 1. Prerequisites

Install the following:
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL (or your configured database engine)
- Git (optional, for cloning)

## 2. Project Setup (Fresh Machine)

From project root:

1. Install PHP dependencies
   - `composer install`
2. Copy environment file
   - `copy .env.example .env` (Windows)
3. Generate app key
   - `php artisan key:generate`
4. Configure `.env`
   - Set `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
5. Run database migrations
   - `php artisan migrate`
6. (Optional but recommended) Seed demo users
   - `php artisan db:seed --class=RoleSeeder`
7. Install frontend dependencies
   - `npm install`
8. Build frontend assets
   - `npm run build`
9. Create storage symlink for uploaded files
   - `php artisan storage:link`

## 3. Run for Local Development

Option A (single command if configured):
- `composer run dev`

Option B (separate terminals):
- Terminal 1: `php artisan serve`
- Terminal 2: `npm run dev`

Open app:
- `http://127.0.0.1:8000`

## 4. Demo Account Notes

If seeded with `RoleSeeder`, sample accounts may exist:
- Admin: `admin@vetconnect.com`
- Pet owner: `owner@vetconnect.com`
- Password: `password`

If these credentials do not work:
- Re-run seeder, or
- Create fresh admin and pet owner accounts manually.

## 5. Production/Presentation Checklist

Before showing to evaluator:
- `.env` points to correct database
- `APP_URL` is correct
- Migrations are applied
- `php artisan storage:link` completed
- Assets are built (`npm run build`)
- Demo data is present (pets, appointments, records)
- Test admin and pet owner login works

## 6. Common Setup Issues

### Issue: `Vite manifest not found`
Cause: assets not built.
Fix:
1. Run `npm install`
2. Run `npm run build`

### Issue: `SQLSTATE` connection errors
Cause: wrong DB credentials/database missing.
Fix:
1. Verify `.env` DB values
2. Ensure database exists
3. Run `php artisan config:clear`

### Issue: Images not showing
Cause: no storage link.
Fix:
1. Run `php artisan storage:link`
2. Refresh browser

### Issue: `Target class [role] does not exist` or middleware problems
Cause: stale cache/config.
Fix:
1. Run `php artisan optimize:clear`
2. Retry request

## 7. Reset and Rebuild (Safe Demo Refresh)

Use only on non-production demo database:
1. `php artisan migrate:fresh --seed`
2. `php artisan storage:link`
3. `npm run build`

This gives a clean dataset for consistent presentation.

## 8. Submission Notes

Include:
- Source code
- `.env.example` only (never expose real secrets)
- Database export (`.sql`)
- User Manual
- Admin Guide
- Demo script + presentation
- This setup guide
