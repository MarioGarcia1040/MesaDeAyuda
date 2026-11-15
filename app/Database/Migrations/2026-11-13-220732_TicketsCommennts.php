<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Migración para la tabla de comentarios de tickets.
 * Tabla: ticket_comments
 * 13-Noviembre-2026
 * 
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TicketsCommennts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ticket_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'comment'        => ['type' => 'TEXT'],
            'is_internal'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('ticket_comments');
    }

    public function down()
    {
        $this->forge->dropTable('ticket_comments');
    }
}
