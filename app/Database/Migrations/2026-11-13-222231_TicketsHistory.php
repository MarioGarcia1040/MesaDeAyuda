<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Migración para la tabla de historial de tickets.
 * Tabla: ticket_history
 * 13-Noviembre-2026
 * 
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TicketsHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ticket_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'field'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'old_value'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'new_value'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'comment_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('comment_id', 'ticket_comments', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('ticket_history');
    }

    public function down()
    {
        $this->forge->dropTable('ticket_history');
    }
}
