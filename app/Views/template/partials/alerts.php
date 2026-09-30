<?php
$types = [
    'success' => ['success', 'bi-check-circle-fill'],
    'message' => ['success', 'bi-check-circle-fill'],
    'error'   => ['danger',  'bi-exclamation-triangle-fill'],
    'warning' => ['warning', 'bi-exclamation-circle-fill'],
    'info'    => ['info',    'bi-info-circle-fill'],
];

$errors = session('errors');
$listErrors = (is_array($errors) && array_is_list($errors)) ? $errors : [];
?>

<?php foreach ($types as $key => [$class, $icon]): ?>
    <?php if ($msg = session($key)): ?>
        <div class="alert alert-<?= $class ?> alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi <?= $icon ?> me-2"></i>
            <div><?= esc($msg) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif ?>
<?php endforeach ?>

<?php if ($listErrors): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach ($listErrors as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif ?>