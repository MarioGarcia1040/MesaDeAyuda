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

        <div class="alert alert-success" role="alert"><?= lang('Auth.checkYourEmail') ?></div>

        <p class="mb-1 mt-3"><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>

        <p class="mb-0">
            <a href="<?= url_to('login') ?>"><?= lang('Auth.backToLogin') ?></a>
        </p>

    </div>
</div>

<?= $this->endSection() ?>