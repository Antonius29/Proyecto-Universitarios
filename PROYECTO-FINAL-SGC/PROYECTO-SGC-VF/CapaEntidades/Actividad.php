<?php
/**
 * Entidad Actividad (Tarea)
 * Representa una tarea asociada a un proyecto dentro del sistema.
 */
class Actividad {
    // Identificador único de la tarea
    private $id;

    // ID del proyecto al que pertenece la tarea
    private $proyecto_id;

    // ID del tipo de tarea (desarrollo, diseño, pruebas, documentación, etc.)
    private $tipo_tarea_id;

    // ID del usuario responsable de la tarea
    private $usuario_id;

    // ID del estado de la tarea (pendiente, en progreso, completada)
    private $estado_tarea_id;

    // Fecha y hora en que se realizará o realizó la tarea
    private $fecha_hora;

    // Descripción de la tarea
    private $descripcion;

    /**
     * Constructor de la clase Actividad (Tarea)
     * Permite inicializar la entidad con valores opcionales
     */
    public function __construct($id = null, $proyecto_id = null, $tipo_tarea_id = null, $usuario_id = null, $estado_tarea_id = null, $fecha_hora = null, $descripcion = '') {
        $this->id = $id;
        $this->proyecto_id = $proyecto_id;
        $this->tipo_tarea_id = $tipo_tarea_id;
        $this->usuario_id = $usuario_id;
        $this->estado_tarea_id = $estado_tarea_id;
        $this->fecha_hora = $fecha_hora;
        $this->descripcion = $descripcion;
    }

    // Getter para el ID
    public function getId() { return $this->id; }

    // Setter para el ID
    public function setId($id) { $this->id = $id; }
    
    // Getter del ID del proyecto
    public function getProyectoId() { return $this->proyecto_id; }

    // Setter del ID del proyecto
    public function setProyectoId($proyecto_id) { $this->proyecto_id = $proyecto_id; }
    
    // Getter del tipo de tarea
    public function getTipoTareaId() { return $this->tipo_tarea_id; }

    // Setter del tipo de tarea
    public function setTipoTareaId($tipo_tarea_id) { $this->tipo_tarea_id = $tipo_tarea_id; }
    
    // Getter del ID del usuario responsable
    public function getUsuarioId() { return $this->usuario_id; }

    // Setter del ID del usuario responsable
    public function setUsuarioId($usuario_id) { $this->usuario_id = $usuario_id; }
    
    // Getter del estado de la tarea
    public function getEstadoTareaId() { return $this->estado_tarea_id; }

    // Setter del estado de la tarea
    public function setEstadoTareaId($estado_tarea_id) { $this->estado_tarea_id = $estado_tarea_id; }
    
    // Getter de la fecha y hora
    public function getFechaHora() { return $this->fecha_hora; }

    // Setter de la fecha y hora
    public function setFechaHora($fecha_hora) { $this->fecha_hora = $fecha_hora; }
    
    // Getter de la descripción de la tarea
    public function getDescripcion() { return $this->descripcion; }

    // Setter de la descripción
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
}
