<?php
session_start();
require_once __DIR__ . '/../../CapaNegocio/DocumentoNegocio.php';

header('Content-Type: application/json; charset=utf-8');

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

try {
    $negocio = new DocumentoNegocio();
    $action = $_GET['action'] ?? $_POST['action'] ?? null;

    switch ($action) {
        case 'crear':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $proyecto_id = $_POST['proyecto_id'] ?? null;
            $categoria_id = $_POST['categoria_id'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $url_externa = $_POST['url_externa'] ?? null;
            $archivo = $_FILES['archivo'] ?? null;

            $resultado = $negocio->crear(
                $proyecto_id,
                $categoria_id,
                $nombre,
                $descripcion,
                $_SESSION['usuario_id'],
                $archivo,
                $url_externa
            );

            echo json_encode([
                'success' => true,
                'mensaje' => 'Documento creado exitosamente',
                'id' => $resultado
            ]);
            break;

        case 'listar':
            $documentos = $negocio->listar();
            echo json_encode([
                'success' => true,
                'data' => $documentos
            ]);
            break;

        case 'porProyecto':
            if (!isset($_GET['proyecto_id'])) {
                throw new Exception('Proyecto ID requerido');
            }
            $documentos = $negocio->obtenerPorProyecto($_GET['proyecto_id']);
            echo json_encode([
                'success' => true,
                'data' => $documentos
            ]);
            break;

        case 'porCategoria':
            if (!isset($_GET['categoria_id'])) {
                throw new Exception('Categoría ID requerido');
            }
            $documentos = $negocio->obtenerPorCategoria($_GET['categoria_id']);
            echo json_encode([
                'success' => true,
                'data' => $documentos
            ]);
            break;

        case 'buscar':
            if (!isset($_GET['q'])) {
                throw new Exception('Término de búsqueda requerido');
            }
            $documentos = $negocio->buscar($_GET['q']);
            echo json_encode([
                'success' => true,
                'data' => $documentos
            ]);
            break;

        case 'categorias':
            $categorias = $negocio->obtenerCategorias();
            echo json_encode([
                'success' => true,
                'data' => $categorias
            ]);
            break;

        case 'obtener':
            if (!isset($_GET['id'])) {
                throw new Exception('ID requerido');
            }
            $documento = $negocio->obtenerPorId($_GET['id']);
            echo json_encode([
                'success' => true,
                'data' => $documento
            ]);
            break;

        case 'actualizar':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $id = $_POST['id'] ?? null;
            $proyecto_id = $_POST['proyecto_id'] ?? null;
            $categoria_id = $_POST['categoria_id'] ?? null;
            $nombre = $_POST['nombre'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;

            $resultado = $negocio->actualizar($id, $proyecto_id, $categoria_id, $nombre, $descripcion);
            echo json_encode([
                'success' => true,
                'mensaje' => 'Documento actualizado exitosamente'
            ]);
            break;

        case 'eliminar':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }

            $id = $_POST['id'] ?? null;
            $resultado = $negocio->eliminar($id);
            echo json_encode([
                'success' => true,
                'mensaje' => 'Documento eliminado exitosamente'
            ]);
            break;

        case 'descargar':
            if (!isset($_GET['id'])) {
                throw new Exception('ID requerido para descargar');
            }

            $documento = $negocio->obtenerPorId($_GET['id']);
            
            if (!$documento || empty($documento['ruta_archivo'])) {
                throw new Exception('Documento no encontrado o no tiene archivo');
            }

            $ruta = __DIR__ . '/../../documentos/' . $documento['ruta_archivo'];
            
            if (!file_exists($ruta)) {
                throw new Exception('Archivo no existe en el servidor');
            }

            // Enviar archivo al cliente
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $documento['nombre'] . '"');
            header('Content-Length: ' . filesize($ruta));
            readfile($ruta);
            exit;

        default:
            throw new Exception('Acción no reconocida');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}