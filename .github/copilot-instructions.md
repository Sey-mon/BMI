# Copilot Instructions

<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

This is a Laravel project with authentication for both admin and regular users. 

## Project Context
- Laravel 12.x framework
- Multi-role authentication system (Admin and User roles)
- MySQL database (configurable to SQLite for development)
- Laravel Breeze for authentication scaffolding
- Tailwind CSS for styling
- Role-based access control with middleware

## Coding Guidelines
- Follow Laravel conventions and best practices
- Use Eloquent models for database interactions
- Implement proper middleware for role-based access control
- Use Laravel's built-in authentication features
- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Add proper documentation for complex functions
- Use PHPDoc annotations for better IDE support

## Authentication Structure
- User model with role field (`admin` or `user`)
- AdminMiddleware for protecting admin routes
- Role-based navigation and redirects
- Seeded test users (admin@example.com and user@example.com)
- Admin dashboard with user management
- Regular user dashboard

## File Structure
### Models
- `app/Models/User.php` - Enhanced with role methods (isAdmin(), isUser())

### Middleware
- `app/Http/Middleware/AdminMiddleware.php` - Protects admin routes

### Controllers
- `app/Http/Controllers/AdminController.php` - Admin functionality

### Views
- `resources/views/admin/dashboard.blade.php` - Admin dashboard
- `resources/views/admin/users.blade.php` - User management
- `resources/views/test-page.blade.php` - Project status page
- `resources/views/setup-database.blade.php` - Database setup guide

### External Assets (CSS & JavaScript Separation)
- `public/css/auth.css` - Authentication pages styling (login/register)
- `public/css/pages.css` - Test and setup pages styling
- `public/js/auth.js` - Authentication pages JavaScript functionality
- `public/js/pages.js` - Test and setup pages JavaScript functionality

**CSS/JS Separation Completed:**
- Removed all inline `<style>` blocks from view files
- Extracted authentication styles to `auth.css` with modern green theme
- Extracted test/setup page styles to `pages.css`
- Created interactive JavaScript files with features:
  - Form validation and submission feedback
  - Copy-to-clipboard functionality for code blocks
  - Smooth transitions and hover effects
  - Auto-focus on form inputs
  - Notification system for user feedback
- Updated all view files to use external asset links
- Maintained responsive design and accessibility features

### Routes
- Admin routes: `/admin/dashboard`, `/admin/users` (protected by admin middleware)
- Public routes: `/test`, `/setup` for debugging and setup

### Database
- Migration: `add_role_to_users_table.php` - Adds role enum field
- Seeder: `AdminUserSeeder.php` - Creates test admin and user accounts

## Development Notes
- Database connection configurable via .env (MySQL/SQLite)
- Test pages available for troubleshooting
- Role-based UI components in navigation
- Proper type hinting and PHPDoc for IDE support
- **CSS/JS Separation:** All inline styles and scripts moved to external files
- **Modern UI:** Custom green-themed authentication with glassmorphism effects
- **Interactive Features:** Form enhancements, copy functionality, smooth animations
- **Asset Organization:** Structured external CSS/JS files for maintainability
