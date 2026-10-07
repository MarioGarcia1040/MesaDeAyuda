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
                                aria-label="Filter by role">
                                <option value="all" selected>Todos los roles</option>
                                <option value="administrator">Administrador</option>
                                <option value="author">Soporte TI</option>
                                <option value="subscriber">Usuario</option>
                            </select>
                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-add-user">
                                <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                                Nuevo usuario
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card Header-->
            <!--begin::Card Body-->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Registro</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <?php
                                $nombreCompleto = trim(($user['nombre'] ?? '') . ' ' . ($user['apellido'] ?? ''));
                                $email          = $user['email'] ?? null;
                                $telefono       = preg_replace('/\D/', '', $user['telefono'] ?? '');
                                $grupos         = ! empty($user['grupos']) ? explode(',', $user['grupos']) : [];
                                $fecha          = ! empty($user['created_at'])
                                    ? date('d/m/Y', strtotime($user['created_at']))
                                    : 'Fecha no disponible';
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?= user_avatar(32, 'shadow') ?>
                                            <span class="fw-medium"><?= esc($nombreCompleto) ?></span>
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
                                                <?= esc($user['telefono']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($grupos): ?>
                                            <?php foreach ($grupos as $grupo): ?>
                                                <span class="badge text-bg-secondary"><?= esc(ucfirst($grupo)) ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="badge text-bg-light text-dark">Sin grupo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (($user['status'] ?? null) === 'banned'): ?>
                                            <span class="badge text-bg-danger" title="<?= esc($user['status_message'] ?? '', 'attr') ?>">Bloqueado</span>
                                        <?php elseif (! $user['active']): ?>
                                            <span class="badge text-bg-warning">Inactivo</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-success">Activo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($fecha) ?></td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= site_url('users/edit/' . (int) $user['user_id']) ?>"
                                                class="btn btn-outline-secondary"
                                                aria-label="Editar <?= esc($nombreCompleto, 'attr') ?>">
                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-delete-user"
                                                data-user-id="<?= (int) $user['user_id'] ?>"
                                                data-user-name="<?= esc($nombreCompleto, 'attr') ?>"
                                                aria-label="Eliminar <?= esc($nombreCompleto, 'attr') ?>">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!--end::Card Body-->
            <!--begin::Card Footer-->
            <div class="card-footer clearfix">
                <div class="float-start pt-1 fs-7 text-body-secondary">
                    Showing 1 to 9 of 42 users
                </div>
                <ul class="pagination pagination-sm m-0 float-end">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous"> &laquo; </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">4</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">5</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next"> &raquo; </a>
                    </li>
                </ul>
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
<?= $this->endSection() ?>