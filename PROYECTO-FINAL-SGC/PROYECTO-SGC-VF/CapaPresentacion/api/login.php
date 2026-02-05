<?php
session_start();
header('Content-Type: application/json');

// Importamos la Capa de Negocio y las Excepciones
require_once __DIR__ . '/../../CapaNegocio/UsuarioNegocio.php';
require_once __DIR__ . '/../../CapaExcepciones/UsuarioNoExistenteException.php';
require_once __DIR__ . '/../../CapaExcepciones/ContraseñaIncorrectaException.php';
require_once __DIR__ . '/../../CapaExcepciones/CuentaBloqueadaException.php';

// Este archivo actúa como un punto de entrada para manejar las solicitudes de inicio de sesión.
// Recibe datos del cliente (frontend), los procesa y devuelve una respuesta adecuada.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del cuerpo de la solicitud
    $input = json_decode(file_get_contents('php://input'), true);
    
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    // Validar datos de entrada
    if (empty($email) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Email y contraseña son requeridos.'
        ]);
        exit;
    }

    // Crear instancia de la lógica de negocio
    $usuarioNegocio = new UsuarioNegocio();

    try {
        // Intentar autenticar al usuario
        $usuario = $usuarioNegocio->autenticar($email, $password);

        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['usuario_nombre'] = $usuario->getNombre();
        $_SESSION['usuario_email'] = $usuario->getEmail();
        $_SESSION['usuario_rol'] = $usuario->getRolId();

        // Respuesta en caso de éxito
        echo json_encode([
            'success' => true,
            'message' => 'Login exitoso',
            'usuario' => [
                'nombre' => $usuario->getNombre(),
                'rol' => $usuario->getRolId()
            ]
        ]);
    } catch (Exception $e) {
        // Respuesta en caso de error
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['accion']) && $_GET['accion'] === 'solicitar_desbloqueo') {
    try {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'] ?? '';

        $usuarioNegocio = new UsuarioNegocio();
        $usuarioNegocio->solicitarDesbloqueo($email);

        echo json_encode([
            'success' => true,
            'message' => 'Solicitud de desbloqueo registrada correctamente.'
        ]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}