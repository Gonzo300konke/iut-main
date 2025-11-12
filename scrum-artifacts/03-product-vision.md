# VISIÓN DEL PRODUCTO
## Sistema de Gestión de Inventario de Bienes

**Fecha:** 04 de Noviembre de 2025  
**Versión:** 1.0  
**Product Owner:** Gerente de Administración

---

## 1. VISIÓN

Ser la solución integral de gestión patrimonial para instituciones educativas venezolanas que garantice transparencia, trazabilidad y control total de los bienes públicos, facilitando auditorías y optimizando la administración de activos institucionales.

---

## 2. DECLARACIÓN DEL PROBLEMA

### Problema
Las instituciones educativas venezolanas, especialmente los UPTOS (Universidades Politécnicas Territoriales), enfrentan serios desafíos en la gestión y control de sus activos patrimoniales:

- **Falta de trazabilidad:** No se conoce el paradero actual de muchos bienes
- **Pérdida de información:** Registros en papel susceptibles a deterioro o extravío
- **Auditorías complejas:** Procesos manuales que consumen semanas o meses
- **Responsabilidad difusa:** No hay claridad sobre quién es responsable de cada bien
- **Movimientos sin registro:** Traslados informales que no quedan documentados
- **Falta de evidencia:** No hay respaldo fotográfico de los bienes
- **Reportes ineficientes:** Generación manual de informes para auditorías

### Impacto
- Riesgo de sanciones en auditorías gubernamentales
- Pérdida de bienes por falta de control
- Tiempo administrativo desperdiciado
- Imposibilidad de tomar decisiones informadas sobre compras
- Deterioro de la transparencia institucional

### Afectados
- **Administradores:** Responsables de mantener control patrimonial
- **Gerentes de Bienes:** Encargados de supervisar inventarios
- **Responsables de Dependencias:** Usuarios a cargo de bienes específicos
- **Auditores:** Requieren información precisa y actualizada
- **Autoridades:** Necesitan reportes oficiales confiables

---

## 3. DECLARACIÓN DE LA SOLUCIÓN

### Producto
Sistema web de gestión de inventario de bienes patrimoniales, desarrollado en Laravel (PHP 8.2) con base de datos relacional, que permite registrar, rastrear y generar reportes oficiales sobre todos los activos de una institución educativa.

### Para quién
- Instituciones educativas públicas venezolanas
- Específicamente UPTOS (Universidades Politécnicas Territoriales)
- Organismos adscritos al Ministerio del Poder Popular para la Educación Universitaria

### Que resuelve
- **Registro digital centralizado** de todos los bienes institucionales
- **Trazabilidad completa** de movimientos y cambios de responsabilidad
- **Evidencia fotográfica** de cada activo
- **Reportes oficiales automatizados** listos para auditorías
- **Control de acceso por roles** para diferentes niveles de responsabilidad
- **Historial inmutable** de todas las operaciones
- **Jerarquía organizacional** clara (Organismo > Unidad > Dependencia > Bien)

### Diferenciadores
A diferencia de hojas de cálculo o sistemas genéricos:
- **Diseñado específicamente** para la realidad de instituciones educativas venezolanas
- **Cumple con normativas** de control patrimonial del Estado venezolano
- **Interfaz intuitiva** pensada para usuarios no técnicos
- **Sin costos de licenciamiento** (código abierto)
- **Autohospedable** en servidores institucionales

---

## 4. OBJETIVOS DEL PRODUCTO

### Objetivos de Negocio
1. **Reducir 80%** el tiempo de preparación para auditorías patrimoniales
2. **Eliminar 100%** de los registros en papel para el control de inventario
3. **Lograr trazabilidad completa** de todos los bienes en 6 meses
4. **Aprobar auditorías** sin observaciones mayores en control patrimonial
5. **Optimizar** asignación de presupuesto basado en datos de inventario real

### Objetivos de Usuario
1. **Registrar un bien nuevo** en menos de 5 minutos
2. **Generar reporte oficial** en menos de 2 minutos
3. **Localizar cualquier bien** en menos de 30 segundos
4. **Registrar movimientos** de forma sencilla y rápida
5. **Consultar historial** completo de cualquier activo

### Objetivos Técnicos
1. **Disponibilidad** del sistema 99.5% del tiempo
2. **Tiempo de respuesta** menor a 2 segundos en operaciones comunes
3. **Escalabilidad** para manejar hasta 50,000 bienes
4. **Seguridad** con autenticación robusta y auditoría completa
5. **Respaldos automáticos** diarios de toda la información

---

## 5. STAKEHOLDERS

### Stakeholders Primarios

#### 1. Product Owner: Gerente de Administración
- **Rol:** Define prioridades del producto
- **Interés:** Sistema que facilite control administrativo
- **Poder:** Alto - Decisión final sobre funcionalidades

#### 2. Usuarios Administradores
- **Rol:** Gestión completa del sistema
- **Interés:** Control total y visibilidad del inventario
- **Necesidades:** 
  - Dashboards con métricas clave
  - Gestión de usuarios y permisos
  - Acceso a toda la información

#### 3. Gerentes de Bienes
- **Rol:** Supervisión de inventarios por áreas
- **Interés:** Herramientas eficientes de gestión diaria
- **Necesidades:**
  - Registro rápido de bienes
  - Generación de reportes
  - Registro de movimientos

#### 4. Usuarios Responsables
- **Rol:** Cuidado de bienes asignados
- **Interés:** Claridad sobre sus responsabilidades
- **Necesidades:**
  - Ver bienes bajo su cargo
  - Notificaciones de cambios
  - Constancias de responsabilidad

### Stakeholders Secundarios

#### 5. Auditores Gubernamentales
- **Rol:** Verificación de control patrimonial
- **Interés:** Información confiable y verificable
- **Necesidades:**
  - Reportes oficiales detallados
  - Historial completo de movimientos
  - Evidencia fotográfica

#### 6. Autoridades Institucionales
- **Rol:** Toma de decisiones estratégicas
- **Interés:** Información para planificación
- **Necesidades:**
  - Reportes ejecutivos
  - Estadísticas de inventario
  - Valor total de activos

#### 7. Equipo de Desarrollo
- **Rol:** Construcción y mantenimiento del sistema
- **Interés:** Código mantenible y escalable
- **Necesidades:**
  - Arquitectura clara
  - Documentación técnica
  - Herramientas de desarrollo

---

## 6. ALCANCE DEL PRODUCTO

### En Alcance (Versión 1.0)

#### Gestión de Estructura Organizacional
- ✅ CRUD de Organismos
- ✅ CRUD de Unidades Administradoras
- ✅ CRUD de Dependencias
- ✅ Visualización de jerarquía completa

#### Gestión de Usuarios y Seguridad
- ✅ Registro de usuarios con roles
- ✅ Autenticación y autorización
- ✅ Roles: Administrador, Gerente, Responsable
- ✅ Gestión de perfiles
- ✅ Recuperación de contraseña

#### Gestión de Inventario
- ✅ Registro de bienes con fotos (hasta 5)
- ✅ Edición de información de bienes
- ✅ Búsqueda avanzada de bienes
- ✅ Listados con filtros y paginación
- ✅ Estados de bienes (Activo, Inactivo, Mantenimiento, Dado de Baja, Extraviado)

#### Gestión de Responsables
- ✅ Registro de responsables
- ✅ Tipos de responsables (Primario, Por Uso)
- ✅ Asignación de responsabilidad

#### Movimientos y Trazabilidad
- ✅ Registro de traslados entre dependencias
- ✅ Cambios de responsabilidad
- ✅ Historial completo de movimientos
- ✅ Documentos de autorización

#### Reportes y Auditoría
- ✅ Reporte de inventario por dependencia (PDF)
- ✅ Reporte por responsable (PDF)
- ✅ Exportación a Excel
- ✅ Auditoría automática de acciones
- ✅ Consulta de logs de auditoría

#### Funcionalidades Avanzadas
- ✅ Generación de códigos QR
- ✅ Escaneo de QR desde móvil
- ✅ Importación masiva desde Excel
- ✅ Notificaciones por correo
- ✅ Dashboards por rol

### Fuera de Alcance (Versión 1.0)

#### Funcionalidades Futuras
- ❌ Integración con sistema de compras
- ❌ Recordatorios automáticos de mantenimiento
- ❌ App móvil nativa
- ❌ Firma digital electrónica
- ❌ Geolocalización con IoT
- ❌ API pública para integraciones
- ❌ Módulo de garantías y seguros
- ❌ Gestión de depreciación
- ❌ Valorización automática

---

## 7. SUPUESTOS Y RESTRICCIONES

### Supuestos
1. La institución cuenta con servidor web con PHP 8.2+
2. Usuarios tienen acceso a navegador web moderno
3. Existe conectividad a Internet para notificaciones
4. Se cuenta con capacitación básica para usuarios
5. Hay respaldo de autoridades institucionales

### Restricciones Técnicas
1. **Tecnología:** Laravel 12, PHP 8.2+, MySQL/SQLite
2. **Hosting:** Servidor institucional (no cloud público)
3. **Presupuesto:** $0 en licencias de software
4. **Compatibilidad:** Navegadores modernos (últimas 2 versiones)
5. **Tiempo:** 12 semanas de desarrollo (6 sprints)

### Restricciones de Negocio
1. Cumplimiento de normativas venezolanas de control patrimonial
2. Datos sensibles no pueden salir de servidores institucionales
3. Reportes deben seguir formatos oficiales establecidos
4. Sistema debe funcionar en infraestructura limitada

### Dependencias
1. Aprobación de autoridades institucionales
2. Disponibilidad del equipo de desarrollo
3. Acceso a información de bienes existentes
4. Servidor de correo institucional configurado
5. Capacitación de usuarios finales

---

## 8. CRITERIOS DE ÉXITO

### Métricas de Adopción
- **80%** de usuarios activos semanalmente en el primer mes
- **100%** de bienes críticos registrados en 3 meses
- **90%** de satisfacción de usuarios (encuesta)

### Métricas de Eficiencia
- Reducción de **75%** en tiempo de generación de reportes
- Reducción de **80%** en tiempo de preparación para auditorías
- **0** errores críticos en producción

### Métricas de Calidad
- **100%** de movimientos con trazabilidad
- **95%** de bienes con evidencia fotográfica
- **0** observaciones mayores en auditorías

### Métricas Técnicas
- Disponibilidad **>99%**
- Tiempo de respuesta **<2 segundos**
- **0** brechas de seguridad críticas

---

## 9. ROADMAP DE ALTO NIVEL

### Fase 1: MVP - Fundamentos (Sprints 1-2)
**Nov 2025 - Dic 2025**
- Autenticación y roles
- Estructura organizacional
- Gestión básica de bienes

### Fase 2: Trazabilidad (Sprints 3-4)
**Dic 2025 - Ene 2026**
- Movimientos de bienes
- Cambios de responsabilidad
- Reportes oficiales
- Sistema de auditoría

### Fase 3: Optimización (Sprints 5-6)
**Ene 2026 - Feb 2026**
- Códigos QR
- Importación/Exportación masiva
- Notificaciones
- Mejoras de UX

### Fase 4: Consolidación
**Feb 2026 - Mar 2026**
- Despliegue en producción
- Capacitación de usuarios
- Migración de datos históricos
- Estabilización

### Versiones Futuras (2026-2027)
- Integración con sistemas externos
- Funcionalidades avanzadas de análisis
- App móvil nativa
- Firma digital

---

## 10. RIESGOS Y MITIGACIONES

| Riesgo | Probabilidad | Impacto | Mitigación |
|--------|--------------|---------|------------|
| Resistencia al cambio de usuarios | Alta | Alto | Capacitación continua, soporte dedicado |
| Datos históricos inconsistentes | Media | Alto | Proceso de validación y limpieza antes de migración |
| Falta de conectividad estable | Media | Medio | Diseño offline-first para funciones críticas |
| Cambio de autoridades institucionales | Baja | Alto | Documentación completa, código abierto |
| Problemas de rendimiento con muchos datos | Media | Medio | Optimización de consultas, índices adecuados |
| Pérdida de datos por fallas de hardware | Baja | Crítico | Respaldos automáticos diarios, redundancia |

---

## APROBACIONES

**Product Owner:**  
_________________________  
Gerente de Administración  
Fecha: _______________

**Scrum Master:**  
_________________________  
Líder Técnico  
Fecha: _______________

**Autoridad Institucional:**  
_________________________  
Rector/Director  
Fecha: _______________
