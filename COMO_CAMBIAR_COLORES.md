# Cómo Cambiar los Colores del Proyecto CETAM

## 🎨 Archivo de Configuración Principal

**SOLO hay UN archivo que debes editar para cambiar los colores:**

📁 `resources/scss/custom/_variables.scss`

## ✅ Proceso Correcto (3 pasos)

### 1️⃣ Edita el archivo de variables

Abre `resources/scss/custom/_variables.scss` y cambia los colores que necesites.

**Este archivo ahora tiene TODOS los colores del sistema:**

```scss
// COLORES DE MARCA (Los más importantes)
$primary: #1F2937;      // Color principal
$secondary: #ed6d12;    // Color secundario
$tertiary: #31316A;     // Color terciario

// COLORES SEMÁNTICOS
$success: $green;       // #10B981 - Estados exitosos
$info: $teal;           // #1E90FF - Estados informativos
$warning: $yellow;      // #F3C78E - Alertas
$danger: $red;          // #E11D48 - Errores

// COLORES GENÉRICOS (para gráficos)
$blue: #2361CE;
$indigo: #4F46E5;
$purple: #7C3AED;
$pink: #EF4683;
// ... y más

// ESCALA DE GRISES
$gray-50: #F9FAFB;
$gray-100: #F2F4F6;
// ... hasta $gray-900
```

**Puedes cambiar CUALQUIERA de estos colores** y todo el sistema se actualizará automáticamente.

### 2️⃣ Recompila los assets

Ejecuta en la terminal:

```bash
npm run production
```

O para desarrollo (con watch):

```bash
npm run watch
```

### 3️⃣ ¡Listo!

Todos los archivos CSS se regenerarán automáticamente con los nuevos colores.

---

## ❌ Lo que NO debes hacer

### ⛔ **NO edites estos archivos manualmente:**

- ❌ `public/css/volt.css` - Archivo compilado, se regenera automáticamente
- ❌ `resources/scss/volt/_variables.scss` - Este tiene valores por defecto con `!default`
- ❌ Archivos en `public/documentation/` - Documentación externa
- ❌ Cualquier archivo `.min.css` - Archivos minificados

### ⛔ **NO uses colores hardcodeados en las vistas:**

```html
<!-- ❌ MAL -->
<div style="color: #CBD4C4;">Texto</div>

<!-- ✅ BIEN -->
<div class="text-secondary">Texto</div>
```

---

## 📚 Colores Disponibles en el Sistema

### 🎨 Colores Principales (Brand Colors)
| Variable | Descripción | Uso Principal |
|----------|-------------|---------------|
| `$primary` | Color principal | Botones principales, encabezados, navegación |
| `$secondary` | Color secundario | Elementos destacados, iconos activos, CTAs |
| `$tertiary` | Color terciario | Áreas complementarias, fondos secundarios |

### ✅ Colores Semánticos (Estados)
| Variable | Color por Defecto | Uso |
|----------|-------------------|-----|
| `$success` | `$green` (#10B981) | Estados completados, confirmaciones, aprobaciones |
| `$info` | `$teal` (#1E90FF) | Estados activos/en progreso, información |
| `$warning` | `$yellow` (#F3C78E) | Estados pendientes, alertas moderadas |
| `$danger` | `$red` (#E11D48) | Errores, cancelaciones, acciones destructivas |

### 🎨 Colores Genéricos (Complementarios - para gráficos)
`$blue`, `$indigo`, `$purple`, `$pink`, `$orange`, `$brown`, `$cyan`

### ⚫ Escala de Grises
`$gray-50`, `$gray-100`, `$gray-200`, `$gray-300`, `$gray-400`, `$gray-500`, `$gray-600`, `$gray-700`, `$gray-800`, `$gray-900`

### 📱 Colores de Redes Sociales
`$facebook`, `$twitter`, `$google`, `$instagram`, `$pinterest`, `$youtube`, `$slack`, `$dribbble`, `$github`, `$dropbox`, `$twitch`, `$paypal`, `$behance`, `$reddit`

---

## 🔧 Cómo Funciona

1. **custom/_variables.scss** se importa PRIMERO en `volt.scss` (línea 21)
2. Luego se importa **volt/_variables.scss** que tiene valores `!default` (línea 24)
3. Los valores de `custom/_variables.scss` tienen prioridad sobre los de `volt/_variables.scss`
4. Laravel Mix compila todo en `public/css/volt.css`

---

## 📖 Ejemplo: Cambiar el Color Secondary

**Antes:**
```scss
$secondary: #FB503B;  // Naranja vibrante
```

**Después:**
```scss
$secondary: #CBD4C4;  // Verde suave
```

**Ejecutar:**
```bash
npm run production
```

**Resultado:**
✅ Todos los botones `.btn-secondary`, badges `.bg-secondary`, y demás elementos usan automáticamente el nuevo color.

---

## 🚀 Scripts NPM Disponibles

```bash
npm run dev           # Compilar para desarrollo
npm run production    # Compilar para producción (minificado)
npm run watch         # Compilar y vigilar cambios
npm run hot           # Hot module replacement
```

---

## 📝 Notas Importantes

- Los cambios en `custom/_variables.scss` afectan a TODO el proyecto
- Siempre ejecuta `npm run production` después de cambiar colores
- En producción, asegúrate de limpiar el caché del navegador
- Los archivos compilados NO deben versionarse en Git (están en `.gitignore`)

---

## ✨ Beneficios de este Sistema

✅ **Un solo lugar para cambiar colores** - No hay confusión
✅ **Regeneración automática** - No editas archivos manualmente
✅ **Consistencia garantizada** - Todos los componentes usan los mismos colores
✅ **Fácil mantenimiento** - Cambios centralizados
✅ **Sin errores** - El compilador valida todo

---

## 🎯 SweetAlert2 (Modales de Success/Warning/Error)

Los modales de SweetAlert2 también usan el sistema de colores centralizado:

### 🔔 Colores de Modales que se Actualizan Automáticamente

Cuando cambias los colores en `custom/_variables.scss`, los siguientes modales se actualizan:

| Modal SweetAlert2 | Variable CETAM | Descripción |
|-------------------|----------------|-------------|
| 🟢 **Success** | `$success` | Color del icono de éxito (checkmark verde) |
| 🔴 **Error** | `$danger` | Color del icono de error (X roja) |
| 🟡 **Warning** | `$warning` | Color del icono de advertencia (signo de exclamación) |
| 🔵 **Info** | `$info` | Color del icono de información (i) |
| **Botón Confirmar** | `$primary` | Color de fondo del botón de confirmar |

### 📝 Archivos Involucrados

- **`resources/scss/custom/_sweetalert2-variables.scss`** - Variables personalizadas de SweetAlert2
- **`resources/scss/volt.scss`** (líneas 95-96) - Importación de SweetAlert2 con colores CETAM

### ⚡ Cómo Funciona

1. SweetAlert2 se compila desde el código SCSS fuente (no desde CSS precompilado)
2. Las variables de `custom/_variables.scss` se importan ANTES de SweetAlert2
3. Las variables personalizadas en `custom/_sweetalert2-variables.scss` mapean los colores CETAM a SweetAlert2
4. Al ejecutar `npm run production`, todo se compila con los colores correctos

### 🚨 Importante

Ya NO debes usar el archivo CSS precompilado de SweetAlert2. El CSS ahora se genera desde:
- ❌ **Antes:** `public/vendor/sweetalert2/sweetalert2.min.css` (archivo estático)
- ✅ **Ahora:** Compilado en `public/css/volt.css` con tus colores personalizados

### ⚡ Diferencia Clave

Las variables de SweetAlert2 en `custom/_sweetalert2-variables.scss` **NO** usan el flag `!default`, lo que significa que **SOBRESCRIBEN COMPLETAMENTE** los colores originales de SweetAlert2:
- Todos los bordes, animaciones y efectos visuales usan los colores de CETAM
- No quedan rastros de los colores originales de SweetAlert2
- El cambio es total y consistente en toda la interfaz

---

**Última actualización:** 2025-11-30
**Mantenedor:** Sistema CETAM
