# Insurance Management System

## Setup Instructions

1.  **Start XAMPP**: Ensure Apache and MySQL are running.
2.  **Database**: The database `insurance_management` should have been created and migrated automatically.
3.  **Seed Data**:
    Run the following command to create the default Admin user and categories:
    ```bash
    php artisan db:seed --class=AdminUserSeeder
    ```
4.  **Run Application**:
    Open a terminal in this directory and run:
    ```bash
    php artisan serve
    ```
5.  **Access the App**: http://127.0.0.1:8000

## Login Credentials

### Admin Panel
- **URL**: http://127.0.0.1:8000/admin/login
- **Email**: `admin@insurance.com`
- **Password**: `password`

### User Access
- **URL**: http://127.0.0.1:8000/register
- Register a new account to purchase policies.

## Features Implemented
- **Landing Page**: View insurance categories.
- **User Dashboard**: Manage policies, file claims, renew policies.
- **Admin Panel**: Manage categories and plans.
- **Claims & Renewals**: Full flows implemented.
