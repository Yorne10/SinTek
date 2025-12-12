# 🔒 PLAN DE PRUEBAS - SISTEMA DE INACTIVIDAD

## ✅ MEJORAS IMPLEMENTADAS

### 1. **Verificación de sesión en servidor**
- Cuando el usuario presiona "Continuar sesión", se verifica que la sesión siga activa en el servidor
- Si la sesión expiró (401/419), se cierra automáticamente

### 2. **Feedback visual mejorado**
- SweetAlert muestra "Cerrando sesión..." con loading spinner
- Confirmación de "Sesión extendida" cuando se renueva exitosamente
- Mensaje más claro en la alerta de inactividad

### 3. **Manejo robusto de errores**
- Try-catch en el logout para manejar errores de red
- Redirección forzada a session-expired si falla el logout
- Manejo de TokenMismatchException y AuthenticationException

### 4. **Página de sesión expirada mejorada**
- Mensaje más claro y tranquilizador
- Botón único con icono
- Diseño más limpio

---

## 📋 CASOS DE PRUEBA

### **CASO 1: Flujo normal de inactividad**

**Pasos:**
1. Iniciar sesión en el sistema
2. **NO** tocar el mouse, teclado, ni hacer scroll
3. Esperar 119.5 minutos (configuración por defecto: 120 min - 30 seg)
4. Debe aparecer SweetAlert: "¿Sigues ahí?"
5. **NO hacer nada** durante 30 segundos
6. El timer expirará automáticamente
7. Debe mostrarse "Cerrando sesión..." con loading
8. Debe redirigir a `/p/sintek/session-expired`
9. La página debe mostrar: "Tu sesión ha expirado"
10. Click en "Iniciar sesión nuevamente"
11. Debe redirigir al login

**Resultado esperado:** ✅ Flujo completo sin errores

---

### **CASO 2: Usuario continúa la sesión**

**Pasos:**
1. Iniciar sesión en el sistema
2. NO tocar nada durante 119.5 minutos
3. Aparece SweetAlert: "¿Sigues ahí?"
4. **Click en "Continuar sesión"**
5. Debe mostrarse "Sesión extendida" brevemente
6. El timer se reinicia
7. El usuario puede seguir trabajando

**Resultado esperado:** ✅ Sesión extendida exitosamente

---

### **CASO 3: Usuario cancela manualmente**

**Pasos:**
1. Iniciar sesión en el sistema
2. NO tocar nada durante 119.5 minutos
3. Aparece SweetAlert: "¿Sigues ahí?"
4. **Click en "Cerrar sesión"**
5. Debe mostrarse "Cerrando sesión..." con loading
6. Debe redirigir a `/p/sintek/session-expired`

**Resultado esperado:** ✅ Cierre de sesión manual exitoso

---

### **CASO 4: Actividad del usuario reinicia el timer**

**Pasos:**
1. Iniciar sesión en el sistema
2. Esperar 100 minutos sin hacer nada
3. **Mover el mouse** o hacer **scroll**
4. El timer se reinicia desde cero
5. Esperar otros 119.5 minutos
6. Debe aparecer SweetAlert nuevamente

**Resultado esperado:** ✅ Timer se reinicia con actividad

**Eventos que reinician el timer:**
- `mousedown` (click del mouse)
- `mousemove` (movimiento del mouse)
- `keypress` (presionar teclas)
- `scroll` (hacer scroll)
- `touchstart` (tocar pantalla táctil)

---

### **CASO 5: Sesión expirada en el servidor (Edge Case)**

**Pasos:**
1. Iniciar sesión en el sistema
2. **En otro tab**, ejecutar manualmente:
   ```bash
   php artisan cache:clear
   php artisan session:clear
   ```
   O simplemente esperar que la sesión expire en el servidor (120 min)
3. En el tab original, esperar a que aparezca "¿Sigues ahí?"
4. Click en "Continuar sesión"
5. El sistema detecta que la sesión expiró (401/419)
6. Debe redirigir automáticamente a `/p/sintek/session-expired`

**Resultado esperado:** ✅ Detección de sesión expirada en servidor

---

### **CASO 6: Error de red durante logout**

**Pasos:**
1. Iniciar sesión en el sistema
2. Abrir DevTools → Network tab
3. Activar "Offline mode" (simular sin internet)
4. NO tocar nada durante 119.5 minutos
5. Aparece SweetAlert: "¿Sigues ahí?"
6. NO hacer nada (dejar que expire)
7. Debe mostrarse "Cerrando sesión..."
8. Como no hay red, el catch maneja el error
9. Debe redirigir forzadamente a `/p/sintek/session-expired`

**Resultado esperado:** ✅ Redirección forzada incluso sin red

---

### **CASO 7: CSRF Token inválido**

**Pasos:**
1. Iniciar sesión en el sistema
2. Esperar que la sesión expire en el servidor (120 min)
3. Intentar enviar un formulario Livewire
4. El sistema detecta TokenMismatchException
5. Debe redirigir a `/p/sintek/session-expired`

**Resultado esperado:** ✅ Manejo correcto de CSRF expirado

---

### **CASO 8: Petición Ajax después de sesión expirada**

**Pasos:**
1. Iniciar sesión en el sistema
2. Abrir una página con componentes Livewire
3. Esperar que la sesión expire (120 min)
4. Intentar interactuar con un componente Livewire
5. El sistema detecta AuthenticationException
6. Como es petición Livewire, redirige a session-expired

**Resultado esperado:** ✅ Redirección desde peticiones Ajax

---

### **CASO 9: Múltiples tabs abiertos**

**Pasos:**
1. Iniciar sesión en el sistema
2. Abrir 3 tabs diferentes (Dashboard, Perfil, Usuarios)
3. NO tocar ningún tab durante 119.5 minutos
4. En cada tab debe aparecer "¿Sigues ahí?" casi al mismo tiempo
5. En el **Tab 1**, click en "Continuar sesión"
6. En los **otros tabs**, el timer debería seguir activo (no se sincronizan entre tabs)
7. Cada tab maneja su propio timer independientemente

**Resultado esperado:** ✅ Cada tab maneja su timer independientemente

---

### **CASO 10: Usuario cierra el navegador**

**Pasos:**
1. Iniciar sesión en el sistema
2. Cerrar el navegador completamente
3. Abrir el navegador nuevamente
4. Intentar acceder a una ruta protegida directamente
5. Como la sesión sigue activa (no se marcó "recordarme"), debe funcionar
6. Si pasaron 120 minutos, la sesión expiró y redirige al login

**Resultado esperado:** ✅ Sesión persiste según configuración

---

## 🔧 CONFIGURACIÓN DEL SISTEMA

### ⚠️ **CORRECCIÓN IMPORTANTE APLICADA**

**Problema solucionado:** Anteriormente, cuando el timer expiraba, se mostraba brevemente la URL `/logout?idle=1` en el navegador antes de redirigir a `/session-expired`.

**Solución:** Ahora se usa `fetch()` (Ajax) para hacer el logout en segundo plano, y JavaScript redirige **DIRECTAMENTE** a `/session-expired` sin mostrar URLs intermedias.

Ver archivo `PRUEBA_FLUJO_INACTIVIDAD.md` para detalles completos de la corrección.

---

### **Tiempo de sesión**
- Archivo: `config/session.php`
- Parámetro: `'lifetime' => env('SESSION_LIFETIME', 120)`
- Valor por defecto: **120 minutos**
- Para pruebas rápidas, cambia en `.env`:
  ```
  SESSION_LIFETIME=2  # 2 minutos para testing
  ```

### **Tiempo de warning**
- Archivo: `resources/views/layouts/partials/idle-timer.blade.php`
- Línea 9: `const warningDuration = 30 * 1000; // 30 segundos`
- Para pruebas, cambia a:
  ```javascript
  const warningDuration = 10 * 1000; // 10 segundos para testing
  ```

---

## 🧪 PRUEBAS RÁPIDAS (MODO DESARROLLO)

Para hacer pruebas sin esperar 120 minutos:

1. **Modificar `.env`:**
   ```
   SESSION_LIFETIME=1  # 1 minuto
   ```

2. **Modificar `idle-timer.blade.php` línea 9:**
   ```javascript
   const warningDuration = 10 * 1000; // 10 segundos
   ```

3. **Reiniciar servidor:**
   ```bash
   php artisan config:clear
   php artisan serve
   ```

4. **Probar:**
   - Iniciar sesión
   - Esperar **50 segundos** sin tocar nada
   - Debe aparecer el SweetAlert
   - Esperar **10 segundos** más (o hacer nada)
   - Debe cerrar sesión y redirigir a session-expired

---

## ✅ CHECKLIST DE VERIFICACIÓN

- [ ] El timer se carga solo en páginas autenticadas
- [ ] El SweetAlert aparece antes de que expire la sesión
- [ ] El botón "Continuar sesión" renueva correctamente
- [ ] El botón "Cerrar sesión" cierra y redirige a session-expired
- [ ] El timer expirando automáticamente cierra y redirige
- [ ] Los eventos de usuario (mouse, teclado, scroll) reinician el timer
- [ ] La verificación en servidor detecta sesiones expiradas
- [ ] El manejo de errores funciona correctamente
- [ ] La página session-expired se ve correctamente
- [ ] El botón de "Iniciar sesión nuevamente" funciona
- [ ] TokenMismatchException redirige a session-expired
- [ ] AuthenticationException maneja correctamente Ajax/Livewire
- [ ] No hay errores en consola del navegador

---

## 🐛 DEBUGGING

Si algo no funciona:

1. **Verificar en DevTools Console:**
   - Debe mostrar: "SweetAlert2 is loaded"
   - NO debe haber errores JavaScript

2. **Verificar rutas:**
   ```bash
   php artisan route:list | grep session-expired
   ```
   Debe mostrar: `proj.errors.session-expired`

3. **Verificar logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Verificar sesión:**
   ```bash
   # Ver archivos de sesión
   ls -la storage/framework/sessions/
   ```

---

## 📊 RESUMEN DE ARCHIVOS MODIFICADOS

1. **resources/views/layouts/partials/idle-timer.blade.php**
   - Agregada verificación de sesión en servidor
   - Agregado feedback visual mejorado
   - Agregado manejo robusto de errores

2. **app/Exceptions/Handler.php**
   - Agregado manejo de TokenMismatchException
   - Agregado manejo de AuthenticationException
   - Agregado soporte para peticiones Ajax/Livewire

3. **resources/views/errors/session-expired.blade.php**
   - Mejorado diseño y mensajes
   - Simplificado botones

4. **app/Services/Auth/FallbackAuthService.php**
   - Ya estaba correcto, maneja `?idle=1` correctamente

---

## 🎯 RESULTADO FINAL ESPERADO

**Flujo perfecto:**
1. Usuario autenticado → Timer activo
2. Inactividad por 119.5 min → SweetAlert "¿Sigues ahí?"
3. Usuario no responde (30 seg) → "Cerrando sesión..."
4. Redirección automática → `/p/sintek/session-expired`
5. Página limpia y clara → Botón de volver al login
6. Click en botón → Login exitoso

**Sin errores en:**
- Console del navegador
- Network tab
- Logs de Laravel
- Base de datos

---

## 🎉 VERIFICACIÓN FINAL DEL SISTEMA

### ✅ Componentes Verificados

1. **Configuración de sesión (`config/session.php`)**
   - Lifetime: 120 minutos (configurable via `.env`)
   - Driver: file
   - Cookie segura y httpOnly habilitado

2. **Timer JavaScript (`resources/views/layouts/partials/idle-timer.blade.php`)**
   - ✅ Se carga solo en páginas autenticadas (`@auth` en app.blade.php línea 118-120)
   - ✅ Timer configurado dinámicamente desde Laravel config
   - ✅ Warning aparece 30 segundos antes de expiración
   - ✅ Eventos de usuario reinician el timer: mousedown, mousemove, keypress, scroll, touchstart
   - ✅ Verificación de sesión en servidor cuando usuario continúa
   - ✅ Detección de sesión expirada (401/419) en servidor
   - ✅ Feedback visual: "Cerrando sesión...", "Sesión extendida"
   - ✅ Manejo de errores con try-catch y fallback redirect
   - ✅ **NUEVO:** Logout mediante fetch() para evitar mostrar URL `/logout?idle=1`
   - ✅ **NUEVO:** Redirección directa a `/session-expired` sin URLs intermedias

3. **Logout Service (`app/Services/Auth/FallbackAuthService.php`)**
   - ✅ **NUEVO:** Detecta peticiones JSON y retorna JSON en lugar de redirección HTML
   - ✅ Logout manual desde sidebar redirige a `login` (línea 127)
   - ✅ Logout por inactividad retorna JSON para que JavaScript maneje la redirección
   - ✅ Manejo de errores con try-catch (línea 128-139)

4. **Exception Handler (`app/Exceptions/Handler.php`)**
   - ✅ TokenMismatchException → session-expired (línea 42-47)
   - ✅ AuthenticationException → session-expired para Ajax/Livewire (línea 58-68)
   - ✅ MethodNotAllowedHttpException → session-expired (línea 50-55)
   - ✅ Soporte para peticiones JSON con códigos HTTP apropiados

5. **Ruta session-expired (`routes/web.php`)**
   - ✅ Ruta pública: `/p/sintek/session-expired` (línea 101)
   - ✅ Nombre: `proj.errors.session-expired`
   - ✅ Vista: `resources/views/errors/session-expired.blade.php`

6. **Vista session-expired (`resources/views/errors/session-expired.blade.php`)**
   - ✅ Diseño claro y profesional
   - ✅ Mensaje tranquilizador sobre cambios guardados
   - ✅ Botón de acción claro: "Iniciar sesión nuevamente"
   - ✅ Enlace directo al login

### 🔗 Flujo Completo Verificado (ACTUALIZADO)

```
Usuario autenticado
        ↓
  Timer activo (120 min)
        ↓
  Inactividad detectada
        ↓
  SweetAlert "¿Sigues ahí?" (30 seg)
        ↓
    ┌───────┴───────┐
    ↓               ↓
Continuar      No responde
    ↓               ↓
Validar       Auto-expire
servidor          ↓
    ↓         "Cerrando..."
  ┌─┴─┐            ↓
  ↓   ↓      fetch POST /logout (Ajax)
Válido Exp.         ↓
  ↓   ↓      Servidor retorna JSON
"Extendida"         ↓
  ↓   ↓      JavaScript redirige
Timer  ↓            ↓
reinicia    window.location.href
         ↘    = '/session-expired'
          ↘   ↙
        Vista limpia
           ↓
    "Tu sesión ha expirado"
           ↓
      Botón "Login"
```

**IMPORTANTE:** Ya NO aparece `/logout?idle=1` en la barra de direcciones del navegador.

### 📍 Archivos Involucrados

| Archivo | Responsabilidad | Líneas Clave | Cambios |
|---------|----------------|--------------|---------|
| `config/session.php` | Configuración de lifetime | 34 | Sin cambios |
| `resources/views/layouts/app.blade.php` | Inclusión del timer solo para @auth | 118-120 | Sin cambios |
| `resources/views/layouts/partials/idle-timer.blade.php` | Lógica del timer JavaScript | 101-117 | ✅ **MODIFICADO:** Usa fetch() en lugar de form.submit() |
| `app/Services/Auth/FallbackAuthService.php` | Manejo de logout JSON/HTML | 111-139 | ✅ **MODIFICADO:** Retorna JSON para peticiones Ajax |
| `app/Exceptions/Handler.php` | Manejo de excepciones de sesión | 42-68 | Sin cambios |
| `routes/web.php` | Definición de ruta session-expired | 101 | Sin cambios |
| `resources/views/errors/session-expired.blade.php` | Vista de sesión expirada | 1-44 | Sin cambios |

---

**NOTA IMPORTANTE:** Recuerda revertir SESSION_LIFETIME a 120 minutos en producción después de las pruebas.
