<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra los datos de la cuenta del usuario.
 * 26-Septiembre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function index()
    {
        return view('template/profile', [
            'title' => 'Shoei | Mi Cuenta'
        ]);
    }
}
