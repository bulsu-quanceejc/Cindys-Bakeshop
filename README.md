# Cindy's Bakeshop

## Overview
Cindy's Bakeshop is a lightweight PHP/MySQL application for running an online
bakery. Customers can register, browse products, place orders, and track
deliveries while administrators manage the catalogue and fulfilment.

### Features
- Product browsing with images and descriptions
- User registration and login
- Cart and order submission
- Administrative dashboard for inventory, orders and deliveries

## Requirements
- **PHP 8** or higher with the PDO MySQL extension enabled
- **MySQL/MariaDB** server
- A web server such as Apache/Nginx (or PHP's built-in server for testing)

## Directory Structure
- `Database/` – SQL dump (`cindys_bakeshop.sql`) for database schema and sample data
- `PHP/` – reusable PHP scripts that implement database functions
- `adminSide/` – administrator dashboard pages
- `user-cindysbakeshop/` – customer‑facing pages
- `Admin Cindys/`, `UpdatedUser/`, `UpdatedUser1/` – legacy/alternate versions kept for reference

## Installation
1. Create a database named `cindysdb` in your MySQL server.
2. Import the SQL dump using phpMyAdmin or the command line:
   ```sh
   mysql -u root -p cindysdb < Database/cindys_bakeshop.sql
   ```
   Adjust the credentials or database name as needed.
3. Update `PHP/db_connect.php` with your database credentials.

## Running Locally
Place the repository inside your web server's document root or start a local
development server:
```sh
php -S localhost:8000
```
- Browse the customer-facing site at `http://localhost:8000/user-cindysbakeshop`.
- Access the admin dashboard at `http://localhost:8000/adminSide`.

## Contributing
Pull requests are welcome. Please ensure that any modified PHP files pass
`php -l` for syntax errors before submitting changes.


