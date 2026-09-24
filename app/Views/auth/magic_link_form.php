<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">

<style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <a href="<?= site_url('/') ?>" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
            <img src="<?= base_url('dist/assets/img/shoei-logo.png') ?>" alt="Shoei" class="img-fluid d-block mx-auto" style="max-height: 150px;">
        </a>
    </div>
    <div class="card-body login-card-body">

        <p class="login-box-msg"><?= lang('Auth.useMagicLink') ?></p>

        <?php if (session('error') !== null) : ?>
            <div class="alert alert-danger" role="alert"><?= esc(session('error')) ?></div>
        <?php elseif (session('errors') !== null) : ?>
            <div class="alert alert-danger" role="alert">
                <?php if (is_array(session('errors'))) : ?>
                    <?php foreach (session('errors') as $error) : ?>
                        <?= esc($error) ?>
                        <br>
                    <?php endforeach ?>
                <?php else : ?>
                    <?= esc(session('errors')) ?>
                <?php endif ?>
            </div>
        <?php endif ?>

        <form action="<?= url_to('magic-link') ?>" method="post" id="formulario">
            <?= csrf_field() ?>

            <div class="input-group mb-1">
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                        value="<?= old('email', auth()->user()->email ?? null) ?>" required>
                    <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                </div>
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= lang('Auth.send') ?></button>
                    </div>
                </div>
            </div>

        </form>

        <div id="loader-overlay" class="loader-overlay d-none" role="status" aria-live="polite">
            <div class="text-white text-center">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2">Verificando datos...</p>
            </div>
        </div>

        <p class="mb-1 mt-3">
            <a href="<?= url_to('login') ?>"><?= lang('Auth.backToLogin') ?></a>
        </p>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>

<script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
<script>
    document.getElementById('formulario').addEventListener('submit', function() {
        document.getElementById('loader-overlay').classList.remove('d-none');
        this.querySelector('button[type="submit"]').disabled = true;
    });
</script>

<?= $this->endSection() ?>