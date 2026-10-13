<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Semilla para insertar categorías de ejemplo
 * 08-Octubre-2026
 * 
 */

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('categories')->insertBatch([
            ['name' => 'Correo'],
            ['name' => 'Hardware'],
            ['name' => 'Accesos'],
            ['name' => 'Red'],
            ['name' => 'Software'],
            ['name' => 'ERP'],
        ]);
    }
}
