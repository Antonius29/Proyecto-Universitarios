<?php
require_once __DIR__ . '/../CapaDatos/ActividadDAO.php';
require_once __DIR__ . '/../CapaEntidades/Actividad.php';

/**
 * Capa de Negocio para Tarea (anteriormente Actividad)
 */
class ActividadNegocio {
    private $actividadDAO;

    public function __construct() {
        $this->actividadDAO = new ActividadDAO();
    }

    /**
     * Crear una nueva tarea
     */
    public function crear($proyecto_id, $tipo_tarea_id, $usuario_id, $estado_tarea_id, $descripcion) {
        // Validación de lógica de negocio
        if (empty($proyecto_id) || empty($tipo_tarea_id) || empty($usuario_id) || empty($estado_tarea_id)) {
            throw new Exception("Proyecto, tipo de tarea, usuario y estado son obligatorios para crear la tarea.");
        }

        // Crear la entidad Tarea
        $tarea = new Actividad(
            null,
            $proyecto_id,
            $tipo_tarea_id,
            $usuario_id,
            $estado_tarea_id,
            date('Y-m-d H:i:s'),
            $descripcion
        );

        return $this->actividadDAO->crear($tarea);
    }

    /**
     * Listar todas las tareas
     */
    public function listar() {
        return $this->actividadDAO->listar();
    }

    /**
     * Obtener una tarea por ID
     */
    public function obtenerPorId($id) {
        if (empty($id)) {
            throw new Exception("El ID de la tarea es necesario.");
        }
        return $this->actividadDAO->obtenerPorId($id);
    }

    /**
     * Actualizar una tarea existente
     */
    public function actualizar($id, $proyecto_id, $tipo_tarea_id, $usuario_id, $estado_tarea_id, $descripcion) {
        // Validación
        if (empty($id) || empty($proyecto_id) || empty($tipo_tarea_id) || empty($usuario_id) || empty($estado_tarea_id)) {
            throw new Exception("ID, proyecto, tipo de tarea, usuario y estado son obligatorios para actualizar.");
        }

        $tarea = new Actividad(
            $id,
            $proyecto_id,
            $tipo_tarea_id,
            $usuario_id,
            $estado_tarea_id,
            date('Y-m-d H:i:s'),
            $descripcion
        );

        return $this->actividadDAO->actualizar($tarea);
    }

    /**
     * Eliminar una tarea por ID
     */
    public function eliminar($id) {
        if (empty($id)) {
            throw new Exception("ID no válido para eliminar.");
        }
        return $this->actividadDAO->eliminar($id);
    }

    /**
     * Obtener tipos de tarea disponibles
     */
    public function obtenerTipos() {
        return $this->actividadDAO->obtenerTipos();
    }

    /**
     * Obtener estados de tarea disponibles
     */
    public function obtenerEstados() {
        return $this->actividadDAO->obtenerEstados();
    }
}