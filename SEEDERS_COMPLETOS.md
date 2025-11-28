# 🌱 Seeders Completos - Sistema SinTek
**Fecha:** 24/11/2025
**Proyecto:** Sistema de Trámites - CETAM
**Contraseña universal:** `123456Ab`

---

## ✅ EJECUCIÓN COMPLETADA

Los seeders se ejecutaron exitosamente con el comando:
```bash
php artisan migrate:fresh --seed
```

---

## 👥 USUARIOS CREADOS (8 usuarios)

### 🔐 Administradores (2)

#### 1. Administrador del Sistema
- **Email:** `admin@cetam.gob.mx`
- **Password:** `123456Ab`
- **Role:** admin
- **Estado:** Activo ✅

#### 2. Secretaria General
- **Email:** `secretaria@cetam.gob.mx`
- **Password:** `123456Ab`
- **Role:** secretary
- **Estado:** Activo ✅

---

### 👷 Trabajadores (6)

#### 1. Juan Pérez García - Docente Titular
- **Email:** `juan.perez@cetam.gob.mx`
- **Password:** `123456Ab`
- **CURP:** PEGJ850615HDFRNN01
- **RFC:** PEGJ850615AB1
- **Puesto:** Docente Titular
- **Teléfono:** 6141234567
- **Estado:** Activo ✅

#### 2. María González López - Administrativo
- **Email:** `maria.gonzalez@cetam.gob.mx`
- **Password:** `123456Ab`
- **CURP:** GOLM900320MDFLPR02
- **RFC:** GOLM900320CD2
- **Puesto:** Administrativo
- **Teléfono:** 6149876543
- **Estado:** Activo ✅

#### 3. Carlos Ramírez Sánchez - Jefe de Mantenimiento
- **Email:** `carlos.ramirez@cetam.gob.mx`
- **Password:** `123456Ab`
- **CURP:** RASC880710HDFMRR03
- **RFC:** RASC880710EF3
- **Puesto:** Jefe de Mantenimiento
- **Teléfono:** 6145551234
- **Estado:** Activo ✅

#### 4. Ana Martínez Hernández - Docente Asociado
- **Email:** `ana.martinez@cetam.gob.mx`
- **Password:** `123456Ab`
- **CURP:** MAHA920815MDFRNN04
- **RFC:** MAHA920815GH4
- **Puesto:** Docente Asociado
- **Teléfono:** 6143334455
- **Estado:** Activo ✅

#### 5. Roberto López Mendoza - Coordinador Académico
- **Email:** `roberto.lopez@cetam.gob.mx`
- **Password:** `123456Ab`
- **CURP:** LOMR870925HDFPNB05
- **RFC:** LOMR870925IJ5
- **Puesto:** Coordinador Académico
- **Teléfono:** 6147778899
- **Estado:** Activo ✅

#### 6. Pedro Inactive Test - Técnico Auxiliar
- **Email:** `pedro.test@cetam.gob.mx`
- **Password:** `123456Ab`
- **CURP:** TESP950101HDFSTS06
- **RFC:** TESP950101KL6
- **Puesto:** Técnico Auxiliar
- **Teléfono:** 6140000000
- **Estado:** ❌ INACTIVO (para testing)

---

## 💼 PUESTOS CREADOS (6)

1. **Docente Titular** - DOC-TIT-001
2. **Docente Asociado** - DOC-ASO-002
3. **Coordinador Académico** - COORD-ACA-003
4. **Administrativo** - ADM-GEN-004
5. **Jefe de Mantenimiento** - MANT-JEF-005
6. **Técnico Auxiliar** - TEC-AUX-006

---

## 📋 PROCESOS Y TRÁMITES CREADOS (4 procesos, 13 pasos)

### 1. Solicitud de Constancia Laboral
- **Código:** CONST-LAB-001
- **Categoría:** Documentación
- **Prioridad:** Media
- **Días límite:** 5 días
- **Departamento:** Recursos Humanos
- **Pasos:** 3
  1. Llenar solicitud
  2. Revisión de documentos
  3. Emisión de constancia

### 2. Solicitud de Vacaciones
- **Código:** VAC-001
- **Categoría:** Recursos Humanos
- **Prioridad:** Alta
- **Días límite:** 10 días
- **Departamento:** Recursos Humanos
- **Pasos:** 3
  1. Solicitar vacaciones
  2. Aprobación del coordinador
  3. Autorización final

### 3. Reporte de Mantenimiento
- **Código:** MANT-REP-001
- **Categoría:** Mantenimiento
- **Prioridad:** Media
- **Días límite:** 7 días
- **Departamento:** Mantenimiento
- **Pasos:** 3
  1. Crear reporte
  2. Evaluación técnica
  3. Ejecución de mantenimiento

### 4. Solicitud de Cambio de Horario (FLUJO CONDICIONAL)
- **Código:** HORARIO-001
- **Categoría:** Recursos Humanos
- **Prioridad:** Baja
- **Días límite:** 15 días
- **Departamento:** Recursos Humanos
- **Pasos:** 4 (con condicional)
  1. Solicitud de cambio
  2. ¿Es por motivos médicos? (CONDICIONAL)
     - **SI →** Paso 3: Aprobación inmediata
     - **NO →** Paso 4: Evaluación del coordinador

---

## 📢 CONVOCATORIAS CREADAS (5)

### 1. Convocatoria de Plaza Docente 2025-1
- **Estado:** ✅ ACTIVA
- **Inicio:** Hace 5 días
- **Fin:** En 25 días
- **Descripción:** Proceso de selección para plaza docente en Ingeniería Industrial

### 2. Convocatoria Personal Administrativo
- **Estado:** 🔜 PRÓXIMA
- **Inicio:** En 10 días
- **Fin:** En 40 días
- **Descripción:** Próxima convocatoria para personal administrativo

### 3. Programa de Becas CETAM
- **Estado:** ♾️ PERMANENTE
- **Inicio:** Inicio del año
- **Fin:** Sin fecha de cierre
- **Descripción:** Programa de becas institucionales (convocatoria permanente)

### 4. Convocatoria Plaza Mantenimiento 2024
- **Estado:** ❌ CERRADA
- **Inicio:** Hace 3 meses
- **Fin:** Hace 2 meses
- **Descripción:** Plaza de jefe de mantenimiento (proceso cerrado)

### 5. Curso de Capacitación Docente
- **Estado:** ✅ ACTIVA
- **Inicio:** Hace 2 días
- **Fin:** En 15 días
- **Descripción:** Curso de actualización pedagógica

---

## ❓ FAQs CREADAS (4 categorías, 13 preguntas)

### Categoría 1: Trámites generales (4 FAQs)
1. ¿Cómo inicio un nuevo trámite?
2. ¿Cuánto tiempo tarda mi trámite?
3. ¿Puedo cancelar un trámite en proceso?
4. ¿Cómo sé en qué paso está mi trámite?

### Categoría 2: Mi cuenta (3 FAQs)
1. ¿Cómo actualizo mi información de perfil?
2. ¿Cómo cambio mi contraseña?
3. ¿Puedo cambiar mi foto de perfil?

### Categoría 3: Convocatorias (3 FAQs)
1. ¿Dónde veo las convocatorias disponibles?
2. ¿Qué significa el estado "Próxima" en una convocatoria?
3. ¿Cómo descargo los documentos de una convocatoria?

### Categoría 4: Documentación (3 FAQs)
1. ¿Cómo solicito una constancia laboral?
2. ¿Qué documentos necesito subir para mi trámite?
3. ¿Puedo descargar mis documentos después de subirlos?

---

## 📊 RESUMEN DE DATOS

| Tabla | Registros Creados |
|-------|------------------|
| Users | 8 |
| Workers | 6 |
| Positions | 6 |
| Positions-Workers (relación) | 6 |
| Processes | 4 |
| Steps | 13 |
| Convocations | 5 |
| FAQ Categories | 4 |
| FAQs | 13 |
| **TOTAL** | **65 registros** |

---

## 🧪 TESTING DE FUNCIONALIDADES

### Para testing de login:

#### Admin:
```json
{
  "email": "admin@cetam.gob.mx",
  "password": "123456Ab"
}
```

#### Workers activos (cualquiera de estos):
```json
{
  "email": "juan.perez@cetam.gob.mx",
  "password": "123456Ab"
}
```
```json
{
  "email": "maria.gonzalez@cetam.gob.mx",
  "password": "123456Ab"
}
```
```json
{
  "email": "carlos.ramirez@cetam.gob.mx",
  "password": "123456Ab"
}
```
```json
{
  "email": "ana.martinez@cetam.gob.mx",
  "password": "123456Ab"
}
```
```json
{
  "email": "roberto.lopez@cetam.gob.mx",
  "password": "123456Ab"
}
```

#### Worker INACTIVO (para testing de restricciones):
```json
{
  "email": "pedro.test@cetam.gob.mx",
  "password": "123456Ab"
}
```
**Nota:** Este usuario debe retornar error "Cuenta inactiva"

---

## 🚀 PRÓXIMOS PASOS

### Testing recomendado:

1. **Login:**
   - ✅ Login exitoso con admin
   - ✅ Login exitoso con workers activos
   - ✅ Login fallido con worker inactivo

2. **Perfil:**
   - ✅ Ver perfil de usuario
   - ✅ Actualizar datos de perfil
   - ✅ Cambiar contraseña
   - ✅ Subir foto de perfil

3. **Procesos:**
   - ✅ Ver lista de procesos disponibles
   - ✅ Ver detalles de un proceso
   - ✅ Iniciar un nuevo trámite
   - ✅ Ver mis trámites

4. **Convocatorias:**
   - ✅ Ver convocatorias activas
   - ✅ Ver detalles de convocatoria
   - ✅ Filtrar por estado

5. **FAQs:**
   - ✅ Ver categorías
   - ✅ Ver FAQs por categoría
   - ✅ Buscar FAQs

---

## 📝 NOTAS IMPORTANTES

1. **Contraseña universal:** Todos los usuarios tienen la misma contraseña `123456Ab` para facilitar el testing.

2. **Usuario inactivo:** `pedro.test@cetam.gob.mx` está marcado como inactivo para testing de restricciones de acceso.

3. **CURPs y RFCs:** Son valores de ejemplo que cumplen con el formato mexicano pero no son reales.

4. **Flujo condicional:** El proceso "Cambio de Horario" incluye un paso condicional (Sí/No) para demostrar flujos no lineales.

5. **Convocatorias:** Tienen diferentes estados (activa, próxima, permanente, cerrada) para testing de filtros.

6. **Relaciones:** Los workers están correctamente relacionados con sus puestos mediante la tabla pivot `positions_workers`.

---

## ✅ VERIFICACIÓN

Para verificar que todo se creó correctamente:

```bash
# Ver usuarios
php artisan tinker
>>> User::count()
=> 8

# Ver workers
>>> Worker::count()
=> 6

# Ver procesos
>>> Process::count()
=> 4

# Ver steps
>>> Step::count()
=> 13

# Ver convocatorias
>>> Convocation::count()
=> 5

# Ver FAQs
>>> Faq::count()
=> 13
```

---

**Creado por:** Claude Code
**Fecha:** 24/11/2025
**Versión:** 1.0.0
