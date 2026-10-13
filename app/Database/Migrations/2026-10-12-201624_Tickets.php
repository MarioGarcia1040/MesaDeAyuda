<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Migración para la tabla de tickets.
 * Tabla: tickets
 * 12-Octubre-2026
 * 
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tickets extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'asset'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'description'    => ['type' => 'TEXT', 'null' => true],
            'category_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['abierto', 'en_proceso', 'pendiente', 'resuelto'], 'default' => 'abierto'],
            'priority'       => ['type' => 'ENUM', 'constraint' => ['alta', 'media', 'baja'], 'default' => 'media'],
            'applicant_id'   => ['type' => 'INT', 'unsigned' => true],
            'assigned_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'resolved_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addKey('assigned_id');
        $this->forge->addKey('applicant_id');
        $this->forge->addForeignKey('applicant_id', 'users', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('assigned_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categorias', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
