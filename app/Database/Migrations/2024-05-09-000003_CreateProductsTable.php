<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'category_id' => [
                'type' => 'INT',
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sku' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'cost' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Available', 'Discontinued'],
                'default' => 'Available',
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
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
