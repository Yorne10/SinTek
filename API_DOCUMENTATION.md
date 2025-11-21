# API Documentation - Sistema Sindicato

Esta es la documentación completa de los endpoints de la API REST para el sistema del sindicato. La API está diseñada para ser consumida por la aplicación web y la aplicación móvil Flutter.

## Base URL
```
http://localhost:8000/api
```

## Autenticación

La API utiliza Laravel Sanctum para la autenticación basada en tokens. Todos los endpoints protegidos requieren el header:
```
Authorization: Bearer {token}
```

---

## Endpoints Públicos

### 1. Login
**POST** `/login`

Autentica un usuario y devuelve un token de acceso.

**Request Body:**
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "users_id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "role": "worker",
            "active": 1,
            "worker": {
                "workers_id": 1,
                "curp": "ABCD123456",
                "sex": "M",
                "phone": "1234567890",
                "adress": "Calle 123",
                "rfc": "RFC123456",
                "positions": []
            }
        },
        "token": "1|abc123..."
    }
}
```

### 2. Registrar Worker
**POST** `/register/worker`

Registra un nuevo worker con su cuenta de usuario.

**Request Body:**
```json
{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "curp": "ABCD123456",
    "sex": "M",
    "phone": "1234567890",
    "adress": "Calle 123",
    "rfc": "RFC123456"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Worker registered successfully",
    "data": {
        "user": {...},
        "worker": {...},
        "token": "1|abc123..."
    }
}
```

---

## Endpoints Protegidos (Requieren Autenticación)

### Autenticación

#### Logout
**POST** `/logout`
- Revoca el token actual del usuario
- Headers: `Authorization: Bearer {token}`

#### Obtener Usuario Actual
**GET** `/me`
- Obtiene la información del usuario autenticado
- Headers: `Authorization: Bearer {token}`

---

## Endpoints para Workers (App Móvil)

Estos endpoints están disponibles para usuarios con el role `worker`. Pueden ser consumidos desde la aplicación móvil Flutter.

### Mis Solicitudes
**GET** `/my-requests`
- Obtiene todas las solicitudes del worker autenticado
- Headers: `Authorization: Bearer {token}`

### Mis Documentos
**GET** `/my-documents`
- Obtiene todos los documentos del worker autenticado
- Headers: `Authorization: Bearer {token}`

### Mis Notificaciones
**GET** `/my-notifications`
- Obtiene todas las notificaciones del worker autenticado
- Headers: `Authorization: Bearer {token}`

### Mi Perfil
**GET** `/my-profile`
- Obtiene el perfil completo del worker autenticado
- Headers: `Authorization: Bearer {token}`

**PUT** `/my-profile`
- Actualiza el perfil del worker autenticado
- Headers: `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "curp": "ABCD123456",
    "sex": "M",
    "phone": "1234567890",
    "adress": "Nueva dirección",
    "rfc": "RFC123456"
}
```

### FAQs (Lectura)
**GET** `/faqs`
- Obtiene todas las preguntas frecuentes activas

**GET** `/faqs/{id}`
- Obtiene una pregunta frecuente específica

---

## Endpoints para Admin y Secretarios (Web/Móvil)

### Usuarios (Solo Admin)

**GET** `/users`
- Lista todos los usuarios
- Role: `admin`

**POST** `/users`
- Crea un nuevo usuario
- Role: `admin`

**GET** `/users/{id}`
- Obtiene un usuario específico
- Role: `admin`

**PUT** `/users/{id}`
- Actualiza un usuario
- Role: `admin`

**DELETE** `/users/{id}`
- Elimina un usuario
- Role: `admin`

### Workers (Admin y Secretary)

**GET** `/workers`
- Lista todos los workers
- Role: `admin`, `secretary`

**POST** `/workers`
- Crea un nuevo worker
- Role: `admin`, `secretary`

**GET** `/workers/{id}`
- Obtiene un worker específico
- Role: `admin`, `secretary`

**PUT** `/workers/{id}`
- Actualiza un worker
- Role: `admin`, `secretary`

**DELETE** `/workers/{id}`
- Elimina un worker
- Role: `admin`, `secretary`

### Positions (Solo Admin)

**GET** `/positions`
- Lista todas las posiciones
- Role: `admin`

**POST** `/positions`
- Crea una nueva posición
- Role: `admin`

**Request Body:**
```json
{
    "budget_key": "CLAVE123",
    "position_name": "Nombre del puesto"
}
```

**GET** `/positions/{id}`
**PUT** `/positions/{id}`
**DELETE** `/positions/{id}`

### Processes (Solo Admin)

**GET** `/processes`
- Lista todos los procesos
- Role: `admin`

**POST** `/processes`
- Crea un nuevo proceso
- Role: `admin`

**Request Body:**
```json
{
    "name": "Proceso de solicitud",
    "description": "Descripción del proceso",
    "active": 1
}
```

### Steps (Solo Admin)

**GET** `/steps`
- Lista todos los pasos
- Role: `admin`

**POST** `/steps`
- Crea un nuevo paso
- Role: `admin`

**Request Body:**
```json
{
    "process_id": 1,
    "order": 1,
    "tittle": "Título del paso",
    "description": "Descripción",
    "condition_type": "approval",
    "next_yes": 2,
    "next_no": null
}
```

### Requests (Admin y Secretary)

**GET** `/requests`
- Lista todas las solicitudes
- Role: `admin`, `secretary`

**POST** `/requests`
- Crea una nueva solicitud
- Role: `admin`, `secretary`

**Request Body:**
```json
{
    "worker_id": 1,
    "process_id": 1,
    "status": "pending",
    "start_date": "2025-01-01",
    "end_date": null
}
```

**GET** `/requests/{id}`
**PUT** `/requests/{id}`
**DELETE** `/requests/{id}`

### Request Steps (Admin y Secretary)

**GET** `/request-steps`
**POST** `/request-steps`
**GET** `/request-steps/{id}`
**PUT** `/request-steps/{id}`
**DELETE** `/request-steps/{id}`

### Documents (Admin y Secretary)

**GET** `/documents`
**POST** `/documents`

**Request Body (multipart/form-data):**
```json
{
    "request_id": 1,
    "step_id": 1,
    "type": "pdf",
    "name": "Documento importante",
    "file": <archivo>
}
```

**GET** `/documents/{id}`
**PUT** `/documents/{id}`
**DELETE** `/documents/{id}`

### Notifications (Admin y Secretary)

**GET** `/notifications`
- Lista todas las notificaciones
- Role: `admin`, `secretary`

**POST** `/notifications`
- Crea una notificación
- Role: `admin`, `secretary`

**Request Body:**
```json
{
    "user_id": 1,
    "tittle": "Nueva notificación",
    "message": "Mensaje de la notificación",
    "type": "info",
    "request_id": 1,
    "steps_id": null,
    "convocations_id": null
}
```

**PATCH** `/notifications/{id}/read`
- Marca una notificación como leída
- Role: `admin`, `secretary`

### Convocations (Solo Admin)

**GET** `/convocations`
**POST** `/convocations`

**Request Body:**
```json
{
    "title": "Nueva convocatoria",
    "description": "Descripción",
    "file_path": "/path/to/file",
    "start_date": "2025-01-01",
    "end_date": "2025-01-31",
    "status": "active"
}
```

**GET** `/convocations/{id}`
**PUT** `/convocations/{id}`
**DELETE** `/convocations/{id}`

### FAQs (Admin y Secretary)

**POST** `/faqs`
- Crea una nueva pregunta frecuente
- Role: `admin`, `secretary`

**Request Body:**
```json
{
    "question": "¿Cómo hago...?",
    "answer": "Respuesta detallada",
    "category": "general",
    "status": 1
}
```

**PUT** `/faqs/{id}`
**DELETE** `/faqs/{id}`

### Logs (Solo Admin - Solo Lectura)

**GET** `/logs`
- Lista todos los logs del sistema
- Role: `admin`

**GET** `/logs/{id}`
- Obtiene un log específico
- Role: `admin`

---

## Roles y Permisos

### Roles disponibles:
1. **admin** - Acceso completo a todas las funcionalidades
2. **secretary** - Gestión de workers, solicitudes, documentos y notificaciones
3. **worker** - Acceso solo a sus propios datos (app móvil)

### Restricciones:
- La app móvil **solo** permite login de usuarios con role `worker`
- Los endpoints de worker (`/my-*`) solo están disponibles para workers autenticados
- Los endpoints administrativos requieren roles específicos

---

## Códigos de Estado HTTP

- `200` - OK (Operación exitosa)
- `201` - Created (Recurso creado exitosamente)
- `400` - Bad Request (Error en la petición)
- `401` - Unauthorized (No autenticado)
- `403` - Forbidden (No tiene permisos)
- `404` - Not Found (Recurso no encontrado)
- `422` - Unprocessable Entity (Error de validación)
- `500` - Internal Server Error (Error del servidor)

---

## Ejemplo de Integración en Flutter

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class ApiService {
  final String baseUrl = 'http://localhost:8000/api';
  String? token;

  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );

    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      token = data['data']['token'];
      return data;
    } else {
      throw Exception('Failed to login');
    }
  }

  Future<Map<String, dynamic>> getMyRequests() async {
    final response = await http.get(
      Uri.parse('$baseUrl/my-requests'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load requests');
    }
  }
}
```

---

## Notas Importantes

1. **Todos los endpoints protegidos requieren el header de Authorization con el token Bearer**
2. **Los workers solo pueden acceder a través de la app móvil**
3. **La aplicación web es para admin y secretary**
4. **Los tokens de Sanctum no expiran por defecto (configurado en `sanctum.php`)**
5. **CORS está configurado para aceptar todas las origins en desarrollo**

---

Para más información o reportar problemas, contacta al equipo de desarrollo.
