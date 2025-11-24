# Documentación de API - Sistema de FAQs

## Información General

Todas las rutas de API requieren autenticación mediante Sanctum Token (Bearer Token).

Base URL: `http://your-domain.com/api`

---

## Endpoints Disponibles

### 1. Obtener Categorías de FAQs

**Endpoint:** `GET /faq-categories`

**Descripción:** Obtiene todas las categorías activas con el conteo de FAQs en cada una.

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta Exitosa (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Trámites generales",
      "description": "Preguntas sobre trámites y procesos",
      "order": 0,
      "faqs_count": 5
    },
    {
      "id": 2,
      "name": "Mi cuenta",
      "description": "Gestión de cuenta y perfil",
      "order": 1,
      "faqs_count": 3
    }
  ],
  "message": "Categorías obtenidas exitosamente."
}
```

---

### 2. Obtener Todas las FAQs (Agrupadas por Categoría)

**Endpoint:** `GET /faqs`

**Descripción:** Obtiene todas las FAQs activas agrupadas por categoría.

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta Exitosa (200):**
```json
{
  "success": true,
  "data": [
    {
      "category_id": 1,
      "category_name": "Trámites generales",
      "category_description": "Preguntas sobre trámites y procesos",
      "category_order": 0,
      "faqs": [
        {
          "id": 1,
          "question": "¿Cómo inicio un nuevo trámite?",
          "answer": "Para iniciar un nuevo trámite, ve a la sección de trámites disponibles...",
          "order": 0
        },
        {
          "id": 2,
          "question": "¿Cuánto tiempo tarda mi trámite?",
          "answer": "El tiempo de procesamiento varía según el tipo de trámite...",
          "order": 1
        }
      ]
    },
    {
      "category_id": 2,
      "category_name": "Mi cuenta",
      "category_description": "Gestión de cuenta y perfil",
      "category_order": 1,
      "faqs": [
        {
          "id": 3,
          "question": "¿Cómo cambio mi contraseña?",
          "answer": "Puedes cambiar tu contraseña desde la sección Mi Perfil...",
          "order": 0
        }
      ]
    }
  ],
  "message": "FAQs obtenidas exitosamente."
}
```

---

### 3. Obtener FAQs por Categoría

**Endpoint:** `GET /faqs/category/{categoryId}`

**Descripción:** Obtiene todas las FAQs activas de una categoría específica.

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Parámetros de Ruta:**
- `categoryId` (integer, requerido): ID de la categoría

**Ejemplo:** `GET /faqs/category/1`

**Respuesta Exitosa (200):**
```json
{
  "success": true,
  "data": {
    "category": {
      "id": 1,
      "name": "Trámites generales",
      "description": "Preguntas sobre trámites y procesos",
      "order": 0
    },
    "faqs": [
      {
        "id": 1,
        "question": "¿Cómo inicio un nuevo trámite?",
        "answer": "Para iniciar un nuevo trámite, ve a la sección de trámites disponibles y selecciona el tipo de trámite que necesites. Luego completa el formulario con los datos requeridos.",
        "order": 0
      },
      {
        "id": 2,
        "question": "¿Cuánto tiempo tarda mi trámite?",
        "answer": "El tiempo de procesamiento varía según el tipo de trámite. Generalmente los trámites urgentes tardan de 2 a 5 días hábiles, mientras que los trámites regulares pueden tardar de 5 a 15 días hábiles.",
        "order": 1
      }
    ]
  },
  "message": "FAQs de la categoría obtenidas exitosamente."
}
```

**Respuesta de Error (404):**
```json
{
  "success": false,
  "message": "Error al obtener las FAQs de la categoría.",
  "error": "No query results for model..."
}
```

---

### 4. Buscar FAQs

**Endpoint:** `GET /faqs/search`

**Descripción:** Busca FAQs por palabra clave en preguntas y respuestas.

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Parámetros de Query:**
- `keyword` (string, requerido): Palabra o frase a buscar

**Ejemplo:** `GET /faqs/search?keyword=contraseña`

**Respuesta Exitosa (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 3,
      "category": {
        "id": 2,
        "name": "Mi cuenta"
      },
      "question": "¿Cómo cambio mi contraseña?",
      "answer": "Puedes cambiar tu contraseña desde la sección Mi Perfil. Haz clic en Seguridad y luego en Cambiar contraseña.",
      "order": 0
    },
    {
      "id": 8,
      "category": {
        "id": 2,
        "name": "Mi cuenta"
      },
      "question": "¿Qué hago si olvidé mi contraseña?",
      "answer": "En la página de login, haz clic en '¿Olvidaste tu contraseña?' y sigue las instrucciones para restablecerla.",
      "order": 2
    }
  ],
  "count": 2,
  "message": "Búsqueda completada exitosamente."
}
```

**Respuesta de Error (400):**
```json
{
  "success": false,
  "message": "El parámetro \"keyword\" es requerido."
}
```

---

### 5. Obtener FAQ por ID

**Endpoint:** `GET /faqs/{faqId}`

**Descripción:** Obtiene los detalles completos de una FAQ específica.

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Parámetros de Ruta:**
- `faqId` (integer, requerido): ID de la FAQ

**Ejemplo:** `GET /faqs/1`

**Respuesta Exitosa (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "category": {
      "id": 1,
      "name": "Trámites generales"
    },
    "question": "¿Cómo inicio un nuevo trámite?",
    "answer": "Para iniciar un nuevo trámite, ve a la sección de trámites disponibles y selecciona el tipo de trámite que necesites. Luego completa el formulario con los datos requeridos y adjunta los documentos solicitados. Al finalizar, recibirás un número de folio para dar seguimiento.",
    "order": 0
  },
  "message": "FAQ obtenida exitosamente."
}
```

**Respuesta de Error (404):**
```json
{
  "success": false,
  "message": "FAQ no encontrada.",
  "error": "No query results for model..."
}
```

---

## Códigos de Estado HTTP

- `200 OK`: Solicitud exitosa
- `400 Bad Request`: Parámetros faltantes o inválidos
- `404 Not Found`: Recurso no encontrado
- `500 Internal Server Error`: Error del servidor

---

## Notas Importantes

1. **Autenticación**: Todas las rutas requieren un token de autenticación válido (Sanctum).
2. **FAQs Activas**: Solo se devuelven FAQs y categorías con `is_active = true`.
3. **Orden**: Las FAQs se devuelven ordenadas por el campo `order` (ascendente).
4. **Formato de Respuesta**: Todas las respuestas están en formato JSON.
5. **Búsqueda**: La búsqueda es case-insensitive y busca coincidencias parciales.

---

## Ejemplo de Uso en Flutter (Dart)

```dart
import 'package:http/http.dart' as http;
import 'dart:convert';

class FaqService {
  final String baseUrl = 'http://your-domain.com/api';
  final String token;

  FaqService(this.token);

  Future<List<Category>> getCategories() async {
    final response = await http.get(
      Uri.parse('$baseUrl/faq-categories'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      if (data['success']) {
        return (data['data'] as List)
            .map((cat) => Category.fromJson(cat))
            .toList();
      }
    }
    throw Exception('Error al obtener categorías');
  }

  Future<List<Faq>> getAllFaqs() async {
    final response = await http.get(
      Uri.parse('$baseUrl/faqs'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      if (data['success']) {
        List<Faq> allFaqs = [];
        for (var category in data['data']) {
          for (var faq in category['faqs']) {
            allFaqs.add(Faq.fromJson(faq));
          }
        }
        return allFaqs;
      }
    }
    throw Exception('Error al obtener FAQs');
  }

  Future<List<Faq>> searchFaqs(String keyword) async {
    final response = await http.get(
      Uri.parse('$baseUrl/faqs/search?keyword=$keyword'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      if (data['success']) {
        return (data['data'] as List)
            .map((faq) => Faq.fromJson(faq))
            .toList();
      }
    }
    throw Exception('Error al buscar FAQs');
  }
}

// Modelos de datos
class Category {
  final int id;
  final String name;
  final String? description;
  final int order;
  final int faqsCount;

  Category({
    required this.id,
    required this.name,
    this.description,
    required this.order,
    required this.faqsCount,
  });

  factory Category.fromJson(Map<String, dynamic> json) {
    return Category(
      id: json['id'],
      name: json['name'],
      description: json['description'],
      order: json['order'],
      faqsCount: json['faqs_count'],
    );
  }
}

class Faq {
  final int id;
  final String question;
  final String answer;
  final int order;

  Faq({
    required this.id,
    required this.question,
    required this.answer,
    required this.order,
  });

  factory Faq.fromJson(Map<String, dynamic> json) {
    return Faq(
      id: json['id'],
      question: json['question'],
      answer: json['answer'],
      order: json['order'],
    );
  }
}
```

---

## Gestión de FAQs (Solo Secretarios)

Para gestionar FAQs (crear, editar, eliminar), los secretarios deben acceder a la interfaz web en:

**URL:** `http://your-domain.com/p/sintek/gestion-faqs`

**Características:**
- Crear y editar categorías de FAQs
- Crear, editar, activar/desactivar FAQs
- Organizar FAQs por orden
- Eliminar categorías y FAQs
- Ver conteo de FAQs por categoría

---

## Soporte

Para soporte técnico o reportar problemas, contacta a:
- Email: soporte@cetam.gob.mx
- Teléfono: 55-1234-5678 ext. 100
