<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Helper para manejar la lógica del perfil del usuario.
 * 06-Octubre-2026
 * 
 */

use App\Models\UserProfilesModel;

if (! function_exists('actual_profile')) {
    function actual_profile(): ?array
    {
        static $profile = false;

        if ($profile === false) {
            $user   = auth()->user();
            $profile = $user
                ? (new UserProfilesModel())->where('user_id', $user->id)->first()
                : null;
        }

        return $profile;
    }
}

if (! function_exists('fullname')) {
    function fullname(): string
    {
        $profile = actual_profile();
        $nombre = trim(($profile['nombre'] ?? '') . ' ' . ($profile['apellido'] ?? ''));

        return $nombre !== '' ? $nombre : (string) auth()->user()?->email;
    }
}

if (! function_exists('user_avatar')) {
    function user_avatar(int $size = 96, string $class = ''): string
    {
        $user = auth()->user();

        if (! $user) {
            return '';
        }

        $profile = actual_profile();

        // Pendiente: Implementar la lógica para mostrar la foto de perfil si está disponible.
        /*if (! empty($profile['foto'])) {
            return sprintf(
                '<img src="%s" class="rounded-circle %s" width="%d" height="%d" style="object-fit: cover" alt="">',
                esc(site_url('images/small/' . rawurlencode($profile['foto']))),
                esc($class),
                $size,
                $size
            );
        }*/

        $nombre   = trim($profile['nombre'] ?? '');
        $apellido = trim($profile['apellido'] ?? '');

        $iniciales = ($nombre !== '' || $apellido !== '')
            ? mb_substr($nombre, 0, 1) . mb_substr($apellido, 0, 1)
            : mb_substr(trim((string) $user->email), 0, 2);

        $iniciales = mb_strtoupper($iniciales) ?: '?';

        return sprintf(
            '<div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center %s" style="width: %dpx; height: %dpx; font-size: %dpx" aria-hidden="true">%s</div>',
            esc($class),
            $size,
            $size,
            (int) round($size * 0.4),
            esc($iniciales)
        );
    }
}