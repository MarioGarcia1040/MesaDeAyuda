<p>Hola <?= esc($username) ?>,</p>
<p>Se creó una cuenta para ti. Entra con este enlace:</p>
<p><a href="<?= esc($link, 'attr') ?>">Acceder al sistema</a></p>
<p>El enlace es de un solo uso y expira pronto. Si caduca, puedes pedir otro desde la pantalla de inicio de sesión.</p>