<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryHistoryTable extends Migration
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
            ],
            'transaction_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'quantity_change' => [
                'type' => 'INT',
            ],
            'quantity_before' => [
                'type' => 'INT',
            ],
            'quantity_after' => [
                'type' => 'INT',
            ],
            'reference_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('product_id');
        $this->forge->addKey('created_by');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventory_history');
    }

    public function down()
    {
        $this->forge->dropTable('inventory_history');
    }
}
