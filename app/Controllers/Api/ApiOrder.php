<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\OrderModel;

class ApiOrder extends ResourceController
{
    protected $model;
    protected $format = 'json';

    public function __construct()
    {
        $this->model = new OrderModel();
    }

    public function index()
    {
        $orders = $this->model->findAll();
        return $this->response->setJSON($orders);
    }

    public function show($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Order ID required']);
        }

        $order = $this->model->find($id);
        if (!$order) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Order not found']);
        }

        return $this->response->setJSON($order);
    }

    public function create()
    {
        $data = $this->request->getJSON();

        if (!$this->model->insert($data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setStatusCode(201)->setJSON(['success' => 'Order created']);
    }

    public function update($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Order ID required']);
        }

        $data = $this->request->getJSON();

        if (!$this->model->update($id, $data)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => $this->model->errors()]);
        }

        return $this->response->setJSON(['success' => 'Order updated']);
    }

    public function delete($id = null)
    {
        if (!$id) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Order ID required']);
        }

        if (!$this->model->delete($id)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Failed to delete order']);
        }

        return $this->response->setJSON(['success' => 'Order deleted']);
    }
}
?>
