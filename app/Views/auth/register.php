<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

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

        <form action="<?= url_to('register') ?>" method="post">
            <?= csrf_field() ?>

            <div class="input-group mb-1">
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                    <label for="floatingEmailInput"><?= lang('Auth.email') ?></label>
                </div>
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
            </div>

            <div class="input-group mb-1">
                <div class="form-floating">
                    <input type="text" class="form-control" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" required>
                    <label for="floatingUsernameInput"><?= lang('Auth.username') ?></label>
                </div>
                <div class="input-group-text">
                    <span class="bi bi-person"></span>
                </div>
            </div>

            <div class="input-group mb-1">
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>" required>
                    <label for="floatingPasswordInput"><?= lang('Auth.password') ?></label>
                </div>
                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
                </div>
            </div>

            <div class="input-group mb-1">
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>" required>
                    <label for="floatingPasswordConfirmInput"><?= lang('Auth.passwordConfirm') ?></label>
                </div>
                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-6 d-inline-flex align-items-center">                    
                </div>
                <div class="col-6">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= lang('Auth.register') ?></button>
                    </div>
                </div>
            </div>
        </form>

        <p class="mb-1 mt-3">
            <?= lang('Auth.haveAccount') ?> <a href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a>
        </p>

        <?= $this->endSection() ?>