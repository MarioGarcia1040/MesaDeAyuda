<?= $this->extend('template/partials/layout') ?>

<?= $this->section('title') ?>Mi cuenta<?= $this->endSection() ?>

<?= $this->section('breadcrumbs') ?>
<li class="breadcrumb-item active" aria-current="page">Mi cuenta</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-3">
    <!-- Profile sidebar -->
    <div class="col-md-3">
        <!-- About card -->
        <div class="card">
            <div class="card-body text-center">
                <div
                    class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3"
                    style="width: 96px; height: 96px; font-size: 2rem"
                    aria-hidden="true">
                    JD
                </div>
                <h3 class="h5 mb-0"><?= auth()->user()->username ?></h3>
                <p class="text-secondary mb-3"><?= auth()->user()->email ?></p>
                <ul class="list-group list-group-flush text-start small">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Registro</span>
                        <span class="fw-semibold"><?= auth()->user()->created_at?->setTimezone('America/Mexico_City')->format('d/m/Y H:i') ?? '—' ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Actualización</span>
                        <span class="fw-semibold"><?= auth()->user()->updated_at?->setTimezone('America/Mexico_City')->format('d/m/Y H:i') ?? '—' ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Acceso</span>
                        <span class="fw-semibold"><?= auth()->user()->last_active?->setTimezone('America/Mexico_City')->format('d/m/Y H:i') ?? '—' ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tabbed content -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="profile-tabs" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="settings-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#settings"
                            type="button"
                            role="tab"
                            aria-selected="false">
                            Mis datos
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="password-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#password"
                            type="button"
                            role="tab"
                            aria-selected="false">
                            Contraseña
                        </button>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">

                    <!-- Settings tab -->
                    <div
                        class="tab-pane fade show active"
                        id="settings"
                        role="tabpanel"
                        aria-labelledby="settings-tab">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="profile-first"> Nombre(s) </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="profile-first"
                                    value="Nombre" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-last"> Apellido(s) </label>
                                <input type="text" class="form-control" id="profile-last" value="Apellidos" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-email"> Email </label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="profile-email"
                                    value="<?= auth()->user()->email ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-role"> Rol </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="profile-role"
                                    value="<?= auth()->user()->roles[0] ?? 'User' ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-telefono"> Teléfono </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="profile-telefono"
                                    value="<?= auth()->user()->telefono ?? '' ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-fotografia"> Fotografía </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="profile-fotografia"
                                    value="<?= auth()->user()->fotografia ?? '' ?>" />
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Password tab -->
                    <div
                        class="tab-pane fade"
                        id="password"
                        role="tabpanel"
                        aria-labelledby="password-tab">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="actual-password"> Actual </label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="actual-password"
                                    value="" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="new-password"> Nueva </label>
                                <input type="password" class="form-control" id="new-password" value="" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="repeat-new-password"> Repetir</label>
                                <input type="password" class="form-control" id="repeat-new-password" value="" />
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    // JS específico de esta vista (opcional)   
</script>
<?= $this->endSection() ?>