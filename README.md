<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

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

1. ### Clone the repository**
- git clone https://github.com/vksinghjaipur/url-shortner-project.git
- cd url-shortner-project

2. ### Install PHP and JS dependencies**
- composer install
- npm install

3.  ### Create a copy of the .env file**
- cp .env.example .env
- Update the database and other credentials inside the .env file.

4.  ### Generate application key**
- php artisan key:generate

5.  ### Run database migrations**
- php artisan migrate

6. ### Run seeder for SuperAdmin**
- php artisan db:seed --class=SuperAdminSeeder

7. ### SuperAdmin Credential  
- **Email:** superadmin@urlshortner.com  
- **Password:** 12345678


8. ### Compile frontend assets**
- npm run dev


9.  ### Start the Laravel development server**
- php artisan serve


### 👨‍💻 Developed By

**Vikash Kumar Singh**  
📧 vksinghjaipur@gmail.com


<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

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

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
