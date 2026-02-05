# Cambios Realizados al Sistema de Gestión de Clientes (SGC)

Última actualización: 23 de enero de 2026

## Resumen Ejecutivo

Se han realizado mejoras significativas en la funcionalidad del sistema, enfocándose en la corrección de errores críticos en los formularios, la mejora de la interfaz de usuario y la optimización de la presentación de datos.

## Cambios Principales Realizados

### 1. Corrección de Formularios Vacíos al Editar

PROBLEMA: Los formularios aparecían vacíos cuando hacía clic en el botón "Editar"

CAUSA RAÍZ: La función mostrarFormulario() llamaba a reset() inmediatamente después de cargar los datos, borrando todos los campos.

SOLUCIÓN IMPLEMENTADA:
- Modificó todas las funciones mostrarFormulario() para aceptar un parámetro esNuevo
- Si esNuevo = true: llama a reset() para crear nuevo registro
- Si esNuevo = false: no llama a reset(), preserva datos cargados
- Todas las funciones editarX() ahora pasan false: mostrarFormulario(false)

MÓDULOS AFECTADOS:
- contactos.js
- oportunidades.js
- actividades.js
- productos.js
- documentos.js

RESULTADO: Los formularios ahora muestran correctamente los datos del registro a editar.

### 2. Corrección del Problema "Guardar Crea Nueva Fila"

PROBLEMA: Al editar un registro y hacer guardar, se creaba una nueva fila en lugar de actualizar la existente

CAUSA RAÍZ: Los APIs no distinguían entre crear (POST sin ID) y actualizar (POST con ID)

SOLUCIÓN IMPLEMENTADA:
- Se modificaron todos los archivos API para verificar si existe ID
- Si ID presente: ejecuta operación actualizar
- Si ID vacío: ejecuta operación crear

ARCHIVOS MODIFICADOS:
- api/clientes.php
- api/contactos.php
- api/oportunidades.php
- api/actividades.php
- api/productos.php

RESULTADO: Editar ahora actualiza correctamente el registro sin crear duplicados.

### 3. Mejora de Interfaz: Botones "Nuevo"

PROBLEMA: Los botones "Nuevo" no tenían consistencia visual en los módulos

CAMBIO REALIZADO:
- Cambié todos los contenedores de "toolbar" a "action-bar" por consistencia
- Reubiqué botón "Nuevo Documento" al inicio (antes estaba junto con buscador)
- Todos los módulos ahora tienen estructura uniforme

MÓDULOS AFECTADOS:
- contactos.php: toolbar -> action-bar
- oportunidades.php: toolbar -> action-bar
- actividades.php: toolbar -> action-bar
- productos.php: toolbar -> action-bar
- documentos.php: reestructurado

RESULTADO: Interfaz consistente y profesional en todos los módulos.

### 4. Optimización de Tamaño de Botones

PROBLEMA: Los botones de tabla tenían tamaños inconsistentes (especialmente "Descargar" vs "Editar"/"Eliminar")

CAMBIO REALIZADO:
- Aumenté padding de btn-sm de "8px 16px" a "10px 18px"
- Agregué line-height: 1 para alineación vertical
- Agregué display: inline-block con line-height a enlace Descargar
- Agregué flex display a última columna de tabla con gap: 8px

ARCHIVOS MODIFICADOS:
- estilos.css

RESULTADO: Todos los botones tienen tamaño uniforme y están correctamente alineados.

### 5. Corrección de Ordenamiento de Registros

PROBLEMA: Los registros salían desordenados (no en orden por ID)

CAUSA RAÍZ: Los datos venían sin ordenar del servidor

SOLUCIÓN IMPLEMENTADA:
- Agregó sort() en cada función de carga después de obtener datos de API
- Todos los arrays se ordenan por ID ascendente: sort((a, b) => a.id - b.id)

MÓDULOS AFECTADOS:
- clientes.js
- contactos.js
- oportunidades.js
- actividades.js
- productos.js
- documentos.js

RESULTADO: Todos los registros aparecen ordenados por ID de menor a mayor.

### 6. Reducción de Datos de Ejemplo

CAMBIO REALIZADO:
- Reducido de múltiples registros a exactamente 5 por tabla para mejor visualización

CAMBIOS EN BD:
- Clientes: 5 registros (ya estaban)
- Usuarios: 5 registros (ya estaban)
- Contactos: 8 -> 5 registros
- Proyectos: 10 -> 5 registros
- Tareas: 20 -> 5 registros
- Productos: 10 -> 5 registros
- Documentos: 16 -> 5 registros

ARCHIVO MODIFICADO:
- scripts/bd_clientes.sql

RESULTADO: Base de datos más limpia, más fácil de visualizar y mantener.

### 7. Documentación Nueva

Se han creado los siguientes archivos de documentación:

ACERCA_DEL_PROYECTO.md
- Descripción general del sistema
- Objetivo y características
- Arquitectura
- Tecnologías utilizadas
- Flujo de trabajo típico
- Beneficios
- Próximas mejoras

GUIA_EJECUCION.md
- Requisitos previos
- Paso a paso para ejecutar
- Configuración de base de datos
- Colocación de archivos
- Formas de iniciar el servidor
- Solución de problemas
- Estructura de carpetas

PLAN_DE_PRUEBAS_DETALLADO.md
- Objetivo de pruebas
- Alcance
- Ambiente de pruebas
- Credenciales de prueba
- Casos de prueba detallados para cada módulo
- Pruebas de interfaz
- Pruebas de datos
- Criterios de aceptación
- Ciclo de pruebas

CAMBIOS_REALIZADOS.md (este archivo)
- Registro de todos los cambios efectuados

## Resumen de Archivos Modificados

### Archivos JavaScript Modificados (6):
1. contactos.js
2. oportunidades.js
3. actividades.js
4. productos.js
5. documentos.js
6. clientes.js

### Archivos PHP Modificados (6):
1. contactos.php
2. oportunidades.php
3. actividades.php
4. productos.php
5. documentos.php
6. api/clientes.php
7. api/contactos.php
8. api/oportunidades.php
9. api/actividades.php
10. api/productos.php

### Archivos CSS Modificados (1):
1. estilos.css

### Archivos SQL Modificados (1):
1. scripts/bd_clientes.sql

### Archivos Markdown Creados (4):
1. ACERCA_DEL_PROYECTO.md
2. GUIA_EJECUCION.md
3. PLAN_DE_PRUEBAS_DETALLADO.md
4. CAMBIOS_REALIZADOS.md

## Impacto en Funcionalidad

### Antes de los Cambios:
- Formularios mostraban vacíos al editar
- Editar creaba nuevas filas en lugar de actualizar
- Botones inconsistentes en tamaño
- Registros desordenados
- Interfaz inconsistente entre módulos

### Después de los Cambios:
- Formularios cargan correctamente con datos existentes
- Editar actualiza registros correctamente
- Todos los botones tienen tamaño uniforme
- Registros ordenados por ID ascendente
- Interfaz consistente y profesional

## Testing Realizado

- Verificado que formularios de editar cargan datos correctamente
- Verificado que guardar actualiza registros en lugar de crear nuevos
- Verificado que botones tienen tamaño uniforme
- Verificado que registros aparecen ordenados
- Verificado que todos los módulos funcionan correctamente
- No se encontraron errores de compilación en ningún archivo

## Cambios No Realizados

Se decidió NO realizar:
- Cambio de base de datos a PostgreSQL
- Implementación de API REST completa
- Sistema de autenticación OAuth
- Aplicación móvil nativa
- Sistema de reportes avanzados

Estos se consideran para futuras mejoras.

## Recomendaciones

1. Ejecutar suite completa de pruebas con datos reales
2. Validar performance con datos a escala
3. Considerar agregar búsqueda avanzada
4. Implementar sistema de permisos más granular
5. Agregar auditoría de cambios
6. Considerar migración a framework moderno

## Historial de Cambios

Todos los cambios fueron realizados en la sesión del 23 de enero de 2026 como parte del mejoramiento general del sistema.

## Próximas Acciones

1. Ejecutar plan de pruebas detallado
2. Recopilar feedback de usuarios
3. Identificar nuevos defectos o mejoras
4. Planificar próxima iteración

## Aprobación

Cambios realizados: 23 de enero de 2026
Estado: Completados y verificados
Listo para: Pruebas exhaustivas
