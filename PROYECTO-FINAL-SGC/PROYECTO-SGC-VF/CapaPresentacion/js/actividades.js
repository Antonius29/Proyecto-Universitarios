let tareas = []
let proyectos = []
let usuarios = []
let tiposTarea = []
let estadosTarea = []

// =============================
// Cargar proyectos desde API
// =============================
async function cargarProyectos() {
  try {
    const response = await fetch("api/oportunidades.php")
    proyectos = await response.json()

    const select = document.getElementById("proyecto_id")
    select.innerHTML = '<option value="">Seleccione un proyecto</option>'

    proyectos.forEach((proy) => {
      select.innerHTML += `<option value="${proy.id}">${proy.descripcion || `Proyecto ${proy.id}`}</option>`
    })
  } catch (error) {
    console.error("Error al cargar proyectos:", error)
  }
}

// =============================
// Cargar usuarios desde API
// =============================
async function cargarUsuarios() {
  try {
    const response = await fetch("api/clientes.php?type=usuarios")
    usuarios = await response.json()

    const select = document.getElementById("usuario_id")
    select.innerHTML = '<option value="">Seleccione usuario</option>'

    usuarios.forEach((usuario) => {
      select.innerHTML += `<option value="${usuario.id}">${usuario.nombre}</option>`
    })
  } catch (error) {
    console.error("Error al cargar usuarios:", error)
  }
}

// =============================
// Cargar tipos de tarea
// =============================
async function cargarTiposTarea() {
  try {
    const response = await fetch("api/actividades.php?action=tipos")
    tiposTarea = await response.json()

    const select = document.getElementById("tipo_tarea_id")
    select.innerHTML = '<option value="">Seleccione tipo</option>'

    tiposTarea.forEach((tipo) => {
      select.innerHTML += `<option value="${tipo.id}">${tipo.nombre}</option>`
    })
  } catch (error) {
    console.error("Error al cargar tipos de tarea:", error)
  }
}

// =============================
// Cargar estados de tarea
// =============================
async function cargarEstadosTarea() {
  try {
    const response = await fetch("api/actividades.php?action=estados")
    estadosTarea = await response.json()

    const select = document.getElementById("estado_tarea_id")
    select.innerHTML = '<option value="">Seleccione estado</option>'

    estadosTarea.forEach((estado) => {
      select.innerHTML += `<option value="${estado.id}">${estado.nombre}</option>`
    })
  } catch (error) {
    console.error("Error al cargar estados de tarea:", error)
  }
}

// =============================
// Cargar tareas desde API
// =============================
async function cargarTareas() {
  try {
    const response = await fetch("api/actividades.php")
    tareas = await response.json()
    tareas.sort((a, b) => a.id - b.id) // Ordenar por ID ascendente
    mostrarTareas()
  } catch (error) {
    console.error("Error al cargar tareas:", error)
    document.getElementById("tablaTareas").innerHTML =
      '<tr><td colspan="7" class="text-center">Error al cargar datos</td></tr>'
  }
}

// =============================
// Mostrar tareas en tabla
// =============================
function mostrarTareas() {
  const tbody = document.getElementById("tablaTareas")

  if (tareas.length === 0) {
    tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay tareas registradas</td></tr>'
    return
  }

  tbody.innerHTML = tareas
    .map((tarea) => {
      const proyecto = proyectos.find((p) => p.id == tarea.proyecto_id)
      const usuario = usuarios.find((u) => u.id == tarea.usuario_id)
      const estado = estadosTarea.find((e) => e.id == tarea.estado_tarea_id)
      const tipo = tiposTarea.find((t) => t.id == tarea.tipo_tarea_id)

      return `
            <tr>
                <td>${tarea.id}</td>
                <td>
                  <strong>${proyecto ? proyecto.descripcion : "N/A"}</strong>
                  <br><small>${proyecto ? proyecto.cliente_nombre : ""}</small>
                </td>
                <td><span class="badge badge-blue">${tipo ? tipo.nombre : "N/A"}</span></td>
                <td>${usuario ? usuario.nombre : "N/A"}</td>
                <td><span class="badge badge-${
                  tarea.estado_tarea_id == 1
                    ? "yellow"
                    : tarea.estado_tarea_id == 2
                    ? "blue"
                    : "green"
                }">${estado ? estado.nombre : "N/A"}</span></td>
                <td>${tarea.descripcion || "N/A"}</td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="editarTarea(${tarea.id})">Editar</button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarTarea(${tarea.id})">Eliminar</button>
                </td>
            </tr>
        `
    })
    .join("")
}

// =============================
// Mostrar formulario
// =============================
function mostrarFormulario(esNuevo = true) {
  document.getElementById("formularioTarea").style.display = "block"
  
  // Solo limpiar si es un nuevo registro
  if (esNuevo) {
    document.getElementById("formTarea").reset()
    document.getElementById("tareaId").value = ""
  }
}

// Oculta el formulario
function ocultarFormulario() {
  document.getElementById("formularioTarea").style.display = "none"
}

// ============================================================
// Evento de submit del formulario
// ============================================================
async function guardarTarea(e) {
  e.preventDefault()

  const formData = new FormData(e.target)
  const data = Object.fromEntries(formData)

  try {
    const response = await fetch("api/actividades.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    })

    if (response.ok) {
      alert("Tarea guardada exitosamente")
      ocultarFormulario()
      cargarTareas()
    } else {
      alert("Error al guardar tarea")
    }
  } catch (error) {
    console.error("Error:", error)
    alert("Error de conexión")
  }
}

// =============================
// Eliminar una tarea
// =============================
async function eliminarTarea(id) {
  if (!confirm("¿Está seguro de eliminar esta tarea?")) return

  try {
    const response = await fetch(`api/actividades.php?id=${id}`, {
      method: "DELETE",
    })

    if (response.ok) {
      alert("Tarea eliminada")
      cargarTareas()
    } else {
      alert("Error al eliminar")
    }
  } catch (error) {
    console.error("Error:", error)
  }
}

// =============================
// Editar una tarea
// =============================
function editarTarea(id) {
  const tarea = tareas.find((t) => t.id == id)
  if (!tarea) return

  document.getElementById("tareaId").value = tarea.id
  document.getElementById("proyecto_id").value = tarea.proyecto_id
  document.getElementById("tipo_tarea_id").value = tarea.tipo_tarea_id
  document.getElementById("usuario_id").value = tarea.usuario_id
  document.getElementById("estado_tarea_id").value = tarea.estado_tarea_id
  document.getElementById("descripcion").value = tarea.descripcion || ""

  mostrarFormulario(false)
}

// =============================
// Cargar datos iniciales
// =============================
document.addEventListener("DOMContentLoaded", () => {
  cargarProyectos()
  cargarUsuarios()
  cargarTiposTarea()
  cargarEstadosTarea()
  cargarTareas()
  
  // Registrar listener del formulario
  const formTarea = document.getElementById("formTarea")
  if (formTarea) {
    formTarea.addEventListener("submit", guardarTarea)
  }
})
