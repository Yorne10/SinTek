# Iconos Faltantes

## Iconos que NO están en config/icons.php

Durante la migración de SVG a Font Awesome, se encontró el siguiente icono que no tiene equivalente en `config/icons.php`:

### 1. Menú de 3 puntos (Ellipsis Vertical)

**Archivo:** `resources/views/livewire/admin/definir-pasos.blade.php:136-138`

**Uso:** Botón de menú desplegable con opciones (Editar, Eliminar)

**SVG actual:**
```html
<svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
</svg>
```

**Sugerencia de Font Awesome:**
```php
'action.more' => 'fa-solid fa-ellipsis-vertical',
```

**Alternativas:**
- `fa-solid fa-ellipsis` (3 puntos horizontal)
- `fa-solid fa-ellipsis-vertical` (3 puntos vertical) ← **Recomendado**

---

## Estado de la migración

### ✅ Completado
- Dashboards (admin, secretary, worker) - 100%
- Navegación (topbar, sidenav-secretary, sidenav-worker) - 100%
- Componentes Admin (crear-proceso, definir-pasos, configuracion) - ~95%

### ⏳ Pendiente
- Componentes Livewire de secretary
- Componentes Livewire de worker
- Componentes generales (users, profile, etc)

### 📝 Nota
El icono del menú de 3 puntos quedó sin migrar en definir-pasos.blade.php porque no existe en config/icons.php. Se dejó el SVG original.
