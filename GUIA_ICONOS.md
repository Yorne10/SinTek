# Guía de Uso de Iconos

Este proyecto usa Font Awesome icons centralizados en el archivo `config/icons.php`.

## ✅ Configuración Completada

Se han creado los siguientes archivos:
- `app/helpers.php` - Helper function `icon()`
- `app/Providers/AppServiceProvider.php` - Registra helper y directiva Blade `@icon`
- `config/icons.php` - Configuración de iconos

## 📖 Cómo Usar los Iconos

### Opción 1: Directiva Blade (Recomendado)

```blade
{{-- Icono básico --}}
@icon('nav.home')

{{-- Icono con clases adicionales --}}
@icon('user.profile', 'text-primary me-2')

{{-- Icono en botón --}}
<button class="btn btn-primary">
    @icon('action.save') Guardar
</button>
```

### Opción 2: Helper Function

```blade
<i class="{{ icon('nav.dashboard') }}"></i>

<i class="{{ icon('user.list', 'text-info') }}"></i>
```

### Opción 3: HTML Directo (para casos especiales)

```blade
<i class="fa-solid fa-house"></i>
```

## 🔄 Migración de SVG a Font Awesome

### Mapeo de Iconos Comunes

#### Navegación
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| Home icon (path d="M3 12l2-2...") | `nav.home` | `fa-solid fa-house` |
| Dashboard icon (gauge) | `nav.dashboard` | `fa-solid fa-gauge-high` |
| Menu/Bars | `nav.menu` | `fa-solid fa-bars` |
| Close/X | `nav.close` | `fa-solid fa-xmark` |
| Arrow left | `nav.back` | `fa-solid fa-arrow-left` |

#### Usuarios
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| User circle | `user.avatar` | `fa-solid fa-circle-user` |
| Single user | `user.profile` | `fa-solid fa-user` |
| Multiple users | `user.list` | `fa-solid fa-users` |
| User plus | `user.add` | `fa-solid fa-user-plus` |

#### Acciones
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| Plus/Add | `action.create` | `fa-solid fa-plus` |
| Edit/Pen | `action.edit` | `fa-solid fa-pen-to-square` |
| Trash/Delete | `action.delete` | `fa-solid fa-trash` |
| Eye/View | `action.view` | `fa-solid fa-eye` |
| Save/Disk | `action.save` | `fa-solid fa-floppy-disk` |
| Search/Magnify | `action.search` | `fa-solid fa-magnifying-glass` |
| Download | `action.download` | `fa-solid fa-download` |
| Upload | `action.upload` | `fa-solid fa-upload` |

#### Estados
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| Check circle | `state.success` | `fa-solid fa-circle-check` |
| X circle | `state.error` | `fa-solid fa-circle-xmark` |
| Warning triangle | `state.warning` | `fa-solid fa-triangle-exclamation` |
| Info circle | `state.info` | `fa-solid fa-circle-info` |
| Clock/Pending | `state.pending` | `fa-solid fa-clock` |
| Spinner/Loading | `state.in_progress` | `fa-solid fa-spinner` |

#### Documentos
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| File generic | `file.generic` | `fa-solid fa-file` |
| PDF file | `file.pdf` | `fa-solid fa-file-pdf` |
| Folder | `folder.closed` | `fa-solid fa-folder` |
| Paperclip | `file.attachment` | `fa-solid fa-paperclip` |

#### Procesos
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| Clipboard/Process | `process.generic` | `fa-solid fa-clipboard-list` |
| Gears/Settings | `process.generic` | `fa-solid fa-gears` |
| Approval checkbox | `process.approval` | `fa-solid fa-check-to-slot` |
| Step/Footprints | `process.step` | `fa-solid fa-shoe-prints` |

#### Notificaciones
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| Bell | `notif.bell` | `fa-solid fa-bell` |
| Envelope/Email | `msg.email` | `fa-solid fa-envelope` |
| Chat/Comments | `msg.chat` | `fa-solid fa-comments` |

#### Reportes
| SVG Actual | Nuevo Icon Key | Font Awesome |
|-----------|---------------|--------------|
| Chart line | `report.line` | `fa-solid fa-chart-line` |
| Chart bar | `report.bar` | `fa-solid fa-chart-bar` |
| Chart pie | `report.pie` | `fa-solid fa-chart-pie` |
| Print | `report.print` | `fa-solid fa-print` |

## 📝 Ejemplos de Reemplazo

### Antes (SVG inline):
```blade
<svg class="icon text-info" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
</svg>
```

### Después (Font Awesome):
```blade
@icon('process.generic', 'text-info')
```

### Antes (Breadcrumb home):
```blade
<svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
</svg>
```

### Después:
```blade
@icon('nav.home', 'icon-xxs')
```

## 🎯 Archivos a Actualizar

Archivos que contienen SVG inline y deben migrarse:

### Dashboards
- [ ] `resources/views/livewire/admin/dashboard.blade.php`
- [ ] `resources/views/livewire/secretary/dashboard.blade.php`
- [ ] `resources/views/livewire/worker/dashboard.blade.php`

### Navegación
- [ ] `resources/views/layouts/sidenav-secretary.blade.php`
- [ ] `resources/views/layouts/sidenav-worker.blade.php`
- [ ] `resources/views/layouts/topbar.blade.php`

### Componentes Livewire
- [ ] `resources/views/livewire/admin/crear-proceso.blade.php`
- [ ] `resources/views/livewire/admin/definir-pasos.blade.php`
- [ ] `resources/views/livewire/admin/configuracion.blade.php`
- [ ] `resources/views/livewire/secretary/busqueda-trabajadores.blade.php`
- [ ] `resources/views/livewire/secretary/convocatorias-documentos.blade.php`
- [ ] `resources/views/livewire/secretary/gestion-faqs.blade.php`
- [ ] `resources/views/livewire/secretary/notificaciones.blade.php`
- [ ] `resources/views/livewire/worker/tramites-disponibles.blade.php`
- [ ] `resources/views/livewire/worker/detalle-tramite.blade.php`
- [ ] `resources/views/livewire/users.blade.php`
- [ ] `resources/views/livewire/user-create.blade.php`
- [ ] `resources/views/livewire/profile.blade.php`
- [ ] `resources/views/livewire/preguntas-frecuentes.blade.php`

## 🔧 Agregar Nuevos Iconos

Para agregar un nuevo icono al sistema:

1. Abre `config/icons.php`
2. Agrega una nueva entrada siguiendo la convención de nombres:
   ```php
   'dominio.nombre' => 'fa-solid fa-icon-name',
   ```
3. Usa el icono en tus vistas:
   ```blade
   @icon('dominio.nombre')
   ```

## 📚 Referencias

- Font Awesome Icons: https://fontawesome.com/icons
- Configuración: `config/icons.php`
- Helper: `app/helpers.php`
- Provider: `app/Providers/AppServiceProvider.php`
