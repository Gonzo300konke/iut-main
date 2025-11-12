# SPRINT BACKLOGS
## Sistema de Gestión de Inventario de Bienes

**Proyecto:** Sistema de Gestión de Inventario de Bienes  
**Equipo de Desarrollo:** 4 desarrolladores  
**Duración del Sprint:** 2 semanas  
**Velocidad Promedio:** 28-35 puntos por sprint

---

## SPRINT 1: Fundamentos y Estructura Base
**Objetivo:** Establecer autenticación, roles y estructura organizacional básica  
**Duración:** 4 Nov 2025 - 17 Nov 2025  
**Story Points:** 28 puntos

### Historias de Usuario

#### HU-001: Registro de Usuarios Administradores (5 pts)
**Tareas:**
- [ ] Crear migración para tabla usuarios con todos los campos requeridos
- [ ] Crear modelo Usuario con validaciones
- [ ] Crear formulario de registro con validación frontend
- [ ] Implementar controlador de registro con validación backend
- [ ] Crear vista de listado de usuarios
- [ ] Implementar seeders con usuarios de prueba
- [ ] Testing unitario de validaciones

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Usuario puede crear nuevos usuarios con roles y visualizar listado

---

#### HU-002: Iniciar Sesión en el Sistema (5 pts)
**Tareas:**
- [ ] Configurar sistema de autenticación de Laravel
- [ ] Crear formulario de login con validación
- [ ] Implementar lógica de autenticación con remember_token
- [ ] Crear middleware para proteger rutas
- [ ] Implementar redirección según rol del usuario
- [ ] Crear dashboards básicos por rol
- [ ] Testing de autenticación

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Usuario puede iniciar sesión y acceder a dashboard según su rol

---

#### HU-003: Cerrar Sesión (3 pts)
**Tareas:**
- [ ] Implementar endpoint de logout
- [ ] Agregar botón de cerrar sesión en navbar
- [ ] Destruir sesión y token al cerrar
- [ ] Redirección a página de login
- [ ] Testing de destrucción de sesión

**Responsable:** Desarrollador Frontend  
**Criterio de Completitud:** Usuario puede cerrar sesión de forma segura

---

#### HU-004: Crear Organismo (5 pts)
**Tareas:**
- [ ] Crear migración para tabla organismos
- [ ] Crear modelo Organismo con validaciones
- [ ] Crear formulario de registro de organismo
- [ ] Implementar CRUD de organismos
- [ ] Crear vista de listado de organismos
- [ ] Validación de código único
- [ ] Testing CRUD

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Administrador puede crear y listar organismos

---

#### HU-005: Crear Unidad Administradora (5 pts)
**Tareas:**
- [ ] Crear migración para tabla unidades_administradoras
- [ ] Crear modelo UnidadAdministradora con relaciones
- [ ] Crear formulario con selector de organismo
- [ ] Implementar CRUD de unidades
- [ ] Crear vista de listado jerárquico
- [ ] Validación de código único por organismo
- [ ] Testing CRUD y relaciones

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Administrador puede crear unidades y vincularlas a organismos

---

#### HU-006: Crear Dependencia (5 pts)
**Tareas:**
- [ ] Crear migración para tabla dependencias
- [ ] Crear modelo Dependencia con relaciones
- [ ] Crear formulario con selector de unidad
- [ ] Implementar CRUD de dependencias
- [ ] Crear vista de jerarquía completa
- [ ] Validación de código único por unidad
- [ ] Testing CRUD y relaciones jerárquicas

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Administrador puede crear dependencias y visualizar jerarquía completa

---

### Definition of Done (DoD)
- [ ] Código revisado por al menos un compañero (Code Review)
- [ ] Tests unitarios implementados y pasando
- [ ] Documentación técnica actualizada
- [ ] Sin errores críticos ni warnings
- [ ] Funcionalidad probada en entorno de desarrollo
- [ ] Migrations ejecutadas correctamente

---

## SPRINT 2: Gestión de Inventario Base
**Objetivo:** Implementar funcionalidades core de gestión de bienes  
**Duración:** 18 Nov 2025 - 1 Dic 2025  
**Story Points:** 28 puntos

### Historias de Usuario

#### HU-007: Registrar Bien en Inventario (8 pts)
**Tareas:**
- [ ] Crear migración para tabla bienes con todos los campos
- [ ] Crear modelo Bien con relaciones y validaciones
- [ ] Implementar subida de imágenes (storage)
- [ ] Crear formulario de registro con selectores dinámicos
- [ ] Implementar validación de código único
- [ ] Crear endpoint de registro de bien
- [ ] Implementar galería de fotos
- [ ] Testing de registro y validaciones

**Responsable:** Desarrollador Full Stack  
**Criterio de Completitud:** Gerente puede registrar bienes con fotos

---

#### HU-008: Listar Bienes por Dependencia (5 pts)
**Tareas:**
- [ ] Crear vista de tabla de bienes con datatables
- [ ] Implementar filtro por dependencia
- [ ] Implementar paginación
- [ ] Implementar búsqueda por código/descripción
- [ ] Implementar ordenamiento por columnas
- [ ] Crear funcionalidad de exportar a PDF
- [ ] Testing de filtros y búsqueda

**Responsable:** Desarrollador Frontend  
**Criterio de Completitud:** Usuario puede filtrar y buscar bienes por dependencia

---

#### HU-009: Ver Detalle de un Bien (5 pts)
**Tareas:**
- [ ] Crear vista de detalle de bien
- [ ] Implementar galería de fotos con lightbox
- [ ] Mostrar información de responsable
- [ ] Mostrar jerarquía organizacional
- [ ] Mostrar historial resumido de movimientos
- [ ] Implementar botones de acción según rol
- [ ] Testing de permisos por rol

**Responsable:** Desarrollador Frontend  
**Criterio de Completitud:** Usuario puede ver toda la información del bien

---

#### HU-010: Editar Información de un Bien (5 pts)
**Tareas:**
- [ ] Crear formulario de edición prellenado
- [ ] Implementar actualización de datos
- [ ] Implementar gestión de fotos (agregar/eliminar)
- [ ] Bloquear edición de código
- [ ] Implementar confirmación antes de guardar
- [ ] Registrar fecha de última actualización
- [ ] Testing de actualización

**Responsable:** Desarrollador Full Stack  
**Criterio de Completitud:** Gerente puede actualizar información de bienes

---

#### Tareas Técnicas del Sprint
- [ ] Configurar storage para imágenes de bienes
- [ ] Implementar librería para generación de PDFs
- [ ] Crear componentes reutilizables de formularios
- [ ] Optimizar consultas con eager loading

---

### Definition of Done (DoD)
- [ ] Código revisado por al menos un compañero
- [ ] Tests unitarios y de integración pasando
- [ ] Responsive design verificado
- [ ] Optimización de imágenes implementada
- [ ] Documentación de API actualizada
- [ ] Sin errores en consola del navegador

---

## SPRINT 3: Movimientos y Reportes
**Objetivo:** Implementar trazabilidad de bienes y sistema de reportes  
**Duración:** 2 Dic 2025 - 15 Dic 2025  
**Story Points:** 34 puntos

### Historias de Usuario

#### HU-011: Registrar Movimiento de Bien (8 pts)
**Tareas:**
- [ ] Crear migración para tabla movimientos
- [ ] Crear modelo Movimiento con relaciones
- [ ] Crear formulario de registro de movimiento
- [ ] Implementar validación de dependencia origen
- [ ] Implementar actualización automática de dependencia del bien
- [ ] Crear registro en historial de movimientos
- [ ] Implementar subida de documento de autorización
- [ ] Testing de lógica de movimientos

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Gerente puede registrar traslados entre dependencias

---

#### HU-012: Cambiar Responsable de un Bien (5 pts)
**Tareas:**
- [ ] Crear formulario de cambio de responsable
- [ ] Implementar selector de nuevo responsable
- [ ] Validar motivo obligatorio
- [ ] Actualizar responsable del bien
- [ ] Registrar en historial de movimientos
- [ ] Implementar notificación (opcional)
- [ ] Testing de cambio de responsabilidad

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Gerente puede reasignar responsabilidad de bienes

---

#### HU-013: Ver Historial de Movimientos de un Bien (5 pts)
**Tareas:**
- [ ] Crear vista de historial cronológico
- [ ] Implementar listado de movimientos con detalles
- [ ] Implementar filtros por fecha
- [ ] Crear funcionalidad de exportar a PDF
- [ ] Mostrar documentos adjuntos si existen
- [ ] Testing de consultas de historial

**Responsable:** Desarrollador Frontend  
**Criterio de Completitud:** Usuario puede consultar historial completo de movimientos

---

#### HU-014: Generar Reporte de Inventario por Dependencia (8 pts)
**Tareas:**
- [ ] Crear migración para tabla reportes
- [ ] Diseñar template de reporte PDF oficial
- [ ] Implementar generación de reporte con encabezado institucional
- [ ] Implementar opción de incluir fotos
- [ ] Calcular valor total de inventario
- [ ] Incluir logo institucional
- [ ] Implementar numeración y firma digital
- [ ] Testing de generación de PDF

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Gerente puede generar reportes oficiales en PDF

---

#### HU-015: Buscar Bienes Globalmente (8 pts)
**Tareas:**
- [ ] Crear formulario de búsqueda avanzada
- [ ] Implementar búsqueda por múltiples criterios
- [ ] Implementar filtros combinables
- [ ] Crear vista de resultados con paginación
- [ ] Implementar funcionalidad de guardar búsquedas
- [ ] Implementar exportación a Excel
- [ ] Optimizar consultas de búsqueda
- [ ] Testing de búsqueda avanzada

**Responsable:** Desarrollador Full Stack  
**Criterio de Completitud:** Usuario puede buscar bienes usando múltiples criterios

---

### Definition of Done (DoD)
- [ ] Código revisado y aprobado
- [ ] Tests de integración pasando
- [ ] Reportes PDF con formato profesional
- [ ] Optimización de consultas complejas
- [ ] Documentación de endpoints
- [ ] Pruebas de carga de búsquedas

---

## SPRINT 4: Auditoría y Responsables
**Objetivo:** Implementar sistema de auditoría y gestión de responsables  
**Duración:** 16 Dic 2025 - 29 Dic 2025  
**Story Points:** 31 puntos

### Historias de Usuario

#### HU-016: Dashboard de Administrador (8 pts)
**Tareas:**
- [ ] Diseñar layout de dashboard
- [ ] Implementar cálculo de métricas
- [ ] Crear gráficos de distribución (Chart.js)
- [ ] Implementar widget de últimas actividades
- [ ] Implementar filtros de fecha para métricas
- [ ] Optimizar consultas de dashboard
- [ ] Testing de cálculos

**Responsable:** Desarrollador Full Stack  
**Criterio de Completitud:** Administrador ve métricas clave del sistema

---

#### HU-017: Gestionar Tipos de Responsables (5 pts)
**Tareas:**
- [ ] Crear migración para tabla tipos_responsables
- [ ] Crear modelo TipoResponsable
- [ ] Implementar CRUD de tipos
- [ ] Crear seeder con tipos por defecto
- [ ] Implementar validación de eliminación
- [ ] Testing CRUD

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Administrador puede gestionar tipos de responsables

---

#### HU-018: Registrar Responsable (5 pts)
**Tareas:**
- [ ] Crear migración para tabla responsables
- [ ] Crear modelo Responsable con relaciones
- [ ] Crear formulario de registro
- [ ] Implementar CRUD de responsables
- [ ] Vincular con usuarios (opcional)
- [ ] Implementar estado activo/inactivo
- [ ] Testing CRUD

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Administrador puede registrar responsables completos

---

#### HU-019: Registro de Auditoría del Sistema (8 pts)
**Tareas:**
- [ ] Crear migración para tabla auditoria
- [ ] Crear modelo Auditoria
- [ ] Implementar observers para modelos críticos
- [ ] Registrar automáticamente acciones CRUD
- [ ] Capturar IP y user agent
- [ ] Crear vista de consulta de auditoría
- [ ] Implementar filtros de auditoría
- [ ] Testing de registro automático

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Sistema registra automáticamente todas las acciones críticas

---

#### HU-020: Marcar Bien como Inactivo/Dado de Baja (5 pts)
**Tareas:**
- [ ] Agregar campo estado a tabla bienes
- [ ] Crear enum de estados
- [ ] Crear formulario de cambio de estado
- [ ] Implementar validación de motivo
- [ ] Registrar en historial
- [ ] Implementar subida de documento de autorización
- [ ] Filtrar bienes dados de baja en reportes activos
- [ ] Testing de cambio de estado

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Gerente puede cambiar estado de bienes con justificación

---

### Definition of Done (DoD)
- [ ] Código revisado y aprobado
- [ ] Tests de auditoría pasando
- [ ] Dashboard responsive
- [ ] Optimización de gráficos
- [ ] Documentación de sistema de auditoría
- [ ] Validación de permisos por rol

---

## SPRINT 5: Funcionalidades Avanzadas
**Objetivo:** Implementar notificaciones, importación/exportación y códigos QR  
**Duración:** 30 Dic 2025 - 12 Ene 2026  
**Story Points:** 47 puntos

### Historias de Usuario

#### HU-021: Notificaciones por Correo (8 pts)
**Tareas:**
- [ ] Configurar servidor SMTP en Laravel
- [ ] Crear templates de email con Blade
- [ ] Implementar envío al asignar bien
- [ ] Implementar envío al remover responsabilidad
- [ ] Implementar envío al registrar movimiento
- [ ] Agregar opción de desactivar notificaciones en perfil
- [ ] Testing de envío de correos

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Usuarios reciben notificaciones por correo

---

#### HU-022: Importar Bienes desde Excel (13 pts)
**Tareas:**
- [ ] Instalar librería de lectura de Excel
- [ ] Crear template de Excel descargable
- [ ] Crear formulario de carga de archivo
- [ ] Implementar validación de formato
- [ ] Implementar validación fila por fila
- [ ] Crear reporte de errores detallado
- [ ] Implementar importación en lote
- [ ] Crear barra de progreso con AJAX
- [ ] Testing de importación masiva

**Responsable:** Desarrollador Full Stack  
**Criterio de Completitud:** Gerente puede importar hasta 500 bienes desde Excel

---

#### HU-023: Exportar Inventario a Excel (5 pts)
**Tareas:**
- [ ] Instalar librería de escritura de Excel
- [ ] Implementar exportación de bienes
- [ ] Incluir hoja resumen con totales
- [ ] Generar nombre de archivo con fecha
- [ ] Testing de exportación

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Usuario puede exportar inventario a Excel

---

#### HU-024: Generar Código QR para Bienes (8 pts)
**Tareas:**
- [ ] Instalar librería de generación de QR
- [ ] Implementar generación de QR único por bien
- [ ] Crear endpoint de descarga de QR individual
- [ ] Implementar generación masiva de QR
- [ ] Diseñar template de etiquetas imprimibles
- [ ] Testing de generación

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Sistema genera códigos QR para cada bien

---

#### HU-025: Escanear Código QR desde Móvil (8 pts)
**Tareas:**
- [ ] Implementar botón de escanear en versión móvil
- [ ] Integrar librería de escaneo de QR (HTML5-QRCode)
- [ ] Implementar acceso a cámara
- [ ] Implementar redirección a detalle del bien
- [ ] Optimizar para PWA
- [ ] Manejo de errores de escaneo
- [ ] Testing en dispositivos móviles

**Responsable:** Desarrollador Frontend  
**Criterio de Completitud:** Usuario puede escanear QR desde móvil

---

#### HU-026: Perfil de Usuario (5 pts)
**Tareas:**
- [ ] Crear vista de perfil de usuario
- [ ] Implementar edición de datos personales
- [ ] Implementar cambio de contraseña
- [ ] Implementar subida de foto de perfil
- [ ] Mostrar historial de última actividad
- [ ] Testing de actualización de perfil

**Responsable:** Desarrollador Full Stack  
**Criterio de Completitud:** Usuario puede gestionar su perfil

---

### Definition of Done (DoD)
- [ ] Código revisado y aprobado
- [ ] Tests de integración pasando
- [ ] Notificaciones de correo funcionando
- [ ] Importación masiva probada con 500 registros
- [ ] QR escaneables desde múltiples dispositivos
- [ ] Documentación de configuración SMTP

---

## SPRINT 6: Finalización y Mejoras de UX
**Objetivo:** Completar funcionalidades secundarias y mejorar experiencia de usuario  
**Duración:** 13 Ene 2026 - 26 Ene 2026  
**Story Points:** 29 puntos

### Historias de Usuario

#### HU-027: Recuperar Contraseña (8 pts)
**Tareas:**
- [ ] Crear tabla de tokens de recuperación
- [ ] Implementar formulario de solicitud
- [ ] Implementar envío de email con token
- [ ] Crear formulario de reset de contraseña
- [ ] Implementar validación de token (1 hora)
- [ ] Implementar actualización de contraseña
- [ ] Testing de flujo completo

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Usuario puede recuperar contraseña olvidada

---

#### HU-028: Reporte de Bienes por Responsable (5 pts)
**Tareas:**
- [ ] Crear endpoint de reporte por responsable
- [ ] Diseñar template PDF de reporte
- [ ] Calcular valor total de bienes
- [ ] Incluir espacio para firma
- [ ] Testing de generación

**Responsable:** Desarrollador Backend  
**Criterio de Completitud:** Gerente puede generar reporte por responsable

---

#### HU-029: Dashboard de Responsable (8 pts)
**Tareas:**
- [ ] Diseñar dashboard de responsable
- [ ] Implementar métricas de bienes asignados
- [ ] Implementar alertas de mantenimiento
- [ ] Mostrar historial reciente
- [ ] Implementar impresión de constancia
- [ ] Testing de cálculos

**Responsable:** Desarrollador Full Stack  
**Criterio de Completitud:** Responsable ve dashboard de sus bienes

---

#### HU-030: Filtros Avanzados en Listados (8 pts)
**Tareas:**
- [ ] Implementar filtros combinables
- [ ] Implementar contador de resultados
- [ ] Crear funcionalidad de guardar filtros favoritos
- [ ] Implementar botón de limpiar filtros
- [ ] Implementar URLs compartibles con filtros
- [ ] Optimizar consultas con filtros múltiples
- [ ] Testing de filtros combinados

**Responsable:** Desarrollador Frontend  
**Criterio de Completitud:** Usuario puede aplicar filtros avanzados

---

#### Tareas Finales del Sprint
- [ ] Revisión completa de UI/UX
- [ ] Optimización de rendimiento
- [ ] Corrección de bugs menores
- [ ] Actualización de documentación completa
- [ ] Preparación para despliegue

---

### Definition of Done (DoD)
- [ ] Código revisado y aprobado
- [ ] Tests de regresión pasando
- [ ] Documentación completa actualizada
- [ ] Manual de usuario creado
- [ ] Sistema listo para producción
- [ ] Plan de despliegue documentado

---

## MÉTRICAS DE SEGUIMIENTO

### Burndown Chart (Por Sprint)
- Actualización diaria de story points completados vs restantes
- Identificación temprana de desviaciones

### Velocity Chart
- Seguimiento de puntos completados por sprint
- Ajuste de capacidad para sprints futuros

### Cumulative Flow Diagram
- Visualización de trabajo en progreso
- Identificación de cuellos de botella

---

## CEREMONIAS SCRUM

### Daily Standup (15 min)
- Qué hice ayer
- Qué haré hoy
- Impedimentos

### Sprint Planning (4 horas)
- Revisión de historias
- Estimación de tareas
- Compromiso del equipo

### Sprint Review (2 horas)
- Demostración de funcionalidades
- Feedback del Product Owner
- Ajustes al Product Backlog

### Sprint Retrospective (1.5 horas)
- Qué funcionó bien
- Qué mejorar
- Acciones de mejora

---

## ROLES DEL EQUIPO

- **Product Owner:** Gerente de Administración
- **Scrum Master:** Líder Técnico
- **Developers:**
  - Desarrollador Backend Senior
  - Desarrollador Frontend Senior
  - Desarrollador Full Stack
  - QA Engineer

---

## DEFINICIÓN DE "HECHO" GLOBAL

Una historia se considera terminada cuando:
1. ✅ Código implementado según criterios de aceptación
2. ✅ Tests unitarios y de integración pasando
3. ✅ Code review completado y aprobado
4. ✅ Documentación técnica actualizada
5. ✅ Sin bugs críticos ni de alta prioridad
6. ✅ Funcionalidad probada en ambiente de desarrollo
7. ✅ Aprobación del Product Owner
8. ✅ Código mergeado a rama principal
