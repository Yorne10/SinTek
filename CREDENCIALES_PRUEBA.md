# Credenciales de Prueba - Sistema SinTek

## Aplicación Web (http://127.0.0.1:8000)
Todos los roles pueden acceder a la aplicación web.

### Administrador
- **Email:** admin@sintek.test
- **Password:** SinTek2025!
- **Permisos:** Acceso completo al sistema

### Secretario(a)
- **Email:** secretaria@sintek.test
- **Password:** Secretary2025!
- **Permisos:** Gestión de solicitudes y trabajadores

### Trabajador
- **Email:** trabajador@sintek.test
- **Password:** Worker2025!
- **Permisos:** Acceso a trámites personales

---

## API Móvil (http://127.0.0.1:8000/api)
**⚠️ SOLO usuarios con rol "worker" pueden acceder a la API móvil.**

### Trabajador (Único rol permitido en móvil)
- **Email:** trabajador@sintek.test
- **Password:** Worker2025!
- **Endpoint:** POST /api/login

**Ejemplo de request:**
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "trabajador@sintek.test",
    "password": "Worker2025!"
  }'
```

**Response exitoso:**
```json
{
  "success": true,
  "message": "Inicio de sesión exitoso",
  "data": {
    "user": {
      "users_id": 2,
      "name": "Juan Pérez García",
      "email": "trabajador@sintek.test",
      "role": "worker",
      "active": 1
    },
    "worker": {
      "workers_id": 1,
      "curp": "PEGJ850315HDFRNN01",
      "sex": "M",
      "phone": "5551234567",
      "adress": "Calle Principal #123, Colonia Centro",
      "rfc": "PEGJ850315XXX",
      "positions": [...]
    },
    "token": "9|abc123..."
  }
}
```

---

## Intentos de login rechazados en API móvil

### Admin intentando acceder (RECHAZADO ❌)
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@sintek.test",
    "password": "SinTek2025!"
  }'
```

**Response:**
```json
{
  "success": false,
  "message": "Acceso denegado. Esta aplicación es solo para trabajadores. Los administradores y secretarios deben usar la aplicación web."
}
```

### Secretario intentando acceder (RECHAZADO ❌)
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "secretaria@sintek.test",
    "password": "Secretary2025!"
  }'
```

**Response:**
```json
{
  "success": false,
  "message": "Acceso denegado. Esta aplicación es solo para trabajadores. Los administradores y secretarios deben usar la aplicación web."
}
```

---

## Notas Importantes

1. **Separación de accesos:**
   - **Web:** Admin, Secretary y Worker pueden acceder
   - **API Móvil:** Solo Worker puede acceder

2. **Autenticación:**
   - Web usa sesiones de Laravel (Livewire)
   - API usa tokens de Laravel Sanctum

3. **Token de API:**
   - Después del login exitoso, guarda el token
   - Incluye el token en el header de todas las requests:
     ```
     Authorization: Bearer {token}
     ```

4. **Crear nuevos workers:**
   - Desde la web: http://127.0.0.1:8000/p/sintek/users/create
   - Desde la API: POST /api/register/worker (público)
