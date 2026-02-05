# Plan de Pruebas - Sistema de Gestión de Clientes (SGC)

## Objetivo del Plan de Pruebas

Validar que todas las funcionalidades del sistema funcionan correctamente según los requisitos especificados.

## Alcance

Este plan cubre pruebas funcionales para los siguientes módulos:
- Autenticación y Login
- Gestión de Clientes
- Gestión de Equipo (Contactos)
- Gestión de Proyectos
- Gestión de Tareas
- Gestión de Productos
- Gestión de Documentos

## Ambiente de Pruebas

- Sistema Operativo: Windows 10/11
- Navegador: Chrome, Firefox, Edge
- Base de Datos: MySQL 5.7+
- Servidor Web: Apache con PHP 7.4+
- Datos de Ejemplo: 5 registros por tabla

## Credenciales de Prueba

Email: admin@sistema.com
Contraseña: admin123

Usuarios adicionales:
- daniel.soto@devsoftware.com / dev123
- sofia.reyes@devsoftware.com / qa123
- lucas.fernandez@devsoftware.com / dev456
- maria.vazquez@devsoftware.com / devops123

## Casos de Prueba Funcionales

### Módulo 1: Autenticación

Caso de Prueba 1.1: Login Válido
- Acción: Ingresar email y contraseña correcta
- Resultado Esperado: Acceso concedido, redirección a dashboard
- Estado: Por ejecutar

Caso de Prueba 1.2: Login con Credenciales Inválidas
- Acción: Ingresar email/contraseña incorrecta
- Resultado Esperado: Mensaje de error "Credenciales inválidas"
- Estado: Por ejecutar

Caso de Prueba 1.3: Logout
- Acción: Hacer clic en botón "Cerrar Sesión"
- Resultado Esperado: Sesión finalizada, redirección a login
- Estado: Por ejecutar

### Módulo 2: Gestión de Clientes

Caso de Prueba 2.1: Crear Cliente Nuevo
- Acción: Clic en "Nuevo Cliente", llenar formulario, guardar
- Resultado Esperado: Cliente creado, aparece en tabla
- Estado: Por ejecutar

Caso de Prueba 2.2: Visualizar Clientes
- Acción: Abrir módulo de Clientes
- Resultado Esperado: Tabla muestra 5 clientes de ejemplo ordenados por ID
- Estado: Por ejecutar

Caso de Prueba 2.3: Editar Cliente Existente
- Acción: Hacer clic en "Editar", modificar datos, guardar
- Resultado Esperado: Cliente actualizado, datos se reflejan en tabla
- Estado: Por ejecutar

Caso de Prueba 2.4: Eliminar Cliente
- Acción: Hacer clic en "Eliminar", confirmar
- Resultado Esperado: Cliente eliminado de la tabla
- Estado: Por ejecutar

Caso de Prueba 2.5: Validación de Campos Requeridos
- Acción: Intentar guardar sin llenar campos obligatorios
- Resultado Esperado: Mostrar mensaje de validación
- Estado: Por ejecutar

### Módulo 3: Gestión de Equipo (Contactos)

Caso de Prueba 3.1: Crear Contacto Nuevo
- Acción: Clic en "Nuevo Contacto", seleccionar cliente, llenar datos, guardar
- Resultado Esperado: Contacto creado en tabla
- Estado: Por ejecutar

Caso de Prueba 3.2: Visualizar Contactos
- Acción: Abrir módulo Equipo
- Resultado Esperado: Tabla muestra 5 contactos ordenados por ID
- Estado: Por ejecutar

Caso de Prueba 3.3: Editar Contacto
- Acción: Hacer clic en "Editar", modificar datos, guardar
- Resultado Esperado: Cambios se reflejan en tabla
- Estado: Por ejecutar

Caso de Prueba 3.4: Eliminar Contacto
- Acción: Hacer clic en "Eliminar", confirmar
- Resultado Esperado: Contacto eliminado
- Estado: Por ejecutar

Caso de Prueba 3.5: Asociar Contacto a Cliente
- Acción: Crear contacto, seleccionar cliente correcto
- Resultado Esperado: Contacto vinculado al cliente correcto
- Estado: Por ejecutar

### Módulo 4: Gestión de Proyectos

Caso de Prueba 4.1: Crear Proyecto Nuevo
- Acción: Clic en "Nuevo Proyecto", llenar datos, guardar
- Resultado Esperado: Proyecto aparece en tabla
- Estado: Por ejecutar

Caso de Prueba 4.2: Visualizar Proyectos
- Acción: Abrir módulo Proyectos
- Resultado Esperado: Tabla muestra 5 proyectos ordenados por ID
- Estado: Por ejecutar

Caso de Prueba 4.3: Editar Proyecto
- Acción: Hacer clic en "Editar", modificar descripción/monto, guardar
- Resultado Esperado: Datos actualizados en tabla
- Estado: Por ejecutar

Caso de Prueba 4.4: Eliminar Proyecto
- Acción: Hacer clic en "Eliminar", confirmar
- Resultado Esperado: Proyecto eliminado
- Estado: Por ejecutar

Caso de Prueba 4.5: Cambiar Estado de Proyecto
- Acción: Editar proyecto, cambiar estado
- Resultado Esperado: Estado actualizado correctamente
- Estado: Por ejecutar

### Módulo 5: Gestión de Tareas

Caso de Prueba 5.1: Crear Tarea Nueva
- Acción: Clic en "Nueva Tarea", seleccionar proyecto, asignar usuario, guardar
- Resultado Esperado: Tarea aparece en tabla
- Estado: Por ejecutar

Caso de Prueba 5.2: Visualizar Tareas
- Acción: Abrir módulo Tareas
- Resultado Esperado: Tabla muestra 5 tareas ordenadas por ID
- Estado: Por ejecutar

Caso de Prueba 5.3: Editar Tarea
- Acción: Hacer clic en "Editar", modificar datos, guardar
- Resultado Esperado: Cambios se reflejan en tabla
- Estado: Por ejecutar

Caso de Prueba 5.4: Eliminar Tarea
- Acción: Hacer clic en "Eliminar", confirmar
- Resultado Esperado: Tarea eliminada
- Estado: Por ejecutar

Caso de Prueba 5.5: Cambiar Estado de Tarea
- Acción: Editar tarea, cambiar a "Completada"
- Resultado Esperado: Estado actualizado
- Estado: Por ejecutar

### Módulo 6: Gestión de Productos

Caso de Prueba 6.1: Crear Producto Nuevo
- Acción: Clic en "Nuevo Producto", llenar formulario, guardar
- Resultado Esperado: Producto aparece en tabla
- Estado: Por ejecutar

Caso de Prueba 6.2: Visualizar Productos
- Acción: Abrir módulo Productos
- Resultado Esperado: Tabla muestra 5 productos ordenados por ID
- Estado: Por ejecutar

Caso de Prueba 6.3: Editar Producto
- Acción: Hacer clic en "Editar", modificar precio/descripción, guardar
- Resultado Esperado: Datos actualizados
- Estado: Por ejecutar

Caso de Prueba 6.4: Eliminar Producto
- Acción: Hacer clic en "Eliminar", confirmar
- Resultado Esperado: Producto eliminado
- Estado: Por ejecutar

Caso de Prueba 6.5: Activar/Desactivar Producto
- Acción: Cambiar estado del producto
- Resultado Esperado: Estado actualizado en tabla
- Estado: Por ejecutar

### Módulo 7: Gestión de Documentos

Caso de Prueba 7.1: Subir Documento
- Acción: Clic en "Nuevo Documento", seleccionar archivo, llenar datos, guardar
- Resultado Esperado: Documento aparece en tabla, puede descargarse
- Estado: Por ejecutar

Caso de Prueba 7.2: Visualizar Documentos
- Acción: Abrir módulo Documentos
- Resultado Esperado: Tabla muestra 5 documentos ordenados por ID
- Estado: Por ejecutar

Caso de Prueba 7.3: Descargar Documento
- Acción: Hacer clic en botón "Descargar"
- Resultado Esperado: Archivo se descarga correctamente
- Estado: Por ejecutar

Caso de Prueba 7.4: Editar Documento
- Acción: Hacer clic en "Editar", modificar descripción, guardar
- Resultado Esperado: Cambios se reflejan en tabla
- Estado: Por ejecutar

Caso de Prueba 7.5: Eliminar Documento
- Acción: Hacer clic en "Eliminar", confirmar
- Resultado Esperado: Documento eliminado
- Estado: Por ejecutar

Caso de Prueba 7.6: Buscar Documento
- Acción: Escribir en buscador, presionar enter
- Resultado Esperado: Tabla filtra documentos que coinciden
- Estado: Por ejecutar

## Pruebas de Interfaz

Prueba I.1: Responsividad
- Probar en pantallas pequeñas (móvil)
- Probar en pantallas medianas (tablet)
- Probar en pantallas grandes (desktop)
- Estado: Por ejecutar

Prueba I.2: Botones y Enlaces
- Verificar que todos los botones sean clickeables
- Verificar que el tamaño de botones sea consistente
- Verificar que no haya elementos superpuestos
- Estado: Por ejecutar

Prueba I.3: Carga de Página
- Verificar que las páginas carguen rápidamente
- Verificar que no haya elementos rotos
- Estado: Por ejecutar

## Pruebas de Datos

Prueba D.1: Ordenamiento por ID
- Todos los registros deben aparecer ordenados ascendentemente por ID
- Estado: Por ejecutar

Prueba D.2: Relaciones entre Tablas
- Contactos deben estar vinculados a Clientes correctos
- Tareas deben estar vinculadas a Proyectos correctos
- Documentos deben estar vinculados a Proyectos correctos
- Estado: Por ejecutar

Prueba D.3: Datos de Ejemplo
- Verificar que los 5 registros de ejemplo se cargan correctamente
- Verificar que tienen datos válidos
- Estado: Por ejecutar

## Criterios de Aceptación

1. Todos los módulos cargan correctamente
2. CRUD funciona en todos los módulos
3. Los datos se validan antes de guardar
4. Los mensajes de error son claros
5. La interfaz es consistente en todos los módulos
6. Los botones tienen tamaño y espaciado uniforme
7. Los registros se ordenan por ID ascendente
8. Las relaciones entre tablas funcionan correctamente
9. Los datos de ejemplo son correctos (5 por tabla)
10. El sistema responde rápidamente

## Ciclo de Pruebas

1. Semana 1: Pruebas de Login y Autenticación
2. Semana 2: Pruebas de Módulos Principales (Clientes, Equipo, Proyectos)
3. Semana 3: Pruebas de Módulos Secundarios (Tareas, Productos, Documentos)
4. Semana 4: Pruebas de Interfaz y Regresión

## Defectos Encontrados

Para registrar defectos:
- Descripción clara del problema
- Pasos para reproducir
- Resultado esperado vs actual
- Navegador y SO utilizados
- Severidad (Crítica, Alta, Media, Baja)

## Reporte Final

Se generará reporte con:
- Casos de prueba ejecutados
- Casos pasados/fallidos
- Defectos encontrados
- Recomendaciones
- Fecha de pruebas
