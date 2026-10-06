<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Migración para la tabla de perfiles de usuario.
 * Tabla: user_profiles
 * Extensión de shield para agregar campos adicionales al perfil de usuario.
 * 06-Octubre-2026
 * 
 */

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserProfiles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nombre'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'apellido'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'telefono'   => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'foto'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('user_profiles');
    }
}
