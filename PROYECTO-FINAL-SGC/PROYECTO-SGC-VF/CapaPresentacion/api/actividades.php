<?php
require_once __DIR__ . '/../../CapaNegocio/ActividadNegocio.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');
$tareaNegocio = new ActividadNegocio();

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $action = $_GET['action'] ?? null;
    
    // Obtener tipos de tarea
    if ($method === 'GET' && $action === 'tipos') {
        echo json_encode($tareaNegocio->obtenerTipos());
    }
    // Obtener estados de tarea
    elseif ($method === 'GET' && $action === 'estados') {
        echo json_encode($tareaNegocio->obtenerEstados());
    }
    // GET: Listar o consultar por ID
    elseif ($method === 'GET') {
        if (isset($_GET['id'])) {
            echo json_encode($tareaNegocio->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($tareaNegocio->listar());
        }
    }

    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Si hay ID, es actualizar; si no, es crear
        if (!empty($data['id'])) {
            // ACTUALIZAR
            $resultado = $tareaNegocio->actualizar(
                $data['id'],
                $data['proyecto_id'],
                $data['tipo_tarea_id'],
                $data['usuario_id'],
                $data['estado_tarea_id'],
                $data['descripcion'] ?? ''
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Tarea actualizada exitosamente']);
        } else {
            // CREAR
            $resultado = $tareaNegocio->crear(
                $data['proyecto_id'],
                $data['tipo_tarea_id'],
                $data['usuario_id'],
                $data['estado_tarea_id'],
                $data['descripcion'] ?? ''
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Tarea creada exitosamente']);
        }
    }

    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);
        $resultado = $tareaNegocio->actualizar(
            $data['id'],
            $data['proyecto_id'],
            $data['tipo_tarea_id'],
            $data['usuario_id'],
            $data['estado_tarea_id'],
            $data['descripcion'] ?? ''
        );
        echo json_encode(['success' => $resultado]);
    }

    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        $resultado = $tareaNegocio->eliminar($id);
        echo json_encode(['success' => $resultado]);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}