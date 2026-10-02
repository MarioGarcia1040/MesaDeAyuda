<?= $this->extend('template/partials/layout') ?>

<?= $this->section('title') ?>Tickets<?= $this->endSection() ?>

<?= $this->section('breadcrumbs') ?>
<li class="breadcrumb-item active" aria-current="page">Tickets</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
// DATOS DE EJEMPLO: bórralos cuando tengas tu modelo
$tickets = [
    ['id' => 1, 'asunto' => 'No puedo acceder al correo', 'solicitante' => 'Laura Pérez', 'categoria' => 'Correo',
     'estado' => 'abierto', 'prioridad' => 'alta', 'asignado' => 'Mario', 'created_at' => '2026-10-01 09:15:00'],
    ['id' => 2, 'asunto' => 'Impresora de recepción sin tinta', 'solicitante' => 'Carlos Ruiz', 'categoria' => 'Hardware',
     'estado' => 'en_proceso', 'prioridad' => 'media', 'asignado' => 'Mario', 'created_at' => '2026-09-30 16:40:00'],
    ['id' => 3, 'asunto' => 'Solicitud de alta de usuario', 'solicitante' => 'Ana Torres', 'categoria' => 'Accesos',
     'estado' => 'pendiente', 'prioridad' => 'baja', 'asignado' => null, 'created_at' => '2026-09-29 11:05:00'],
    ['id' => 4, 'asunto' => 'Internet lento en sala de estudios', 'solicitante' => 'Jorge Díaz', 'categoria' => 'Red',
     'estado' => 'resuelto', 'prioridad' => 'media', 'asignado' => 'Mario', 'created_at' => '2026-09-28 08:30:00'],
];

$estadoBadge = [
    'abierto'    => 'text-bg-primary',
    'en_proceso' => 'text-bg-warning',
    'pendiente'  => 'text-bg-info',
    'resuelto'   => 'text-bg-success',
    'cerrado'    => 'text-bg-secondary',
];
$estadoLabel = [
    'abierto'    => 'Abierto',
    'en_proceso' => 'En proceso',
    'pendiente'  => 'Pendiente',
    'resuelto'   => 'Resuelto',
    'cerrado'    => 'Cerrado',
];
$prioridadBadge = [
    'alta'  => 'text-bg-danger',
    'media' => 'text-bg-info',
    'baja'  => 'text-bg-secondary',
];

// Contadores calculados a partir del arreglo
$conteo = array_count_values(array_column($tickets, 'estado'));
?>

<!-- Tarjetas resumen -->
<div class="row g-3 mb-3">
    <?php
    $resumen = [
        ['Abiertos',   $conteo['abierto']    ?? 0, 'text-primary'],
        ['En proceso', $conteo['en_proceso'] ?? 0, 'text-warning'],
        ['Pendientes', $conteo['pendiente']  ?? 0, 'text-info'],
        ['Resueltos',  $conteo['resuelto']   ?? 0, 'text-success'],
    ];
    foreach ($resumen as [$titulo, $valor, $color]): ?>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-secondary small mb-1"><?= $titulo ?></p>
                    <h3 class="mb-0 fw-bold <?= $color ?>"><?= $valor ?></h3>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Listado -->
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 align-items-center">
        <h3 class="card-title mb-0 me-auto">Todos los tickets</h3>

        <div class="input-group input-group-sm" style="width: 16rem">
            <span class="input-group-text"><i class="bi bi-search" aria-hidden="true"></i></span>
            <input type="search" id="ticket-search" class="form-control"
                   placeholder="Buscar tickets&hellip;" aria-label="Buscar tickets">
        </div>

        <select id="ticket-filter-estado" class="form-select form-select-sm" style="width: 10rem"
                aria-label="Filtrar por estado">
            <option value="">Todos los estados</option>
            <?php foreach ($estadoLabel as $valor => $texto): ?>
                <option value="<?= $valor ?>"><?= $texto ?></option>
            <?php endforeach; ?>
        </select>

        <button type="button" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
            Nuevo ticket
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="tickets-table">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Asunto</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Asignado a</th>
                        <th>Creado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($tickets as $t): ?>
                    <tr data-estado="<?= esc($t['estado']) ?>">
                        <td class="text-nowrap fw-semibold">#<?= esc($t['id']) ?></td>
                        <td>
                            <a href="#" class="fw-semibold text-decoration-none"><?= esc($t['asunto']) ?></a>
                            <div class="small text-secondary">
                                <?= esc($t['solicitante']) ?> &middot; <?= esc($t['categoria']) ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?= $estadoBadge[$t['estado']] ?>">
                                <?= $estadoLabel[$t['estado']] ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $prioridadBadge[$t['prioridad']] ?>">
                                <?= esc(ucfirst($t['prioridad'])) ?>
                            </span>
                        </td>
                        <td class="text-nowrap"><?= esc($t['asignado'] ?? 'Sin asignar') ?></td>
                        <td class="text-nowrap"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" type="button" title="Ver">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-outline-secondary" type="button" title="Editar">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <small class="text-secondary">Mostrando <?= count($tickets) ?> tickets</small>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscador = document.getElementById('ticket-search');
        const filtro   = document.getElementById('ticket-filter-estado');
        const filas    = document.querySelectorAll('#tickets-table tbody tr[data-estado]');

        const filtrar = () => {
            const texto  = buscador.value.trim().toLowerCase();
            const estado = filtro.value;
            filas.forEach(fila => {
                const coincideTexto  = fila.textContent.toLowerCase().includes(texto);
                const coincideEstado = !estado || fila.dataset.estado === estado;
                fila.hidden = !(coincideTexto && coincideEstado);
            });
        };

        buscador.addEventListener('input', filtrar);
        filtro.addEventListener('change', filtrar);
    });
</script>
<?= $this->endSection() ?>