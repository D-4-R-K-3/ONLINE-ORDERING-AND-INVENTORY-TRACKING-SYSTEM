<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'customer_id', 'order_number', 'order_date', 'delivery_address', 'total_items',
        'subtotal', 'tax_amount', 'shipping_fee', 'total_amount', 'status', 'payment_status', 'notes'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'customer_id' => 'required|integer',
        'order_number' => 'required|is_unique[orders.order_number]',
        'delivery_address' => 'required|min_length[5]',
        'status' => 'required|in_list[Pending,Confirmed,Processing,Shipped,Delivered,Cancelled]',
        'payment_status' => 'required|in_list[Unpaid,Paid,Refunded]',
    ];

    public function generateOrderNumber()
    {
        return 'ORD-' . date('YmdHis') . '-' . random_string('numeric', 4);
    }

    public function getOrderWithItems($orderId)
    {
        return $this->select('orders.*, users.first_name, users.last_name, users.email')
                    ->join('users', 'users.id = orders.customer_id', 'inner')
                    ->where('orders.id', $orderId)
                    ->first();
    }

    public function getCustomerOrders($customerId)
    {
        return $this->where('customer_id', $customerId)
                    ->orderBy('order_date', 'DESC')
                    ->findAll();
    }

    public function getOrdersByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('order_date', 'DESC')
                    ->findAll();
    }

    public function searchOrders($keyword)
    {
        return $this->select('orders.*, users.first_name, users.last_name')
                    ->join('users', 'users.id = orders.customer_id', 'inner')
                    ->groupStart()
                        ->like('orders.order_number', $keyword)
                        ->orLike('users.first_name', $keyword)
                        ->orLike('users.last_name', $keyword)
                        ->orLike('users.email', $keyword)
                    ->groupEnd()
                    ->orderBy('orders.order_date', 'DESC')
                    ->findAll();
    }

    public function getOrderStats()
    {
        return $this->select(
            'COUNT(*) as total_orders, ' .
            'SUM(total_amount) as total_revenue, ' .
            'AVG(total_amount) as average_order_value'
        )->first();
    }

    public function getTodayOrders()
    {
        return $this->where('DATE(order_date)', date('Y-m-d'))
                    ->orderBy('order_date', 'DESC')
                    ->findAll();
    }

    public function getRecentOrders($limit = 10)
    {
        return $this->orderBy('order_date', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
