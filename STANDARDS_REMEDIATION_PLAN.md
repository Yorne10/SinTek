# Plan de Remediación de Estándares CETAM - SinTek

**Versión:** 1.0.0  
**Fecha de Auditoría:** 14/12/2025  
**Proyecto:** Sistema de Trámites CETAM (SinTek)  
**Estado Actual de Cumplimiento:** ~85%  
**Meta de Cumplimiento:** 100%

---

## Resumen Ejecutivo

Esta auditoría analiza el proyecto SinTek contra los estándares de codificación CETAM documentados en `CETAM_MASTER_STANDARDS.md`. Se identificaron las siguientes áreas de no-cumplimiento:

| Área | Estado | Detalles |
|------|--------|----------|
| Headers de archivo (CETAM) | ⚠️ 92% | 13 archivos sin header |
| Comentarios en inglés | ❌ 0% | 300+ comentarios en español |
| DocBlocks | ✅ 95% | Mayoría de métodos documentados |
| Nomenclatura | ✅ 100% | PascalCase, camelCase correctos |
| Estructura de carpetas | ✅ 100% | Organización por módulo |
| Rutas | ✅ 100% | Prefijo correcto sintek.* |

---

## Tabla de Contenidos

1. [Fase 1: Archivos sin Header CETAM](#fase-1-archivos-sin-header-cetam)
2. [Fase 2: Traducción de Comentarios a Inglés](#fase-2-traducción-de-comentarios-a-inglés)
3. [Fase 3: DocBlocks Faltantes](#fase-3-docblocks-faltantes)
4. [Verificación Final](#verificación-final)

---

# Fase 1: Archivos sin Header CETAM

## Prioridad: 🔴 ALTA

Los siguientes archivos PHP no tienen el header estándar CETAM. Estos son principalmente archivos base de Laravel que necesitan el header corporativo.

### Template de Header Requerido

```php
<?php
/**
 * Company: CETAM
 * Project: ST
 * File: [FILENAME]
 * Created on: 14/12/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */
```

---

## 1.1 Core Laravel Files (app/)

### [MODIFY] [Controller.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Controllers/Controller.php)
**Ubicación:** `app/Http/Controllers/Controller.php`  
**Acción:** Agregar header CETAM antes del `<?php`

### [MODIFY] [Authenticate.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/Authenticate.php)
**Ubicación:** `app/Http/Middleware/Authenticate.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [EncryptCookies.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/EncryptCookies.php)
**Ubicación:** `app/Http/Middleware/EncryptCookies.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [PreventRequestsDuringMaintenance.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/PreventRequestsDuringMaintenance.php)
**Ubicación:** `app/Http/Middleware/PreventRequestsDuringMaintenance.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [RedirectIfAuthenticated.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/RedirectIfAuthenticated.php)
**Ubicación:** `app/Http/Middleware/RedirectIfAuthenticated.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [TrimStrings.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/TrimStrings.php)
**Ubicación:** `app/Http/Middleware/TrimStrings.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [TrustHosts.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/TrustHosts.php)
**Ubicación:** `app/Http/Middleware/TrustHosts.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [TrustProxies.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/TrustProxies.php)
**Ubicación:** `app/Http/Middleware/TrustProxies.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [VerifyCsrfToken.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Middleware/VerifyCsrfToken.php)
**Ubicación:** `app/Http/Middleware/VerifyCsrfToken.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [Kernel.php (Console)](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Console/Kernel.php)
**Ubicación:** `app/Console/Kernel.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [Kernel.php (Http)](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Http/Kernel.php)
**Ubicación:** `app/Http/Kernel.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [Handler.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Exceptions/Handler.php)
**Ubicación:** `app/Exceptions/Handler.php`  
**Acción:** Agregar header CETAM

---

## 1.2 Database Factories

### [MODIFY] [UserFactory.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/database/factories/UserFactory.php)
**Ubicación:** `database/factories/UserFactory.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [WorkerFactory.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/database/factories/WorkerFactory.php)
**Ubicación:** `database/factories/WorkerFactory.php`  
**Acción:** Agregar header CETAM

### [MODIFY] [RequestFactory.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/database/factories/RequestFactory.php)
**Ubicación:** `database/factories/RequestFactory.php`  
**Acción:** Agregar header CETAM

---

# Fase 2: Traducción de Comentarios a Inglés

## Prioridad: 🔴 ALTA

**Total de comentarios a traducir:** ~350+ líneas

El estándar CETAM establece:
> - **Code:** English (variables, functions, classes)
> - **Comments:** English
> - **UI/Messages:** Spanish (user-facing)

---

## 2.1 Servicios (app/Services/)

### [MODIFY] [ConvocationDocumentService.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Services/Documents/ConvocationDocumentService.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 33 | `// Asegurar que el nombre del archivo siempre termine en .pdf` | `// Ensure the filename always ends with .pdf` |
| 36 | `// Remover extensión existente si la hay` | `// Remove existing extension if any` |
| 39 | `// Agregar extensión .pdf` | `// Add .pdf extension` |
| 65 | `// Asegurar que el nombre del archivo siempre termine en .pdf` | `// Ensure the filename always ends with .pdf` |
| 68 | `// Remover extensión existente si la hay` | `// Remove existing extension if any` |
| 71 | `// Agregar extensión .pdf` | `// Add .pdf extension` |

---

### [MODIFY] [FallbackAuthService.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Services/Auth/FallbackAuthService.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 168 | `// If it is una petición JSON/Ajax` | `// If it is a JSON/Ajax request (e.g., from the inactivity timer)` |
| 169 | `// retornar JSON en lugar de redirección HTML` | `// return JSON instead of HTML redirect` |
| 174 | `// If it is un logout manual desde el botón del sidebar` | `// If it is a manual logout from the sidebar button, redirect to login` |
| 179 | `// If it is una petición JSON, retornar JSON incluso en error` | `// If it is a JSON request, return JSON even on error` |
| 184 | `// If it is HTML, redirigir al login en caso de error` | `// If it is HTML, redirect to login on error` |

---

### [MODIFY] [RequestService.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Services/API/Requests/RequestService.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 600 | `// Validate que el trámite pueda ser cancelado` | `// Validate that the request can be cancelled` |
| 610 | `// Update el estado del trámite` | `// Update the request status` |
| 614 | `// Cancelar todos los pasos pendientes o en progreso` | `// Cancel all pending or in-progress steps` |
| 624 | `// Log activity` | `// Log activity` (ya está en inglés) |

---

### [MODIFY] [ActivityLogger.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Services/ActivityLogger.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 42 | `// Worker actions - Web y API` | `// Worker actions - Web and API` |
| 51 | `// Secretary actions - Convocatorias` | `// Secretary actions - Convocations` |
| 57 | `// Secretary actions - Documentos institucionales` | `// Secretary actions - Institutional documents` |
| 63 | `// Secretary actions - Claves presupuestales` | `// Secretary actions - Budget keys` |
| 68 | `// Secretary actions - Notificaciones y FAQs` | `// Secretary actions - Notifications and FAQs` |
| 79 | `// Admin actions - Procesos` | `// Admin actions - Processes` |
| 86 | `// Admin actions - Pasos` | `// Admin actions - Steps` |
| 92 | `// API actions (compatibilidad)` | `// API actions (compatibility)` |

---

## 2.2 Providers (app/Providers/)

### [MODIFY] [AppServiceProvider.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Providers/AppServiceProvider.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 30 | `// Load helpers` | ✅ Already in English |
| 41 | `// Register @icon Blade directive` | ✅ Already in English |
| 46 | `// Load system settings from database` | ✅ Already in English |
| 73 | `// Log error or ignore if DB connection fails` | ✅ Already in English |
| 76 | `// Opcional: Prefijo genérico para componentes Blade` | `// Optional: Generic prefix for Blade components` |
| 77 | `// Descomenta y ajusta el prefijo 'proj' por el código real del proyecto.` | `// Uncomment and adjust the 'proj' prefix with the actual project code.` |
| 79 | `// Ahora invocable como: <x-proj-layouts-base>` | `// Now invokable as: <x-proj-layouts-base>` |

---

## 2.3 View Components (app/View/)

### [MODIFY] [Base.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/View/Components/Layouts/Base.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 32 | `// Opcional: Puedes registrar este componente con un prefijo genérico` | `// Optional: You can register this component with a generic prefix` |
| 33 | `// For su uso como <x-proj-layouts.base>. Sustituir 'proj' por el código real del proyecto.` | `// For use as <x-proj-layouts.base>. Replace 'proj' with the actual project code.` |
| 34 | `// Ver: AppServiceProvider::boot() -> Blade::component(...)` | `// See: AppServiceProvider::boot() -> Blade::component(...)` |

---

## 2.4 Exceptions (app/Exceptions/)

### [MODIFY] [Handler.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Exceptions/Handler.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 41 | `// Manejo de CSRF token inválido (sesión expirada)` | `// Handle invalid CSRF token (session expired)` |
| 49 | `// Manejo de errores de método no permitido` | `// Handle method not allowed errors (e.g., GET on POST route)` |
| 50 | `// Esto NO debe mostrar "sesión expirada"...` | `// This should NOT show "session expired" because the session may still be active` |
| 55 | `// Redirigir al dashboard si está autenticado, o al login si no` | `// Redirect to dashboard if authenticated, or to login if not` |
| 62 | `// Manejo de autenticación fallida` | `// Handle authentication failure (unauthenticated user)` |
| 67 | `// If viene de una petición Ajax/Livewire...` | `// If coming from an Ajax/Livewire request, redirect to session expired` |
| 71 | `// If it is una petición normal, redirigir al login` | `// If it is a normal request, redirect to login` |
| 75 | `// Manejo de errores de conexión con la base de datos` | `// Handle database connection errors` |
| 77 | `// Solo tratar como error de conexión si REALMENTE es un error crítico` | `// Only treat as connection error if it is REALLY a critical error` |
| 81 | `// Para peticiones Livewire/AJAX` | `// For Livewire/AJAX requests` |
| 83 | `// En lugar de JSON puro, redirigir a una página de error` | `// Instead of pure JSON, redirect to an error page` |
| 90 | `// Para peticiones normales` | `// For normal requests` |
| 96 | `// Si no es un error crítico, dejar que Laravel lo maneje normalmente` | `// If not a critical error, let Laravel handle it normally` |
| 99 | `// Manejo de errores PDO` | `// Handle PDO errors (failed connection at lower level)` |
| 103 | `// Para peticiones Livewire/AJAX o normales...` | `// For Livewire/AJAX or normal requests, show error view` |
| 112 | `// Determinar si la excepción es un error de conexión CRÍTICO` | `// Determine if the exception is a CRITICAL database connection error` |
| 113 | `// Solo devuelve true para errores reales de conexión` | `// Only returns true for real connection errors, not normal query errors` |
| 120 | `// Códigos de error que indican problemas CRÍTICOS de conexión` | `// Error codes indicating CRITICAL connection problems` |
| 133 | `// Solo considerar error crítico si el código coincide exactamente` | `// Only consider critical error if the code matches exactly` |
| 138 | `// Verificar palabras clave específicas que indican pérdida de conexión` | `// Check specific keywords indicating connection loss` |

---

## 2.5 Livewire Components (app/Livewire/)

### [MODIFY] [ConfigureFlow.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Livewire/Admin/ConfigureFlow.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 341 | `// usar maxOrder + indice para mantener estabilidad relativa` | `// use maxOrder + index to maintain relative stability` |
| 392 | `// ciclo, considerar que no llega a final para evitar loop infinito` | `// cycle, consider that it does not reach final to avoid infinite loop` |

### [MODIFY] [ProcessesIndex.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Livewire/Secretary/ProcessesIndex.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 233 | `return false; // ciclo` | `return false; // cycle detected` |

### [MODIFY] [FaqQuestionForm.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Livewire/Secretary/FaqQuestionForm.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 83 | `// alta: siguiente orden disponible` | `// create: next available order` |

### [MODIFY] [Notifications.php (ResetPassword)](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/app/Notifications/ResetPassword.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 60 | `// Ajuste al nuevo esquema de rutas con prefijo configurable` | `// Adjust to new route scheme with configurable prefix (proj.*)` |

---

## 2.6 Blade Views (resources/views/)

### Comentarios en Partials

Todos los partials tienen este comentario que debe traducirse:

```blade
{{-- Wrapper para cumplir la convención de partials --}}
```

**Traducción:**
```blade
{{-- Wrapper to comply with partials convention --}}
```

**Archivos afectados:**
- `partials/topbar.blade.php` (línea 15)
- `partials/sidenav.blade.php` (línea 15)
- `partials/sidenav-worker.blade.php` (línea 15)
- `partials/sidenav-secretary.blade.php` (línea 15)
- `partials/sidenav-basic.blade.php` (línea 15)
- `partials/sidenav-admin.blade.php` (línea 15)
- `partials/nav.blade.php` (línea 15)
- `partials/footer2.blade.php` (línea 15)
- `partials/footer.blade.php` (línea 15)

### Comentarios en Livewire Views

#### [dashboard.blade.php (livewire/admin)](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/resources/views/livewire/admin/dashboard.blade.php)

```blade
{{-- Vista movida a modules/admin\dashboard.blade.php --}}
```

**Traducción:**
```blade
{{-- View moved to modules/admin/dashboard.blade.php --}}
```

### Comentarios en Modules

#### [my-procedures.blade.php](file:///c:/Users/alpon/CETAM/Proyectos/SinTek/resources/views/modules/worker/my-procedures.blade.php)

| Línea | Español (Actual) | Inglés (Corregido) |
|-------|------------------|-------------------|
| 42 | `{{-- Filtros y búsqueda --}}` | `{{-- Filters and search --}}` |

---

# Fase 3: DocBlocks Faltantes

## Prioridad: 🟡 MEDIA

La mayoría de métodos públicos ya tienen DocBlocks. Verificar los siguientes archivos que podrían necesitar actualización:

### Archivos a revisar:

1. `app/Http/Middleware/*.php` - Verificar métodos tengan DocBlocks
2. `app/Console/Kernel.php` - Ya tiene DocBlocks (OK)
3. `database/factories/*.php` - Verificar métodos `definition()` y `unverified()`

---

# Verificación Final

## Checklist de Cumplimiento

Después de aplicar todas las correcciones, verificar:

- [ ] Todos los archivos PHP tienen header CETAM
- [ ] Todos los comentarios `//` están en inglés
- [ ] Todos los comentarios `{{-- --}}` en Blade están en inglés
- [ ] DocBlocks en formato estándar con @param, @return
- [ ] Headers de archivos Blade en formato `{{-- Company: CETAM --}}`

## Comandos de Verificación

```powershell
# Buscar comentarios en español restantes
rg "// [A-ZÁÉÍÓÚ]" app/ --glob="*.php"
rg "\{\{-- [A-ZÁÉÍÓÚ]" resources/views/ --glob="*.blade.php"

# Verificar headers CETAM
rg "Company: CETAM" app/ --glob="*.php" -c
rg "Company: CETAM" database/ --glob="*.php" -c
rg "Company: CETAM" resources/views/ --glob="*.blade.php" -c
```

---

# Estimación de Esfuerzo

| Fase | Archivos | Tiempo Estimado |
|------|----------|-----------------|
| Fase 1: Headers | 15 archivos | 30 minutos |
| Fase 2: Traducción PHP | ~25 archivos | 2 horas |
| Fase 2: Traducción Blade | ~20 archivos | 1 hora |
| Fase 3: DocBlocks | ~5 archivos | 30 minutos |
| **Total** | **~65 archivos** | **~4 horas** |

---

# Priorización Recomendada

1. **Inmediato (Día 1):** 
   - Agregar headers CETAM a archivos faltantes
   - Traducir comentarios en Services (lógica de negocio crítica)

2. **Corto plazo (Día 2):**
   - Traducir comentarios en Livewire components
   - Traducir comentarios en Exceptions/Handler.php

3. **Mediano plazo (Día 3):**
   - Traducir comentarios en Blade views
   - Revisar y completar DocBlocks faltantes

4. **Verificación:**
   - Ejecutar comandos de verificación
   - Actualizar `CETAM_MASTER_STANDARDS.md` si es necesario
