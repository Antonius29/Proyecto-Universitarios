// Estado global
let documentos = [];
let categorias = [];
let proyectos = [];

// Cargar categorías de documentos
async function cargarCategorias() {
    try {
        const response = await fetch('api/documentos.php?action=categorias');
        const resultado = await response.json();
        
        if (resultado.success) {
            categorias = resultado.data;
            
            // Llenar selector de categorías
            const select = document.getElementById('categoria_id');
            if (select) {
                select.innerHTML = '<option value="">Seleccione una categoría</option>';
                categorias.forEach(cat => {
                    select.innerHTML += `<option value="${cat.id}">${cat.nombre}</option>`;
                });
            }
            
            // Llenar botones de filtro
            const filtroContainer = document.getElementById('filtrosCategorias');
            if (filtroContainer) {
                filtroContainer.innerHTML = '<button class="btn btn-sm btn-outline-primary me-2" onclick="cargarDocumentos()">Todos</button>';
                categorias.forEach(cat => {
                    filtroContainer.innerHTML += `<button class="btn btn-sm btn-outline-primary me-2" onclick="filtrarPorCategoria(${cat.id})">${cat.nombre}</button>`;
                });
            }
        }
    } catch (error) {
        console.error('Error al cargar categorías:', error);
    }
}

// Cargar proyectos
async function cargarProyectos() {
    try {
        const response = await fetch('api/oportunidades.php?action=listar');
        const resultado = await response.json();
        
        if (resultado && resultado.length > 0) {
            proyectos = resultado;
        } else {
            const response2 = await fetch('api/oportunidades.php');
            proyectos = await response2.json();
        }
        
        const select = document.getElementById('proyecto_id');
        if (select) {
            select.innerHTML = '<option value="">Seleccione un proyecto</option>';
            proyectos.forEach(proy => {
                select.innerHTML += `<option value="${proy.id}">${proy.descripcion || `Proyecto ${proy.id}`}</option>`;
            });
        }
    } catch (error) {
        console.error('Error al cargar proyectos:', error);
    }
}

// Cargar documentos
async function cargarDocumentos(filtro = null) {
    try {
        let url = 'api/documentos.php?action=listar';
        
        if (filtro && filtro.tipo === 'categoria') {
            url = `api/documentos.php?action=porCategoria&categoria_id=${filtro.id}`;
        } else if (filtro && filtro.tipo === 'proyecto') {
            url = `api/documentos.php?action=porProyecto&proyecto_id=${filtro.id}`;
        }
        
        const response = await fetch(url);
        const resultado = await response.json();
        
        if (resultado.success) {
            documentos = Array.isArray(resultado.data) ? resultado.data : [];
        } else {
            documentos = [];
        }
        
        documentos.sort((a, b) => a.id - b.id); // Ordenar por ID ascendente
        mostrarDocumentos();
    } catch (error) {
        console.error('Error al cargar documentos:', error);
        documentos = [];
        mostrarDocumentos();
    }
}

// Mostrar documentos en tabla
function mostrarDocumentos() {
    const tbody = document.getElementById('tablaDocumentos');
    
    if (!tbody) return;
    
    if (documentos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No hay documentos registrados</td></tr>';
        return;
    }
    
    tbody.innerHTML = documentos.map(doc => {
        let archivoInfo = '-';
        if (doc.ruta_archivo) {
            const tamaño = doc.tamaño_kb ? (doc.tamaño_kb / 1024).toFixed(2) + ' MB' : 'N/A';
            const nombreArchivo = doc.ruta_archivo.split('_').pop();
            archivoInfo = `${nombreArchivo} <br><small style="color: #666;">${tamaño}</small>`;
        } else if (doc.url) {
            archivoInfo = '<strong style="color: #0066cc;">URL Externa</strong>';
        }
        
        return `
        <tr>
            <td>${doc.id}</td>
            <td>${doc.proyecto_nombre || `Proyecto ${doc.proyecto_id}`}</td>
            <td>${doc.categoria_nombre || 'Sin categoría'}</td>
            <td>${doc.nombre}</td>
            <td>${doc.descripcion || '-'}</td>
            <td>${doc.usuario_nombre || 'Sistema'}</td>
            <td>${archivoInfo}</td>
            <td>
                ${doc.ruta_archivo ? `<a href="api/documentos.php?action=descargar&id=${doc.id}" class="btn btn-sm btn-success" style="display: inline-block; line-height: 1;">Descargar</a>` : ''}
                <button class="btn btn-sm btn-primary" onclick="editarDocumento(${doc.id})">Editar</button>
                <button class="btn btn-sm btn-danger" onclick="eliminarDocumento(${doc.id})">Eliminar</button>
            </td>
        </tr>
    `;
    }).join('');
}

// Buscar documentos
async function buscarDocumentos() {
    const termino = document.getElementById('busqueda').value;
    
    if (!termino.trim()) {
        cargarDocumentos();
        return;
    }
    
    try {
        const response = await fetch(`api/documentos.php?action=buscar&q=${encodeURIComponent(termino)}`);
        const resultado = await response.json();
        
        if (resultado.success) {
            documentos = Array.isArray(resultado.data) ? resultado.data : [];
        }
        mostrarDocumentos();
    } catch (error) {
        console.error('Error al buscar:', error);
    }
}

// Filtrar por categoría
function filtrarPorCategoria(categoriaId) {
    cargarDocumentos({tipo: 'categoria', id: categoriaId});
}

// Mostrar formulario
function mostrarFormulario(esNuevo = true) {
    document.getElementById('formularioDocumento').style.display = 'block';
    
    // Solo limpiar si es un nuevo registro
    if (esNuevo) {
        document.getElementById('formDocumento').reset();
        document.getElementById('documentoId').value = '';
        document.getElementById('tituloFormulario').textContent = 'Nuevo Documento';
    }
}

// Ocultar formulario
function ocultarFormulario() {
    document.getElementById('formularioDocumento').style.display = 'none';
}

// Guardar documento
function guardarDocumento(e) {
    e.preventDefault();
    
    const documentoId = document.getElementById('documentoId').value;
    const proyecto_id = document.getElementById('proyecto_id').value;
    const categoria_id = document.getElementById('categoria_id').value;
    const nombre = document.getElementById('nombre').value;
    const descripcion = document.getElementById('descripcion').value;
    const url_externa = document.getElementById('url_externa').value;
    const archivoInput = document.getElementById('archivo');
    
    // Validaciones básicas
    if (!proyecto_id) {
        alert('El proyecto es obligatorio');
        return;
    }
    
    if (!nombre) {
        alert('El nombre del documento es obligatorio');
        return;
    }
    
    // Si es nuevo, debe tener archivo o URL
    if (!documentoId && !archivoInput.files.length && !url_externa) {
        alert('Debe seleccionar un archivo o proporcionar una URL externa');
        return;
    }
    
    const formData = new FormData();
    formData.append('proyecto_id', proyecto_id);
    formData.append('categoria_id', categoria_id);
    formData.append('nombre', nombre);
    formData.append('descripcion', descripcion);
    formData.append('url_externa', url_externa);
    
    // Solo agregar archivo si hay uno seleccionado
    if (archivoInput.files.length > 0) {
        formData.append('archivo', archivoInput.files[0]);
    }
    
    // ID si es actualización
    if (documentoId) {
        formData.append('id', documentoId);
    }
    
    const url = documentoId 
        ? `api/documentos.php?action=actualizar`
        : `api/documentos.php?action=crear`;
    
    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(resultado => {
        if (resultado.success) {
            alert(resultado.mensaje || 'Operación exitosa');
            ocultarFormulario();
            cargarDocumentos();
        } else {
            alert('Error: ' + (resultado.error || 'No se pudo procesar'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
}

// Editar documento
async function editarDocumento(id) {
    try {
        const response = await fetch(`api/documentos.php?action=obtener&id=${id}`);
        const resultado = await response.json();
        
        if (resultado.success && resultado.data) {
            const doc = resultado.data;
            
            document.getElementById('documentoId').value = doc.id;
            document.getElementById('proyecto_id').value = doc.proyecto_id;
            document.getElementById('categoria_id').value = doc.categoria_id || '';
            document.getElementById('nombre').value = doc.nombre;
            document.getElementById('descripcion').value = doc.descripcion || '';
            document.getElementById('tituloFormulario').textContent = 'Editar Documento';
            
            mostrarFormulario(false);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Eliminar documento
async function eliminarDocumento(id) {
    if (!confirm('¿Está seguro de eliminar este documento?')) return;
    
    try {
        const response = await fetch(`api/documentos.php?action=eliminar`, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
        });
        
        const resultado = await response.json();
        
        if (resultado.success) {
            alert('Documento eliminado');
            cargarDocumentos();
        } else {
            alert('Error: ' + resultado.error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    cargarCategorias();
    cargarProyectos();
    cargarDocumentos();
    
    // Registrar listener del formulario
    const formDocumento = document.getElementById('formDocumento');
    if (formDocumento) {
        formDocumento.addEventListener('submit', guardarDocumento);
    }
    
    // Búsqueda en tiempo real
    const busquedaInput = document.getElementById('busqueda');
    if (busquedaInput) {
        busquedaInput.addEventListener('keyup', buscarDocumentos);
    }
});
