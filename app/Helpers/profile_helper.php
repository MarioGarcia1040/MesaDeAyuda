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
    function user_avatar(int $size = 96, string $class = '', bool $zoom = false, ?array $profile = null): string
    {
        // Sin perfil explícito: se usa el del usuario activo (comportamiento actual)
        if ($profile === null) {
            $user = auth()->user();

            if (! $user) {
                return '';
            }

            $profile = actual_profile();
            $email   = (string) $user->email;
        } else {
            $email = (string) ($profile['email'] ?? '');
        }

        if (! empty($profile['foto'])) {
            $foto  = rawurlencode($profile['foto']);
            $attrs = '';
            $style = 'object-fit: cover';

            if ($zoom) {
                $attrs  = ' data-full="' . esc(site_url('profile/avatar/real/' . $foto)) . '"';
                $class .= ' avatar-zoom';
                $style .= '; cursor: zoom-in';
            }

            return sprintf(
                '<img src="%s"%s class="rounded-circle %s" width="%d" height="%d" style="%s" alt="Foto de perfil">',
                esc(site_url('profile/avatar/small/' . $foto)),
                $attrs,
                esc(trim($class)),
                $size,
                $size,
                $style
            );
        }

        $nombre   = trim($profile['nombre'] ?? '');
        $apellido = trim($profile['apellido'] ?? '');

        $iniciales = ($nombre !== '' || $apellido !== '')
            ? mb_substr($nombre, 0, 1) . mb_substr($apellido, 0, 1)
            : mb_substr(trim($email), 0, 2);

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
