<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\InventoryModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Libraries\EmailService;
use CodeIgniter\Controller;

class Shop extends Controller
{
    protected $productModel;
    protected $categoryModel;
    protected $inventoryModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $emailService;
    protected $helpers = ['form', 'url', 'text'];

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->inventoryModel = new InventoryModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Online Store',
            'categories' => $this->categoryModel->getActiveCategories(),
            'featuredProducts' => $this->productModel->where('status', 'Available')->paginate(10, 'products'),
            'pager' => $this->productModel->pager,
            'totalProducts' => count($this->productModel->getAvailableProducts()),
        ];

        return view('shop/index', $data);
    }

    public function category($categoryId = null)
    {
        if (!$categoryId) {
            return redirect()->to('/shop');
        }

        $category = $this->categoryModel->find($categoryId);
        if (!$category) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
        }

        $data = [
            'title' => 'Category: ' . $category['name'],
            'category' => $category,
            'categories' => $this->categoryModel->getActiveCategories(),
            'products' => $this->productModel->where('category_id', $categoryId)
                                             ->where('status', 'Available')
                                             ->paginate(10, 'category_products'),
            'pager' => $this->productModel->pager,
            'search' => false,
        ];

        return view('shop/category', $data);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q') ?? '';
        $products = [];

        if (strlen($keyword) >= 2) {
            $products = $this->productModel->like('name', $keyword)
                                           ->orLike('description', $keyword)
                                           ->where('status', 'Available')
                                           ->paginate(10, 'search_results');
        }

        $data = [
            'title' => 'Search Results',
            'keyword' => $keyword,
            'products' => $products,
            'pager' => $this->productModel->pager,
            'categories' => $this->categoryModel->getActiveCategories(),
            'search' => true,
        ];

        return view('shop/search', $data);
    }

    public function product($productId = null)
    {
        if (!$productId) {
            return redirect()->to('/shop');
        }

        $product = $this->productModel->getProductWithCategory($productId);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        $inventory = $this->inventoryModel->getByProductId($productId);

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'inventory' => $inventory,
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('shop/product', $data);
    }

    public function cart()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $cart = session()->get('cart') ?? [];

        $data = [
            'title' => 'Shopping Cart',
            'cart' => $cart,
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('shop/cart', $data);
    }

    public function addToCart()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $productId = $this->request->getPost('product_id');
        $quantity = (int)($this->request->getPost('quantity') ?? 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        $product = $this->productModel->find($productId);
        $inventory = $this->inventoryModel->getByProductId($productId);

        if (!$product || !$inventory || $inventory['quantity_available'] < $quantity) {
            session()->setFlashdata('error', 'Product not available or insufficient stock.');
            return redirect()->back();
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image'],
            ];
        }

        session()->set('cart', $cart);
        session()->setFlashdata('success', 'Product added to cart!');
        return redirect()->back();
    }

    public function processOrder()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            session()->setFlashdata('error', 'Your cart is empty.');
            return redirect()->to('/shop/cart');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'delivery_address' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $taxAmount = $subtotal * 0.12;
        $shippingFee = 5.00;
        $totalAmount = $subtotal + $taxAmount + $shippingFee;

        $orderData = [
            'customer_id' => session()->get('user_id'),
            'order_number' => $this->orderModel->generateOrderNumber(),
            'order_date' => date('Y-m-d H:i:s'),
            'delivery_address' => $this->request->getPost('delivery_address'),
            'total_items' => array_sum(array_column($cart, 'quantity')),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_fee' => $shippingFee,
            'total_amount' => $totalAmount,
            'status' => 'Pending',
            'payment_status' => 'Unpaid',
        ];

        $orderId = $this->orderModel->insert($orderData, true);

        if ($orderId) {
            $itemDetailsForEmail = [];

            foreach ($cart as $productId => $item) {
                $this->orderItemModel->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);

                $itemDetailsForEmail[] = [
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity']
                ];

                $inventory = $this->inventoryModel->getByProductId($productId);
                $product = $this->productModel->find($productId);

                $newQuantity = $inventory['quantity_on_hand'] - $item['quantity'];
                $newReserved = $inventory['quantity_reserved'] + $item['quantity'];
                
                $this->inventoryModel->update($inventory['id'], [
                    'quantity_on_hand' => $newQuantity,
                    'quantity_reserved' => $newReserved,
                    'quantity_available' => $newQuantity - $newReserved,
                ]);

                if ($newQuantity <= $inventory['reorder_level']) {
                    $this->emailService->sendLowStockNotification(
                        $product['name'], 
                        $newQuantity, 
                        $inventory['reorder_level']
                    );
                }
            }

            $customerData = [
                'email' => session()->get('user_email'),
                'first_name' => session()->get('first_name') ?? 'Valued Customer',
                'last_name' => session()->get('last_name') ?? ''
            ];

            $this->emailService->sendOrderAlerts($orderData, $customerData, $itemDetailsForEmail);

            session()->remove('cart');
            session()->setFlashdata('success', 'Order placed successfully!');
            return redirect()->to('/shop/order-confirmation/' . $orderId);
        } else {
            session()->setFlashdata('error', 'Failed to create order.');
            return redirect()->back();
        }
    }

    public function myOrders()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'My Orders',
            'orders' => $this->orderModel->where('customer_id', session()->get('user_id'))
                                         ->orderBy('created_at', 'DESC')
                                         ->paginate(10, 'my_orders'),
            'pager' => $this->orderModel->pager,
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        return view('shop/my-orders', $data);
    }
}