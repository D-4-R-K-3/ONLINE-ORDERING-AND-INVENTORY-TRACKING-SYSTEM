<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]|is_unique[categories.name]',
        'description' => 'permit_empty|string',
        'status' => 'required|in_list[Active,Inactive]',
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getActiveCategories()
    {
        return $this->where('status', 'Active')->orderBy('name', 'ASC')->findAll();
    }

    public function getCategoryWithProducts($categoryId)
    {
        return $this->select('categories.*, COUNT(products.id) as product_count')
                    ->join('products', 'products.category_id = categories.id', 'left')
                    ->where('categories.id', $categoryId)
                    ->first();
    }
}
