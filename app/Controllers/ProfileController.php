<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra los datos de la cuenta del usuario.
 * 26-Septiembre-2026 | 30-Septiembre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpParser\Node\Stmt\Label;

class ProfileController extends BaseController
{
    public function index()
    {
        return view('template/profile', [
            'title' => 'Shoei | Mi Cuenta'
        ]);
    }

    public function changePassword()
    {
        $user = auth()->user();

        $rules = [
            'actual-password' => [
                'label' => 'Contraseña actual',
                'rules' => 'required',
            ],
            'new-password' => [
                'label'  => 'Nueva contraseña',
                'rules'  => 'required|max_length[100]|strong_password[]|differs[actual-password]',
                'errors' => [
                    'differs' => 'La nueva contraseña debe ser distinta a la actual',
                ],
            ],
            'confirm-password' => [
                'label' => 'Confirmar contraseña',
                'rules' => 'required|matches[new-password]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->with('tab', 'password');
        }

        $result = auth()->check([
            'email'    => $user->email,
            'password' => $this->request->getPost('actual-password'),
        ]);

        if (! $result->isOK()) {
            return redirect()->back()
                ->with('errors', ['actual-password' => 'La contraseña actual es incorrecta'])
                ->with('tab', 'password');
        }

        try {
            $user->setPassword($this->request->getPost('new-password'));
            auth()->getProvider()->save($user);
        } catch (\CodeIgniter\Shield\Exceptions\ValidationException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        session()->regenerate();

        return redirect()->back()
            ->with('success', 'Contraseña actualizada correctamente')
            ->with('tab', 'password');
    }
}
