<?php
require_once __DIR__ . '/Conexion.php';
require_once __DIR__ . '/../CapaEntidades/Actividad.php';

/**
 * DAO para Tarea (anteriormente Actividad)
 * Encargado de realizar operaciones CRUD sobre la tabla Tarea
 */
class ActividadDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion();
    }

    /**
     * Registra una tarea usando sp_tarea_guardar_completo
     */
    public function crear(Actividad $tarea) {
        $sql = "CALL sp_tarea_guardar_completo(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $tarea->getProyectoId(),
            $tarea->getTipoTareaId(),
            $tarea->getUsuarioId(),
            $tarea->getEstadoTareaId(),
            $tarea->getDescripcion(),
            $tarea->getFechaHora()
        ]);
    }

    /**
     * Lista tareas usando la vista detallada
     */
    public function listar() {
        $sql = "SELECT * FROM vista_actividades_detalladas ORDER BY fecha_hora DESC";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una tarea por ID
     */
    public function obtenerPorId($id) {
        $sql = "CALL sp_tarea_obtener_uno(?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza una tarea usando sp_tarea_actualizar_completo
     */
    public function actualizar(Actividad $tarea) {
        $sql = "CALL sp_tarea_actualizar_completo(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            $tarea->getId(),
            $tarea->getProyectoId(),
            $tarea->getTipoTareaId(),
            $tarea->getUsuarioId(),
            $tarea->getEstadoTareaId(),
            $tarea->getDescripcion()
        ]);
    }

    /**
     * Elimina una tarea usando sp_tarea_eliminar
     */
    public function eliminar($id) {
        $sql = "CALL sp_tarea_eliminar(?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Obtiene los tipos de tarea
     */
    public function obtenerTipos() {
        $sql = "SELECT * FROM TipoTarea ORDER BY nombre";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los estados posibles de una tarea
     */
    public function obtenerEstados() {
        $sql = "SELECT * FROM EstadoTarea ORDER BY nombre";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}