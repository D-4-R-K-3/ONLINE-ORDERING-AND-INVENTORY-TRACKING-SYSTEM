# Complete Installation and Setup Guide

## Online Ordering and Inventory Tracking System
**Terminal Assessment 3 Project**  
**CodeIgniter 4 Framework**  
**Advanced Web Development Course**

---

## TABLE OF CONTENTS
1. [Prerequisites](#prerequisites)
2. [Quick Setup](#quick-setup)
3. [Manual Setup](#manual-setup)
4. [Database Configuration](#database-configuration)
5. [Directory Structure](#directory-structure)
6. [Testing the Application](#testing-the-application)
7. [Troubleshooting](#troubleshooting)
8. [Features Overview](#features-overview)

---

## PREREQUISITES

### System Requirements
- **Windows 10/11** or equivalent
- **PHP 8.2+** (included in XAMPP)
- **MySQL 5.7+** or **MariaDB 10.3+**
- **XAMPP Server** (Apache, PHP, MySQL bundled)
- **Text Editor** (VS Code, Sublime Text, etc.)
- **Web Browser** (Chrome, Firefox, Edge)
- **Git** (optional, for version control)

### Software Installation
1. Download and install **XAMPP** from: https://www.apachefriends.org/
2. Start XAMPP Control Panel and enable:
   - Apache (Web Server)
   - MySQL (Database)
3. Ensure ports are available (80 for Apache, 3306 for MySQL)

---

## QUICK SETUP

### Step 1: Navigate to Project Directory
```bash
cd C:\xampp\htdocs\TA3-OOITS
```

### Step 2: Create Required Directories
Open **Command Prompt** and run:
```batch
mkdir "app\Views\auth"
mkdir "app\Views\admin"
mkdir "app\Views\layouts"
mkdir "app\Views\shop"
mkdir "app\Controllers\Api"
mkdir "public\uploads\products"
```

### Step 3: Configure Environment
```bash
copy env .env
```

Edit `.env` file with your settings:
```ini
CI_ENVIRONMENT = development

DB_DEFAULT_GROUP = default

DB_DEFAULT_HOSTNAME = localhost
DB_DEFAULT_DATABASE = online_ordering_db
DB_DEFAULT_USERNAME = root
DB_DEFAULT_PASSWORD = 

APP_BASEURL = http://localhost/TA3-OOITS/public/

app.indexPage = 
```

### Step 4: Setup Database

#### Option A: Using phpMyAdmin (Recommended for beginners)
1. Open http://localhost/phpmyadmin
2. Click "Databases" tab
3. Create new database: `online_ordering_db`
4. Select the new database
5. Go to "Import" tab
6. Upload `database_setup.sql` file
7. Click "Import"

#### Option B: Using MySQL Command Line
```bash
mysql -u root -p < database_setup.sql
```
When prompted for password, press Enter (if no password set).

### Step 5: Start Development Server
```bash
php spark serve
```

Application will be available at: **http://localhost:8080**

---

## MANUAL SETUP

### Step 1: Copy Project Files
```bash
# Navigate to project
cd C:\xampp\htdocs\TA3-OOITS

# Install dependencies (if not already done)
composer install
```

### Step 2: Update Configuration Files

#### config/.env
```ini
# Database configuration
DB_DEFAULT_HOSTNAME = localhost
DB_DEFAULT_DATABASE = online_ordering_db
DB_DEFAULT_USERNAME = root
DB_DEFAULT_PASSWORD = 

# Application URL
APP_BASEURL = http://localhost/TA3-OOITS/public/

# Environment
CI_ENVIRONMENT = development

# Session configuration
session.savePath = "writable/session"
```

#### config/App.php
Update if needed:
```php
public $baseURL = 'http://localhost/TA3-OOITS/public/';
public $indexPage = '';
```

### Step 3: Create Database Schema

#### Create Database
```sql
CREATE DATABASE online_ordering_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE online_ordering_db;
```

#### Import Schema
Use the provided `database_setup.sql` file which includes:
- Table creation scripts
- Foreign key relationships
- Indexes
- Sample data

### Step 4: Run Migrations (Optional)
If not using SQL import:
```bash
php spark migrate
```

### Step 5: Verify Installation
1. Access http://localhost/TA3-OOITS/public/
2. Should see home page or redirect to shop
3. Test login with sample credentials

---

## DATABASE CONFIGURATION

### Database Connection String
```
Server: localhost
Port: 3306
Database: online_ordering_db
Username: root
Password: (empty or your password)
```

### Tables Created
| Table | Purpose |
|-------|---------|
| users | User accounts and authentication |
| categories | Product categories |
| products | Product catalog |
| inventory | Stock management |
| orders | Customer orders |
| order_items | Order line items |
| inventory_history | Audit trail for stock changes |

### Sample Data Included
- 1 Admin user
- 1 Staff user
- 2 Customer accounts
- 5 Product categories
- 8 Sample products
- 1 Sample order

### User Accounts for Testing

| Role | Username | Password | Email |
|------|----------|----------|-------|
| Admin | admin | admin123 | admin@example.com |
| Staff | staff | staff123 | staff@example.com |
| Customer | customer | customer123 | customer@example.com |
| Customer | customer2 | customer123 | customer2@example.com |

---

## DIRECTORY STRUCTURE

```
TA3-OOITS/
├── app/
│   ├── Config/
│   │   ├── Routes.php ...................... Application routes
│   │   ├── Filters.php ..................... Filter configuration
│   │   └── Database.php .................... Database settings
│   ├── Controllers/
│   │   ├── Auth.php ....................... Authentication
│   │   ├── Shop.php ....................... Customer shopping
│   │   ├── Dashboard.php ................. Admin dashboard
│   │   └── Api/
│   │       ├── ApiProduct.php
│   │       ├── ApiOrder.php
│   │       ├── ApiCategory.php
│   │       └── ApiInventory.php
│   ├── Models/
│   │   ├── UserModel.php
│   │   ├── ProductModel.php
│   │   ├── CategoryModel.php
│   │   ├── InventoryModel.php
│   │   ├── OrderModel.php
│   │   ├── OrderItemModel.php
│   │   └── InventoryHistoryModel.php
│   ├── Views/
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   ├── register.php
│   │   │   ├── profile.php
│   │   │   └── change-password.php
│   │   ├── shop/
│   │   │   ├── index.php
│   │   │   ├── category.php
│   │   │   ├── search.php
│   │   │   ├── product.php
│   │   │   ├── cart.php
│   │   │   ├── checkout.php
│   │   │   ├── order-confirmation.php
│   │   │   ├── my-orders.php
│   │   │   └── order-details.php
│   │   ├── admin/
│   │   │   ├── dashboard.php
│   │   │   ├── products/
│   │   │   ├── inventory/
│   │   │   ├── orders/
│   │   │   └── reports/
│   │   └── layouts/
│   │       └── main.php ................... Master layout
│   ├── Filters/
│   │   ├── AuthFilter.php ................ Authentication filter
│   │   └── RoleFilter.php ................ Role-based access filter
│   └── Database/
│       ├── Migrations/
│       │   ├── CreateUsersTable.php
│       │   ├── CreateCategoriesTable.php
│       │   ├── CreateProductsTable.php
│       │   ├── CreateInventoryTable.php
│       │   ├── CreateOrdersTable.php
│       │   ├── CreateOrderItemsTable.php
│       │   └── CreateInventoryHistoryTable.php
│       └── Seeds/
├── public/
│   ├── index.php ......................... Application entry point
│   ├── setup.php ......................... Setup script
│   └── uploads/
│       └── products/ ..................... Product images
├── .env ................................. Environment configuration
├── .htaccess ............................ Apache rewrite rules
├── database_setup.sql ................... Database schema
├── composer.json ........................ PHP dependencies
├── README.md ............................ Project documentation
├── README_SYSTEM.md ..................... System documentation
├── API_DOCUMENTATION.md ................. REST API docs
├── TEST_CASES.md ........................ Test case documentation
└── SETUP_INSTRUCTIONS.php .............. Installation guide
```

---

## TESTING THE APPLICATION

### 1. Verify Installation
```
Access: http://localhost/TA3-OOITS/public/
Expected: Redirect to shop page or show products
```

### 2. Test Authentication
```
1. Click Login
2. Enter: admin / admin123
3. Verify: Redirected to dashboard
```

### 3. Test Shopping (as Customer)
```
1. Login: customer / customer123
2. Browse products
3. Search for products
4. Add to cart
5. Checkout and create order
6. View order in My Orders
```

### 4. Test Admin Functions
```
1. Login: admin / admin123
2. Navigate to /dashboard
3. Test product management (Add/Edit/Delete)
4. Test inventory updates
5. Test order management
6. View reports
```

### 5. Test API
Use Postman or curl:
```bash
# Get products
curl http://localhost/TA3-OOITS/public/api/products

# Get categories
curl http://localhost/TA3-OOITS/public/api/categories

# Get orders (requires auth)
curl -b "PHPSESSID=yoursession" http://localhost/TA3-OOITS/public/api/orders
```

---

## TROUBLESHOOTING

### Issue: "Page not found" error
**Solution**:
- Check .htaccess exists in public folder
- Enable mod_rewrite in Apache
- Verify APP_BASEURL in .env

### Issue: Database connection error
**Solution**:
- Verify MySQL is running (XAMPP Control Panel)
- Check .env database settings
- Ensure database exists: `online_ordering_db`

### Issue: 404 on admin pages
**Solution**:
- Verify you're logged in as admin/staff
- Check user role in database
- Clear browser cache

### Issue: Upload folder permissions error
**Solution**:
```bash
# Set permissions (Windows Command Prompt as Admin)
icacls "C:\xampp\htdocs\TA3-OOITS\public\uploads" /grant:r Everyone:(OI)(CI)F

# Or via XAMPP:
Right-click folder > Properties > Security > Edit > Add Everyone > Full Control
```

### Issue: Blank page or white screen
**Solution**:
- Check PHP error log: `writable/logs/`
- Enable CI debugging in .env: `CI_ENVIRONMENT = development`
- Check database connectivity

### Issue: Session not persisting
**Solution**:
- Verify session save path is writable
- Check .env session configuration
- Clear browser cookies

### Issue: File upload not working
**Solution**:
- Ensure `public/uploads/products/` exists and is writable
- Check file size limits in PHP.ini
- Verify file type restrictions

---

## FEATURES OVERVIEW

### User Roles and Permissions

**Customer**:
- Browse products
- Search and filter
- Add to cart
- Place orders
- View order history
- Update profile

**Staff**:
- All customer features
- Manage products
- Update inventory
- View all orders
- Update order status
- View reports

**Admin**:
- All staff features
- Delete products
- User management
- Advanced reporting
- System configuration

### Key Features

**Shopping System**:
- Product catalog with categories
- Advanced search
- Shopping cart
- Checkout with tax calculation
- Order tracking

**Inventory System**:
- Real-time stock tracking
- Low stock alerts
- Stock history
- Reorder management

**Admin Dashboard**:
- Sales analytics
- Inventory reports
- Order management
- Product management

**Security**:
- User authentication
- Role-based access
- CSRF protection
- Input validation
- Password hashing

**API**:
- RESTful endpoints
- JSON responses
- Pagination
- Error handling

---

## PERFORMANCE OPTIMIZATION

### Database
- Indexes on frequently used columns
- Optimized queries in models
- Relationship eager loading

### Caching
- Session caching
- Query result caching

### Frontend
- Minified CSS/JS
- Bootstrap CDN
- Chart.js for analytics

---

## BACKUP AND MAINTENANCE

### Database Backup
```bash
# Export database
mysqldump -u root online_ordering_db > backup.sql

# Import database
mysql -u root online_ordering_db < backup.sql
```

### Log Files
Located in: `writable/logs/`

### Session Cleanup
Files in: `writable/session/`

---

## NEXT STEPS

1. **Customize**: Edit styles in Bootstrap CSS
2. **Add Features**: Extend controllers and models
3. **Deploy**: Move to production hosting
4. **Monitor**: Set up error logging and alerts
5. **Backup**: Implement automated backups

---

## SUPPORT AND RESOURCES

- **CodeIgniter Docs**: https://codeigniter.com/user_guide/
- **Bootstrap Docs**: https://getbootstrap.com/docs/
- **MySQL Docs**: https://dev.mysql.com/doc/
- **PHP Docs**: https://www.php.net/manual/

---

## PROJECT DELIVERABLES

✓ Complete web application  
✓ Database schema and sample data  
✓ REST API with documentation  
✓ Comprehensive test cases  
✓ User documentation  
✓ Security features implemented  
✓ Responsive UI design  
✓ Ready for deployment  

---

**Created**: May 2025  
**Course**: Advanced Web Development (PC21)  
**Assessment**: Terminal Assessment 3 (TA3)  

