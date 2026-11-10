<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Controlador muestra los datos de la cuenta del usuario.
 * 26-Septiembre-2026 | 05-Noviembre-2026
 * 
 */

namespace App\Controllers;

use App\Models\AccessLogModel;
use App\Models\UserModel;
use App\Models\UserProfilesModel;
use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    public function index()
    {
        $user = auth()->user();

        return view('template/profile', [
            'title'       => 'Mi Cuenta',
            'accesses'    => model(AccessLogModel::class)->recentForUser($user),
            'profileData' => model(UserProfilesModel::class)->findByUserId($user->id),
        ]);
    }

    public function changePassword()
    {
        $user = auth()->user();

        if (! $this->validate('changePassword')) {
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

        if (! $this->validate('updateEmail')) {
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

        if (model(UserModel::class)->emailInUse($newEmail, $user->id)) {
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
        $userProfiles = model(UserProfilesModel::class);

        $data = [
            'profile-first-name' => $this->normalizeName((string) $this->request->getPost('profile-first-name')),
            'profile-last-name'  => $this->normalizeName((string) $this->request->getPost('profile-last-name')),
            'profile-phone'      => preg_replace('/\D/', '', (string) $this->request->getPost('profile-phone')),
        ];

        if (! $this->validateData($data, 'updateProfile')) {
            return $this->backWithErrors($this->validator->getErrors());
        }

        $profileData = [
            'user_id'  => $user->id,
            'nombre'   => $data['profile-first-name'],
            'apellido' => $data['profile-last-name'],
            'telefono' => $data['profile-phone'] ?: null,
        ];

        $profile  = $userProfiles->findByUserId($user->id);
        $oldPhoto = $profile['foto'] ?? null;

        $file     = $this->request->getFile('profile-photo');
        $hasPhoto = $file && $file->getError() !== UPLOAD_ERR_NO_FILE;

        if ($hasPhoto) {
            if (! $this->validate('updateProfilePhoto')) {
                return $this->backWithErrors($this->validator->getErrors());
            }

            try {
                $profileData['foto'] = $this->savePhoto($file);
            } catch (\Throwable $e) {
                log_message('error', 'Error procesando foto de perfil: ' . $e->getMessage());

                return $this->backWithErrors(['profile-photo' => 'No se pudo procesar la imagen.']);
            }
        }

        try {
            if ($profile) {
                $userProfiles->saveForUser($user->id, $profileData);
            } else {
                $userProfiles->insert($profileData);
            }
        } catch (\Throwable $e) {
            if (isset($profileData['foto'])) {
                $this->deletePhoto($profileData['foto']);
            }
            log_message('error', 'Error guardando perfil: ' . $e->getMessage());

            return $this->backWithErrors(['general' => 'No se pudo guardar el perfil.']);
        }

        if ($oldPhoto && isset($profileData['foto'])) {
            $this->deletePhoto($oldPhoto);
        }

        return redirect()->back()
            ->with('success', 'Perfil actualizado correctamente')
            ->with('tab', 'settings');
    }

    private const PHOTO_BASE_DIR = WRITEPATH . 'uploads/profile_photos';

    private function savePhoto(\CodeIgniter\HTTP\Files\UploadedFile $file): string
    {
        if (! $file->isValid() || $file->hasMoved()) {
            throw new \RuntimeException('Archivo no válido o ya movido.');
        }

        $realDir  = self::PHOTO_BASE_DIR . '/real';
        $smallDir = self::PHOTO_BASE_DIR . '/small';

        foreach ([$realDir, $smallDir] as $dir) {
            if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
                throw new \RuntimeException("No se pudo crear el directorio {$dir}");
            }
        }

        $newName = $file->getRandomName();
        $file->move($realDir, $newName);

        try {
            \Config\Services::image()
                ->withFile($realDir . '/' . $newName)
                ->fit(200, 200, 'center')
                ->save($smallDir . '/' . $newName, 85);
        } catch (\Throwable $e) {
            $this->deletePhoto($newName);
            throw $e;
        }

        return $newName;
    }

    private function deletePhoto(string $name): void
    {
        @unlink(self::PHOTO_BASE_DIR . '/real/' . $name);
        @unlink(self::PHOTO_BASE_DIR . '/small/' . $name);
    }

    private function backWithErrors(array $errors, string $tab = 'settings')
    {
        return redirect()->back()->withInput()
            ->with('errors', $errors)
            ->with('tab', $tab);
    }

    private function normalizeName(string $value): string
    {
        $value = trim(preg_replace('/\s+/', ' ', $value));

        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    public function avatar(string $type, string $filename)
    {
        $type = $type === 'small' ? 'small' : 'real';
        $path = WRITEPATH . 'uploads/profile_photos/' . $type . '/' . basename($filename);

        if (! is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setHeader('Cache-Control', 'private, max-age=86400')
            ->setBody(file_get_contents($path));
    }
}
