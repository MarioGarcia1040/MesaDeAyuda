<?= $this->extend('template/partials/layout') ?>

<?= $this->section('title') ?>Mi cuenta<?= $this->endSection() ?>

<?= $this->section('breadcrumbs') ?>
<li class="breadcrumb-item active" aria-current="page">Mi cuenta</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$errors    = session('errors') ?? [];
$flashTab  = $activeTab ?? session('tab');
$activeTab = $flashTab ?? 'settings';
?>

<div class="row g-3">
    <!-- Profile sidebar -->
    <div class="col-md-3">
        <!-- About card -->
        <div class="card">
            <div class="card-body text-center">
                <?= user_avatar(96, 'mb-3') ?>

                <?php $tieneNombre = ! empty($profileData['nombre']) || ! empty($profileData['apellido']); ?>
                <h3 class="h5 mb-0"><?= esc(fullname()) ?></h3>
                <?php if ($tieneNombre): ?>
                    <p class="text-secondary mb-3"><?= esc(auth()->user()->email) ?></p>
                <?php else: ?>
                    <div class="mb-3"></div>
                <?php endif ?>
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
                <ul class="nav nav-tabs" id="profile-tabs" role="tablist"
                    <?= $flashTab ? 'data-server-tab="' . esc($flashTab) . '"' : '' ?>>

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
                            class="nav-link <?= $activeTab === 'email' ? 'active' : '' ?>"
                            id="email-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#email"
                            type="button"
                            role="tab"
                            aria-selected="<?= $activeTab === 'email' ? 'true' : 'false' ?>">
                            Email
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

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link <?= $activeTab === 'access_registration' ? 'active' : '' ?>"
                            id="access-registration-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#access-registration"
                            type="button"
                            role="tab"
                            aria-selected="<?= $activeTab === 'access_registration' ? 'true' : 'false' ?>">
                            Registro de accesos
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
                        <form class="row g-3" action="<?= base_url('profile/update-profile') ?>" method="POST" enctype="multipart/form-data" novalidate>
                            <?= csrf_field() ?>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-first-name"> Nombre(s) </label>
                                <input
                                    type="text"
                                    class="form-control <?= isset($errors['profile-first-name']) ? 'is-invalid' : '' ?>"
                                    id="profile-first-name"
                                    name="profile-first-name"
                                    value="<?= esc(old('profile-first-name', $profileData['nombre'] ?? '')) ?>"
                                    placeholder="Nombre(s)" />
                                <?php if (isset($errors['profile-first-name'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['profile-first-name']) ?></div>
                                <?php endif ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-last-name"> Apellido(s) </label>
                                <input type="text" class="form-control <?= isset($errors['profile-last-name']) ? 'is-invalid' : '' ?>" id="profile-last-name" name="profile-last-name" value="<?= esc(old('profile-last-name', $profileData['apellido'] ?? '')) ?>" placeholder="Apellido(s)" />
                                <?php if (isset($errors['profile-last-name'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['profile-last-name']) ?></div>
                                <?php endif ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-phone"> Teléfono </label>
                                <?php
                                $tel = $profileData['telefono'] ?? '';
                                $telFormateado = strlen($tel) === 10
                                    ? sprintf('(%s)%s-%s', substr($tel, 0, 3), substr($tel, 3, 3), substr($tel, 6))
                                    : '';
                                ?>
                                <input
                                    type="text"
                                    class="form-control <?= isset($errors['profile-phone']) ? 'is-invalid' : '' ?>"
                                    id="profile-phone"
                                    placeholder="(999) 999-9999"
                                    inputmode="numeric"
                                    name="profile-phone"
                                    value="<?= esc(old('profile-phone', $telFormateado)) ?>" />
                                <?php if (isset($errors['profile-phone'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['profile-phone']) ?></div>
                                <?php endif ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profile-photo"> Fotografía </label>
                                <input
                                    type="file"
                                    class="form-control <?= isset($errors['profile-photo']) ? 'is-invalid' : '' ?>"
                                    id="profile-photo"
                                    data-gtm-form-interact-field-id="0"
                                    name="profile-photo"
                                    accept="image/jpeg,image/png" />
                                <?php if (isset($errors['profile-photo'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['profile-photo']) ?></div>
                                <?php endif ?>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"> Actualizar </button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Email tab -->
                    <div
                        class="tab-pane fade <?= $activeTab === 'email' ? 'show active' : '' ?>"
                        id="email"
                        role="tabpanel"
                        aria-labelledby="email-tab">
                        <form class="row g-3" action="<?= base_url('profile/update-email') ?>" method="POST" novalidate>
                            <?= csrf_field() ?>

                            <div class="col-md-6">
                                <label class="form-label" for="profile-new-email"> Nuevo </label>
                                <input
                                    type="email"
                                    class="form-control <?= isset($errors['profile-new-email']) ? 'is-invalid' : '' ?>"
                                    id="profile-new-email"
                                    name="profile-new-email"
                                    pattern="[^@\s]+@[^@\s]+\.[^@\s]{2,}"
                                    value=""
                                    placeholder="Nuevo email"
                                    required />
                                <?php if (isset($errors['profile-new-email'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['profile-new-email']) ?></div>
                                <?php endif ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="new-email-password-verification"> Contraseña </label>
                                <input type="password"
                                    class="form-control <?= isset($errors['new-email-password-verification']) ? 'is-invalid' : '' ?>"
                                    id="new-email-password-verification" name="new-email-password-verification"
                                    autocomplete="current-password" required>
                                <?php if (isset($errors['new-email-password-verification'])): ?>
                                    <div class="invalid-feedback"><?= esc($errors['new-email-password-verification']) ?></div>
                                <?php endif ?>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-0">Actual: <b><?= esc(auth()->user()->email) ?></b></p>
                            </div>

                            <div class="col-6">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">Cancelar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Password tab -->
                    <div
                        class="tab-pane fade <?= $activeTab === 'password' ? 'show active' : '' ?>"
                        id="password"
                        role="tabpanel"
                        aria-labelledby="password-tab">
                        <form class="row g-3" action="<?= base_url('profile/update-password') ?>" method="POST" novalidate>
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
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="reset" class="btn btn-outline-secondary ms-1">Cancelar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Access Registration tab -->
                    <div
                        class="tab-pane fade <?= ($activeTab ?? '') === 'access_registration' ? 'show active' : '' ?>"
                        id="access-registration"
                        role="tabpanel"
                        aria-labelledby="access-registration-tab">
                        <?php if (empty($accesses)): ?>
                            <p class="text-secondary mb-0">Aún no hay accesos registrados.</p>
                        <?php else: ?>
                            <?php
                            $seeUserAgent = auth()->user()->inGroup('admin', 'superadmin');
                            $total        = count($accesses);
                            ?>
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($accesses as $i => $a): ?>
                                    <li class="d-flex gap-3 <?= $i < $total - 1 ? 'mb-3' : '' ?>">
                                        <span class="badge <?= $a->success ? 'text-bg-success' : 'text-bg-danger' ?> rounded-pill flex-shrink-0 align-self-start mt-1">
                                            <i class="bi <?= $a->success ? 'bi-check-lg' : 'bi-x-lg' ?>" aria-hidden="true"></i>
                                        </span>
                                        <div style="min-width: 0">
                                            <p class="mb-0 fw-semibold">
                                                <?= $a->success ? 'Inicio de sesión exitoso' : 'Intento fallido' ?>
                                            </p>
                                            <small class="text-secondary d-block">
                                                <?= esc($a->date->setTimezone('America/Mexico_City')->format('d/m/Y H:i')) ?>
                                                &middot; IP <?= esc($a->ip_address) ?>
                                            </small>
                                            <?php if ($seeUserAgent): ?>
                                                <small class="text-secondary d-block text-truncate"
                                                    title="<?= esc($a->user_agent) ?>">
                                                    <?= esc($a->user_agent) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
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
        IMask(document.getElementById('profile-phone'), {
            mask: '(000) 000-0000'
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const KEY = 'profile-active-tab';
        const tabs = document.getElementById('profile-tabs');

        if (tabs.dataset.serverTab) {
            // El servidor manda: guarda esa pestaña como la actual
            const active = tabs.querySelector('.nav-link.active');
            if (active) sessionStorage.setItem(KEY, active.dataset.bsTarget);
        } else {
            // Recarga normal: restaura la última pestaña
            const saved = sessionStorage.getItem(KEY);
            const btn = saved && tabs.querySelector(`[data-bs-target="${saved}"]`);
            if (btn) bootstrap.Tab.getOrCreateInstance(btn).show();
        }

        tabs.addEventListener('shown.bs.tab', (e) => {
            sessionStorage.setItem(KEY, e.target.dataset.bsTarget);
        });
    });
</script>
<?= $this->endSection() ?>