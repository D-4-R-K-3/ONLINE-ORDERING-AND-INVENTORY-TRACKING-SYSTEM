# REST API Documentation

## Base URL
```
http://localhost/TA3-OOITS/public/api
```

## Authentication
Some endpoints require authentication via CodeIgniter session.

## Response Format
All responses are in JSON format with the following structure:

**Success Response**:
```json
{
  "success": true,
  "data": {},
  "message": "Operation successful"
}
```

**Error Response**:
```json
{
  "success": false,
  "message": "Error description"
}
```

---

## Products Endpoints

### Get All Products
Retrieve a paginated list of available products.

**Endpoint**: `GET /api/products`

**Query Parameters**:
- `page` (int, default: 1) - Page number
- `q` (string, optional) - Search keyword
- `category` (int, optional) - Filter by category ID

**Example Request**:
```bash
curl "http://localhost/TA3-OOITS/public/api/products?page=1&q=wireless"
```

**Response** (200 OK):
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "category_id": 1,
      "name": "Wireless Headphones",
      "description": "High-quality wireless headphones",
      "sku": "ELEC-001",
      "price": "45.99",
      "cost": "25.00",
      "image": "image.jpg",
      "status": "Available",
      "category_name": "Electronics",
      "quantity_available": 45
    }
  ],
  "total": 15,
  "page": 1,
  "per_page": 20,
  "total_pages": 1
}
```

---

### Get Single Product
Retrieve detailed information about a specific product.

**Endpoint**: `GET /api/products/:id`

**Path Parameters**:
- `id` (int, required) - Product ID

**Example Request**:
```bash
curl "http://localhost/TA3-OOITS/public/api/products/1"
```

**Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "id": 1,
    "category_id": 1,
    "name": "Wireless Headphones",
    "description": "High-quality wireless headphones with noise cancellation",
    "sku": "ELEC-001",
    "price": "45.99",
    "cost": "25.00",
    "image": "wireless-headphones.jpg",
    "status": "Available",
    "category_name": "Electronics",
    "quantity_on_hand": 50,
    "quantity_reserved": 5,
    "quantity_available": 45,
    "reorder_level": 10,
    "alert_status": "Normal"
  }
}
```

**Error Response** (404 Not Found):
```json
{
  "success": false,
  "message": "Product not found"
}
```

---

## Categories Endpoints

### Get All Categories
Retrieve list of all active product categories.

**Endpoint**: `GET /api/categories`

**Example Request**:
```bash
curl "http://localhost/TA3-OOITS/public/api/categories"
```

**Response** (200 OK):
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Electronics",
      "description": "Electronic gadgets and devices",
      "status": "Active"
    },
    {
      "id": 2,
      "name": "Clothing",
      "description": "Apparel and fashion items",
      "status": "Active"
    }
  ]
}
```

---

## Orders Endpoints (Authentication Required)

### Get Customer Orders
Retrieve paginated list of orders for authenticated customer.

**Endpoint**: `GET /api/orders`

**Authentication**: Required (Session cookie)

**Query Parameters**:
- `page` (int, default: 1) - Page number

**Example Request**:
```bash
curl -b "PHPSESSID=session_id" "http://localhost/TA3-OOITS/public/api/orders"
```

**Response** (200 OK):
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "customer_id": 3,
      "order_number": "ORD-20250509001",
      "order_date": "2025-05-09 14:30:00",
      "delivery_address": "123 Main Street, City",
      "total_items": 2,
      "subtotal": "80.98",
      "tax_amount": "6.48",
      "shipping_fee": "5.00",
      "total_amount": "92.46",
      "status": "Processing",
      "payment_status": "Paid"
    }
  ],
  "total": 5,
  "page": 1,
  "per_page": 10
}
```

**Error Response** (401 Unauthorized):
```json
{
  "success": false,
  "message": "Unauthorized"
}
```

---

### Get Order Details
Retrieve full details of a specific order including items.

**Endpoint**: `GET /api/orders/:id`

**Authentication**: Required

**Path Parameters**:
- `id` (int, required) - Order ID

**Example Request**:
```bash
curl -b "PHPSESSID=session_id" "http://localhost/TA3-OOITS/public/api/orders/1"
```

**Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "order": {
      "id": 1,
      "customer_id": 3,
      "order_number": "ORD-20250509001",
      "order_date": "2025-05-09 14:30:00",
      "delivery_address": "123 Main Street, City",
      "total_items": 2,
      "subtotal": "80.98",
      "tax_amount": "6.48",
      "shipping_fee": "5.00",
      "total_amount": "92.46",
      "status": "Processing",
      "payment_status": "Paid"
    },
    "items": [
      {
        "id": 1,
        "order_id": 1,
        "product_id": 1,
        "quantity": 1,
        "unit_price": "45.99",
        "total_price": "45.99",
        "name": "Wireless Headphones",
        "sku": "ELEC-001"
      },
      {
        "id": 2,
        "order_id": 1,
        "product_id": 3,
        "quantity": 2,
        "unit_price": "19.99",
        "total_price": "39.98",
        "name": "Cotton T-Shirt",
        "sku": "CLOT-001"
      }
    ]
  }
}
```

---

### Create Order
Create a new order with items.

**Endpoint**: `POST /api/orders`

**Authentication**: Required

**Request Body**:
```json
{
  "items": [
    {
      "product_id": 1,
      "quantity": 1,
      "price": 45.99
    },
    {
      "product_id": 3,
      "quantity": 2,
      "price": 19.99
    }
  ],
  "delivery_address": "123 Main Street, City",
  "shipping_fee": 5.00
}
```

**Example Request**:
```bash
curl -X POST -b "PHPSESSID=session_id" \
  -H "Content-Type: application/json" \
  -d '{
    "items": [{"product_id": 1, "quantity": 1, "price": 45.99}],
    "delivery_address": "123 Main Street"
  }' \
  "http://localhost/TA3-OOITS/public/api/orders"
```

**Response** (201 Created):
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "order_id": 5
  }
}
```

**Error Responses**:

400 Bad Request:
```json
{
  "success": false,
  "message": "Items array is required"
}
```

401 Unauthorized:
```json
{
  "success": false,
  "message": "Unauthorized"
}
```

---

## Inventory Endpoints (Admin/Staff Only)

### Get Inventory List
Retrieve paginated inventory list.

**Endpoint**: `GET /api/inventory`

**Authentication**: Required (Admin or Staff role)

**Query Parameters**:
- `page` (int, default: 1) - Page number

**Example Request**:
```bash
curl -b "PHPSESSID=session_id" "http://localhost/TA3-OOITS/public/api/inventory"
```

**Response** (200 OK):
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "product_id": 1,
      "quantity_on_hand": 50,
      "quantity_reserved": 5,
      "quantity_available": 45,
      "reorder_level": 10,
      "reorder_quantity": 50,
      "alert_status": "Normal",
      "name": "Wireless Headphones",
      "sku": "ELEC-001"
    }
  ],
  "total": 8,
  "page": 1,
  "per_page": 20
}
```

---

### Get Inventory Details
Retrieve detailed inventory information for a specific item.

**Endpoint**: `GET /api/inventory/:id`

**Authentication**: Required (Admin or Staff role)

**Path Parameters**:
- `id` (int, required) - Inventory ID

**Example Request**:
```bash
curl -b "PHPSESSID=session_id" "http://localhost/TA3-OOITS/public/api/inventory/1"
```

**Response** (200 OK):
```json
{
  "success": true,
  "data": {
    "id": 1,
    "product_id": 1,
    "quantity_on_hand": 50,
    "quantity_reserved": 5,
    "quantity_available": 45,
    "reorder_level": 10,
    "reorder_quantity": 50,
    "alert_status": "Normal",
    "last_restock_date": "2025-05-09 10:00:00",
    "name": "Wireless Headphones",
    "sku": "ELEC-001",
    "price": "45.99"
  }
}
```

---

## HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | OK - Request successful |
| 201 | Created - Resource created successfully |
| 400 | Bad Request - Invalid parameters |
| 401 | Unauthorized - Authentication required |
| 403 | Forbidden - Access denied |
| 404 | Not Found - Resource not found |
| 500 | Internal Server Error - Server error |

---

## Error Handling

All errors include a meaningful message:

```json
{
  "success": false,
  "message": "Specific error description"
}
```

---

## Rate Limiting

Currently not implemented. Recommended for production.

---

## Testing with Postman

### Setup
1. Import collection from Postman Collection v2.1 format
2. Set variable: `base_url = http://localhost/TA3-OOITS/public`
3. Get session from login endpoint

### Example Flow
1. POST /auth/login → Get session
2. GET /api/categories
3. GET /api/products?category=1
4. POST /api/orders → Create order
5. GET /api/orders → View orders

---

## SDK Example (JavaScript)

```javascript
const API_BASE = 'http://localhost/TA3-OOITS/public/api';

// Get products
async function getProducts(page = 1, search = '') {
  const params = new URLSearchParams({ page, q: search });
  const response = await fetch(`${API_BASE}/products?${params}`);
  return await response.json();
}

// Get product details
async function getProduct(id) {
  const response = await fetch(`${API_BASE}/products/${id}`);
  return await response.json();
}

// Create order (requires auth)
async function createOrder(items, address) {
  const response = await fetch(`${API_BASE}/orders`, {
    method: 'POST',
    credentials: 'include',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      items,
      delivery_address: address
    })
  });
  return await response.json();
}

// Usage
getProducts(1, 'wireless').then(data => console.log(data));
```

---

## Future Enhancements

1. OAuth 2.0 authentication
2. API key-based access
3. Rate limiting
4. Webhook support
5. GraphQL endpoint
6. API versioning
7. Request logging
8. Analytics tracking
