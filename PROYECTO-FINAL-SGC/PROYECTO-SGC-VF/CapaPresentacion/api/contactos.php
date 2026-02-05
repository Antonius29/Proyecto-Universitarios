<?php
require_once __DIR__ . '/../../CapaNegocio/ContactoNegocio.php';

session_start();

// Verificación de seguridad
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');
$contactoNegocio = new ContactoNegocio();

try {
    $method = $_SERVER['REQUEST_METHOD'];
    
    // MÉTODO GET: Listar o consultar contacto
    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            $contacto = $contactoNegocio->obtenerPorId($_GET['id']);
            echo json_encode($contacto);
        } else {
            $contactos = $contactoNegocio->listar();
            echo json_encode($contactos ?? []);
        }
    }

    // MÉTODO POST: Crear o actualizar contacto
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Si hay ID, es actualizar; si no, es crear
        if (!empty($data['id'])) {
            // ACTUALIZAR
            $resultado = $contactoNegocio->actualizar(
                $data['id'],
                $data['cliente_id'],
                $data['nombre'],
                $data['cargo'] ?? null,
                $data['email'] ?? null,
                $data['telefono'] ?? null
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Contacto actualizado exitosamente']);
        } else {
            // CREAR
            $resultado = $contactoNegocio->crear(
                $data['cliente_id'],
                $data['nombre'],
                $data['cargo'] ?? null,
                $data['email'] ?? null,
                $data['telefono'] ?? null
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Contacto creado exitosamente']);
        }
    }

    // MÉTODO PUT: Actualizar contacto existente (deprecated, usar POST)
    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);

        $resultado = $contactoNegocio->actualizar(
            $data['id'],
            $data['cliente_id'],
            $data['nombre'],
            $data['cargo'] ?? null,
            $data['email'] ?? null,
            $data['telefono'] ?? null
        );

        echo json_encode(['success' => $resultado]);
    }

    // MÉTODO DELETE: Eliminar contacto
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        $resultado = $contactoNegocio->eliminar($id);
        echo json_encode(['success' => $resultado]);
    }

} catch (Exception $e) {
    // Si ocurre un error (incluyendo los de validación del Negocio), se responde aquí
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}