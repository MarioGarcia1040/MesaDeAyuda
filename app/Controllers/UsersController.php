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
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Models\UserIdentityModel;


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

        $correoEnviado = $this->sendMagicLinkEmail($usuario);

        session()->setFlashdata(
            $correoEnviado ? 'success' : 'warning',
            $correoEnviado
                ? 'Usuario agregado correctamente. Se envió un correo de acceso.'
                : 'Usuario agregado, pero no se pudo enviar el correo de acceso.'
        );

        return $this->response->setJSON([
            'success'  => true,
            'redirect' => site_url('users'),
            'csrf'     => csrf_hash(),
        ]);
    }

    private function sendMagicLinkEmail(User $user): bool
    {
        try {
            $token = $this->createMagicLinkToken($user);

            $email = service('email');
            $email->setTo($user->email);
            $email->setSubject('Tu acceso al sistema');
            $email->setMessage(view('template/emails/registredbysupport', [
                'username' => $user->username,
                'link'     => url_to('verify-magic-link') . '?token=' . $token,
            ]));

            if (! $email->send(false)) {
                log_message('error', 'Email de acceso falló: ' . $email->printDebugger(['headers']));
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            log_message('error', 'Email de acceso: ' . $e->getMessage());
            return false;
        }
    }

    private function createMagicLinkToken(User $user): string
    {
        $identities = model(UserIdentityModel::class);

        // Elimina tokens anteriores para no acumularlos
        $identities->where('user_id', $user->id)
            ->where('type', Session::ID_TYPE_MAGIC_LINK)
            ->delete();

        $token = bin2hex(random_bytes(20));

        $identities->insert([
            'user_id' => $user->id,
            'type'    => Session::ID_TYPE_MAGIC_LINK,
            'secret'  => $token,
            'expires' => Time::now()
                ->addSeconds(setting('Auth.magicLinkLifetime'))
                ->format('Y-m-d H:i:s'),
        ]);

        return $token;
    }
}
