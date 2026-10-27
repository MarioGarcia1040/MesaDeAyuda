<?= $this->extend('template/partials/layout') ?>

<?= $this->section('title') ?>Tickets<?= $this->endSection() ?>

<?= $this->section('breadcrumbs') ?>
<li class="breadcrumb-item active" aria-current="page">Tickets</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php

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

?>

<!-- Tarjetas resumen -->
<div class="row g-3 mb-3">
    <?php
    $resume = [
        ['Abiertos',   $countTicketsByStatus['abierto']    ?? 0, 'text-primary'],
        ['En proceso', $countTicketsByStatus['en_proceso'] ?? 0, 'text-warning'],
        ['Pendientes', $countTicketsByStatus['pendiente']  ?? 0, 'text-info'],
        ['Resueltos',  $countTicketsByStatus['resuelto']   ?? 0, 'text-success'],
    ];
    foreach ($resume as [$title, $value, $color]): ?>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-secondary small mb-1"><?= $title ?></p>
                    <h3 class="mb-0 fw-bold <?= $color ?>"><?= $value ?></h3>
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

        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#demoModalScrollable">
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
                        <tr data-estado="<?= esc($t['status']) ?>">
                            <td class="text-nowrap fw-semibold">#<?= esc($t['id']) ?></td>
                            <td>
                                <a href="#" class="fw-semibold text-decoration-none"><?= esc($t['subject']) ?></a>
                                <div class="small text-secondary">
                                    <?= esc($t['applicant_name']) ?> &middot; <?= esc($t['category_name']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?= $estadoBadge[$t['status']] ?>">
                                    <?= $estadoLabel[$t['status']] ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $prioridadBadge[$t['priority']] ?>">
                                    <?= esc(ucfirst($t['priority'])) ?>
                                </span>
                            </td>
                            <td class="text-nowrap"><?= esc($t['assigned_name'] ?: 'Sin asignar') ?></td>
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

<div
    class="modal fade"
    id="demoModalScrollable"
    tabindex="-1"
    aria-labelledby="demoModalScrollableLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="demoModalScrollableLabel">
                    Nuevo Ticket
                </h1>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form>

                    <div class="row mb-3">
                        <label for="applicant" class="col-sm-3 col-form-label">Solicita</label>
                        <div class="col-sm-9">
                            <select id="applicant" name="applicant" class="form-select">
                                <option value="">Todos los estados</option>
                                <?php foreach ($estadoLabel as $valor => $texto): ?>
                                    <option value="<?= $valor ?>"><?= $texto ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="col-sm-3 col-form-label">Categoria</label>
                        <div class="col-sm-9">
                            <select id="category" name="category" class="form-select">
                                <option value="">Todos los estados</option>
                                <?php foreach ($estadoLabel as $valor => $texto): ?>
                                    <option value="<?= $valor ?>"><?= $texto ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-sm-3 col-form-label">Asunto</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-sm-3 col-form-label">Descripción</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" aria-label="With textarea"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="priority" class="col-sm-3 col-form-label">Prioridad</label>
                        <div class="col-sm-9">
                            <select id="priority" name="priority" class="form-select" required>
                                <?php foreach ($priorityLabel as $valor => $texto): ?>
                                    <option value="<?= esc($valor) ?>"
                                        <?= old('priority', \App\Models\TicketsModel::PRIORITY_MEDIUM) === $valor ? 'selected' : '' ?>>
                                        <?= esc($texto) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buscador = document.getElementById('ticket-search');
        const filtro = document.getElementById('ticket-filter-estado');
        const filas = document.querySelectorAll('#tickets-table tbody tr[data-estado]');

        const filtrar = () => {
            const texto = buscador.value.trim().toLowerCase();
            const estado = filtro.value;
            filas.forEach(fila => {
                const coincideTexto = fila.textContent.toLowerCase().includes(texto);
                const coincideEstado = !estado || fila.dataset.estado === estado;
                fila.hidden = !(coincideTexto && coincideEstado);
            });
        };

        buscador.addEventListener('input', filtrar);
        filtro.addEventListener('change', filtrar);
    });
</script>

<?= $this->endSection() ?>