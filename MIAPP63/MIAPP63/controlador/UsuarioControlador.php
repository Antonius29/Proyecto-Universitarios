<?php
require_once __DIR__ . '/../dao/UsuarioDao.php';

class UsuarioControlador {
    public function procesarLogin($usuario, $clave) {
        $userDao = new UsuarioDao();
        $userObj = $userDao->autenticar($usuario, $clave);

        if ($userObj) {
            session_start();
            $_SESSION['usuario'] = $userObj->usuario;
            $_SESSION['usuario_id'] = $userObj->id;
            header('Location: index.php?accion=menu');
        } else {
            header('Location: index.php?accion=login&error=1');
        }
        exit();
    }
}
?>