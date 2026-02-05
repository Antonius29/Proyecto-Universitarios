<?php
require_once __DIR__ . '/../../CapaNegocio/ClienteNegocio.php';
require_once __DIR__ . '/../../CapaDatos/Conexion.php';

session_start();

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');
$clienteNegocio = new ClienteNegocio();
$conexion = Conexion::getConexion();

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $type = $_GET['type'] ?? null;
    
    // GET: Devolver usuarios para tareas
    if ($method === 'GET' && $type === 'usuarios') {
        $sql = "SELECT id, nombre FROM Usuario ORDER BY nombre";
        $stmt = $conexion->query($sql);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    // GET: Listar o Obtener por ID
    elseif ($method === 'GET') {
        if (isset($_GET['id'])) {
            $cliente = $clienteNegocio->obtenerPorId($_GET['id']);
            echo json_encode($cliente);
        } else {
            $clientes = $clienteNegocio->listar();
            echo json_encode($clientes);
        }
    }
    
    // POST: Crear o actualizar cliente
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Si hay ID, es actualizar; si no, es crear
        if (!empty($data['id'])) {
            // ACTUALIZAR
            $resultado = $clienteNegocio->actualizar(
                $data['id'],
                $data['nombre'] ?? '',
                $data['tipo_cliente_id'] ?? null,
                $data['telefono'] ?? null,
                $data['email'] ?? null,
                $data['activo'] ?? 1
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Cliente actualizado exitosamente']);
        } else {
            // CREAR
            $resultado = $clienteNegocio->crear(
                $data['nombre'] ?? '',
                $data['tipo_cliente_id'] ?? null,
                $data['telefono'] ?? null,
                $data['email'] ?? null
            );
            echo json_encode(['success' => $resultado, 'mensaje' => 'Cliente creado exitosamente']);
        }
    }
    
    // DELETE: Eliminar cliente
    elseif ($method === 'DELETE') {
        $id = $_GET['id'] ?? null;
        $resultado = $clienteNegocio->eliminar($id);
        echo json_encode(['success' => $resultado]);
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage()
    ]);
}