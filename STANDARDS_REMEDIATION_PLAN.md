# CETAM Standards Complete Remediation Plan
# SinTek Project - Full Compliance Audit

**Audit Date:** 14/12/2025  
**Project:** Sistema de Trámites CETAM (SinTek)  
**Current Compliance:** ~80%  
**Target Compliance:** 100%

---

## Executive Summary

| Category | Files Affected | Status |
|----------|---------------|--------|
| Files without CETAM Headers | 18 | ❌ Requires fix |
| Spanish Comments in PHP | ~25 files, 60+ comments | ❌ Requires translation |
| Spanish Comments in Blade | ~30 files, 40+ comments | ❌ Requires translation |
| DocBlocks | 95%+ | ✅ Mostly compliant |
| Naming Conventions | 100% | ✅ Compliant |
| Directory Structure | 100% | ✅ Compliant |
| Route Naming | 100% | ✅ Compliant |

---

# PHASE 1: FILES WITHOUT CETAM HEADERS

**Total: 18 files**

## CETAM Header Template (PHP)

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

## CETAM Header Template (Blade)

```blade
{{--
Company: CETAM
Project: ST
File: [FILENAME]
Created on: 14/12/2025
Created by: Alfonso Angel Garcia Hernandez
Approved by: Alfonso Angel Garcia Hernandez

Changelog:
- ID: <ID> | Date: dd/mm/yyyy
  Modified by: <Developer name>
  Description: <Brief description of change>
--}}
```

---

## 1.1 App Core Files (12 files)

| # | File Path | Action |
|---|-----------|--------|
| 1 | `app/Console/Kernel.php` | Add CETAM header |
| 2 | `app/Exceptions/Handler.php` | Add CETAM header |
| 3 | `app/Http/Kernel.php` | Add CETAM header |
| 4 | `app/Http/Controllers/Controller.php` | Add CETAM header |
| 5 | `app/Http/Middleware/Authenticate.php` | Add CETAM header |
| 6 | `app/Http/Middleware/EncryptCookies.php` | Add CETAM header |
| 7 | `app/Http/Middleware/PreventRequestsDuringMaintenance.php` | Add CETAM header |
| 8 | `app/Http/Middleware/RedirectIfAuthenticated.php` | Add CETAM header |
| 9 | `app/Http/Middleware/TrimStrings.php` | Add CETAM header |
| 10 | `app/Http/Middleware/TrustHosts.php` | Add CETAM header |
| 11 | `app/Http/Middleware/TrustProxies.php` | Add CETAM header |
| 12 | `app/Http/Middleware/VerifyCsrfToken.php` | Add CETAM header |

## 1.2 Database Files (4 files)

| # | File Path | Action |
|---|-----------|--------|
| 13 | `database/factories/PositionFactory.php` | Add CETAM header |
| 14 | `database/factories/UserFactory.php` | Add CETAM header |
| 15 | `database/factories/WorkerFactory.php` | Add CETAM header |
| 16 | `database/migrations/2025_12_13_155835_add_privacy_accepted_to_workers.php` | Add CETAM header |

## 1.3 Routes Files (2 files)

| # | File Path | Action |
|---|-----------|--------|
| 17 | `routes/channels.php` | Add CETAM header |
| 18 | `routes/console.php` | Add CETAM header |

## 1.4 Blade Files (2 files)

| # | File Path | Action |
|---|-----------|--------|
| 19 | `resources/views/layouts/base.blade.php` | Add CETAM header |
| 20 | `resources/views/modules/admin/define-steps.blade.php` | Add CETAM header |

---

# PHASE 2: SPANISH TO ENGLISH COMMENT TRANSLATION

## Standard Rule
Per CETAM_MASTER_STANDARDS.md Chapter 3.1:
> - **Code:** English (variables, functions, classes)
> - **Comments:** English
> - **UI/Messages:** Spanish (user-facing)

---

## 2.1 app/Exceptions/Handler.php

| Line | Spanish | English |
|------|---------|---------|
| 41 | `// Manejo de CSRF token inválido (sesión expirada)` | `// Handle invalid CSRF token (session expired)` |
| 49 | `// Manejo de errores de método no permitido (ej: GET en ruta POST)` | `// Handle method not allowed errors (e.g., GET on POST route)` |
| 50 | `// Esto NO debe mostrar "sesión expirada" porque la sesión puede seguir activa` | `// This should NOT show "session expired" because the session may still be active` |
| 55 | `// Redirigir al dashboard si está autenticado, o al login si no` | `// Redirect to dashboard if authenticated, or to login if not` |
| 62 | `// Manejo de autenticación fallida (usuario no autenticado)` | `// Handle authentication failure (unauthenticated user)` |
| 67 | `// If viene de una petición Ajax/Livewire, redirigir a sesión expirada` | `// If coming from an Ajax/Livewire request, redirect to session expired` |
| 71 | `// If it is una petición normal, redirigir al login` | `// If it is a normal request, redirect to login` |
| 75 | `// Manejo de errores de conexión con la base de datos` | `// Handle database connection errors` |
| 77 | `// Solo tratar como error de conexión si REALMENTE es un error de conexión crítico` | `// Only treat as connection error if it is REALLY a critical connection error` |
| 81 | `// Para peticiones Livewire/AJAX` | `// For Livewire/AJAX requests` |
| 83 | `// En lugar de JSON puro, redirigir a una página de error` | `// Instead of pure JSON, redirect to an error page` |
| 90 | `// Para peticiones normales` | `// For normal requests` |
| 96 | `// Si no es un error crítico, dejar que Laravel lo maneje normalmente` | `// If not a critical error, let Laravel handle it normally` |
| 99 | `// Manejo de errores PDO (conexión fallida a nivel más bajo)` | `// Handle PDO errors (connection failed at lower level)` |
| 103 | `// Para peticiones Livewire/AJAX o normales, mostrar vista de error` | `// For Livewire/AJAX or normal requests, show error view` |
| 112 | `// Determinar si la excepción es un error de conexión CRÍTICO con la base de datos` | `// Determine if the exception is a CRITICAL database connection error` |
| 113 | `// Solo devuelve true para errores reales de conexión, no para errores de query normales` | `// Only returns true for real connection errors, not for normal query errors` |
| 120 | `// Códigos de error que indican problemas CRÍTICOS de conexión` | `// Error codes indicating CRITICAL connection problems` |
| 133 | `// Solo considerar error crítico si el código coincide exactamente` | `// Only consider critical error if the code matches exactly` |
| 138 | `// Verificar palabras clave específicas que indican pérdida de conexión` | `// Check specific keywords indicating connection loss` |

---

## 2.2 app/Services/Documents/ConvocationDocumentService.php

| Line | Spanish | English |
|------|---------|---------|
| 33 | `// Asegurar que el nombre del archivo siempre termine en .pdf` | `// Ensure the filename always ends with .pdf` |
| 36 | `// Remover extensión existente si la hay` | `// Remove existing extension if any` |
| 39 | `// Agregar extensión .pdf` | `// Add .pdf extension` |
| 65 | `// Asegurar que el nombre del archivo siempre termine en .pdf` | `// Ensure the filename always ends with .pdf` |
| 68 | `// Remover extensión existente si la hay` | `// Remove existing extension if any` |
| 71 | `// Agregar extensión .pdf` | `// Add .pdf extension` |

---

## 2.3 app/Livewire/Admin/ConfigureFlow.php

| Line | Spanish | English |
|------|---------|---------|
| 169 | `// Si no es alcanzable desde el inicial, no bloquea la validación` | `// If not reachable from initial, it doesn't block validation (only shows warning)` |
| 280 | `// Sin inicial, mantener un orden estable basado en la posición actual` | `// Without initial, maintain a stable order based on current position` |
| 341 | `// usar maxOrder + indice para mantener estabilidad relativa` | `// use maxOrder + index to maintain relative stability` |
| 355 | `// Actualizar flag de vinculado en los pasos en memoria` | `// Update linked flag in steps in memory` |
| 392 | `// ciclo, considerar que no llega a final para evitar loop infinito` | `// cycle, consider it doesn't reach final to avoid infinite loop` |
| 424 | `// Si no hay siguientes y no es final, no llega a final` | `// If no next steps and not final, it doesn't reach final` |

---

## 2.4 app/Livewire/Admin/DefineSteps.php

| Line | Spanish | English |
|------|---------|---------|
| 104 | `// Solo un paso inicial visible: el primero marcado se mantiene, el resto se muestra como no inicial` | `// Only one initial step visible: the first marked is kept, the rest shown as non-initial` |
| 116 | `// Solo un tipo "inicial" en la columna Tipo; los demás se muestran como "normal"` | `// Only one "initial" type in the Type column; the rest shown as "normal"` |

---

## 2.5 app/Livewire/Admin/CreateStep.php

| Line | Spanish | English |
|------|---------|---------|
| 353 | `// Validar documentos proporcionados nuevos (si existen)` | `// Validate new provided documents (if any)` |
| 439 | `// Sincronizar documentos requeridos` | `// Sync required documents` |
| 452 | `// Sincronizar documentos proporcionados` | `// Sync provided documents` |

---

## 2.6 app/Livewire/Secretary/ProcessesIndex.php

| Line | Spanish | English |
|------|---------|---------|
| 105 | `// Si se intenta activar, validar que el flujo sea válido (inicio → final)` | `// If activating, validate that the flow is valid (start → end)` |
| 233 | `return false; // ciclo` | `return false; // cycle detected` |

---

## 2.7 app/Livewire/Secretary/BudgetKeyForm.php

| Line | Spanish | English |
|------|---------|---------|
| 120 | `// Redirigir solo si es edición` | `// Redirect only if editing` |

---

## 2.8 app/Livewire/Auth/Login.php

| Line | Spanish | English |
|------|---------|---------|
| 55 | `// Redirigir al dashboard con el nuevo esquema de rutas` | `// Redirect to dashboard with the new route scheme` |

---

## 2.9 app/Http/Middleware/LogApiActivity.php

| Line | Spanish | English |
|------|---------|---------|
| 33 | `// Solo registramos si el controlador/servicio envió acción y descripción explícitas` | `// Only log if the controller/service sent explicit action and description` |

---

## 2.10 app/Livewire/Profile.php

| Line | Spanish | English |
|------|---------|---------|
| 242 | `// Agregar la relación en la tabla positions_workers` | `// Add the relationship in the positions_workers table` |

---

## 2.11 app/View/Components/Layouts/Base.php

| Line | Spanish | English |
|------|---------|---------|
| 32 | `// Opcional: Puedes registrar este componente con un prefijo genérico` | `// Optional: You can register this component with a generic prefix` |
| 33 | `// For su uso como <x-proj-layouts.base>. Sustituir 'proj' por el código real del proyecto.` | `// For use as <x-proj-layouts.base>. Replace 'proj' with the actual project code.` |
| 34 | `// Ver: AppServiceProvider::boot() -> Blade::component(...)` | `// See: AppServiceProvider::boot() -> Blade::component(...)` |

---

## 2.12 app/Providers/AppServiceProvider.php

| Line | Spanish | English |
|------|---------|---------|
| 76 | `// Opcional: Prefijo genérico para componentes Blade` | `// Optional: Generic prefix for Blade components` |
| 77 | `// Descomenta y ajusta el prefijo 'proj' por el código real del proyecto.` | `// Uncomment and adjust the 'proj' prefix with the actual project code.` |
| 79 | `// Ahora invocable como: <x-proj-layouts-base>` | `// Now invokable as: <x-proj-layouts-base>` |

---

## 2.13 app/Notifications/ResetPassword.php

| Line | Spanish | English |
|------|---------|---------|
| 60 | `// Ajuste al nuevo esquema de rutas con prefijo configurable (proj.*)` | `// Adjust to new route scheme with configurable prefix (proj.*)` |

---

# PHASE 3: BLADE SPANISH COMMENTS TRANSLATION

## 3.1 Livewire View Wrappers (19 files)

**Pattern to translate in each file:**
```blade
{{-- Vista movida a modules/[path] --}}
```
**Translate to:**
```blade
{{-- View moved to modules/[path] --}}
```

**Files affected:**
1. `livewire/worker/detalle-t.blade.php`
2. `livewire/worker/dashboard.blade.php`
3. `livewire/users.blade.php`
4. `livewire/user-create.blade.php`
5. `livewire/upgrade-to-pro.blade.php`
6. `livewire/secretary/dashboard.blade.php`
7. `livewire/reset-password.blade.php`
8. `livewire/register-example.blade.php`
9. `livewire/profile.blade.php`
10. `livewire/profile-example.blade.php`
11. `livewire/logout.blade.php`
12. `livewire/login-example.blade.php`
13. `livewire/forgot-password.blade.php`
14. `livewire/forgot-password-example.blade.php`
15. `livewire/faq.blade.php`
16. `livewire/auth/register.blade.php`
17. `livewire/auth/login.blade.php`
18. `livewire/admin/reportes.blade.php`
19. `livewire/admin/dashboard.blade.php`

---

## 3.2 Partials (9 files)

**Pattern to translate:**
```blade
{{-- Wrapper para cumplir la convención de partials --}}
```
**Translate to:**
```blade
{{-- Wrapper to comply with partials convention --}}
```

**Files affected:**
1. `partials/topbar.blade.php`
2. `partials/sidenav.blade.php`
3. `partials/sidenav-worker.blade.php`
4. `partials/sidenav-secretary.blade.php`
5. `partials/sidenav-basic.blade.php`
6. `partials/sidenav-admin.blade.php`
7. `partials/nav.blade.php`
8. `partials/footer2.blade.php`
9. `partials/footer.blade.php`

---

## 3.3 Module Views

### modules/worker/my-procedures.blade.php
| Line | Spanish | English |
|------|---------|---------|
| 42 | `{{-- Filtros y búsqueda --}}` | `{{-- Filters and search --}}` |

### modules/worker/documents-index.blade.php
| Line | Spanish | English |
|------|---------|---------|
| 34 | `{{-- Filtros y tabla --}}` | `{{-- Filters and table --}}` |

### modules/worker/calls-index.blade.php
| Line | Spanish | English |
|------|---------|---------|
| 34 | `{{-- Filtros --}}` | `{{-- Filters --}}` |

### modules/worker/profile.blade.php
| Line | Spanish | English |
|------|---------|---------|
| 216 | `{{-- Plazas presupuestales --}}` | `{{-- Budget positions --}}` |

---

# PHASE 4: VERIFICATION

## Commands to verify compliance after fixes:

### Check for remaining files without headers:
```powershell
Get-ChildItem -Path "app" -Filter "*.php" -Recurse | ForEach-Object { 
    $content = Get-Content $_.FullName -Raw -ErrorAction SilentlyContinue
    if ($content -notmatch "Company: CETAM") { $_.FullName } 
}
```

### Check for remaining Spanish comments:
```powershell
Select-String -Path "app\**\*.php" -Pattern "// (Asegurar|Remover|Agregar|Manejo|Opcional|Redirigir|Solo|Para|Si|Verificar|Crear|Obtener|Actualizar|Buscar|Validar)" -Recursive
```

---

# EFFORT ESTIMATION

| Phase | Files | Estimated Time |
|-------|-------|----------------|
| Phase 1: Add Headers | 20 files | 40 minutes |
| Phase 2: Translate PHP comments | 13 files, ~60 comments | 1.5 hours |
| Phase 3: Translate Blade comments | 31 files, ~40 comments | 1 hour |
| Phase 4: Verification | - | 30 minutes |
| **TOTAL** | **64 files** | **~3.5 hours** |

---

# PRIORITY ORDER

1. **HIGH (Do First):**
   - Add CETAM headers to all 20 files
   - Translate Handler.php comments (critical error handling)

2. **MEDIUM (Do Second):**
   - Translate Livewire component comments
   - Translate Service layer comments

3. **LOW (Do Last):**
   - Translate Blade partial comments
   - Clean up remaining minor comments

---

# NOTES

- All UI-facing text (labels, messages, alerts) should remain in **Spanish**
- Only code comments and documentation should be in **English**
- DocBlocks use English descriptions with Spanish technical terms where necessary
