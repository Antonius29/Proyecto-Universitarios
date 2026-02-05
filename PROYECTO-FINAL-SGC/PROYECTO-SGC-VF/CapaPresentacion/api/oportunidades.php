<?php
require_once __DIR__ . '/../../CapaNegocio/OportunidadNegocio.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');
$proyectoNegocio = new OportunidadNegocio();

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $action = $_GET['action'] ?? null;
    
    // Obtener estados
    if ($method === 'GET' && $action === 'estados') {
        echo json_encode($proyectoNegocio->obtenerEstados());
    }
    // GET: Listar o consultar por ID
    elseif ($method === 'GET') {
        if (isset($_GET['id'])) {
            echo json_encode($proyectoNegocio->obtenerPorId($_GET['id']));
        } else {
            echo json_encode($proyectoNegocio->listar());
        }
    }
    
    // POST: Crear o actualizar proyecto
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Si hay ID, es actualizar; si no, es crear
        if (!empty($data['id'])) {
            // ACTUALIZAR
            $resultado = $proyectoNegocio->actualizar(
                $data['id'],
                $data['cliente_id'],
                $data['estado_proyecto_id'],
                $data['monto'] ?? 0,
                $data['descripcion'] ?? null
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Proyecto actualizado exitosamente']);
        } else {
            // CREAR
            $resultado = $proyectoNegocio->crear(
                $data['cliente_id'],
                $data['estado_proyecto_id'],
                $data['monto'] ?? 0,
                $data['descripcion'] ?? null
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Proyecto creado exitosamente']);
        }
    }

    // PUT: Actualizar proyecto (deprecated, usar POST)
    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        $resultado = $proyectoNegocio->actualizar(
            $data['id'],
            $data['cliente_id'],
            $data['estado_proyecto_id'],
            $data['monto'] ?? 0,
            $data['descripcion'] ?? null
        );

        echo json_encode(['success' => $resultado]);
    }

    // DELETE: Eliminar proyecto
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        $resultado = $proyectoNegocio->eliminar($id);
        echo json_encode(['success' => $resultado]);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}