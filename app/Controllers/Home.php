<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador de acceso a la aplicación, principal.
 * 09-Septiembre-2026
 * 
 */

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('\CodeIgniter\Shield\Views\login');
    }
}
