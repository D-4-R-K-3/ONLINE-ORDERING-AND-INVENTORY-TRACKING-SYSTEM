<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;

class ApiProduct extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new ProductModel();
    }

    public function index()
    {
        $products = $this->model->findAll();
        return $this->response->setJSON($products);
    }

    public function show($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Product ID required']);
        }

        $product = $this->model->find($id);
        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Product not found']);
        }

        return $this->response->setJSON($product);
    }

    public function create()
    {
        $data = $this->request->getJSON();

        if (!$this->model->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setStatusCode(201)->setJSON(['success' => 'Product created']);
    }

    public function update($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Product ID required']);
        }

        $data = $this->request->getJSON();

        if (!$this->model->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setJSON(['success' => 'Product updated']);
    }

    public function delete($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Product ID required']);
        }

        if (!$this->model->delete($id)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Failed to delete product']);
        }

        return $this->response->setJSON(['success' => 'Product deleted']);
    }
}
?>
