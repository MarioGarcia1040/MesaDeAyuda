# Sistema de Mesa de Ayuda

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4-DD4814?style=for-the-badge&logo=codeigniter&logoColor=white)
![Shield](https://img.shields.io/badge/Shield-Authentication-red?style=for-the-badge)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Sistema de mesa de ayuda (Help Desk) desarrollado con **PHP (CodeIgniter 4)**, **JavaScript**, **CSS** y **MySQL**. Utiliza **CodeIgniter Shield** para autenticación y control de acceso, y **AdminLTE** como plantilla para la interfaz administrativa.

## Características principales

- Registro y seguimiento de tickets.
- Gestión de usuarios.
- Administración de permisos mediante CodeIgniter Shield.
- Interfaz basada en AdminLTE.
- Arquitectura MVC con CodeIgniter 4.
- Base de datos MySQL/MariaDB.

---

## Tecnologías utilizadas

- PHP 8.2+
- CodeIgniter 4
- CodeIgniter Shield
- MySQL / MariaDB
- JavaScript
- CSS
- AdminLTE
- Composer

---

## Requisitos del servidor

- PHP 8.2 o superior.
- MySQL 5.7+ o MariaDB 10.4+.
- Composer 2.x.

### Extensiones PHP requeridas

- intl
- mbstring
- json
- mysqlnd
- curl
- openssl
- fileinfo

---

## Compatibilidad de versiones PHP

| Versión PHP | Estado |
|------------|---------|
| 8.4 | ✅ Soportada |
| 8.3 | ✅ Soportada |
| 8.2 | ✅ Soportada |
| 8.1 | ❌ Fin de soporte |
| 8.0 | ❌ Fin de soporte |
| 7.4 | ❌ Fin de soporte |

> [!IMPORTANT]
> Este proyecto requiere PHP 8.2 o superior. Se recomienda utilizar una versión de PHP con soporte activo para recibir actualizaciones de seguridad y compatibilidad.

> [!WARNING]
> Las versiones de PHP que han alcanzado su fin de soporte ya no reciben correcciones de seguridad y no deben utilizarse en entornos de producción.

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/MarioGarcia1040/MesaDeAyuda.git
cd MesaDeAyuda
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar variables de entorno

```bash
cp env .env
```

Edita el archivo `.env` y configura:

- `app.baseURL`
- Credenciales de la base de datos
- `CI_ENVIRONMENT`
- Configuración específica del entorno

---

### 4. Crear la base de datos

Ejemplo:

```sql
CREATE DATABASE mesa_de_ayuda;
```

---

### 5. Configurar la conexión a la base de datos

Edita el archivo `.env`:

```env
database.default.hostname = localhost
database.default.database = mesa_de_ayuda
database.default.username = usuario
database.default.password = contraseña
database.default.DBDriver = MySQLi
```

---

### 6. Ejecutar migraciones

```bash
php spark migrate
```

Si el proyecto no utiliza migraciones de CodeIgniter, importa el archivo SQL correspondiente incluido en el proyecto.

---

### 7. Configuración de CodeIgniter Shield

Ejecuta todas las migraciones disponibles:

```bash
php spark migrate --all
```

Verifica que existan las tablas de autenticación:

- users
- auth_identities
- auth_logins
- auth_permissions_users
- auth_groups_users
- auth_groups_permissions
- auth_remember_tokens

#### Crear un usuario administrador

Puedes crear usuarios mediante el formulario de registro de la aplicación o directamente desde la base de datos.

Una vez creado el usuario, asígnalo al grupo correspondiente:

```php
$user = auth()->user();

$users = auth()->getProvider();

$user = $users->findById(1);

$user->addGroup('admin');
```

#### Crear grupos y permisos

Ejemplo:

```php
$user->addGroup('admin');

$user->addPermission(
    'tickets.crear',
    'tickets.editar',
    'tickets.eliminar'
);
```

Consulta la documentación oficial de Shield para configuraciones avanzadas de autenticación, autorización, grupos, permisos y protección de rutas.

---

### 8. Ajustar permisos

Linux:

```bash
chmod -R 755 writable
chmod -R 755 public/uploads
```

---

### 9. Configurar el servidor web

El DocumentRoot debe apuntar a:

```text
public/
```

Ejemplo:

```text
/var/www/MesaDeAyuda/public
```

---

### 10. Iniciar el servidor de desarrollo

```bash
php spark serve
```

Accede desde:

```text
http://localhost:8080
```

---

## Configuración importante

### Directorio público

Por seguridad, el archivo `index.php` debe permanecer dentro de la carpeta:

```text
public/
```

Asegúrate de que el servidor web no apunte a la raíz del proyecto.

---

### Clave de encriptación

Genera la clave de aplicación:

```bash
php spark key:generate
```

---

### Entorno de producción

Configura en `.env`:

```env
CI_ENVIRONMENT = production
```

Desactiva cualquier opción de depuración antes de publicar en producción.

---

## Ejemplo mínimo de archivo `.env`

```env
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = mesa_de_ayuda
database.default.username = usuario
database.default.password = contraseña
database.default.DBDriver = MySQLi
```

---

## Seguridad y mantenimiento

### Auditoría de seguridad

Verificar dependencias vulnerables:

```bash
composer audit
```

Actualizar dependencias:

```bash
composer update
```

Actualizar CodeIgniter:

```bash
composer update codeigniter4/framework
```

Actualizar Shield:

```bash
composer update codeigniter4/shield
```

---

### Buenas prácticas de seguridad

- No subir el archivo `.env` al repositorio.
- Mantener PHP actualizado.
- Mantener CodeIgniter actualizado.
- Mantener Shield actualizado.
- Utilizar HTTPS en producción.
- Desactivar el modo debug en producción.
- Realizar respaldos periódicos de la base de datos.
- Limitar permisos de escritura únicamente a los directorios necesarios.
- Utilizar grupos de permisos en Shield en lugar de asignar permisos individuales a los usuarios.
- Restringir el acceso administrativo mediante roles.
- Revisar periódicamente los registros de autenticación y acceso.

---

## Desarrollo y contribuciones

Las contribuciones son bienvenidas.

Antes de enviar cambios:

1. Mantén el código alineado con los estándares de CodeIgniter 4.
2. Documenta nuevas funcionalidades.
3. Prueba los cambios antes de crear un Pull Request.
4. Actualiza las migraciones cuando se modifique la estructura de la base de datos.

Consulta el archivo `CONTRIBUTING.md` para más detalles.

---

## Licencia

Este proyecto está bajo la licencia MIT.

Consulta el archivo [LICENSE](LICENSE) para más informaci🏢 Búho Computación

GitHub: https://github.com/MarioGarcia1040