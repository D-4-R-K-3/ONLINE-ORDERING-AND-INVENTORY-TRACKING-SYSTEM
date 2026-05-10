<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryHistoryModel extends Model
{
    protected $table = 'inventory_history';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'product_id', 'transaction_type', 'quantity_change', 'quantity_before',
        'quantity_after', 'reference_id', 'notes', 'created_by'
    ];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $validationRules = [
        'product_id' => 'required|integer',
        'transaction_type' => 'required|min_length[2]',
        'quantity_change' => 'required|integer',
        'created_by' => 'required|integer',
    ];

    public function getProductHistory($productId, $limit = 50)
    {
        return $this->select('inventory_history.*, products.name, users.first_name, users.last_name')
                    ->join('products', 'products.id = inventory_history.product_id', 'inner')
                    ->join('users', 'users.id = inventory_history.created_by', 'inner')
                    ->where('inventory_history.product_id', $productId)
                    ->orderBy('inventory_history.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function logTransaction($productId, $type, $quantityChange, $quantityBefore, $quantityAfter, $userId, $notes = null, $referenceId = null)
    {
        return $this->insert([
            'product_id' => $productId,
            'transaction_type' => $type,
            'quantity_change' => $quantityChange,
            'quantity_before' => $quantityBefore,
            'quantity_after' => $quantityAfter,
            'reference_id' => $referenceId,
            'notes' => $notes,
            'created_by' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getRecentActivity($limit = 20)
    {
        return $this->select('inventory_history.*, products.name, products.sku, users.first_name, users.last_name')
                    ->join('products', 'products.id = inventory_history.product_id', 'inner')
                    ->join('users', 'users.id = inventory_history.created_by', 'inner')
                    ->orderBy('inventory_history.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
