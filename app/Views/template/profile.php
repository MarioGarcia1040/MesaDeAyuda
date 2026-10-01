<?= $this->extend('template/partials/layout') ?>

<?= $this->section('title') ?>Mi cuenta<?= $this->endSection() ?>

<?= $this->section('breadcrumbs') ?>
<li class="breadcrumb-item active" aria-current="page">Mi cuenta</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$activeTab = session('tab') ?? 'settings';
$errors    = session('errors') ?? [];
?>
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
                    <?= esc(mb_strtoupper(mb_substr(auth()->user()->username, 0, 2))) ?>
                </div>
                <h3 class="h5 mb-0"><?= esc(auth()->user()->username) ?></h3>
                <p class="text-secondary mb-3"><?= esc(auth()->user()->email) ?></p>
                <ul class="list-group list-group-flush text-start small">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Registro</span>
                        <span class="fw-semibold"><?= esc(auth()->user()->created_at?->setTimezone('America/Mexico_City')->format('d/m/Y H:i') ?? '—') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Actualización</span>
                        <span class="fw-semibold"><?= esc(auth()->user()->updated_at?->setTimezone('America/Mexico_City')->format('d/m/Y H:i') ?? '—') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Acceso</span>
                        <span class="fw-semibold"><?= esc(auth()->user()->last_active?->setTimezone('America/Mexico_City')->format('d/m/Y H:i') ?? '—') ?></span>
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
                            class="nav-link <?= $activeTab === 'settings' ? 'active' : '' ?>"
                            id="settings-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#settings"
                            type="button"
                            role="tab"
                            aria-selected="<?= $activeTab === 'settings' ? 'true' : 'false' ?>">
                            Mis datos
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link <?= $activeTab === 'password' ? 'active' : '' ?>"
                            id="password-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#password"
                            type="button"
                            role="tab"
                            aria-selected="<?= $activeTab === 'password' ? 'true' : 'false' ?>">
                            Contraseña
                        </button>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">

                    <!-- Settings tab -->
                    <div
                        class="tab-pane fade <?= $activeTab === 'settings' ? 'show active' : '' ?>"
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
                                    value=""
                                    placeholder="Nombre(s)" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-last"> Apellido(s) </label>
                                <input type="text" class="form-control" id="profile-last" value="" placeholder="Apellido(s)" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-email"> Email </label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="profile-email"
                                    pattern="[^@\s]+@[^@\s]+\.[^@\s]{2,}"
                                    value="<?= esc(auth()->user()->email) ?>" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-role"> Rol </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="profile-role"
                                    value="<?= esc(auth()->user()->getGroups()[0] ?? '-') ?>" readonly />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-telefono"> Teléfono </label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="profile-telefono"
                                    placeholder="(999) 999-9999"
                                    inputmode="numeric"
                                    name="profile-telefono"
                                    value="<?= esc(auth()->user()->telefono ?? '') ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-fotografia"> Fotografía </label>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="profile-fotografia"
                                    data-gtm-form-interact-field-id="0"
                                    value="" />
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
                        class="tab-pane fade <?= $activeTab === 'password' ? 'show active' : '' ?>"
                        id="password"
                        role="tabpanel"
                        aria-labelledby="password-tab">
                        <form class="row g-3" action="<?= base_url('cuenta/cambiar-contrasena') ?>" method="POST" novalidate>
                            <?= csrf_field() ?>

                            <div class="col-md-12">
                                <label class="form-label" for="actual-password">Actual</label>
                                <input type="password"
                                    class="form-control <?= isset($errors['actual-password']) ? 'is-invalid' : '' ?>"
                                    id="actual-password" name="actual-password"
                                    autocomplete="current-password" required>
                                <?php if (isset($errors['actual-password'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['actual-password']) ?></div>
                                <?php endif ?>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="new-password">Nueva</label>
                                <input type="password"
                                    class="form-control <?= isset($errors['new-password']) ? 'is-invalid' : '' ?>"
                                    id="new-password" name="new-password"
                                    autocomplete="new-password" required>
                                <?php if (isset($errors['new-password'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['new-password']) ?></div>
                                <?php endif ?>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="confirm-password">Repetir</label>
                                <input type="password"
                                    class="form-control <?= isset($errors['confirm-password']) ? 'is-invalid' : '' ?>"
                                    id="confirm-password" name="confirm-password"
                                    autocomplete="new-password" required>
                                <?php if (isset($errors['confirm-password'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['confirm-password']) ?></div>
                                <?php endif ?>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">Cancelar</button>
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
<script src="https://cdn.jsdelivr.net/npm/imask@7.6.1/dist/imask.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        IMask(document.getElementById('profile-telefono'), {
            mask: '(000) 000-0000'
        });
    });
</script>
<?= $this->endSection() ?>