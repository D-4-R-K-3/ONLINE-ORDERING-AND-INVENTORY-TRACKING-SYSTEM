<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\InventoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\InventoryHistoryModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $userModel;
    protected $productModel;
    protected $categoryModel;
    protected $inventoryModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $historyModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->inventoryModel = new InventoryModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->historyModel = new InventoryHistoryModel();
        
        // Ensure view directories exist
        @mkdir(APPPATH . 'Views/admin/inventory', 0755, true);
        @mkdir(APPPATH . 'Views/admin/products', 0755, true);
        @mkdir(APPPATH . 'Views/admin/orders', 0755, true);
        @mkdir(APPPATH . 'Views/admin/reports', 0755, true);
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        if (!in_array(session()->get('role'), ['Admin', 'Staff'])) {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to('/');
        }

        $orderStats = $this->orderModel->getOrderStats();
        $inventoryStats = $this->inventoryModel->getInventoryStats();
        $recentOrders = $this->orderModel->getRecentOrders(5);
        $lowStockProducts = $this->inventoryModel->getLowStockProducts();
        $recentActivity = $this->historyModel->getRecentActivity(10);

        $data = [
            'title' => 'Dashboard',
            'orderStats' => $orderStats,
            'inventoryStats' => $inventoryStats,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'recentActivity' => $recentActivity,
            'totalUsers' => count($this->userModel->getActiveUsers()),
            'totalProducts' => count($this->productModel->getAvailableProducts()),
            'totalCategories' => count($this->categoryModel->getActiveCategories()),
        ];

        return view('admin/dashboard', $data);
    }

    // Product Management
    public function products($page = 1)
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        $perPage = 10;
        $products = $this->productModel->select('products.*, categories.name as category_name')
                                       ->join('categories', 'categories.id = products.category_id', 'left')
                                       ->orderBy('products.id', 'DESC')->paginate($perPage, 'default', $page);
        $pager = $this->productModel->pager;

        $data = [
            'title' => 'Products',
            'products' => $products,
            'pager' => $pager,
        ];

        return view('admin/products/index', $data);
    }

    public function addProduct()
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        if ($this->request->is('post')) {
            $rules = [
                'category_id' => 'required|integer',
                'name' => 'required|min_length[2]|max_length[150]',
                'sku' => 'required|min_length[2]|max_length[50]|is_unique[products.sku]',
                'price' => 'required|decimal',
                'cost' => 'permit_empty|decimal',
                'description' => 'permit_empty|string',
                'status' => 'required|in_list[Available,Discontinued]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $image = '';
            if ($file = $this->request->getFile('image')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . '../public/uploads/products', $newName);
                    $image = $newName;
                }
            }

            $data = [
                'category_id' => $this->request->getPost('category_id'),
                'name' => $this->request->getPost('name'),
                'sku' => $this->request->getPost('sku'),
                'price' => $this->request->getPost('price'),
                'cost' => $this->request->getPost('cost') ?? null,
                'description' => $this->request->getPost('description'),
                'image' => $image,
                'status' => $this->request->getPost('status'),
            ];

            if ($productId = $this->productModel->insert($data, true)) {
                // Create inventory record
                $this->inventoryModel->insert([
                    'product_id' => $productId,
                    'quantity_on_hand' => 0,
                    'quantity_reserved' => 0,
                    'quantity_available' => 0,
                    'reorder_level' => 10,
                    'reorder_quantity' => 50,
                ]);

                session()->setFlashdata('success', 'Product added successfully!');
                return redirect()->to('/dashboard/products');
            }

            session()->setFlashdata('error', 'Failed to add product.');
            return redirect()->back()->withInput();
        }

        $data = [
            'title' => 'Add Product',
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('admin/products/add', $data);
    }

    public function editProduct($productId = null)
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        if (!$productId) {
            return redirect()->to('/dashboard/products');
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        if ($this->request->is('post')) {
            $rules = [
                'category_id' => 'required|integer',
                'name' => 'required|min_length[2]|max_length[150]',
                'sku' => "required|min_length[2]|max_length[50]|is_unique[products.sku,id,$productId]",
                'price' => 'required|decimal',
                'cost' => 'permit_empty|decimal',
                'description' => 'permit_empty|string',
                'status' => 'required|in_list[Available,Discontinued]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $image = $product['image'];
            if ($file = $this->request->getFile('image')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Delete old image
                    if ($image && file_exists(WRITEPATH . '../public/uploads/products/' . $image)) {
                        unlink(WRITEPATH . '../public/uploads/products/' . $image);
                    }
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . '../public/uploads/products', $newName);
                    $image = $newName;
                }
            }

            $data = [
                'category_id' => $this->request->getPost('category_id'),
                'name' => $this->request->getPost('name'),
                'sku' => $this->request->getPost('sku'),
                'price' => $this->request->getPost('price'),
                'cost' => $this->request->getPost('cost') ?? null,
                'description' => $this->request->getPost('description'),
                'image' => $image,
                'status' => $this->request->getPost('status'),
            ];

            if ($this->productModel->skipValidation(true)->update($productId, $data)) {
                session()->setFlashdata('success', 'Product updated successfully!');
                return redirect()->to('/dashboard/products');
            }

            session()->setFlashdata('error', 'Failed to update product.');
            return redirect()->back()->withInput();
        }

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('admin/products/edit', $data);
    }

    public function deleteProduct($productId = null)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to('/');
        }

        if (!$productId) {
            return redirect()->to('/dashboard/products');
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        // Delete image
        if ($product['image'] && file_exists(WRITEPATH . '../public/uploads/products/' . $product['image'])) {
            unlink(WRITEPATH . '../public/uploads/products/' . $product['image']);
        }

        // Delete product (cascade will delete inventory and order items)
        $this->productModel->delete($productId);

        session()->setFlashdata('success', 'Product deleted successfully!');
        return redirect()->to('/dashboard/products');
    }

    // Inventory Management
    public function inventory($page = 1)
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        $perPage = 10;
        $builder = $this->inventoryModel->select('inventory.*, products.name, products.sku')
                                        ->join('products', 'products.id = inventory.product_id', 'inner')
                                        ->orderBy('inventory.id', 'DESC');
        
        $total = $builder->countAllResults(false);
        $inventory = $builder->paginate($perPage, 'default', $page);
        $pager = $this->inventoryModel->pager;

        $data = [
            'title' => 'Inventory',
            'inventory' => $inventory,
            'pager' => $pager,
        ];

        return view('admin/inventory/index', $data);
    }

    public function updateInventory($inventoryId = null)
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        if (!$inventoryId) {
            return redirect()->to('/dashboard/inventory');
        }

        $inventory = $this->inventoryModel->find($inventoryId);
        if (!$inventory) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inventory not found');
        }

        if ($this->request->is('post')) {
            $rules = [
                'quantity_on_hand' => 'required|integer',
                'reorder_level' => 'required|integer',
                'reorder_quantity' => 'required|integer',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('errors', $this->validator->getErrors());
            }

            $newQuantity = (int)$this->request->getPost('quantity_on_hand');
            $quantityChange = $newQuantity - $inventory['quantity_on_hand'];

            $alertStatus = $this->inventoryModel->calculateAlertStatus(
                $newQuantity - $inventory['quantity_reserved'],
                (int)$this->request->getPost('reorder_level')
            );

            $updateData = [
                'quantity_on_hand' => $newQuantity,
                'quantity_available' => $newQuantity - $inventory['quantity_reserved'],
                'reorder_level' => $this->request->getPost('reorder_level'),
                'reorder_quantity' => $this->request->getPost('reorder_quantity'),
                'alert_status' => $alertStatus,
            ];

            if ($this->inventoryModel->skipValidation(true)->update($inventoryId, $updateData)) {
                // Log transaction
                $this->historyModel->logTransaction(
                    $inventory['product_id'],
                    'Stock Adjustment',
                    $quantityChange,
                    $inventory['quantity_on_hand'],
                    $newQuantity,
                    session()->get('user_id'),
                    $this->request->getPost('notes')
                );

                session()->setFlashdata('success', 'Inventory updated successfully!');
                return redirect()->to('/dashboard/inventory');
            }

            session()->setFlashdata('error', 'Failed to update inventory.');
            return redirect()->back();
        }

        $product = $this->productModel->find($inventory['product_id']);

        $data = [
            'title' => 'Update Inventory',
            'inventory' => $inventory,
            'product' => $product,
        ];

        return view('admin/inventory/update', $data);
    }

    public function lowStock()
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        $lowStockProducts = $this->inventoryModel->getLowStockProducts();

        $data = [
            'title' => 'Low Stock Products',
            'products' => $lowStockProducts,
        ];

        return view('admin/inventory/low-stock', $data);
    }

    // Order Management
    public function orders($page = 1)
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        $perPage = 10;
        $builder = $this->orderModel->select('orders.*, users.first_name, users.last_name, users.email')
                                     ->join('users', 'users.id = orders.customer_id', 'inner')
                                     ->orderBy('orders.order_date', 'DESC');

        $total = $builder->countAllResults(false);
        $orders = $builder->paginate($perPage, 'default', $page);
        $pager = $this->orderModel->pager;

        $data = [
            'title' => 'Orders',
            'orders' => $orders,
            'pager' => $pager,
        ];

        return view('admin/orders/index', $data);
    }

    public function viewOrder($orderId = null)
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        if (!$orderId) {
            return redirect()->to('/dashboard/orders');
        }

        $order = $this->orderModel->getOrderWithItems($orderId);
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order not found');
        }

        $items = $this->orderItemModel->getOrderItems($orderId);

        $data = [
            'title' => 'View Order',
            'order' => $order,
            'items' => $items,
        ];

        return view('admin/orders/view', $data);
    }

    public function updateOrderStatus($orderId = null)
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        if (!$orderId) {
            return redirect()->to('/dashboard/orders');
        }

        $order = $this->orderModel->find($orderId);
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Order not found');
        }

        if ($this->request->is('post')) {
            $rules = [
                'status' => 'required|in_list[Pending,Confirmed,Processing,Shipped,Delivered,Cancelled]',
                'payment_status' => 'required|in_list[Unpaid,Paid,Refunded]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('errors', $this->validator->getErrors());
            }

            $updateData = [
                'status' => $this->request->getPost('status'),
                'payment_status' => $this->request->getPost('payment_status'),
                'notes' => $this->request->getPost('notes'),
            ];

            if ($this->orderModel->skipValidation(true)->update($orderId, $updateData)) {
                session()->setFlashdata('success', 'Order updated successfully!');
                return redirect()->to('/dashboard/order/' . $orderId);
            }

            session()->setFlashdata('error', 'Failed to update order.');
            return redirect()->back();
        }

        $data = [
            'title' => 'Update Order Status',
            'order' => $order,
        ];

        return view('admin/orders/update-status', $data);
    }

    // Reports
    public function salesReport()
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        $stats = $this->orderModel->getOrderStats();
        $topProducts = $this->orderItemModel->getTopSoldProducts(10);
        $recentOrders = $this->orderModel->getRecentOrders(20);

        $data = [
            'title' => 'Sales Report',
            'stats' => $stats,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
        ];

        return view('admin/reports/sales', $data);
    }

    public function inventoryReport()
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['Admin', 'Staff'])) {
            return redirect()->to('/');
        }

        $stats = $this->inventoryModel->getInventoryStats();
        $lowStock = $this->inventoryModel->getLowStockProducts();
        $outOfStock = $this->inventoryModel->getOutOfStockProducts();

        $data = [
            'title' => 'Inventory Report',
            'stats' => $stats,
            'lowStock' => $lowStock,
            'outOfStock' => $outOfStock,
        ];

        return view('admin/reports/inventory', $data);
    }
}
