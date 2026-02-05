// Arreglos donde se guardarán los datos cargados desde la API
let proyectos = []
let clientes = []
let estados = []

// ================================
// CARGAR CLIENTES
// ================================
async function cargarClientes() {
  try {
    const response = await fetch("api/clientes.php")
    clientes = await response.json()

    const select = document.getElementById("cliente_id")
    select.innerHTML = '<option value="">Seleccione un cliente</option>'

    clientes.forEach((cliente) => {
      select.innerHTML += `<option value="${cliente.id}">${cliente.nombre}</option>`
    })
  } catch (error) {
    console.error("Error al cargar clientes:", error)
  }
}

// ================================
// CARGAR ESTADOS DE PROYECTO
// ================================
async function cargarEstados() {
  try {
    const response = await fetch("api/oportunidades.php?action=estados")
    estados = await response.json()

    const select = document.getElementById("estado_proyecto_id")
    select.innerHTML = '<option value="">Seleccione estado</option>'

    estados.forEach((estado) => {
      select.innerHTML += `<option value="${estado.id}">${estado.nombre}</option>`
    })
  } catch (error) {
    console.error("Error al cargar estados:", error)
  }
}

// ================================
// CARGAR PROYECTOS
// ================================
async function cargarProyectos() {
  try {
    const response = await fetch("api/oportunidades.php")
    proyectos = await response.json()

    proyectos.sort((a, b) => a.id - b.id) // Ordenar por ID ascendente
    mostrarProyectos()
  } catch (error) {
    console.error("Error al cargar proyectos:", error)
    document.getElementById("tablaProyectos").innerHTML =
      '<tr><td colspan="6" class="text-center">Error al cargar datos</td></tr>'
  }
}

// ================================
// MOSTRAR PROYECTOS EN LA TABLA
// ================================
function mostrarProyectos() {
  const tbody = document.getElementById("tablaProyectos")

  if (proyectos.length === 0) {
    tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay proyectos registrados</td></tr>'
    return
  }

  tbody.innerHTML = proyectos
    .map((proyecto) => {
      const cliente = clientes.find((c) => c.id == proyecto.cliente_id)
      const estado = estados.find((e) => e.id == proyecto.estado_proyecto_id)

      return `
            <tr>
                <td>${proyecto.id}</td>
                <td>${cliente ? cliente.nombre : "N/A"}</td>
                <td>
                  <span class="badge badge-${
                    proyecto.estado_proyecto_id == 1
                      ? "blue"
                      : proyecto.estado_proyecto_id == 2
                      ? "green"
                      : "red"
                  }">
                    ${estado ? estado.nombre : "N/A"}
                  </span>
                </td>
                <td>$${Number.parseFloat(proyecto.monto).toFixed(2)}</td>
                <td>${proyecto.descripcion || "N/A"}</td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="editarProyecto(${proyecto.id})">Editar</button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarProyecto(${proyecto.id})">Eliminar</button>
                </td>
            </tr>
        `
    })
    .join("")
}

// ================================
// MOSTRAR FORMULARIO DE REGISTRO
// ================================
function mostrarFormulario(esNuevo = true) {
  document.getElementById("formularioProyecto").style.display = "block"
  
  // Solo limpiar si es un nuevo registro
  if (esNuevo) {
    document.getElementById("formProyecto").reset()
    document.getElementById("proyectoId").value = ""
  }
}

// Oculta el formulario
function ocultarFormulario() {
  document.getElementById("formularioProyecto").style.display = "none"
}

// ================================
// GUARDAR / EDITAR PROYECTO
// ================================
async function guardarProyecto(e) {
  e.preventDefault()

  const formData = new FormData(e.target)
  const data = Object.fromEntries(formData)

  try {
    const response = await fetch("api/oportunidades.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    })

    if (response.ok) {
      alert("Proyecto guardado exitosamente")
      ocultarFormulario()
      cargarProyectos()
    } else {
      alert("Error al guardar proyecto")
    }
  } catch (error) {
    console.error("Error:", error)
    alert("Error de conexión")
  }
}

// ================================
// ELIMINAR PROYECTO
// ================================
async function eliminarProyecto(id) {
  if (!confirm("¿Está seguro de eliminar este proyecto?")) return

  try {
    const response = await fetch(`api/oportunidades.php?id=${id}`, {
      method: "DELETE",
    })

    if (response.ok) {
      alert("Proyecto eliminado")
      cargarProyectos()
    } else {
      alert("Error al eliminar")
    }
  } catch (error) {
    console.error("Error:", error)
  }
}

// ================================
// EDITAR PROYECTO (CARGA EN FORMULARIO)
// ================================
function editarProyecto(id) {
  const proyecto = proyectos.find((p) => p.id == id)
  if (!proyecto) return

  document.getElementById("proyectoId").value = proyecto.id
  document.getElementById("cliente_id").value = proyecto.cliente_id
  document.getElementById("estado_proyecto_id").value = proyecto.estado_proyecto_id
  document.getElementById("monto").value = proyecto.monto
  document.getElementById("descripcion").value = proyecto.descripcion || ""

  mostrarFormulario(false)
}

// ================================
// CARGA INICIAL DE DATOS
// ================================
document.addEventListener("DOMContentLoaded", () => {
  cargarClientes()
  cargarEstados()
  cargarProyectos()
  
  // Registrar listener del formulario
  const formProyecto = document.getElementById("formProyecto")
  if (formProyecto) {
    formProyecto.addEventListener("submit", guardarProyecto)
  }
})
