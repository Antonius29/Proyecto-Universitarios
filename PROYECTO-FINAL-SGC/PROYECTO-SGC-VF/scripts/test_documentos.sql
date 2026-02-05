-- =============================================================
-- SCRIPT DE PRUEBA PARA MÓDULO DE DOCUMENTOS MEJORADO
-- =============================================================
-- Ejecuta estas queries para verificar que el sistema funciona

-- 1. Verificar que la tabla CategoriaDocumento existe
SELECT * FROM CategoriaDocumento;

-- 2. Verificar estructura de tabla Documento
DESCRIBE Documento;

-- 3. Listar todos los documentos con sus categorías y usuarios
SELECT 
    d.id,
    d.proyecto_id,
    c.nombre as categoria_nombre,
    d.nombre,
    d.descripcion,
    u.nombre as usuario_nombre,
    d.tamaño_kb,
    d.ruta_archivo,
    d.fecha_subida
FROM Documento d
LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id
LEFT JOIN Usuario u ON d.usuario_id = u.id
ORDER BY d.fecha_subida DESC;

-- 4. Documentos por proyecto específico (cambiar proyecto_id)
SELECT 
    d.id,
    d.nombre,
    c.nombre as categoria,
    d.tamaño_kb,
    u.nombre as usuario_nombre
FROM Documento d
LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id
LEFT JOIN Usuario u ON d.usuario_id = u.id
WHERE d.proyecto_id = 1;

-- 5. Documentos por categoría específica (cambiar categoria_id)
SELECT 
    d.id,
    d.nombre,
    d.proyecto_id,
    u.nombre as usuario_nombre,
    d.tamaño_kb
FROM Documento d
LEFT JOIN Usuario u ON d.usuario_id = u.id
WHERE d.categoria_id = 1;

-- 6. Contar documentos por categoría
SELECT 
    c.id,
    c.nombre,
    COUNT(d.id) as total_documentos
FROM CategoriaDocumento c
LEFT JOIN Documento d ON c.id = d.categoria_id
GROUP BY c.id, c.nombre
ORDER BY total_documentos DESC;

-- 7. Documentos más grandes (Top 10)
SELECT 
    id,
    nombre,
    proyecto_id,
    tamaño_kb,
    tamaño_kb / 1024 as tamaño_mb
FROM Documento
ORDER BY tamaño_kb DESC
LIMIT 10;

-- 8. Últimos 5 documentos subidos
SELECT 
    d.id,
    d.nombre,
    d.proyecto_id,
    c.nombre as categoria,
    u.nombre as usuario_nombre,
    d.fecha_subida
FROM Documento d
LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id
LEFT JOIN Usuario u ON d.usuario_id = u.id
ORDER BY d.fecha_subida DESC
LIMIT 5;

-- 9. Búsqueda de documentos que contengan "especificación"
SELECT 
    d.id,
    d.nombre,
    d.descripcion,
    c.nombre as categoria,
    d.tamaño_kb
FROM Documento d
LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id
WHERE d.nombre LIKE '%especificación%' 
   OR d.descripcion LIKE '%especificación%'
ORDER BY d.fecha_subida DESC;

-- 10. Estadísticas del módulo de documentos
SELECT 
    'Total Documentos' as Métrica,
    COUNT(*) as Valor
FROM Documento
UNION ALL
SELECT 
    'Total Categorías',
    COUNT(*)
FROM CategoriaDocumento
UNION ALL
SELECT 
    'Tamaño Total (MB)',
    ROUND(SUM(tamaño_kb) / 1024, 2)
FROM Documento
UNION ALL
SELECT 
    'Tamaño Promedio (KB)',
    ROUND(AVG(tamaño_kb), 0)
FROM Documento
UNION ALL
SELECT 
    'Usuario que más subió',
    COUNT(*)
FROM Documento
GROUP BY usuario_id
ORDER BY COUNT(*) DESC
LIMIT 1;
