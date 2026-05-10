<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home
$routes->get('/', 'Shop::index');

// Authentication Routes
$routes->group('auth', static function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('logout', 'Auth::logout');
    $routes->get('profile', 'Auth::profile', ['filter' => 'auth']);
    $routes->post('update-profile', 'Auth::updateProfile', ['filter' => 'auth']);
    $routes->get('change-password', 'Auth::changePassword', ['filter' => 'auth']);
    $routes->post('change-password', 'Auth::changePassword', ['filter' => 'auth']);
});

// Shop Routes
$routes->group('shop', static function ($routes) {
    $routes->get('/', 'Shop::index');
    $routes->get('category/(:num)', 'Shop::category/$1');
    $routes->get('search', 'Shop::search');
    $routes->get('product/(:num)', 'Shop::product/$1');
    $routes->get('cart', 'Shop::cart', ['filter' => 'auth']);
    $routes->post('add-to-cart', 'Shop::addToCart', ['filter' => 'auth']);
    $routes->post('remove-from-cart', 'Shop::removeFromCart', ['filter' => 'auth']);
    $routes->get('checkout', 'Shop::checkout', ['filter' => 'auth']);
    $routes->post('process-order', 'Shop::processOrder', ['filter' => 'auth']);
    $routes->get('order-confirmation/(:num)', 'Shop::orderConfirmation/$1', ['filter' => 'auth']);
    $routes->get('my-orders', 'Shop::myOrders', ['filter' => 'auth']);
    $routes->get('order/(:num)', 'Shop::orderDetails/$1', ['filter' => 'auth']);
});

// Admin Dashboard Routes
$routes->group('dashboard', ['filter' => 'role:Admin,Staff'], static function ($routes) {
    $routes->get('/', 'Dashboard::index');
    
    // Products
    $routes->get('products', 'Dashboard::products');
    $routes->get('products/(:num)', 'Dashboard::products/$1');
    $routes->get('product/add', 'Dashboard::addProduct');
    $routes->post('product/add', 'Dashboard::addProduct');
    $routes->get('product/edit/(:num)', 'Dashboard::editProduct/$1');
    $routes->post('product/edit/(:num)', 'Dashboard::editProduct/$1');
    $routes->get('product/delete/(:num)', 'Dashboard::deleteProduct/$1');
    
    // Inventory
    $routes->get('inventory', 'Dashboard::inventory');
    $routes->get('inventory/(:num)', 'Dashboard::inventory/$1');
    $routes->get('inventory/update/(:num)', 'Dashboard::updateInventory/$1');
    $routes->post('inventory/update/(:num)', 'Dashboard::updateInventory/$1');
    $routes->get('inventory/low-stock', 'Dashboard::lowStock');
    
    // Orders
    $routes->get('orders', 'Dashboard::orders');
    $routes->get('orders/(:num)', 'Dashboard::orders/$1');
    $routes->get('order/(:num)', 'Dashboard::viewOrder/$1');
    $routes->get('order/status/(:num)', 'Dashboard::updateOrderStatus/$1');
    $routes->post('order/status/(:num)', 'Dashboard::updateOrderStatus/$1');
    
    // Reports
    $routes->get('reports/sales', 'Dashboard::salesReport');
    $routes->get('reports/inventory', 'Dashboard::inventoryReport');
});

// REST API Routes
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->get('products', 'ApiProduct::index');
    $routes->get('products/(:num)', 'ApiProduct::show/$1');
    $routes->get('categories', 'ApiCategory::index');
    $routes->get('orders', 'ApiOrder::index', ['filter' => 'auth']);
    $routes->get('orders/(:num)', 'ApiOrder::show/$1', ['filter' => 'auth']);
    $routes->post('orders', 'ApiOrder::create', ['filter' => 'auth']);
    $routes->get('inventory', 'ApiInventory::index', ['filter' => 'role:Admin,Staff']);
    $routes->get('inventory/(:num)', 'ApiInventory::show/$1', ['filter' => 'role:Admin,Staff']);
});
