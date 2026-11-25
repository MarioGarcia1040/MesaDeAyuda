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
    'resuelto'   => 'text-bg-success',
    'cerrado'    => 'text-bg-secondary',
];
$estadoLabel = [
    'abierto'    => 'Abierto',
    'en_proceso' => 'En proceso',
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
        ['Resueltos',  $countTicketsByStatus['resuelto']   ?? 0, 'text-success'],
        ['Cerrados',   $countTicketsByStatus['cerrado']    ?? 0, 'text-secondary'],
    ];
    foreach ($resume as [$title, $value, $color]): ?>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body">
                    <p class="text-secondary small mb-1"><?= esc($title) ?></p>
                    <h3 class="mb-0 fw-bold <?= esc($color) ?>"><?= esc($value) ?></h3>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Listado -->
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 align-items-center">
        <h3 class="card-title mb-0 me-auto">Listado</h3>

        <div class="input-group input-group-sm" style="width: 16rem">
            <span class="input-group-text"><i class="bi bi-search" aria-hidden="true"></i></span>
            <input type="search" id="ticket-search" class="form-control"
                placeholder="Buscar tickets&hellip;" aria-label="Buscar tickets">
        </div>

        <select id="ticket-filter-estado" class="form-select form-select-sm" style="width: 10rem"
            aria-label="Filtrar por estado">
            <option value="">Todos los estados</option>
            <?php foreach ($estadoLabel as $valor => $texto): ?>
                <option value="<?= esc($valor) ?>"><?= esc($texto) ?></option>
            <?php endforeach; ?>
        </select>

        <?php if ($canCreateTicket): ?>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#demoModalScrollable">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>
                Nuevo ticket
            </button>
        <?php endif; ?>

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
                    <tr id="tickets-empty" hidden>
                        <td colspan="7" class="text-center text-muted py-4">No se encontraron tickets.</td>
                    </tr>
                    <?php foreach ($tickets as $t): ?>
                        <tr data-estado="<?= esc($t['status'], 'attr') ?>"
                            data-search="<?= esc(mb_strtolower(implode(' ', [
                                                $t['id'],
                                                $t['subject'],
                                                $t['applicant_name'],
                                                $t['category_name'],
                                                $estadoLabel[$t['status']] ?? '',
                                                $t['priority'],
                                                $t['assigned_name'] ?: 'sin asignar',
                                            ])), 'attr') ?>">
                            <td class="text-nowrap fw-semibold">#<?= esc($t['id']) ?></td>
                            <td>
                                <a href="#" class="fw-semibold text-decoration-none"><?= esc($t['subject']) ?></a>
                                <div class="small text-secondary">
                                    <?= esc($t['applicant_name']) ?> &middot; <?= esc($t['category_name']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?= esc($estadoBadge[$t['status']]) ?>">
                                    <?= esc($estadoLabel[$t['status']]) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= esc($prioridadBadge[$t['priority']]) ?>">
                                    <?= esc(ucfirst($t['priority'])) ?>
                                </span>
                            </td>
                            <td class="text-nowrap"><?= esc($t['assigned_name'] ?: 'Sin asignar') ?></td>
                            <td class="text-nowrap"><?= date('d/m/Y H:i', strtotime(esc($t['created_at']))) ?></td>
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

    <div class="card-footer d-flex flex-wrap align-items-center gap-2">
        <span id="tickets-count" class="fs-7 text-body-secondary" aria-live="polite">
            Mostrando <?= count($tickets) ?> de <?= count($tickets) ?> tickets
        </span>
        <div class="d-flex align-items-center gap-2 ms-auto">
            <select id="tickets-page-size" class="form-select form-select-sm w-auto" aria-label="Tickets por página">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <ul class="pagination pagination-sm m-0" id="tickets-pagination"></ul>
        </div>
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
                <form id="ticketForm" action="<?= base_url('tickets/create') ?>" method="post" novalidate>
                    <?= csrf_field() ?>
                    <input type="hidden" name="status" value="abierto">

                    <div id="ticketFormAlert" class="alert alert-danger d-none"></div>

                    <div class="row mb-3">
                        <?php if ($applicant): ?>
                            <input type="hidden" name="applicant_id" value="<?= esc($applicant) ?>">
                        <?php else: ?>
                            <label for="applicant_id" class="col-sm-3 col-form-label">Solicita</label>
                            <div class="col-sm-9">
                                <select id="applicant_id" name="applicant_id" class="form-select">
                                    <option value="">Seleccione un usuario</option>
                                    <?php foreach ($users as $user): ?>
                                        <?php
                                        $nombreCompleto = trim(($user->nombre ?? '') . ' ' . ($user->apellido ?? ''));
                                        if ($nombreCompleto === '') {
                                            $nombreCompleto = $user->email ?? 'Usuario sin nombre';
                                        }
                                        ?>
                                        <option value="<?= esc($user->id) ?>"><?= esc($nombreCompleto) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row mb-3">
                        <label for="category_id" class="col-sm-3 col-form-label">Categoría</label>
                        <div class="col-sm-9">
                            <select id="category_id" name="category_id" class="form-select">
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= esc($category['id']) ?>"><?= esc($category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="subject" class="col-sm-3 col-form-label">Asunto</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="subject" name="subject">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">Descripción</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="priority" class="col-sm-3 col-form-label">Prioridad</label>
                        <div class="col-sm-9">
                            <select id="priority" name="priority" class="form-select">
                                <?php foreach ($priorityLabel as $valor => $texto): ?>
                                    <option value="<?= esc($valor) ?>"
                                        <?= \App\Models\TicketsModel::PRIORITY_MEDIUM === $valor ? 'selected' : '' ?>>
                                        <?= esc($texto) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="ticketSubmit">Guardar</button>
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
        const selectorTamano = document.getElementById('tickets-page-size');
        const filas = Array.from(document.querySelectorAll('#tickets-table tbody tr[data-estado]'));
        const vacio = document.getElementById('tickets-empty');
        const contador = document.getElementById('tickets-count');
        const nav = document.getElementById('tickets-pagination');

        if (!buscador || !filtro) return;

        let porPagina = parseInt(selectorTamano?.value ?? '10', 10);
        let pagina = 1;
        let coincidentes = filas;

        const normalizar = (s) => s.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();

        // Se calcula una sola vez por fila, no en cada tecla
        const textos = new Map();
        filas.forEach(fila => textos.set(fila, normalizar(fila.textContent)));

        const crearItem = (etiqueta, destino, {
            activo = false,
            deshabilitado = false,
            aria = null
        } = {}) => {
            const li = document.createElement('li');
            li.className = 'page-item' + (activo ? ' active' : '') + (deshabilitado ? ' disabled' : '');

            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.innerHTML = etiqueta;
            if (aria) a.setAttribute('aria-label', aria);
            if (activo) a.setAttribute('aria-current', 'page');

            a.addEventListener('click', (e) => {
                e.preventDefault();
                if (activo || deshabilitado) return;
                pagina = destino;
                render();
            });

            li.appendChild(a);
            return li;
        };

        const dibujarPaginas = (totalPaginas) => {
            nav.replaceChildren();

            const fin = Math.min(totalPaginas, Math.max(1, pagina - 2) + 4);
            const inicio = Math.max(1, fin - 4);

            nav.appendChild(crearItem('&laquo;', pagina - 1, {
                deshabilitado: pagina === 1,
                aria: 'Anterior'
            }));
            for (let i = inicio; i <= fin; i++) {
                nav.appendChild(crearItem(i, i, {
                    activo: i === pagina
                }));
            }
            nav.appendChild(crearItem('&raquo;', pagina + 1, {
                deshabilitado: pagina === totalPaginas,
                aria: 'Siguiente'
            }));
        };

        const render = () => {
            const total = coincidentes.length;
            const totalPaginas = Math.max(1, Math.ceil(total / porPagina));
            pagina = Math.min(pagina, totalPaginas);

            const inicio = (pagina - 1) * porPagina;
            const fin = inicio + porPagina;

            filas.forEach(f => f.hidden = true);
            coincidentes.slice(inicio, fin).forEach(f => f.hidden = false);

            if (vacio) vacio.hidden = total > 0;
            contador.textContent = total ?
                `Mostrando ${inicio + 1} a ${Math.min(fin, total)} de ${total} tickets` :
                'Sin resultados';

            dibujarPaginas(totalPaginas);
        };

        const filtrar = () => {
            const texto = normalizar(buscador.value.trim());
            const estado = filtro.value;

            coincidentes = filas.filter(fila =>
                textos.get(fila).includes(texto) &&
                (!estado || fila.dataset.estado === estado)
            );

            pagina = 1;
            render();
        };

        buscador.addEventListener('input', filtrar);
        filtro.addEventListener('change', filtrar);
        selectorTamano?.addEventListener('change', () => {
            porPagina = parseInt(selectorTamano.value, 10);
            pagina = 1;
            render();
        });

        filtrar(); // aplica los valores restaurados por el navegador
        window.addEventListener('pageshow', filtrar); // y al volver con "atrás"
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('ticketForm');
        const alertB = document.getElementById('ticketFormAlert');
        const btn = document.getElementById('ticketSubmit');
        const csrfName = '<?= csrf_token() ?>';

        const clearErrors = () => {
            alertB.classList.add('d-none');
            alertB.innerHTML = '';
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        };

        const showErrors = (errors) => {
            const general = [];

            Object.entries(errors).forEach(([name, message]) => {
                const field = form.elements[name];
                const fb = field && field.type !== 'hidden' ?
                    field.parentElement.querySelector('.invalid-feedback') :
                    null;

                if (!fb) {
                    general.push(message);
                    return;
                }
                field.classList.add('is-invalid');
                fb.textContent = message;
            });

            if (general.length) {
                alertB.textContent = general.join(' ');
                alertB.classList.remove('d-none');
            }
            form.querySelector('.is-invalid')?.focus();
        };

        const updateCsrf = (token) => {
            if (!token) return;
            const input = form.querySelector(`input[name="${csrfName}"]`);
            if (input) input.value = token;
        };

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();
            btn.disabled = true;
            showLoader('Registrando datos...');
            let redirecting = false;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                let data = null;
                try {
                    data = await response.json();
                } catch (_) {}

                updateCsrf(data?.csrf);

                if (response.status === 422 && data?.errors) {
                    showErrors(data.errors);
                    return;
                }

                if (!response.ok || !data) {
                    alertB.textContent = 'Ocurrió un error inesperado. Intente de nuevo.';
                    alertB.classList.remove('d-none');
                    return;
                }

                // Éxito: se deja el loader visible hasta que la página recargue
                redirecting = true;
                bootstrap.Modal.getInstance(form.closest('.modal'))?.hide();
                window.location.href = data.redirect ?? window.location.href;

            } catch (err) {
                alertB.textContent = 'No se pudo conectar con el servidor.';
                alertB.classList.remove('d-none');
            } finally {
                if (!redirecting) {
                    hideLoader();
                    btn.disabled = false;
                }
            }
        });

        form.closest('.modal')?.addEventListener('hidden.bs.modal', () => {
            form.reset();
            clearErrors();
        });

        window.addEventListener('pageshow', (e) => {
            if (e.persisted) {
                btn.disabled = false;
                hideLoader();
            }
        });
    });
</script>
<?= $this->endSection() ?>