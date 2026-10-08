<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra la lista de usuarios.
 * 26-Septiembre-2026 | 08-Octubre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UsersController extends BaseController
{
    public function index()
    {
        $userProfiles = new \App\Models\UserProfilesModel();

        return view('template/users', [
            'title' => 'Shoei | Usuarios',
            'users' => $userProfiles->getUserProfileWithDetails(),
        ]);
    }   
}