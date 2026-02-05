<?php
/**
 * Entidad Documento
 * Representa un documento asociado a un proyecto con soporte para categorías y archivos locales
 */
class Documento {
    private $id;
    private $proyecto_id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $url;
    private $ruta_archivo;
    private $tipo;
    private $usuario_id;
    private $tamaño_kb;
    private $fecha_subida;

    public function __construct($id = null, $proyecto_id = null, $categoria_id = null, $nombre = '', $descripcion = '', 
                                $url = '', $ruta_archivo = '', $tipo = '', $usuario_id = null, $tamaño_kb = 0, $fecha_subida = null) {
        $this->id = $id;
        $this->proyecto_id = $proyecto_id;
        $this->categoria_id = $categoria_id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->url = $url;
        $this->ruta_archivo = $ruta_archivo;
        $this->tipo = $tipo;
        $this->usuario_id = $usuario_id;
        $this->tamaño_kb = $tamaño_kb;
        $this->fecha_subida = $fecha_subida;
    }

    // Getters y Setters
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    
    public function getProyectoId() { return $this->proyecto_id; }
    public function setProyectoId($proyecto_id) { $this->proyecto_id = $proyecto_id; }
    
    public function getCategoriaId() { return $this->categoria_id; }
    public function setCategoriaId($categoria_id) { $this->categoria_id = $categoria_id; }
    
    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    
    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    
    public function getUrl() { return $this->url; }
    public function setUrl($url) { $this->url = $url; }
    
    public function getRutaArchivo() { return $this->ruta_archivo; }
    public function setRutaArchivo($ruta_archivo) { $this->ruta_archivo = $ruta_archivo; }
    
    public function getTipo() { return $this->tipo; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
    
    public function getUsuarioId() { return $this->usuario_id; }
    public function setUsuarioId($usuario_id) { $this->usuario_id = $usuario_id; }
    
    public function getTamañoKb() { return $this->tamaño_kb; }
    public function setTamañoKb($tamaño_kb) { $this->tamaño_kb = $tamaño_kb; }
    
    public function getFechaSubida() { return $this->fecha_subida; }
    public function setFechaSubida($fecha_subida) { $this->fecha_subida = $fecha_subida; }
}
