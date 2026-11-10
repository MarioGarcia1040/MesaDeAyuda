<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra la lista de usuarios.
 * 26-Septiembre-2026 | 10-Octubre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;


class UsersController extends BaseController
{
    public function index()
    {
        $userProfiles = new UserModel();
        return view('template/users', [
            'title' => 'Usuarios',
            'users' => $userProfiles->getUsersWithProfileDetails(),
            'roles' => config('AuthGroups')->groups,
        ]);
    }   
}