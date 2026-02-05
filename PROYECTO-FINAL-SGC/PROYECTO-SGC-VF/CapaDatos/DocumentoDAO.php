<?php
require_once __DIR__ . '/Conexion.php';
require_once __DIR__ . '/../CapaEntidades/Documento.php';

/**
 * DAO para Documento
 * Gestiona la subida, descarga y búsqueda de documentos
 */
class DocumentoDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion();
    }

    /**
     * Registra un nuevo documento
     */
    public function crear(Documento $documento) {
        $sql = "CALL sp_documento_registrar(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            $documento->getProyectoId(),
            $documento->getCategoriaId(),
            $documento->getNombre(),
            $documento->getDescripcion(),
            $documento->getUrl(),
            $documento->getRutaArchivo(),
            $documento->getTipo(),
            $documento->getUsuarioId(),
            $documento->getTamañoKb()
        ]);
    }

    /**
     * Lista todos los documentos
     */
    public function listar() {
        $sql = "CALL sp_documento_listar()";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene documentos por proyecto
     */
    public function obtenerPorProyecto($proyectoId) {
        $sql = "SELECT d.*, c.nombre as categoria_nombre, u.nombre as usuario_nombre, p.descripcion as proyecto_nombre
                FROM Documento d 
                LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id
                LEFT JOIN Usuario u ON d.usuario_id = u.id
                LEFT JOIN Proyecto p ON d.proyecto_id = p.id
                WHERE d.proyecto_id = ? 
                ORDER BY d.fecha_subida DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$proyectoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene documentos por categoría
     */
    public function obtenerPorCategoria($categoriaId) {
        $sql = "SELECT d.*, c.nombre as categoria_nombre, u.nombre as usuario_nombre, p.descripcion as proyecto_nombre
                FROM Documento d 
                LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id
                LEFT JOIN Usuario u ON d.usuario_id = u.id
                LEFT JOIN Proyecto p ON d.proyecto_id = p.id
                WHERE d.categoria_id = ? 
                ORDER BY d.fecha_subida DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$categoriaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca documentos por nombre
     */
    public function buscarPorNombre($nombre) {
        $nombre = "%$nombre%";
        $sql = "SELECT d.*, c.nombre as categoria_nombre, u.nombre as usuario_nombre, p.descripcion as proyecto_nombre
                FROM Documento d 
                LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id
                LEFT JOIN Usuario u ON d.usuario_id = u.id
                LEFT JOIN Proyecto p ON d.proyecto_id = p.id
                WHERE d.nombre LIKE ? OR d.descripcion LIKE ?
                ORDER BY d.fecha_subida DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$nombre, $nombre]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un documento por ID
     */
    public function obtenerPorId($id) {
        $sql = "CALL sp_documento_obtener_uno(?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza un documento
     */
    public function actualizar(Documento $documento) {
        $sql = "CALL sp_documento_actualizar(?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            $documento->getId(),
            $documento->getProyectoId(),
            $documento->getCategoriaId(),
            $documento->getNombre(),
            $documento->getDescripcion(),
            $documento->getUrl(),
            $documento->getRutaArchivo(),
            $documento->getTipo()
        ]);
    }

    /**
     * Elimina un documento
     */
    public function eliminar($id) {
        $sql = "CALL sp_documento_eliminar(?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Obtiene todas las categorías de documentos
     */
    public function obtenerCategorias() {
        $sql = "SELECT * FROM CategoriaDocumento ORDER BY nombre";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
