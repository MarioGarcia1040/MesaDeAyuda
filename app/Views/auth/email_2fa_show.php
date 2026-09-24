<?php

use CodeIgniter\Shield\Entities\User;

?>

<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.email2FATitle') ?> <?= $this->endSection() ?>

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

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5"><?= lang('Auth.email2FATitle') ?></h5>

            <p><?= lang('Auth.confirmEmailAddress') ?></p>

            <?php if (session('error')) : ?>
                <div class="alert alert-danger"><?= esc(session('error')) ?></div>
            <?php endif ?>

            <form action="<?= url_to('auth-action-handle') ?>" method="post" id="formulario">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="mb-2">
                    <input type="email" class="form-control" name="email"
                        inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                        <?php /** @var User $user */ ?>
                        value="<?= old('email', $user->email) ?>" required>
                </div>

                <div class="d-grid col-8 mx-auto m-3">
                    <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.send') ?></button>
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

        </div>
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