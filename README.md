# Cindy's Bakeshop

## Project Purpose
Cindy's Bakeshop is a simple web application for managing an online bakery. It
includes pages for customers to browse and order products as well as an
administrative interface for managing inventory, orders and deliveries.

## Required PHP Setup
- **PHP 8** or higher with the PDO MySQL extension enabled
- **MySQL/MariaDB** server
- A web server such as Apache/Nginx (or PHP's built-in server for testing)

## Directory Structure
- `Database/` – SQL dump (`cindys_bakeshop.sql`) for the database
- `PHP/` – reusable PHP scripts that implement database functions
- `adminSide/` – main administrator dashboard pages
- `user-cindysbakeshop/` – customer‑facing pages
- `Admin Cindys/`, `UpdatedUser/`, `UpdatedUser1/` – legacy/alternate versions

## Importing the SQL Dump
1. Create a database named `cindysdb` in your MySQL server.
2. Import the dump using phpMyAdmin or the command line:
   ```sh
   mysql -u root -p cindysdb < Database/cindys_bakeshop.sql
   ```
   Adjust the credentials or database name as needed.

## PHP Backend Location
The PHP backend lives in the `PHP/` directory. `db_connect.php` contains the
connection settings and other files provide functions for users, orders,
products and more. Update the credentials in that file to match your local
setup.

You can place the repository in your web server's document root and browse the
HTML pages or start a local server with:
```sh
php -S localhost:8000
```

