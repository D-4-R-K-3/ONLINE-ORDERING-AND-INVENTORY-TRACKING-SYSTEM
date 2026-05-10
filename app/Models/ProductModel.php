<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['category_id', 'name', 'description', 'sku', 'price', 'cost', 'image', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'category_id' => 'required|integer',
        'name' => 'required|min_length[2]|max_length[150]',
        'sku' => 'required|min_length[2]|max_length[50]|is_unique[products.sku]',
        'price' => 'required|decimal',
        'status' => 'required|in_list[Available,Discontinued]',
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getAvailableProducts()
    {
        return $this->where('status', 'Available')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }

    public function getProductWithCategory($productId)
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->where('products.id', $productId)
                    ->first();
    }

    public function getProductByCategory($categoryId, $limit = null)
    {
        $query = $this->where('category_id', $categoryId)
                      ->where('status', 'Available')
                      ->orderBy('name', 'ASC');
        
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->findAll();
    }

    public function searchProducts($keyword)
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->groupStart()
                        ->like('products.name', $keyword)
                        ->orLike('products.description', $keyword)
                        ->orLike('products.sku', $keyword)
                    ->groupEnd()
                    ->where('products.status', 'Available')
                    ->orderBy('products.name', 'ASC')
                    ->findAll();
    }

    public function getBySku($sku)
    {
        return $this->where('sku', $sku)->first();
    }
}
