<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Multi-Vendor E-Commerce Platform (Laravel)

A full-featured multi-vendor e-commerce web application built with Laravel, supporting distinct **Buyer** and **Seller** roles, product management, and integrated Stripe payments.

## ✨ Features

- ✅ **Multi-Vendor Architecture** — Separate Buyer and Seller roles with dedicated dashboards and permissions
- ✅ **Seller Panel** — Product listing, inventory management, and order tracking for vendors
- ✅ **Buyer Panel** — Product browsing, cart, checkout, and order history
- ✅ **Stripe Payment Integration** — Secure checkout and transaction processing
- ✅ **Role-Based Access Control (RBAC)** — Distinct permissions and workflows for Buyers and Sellers
- ✅ **RESTful API Layer** — Custom APIs supporting vendor and product operations
- ✅ **Order Management** — Order processing and reconciliation across multiple vendors

## 🏗️ Tech Stack

| Category | Technology |
|---|---|
| Framework | Laravel |
| Language | PHP |
| Frontend | Blade, JavaScript, CSS |
| Database | MySQL |
| Payments | Stripe |
| Auth | Laravel Authentication / Sanctum |

# 📸 ScreenShots
https://www.linkedin.com/posts/hafiz-ahmad-faizan-338b29252_laravel-php-webdevelopment-ugcPost-7437916011317772290-7Jdi/?utm_source=share&utm_medium=member_desktop&rcm=ACoAAD51hJwBXc6yDAQiAZb_23Cv1aR8uKwhtBs

## 📂 Project Structure

```
app/          # Models, Controllers, business logic
routes/       # Web and API route definitions
resources/    # Blade views, frontend assets
database/     # Migrations and seeders
config/       # App and service configuration
```

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL

### Installation

```bash
# Clone the repository
git clone https://github.com/HafizAhmad786/Ecommerce_laravel_app.git

# Navigate to project directory
cd Ecommerce_laravel_app

# Install PHP dependencies
composer install

# Install JS dependencies
npm install && npm run dev

# Copy environment file and configure
cp .env.example .env
php artisan key:generate

# Configure your database credentials in .env, then run migrations
php artisan migrate

# Start the development server
php artisan serve
```

## 📬 Contact

**Hafiz Ahmad Faizan** — Full-Stack Developer (Flutter & Laravel)
🔗 [LinkedIn](https://www.linkedin.com/in/hafiz-ahmad-338b29252)
🐙 [GitHub](https://github.com/HafizAhmad786)
