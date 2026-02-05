# Sistema de Gestión de Clientes (SGC)

## Descripción General

El Sistema de Gestión de Clientes (SGC) es una aplicación web diseñada para que una empresa de desarrollo de software (software house) pueda administrar de manera integral todos sus proyectos, clientes, contactos, tareas y documentación.

## Objetivo del Proyecto

Proporcionar una plataforma centralizada que permita:

1. **Gestión de Clientes**: Mantener un registro completo de todas las empresas que solicitan servicios de desarrollo.
2. **Gestión de Contactos**: Registrar los responsables y puntos de contacto dentro de cada empresa cliente.
3. **Gestión de Proyectos**: Administrar los proyectos de software que se están desarrollando para cada cliente.
4. **Gestión de Tareas**: Asignar y dar seguimiento a las tareas específicas de cada proyecto.
5. **Gestión de Productos**: Catalogar los servicios y productos que ofrece la empresa.
6. **Gestión de Documentos**: Centralizar la documentación técnica, contratos, especificaciones y otros archivos importantes.

## Características Principales

### 1. Módulo de Clientes
- Registrar nuevos clientes con información de contacto
- Clasificar clientes por tipo (empresa, startup, gobierno, etc.)
- Visualizar listado completo de clientes
- Editar información de clientes existentes
- Eliminar clientes cuando sea necesario

### 2. Módulo de Equipo (Contactos)
- Asociar contactos específicos a cada cliente
- Registrar cargo, email y teléfono de cada contacto
- Mantener información de responsables de proyectos
- Facilitar la comunicación directa con puntos clave en cada cliente

### 3. Módulo de Proyectos (Oportunidades)
- Crear proyectos nuevos vinculados a clientes
- Asignar estados de proyecto (En Análisis, En Desarrollo, Completado, etc.)
- Registrar monto económico de cada proyecto
- Añadir descripción detallada del proyecto
- Dar seguimiento a múltiples proyectos simultáneamente

### 4. Módulo de Tareas (Actividades)
- Crear tareas vinculadas a proyectos específicos
- Asignar tareas a miembros del equipo
- Definir tipos de tarea (Desarrollo, Testing, Documentación, etc.)
- Establecer estados de tarea (Por Hacer, En Progreso, Completado)
- Registrar descripciones detalladas de cada tarea

### 5. Módulo de Productos
- Catalogar los servicios y productos ofrecidos
- Incluir descripción, precio y estado de cada producto
- Activar o desactivar productos según disponibilidad
- Permitir actualización de precios

### 6. Módulo de Documentos
- Subir documentos directamente al sistema (PDF, Word, Excel, imágenes, etc.)
- Vincular documentos a proyectos específicos
- Categorizar documentos (Especificación, Contrato, Diseño, etc.)
- Descargar documentos cuando sea necesario
- Incluir descripción de cada documento para mejor localización

## Arquitectura del Sistema

El sistema utiliza una arquitectura MVC (Modelo-Vista-Controlador) de tres capas:

### Capa de Presentación (Frontend)
- Interfaz de usuario desarrollada en HTML5, CSS3 y JavaScript
- Formularios interactivos para CRUD (Crear, Leer, Actualizar, Eliminar)
- Tablas dinámicas que se actualizan sin recargar la página
- Diseño responsive que se adapta a diferentes dispositivos

### Capa de Negocio (Business Logic)
- Clases de negocio (ActividadNegocio, ClienteNegocio, etc.)
- Validación de datos antes de procesar
- Manejo de reglas de negocio
- Gestión de excepciones personalizadas

### Capa de Datos (Backend)
- Base de datos MySQL con vistas y procedimientos almacenados
- Objetos de Acceso a Datos (DAO)
- Entidades que representan los objetos del negocio
- Excepciones específicas para manejo de errores

## Tecnologías Utilizadas

Backend:
- PHP 7.4+ con PDO para acceso a base de datos
- MySQL para almacenamiento de datos
- Procedimientos almacenados para operaciones complejas

Frontend:
- HTML5 para estructura
- CSS3 para estilos y diseño responsive
- JavaScript vanilla para interactividad
- Fetch API para comunicación con el servidor

## Módulos y Tablas Principales

### Base de Datos
- Tabla Usuario: gestiona acceso al sistema
- Tabla Cliente: información de clientes
- Tabla Contacto: contactos de clientes
- Tabla Proyecto: proyectos de desarrollo
- Tabla Tarea: tareas de proyectos
- Tabla Producto: productos/servicios ofrecidos
- Tabla Documento: documentación y archivos
- Tabla de Estados: predefinidos para proyectos y tareas
- Tabla de Categorías: para clasificar documentos y tareas

## Flujo de Trabajo Típico

1. **Adquirir Cliente**: Registrar nuevo cliente en el sistema
2. **Agregar Contactos**: Registrar responsables en la empresa cliente
3. **Crear Proyecto**: Crear proyecto vinculado al cliente con presupuesto
4. **Desglosar en Tareas**: Dividir el proyecto en tareas específicas
5. **Asignar Equipo**: Asignar miembros del equipo a tareas
6. **Documentar**: Subir especificaciones, diseños y otros documentos
7. **Dar Seguimiento**: Actualizar estado de tareas y proyectos
8. **Completar**: Marcar tareas y proyectos como finalizados

## Beneficios del Sistema

- Centralización de información en un único lugar
- Facilita la colaboración entre equipos
- Permite dar seguimiento a múltiples proyectos simultáneamente
- Mejora la comunicación con clientes
- Reduce pérdida de documentos y especificaciones
- Proporciona visibilidad del estado de proyectos
- Facilita la asignación de recursos
- Genera histórico de actividades y cambios

## Seguridad

El sistema implementa:
- Autenticación de usuarios con email y contraseña
- Validación de entrada en formularios
- Manejo de excepciones personalizadas
- Protección contra SQL injection mediante consultas preparadas
- Sesiones de usuario para mantener acceso seguro

## Datos de Ejemplo

El sistema viene precargado con:
- 5 empresas clientes de diferentes industrias
- 5 contactos responsables en las empresas
- 5 proyectos de desarrollo en diferentes fases
- 5 tareas asignadas a miembros del equipo
- 5 productos/servicios catalogados
- 5 documentos de ejemplo asociados a proyectos

## Próximas Mejoras Potenciales

- Dashboard con métricas y gráficos
- Reportes generados automáticamente
- Integración con calendario
- Sistema de notificaciones
- Módulo de facturación
- API REST para integraciones externas
- Aplicación móvil
- Exportación de reportes a PDF
