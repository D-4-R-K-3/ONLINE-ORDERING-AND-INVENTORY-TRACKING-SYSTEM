<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unique' => true,
            ],
            'quantity_on_hand' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'quantity_reserved' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'quantity_available' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'reorder_level' => [
                'type' => 'INT',
                'default' => 10,
            ],
            'reorder_quantity' => [
                'type' => 'INT',
                'default' => 50,
            ],
            'alert_status' => [
                'type' => 'ENUM',
                'constraint' => ['Normal', 'Low Stock', 'Out of Stock'],
                'default' => 'Normal',
            ],
            'last_restock_date' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventory');
    }

    public function down()
    {
        $this->forge->dropTable('inventory');
    }
}
