# MesaDeAyuda
## Sistema de mesa de ayuda por tickets. Está desarrollado con PHP (CodeIgniter 4), JavaScript, CSS, MySQL/MariaDB, AdminLTE como plantilla de interfaz y Shield para control de acceso y privilegios.

Características principales
Registro y seguimiento de tickets de soporte

Tecnologías
PHP (CodeIgniter 4)
MySQL / MariaDB
JavaScript, CSS, AdminLTE, Shield
Composer para dependencias PHP
Requisitos del servidor
PHP 8.1 o superior (se recomienda PHP 8.2+)
Extensiones PHP necesarias:
intl
mbstring
json (habilitado por defecto)
mysqlnd (si usas MySQL)
curl / libcurl (si usas HTTP\CURLRequest)
(Opcional) Composer instalado globalmente
Advertencias de soporte:

Fin de soporte PHP 7.4: 2022-11-28
Fin de soporte PHP 8.0: 2023-11-28
Fin de soporte PHP 8.1: 2025-12-31
Instalación (pasos recomendados)
Clona el repositorio: git clone https://github.com/MarioGarcia1040/shoei.git
Entra al directorio del proyecto: cd shoei
Instala dependencias PHP: composer install
Copia el archivo de entorno: cp env .env
Edita .env y configura:
APP_BASEURL (la URL de tu aplicación)
Database: hostname, username, password, database (por defecto imadic)
APP_ENV, APP_DEBUG según entorno
Crea la base de datos (por ejemplo miBaseDeDatos) en MySQL/MariaDB.
Ejecuta migraciones (si el proyecto incluye migraciones de CodeIgniter): php spark migrate (Si no hay migraciones, importa el script SQL proporcionado en /database o en la carpeta correspondiente.)
Ajusta permisos: chmod -R 755 writable chmod -R 755 public/uploads (según sea necesario)
Configura el servidor web:
El document root debe apuntar a la carpeta public/ del proyecto.
Por ejemplo, en Apache usar un VirtualHost que apunte a /ruta/a/shoei/public.
Inicia la aplicación (modo desarrollo): php spark serve --host=0.0.0.0 --port=8080
Configuración importante
index.php se encuentra dentro de la carpeta public/ por seguridad. Asegúrate de que el servidor web no señale a la raíz del proyecto.
Genera o configura la key de encriptación si el proyecto la requiere (revisar config/Encryption.php o .env).
Estructura recomendada de .env (ejemplo mínimo)
APP_ENV = development APP_DEBUG = true app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost database.default.database = escuela database.default.username = tu_usuario database.default.password = tu_contraseña database.default.DBDriver = MySQLi

Buenas prácticas y seguridad
No subas el .env con credenciales a repositorios públicos.
Mantén actualizado PHP y las dependencias.
Limpia permisos y desactiva APP_DEBUG en producción.
Realiza backups de la base de datos periódicamente.
Desarrollo y contribuciones
Añade instrucciones para ejecutar tests o linters si existen.
Describe el flujo para crear issues y pull requests.
Incluye un archivo CONTRIBUTING.md para normas de contribución.

## Licencia

Este proyecto está bajo la licencia MIT.  
Consulta el archivo [LICENSE](MIT License.txt) para más detalles.

Contacto
Desarrollado por: Mario García — mariogarcia1040@gmail.com | Búho Computación 11/Enero/2026 

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
