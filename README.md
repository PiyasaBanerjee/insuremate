# InsureMate - Insurance Management System

## About the Project

InsureMate is a web-based Insurance Management System developed using Laravel, PHP, MySQL, and Bootstrap.

The system allows users to explore insurance plans, purchase policies, manage policies, submit claims, and handle renewals. An admin panel is provided to manage users, categories, plans, policies, claims, payments, and other insurance-related activities.

## Technologies Used

- PHP
- Laravel
- MySQL
- HTML5
- CSS3
- Bootstrap
- JavaScript

## Setup Instructions

### 1. Start XAMPP

Start:

- Apache
- MySQL

### 2. Create the Database

Create a MySQL database named:

`insurance_management`

If your MySQL server uses port `3307`, configure the `.env` file accordingly.

### 3. Configure Environment

Copy `.env.example` to `.env` and configure your database settings.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=insurance_management
DB_USERNAME=root
DB_PASSWORD=