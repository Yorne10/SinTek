# SinTek - Sistema Integral de Trámites

Sistema web para la gestión integral de trámites administrativos, desarrollado para **CETAM** (Centro de Estudios Tecnológicos y de Administración).

## Descripción

SinTek es una aplicación web que permite gestionar procesos administrativos de manera eficiente. El sistema está diseñado para manejar tres roles principales: **Administrador**, **Secretario(a)** y **Trabajador(a)**.

### Características principales

- **Gestión de trámites**: Creación, seguimiento y finalización de procesos administrativos
- **Gestión de convocatorias**: Publicación y administración de convocatorias públicas
- **Gestión de documentos institucionales**: Almacenamiento y distribución de documentos oficiales
- **Sistema de notificaciones**: Envío de notificaciones a trabajadores
- **Preguntas frecuentes (FAQ)**: Gestión de categorías y preguntas frecuentes
- **Registro de actividad**: Bitácora de acciones realizadas en el sistema
- **Gestión de usuarios**: Administración de usuarios y roles

## Roles del sistema

| Rol | Descripción |
|-----|-------------|
| **Administrador** | Acceso completo al sistema. Gestión de usuarios, configuración y auditoría. |
| **Secretario(a)** | Gestión de trámites, convocatorias, documentos y notificaciones. |
| **Trabajador(a)** | Acceso a trámites personales, convocatorias y documentos institucionales. |

## Tecnologías

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Livewire 3.x, Alpine.js, Bootstrap 5.3.3
- **Base de datos**: MySQL
- **Autenticación**: Laravel Sanctum

## Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18.x y npm >= 10.x
- MySQL >= 8.0

## Instalación

```powershell
# 1. Clonar el repositorio
git clone <url-del-repositorio>
cd SinTek

# 2. Instalar dependencias de PHP
composer install

# 3. Instalar dependencias de Node.js
npm install

# 4. Configurar variables de entorno
Copy-Item .env.example .env
# Editar .env con las credenciales de base de datos

# 5. Generar clave de aplicación
php artisan key:generate

# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. Crear enlace simbólico de almacenamiento
php artisan storage:link

# 8. Compilar assets (desarrollo)
npm run development

# 9. Iniciar servidor de desarrollo
php artisan serve
```

## Credenciales de prueba

Después de ejecutar los seeders, puedes acceder con las siguientes credenciales:

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | admin@cetam.gob.mx | secret |
| Secretario(a) | secretaria@cetam.gob.mx | secret |
| Trabajador(a) | trabajador@cetam.gob.mx | secret |

## Estructura del proyecto

```
app/
├── Http/Controllers/     # Controladores HTTP
├── Livewire/             # Componentes Livewire
│   ├── Admin/            # Componentes de administrador
│   ├── Secretary/        # Componentes de secretaría
│   └── Worker/           # Componentes de trabajador
├── Models/               # Modelos Eloquent
└── Services/             # Servicios de la aplicación

resources/views/
├── layouts/              # Plantillas base
├── livewire/             # Vistas de componentes Livewire
└── modules/              # Vistas organizadas por módulo
    ├── admin/
    ├── secretary/
    └── worker/
```

## Comandos útiles

```powershell
# Compilar assets para producción
npm run production

# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ver lista de rutas
php artisan route:list

# Ejecutar pruebas
php artisan test
```

## Configuración

El archivo `config/proj.php` contiene la configuración específica del proyecto:

- `slug`: Prefijo de URL del proyecto (por defecto: `sintek`)
- `route_name_prefix`: Prefijo para nombres de rutas (por defecto: `sintek`)

## Licencia

Este proyecto es propiedad de **CETAM**. Todos los derechos reservados.

---

Desarrollado por el equipo de desarrollo de CETAM.
