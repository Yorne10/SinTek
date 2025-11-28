# Guía de Limpieza de Migraciones

## Estado Actual

Tu proyecto tiene **23 migraciones fragmentadas** que fueron creadas en diferentes momentos del desarrollo. Esto hace difícil:
- Mantener la base de datos
- Entender la estructura completa
- Hacer cambios futuros
- Configurar nuevos ambientes

## Solución: Migraciones Consolidadas

Se han creado **5 migraciones limpias y consolidadas** que incluyen TODA la funcionalidad actual:

### Nuevas Migraciones (en `database/migrations_clean/`)

1. **2024_01_01_000001_create_users_and_workers_tables.php**
   - ✅ users
   - ✅ password_resets
   - ✅ workers
   - ✅ positions
   - ✅ positions_workers (pivot)

2. **2024_01_01_000002_create_processes_and_steps_tables.php**
   - ✅ processes
   - ✅ steps
   - ✅ requests
   - ✅ request_steps
   - ✅ documents

3. **2024_01_01_000003_create_convocations_and_documents_tables.php**
   - ✅ convocations
   - ✅ convocation_documents (BLOB storage)
   - ✅ institutional_documents (BLOB storage)

4. **2024_01_01_000004_create_notifications_and_faqs_tables.php**
   - ✅ notifications
   - ✅ faq_categories
   - ✅ faqs

5. **2024_01_01_000005_create_system_tables.php**
   - ✅ failed_jobs
   - ✅ personal_access_tokens (Sanctum)
   - ✅ logs

## Proceso de Migración

### ⚠️ IMPORTANTE: HAZ BACKUP PRIMERO

```bash
# 1. Hacer backup de la base de datos
mysqldump -u root -p sintek > backup_sintek_$(date +%Y%m%d).sql
```

### Opción A: Base de Datos Nueva (Recomendado para desarrollo)

```bash
# 1. Resetear base de datos
php artisan migrate:fresh

# 2. Mover migraciones nuevas
mv database/migrations database/migrations_old
mv database/migrations_clean database/migrations

# 3. Ejecutar migraciones limpias
php artisan migrate

# 4. Ejecutar seeders si los tienes
php artisan db:seed
```

### Opción B: Mantener Datos Existentes

Si ya tienes datos en producción que no quieres perder:

```bash
# 1. Hacer backup
mysqldump -u root -p sintek > backup_sintek_$(date +%Y%m%d).sql

# 2. Marcar todas las migraciones antiguas como ejecutadas (no las volverá a correr)
# No hacer nada, dejar las migraciones antiguas como están

# 3. Solo si necesitas agregar nuevas tablas en el futuro, usar las migraciones limpias como referencia
```

## Migraciones Antiguas a Eliminar

Estas son las migraciones que quedarán obsoletas con las nuevas consolidadas:

### ❌ A eliminar (23 archivos):
1. 2014_10_12_000000_create_users_table.php → Consolidado en 000001
2. 2014_10_12_100000_create_password_resets_table.php → Consolidado en 000001
3. 2019_08_19_000000_create_failed_jobs_table.php → Consolidado en 000005
4. 2019_12_14_000001_create_personal_access_tokens_table.php → Consolidado en 000005
5. 2025_11_02_000200_create_workers_table.php → Consolidado en 000001
6. 2025_11_02_000300_create_positions_table.php → Consolidado en 000001
7. 2025_11_21_002755_create_processes_table.php → Consolidado en 000002
8. 2025_11_21_002758_create_steps_table.php → Consolidado en 000002
9. 2025_11_21_002802_create_requests_table.php → Consolidado en 000002
10. 2025_11_21_002806_create_request_steps_table.php → Consolidado en 000002
11. 2025_11_21_002809_create_documents_table.php → Consolidado en 000002
12. 2025_11_21_002810_create_convocations_table.php → Consolidado en 000003
13. 2025_11_21_002812_create_notifications_table.php → Consolidado en 000004
14. 2025_11_21_002818_create_faqs_table.php → Consolidado en 000004
15. 2025_11_21_002823_create_logs_table.php → Consolidado en 000005
16. 2025_11_21_002828_create_positions_workers_table.php → Consolidado en 000001
17. 2025_11_22_231704_create_convocation_documents_table.php → Consolidado en 000003
18. 2025_11_22_232716_modify_convocation_documents_table_add_blob.php → Consolidado en 000003
19. 2025_11_23_000001_add_fields_to_processes_table.php → Consolidado en 000002
20. 2025_11_23_023217_add_additional_fields_to_steps_table.php → Consolidado en 000002
21. 2025_11_24_060827_create_institutional_documents_table.php → Consolidado en 000003
22. 2025_11_24_175400_create_faq_categories_table.php → Consolidado en 000004
23. 2025_11_24_175726_modify_faqs_table_for_categories.php → Consolidado en 000004

## Ventajas de las Migraciones Consolidadas

✅ **Organización**: Tablas relacionadas juntas
✅ **Mantenimiento**: Fácil ver toda la estructura
✅ **Documentación**: Headers completos con descripción
✅ **Configuración**: Setup rápido en nuevos ambientes
✅ **Limpieza**: Solo 5 archivos vs 23
✅ **Orden lógico**: Secuencia clara de dependencias

## Estructura Completa de la Base de Datos

### Módulo de Usuarios y Trabajadores
- `users` - Usuarios del sistema (admin, secretary, worker)
- `workers` - Información adicional de trabajadores
- `positions` - Puestos laborales
- `positions_workers` - Relación muchos a muchos

### Módulo de Procesos y Trámites
- `processes` - Tipos de trámites disponibles
- `steps` - Pasos de cada proceso
- `requests` - Solicitudes/trámites de usuarios
- `request_steps` - Seguimiento de pasos por solicitud
- `documents` - Documentos adjuntos a solicitudes

### Módulo de Convocatorias y Documentos
- `convocations` - Convocatorias publicadas
- `convocation_documents` - PDFs de convocatorias (BLOB)
- `institutional_documents` - Reglamentos, manuales, formatos (BLOB)

### Módulo de Comunicación
- `notifications` - Notificaciones a usuarios
- `faq_categories` - Categorías de preguntas frecuentes
- `faqs` - Preguntas y respuestas

### Módulo de Sistema
- `failed_jobs` - Jobs fallidos de Laravel
- `personal_access_tokens` - Tokens de API (Sanctum)
- `logs` - Bitácora del sistema
- `password_resets` - Tokens para resetear contraseñas

## Recomendación Final

Para **DESARROLLO**:
- Usa las migraciones consolidadas (Opción A)
- Reinicia la base de datos
- Vuelve a crear datos de prueba con seeders

Para **PRODUCCIÓN** (si ya tienes datos):
- Mantén las migraciones actuales funcionando
- Usa las nuevas como referencia para futuros cambios
- No borres las antiguas si ya están en producción

## Comandos Útiles

```bash
# Ver estado de migraciones
php artisan migrate:status

# Rollback de la última migración
php artisan migrate:rollback

# Rollback de todas las migraciones
php artisan migrate:reset

# Resetear y correr todas las migraciones
php artisan migrate:fresh

# Resetear, migrar y ejecutar seeders
php artisan migrate:fresh --seed
```

## Próximos Pasos

1. ✅ Revisar las nuevas migraciones en `database/migrations_clean/`
2. ✅ Verificar que incluyen toda la funcionalidad
3. ⚠️ Hacer backup de tu base de datos actual
4. 🔄 Elegir Opción A o B según tu caso
5. ✅ Ejecutar las migraciones
6. ✅ Probar que todo funciona correctamente
