# Online Ordering and Inventory Tracking System

## Project Overview
A complete CodeIgniter 4-based web application for managing online orders and inventory tracking with admin dashboard, customer portal, and advanced features.

## Features

### Core Features ✓
- **User Authentication**: Secure login/register with password hashing
- **Role-Based Access Control**: Admin, Staff, and Customer roles
- **Product Management**: Full CRUD operations with image uploads
- **Category Management**: Organize products by categories
- **Inventory Tracking**: Real-time stock management with alerts
- **Order Management**: Complete order lifecycle management
- **Shopping Cart**: Add/remove products with quantity management
- **Checkout Process**: Complete order checkout with validation
- **Order History**: Track order status and details

### Advanced Features ✓
- **Search & Pagination**: Product and order search with filtering
- **Analytics Dashboard**: Sales and inventory reports with charts
- **Inventory Alerts**: Low stock and out-of-stock notifications
- **Audit Trail**: Complete inventory transaction history
- **REST API**: Comprehensive API endpoints for integration
- **Email Notifications**: Order confirmations and alerts
- **File Upload**: Product image management
- **Responsive Design**: Bootstrap 5 mobile-friendly UI

### Security Features ✓
- **Password Hashing**: BCrypt password encryption
- **CSRF Protection**: All forms have CSRF tokens
- **XSS Prevention**: All output is escaped
- **SQL Injection Prevention**: Parameterized queries
- **Input Validation**: All inputs validated on server-side
- **Session Management**: Secure session handling

## Technology Stack
- **Backend**: CodeIgniter 4 Framework
- **Language**: PHP 8+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **JavaScript**: jQuery, Chart.js
- **API**: RESTful API with JSON responses

## Installation

### Prerequisites
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- XAMPP or similar local development environment

### Setup Steps

1. **Navigate to project directory**:
   ```bash
   cd C:\xampp\htdocs\TA3-OOITS
   ```

2. **Create required directories**:
   ```bash
   mkdir "app\Views\auth"
   mkdir "app\Views\admin"
   mkdir "app\Views\layouts"
   mkdir "app\Views\shop"
   mkdir "app\Controllers\Api"
   mkdir "public\uploads\products"
   ```

3. **Configure environment**:
   - Copy `env` to `.env`
   - Update database settings:
     ```
     DB_DATABASE=online_ordering_db
     DB_USERNAME=root
     DB_PASSWORD=
     DB_HOSTNAME=localhost
     ```
   - Set base URL:
     ```
     APP_BASEURL=http://localhost/TA3-OOITS/public/
     ```

4. **Setup Database**:
   - Open phpMyAdmin
   - Create database: `online_ordering_db`
   - Import `database_setup.sql` file
   - Verify sample data is loaded

5. **Start Application**:
   ```bash
   php spark serve
   ```
   Access at: `http://localhost:8080`

## Test Credentials

### Admin Account
- **Username**: admin
- **Password**: admin123

### Staff Account
- **Username**: staff
- **Password**: staff123

### Customer Account
- **Username**: customer
- **Password**: customer123

## Application Routes

### Public Routes
- `/` - Home/Shop page
- `/auth/login` - Login page
- `/auth/register` - Registration page
- `/shop` - Product catalog
- `/shop/search` - Search products
- `/shop/category/:id` - View category
- `/shop/product/:id` - Product details

### Customer Routes (Authenticated)
- `/shop/cart` - Shopping cart
- `/shop/checkout` - Checkout
- `/shop/my-orders` - Order history
- `/shop/order/:id` - Order details
- `/auth/profile` - User profile
- `/auth/change-password` - Change password

### Admin/Staff Routes (Role-based)
- `/dashboard` - Main dashboard
- `/dashboard/products` - Manage products
- `/dashboard/inventory` - Manage inventory
- `/dashboard/orders` - Manage orders
- `/dashboard/reports/sales` - Sales reports
- `/dashboard/reports/inventory` - Inventory reports

## REST API Endpoints

### Products
- `GET /api/products` - List products
- `GET /api/products/:id` - Get product details
- `GET /api/categories` - List categories

### Orders (Requires Authentication)
- `GET /api/orders` - Customer's orders
- `GET /api/orders/:id` - Order details
- `POST /api/orders` - Create order

### Inventory (Admin/Staff Only)
- `GET /api/inventory` - List inventory
- `GET /api/inventory/:id` - Inventory details

## Database Schema

### Tables (7 total)

1. **users** - User accounts
   - id, username, email, password, first_name, last_name, phone, address, role, status

2. **categories** - Product categories
   - id, name, description, status

3. **products** - Product catalog
   - id, category_id, name, description, sku, price, cost, image, status

4. **inventory** - Stock management
   - id, product_id, quantity_on_hand, quantity_reserved, quantity_available, reorder_level, reorder_quantity, alert_status

5. **orders** - Customer orders
   - id, customer_id, order_number, order_date, delivery_address, total_items, subtotal, tax_amount, shipping_fee, total_amount, status, payment_status

6. **order_items** - Order line items
   - id, order_id, product_id, quantity, unit_price, total_price

7. **inventory_history** - Stock transaction audit trail
   - id, product_id, transaction_type, quantity_change, quantity_before, quantity_after, reference_id, notes, created_by

## Project Structure

```
TA3-OOITS/
├── app/
│   ├── Controllers/
│   │   ├── Auth.php
│   │   ├── Shop.php
│   │   ├── Dashboard.php
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
│   │   ├── shop/
│   │   ├── admin/
│   │   └── layouts/
│   ├── Filters/
│   │   ├── AuthFilter.php
│   │   └── RoleFilter.php
│   ├── Database/
│   │   └── Migrations/
│   └── Config/
│       ├── Routes.php
│       ├── Filters.php
│       └── Database.php
├── public/
│   ├── index.php
│   ├── uploads/
│   │   └── products/
│   └── setup.php
├── database_setup.sql
├── SETUP_INSTRUCTIONS.php
└── README.md
```

## Key Controllers

### Auth Controller
Handles user authentication:
- Login with email or username
- User registration with validation
- Profile management
- Password changes
- Session management

### Shop Controller
Customer-facing shopping features:
- Product browsing and search
- Category filtering
- Shopping cart management
- Checkout process
- Order confirmation
- Order history

### Dashboard Controller
Admin/Staff management features:
- Sales dashboard with analytics
- Product management (CRUD)
- Inventory management
- Order management
- Reports (sales, inventory)
- Low stock alerts

### API Controllers
RESTful API endpoints for external integration:
- Product information
- Category listing
- Order management
- Inventory status

## Models

All models implement:
- CRUD operations
- Input validation
- Relationships
- Query helpers
- Business logic

### Key Methods

**ProductModel**:
- `getAvailableProducts()` - Active products
- `searchProducts($keyword)` - Search functionality
- `getProductByCategory($id)` - Category filtering
- `getBySku($sku)` - SKU lookup

**InventoryModel**:
- `getLowStockProducts()` - Stock alerts
- `getOutOfStockProducts()` - Out of stock items
- `updateStockByProduct()` - Stock updates
- `getInventoryStats()` - Analytics

**OrderModel**:
- `generateOrderNumber()` - Order numbering
- `getCustomerOrders()` - Customer history
- `getOrdersByStatus()` - Status filtering
- `getOrderStats()` - Statistics

## Filters

### AuthFilter
Ensures user is logged in before accessing protected routes.

### RoleFilter
Validates user role has access to route:
- Can specify required roles
- Redirects unauthorized users
- Supports multiple roles per route

## Security Implementation

### CSRF Protection
All POST forms include CSRF tokens via `csrf_field()`.

### XSS Prevention
All output escaped using CodeIgniter's escaping functions:
- `esc()` for HTML context
- `json_encode()` for JSON responses

### SQL Injection Prevention
All queries use parameterized placeholders:
- Model methods use proper parameter binding
- No string concatenation in queries

### Password Security
- Passwords hashed using BCrypt
- Hash verification with `password_verify()`
- No plain text storage

### Input Validation
Server-side validation rules for all inputs:
- Type checking
- Length restrictions
- Format validation
- Custom validation rules

## Testing

### Test Cases Included

1. **User Authentication**
   - Login with valid credentials
   - Login with invalid credentials
   - Registration with validation
   - Session management

2. **Product Management**
   - Add product with image
   - Edit product details
   - Delete product with cascade
   - Search functionality

3. **Inventory Operations**
   - Update stock quantities
   - Verify low stock alerts
   - Check inventory history
   - Stock calculations

4. **Order Processing**
   - Create order from cart
   - Update order status
   - Calculate totals with tax
   - Order history retrieval

5. **API Integration**
   - Product endpoints
   - Order management
   - Inventory queries
   - Error handling

## API Documentation

### Product Endpoints

**List Products**
```
GET /api/products?page=1&q=search&category=1
Response: Array of products with pagination
```

**Get Product**
```
GET /api/products/1
Response: Single product with inventory details
```

### Category Endpoints

**List Categories**
```
GET /api/categories
Response: Array of active categories
```

### Order Endpoints (Auth Required)

**List Orders**
```
GET /api/orders?page=1
Response: Customer's orders with pagination
```

**Get Order**
```
GET /api/orders/1
Response: Order details with line items
```

**Create Order**
```
POST /api/orders
Body: { items: [], delivery_address: "" }
Response: Created order details
```

## Performance Optimization

### Database
- Proper indexing on frequently queried columns
- Query optimization in models
- Eager loading of relationships

### Caching
- Session caching for user data
- Query result caching

### File Uploads
- Image validation
- Size restrictions
- Organized storage

## Deployment

### Pre-deployment Checklist
- [ ] .env configured for production
- [ ] Database migrated/imported
- [ ] Uploads directory permissions set
- [ ] CSRF protection enabled
- [ ] Security headers configured
- [ ] Error logging configured

### Production Setup
- Use environment variables for secrets
- Enable HTTPS
- Set proper database backups
- Configure email notifications
- Enable application logging

## Support & Documentation

For more information:
- See SETUP_INSTRUCTIONS.php for detailed setup
- Check individual controller files for method documentation
- Review Models for business logic
- Use Postman collection for API testing

## License
MIT License - Terminal Assessment 3 Project

## Author
Advanced Web Development Course - PC21
