<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'customer_id' => [
                'type' => 'INT',
            ],
            'order_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'order_date' => [
                'type' => 'DATETIME',
            ],
            'delivery_address' => [
                'type' => 'TEXT',
            ],
            'total_items' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'tax_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'shipping_fee' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
                'default' => 'Pending',
            ],
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['Unpaid', 'Paid', 'Refunded'],
                'default' => 'Unpaid',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('customer_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('customer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
