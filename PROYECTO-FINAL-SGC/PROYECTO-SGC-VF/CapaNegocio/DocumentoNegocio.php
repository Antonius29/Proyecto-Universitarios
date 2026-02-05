<?php
require_once __DIR__ . '/../CapaDatos/DocumentoDAO.php';
require_once __DIR__ . '/../CapaEntidades/Documento.php';

/**
 * Capa de Negocio para Documento
 * Gestiona la lógica de negocio para documentos con soporte para archivos locales
 */
class DocumentoNegocio {
    private $documentoDAO;
    const DIRECTORIO_DOCUMENTOS = __DIR__ . '/../../documentos/';
    const TAMAÑO_MAX_MB = 50; // Tamaño máximo en MB

    public function __construct() {
        $this->documentoDAO = new DocumentoDAO();
        $this->crearDirectorioSiNoExiste();
    }

    /**
     * Crea el directorio de documentos si no existe
     */
    private function crearDirectorioSiNoExiste() {
        if (!is_dir(self::DIRECTORIO_DOCUMENTOS)) {
            mkdir(self::DIRECTORIO_DOCUMENTOS, 0755, true);
        }
    }

    /**
     * Crear un nuevo documento con archivo subido
     */
    public function crear($proyecto_id, $categoria_id, $nombre, $descripcion, $usuario_id, $archivo = null, $url_externa = null) {
        // Validaciones
        if (empty($nombre) || empty($proyecto_id)) {
            throw new Exception("El nombre del documento y el proyecto son obligatorios.");
        }

        $ruta_archivo = null;
        $tipo = 'Otros';
        $tamaño_kb = 0;

        // Si hay archivo subido
        if ($archivo && isset($archivo['tmp_name'])) {
            $this->validarArchivo($archivo);
            $ruta_archivo = $this->guardarArchivo($archivo);
            $tipo = $this->obtenerTipoDocumento($archivo['name']);
            $tamaño_kb = intval($archivo['size'] / 1024);
        }

        // Crear la entidad
        $documento = new Documento(
            null,
            $proyecto_id,
            $categoria_id,
            $nombre,
            $descripcion,
            $url_externa,
            $ruta_archivo,
            $tipo,
            $usuario_id,
            $tamaño_kb,
            null
        );

        return $this->documentoDAO->crear($documento);
    }

    /**
     * Valida el archivo subido
     */
    private function validarArchivo($archivo) {
        $tamaño_max_bytes = self::TAMAÑO_MAX_MB * 1024 * 1024;
        
        if ($archivo['size'] > $tamaño_max_bytes) {
            throw new Exception("El archivo es muy grande. Máximo: " . self::TAMAÑO_MAX_MB . "MB");
        }

        $tipos_permitidos = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'zip'];
        $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext, $tipos_permitidos)) {
            throw new Exception("Tipo de archivo no permitido: $ext");
        }
    }

    /**
     * Guarda el archivo en el servidor
     */
    private function guardarArchivo($archivo) {
        $nombre_original = basename($archivo['name']);
        $ext = pathinfo($nombre_original, PATHINFO_EXTENSION);
        $nombre_nuevo = uniqid('doc_') . '_' . time() . '.' . $ext;
        $ruta_destino = self::DIRECTORIO_DOCUMENTOS . $nombre_nuevo;

        if (!move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
            throw new Exception("Error al guardar el archivo.");
        }

        return $nombre_nuevo;
    }

    /**
     * Obtiene el tipo de documento del archivo
     */
    private function obtenerTipoDocumento($nombre_archivo) {
        $ext = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
        
        $tipos = [
            'pdf' => 'PDF',
            'doc' => 'Word',
            'docx' => 'Word',
            'xls' => 'Excel',
            'xlsx' => 'Excel',
            'ppt' => 'PowerPoint',
            'pptx' => 'PowerPoint',
            'jpg' => 'Image',
            'jpeg' => 'Image',
            'png' => 'Image',
            'gif' => 'Image',
            'txt' => 'Texto',
            'zip' => 'Comprimido'
        ];

        return $tipos[$ext] ?? 'Otros';
    }

    /**
     * Lista todos los documentos
     */
    public function listar() {
        return $this->documentoDAO->listar();
    }

    /**
     * Obtiene documentos por proyecto
     */
    public function obtenerPorProyecto($proyecto_id) {
        if (empty($proyecto_id)) {
            throw new Exception("ID de proyecto no proporcionado.");
        }
        return $this->documentoDAO->obtenerPorProyecto($proyecto_id);
    }

    /**
     * Busca documentos por nombre
     */
    public function buscar($nombre) {
        if (empty($nombre)) {
            throw new Exception("Término de búsqueda no proporcionado.");
        }
        return $this->documentoDAO->buscarPorNombre($nombre);
    }

    /**
     * Obtiene documentos por categoría
     */
    public function obtenerPorCategoria($categoria_id) {
        return $this->documentoDAO->obtenerPorCategoria($categoria_id);
    }

    /**
     * Obtiene un documento por ID
     */
    public function obtenerPorId($id) {
        if (empty($id)) {
            throw new Exception("ID de documento no proporcionado.");
        }
        return $this->documentoDAO->obtenerPorId($id);
    }

    /**
     * Actualiza un documento
     */
    public function actualizar($id, $proyecto_id, $categoria_id, $nombre, $descripcion) {
        if (empty($id) || empty($nombre)) {
            throw new Exception("ID y nombre son requeridos para actualizar.");
        }

        $documento = new Documento(
            $id,
            $proyecto_id,
            $categoria_id,
            $nombre,
            $descripcion,
            null,
            null,
            null,
            null,
            0,
            null
        );

        return $this->documentoDAO->actualizar($documento);
    }

    /**
     * Elimina un documento y su archivo
     */
    public function eliminar($id) {
        if (empty($id)) {
            throw new Exception("ID inválido para eliminar.");
        }

        // Obtener documento para acceder a la ruta
        $documento = $this->obtenerPorId($id);
        
        if ($documento && !empty($documento['ruta_archivo'])) {
            $ruta = self::DIRECTORIO_DOCUMENTOS . $documento['ruta_archivo'];
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }

        return $this->documentoDAO->eliminar($id);
    }

    /**
     * Obtiene todas las categorías
     */
    public function obtenerCategorias() {
        return $this->documentoDAO->obtenerCategorias();
    }

    /**
     * Genera una URL segura para descargar un documento
     */
    public function generarURLDescarga($id) {
        return "api/documentos.php?action=descargar&id=" . $id;
    }
}
