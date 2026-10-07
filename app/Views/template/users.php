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
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user1-128x128.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Alexander Pierce</span>
                                    </div>
                                </td>
                                <td><a href="mailto:alexander.pierce@example.com">alexander.pierce@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-danger"> Administrator </span>
                                </td>
                                <td>
                                    <span class="badge text-bg-success">Active</span>
                                </td>
                                <td>Mar 12, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Alexander Pierce">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Alexander Pierce">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user3-128x128.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Sarah Bullock</span>
                                    </div>
                                </td>
                                <td><a href="mailto:sarah.bullock@example.com">sarah.bullock@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-primary">Editor</span>
                                </td>
                                <td>
                                    <span class="badge text-bg-success">Active</span>
                                </td>
                                <td>Apr 3, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Sarah Bullock">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Sarah Bullock">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user6-128x128.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Daniel Cooper</span>
                                    </div>
                                </td>
                                <td><a href="mailto:daniel.cooper@example.com">daniel.cooper@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-info">Author</span>
                                </td>
                                <td>
                                    <span class="badge text-bg-warning">Pending</span>
                                </td>
                                <td>Apr 28, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Daniel Cooper">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Daniel Cooper">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user4-128x128.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Nora Vans</span>
                                    </div>
                                </td>
                                <td><a href="mailto:nora.vans@example.com">nora.vans@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-primary">Editor</span>
                                </td>
                                <td>
                                    <span class="badge text-bg-success">Active</span>
                                </td>
                                <td>May 9, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Nora Vans">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Nora Vans">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user7-128x128.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Jane Holland</span>
                                    </div>
                                </td>
                                <td><a href="mailto:jane.holland@example.com">jane.holland@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-secondary"> Subscriber </span>
                                </td>
                                <td>
                                    <span class="badge text-bg-success">Active</span>
                                </td>
                                <td>May 21, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Jane Holland">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Jane Holland">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user8-128x128.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Kenneth Miles</span>
                                    </div>
                                </td>
                                <td><a href="mailto:kenneth.miles@example.com">kenneth.miles@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-info">Author</span>
                                </td>
                                <td>
                                    <span class="badge text-bg-danger"> Suspended </span>
                                </td>
                                <td>Jun 2, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Kenneth Miles">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Kenneth Miles">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user2-160x160.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium"> Nadia Carmichael </span>
                                    </div>
                                </td>
                                <td><a href="mailto:nadia.carmichael@example.com">nadia.carmichael@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-secondary"> Subscriber </span>
                                </td>
                                <td>
                                    <span class="badge text-bg-success">Active</span>
                                </td>
                                <td>Jun 15, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Nadia Carmichael">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Nadia Carmichael">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/user5-128x128.jpg') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Marcus Reed</span>
                                    </div>
                                </td>
                                <td><a href="mailto:marcus.reed@example.com">marcus.reed@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-primary">Editor</span>
                                </td>
                                <td>
                                    <span class="badge text-bg-warning">Pending</span>
                                </td>
                                <td>Jun 24, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Marcus Reed">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Marcus Reed">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img
                                            src="<?= base_url('dist/assets/img/avatar5.png') ?>"
                                            alt=""
                                            class="img-size-32 rounded-circle me-2" />
                                        <span class="fw-medium">Elena Weber</span>
                                    </div>
                                </td>
                                <td><a href="mailto:elena.weber@example.com">elena.weber@example.com</a></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-success"
                                            onclick="window.open('https://wa.me/524771174322', '_blank')"
                                            aria-label="WhatsApp">
                                            <i class="bi bi-whatsapp" aria-hidden="true">
                                                (477) 117-4322
                                            </i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-secondary"> Subscriber </span>
                                </td>
                                <td>
                                    <span class="badge text-bg-success">Active</span>
                                </td>
                                <td>Jul 1, 2025</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            aria-label="Edit Elena Weber">
                                            <i class="bi bi-pencil" aria-hidden="true"> </i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-user"
                                            aria-label="Delete Elena Weber">
                                            <i class="bi bi-trash" aria-hidden="true"> </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
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