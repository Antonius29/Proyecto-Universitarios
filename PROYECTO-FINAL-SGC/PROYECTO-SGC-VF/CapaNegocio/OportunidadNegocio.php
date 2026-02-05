<?php
require_once __DIR__ . '/../CapaDatos/OportunidadDAO.php';
require_once __DIR__ . '/../CapaEntidades/Oportunidad.php';

/**
 * Capa de Negocio para Proyecto (anteriormente Oportunidad)
 */
class OportunidadNegocio {
    private $oportunidadDAO;

    public function __construct() {
        $this->oportunidadDAO = new OportunidadDAO();
    }

    /**
     * Crear un nuevo proyecto
     */
    public function crear($cliente_id, $estado_proyecto_id, $monto, $descripcion) {
        // Validación de negocio
        if (empty($cliente_id) || empty($estado_proyecto_id)) {
            throw new Exception("El cliente y el estado son obligatorios para el proyecto.");
        }

        // Crear la entidad Proyecto
        $proyecto = new Oportunidad(
            null, 
            $cliente_id,
            $estado_proyecto_id,
            date('Y-m-d H:i:s'),
            $monto,
            $descripcion
        );

        // Delegar al DAO (que usa sp_proyecto_guardar_completo)
        return $this->oportunidadDAO->crear($proyecto);
    }

    /**
     * Listar todos los proyectos (usa la vista detallada)
     */
    public function listar() {
        return $this->oportunidadDAO->listar();
    }

    /**
     * Obtener un proyecto por su ID
     */
    public function obtenerPorId($id) {
        if (empty($id)) {
            throw new Exception("ID de proyecto no válido.");
        }
        return $this->oportunidadDAO->obtenerPorId($id);
    }

    /**
     * Actualizar un proyecto existente
     */
    public function actualizar($id, $cliente_id, $estado_proyecto_id, $monto, $descripcion) {
        if (empty($id) || empty($cliente_id) || empty($estado_proyecto_id)) {
            throw new Exception("El ID, cliente y estado son obligatorios para actualizar.");
        }

        $proyecto = new Oportunidad(
            $id,
            $cliente_id,
            $estado_proyecto_id,
            date('Y-m-d H:i:s'),
            $monto,
            $descripcion
        );

        // Delegar al DAO (que usa sp_proyecto_actualizar_completo)
        return $this->oportunidadDAO->actualizar($proyecto);
    }

    /**
     * Eliminar un proyecto por ID
     */
    public function eliminar($id) {
        if (empty($id)) {
            throw new Exception("ID requerido para eliminar el proyecto.");
        }
        return $this->oportunidadDAO->eliminar($id);
    }

    /**
     * Obtener los estados disponibles
     */
    public function obtenerEstados() {
        return $this->oportunidadDAO->obtenerEstados();
    }
}