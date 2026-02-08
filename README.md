# H&Co Properties - Real Estate Management System

A comprehensive Laravel-based real estate management system for property listings, communities, off-plan projects, and administrative operations in Dubai.

## Table of Contents

- [Overview](#overview)
- [Technical Dependencies](#technical-dependencies)
- [Installation Guide](#installation-guide)
- [Project Dependencies](#project-dependencies)
- [Codebase Structure](#codebase-structure)
- [Directory Explanation](#directory-explanation)
- [Working on the Project](#working-on-the-project)
- [Documentation](#documentation)
- [Development](#development)
- [Deployment Guide](#deployment-guide)

## Overview

H&Co Properties is a full-stack real estate management system that enables:
- Property listings management (Buy, Rent, Off-Plan)
- Community information and management
- Off-plan projects management
- Blog and content management
- Property search and filtering
- Booking and contact form management
- Slider management for homepage
- CMS sections for dynamic content
- Dashboard for administrative operations
- Integration with Pixxi Properties API

## Technical Dependencies

### Required Software

- **PHP:** 8.0.2 or higher
- **Composer:** 2.x
- **Node.js:** 18.x or higher
- **npm:** 9.x or higher (comes with Node.js)
- **MySQL:** 8.0 or higher

### PHP Extensions Required

- `mbstring`
- `xml`
- `curl`
- `zip`
- `gd` (for image processing)
- `pdo` and `pdo_mysql` (for database)

## Installation Guide

### Step 1: Clone the Repository

```bash
git clone <repository-url>
cd handco
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

This will install all PHP packages defined in `composer.json`, including:
- Laravel Framework 9.x
- Laravel Sanctum (API authentication)
- Laravel UI (authentication scaffolding)
- League Flysystem AWS S3 (for DigitalOcean Spaces storage)
- Maatwebsite Excel (Excel export)

### Step 3: Install Node Dependencies

```bash
npm install
```

This will install frontend dependencies:
- Vite 4.x (build tool)
- Bootstrap 5.x (CSS framework)
- Laravel Vite Plugin (Laravel integration)
- Axios (HTTP client)

### Step 4: Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

The `.env.example` file contains all required configuration variables with proper defaults. You only need to update the values for your environment.

Generate application key:

```bash
php artisan key:generate
```

### Step 5: Configure Database

Edit the `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=handco_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database:

```bash
mysql -u root -p -e "CREATE DATABASE handco_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 6: Run Migrations

```bash
php artisan migrate
```

This will create all database tables defined in `database/migrations/`.

(Optional) Seed the database with sample data:

```bash
php artisan db:seed
```

### Step 7: Create Storage Link

Create symbolic link for storage:

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public` so uploaded files are accessible via the web.

### Step 8: Build Frontend Assets

For development (with hot reload):

```bash
npm run dev
```

This starts Vite development server with hot module replacement.

For production build:

```bash
npm run build
```

This compiles and minifies CSS and JavaScript files.

### Step 9: Start Development Server

Using Laravel's built-in server:

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Project Dependencies

### Backend Dependencies (Composer)

#### Core Framework
- **laravel/framework:** ^9.19 - Laravel framework
- **php:** ^8.0.2 - PHP version requirement

#### Authentication & Authorization
- **laravel/sanctum:** ^3.0 - API token authentication
- **laravel/ui:** ^4.5 - Authentication scaffolding

#### File Management
- **league/flysystem-aws-s3-v3:** 3.0 - AWS S3 / DigitalOcean Spaces storage driver

#### Data Export
- **maatwebsite/excel:** ^1.1 - Excel import/export functionality

#### Development Dependencies
- **laravel/pint:** ^1.0 - Code style fixer
- **phpunit/phpunit:** ^9.5.10 - Testing framework

### Frontend Dependencies (npm)

- **vite:** ^4.5.3 - Build tool and development server
- **bootstrap:** ^5.2.3 - CSS framework
- **laravel-vite-plugin:** ^0.7.8 - Laravel integration for Vite
- **axios:** ^1.1.2 - HTTP client for API requests
- **@popperjs/core:** ^2.11.6 - Tooltip and popover library

## Codebase Structure

The project follows Laravel's standard directory structure with additional organization for better maintainability.

### Application Core (`app/`)

- **Console/Commands/**: Artisan commands for CLI operations
- **Http/Controllers/**: Request handlers organized by feature
  - **website/**: Frontend/website controllers (HomeController, ProjectController, BlogController, CommunityController)
  - **Auth/**: Authentication controllers (Login, Register, Password Reset)
- **Http/Middleware/**: Custom middleware (authentication, etc.)
- **Models/**: Eloquent models representing database tables
  - **Project**: Property listings
  - **OffPlanProject**: Off-plan projects
  - **Community**: Dubai communities
  - **Blog**: Blog posts
  - **Category**: Property categories
  - **Utility**: Property utilities/features
  - **Slider**: Homepage sliders
  - **Booking**: Property viewing bookings
  - **Contact**: Contact form submissions
  - **CmsSection**: CMS content sections
  - **Media**: Media file management
- **Services/**: Business logic layer
  - **MediaUploadService**: Media upload handling

### Configuration (`config/`)

All configuration files for the application:
- `app.php` - Application settings
- `database.php` - Database connections
- `filesystems.php` - Storage disk configuration (local, S3)
- `mail.php` - Email configuration
- `queue.php` - Queue configuration
- `cache.php` - Cache configuration

### Database (`database/`)

- **migrations/**: 32 migration files defining database schema
  - Users and authentication tables
  - Projects, Categories, Utilities tables
  - Communities, Off-plan projects tables
  - Blogs, Sliders, CMS sections tables
  - Bookings, Contacts tables
- **seeders/**: Database seeders for initial data
  - **DatabaseSeeder**: Main seeder with admin user and CMS sections

### Routes (`routes/`)

Route definitions organized by feature:
- `web.php` - Admin dashboard routes (projects, blogs, communities, sliders, etc.)
- `website.php` - Website frontend routes (home, projects, communities, blogs)
- `api.php` - API routes (if needed)

### Resources (`resources/`)

- **css/**: CSS files
- **js/**: JavaScript files
- **views/**: Blade templates
  - **website/**: Frontend views (home, projects, communities, blogs, contact)
  - **dashboard/**: Admin dashboard views (projects, blogs, communities, sliders, etc.)
  - **auth/**: Authentication views (login, register, password reset)
  - **layouts/**: Layout templates

### Public (`public/`)

Web-accessible files:
- `index.php` - Application entry point
- `storage/` - Symbolic link to storage/app/public
- `assets/` - Static assets (CSS, JS, images)
- `files/` - Uploaded files (projects, blogs, communities, etc.)

### Storage (`storage/`)

- **app/**: Application storage (uploaded files, media)
- **framework/**: Framework files (cache, sessions, views)
- **logs/**: Application logs

## Directory Explanation

### Controllers Organization

Controllers are organized into two main directories:

1. **Website Controllers** (`app/Http/Controllers/website/`)
   - Handle frontend/website operations
   - Examples: HomeController, ProjectController, BlogController, CommunityController

2. **Admin Controllers** (`app/Http/Controllers/`)
   - Handle admin dashboard operations
   - Require authentication
   - Examples: ProjectController, BlogController, CommunityController, SliderController, OffPlanProjectController

### Models and Relationships

Key models in the application:

- **User**: User accounts with authentication
- **Project**: Property listings (Buy/Rent/Off-Plan)
- **OffPlanProject**: Off-plan development projects
- **Community**: Dubai communities information
- **Blog**: Blog posts with categories
- **Category**: Property categories
- **Utility**: Property features and utilities
- **Slider**: Homepage slider content
- **Booking**: Property viewing bookings
- **Contact**: Contact form submissions
- **CmsSection**: Dynamic CMS content sections
- **Media**: Media file management

### Route Organization

Routes are split into multiple files:

- **Web Routes** (`routes/web.php`):
  - Admin dashboard routes (projects, blogs, communities, sliders, off-plan projects, etc.)
  - Authentication routes
  - CMS management routes

- **Website Routes** (`routes/website.php`):
  - Home page
  - Property listings (buy, rent, off-plan)
  - Communities pages
  - Blog pages
  - Contact and booking forms

### Request Flow

1. **Web Request**: Route → Middleware (Auth) → Controller → Model → Database → View/Redirect
2. **API Request**: Route → Middleware (Sanctum Auth) → Controller → Model → Database → JSON Response

### Authentication & Authorization

- **Web Authentication**: Laravel's built-in authentication system
- **API Authentication**: Laravel Sanctum (token-based)
- **Admin Access**: Protected by `auth` middleware on admin routes

## Working on the Project

### Git Workflow

The project uses a Git Flow-like branching strategy for organized development and deployment.

#### Branch Structure

- **main**: Production-ready code (stable, deployed to production)
- **dev**: Development branch (integration branch for all features)
- **feature/***: New features (merge into dev)
- **bugfix/***: Bug fixes (merge into dev or main)
- **hotfix/***: Critical production fixes (merge into main and dev)

#### Branch Naming Conventions

- Feature branches: `feature/description-of-feature`
  - Example: `feature/property-search-filters`, `feature/community-pages`
- Bugfix branches: `bugfix/description-of-bug`
  - Example: `bugfix/property-image-upload`, `bugfix/booking-form`
- Hotfix branches: `hotfix/description-of-hotfix`
  - Example: `hotfix/security-patch`, `hotfix/critical-bug`

### Development Workflow

#### 1. Starting a New Feature

```bash
# Ensure you're on the latest dev branch
git checkout dev
git pull origin dev

# Create a new feature branch
git checkout -b feature/your-feature-name

# Make your changes and commit
git add .
git commit -m "Add feature description"
```

#### 2. Commit Message Guidelines

Follow conventional commit message format:

```
type(scope): subject

body (optional)

footer (optional)
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

**Examples:**
```
feat(projects): Add advanced property search filters
fix(communities): Resolve community image upload issue
docs(readme): Update installation instructions
refactor(controllers): Improve ProjectController code structure
```

#### 3. Pushing Changes

```bash
# Push your branch to remote
git push origin feature/your-feature-name
```

#### 4. Creating a Pull Request

1. Go to GitHub repository
2. Click "New Pull Request"
3. Select `dev` as the base branch
4. Select your feature branch
5. Fill in PR description:
   - What changes were made
   - Why the changes were needed
   - How to test the changes
6. Request review from team members
7. Wait for code review and approval

#### 5. After PR Approval

Once your PR is approved and merged:
- Delete the feature branch locally: `git branch -d feature/your-feature-name`
- Delete the remote branch: `git push origin --delete feature/your-feature-name`
- Update your local dev branch: `git checkout dev && git pull origin dev`

### Code Review Guidelines

- All code must be reviewed before merging to `dev`
- Reviewers should check:
  - Code quality and best practices
  - Functionality and edge cases
  - Security considerations
  - Performance implications
  - Documentation updates

### Environment Configuration

The `.env.example` file contains all required configuration. When setting up:

1. Copy `.env.example` to `.env`
2. Update values:
   - Database credentials
   - API keys (if needed)
   - Mail configuration
   - Application URLs
3. Generate application key: `php artisan key:generate`

**Important:** Never commit `.env` file to version control.

## Development

### Code Style

The project uses Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

### Running Tests

```bash
php artisan test
```

### Queue Workers

For background job processing:

```bash
php artisan queue:work
```

### Clearing Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### IDE Helper

Generate IDE helper files for better autocomplete:

```bash
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta
```

## Deployment Guide

This project is deployed using Dokploy on Teleoceans servers. Media files can be stored on DigitalOcean Spaces.

### Prerequisites

- Access to Dokploy dashboard (teleoceans-servers.cloud)
- DigitalOcean account for Spaces storage (optional)
- GitHub repository access
- Production environment configured in Dokploy

### DigitalOcean Spaces Setup (Optional)

DigitalOcean Spaces can be used for storing media files (images, documents) in production.

#### 1. Create DigitalOcean Space

1. Log in to [DigitalOcean](https://cloud.digitalocean.com/login)
2. Navigate to "Spaces" in the left sidebar
3. Click "Create a Space"
4. Choose:
   - **Datacenter region**: Select closest to your server (e.g., `fra1` for Frankfurt)
   - **CDN**: Enable for faster file delivery
   - **Space name**: Choose a unique name
5. Click "Create a Space"

#### 2. Generate Access Keys

1. Go to "API" section in DigitalOcean dashboard
2. Click "Generate New Token"
3. Select "Spaces Keys" tab
4. Click "Generate New Key"
5. Save the **Access Key** and **Secret Key** securely

#### 3. Configure Environment Variables

Add these variables to your production `.env` file in Dokploy:

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=fra1
AWS_BUCKET=your-space-name
AWS_ENDPOINT=https://fra1.digitaloceanspaces.com
AWS_URL=https://your-space-name.fra1.digitaloceanspaces.com
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### Dokploy Deployment

#### 1. Connect Repository

1. Log in to Dokploy dashboard
2. Navigate to your project (H&Co Properties)
3. Select the production environment
4. Go to the backend service
5. In "Provider" section, connect your GitHub repository
6. Ensure the repository is properly connected

#### 2. Configure Environment Variables

1. Go to "Environment" tab in Dokploy
2. Add all required environment variables from `.env.example`
3. Set production-specific values:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://your-domain.com`
   - Database credentials
   - DigitalOcean Spaces credentials (if using)

#### 3. Build Configuration

Dokploy will automatically:
- Install Composer dependencies
- Install npm dependencies
- Build frontend assets (`npm run build`)
- Run migrations (if configured)

#### 4. Deployment Process

1. **Manual Deployment:**
   - Go to "Deploy Settings" section
   - Click "Deploy" button
   - Monitor deployment logs

2. **Automatic Deployment:**
   - Enable "Autodeploy" toggle
   - Dokploy will automatically deploy when code is pushed to the connected branch

#### 5. Post-Deployment Steps

After successful deployment, run these commands via Dokploy terminal:

```bash
# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link (if not exists)
php artisan storage:link

# Run migrations (if needed)
php artisan migrate --force

# Clear application cache
php artisan cache:clear
```

### Production Checklist

Before deploying to production, ensure:

- [ ] All environment variables are set correctly
- [ ] `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Database credentials are correct
- [ ] DigitalOcean Spaces credentials are configured (if using)
- [ ] Mail configuration is correct
- [ ] Application URLs are set correctly
- [ ] Queue workers are running (configured in Dokploy)
- [ ] Storage link is created
- [ ] All migrations are up to date
- [ ] Frontend assets are built (`npm run build`)

### Queue Workers Setup

Queue workers should be configured in Dokploy to process background jobs:

1. In Dokploy, ensure queue workers are running
2. Configure supervisor or similar process manager
3. Queue connection should be set to `database` or `redis` in production

### Monitoring

- Check application logs in Dokploy "Logs" tab
- Monitor DigitalOcean Spaces usage in DigitalOcean dashboard (if using)
- Monitor server resources in Dokploy dashboard

### Rollback Procedure

If deployment fails:

1. Go to "Deployments" tab in Dokploy
2. Find the previous successful deployment
3. Click "Redeploy" on the previous version
4. Monitor logs to ensure successful rollback

### Troubleshooting

**Issue: Files not uploading to DigitalOcean Spaces**
- Verify AWS credentials in environment variables
- Check Space name and region match configuration
- Ensure Space has proper permissions

**Issue: Application errors after deployment**
- Check application logs in Dokploy
- Verify all environment variables are set
- Clear cache: `php artisan cache:clear && php artisan config:clear`

**Issue: Assets not loading**
- Ensure `npm run build` completed successfully
- Check `public/build` directory exists
- Verify Vite manifest is generated

**Issue: Database connection errors**
- Verify database credentials in `.env`
- Check database server is accessible
- Ensure database exists and user has proper permissions

