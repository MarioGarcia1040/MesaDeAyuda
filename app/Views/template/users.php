<?= $this->extend('template/partials/layout') ?>

<?= $this->section('title') ?>Usuarios<?= $this->endSection() ?>

<?= $this->section('breadcrumbs') ?>
<li class="breadcrumb-item active" aria-current="page">Usuarios</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--begin::Row-->
<div class="row">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card mb-4">
            <!--begin::Card Header-->
            <div class="card-header">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-4">
                        <h3 class="card-title">Directorio</h3>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text">
                                    <i class="bi bi-search" aria-hidden="true"></i>
                                </span>
                                <input
                                    type="search"
                                    id="user-search"
                                    class="form-control"
                                    placeholder="Buscar..."
                                    aria-label="Buscar..."
                                    style="width: 180px" />
                            </div>
                            <select
                                id="user-role-filter"
                                class="form-select form-select-sm w-auto"
                                aria-label="Filtrar por rol">
                                <option value="all" selected>Todos los roles</option>
                                <?php foreach ($roles as $clave => $rol): ?>
                                    <option value="<?= esc($clave, 'attr') ?>"><?= esc($rol['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Boton nuevo usuario
                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-add-user">
                                <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                                Nuevo usuario
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card Header-->
            <!--begin::Card Body-->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0" id="users-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Registro</th>
                                <!-- Acciones
                                <th class="text-end">Acciones</th>
                                -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <?php
                                $nombreCompleto = trim(($user->nombre ?? '') . ' ' . ($user->apellido ?? ''));
                                $email          = $user->email ?? null;
                                $telefono       = preg_replace('/\D/', '', $user->telefono ?? '');
                                $grupos         = ! empty($user->grupos)
                                    ? array_map('trim', explode(',', $user->grupos))
                                    : [];
                                $fecha          = ! empty($user->register_date)
                                    ? date('d/m/Y', strtotime($user->register_date))
                                    : 'Fecha no disponible';

                                if (($user->status ?? null) === 'banned') {
                                    $estado = 'Bloqueado';
                                } elseif (! ($user->active ?? false)) {
                                    $estado = 'Inactivo';
                                } else {
                                    $estado = 'Activo';
                                }
                                ?>
                                <tr data-role="<?= esc(mb_strtolower(implode(' ', $grupos)), 'attr') ?>"
                                    data-search="<?= esc(mb_strtolower($nombreCompleto . ' ' . $email . ' ' . $telefono . ' ' . $estado . ' ' . $fecha), 'attr') ?>">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?= user_avatar(32, 'shadow me-2', zoom: true, profile: $user) ?>
                                            <span class="fw-medium"><?= esc($nombreCompleto ?: 'Nombre no disponible') ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($email): ?>
                                            <a href="mailto:<?= esc($email, 'attr') ?>"><?= esc($email) ?></a>
                                        <?php else: ?>
                                            <span class="text-muted">Email no disponible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($telefono !== ''): ?>
                                            <a class="btn btn-sm btn-outline-success"
                                                href="https://wa.me/52<?= esc($telefono, 'url') ?>"
                                                target="_blank" rel="noopener noreferrer"
                                                aria-label="WhatsApp de <?= esc($nombreCompleto, 'attr') ?>">
                                                <i class="bi bi-whatsapp" aria-hidden="true"></i>
                                                <?= esc($user->telefono) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($grupos): ?>
                                            <?php foreach ($grupos as $grupo): ?>
                                                <span class="badge text-bg-secondary"><?= esc($roles[$grupo]['title'] ?? ucfirst($grupo)) ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="badge text-bg-light text-dark">Sin grupo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($estado === 'Bloqueado'): ?>
                                            <span class="badge text-bg-danger" title="<?= esc($user->status_message ?? '', 'attr') ?>">Bloqueado</span>
                                        <?php elseif ($estado === 'Inactivo'): ?>
                                            <span class="badge text-bg-warning">Inactivo</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-success">Activo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($fecha) ?></td>
                                    <!-- Acciones
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= site_url('users/edit/' . (int) $user->user_id) ?>"
                                                class="btn btn-outline-secondary"
                                                aria-label="Editar <?= esc($nombreCompleto, 'attr') ?>">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-delete-user"
                                                data-user-id="<?= (int) $user->user_id ?>"
                                                data-user-name="<?= esc($nombreCompleto, 'attr') ?>"
                                                aria-label="Eliminar <?= esc($nombreCompleto, 'attr') ?>">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
                <div id="users-empty" class="text-center text-body-secondary p-4" <?= empty($users) ? '' : 'hidden' ?>>
                    No se encontraron usuarios.
                </div>
            </div>
            <!--end::Card Body-->
            <!--begin::Card Footer-->
            <div class="card-footer d-flex flex-wrap align-items-center gap-2">
                <span id="users-count" class="fs-7 text-body-secondary" aria-live="polite">
                    Mostrando <?= count($users) ?> de <?= count($users) ?> usuarios
                </span>
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <select id="users-page-size" class="form-select form-select-sm w-auto" aria-label="Usuarios por página">
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <ul class="pagination pagination-sm m-0" id="users-pagination"></ul>
                </div>
            </div>
            <!--end::Card Footer-->
        </div>
        <!--end::Card-->
    </div>
    <!-- /.col -->
</div>
<!--end::Row-->
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- components/avatar_zoom.php -->
<div class="modal fade" id="modal-avatar-zoom" tabindex="-1" aria-label="Foto de perfil" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img id="avatar-zoom-img" src="" alt="Foto de perfil ampliada"
                    class="img-fluid rounded shadow" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('click', (e) => {
        const avatar = e.target.closest('.avatar-zoom');
        if (!avatar) return;

        document.getElementById('avatar-zoom-img').src = avatar.dataset.full;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-avatar-zoom')).show();
    });

    document.getElementById('modal-avatar-zoom').addEventListener('hidden.bs.modal', () => {
        document.getElementById('avatar-zoom-img').src = '';
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let porPagina = 10;
        let pagina = 1;

        const selectorTamano = document.getElementById('users-page-size');
        const buscador = document.getElementById('user-search');
        const filtro = document.getElementById('user-role-filter');
        const filas = Array.from(document.querySelectorAll('#users-table tbody tr[data-role]'));
        const contador = document.getElementById('users-count');
        const vacio = document.getElementById('users-empty');
        const nav = document.getElementById('users-pagination');

        let coincidentes = filas;

        // Ignora mayúsculas y acentos (José = jose)
        const normalizar = t => t.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

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

            a.addEventListener('click', e => {
                e.preventDefault();
                if (activo || deshabilitado) return;
                pagina = destino;
                render();
            });

            li.appendChild(a);
            return li;
        };

        const dibujarPaginas = totalPaginas => {
            nav.replaceChildren();

            // Ventana de 5 números alrededor de la página actual
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

            vacio.hidden = total !== 0;
            contador.textContent = total ?
                `Mostrando ${inicio + 1} a ${Math.min(fin, total)} de ${total} usuarios` :
                'Sin resultados';

            dibujarPaginas(totalPaginas);
        };

        const filtrar = () => {
            const texto = normalizar(buscador.value.trim());
            const rol = filtro.value;

            coincidentes = filas.filter(fila => {
                const coincideTexto = normalizar(fila.dataset.search).includes(texto);
                const coincideRol = rol === 'all' || fila.dataset.role.split(' ').includes(rol);
                return coincideTexto && coincideRol;
            });

            pagina = 1; // al cambiar el filtro, vuelve a la primera página
            render();
        };

        buscador.addEventListener('input', filtrar);
        filtro.addEventListener('change', filtrar);
        selectorTamano.addEventListener('change', () => {
            porPagina = parseInt(selectorTamano.value, 10);
            pagina = 1;
            render();
        });

        filtrar();
    });
</script>

<?= $this->endSection() ?>