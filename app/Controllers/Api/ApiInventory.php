<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\InventoryModel;

class ApiInventory extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new InventoryModel();
    }

    public function index()
    {
        $inventory = $this->model->findAll();
        return $this->response->setJSON($inventory);
    }

    public function show($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Inventory ID required']);
        }

        $item = $this->model->find($id);
        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Inventory item not found']);
        }

        return $this->response->setJSON($item);
    }

    public function create()
    {
        $data = $this->request->getJSON();

        if (!$this->model->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setStatusCode(201)->setJSON(['success' => 'Inventory item created']);
    }

    public function update($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Inventory ID required']);
        }

        $data = $this->request->getJSON();

        if (!$this->model->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setJSON(['success' => 'Inventory updated']);
    }

    public function delete($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Inventory ID required']);
        }

        if (!$this->model->delete($id)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Failed to delete inventory item']);
        }

        return $this->response->setJSON(['success' => 'Inventory item deleted']);
    }
}
?>
