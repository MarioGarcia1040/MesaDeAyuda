<!doctype html>
<html lang="es" data-bs-theme="light">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $this->renderSection('title') ?></title>

    <?= $this->renderSection('pageStyles') ?>

</head>

<body class="login-page bg-body-secondary">

    <main class="login-box">

        <?= $this->renderSection('main') ?>

    </main>

    <?= $this->renderSection('pageScripts') ?>

</body>

</html>