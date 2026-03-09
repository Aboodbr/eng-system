# Engineering Office Management System

## Project Overview
This project is an advanced management system for an engineering office built with Laravel. It facilitates project tracking, document management, secure user authentication (with distinct roles: Admin, Engineer, Secretary, Accountant), and financial transactions tracking.

## Features
- **Role-Based Access Control (RBAC):** Admin, Engineer, Secretary, and Accountant dashboards.
- **Project Management:** Track projects, assign receivers, and forward projects between engineers.
- **Financial Transactions:** Track installments, paid amounts, and remaining balances.
- **File Management:** Secure file uploads, storage optimization, and duplication prevention.
- **Performance Optimized:** Pagination, Eager Loading (to prevent N+1 issues), and Database Indexing.
- **Clean Architecture:** Utilizes Form Requests, Service layer, and Blade layouts.

## Technologies Used
- PHP 8.2+
- Laravel 11.x
- MySQL / PostgreSQL
- Tailwind CSS / Custom CSS
- SweetAlert2 for notifications

## Installation Instructions

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd <project-folder>
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies:**
   ```bash
   npm install
   npm run build
   ```

## Environment Setup
1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
2. Generate an application key:
   ```bash
   php artisan key:generate
   ```
3. Update `.env` with your database credentials.

## Database Migration Steps
Run the migrations and seeders to set up the database schema:
```bash
php artisan migrate --seed
```

## Storage Setup
Link the storage directory to make uploaded files publicly accessible:
```bash
php artisan storage:link
```

## Running the Application
Start the Laravel development server:
```bash
php artisan serve
```
Access the application at `http://localhost:8000`.

## Running Tests
To run the test suite and ensure everything is working correctly:
```bash
php artisan test
```

## Folder Structure Explanation
- `app/Http/Controllers/`: Handles incoming HTTP requests.
- `app/Http/Requests/`: Form Request validation logic.
- `app/Services/`: Business logic separated from controllers (Service Pattern).
- `app/Models/`: Eloquent models defining database schema and relationships.
- `resources/views/`: Blade templates structured with a main `layouts.app` and individual views.
- `database/migrations/`: Database schema definitions including performance indexes.

## Performance Optimizations Applied
- **Eager Loading:** Applied in `ProjectController` to resolve N+1 queries.
- **Pagination:** Used in lists (Users, Transactions) to optimize memory usage.
- **Database Indexing:** Added indexes to frequently queried columns like `role`, `sender_id`, and `receiver_id`.
- **Service Layer Pattern:** Separated complex logic from controllers to adhere to Single Responsibility Principle.
