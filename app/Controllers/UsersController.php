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
use CodeIgniter\Shield\Entities\User;


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

    public function add()
    {
        if (! $this->validate('addUser')) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors'  => $this->validator->getErrors(),
                    'csrf'    => csrf_hash(),
                ]);
        }

        $email = strtolower(trim($this->request->getPost('email')));
        $users = auth()->getProvider();

        $base = preg_replace('/[^a-z0-9._-]/', '', explode('@', $email)[0]);
        $base = substr($base !== '' ? $base : 'user', 0, 25);

        $username = $base;
        $counter  = 1;

        while ($users->withDeleted()->where('username', $username)->first()) {
            $username = $base . $counter++;
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $usuario = new User([
                'username' => $username,
                'email'    => $email,
                'password' => bin2hex(random_bytes(16)),
            ]);

            $users->save($usuario);

            $usuario = $users->findById($users->getInsertID());
            $users->addToDefaultGroup($usuario);
            $usuario->activate();

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transacción fallida');
            }
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'Error al crear usuario: ' . $e->getMessage());
            session()->setFlashdata('error', 'Error al crear el usuario.');

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'message' => 'Error al crear el usuario.',
                    'csrf'    => csrf_hash(),
                ]);
        }

        session()->setFlashdata('success', 'Usuario agregado correctamente.');

        return $this->response->setJSON([
            'success'  => true,
            'redirect' => site_url('users'),
            'csrf'     => csrf_hash(),
        ]);
    }
}
