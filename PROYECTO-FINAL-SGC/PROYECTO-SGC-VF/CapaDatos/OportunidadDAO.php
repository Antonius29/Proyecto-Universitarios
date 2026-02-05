<?php
require_once __DIR__ . '/Conexion.php';
require_once __DIR__ . '/../CapaEntidades/Oportunidad.php';

/**
 * DAO para Proyecto (anteriormente Oportunidad)
 * 
 * Esta clase encapsula todas las operaciones de acceso a datos relacionadas
 * con la tabla Proyecto en la base de datos.
 */
class OportunidadDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion();
    }

    /**
     * Crea un nuevo proyecto usando sp_proyecto_guardar_completo
     */
    public function crear(Oportunidad $proyecto) {
        $sql = "CALL sp_proyecto_guardar_completo(?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            $proyecto->getClienteId(),
            $proyecto->getEstadoOportunidadId(),
            $proyecto->getMonto(),
            $proyecto->getDescripcion(),
            $proyecto->getFechaHora()
        ]);
    }

    /**
     * Lista todos los proyectos usando la vista detallada
     */
    public function listar() {
        $sql = "SELECT * FROM vista_oportunidades_detalladas ORDER BY fecha_hora DESC";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un proyecto por su ID
     */
    public function obtenerPorId($id) {
        $sql = "CALL sp_proyecto_obtener_uno(?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza un proyecto usando sp_proyecto_actualizar_completo
     */
    public function actualizar(Oportunidad $proyecto) {
        $sql = "CALL sp_proyecto_actualizar_completo(?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            $proyecto->getId(),
            $proyecto->getClienteId(),
            $proyecto->getEstadoOportunidadId(),
            $proyecto->getMonto(),
            $proyecto->getDescripcion(),
            $proyecto->getFechaHora()
        ]);
    }

    /**
     * Elimina un proyecto usando sp_proyecto_eliminar
     */
    public function eliminar($id) {
        $sql = "CALL sp_proyecto_eliminar(?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Obtiene los estados posibles usando sp_estado_proyecto_listar
     */
    public function obtenerEstados() {
        $sql = "SELECT * FROM EstadoProyecto ORDER BY nombre";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}