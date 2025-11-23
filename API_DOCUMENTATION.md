# API Documentation - Sistema Sindicato

Esta es la documentación completa de los endpoints de la API REST para el sistema del sindicato.

## ⚠️ IMPORTANTE: Audiencia de la API

**La API está diseñada EXCLUSIVAMENTE para la aplicación móvil Flutter (WORKERS).**

- ✅ **Workers**: Usan la API REST (esta documentación)
- ❌ **Admin y Secretary**: Usan la aplicación WEB con Livewire (NO consumen esta API)

## Arquitectura del Sistema

```
┌─────────────────────────────────────────────┐
│         LARAVEL BACKEND                     │
├─────────────────────────────────────────────┤
│                                             │
│  ┌────────────────┐    ┌─────────────────┐ │
│  │   LIVEWIRE     │    │   API REST      │ │
│  │   (Web App)    │    │   (Workers)     │ │
│  │                │    │                 │ │
│  │ - Admin ✓      │    │ - Workers ✓     │ │
│  │ - Secretary ✓  │    │ - Admin ✗       │ │
│  │ - Worker ✓     │    │ - Secretary ✗   │ │
│  └────────────────┘    └─────────────────┘ │
│         │                      │            │
└─────────┼──────────────────────┼────────────┘
          │                      │
          ▼                      ▼
    ┌──────────┐          ┌──────────┐
    │  WEB UI  │          │ FLUTTER  │
    │  Browser │          │   APP    │
    │  Admin/  │          │ Workers  │
    │ Secretary│          │   ONLY   │
    └──────────┘          └──────────┘
```

## Base URL
```
http://localhost:8000/api
```

## Autenticación

La API utiliza Laravel Sanctum para la autenticación basada en tokens.

**⚠️ TODOS los endpoints (excepto login y registro) están protegidos con:**
- Autenticación: `auth:sanctum`
- Rol requerido: `worker`

**Headers requeridos:**
```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

---

## Endpoints Públicos

### 1. Login (Solo Workers - Aplicación Móvil)
**POST** `/login`

Autentica un trabajador y devuelve un token de acceso.

**⚠️ IMPORTANTE:** Este endpoint está restringido SOLO para usuarios con rol `worker`. Los administradores y secretarios deben usar la aplicación web para iniciar sesión.

**Request Body:**
```json
{
    "email": "trabajador@example.com",
    "password": "password123"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Inicio de sesión exitoso",
    "data": {
        "user": {
            "users_id": 1,
            "name": "Juan Pérez",
            "email": "juan@example.com",
            "role": "worker",
            "active": 1
        },
        "worker": {
            "workers_id": 1,
            "curp": "ABCD123456",
            "sex": "M",
            "phone": "1234567890",
            "adress": "Calle 123",
            "rfc": "RFC123456",
            "positions": []
        },
        "token": "1|abc123..."
    }
}
```

**Response Error - Usuario no es worker (403):**
```json
{
    "success": false,
    "message": "Acceso denegado. Esta aplicación es solo para trabajadores. Los administradores y secretarios deben usar la aplicación web."
}
```

**Response Error - Credenciales inválidas (401):**
```json
{
    "success": false,
    "message": "Credenciales inválidas"
}
```

**Response Error - Cuenta inactiva (403):**
```json
{
    "success": false,
    "message": "Tu cuenta está inactiva. Contacta al administrador."
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

---

## Endpoints de Perfil (Todos los usuarios autenticados)

### 1. Obtener Mi Perfil
**GET** `/my-profile`

Obtiene la información completa del perfil del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "user": {
            "users_id": 1,
            "name": "Juan Pérez García",
            "email": "juan@example.com",
            "role": "worker",
            "active": 1,
            "created_at": "2025-11-21T01:17:24.000000Z",
            "updated_at": "2025-11-21T01:17:24.000000Z"
        },
        "worker": {
            "workers_id": 1,
            "user_id": 1,
            "curp": "PEGJ850315HDFRNN01",
            "sex": "M",
            "phone": "5551234567",
            "adress": "Calle Principal #123, Colonia Centro",
            "rfc": "PEGJ850315XXX",
            "positions": [
                {
                    "positions_id": 1,
                    "budget_key": "CLAVE-001",
                    "position_name": "Analista de Sistemas"
                }
            ]
        }
    }
}
```

**Nota:** Si el usuario no es worker, el campo `worker` será `null`.

### 2. Actualizar Mi Perfil
**PUT** `/my-profile` o **PATCH** `/my-profile`

Actualiza la información del perfil del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body (Todos los campos son opcionales):**
```json
{
    "name": "Juan Pérez García",
    "email": "juan.perez@example.com",
    "curp": "PEGJ850315HDFRNN01",
    "sex": "M",
    "phone": "5551234567",
    "adress": "Calle Principal #123, Colonia Centro",
    "rfc": "PEGJ850315XXX"
}
```

**Campos editables:**
- **Para todos los usuarios:**
  - `name`: Nombre completo (máx. 150 caracteres)
  - `email`: Correo electrónico (único, válido)

- **Solo para workers (campos adicionales):**
  - `curp`: CURP (máx. 20 caracteres)
  - `sex`: Sexo ("M" o "F")
  - `phone`: Teléfono (máx. 20 caracteres)
  - `adress`: Dirección (máx. 255 caracteres)
  - `rfc`: RFC (máx. 20 caracteres)

**Response Success (200):**
```json
{
    "success": true,
    "message": "Perfil actualizado exitosamente",
    "data": {
        "user": {
            "users_id": 1,
            "name": "Juan Pérez García",
            "email": "juan.perez@example.com",
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
        }
    }
}
```

**Response Error - Validación (422):**
```json
{
    "success": false,
    "errors": {
        "email": ["El correo electrónico ya está registrado."],
        "curp": ["El CURP no debe exceder 20 caracteres."]
    }
}
```

**⚠️ IMPORTANTE - Cómo enviar la request correctamente desde Flutter:**

```dart
// ❌ INCORRECTO - Esto NO funcionará si no envías todos los campos
final response = await http.put(
  Uri.parse('$baseUrl/my-profile'),
  headers: {
    'Authorization': 'Bearer $token',
    'Content-Type': 'application/json',
  },
  body: jsonEncode({
    'phone': phone, // Solo envías phone
  }),
);

// ✅ CORRECTO - Envía TODOS los campos que quieres actualizar
final response = await http.put(
  Uri.parse('$baseUrl/my-profile'),
  headers: {
    'Authorization': 'Bearer $token',
    'Content-Type': 'application/json',
  },
  body: jsonEncode({
    'name': name,
    'email': email,
    'curp': curp,
    'sex': sex,
    'phone': phone,
    'adress': adress,
    'rfc': rfc,
  }),
);

// ✅ TAMBIÉN CORRECTO - Solo enviar los campos que cambias
// El backend ahora acepta actualizaciones parciales
final response = await http.patch(
  Uri.parse('$baseUrl/my-profile'),
  headers: {
    'Authorization': 'Bearer $token',
    'Content-Type': 'application/json',
  },
  body: jsonEncode({
    'phone': newPhone, // Solo actualiza el teléfono
  }),
);
```

**Debugging - Ver los logs:**

Si los cambios no se están aplicando, revisa los logs del servidor en:
```bash
tail -f storage/logs/laravel.log
```

Verás algo como:
```
[2025-11-22 23:00:00] local.INFO: Profile Update Request {"user_id":1,"request_data":{"phone":"5551234567"}}
```

### 3. Actualizar Contraseña
**PUT** `/my-profile/password`

Permite al usuario cambiar su contraseña.

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "current_password": "password_actual",
    "new_password": "nueva_password123",
    "new_password_confirmation": "nueva_password123"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Contraseña actualizada exitosamente"
}
```

**Response Error - Contraseña actual incorrecta (401):**
```json
{
    "success": false,
    "message": "La contraseña actual es incorrecta"
}
```

**Response Error - Validación (422):**
```json
{
    "success": false,
    "errors": {
        "new_password": ["La nueva contraseña debe tener al menos 8 caracteres."],
        "new_password_confirmation": ["Las contraseñas no coinciden."]
    }
}
```

---

## Endpoints para Workers (Aplicación Móvil)

Estos endpoints están disponibles SOLO para usuarios con el role `worker`.

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

## Convocatorias

### 1. Listar Convocatorias Activas
**GET** `/convocations`

Obtiene todas las convocatorias activas, permanentes y próximas con sus documentos.

**Headers:**
```
Authorization: Bearer {token}
```

**Response Success (200):**
```json
{
    "success": true,
    "data": [
        {
            "convocation_id": 1,
            "title": "Convocatoria para plaza de coordinador administrativo",
            "description": "Se convoca a participar en el proceso de selección para el puesto de coordinador del área administrativa...",
            "start_date": "2025-11-01",
            "end_date": "2025-11-15",
            "status": "activa",
            "status_label": "Vigente",
            "is_permanent": false,
            "documents": [
                {
                    "document_id": 1,
                    "title": "Bases de la convocatoria",
                    "download_url": "http://localhost:8000/api/convocation-documents/1"
                },
                {
                    "document_id": 2,
                    "title": "Formato de solicitud",
                    "download_url": "http://localhost:8000/api/convocation-documents/2"
                }
            ],
            "documents_count": 2,
            "created_at": "2025-11-22 18:30:00"
        },
        {
            "convocation_id": 2,
            "title": "Programa de Capacitación 2025",
            "description": "Convocatoria permanente para cursos de capacitación...",
            "start_date": "2025-01-01",
            "end_date": null,
            "status": "permanente",
            "status_label": "Permanente",
            "is_permanent": true,
            "documents": [],
            "documents_count": 0,
            "created_at": "2025-11-20 10:00:00"
        }
    ],
    "count": 2
}
```

**Ejemplo Flutter:**
```dart
Future<List<Convocation>> fetchConvocations() async {
  final response = await http.get(
    Uri.parse('$baseUrl/convocations'),
    headers: {
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    },
  );

  if (response.statusCode == 200) {
    final jsonData = json.decode(response.body);
    if (jsonData['success']) {
      return (jsonData['data'] as List)
          .map((item) => Convocation.fromJson(item))
          .toList();
    }
    throw Exception('Failed to load convocations');
  }
  throw Exception('Failed to load convocations');
}
```

### 2. Obtener Convocatoria Específica
**GET** `/convocations/{id}`

Obtiene los detalles de una convocatoria específica.

**Headers:**
```
Authorization: Bearer {token}
```

**URL Parameters:**
- `id` (required): ID de la convocatoria

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "convocation_id": 1,
        "title": "Convocatoria para plaza de coordinador administrativo",
        "description": "Se convoca a participar en el proceso de selección para el puesto de coordinador del área administrativa...",
        "start_date": "2025-11-01",
        "end_date": "2025-11-15",
        "status": "activa",
        "status_label": "Vigente",
        "is_permanent": false,
        "documents": [
            {
                "document_id": 1,
                "title": "Bases de la convocatoria",
                "download_url": "http://localhost:8000/api/convocation-documents/1"
            }
        ],
        "documents_count": 1,
        "created_at": "2025-11-22 18:30:00"
    }
}
```

**Response Not Found (404):**
```json
{
    "success": false,
    "message": "Convocatoria no encontrada"
}
```

**Ejemplo Flutter:**
```dart
Future<Convocation> fetchConvocation(int id) async {
  final response = await http.get(
    Uri.parse('$baseUrl/convocations/$id'),
    headers: {
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    },
  );

  if (response.statusCode == 200) {
    final jsonData = json.decode(response.body);
    if (jsonData['success']) {
      return Convocation.fromJson(jsonData['data']);
    }
    throw Exception(jsonData['message']);
  } else if (response.statusCode == 404) {
    throw Exception('Convocatoria no encontrada');
  }
  throw Exception('Error al cargar convocatoria');
}
```

### 3. Descargar Documento de Convocatoria
**GET** `/convocation-documents/{id}`

Descarga un documento PDF de una convocatoria en formato Base64.

**Headers:**
```
Authorization: Bearer {token}
```

**URL Parameters:**
- `id` (required): ID del documento

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "document_id": 1,
        "title": "Bases de la convocatoria",
        "file_content": "JVBERi0xLjQKJeLjz9MKMyAwIG9iago8PC9UeXBlL...",
        "mime_type": "application/pdf",
        "file_extension": "pdf"
    }
}
```

**Response Not Found (404):**
```json
{
    "success": false,
    "message": "Documento no encontrado"
}
```

**Ejemplo Flutter:**
```dart
import 'dart:convert';
import 'dart:io';
import 'package:path_provider/path_provider.dart';

Future<File> downloadDocument(int documentId, String title) async {
  final response = await http.get(
    Uri.parse('$baseUrl/convocation-documents/$documentId'),
    headers: {
      'Authorization': 'Bearer $token',
      'Accept': 'application/json',
    },
  );

  if (response.statusCode == 200) {
    final jsonData = json.decode(response.body);
    if (jsonData['success']) {
      // Decodificar Base64 a bytes
      final bytes = base64Decode(jsonData['data']['file_content']);

      // Guardar archivo temporalmente
      final dir = await getTemporaryDirectory();
      final file = File('${dir.path}/$title.pdf');
      await file.writeAsBytes(bytes);

      return file;
    }
    throw Exception(jsonData['message']);
  } else if (response.statusCode == 404) {
    throw Exception('Documento no encontrado');
  }
  throw Exception('Error al descargar documento');
}

// Para abrir el PDF
Future<void> openDocument(int documentId, String title) async {
  final file = await downloadDocument(documentId, title);

  // Usar un paquete como open_file o flutter_pdfview
  // await OpenFile.open(file.path);
}
```

**Modelo Sugerido para Flutter:**
```dart
class Convocation {
  final int convocationId;
  final String title;
  final String description;
  final DateTime? startDate;
  final DateTime? endDate;
  final String status;
  final String statusLabel;
  final bool isPermanent;
  final List<ConvocationDocument> documents;
  final int documentsCount;
  final DateTime createdAt;

  Convocation({
    required this.convocationId,
    required this.title,
    required this.description,
    this.startDate,
    this.endDate,
    required this.status,
    required this.statusLabel,
    required this.isPermanent,
    required this.documents,
    required this.documentsCount,
    required this.createdAt,
  });

  factory Convocation.fromJson(Map<String, dynamic> json) {
    return Convocation(
      convocationId: json['convocation_id'],
      title: json['title'],
      description: json['description'],
      startDate: json['start_date'] != null
          ? DateTime.parse(json['start_date'])
          : null,
      endDate: json['end_date'] != null
          ? DateTime.parse(json['end_date'])
          : null,
      status: json['status'],
      statusLabel: json['status_label'],
      isPermanent: json['is_permanent'],
      documents: (json['documents'] as List)
          .map((doc) => ConvocationDocument.fromJson(doc))
          .toList(),
      documentsCount: json['documents_count'],
      createdAt: DateTime.parse(json['created_at']),
    );
  }
}

class ConvocationDocument {
  final int documentId;
  final String title;
  final String downloadUrl;

  ConvocationDocument({
    required this.documentId,
    required this.title,
    required this.downloadUrl,
  });

  factory ConvocationDocument.fromJson(Map<String, dynamic> json) {
    return ConvocationDocument(
      documentId: json['document_id'],
      title: json['title'],
      downloadUrl: json['download_url'],
    );
  }
}
```

---

## Notas Importantes

### 🔐 Autenticación y Autorización

1. **Todos los endpoints (excepto login y registro) requieren:**
   - Header: `Authorization: Bearer {token}`
   - Rol: `worker` (verificado por middleware)

2. **Si un admin o secretary intenta usar la API:**
   - Recibirán error 403 Forbidden
   - Deben usar la aplicación WEB (Livewire)

### 🏗️ Arquitectura

3. **API REST (esta documentación):**
   - ✅ Solo para Workers
   - ✅ Aplicación móvil Flutter
   - ❌ NO para Admin ni Secretary

4. **Aplicación WEB (Livewire):**
   - ✅ Admin, Secretary y Worker
   - ✅ Navegador web
   - ❌ NO consume esta API REST

### ⚙️ Configuración

5. **Tokens de Sanctum:**
   - No expiran por defecto (configurado en `sanctum.php`)
   - Se pueden revocar con el endpoint `/logout`

6. **CORS:**
   - Configurado para aceptar todas las origins en desarrollo
   - Ajustar para producción en `config/cors.php`

### 🐛 Debugging

7. **Ver logs del servidor:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

8. **Errores comunes:**
   - **401 Unauthorized**: Token inválido o expirado
   - **403 Forbidden**: Usuario no es worker
   - **422 Validation Error**: Datos inválidos
   - **404 Not Found**: Recurso no existe

---

Para más información o reportar problemas, contacta al equipo de desarrollo.
