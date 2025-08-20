# URL Shortener Project
Laravel 11 URL Shortener with roles (SuperAdmin, Admin, Member), company-based access control, and CSV export.


## 📌 Project Summary
This is a Laravel 11-based URL Shortener application with role-based access control for multiple companies.

### 🔐 Roles & Permissions

- **SuperAdmin**
  - Cannot create short URLs
  - Can view all short URLs across all companies
  - Can invite Admins for new companies

- **Admin**
  - Can create short URLs for their own company
  - Can invite Members and other Admins within their company
  - Can view all URLs in their own company

- **Member**
  - Can create short URLs
  - Can view only their own created URLs

### 🌐 Short URL Functionality

- All short URLs are publicly accessible
- Redirect to the original long URL
- CSV download of URLs with filters:
  - Today
  - This week
  - This month
  - Last month

---

## ⚙️ Tech Stack

- Laravel 11
- PHP 8.3
- MySQL
- Blade (Frontend)
- Bootstrap 4/5

---

## 🛠️ Setup Instructions

### Requirements

- PHP >= 8.1
- Composer
- MySQL or SQLite
- Node.js & npm

### Steps to Run the Project Locally

1. **Clone the repository**
git clone https://github.com/vksinghjaipur/url-shortner-project.git
cd url-shortner-project

2. **Install PHP and JS dependencies**
composer install
npm install

3. **Create a copy of the .env file**
cp .env.example .env
Update the database and other credentials inside the .env file.

4. **Generate application key**
php artisan key:generate

5. **Run database migrations**
php artisan migrate

6. **Run seeder for SuperAdmin**
php artisan db:seed --class=SuperAdminSeeder

**SuperAdmin Credential**
Email: superadmin@urlshortner.com
Password: 12345678

7. **Compile frontend assets**
npm run dev


8. **Start the Laravel development server**
``bash
php artisan serve


