<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra los datos de la cuenta del usuario.
 * 26-Septiembre-2026 | 06-Octubre-2026
 * 
 */

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\LoginModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function index()
    {
        $user = auth()->user();
        $userProfiles = new \App\Models\UserProfilesModel();

        $profileData = $userProfiles->where('user_id', $user->id)->first();

        $acceses = (new LoginModel())
            ->groupStart()
            ->where('user_id', $user->id)
            ->orWhere('identifier', $user->email)
            ->groupEnd()
            ->orderBy('date', 'DESC')
            ->findAll(5);

        return view('template/profile', [
            'title' => 'Shoei | Mi Cuenta',
            'accesses' => $acceses,
            'profileData' => $profileData,
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

    public function updateEmail()
    {
        $user = auth()->user();

        $post = $this->request->getPost();
        $post['profile-new-email'] = strtolower(trim($post['profile-new-email'] ?? ''));
        $this->request->setGlobal('post', $post);

        $rules = [
            'profile-new-email' => [
                'label'  => 'Nuevo email',
                'rules'  => 'required|valid_email|max_length[100]',
                'errors' => ['valid_email' => 'El email ingresado no es válido.'],
            ],
            'new-email-password-verification' => [
                'label' => 'Contraseña',
                'rules' => 'required',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('tab', 'email');
        }

        $newEmail = $post['profile-new-email'];

        if ($newEmail === strtolower($user->email)) {
            return redirect()->back()->withInput()
                ->with('errors', ['profile-new-email' => 'El email es igual al actual.'])
                ->with('tab', 'email');
        }

        $enUso = model(\CodeIgniter\Shield\Models\UserIdentityModel::class)
            ->where('type', 'email_password')
            ->where('secret', $newEmail)
            ->where('user_id !=', $user->id)
            ->first();

        if ($enUso) {
            return redirect()->back()->withInput()
                ->with('errors', ['profile-new-email' => 'Este email ya está registrado.'])
                ->with('tab', 'email');
        }

        $result = auth()->check([
            'email'    => $user->email,
            'password' => $this->request->getPost('new-email-password-verification'),
        ]);

        if (! $result->isOK()) {
            return redirect()->back()->withInput()
                ->with('errors', ['new-email-password-verification' => 'La contraseña es incorrecta.'])
                ->with('tab', 'email');
        }

        try {
            $user->email = $newEmail;
            auth()->getProvider()->save($user);
        } catch (\CodeIgniter\Shield\Exceptions\ValidationException | \CodeIgniter\Database\Exceptions\DatabaseException $e) {
            log_message('error', 'Cambio de email falló: ' . $e->getMessage());

            return redirect()->back()->withInput()
                ->with('errors', ['profile-new-email' => 'No se pudo actualizar el email.'])
                ->with('tab', 'email');
        }

        session()->regenerate();

        return redirect()->to('profile')
            ->with('success', 'Email actualizado correctamente')
            ->with('tab', 'email');
    }

    public function updateProfile()
    {
        $user         = auth()->user();
        $userProfiles = new \App\Models\UserProfilesModel();

        $data = [
            'profile-first-name' => trim((string) $this->request->getPost('profile-first-name')),
            'profile-last-name'  => trim((string) $this->request->getPost('profile-last-name')),
            'profile-phone'      => preg_replace('/\D/', '', (string) $this->request->getPost('profile-phone')),
        ];

        $rules = [
            'profile-first-name' => [
                'label' => 'Nombre(s)',
                'rules' => "required|min_length[2]|max_length[100]|regex_match[/^[\p{L}\s'\-]+$/u]",
            ],
            'profile-last-name' => [
                'label' => 'Apellido(s)',
                'rules' => "required|min_length[2]|max_length[100]|regex_match[/^[\p{L}\s'\-]+$/u]",
            ],
            'profile-phone' => [
                'label'  => 'Teléfono',
                'rules'  => 'permit_empty|regex_match[/^[0-9]{10}$/]',
                'errors' => ['regex_match' => 'El teléfono debe tener 10 dígitos.'],
            ],
            'profile-photo' => [
                'label'  => 'Foto',
                'rules'  => 'max_size[profile-photo,4096]|is_image[profile-photo]|mime_in[profile-photo,image/jpeg,image/png]|max_dims[profile-photo,4000,4000]',
                'errors' => [
                    'is_image' => 'El archivo seleccionado no es una imagen válida.',
                    'max_size' => 'La imagen no puede pesar más de 4MB.',
                    'mime_in'  => 'El archivo seleccionado no es un tipo de imagen permitido.',
                    'max_dims' => 'La imagen no puede superar los 4000x4000 píxeles.',
                ],
            ],
        ];

        if (! $this->validateData($data, $rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('tab', 'settings');
        }

        $profileData = [
            'user_id'  => $user->id,
            'nombre'   => $data['profile-first-name'],
            'apellido' => $data['profile-last-name'],
            'telefono' => $data['profile-phone'] ?: null,
        ];

        $file = $this->request->getFile('profile-photo');
        
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $profileData['foto'] = $file->getRandomName();
        }

        $profile = $userProfiles->where('user_id', $user->id)->first();

        if ($profile) {
            $userProfiles->update($profile['id'], $profileData);
        } else {
            $userProfiles->insert($profileData);
        }

        return redirect()->back()
            ->with('success', 'Perfil actualizado correctamente')
            ->with('tab', 'settings');
    }

    private function photoUpload($file)
    {
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
            return $newName;
        }
        return null;
    }
}
