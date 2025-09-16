# Booking System

**Booking System** is a Laravel-based web application for managing **hotel and flight reservations**.  
It provides a simple and structured workflow for handling customers, passengers, bookings, and pricing details.  
The system has two roles: **Customer** (to make bookings) and **Admin** (to view stats and manage dashboard).

---

## 📖 Project Overview
- Customers can create bookings for hotels or flights.
- Customers provide their details and can add  passengers/guests (name, email, phone).
- Each booking stores a related **Hotel/Flight ID**.
- Pricing breakdown is saved for every booking (base fare, taxes, discounts, total).
- After booking, customers see a **confirmation page** that shows passenger details, and pricing breakdown.
- Admin can log in and access the **dashboard**, which shows:
  - Total bookings  
  - Total hotel bookings  
  - Total flight bookings  
  - Total revenue  
  - Latest 5 bookings with passenger and pricing details  

---

## 🚀 Features
- Laravel 12 project with clean architecture  
- Hotel and flight booking management  
- Customer and passenger details  
- Pricing breakdowns for each booking  
- Booking confirmation page  
- Admin dashboard with statistics and recent bookings  
- Database managed entirely with **migrations** 

---

## 🛠️ Installation Guide
```bash
# Clone the repository
git clone https://github.com/kashifdevhub/booking-system.git
cd booking-system

# Install PHP dependencies
composer install

# Install frontend dependencies and build UI
npm install
npm run dev

# Copy environment file and configure database
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# Start local development server
php artisan serve
