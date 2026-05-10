<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'product_id', 'quantity_on_hand', 'quantity_reserved', 'quantity_available',
        'reorder_level', 'reorder_quantity', 'alert_status', 'last_restock_date'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'product_id' => 'required|integer',
        'quantity_on_hand' => 'required|integer',
        'reorder_level' => 'required|integer',
        'reorder_quantity' => 'required|integer',
    ];

    public function getByProductId($productId)
    {
        return $this->where('product_id', $productId)->first();
    }

    public function getLowStockProducts()
    {
        return $this->select('inventory.*, products.name, products.sku')
                    ->join('products', 'products.id = inventory.product_id', 'inner')
                    ->where('inventory.quantity_available <=', 'inventory.reorder_level', false)
                    ->orderBy('inventory.quantity_available', 'ASC')
                    ->findAll();
    }

    public function getOutOfStockProducts()
    {
        return $this->select('inventory.*, products.name, products.sku')
                    ->join('products', 'products.id = inventory.product_id', 'inner')
                    ->where('inventory.quantity_available', 0)
                    ->findAll();
    }

    public function getInventoryWithProduct($inventoryId)
    {
        return $this->select('inventory.*, products.name, products.sku, products.price, categories.name as category_name')
                    ->join('products', 'products.id = inventory.product_id', 'inner')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->where('inventory.id', $inventoryId)
                    ->first();
    }

    public function updateStockByProduct($productId, $quantity)
    {
        $inventory = $this->where('product_id', $productId)->first();
        
        if ($inventory) {
            $newQuantity = $inventory['quantity_on_hand'] + $quantity;
            $availableQuantity = $newQuantity - $inventory['quantity_reserved'];
            
            $alertStatus = $this->calculateAlertStatus($availableQuantity, $inventory['reorder_level']);
            
            return $this->update($inventory['id'], [
                'quantity_on_hand' => $newQuantity,
                'quantity_available' => $availableQuantity,
                'alert_status' => $alertStatus,
                'last_restock_date' => date('Y-m-d H:i:s'),
            ]);
        }
        
        return false;
    }

    public function calculateAlertStatus($available, $reorderLevel)
    {
        if ($available <= 0) {
            return 'Out of Stock';
        } elseif ($available <= $reorderLevel) {
            return 'Low Stock';
        } else {
            return 'Normal';
        }
    }

    public function getInventoryStats()
    {
        return $this->select(
            'COUNT(*) as total_products, ' .
            'SUM(quantity_on_hand) as total_quantity, ' .
            'SUM(quantity_available) as available_quantity, ' .
            'SUM(quantity_reserved) as reserved_quantity'
        )->first();
    }
}
