<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CategoryModel;

class ApiCategory extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->model->findAll();
        return $this->response->setJSON($categories);
    }

    public function show($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Category ID required']);
        }

        $category = $this->model->find($id);
        if (!$category) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Category not found']);
        }

        return $this->response->setJSON($category);
    }

    public function create()
    {
        $data = $this->request->getJSON();

        if (!$this->model->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setStatusCode(201)->setJSON(['success' => 'Category created']);
    }

    public function update($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Category ID required']);
        }

        $data = $this->request->getJSON();

        if (!$this->model->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setJSON(['success' => 'Category updated']);
    }

    public function delete($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Category ID required']);
        }

        if (!$this->model->delete($id)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Failed to delete category']);
        }

        return $this->response->setJSON(['success' => 'Category deleted']);
    }
}
?>
