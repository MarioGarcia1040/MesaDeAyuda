<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('pageStyles') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">

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

        <form action="<?= url_to('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="input-group mb-1">
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                        value="<?= old('email', auth()->user()->email ?? null) ?>" required>
                    <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                </div>
                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
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

        <p class="mb-1 mt-3">
            <a href="<?= url_to('login') ?>"><?= lang('Auth.backToLogin') ?></a>
        </p>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>

<script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>

<?= $this->endSection() ?>