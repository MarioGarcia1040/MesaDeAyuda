<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Reglas de validación para llamado desde diferentes controladores.
 * 05-Noviembre-2026 | 06-Noviembre-2026
 * 
 */

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $changePassword = [
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

    public array $updateEmail = [
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

    public array $updateProfile = [
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
    ];

    public array $updateProfilePhoto = [
        'profile-photo' => [
            'label'  => 'Foto',
            'rules'  => 'uploaded[profile-photo]|max_size[profile-photo,4096]|is_image[profile-photo]|mime_in[profile-photo,image/jpeg,image/png]|max_dims[profile-photo,4000,4000]',
            'errors' => [
                'uploaded' => 'No se pudo subir la imagen.',
                'is_image' => 'El archivo seleccionado no es una imagen válida.',
                'max_size' => 'La imagen no puede pesar más de 4MB.',
                'mime_in'  => 'El archivo seleccionado no es un tipo de imagen permitido.',
                'max_dims' => 'La imagen no puede superar los 4000x4000 píxeles.',
            ],
        ],
    ];

    public array $createTicket = [
        'subject'      => [
            'label' => 'Asunto',
            'rules' => 'required|max_length[150]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'max_length' => 'El campo {field} no puede exceder los 150 caracteres.',
            ],
        ],
        'description'  => [
            'label' => 'Descripción',
            'rules' => 'permit_empty|string',
        ],
        'category_id'  => [
            'label' => 'Categoría',
            'rules' => 'permit_empty|is_natural_no_zero',
        ],
        'status' => [
            'label'  => 'Estado',
            'rules'  => 'required|in_list[abierto,en_proceso,resuelto,cerrado]',
            'errors' => [
                'required' => 'El campo {field} es obligatorio.',
                'in_list'  => 'El campo {field} debe ser: abierto, en_proceso, resuelto o cerrado.',
            ],
        ],
        'priority'     => [
            'label' => 'Prioridad',
            'rules' => 'required|in_list[alta,media,baja]',
            'errors' => [
                'required' => 'El campo {field} es obligatorio.',
                'in_list'  => 'El campo {field} debe ser uno de los siguientes valores: alta, media, baja.',
            ],
        ],
        'applicant_id' => [
            'label' => 'Solicitante',
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'El campo {field} es obligatorio.',
                'is_natural_no_zero' => 'El campo {field} debe ser un número natural mayor que cero.',
            ],
        ],
        'assigned_id'  => [
            'label' => 'Asignado a',
            'rules' => 'permit_empty|is_natural_no_zero',
            'errors' => [
                'is_natural_no_zero' => 'El campo {field} debe ser un número natural mayor que cero.',
            ],
        ],
    ];
}
