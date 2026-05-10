<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['order_id', 'product_id', 'quantity', 'unit_price', 'total_price'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'order_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|greater_than[0]',
        'unit_price' => 'required|decimal',
        'total_price' => 'required|decimal',
    ];

    public function getOrderItems($orderId)
    {
        return $this->select('order_items.*, products.name, products.sku, products.image')
                    ->join('products', 'products.id = order_items.product_id', 'inner')
                    ->where('order_items.order_id', $orderId)
                    ->findAll();
    }

    public function getProductSalesCount($productId, $startDate = null, $endDate = null)
    {
        $query = $this->where('product_id', $productId)
                      ->selectSum('quantity');
        
        if ($startDate && $endDate) {
            $query->where('DATE(created_at) >=', $startDate)
                  ->where('DATE(created_at) <=', $endDate);
        }
        
        return $query->first();
    }

    public function getTopSoldProducts($limit = 10)
    {
        return $this->select('products.id, products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.total_price) as revenue')
                    ->join('products', 'products.id = order_items.product_id', 'inner')
                    ->groupBy('products.id')
                    ->orderBy('total_sold', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
