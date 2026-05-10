<?php
/**
 * SETUP INSTRUCTIONS FOR ONLINE ORDERING AND INVENTORY SYSTEM
 * 
 * This project is built with CodeIgniter 4 and provides a complete
 * online ordering and inventory management system.
 */

/*
STEP 1: CREATE REQUIRED DIRECTORIES
====================================
Open Command Prompt (cmd) and run these commands:

mkdir "c:\xampp\htdocs\TA3-OOITS\app\Views\auth"
mkdir "c:\xampp\htdocs\TA3-OOITS\app\Views\admin"
mkdir "c:\xampp\htdocs\TA3-OOITS\app\Views\layouts"
mkdir "c:\xampp\htdocs\TA3-OOITS\app\Views\shop"
mkdir "c:\xampp\htdocs\TA3-OOITS\app\Controllers\Api"
mkdir "c:\xampp\htdocs\TA3-OOITS\public\uploads\products"

STEP 2: CREATE DATABASE
=======================
Use phpMyAdmin or MySQL Command Line:
1. Create a database: CREATE DATABASE online_ordering_db;
2. Use the database: USE online_ordering_db;
3. Import the database_setup.sql file to populate all tables and sample data

STEP 3: CONFIGURE THE APPLICATION
==================================
1. Copy 'env' file to '.env' file
2. Update database configuration in .env:
   - DB_DATABASE=online_ordering_db
   - DB_USERNAME=root
   - DB_PASSWORD= (leave empty or your password)
   - DB_HOSTNAME=localhost

3. Set the application's base URL:
   - APP_BASEURL=http://localhost/TA3-OOITS/public/

STEP 4: RUN MIGRATIONS (optional if using database_setup.sql)
=============================================================
If not using database_setup.sql, run:
php spark migrate

STEP 5: COPY VIEW FILES
=======================
Due to directory creation constraints, view files are compiled in the 
VIEWS_SETUP.md file. Follow that file to create all necessary view files.

STEP 6: START THE DEVELOPMENT SERVER
=====================================
Run: php spark serve
Then access: http://localhost:8080

TESTING CREDENTIALS
===================
After running database_setup.sql, use these credentials:

Admin Account:
- Username: admin
- Password: admin123

Staff Account:
- Username: staff
- Password: staff123

Customer Account:
- Username: customer
- Password: customer123

FEATURES IMPLEMENTED
====================
✓ User Authentication (Login/Register/Logout)
✓ Role-Based Access Control (Admin, Staff, Customer)
✓ Product Management (CRUD operations)
✓ Category Management
✓ Inventory Tracking
✓ Order Management
✓ Shopping Cart
✓ Checkout Process
✓ Order Status Tracking
✓ Search & Pagination
✓ Sales Reports & Analytics
✓ Low Stock Alerts
✓ Inventory History/Audit Trail
✓ REST API Endpoints
✓ Bootstrap 5 Responsive UI
✓ Input Validation
✓ CSRF Protection
✓ Password Hashing (BCrypt)

API ENDPOINTS
=============
GET /api/products - List all products
GET /api/products/:id - Get product details
GET /api/categories - List categories
GET /api/orders (auth required) - Customer's orders
POST /api/orders (auth required) - Create order
GET /api/inventory (admin/staff only) - View inventory
GET /api/inventory/:id (admin/staff only) - View inventory details

PROJECT STRUCTURE
=================
app/
  ├── Controllers/
  │   ├── Auth.php (Authentication)
  │   ├── Shop.php (Shopping/Customer functions)
  │   ├── Dashboard.php (Admin/Staff dashboard)
  │   └── Api/ (REST API controllers)
  ├── Models/ (Database models)
  ├── Views/
  │   ├── auth/ (Login/Register forms)
  │   ├── shop/ (Customer pages)
  │   ├── admin/ (Admin dashboard pages)
  │   └── layouts/ (Master layout)
  ├── Filters/ (Auth & Role filters)
  └── Database/
      └── Migrations/ (Database tables)
public/
  ├── uploads/ (Product images)
  └── index.php

KEY FILES
=========
- database_setup.sql - Complete database schema with sample data
- app/Config/Routes.php - Application routes
- app/Config/Filters.php - Filter configuration
- .env - Environment configuration (copy from env file)

DATABASE TABLES
===============
1. users - User accounts with roles
2. categories - Product categories
3. products - Product catalog
4. inventory - Stock management
5. orders - Customer orders
6. order_items - Order line items
7. inventory_history - Stock transaction history

SECURITY FEATURES
=================
✓ Password hashing with BCrypt
✓ CSRF token protection
✓ XSS prevention via escaping
✓ SQL injection prevention (parameterized queries)
✓ Input validation on all forms
✓ Role-based access control
✓ Session management
✓ Secure file uploads

TESTING INSTRUCTIONS
====================
1. Test Login: Use the credentials above
2. Test Product Browsing: Browse categories and search products
3. Test Shopping: Add products to cart and checkout
4. Test Admin Functions: Manage products, inventory, and orders
5. Test Reports: View sales and inventory reports
6. Test API: Use Postman or similar tool to test API endpoints

TROUBLESHOOTING
===============
Q: "Page not found" error
A: Ensure the .htaccess file is working and mod_rewrite is enabled

Q: Database connection error
A: Check your .env file database configuration

Q: 403 Forbidden on uploads
A: Ensure public/uploads/products has write permissions (chmod 755)

Q: Missing view files
A: Create directories and copy view files as per VIEWS_SETUP.md

DOCUMENTATION FILES
===================
- README.md - Project overview
- database_setup.sql - Database schema
- SETUP_INSTRUCTIONS.md - This file
- VIEWS_SETUP.md - View file creation instructions
- API_DOCUMENTATION.md - REST API documentation
- TEST_CASES.md - Test case documentation

*/
?>
