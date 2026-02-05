-- CONFIGURACIÓN INICIAL
-- Se crea la base de datos `gestion_clientes` con codificación UTF-8 para soportar caracteres especiales.
CREATE DATABASE gestion_clientes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_clientes;

-- TABLAS DEL SISTEMA
-- Tabla `Rol`: Define los roles disponibles en el sistema (Administrador, Vendedor, Supervisor).
CREATE TABLE Rol (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del rol
    nombre VARCHAR(50) NOT NULL UNIQUE -- Nombre del rol (debe ser único)
) ENGINE=InnoDB;

-- Tabla `Usuario`: Almacena información de los usuarios del sistema.
CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del usuario
    nombre VARCHAR(100) NOT NULL, -- Nombre completo del usuario
    email VARCHAR(100) NOT NULL UNIQUE, -- Correo electrónico único
    password VARCHAR(255) NOT NULL, -- Contraseña del usuario
    rol_id INT NOT NULL, -- ID del rol asignado al usuario
    activo BOOLEAN DEFAULT TRUE, -- Estado activo/inactivo del usuario
    intentos_fallidos INT DEFAULT 0, -- Número de intentos fallidos de inicio de sesión
    bloqueado BOOLEAN DEFAULT FALSE, -- Indica si la cuenta está bloqueada
    fecha_bloqueo TIMESTAMP NULL, -- Fecha y hora del bloqueo
    CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_id) REFERENCES Rol(id) ON UPDATE CASCADE -- Relación con la tabla `Rol`
) ENGINE=InnoDB;

-- Tabla `TipoCliente`: Define los tipos de clientes (Persona, Empresa).
CREATE TABLE TipoCliente (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del tipo de cliente
    nombre VARCHAR(50) NOT NULL UNIQUE -- Nombre del tipo de cliente
) ENGINE=InnoDB;

-- Tabla `Cliente`: Almacena información de los clientes.
CREATE TABLE Cliente (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del cliente
    nombre VARCHAR(200) NOT NULL, -- Nombre del cliente
    tipo_cliente_id INT NOT NULL, -- ID del tipo de cliente
    telefono VARCHAR(10), -- Teléfono del cliente
    email VARCHAR(100), -- Correo electrónico del cliente
    direccion TEXT, -- Dirección del cliente
    activo BOOLEAN DEFAULT TRUE, -- Estado activo/inactivo del cliente
    fecha_alta DATETIME DEFAULT CURRENT_TIMESTAMP, -- Fecha de alta del cliente
    CONSTRAINT fk_cliente_tipo FOREIGN KEY (tipo_cliente_id) REFERENCES TipoCliente(id) ON UPDATE CASCADE -- Relación con la tabla `TipoCliente`
) ENGINE=InnoDB;

-- Tabla `Contacto`: Almacena información de los contactos asociados a los clientes.
CREATE TABLE Contacto (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del contacto
    cliente_id INT NOT NULL, -- ID del cliente asociado
    nombre VARCHAR(100) NOT NULL, -- Nombre del contacto
    cargo VARCHAR(100), -- Cargo del contacto
    email VARCHAR(100), -- Correo electrónico del contacto
    telefono VARCHAR(20), -- Teléfono del contacto
    CONSTRAINT fk_contacto_cliente FOREIGN KEY (cliente_id) REFERENCES Cliente(id) ON DELETE CASCADE ON UPDATE CASCADE -- Relación con la tabla `Cliente`
) ENGINE=InnoDB;

-- Tabla `EstadoProyecto`: Define los estados posibles para un proyecto (En Proceso, Ganada, Perdida).
CREATE TABLE EstadoProyecto (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del estado
    nombre VARCHAR(50) NOT NULL UNIQUE -- Nombre del estado
) ENGINE=InnoDB;

-- Tabla `CategoriaDocumento`: Define las categorías de documentos
CREATE TABLE CategoriaDocumento (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único de la categoría
    nombre VARCHAR(100) NOT NULL UNIQUE, -- Nombre de la categoría (Especificación, Contrato, Manual, etc.)
    descripcion TEXT -- Descripción de la categoría
) ENGINE=InnoDB;

-- Tabla `Proyecto`: Almacena información sobre los proyectos de software.
CREATE TABLE Proyecto (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del proyecto
    cliente_id INT NOT NULL, -- ID del cliente asociado al proyecto
    estado_proyecto_id INT NOT NULL, -- ID del estado del proyecto
    monto DECIMAL(15, 2) DEFAULT 0, -- Monto potencial del proyecto
    descripcion TEXT, -- Descripción del proyecto
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora de creación del proyecto
    CONSTRAINT fk_proyecto_cliente FOREIGN KEY (cliente_id) REFERENCES Cliente(id) ON DELETE CASCADE ON UPDATE CASCADE, -- Relación con la tabla `Cliente`
    CONSTRAINT fk_proyecto_estado FOREIGN KEY (estado_proyecto_id) REFERENCES EstadoProyecto(id) ON UPDATE CASCADE -- Relación con la tabla `EstadoProyecto`
) ENGINE=InnoDB;

-- Tabla `Producto`: Almacena información sobre los productos o servicios ofrecidos.
CREATE TABLE Producto (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del producto
    nombre VARCHAR(200) NOT NULL, -- Nombre del producto
    descripcion TEXT, -- Descripción del producto
    precio DECIMAL(15, 2) DEFAULT 0, -- Precio del producto
    activo BOOLEAN DEFAULT TRUE -- Estado activo/inactivo del producto
) ENGINE=InnoDB;

-- Tabla `Documento`: Almacena documentos relacionados con los proyectos.
CREATE TABLE Documento (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del documento
    proyecto_id INT NOT NULL, -- ID del proyecto asociado
    categoria_id INT, -- ID de la categoría del documento
    nombre VARCHAR(200) NOT NULL, -- Nombre del documento
    descripcion TEXT, -- Descripción del documento
    url TEXT, -- URL si es archivo externo (opcional)
    ruta_archivo VARCHAR(500), -- Ruta local del archivo subido
    tipo VARCHAR(50), -- Tipo de documento (PDF, Word, Excel, etc.)
    usuario_id INT, -- ID del usuario que subió el documento
    tamaño_kb INT DEFAULT 0, -- Tamaño del archivo en KB
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora de subida del documento
    CONSTRAINT fk_doc_proyecto FOREIGN KEY (proyecto_id) REFERENCES Proyecto(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_doc_categoria FOREIGN KEY (categoria_id) REFERENCES CategoriaDocumento(id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_doc_usuario FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabla `EstadoTarea`: Define los estados posibles para una tarea.
CREATE TABLE EstadoTarea (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del estado
    nombre VARCHAR(50) NOT NULL UNIQUE -- Nombre del estado (Pendiente, En Progreso, Completada)
) ENGINE=InnoDB;

-- Tabla `TipoTarea`: Define los tipos de tareas que se pueden registrar.
CREATE TABLE TipoTarea (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único del tipo de tarea
    nombre VARCHAR(50) NOT NULL UNIQUE -- Nombre del tipo de tarea
) ENGINE=InnoDB;

-- Tabla `Tarea`: Almacena información sobre las tareas realizadas en el contexto de un proyecto.
CREATE TABLE Tarea (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único de la tarea
    proyecto_id INT NOT NULL, -- ID del proyecto asociado
    tipo_tarea_id INT NOT NULL, -- ID del tipo de tarea
    usuario_id INT, -- ID del usuario responsable de la tarea
    estado_tarea_id INT NOT NULL, -- ID del estado de la tarea
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora de la tarea
    descripcion TEXT, -- Descripción de la tarea
    CONSTRAINT fk_tarea_proyecto FOREIGN KEY (proyecto_id) REFERENCES Proyecto(id) ON DELETE CASCADE ON UPDATE CASCADE, -- Relación con la tabla `Proyecto`
    CONSTRAINT fk_tarea_tipo FOREIGN KEY (tipo_tarea_id) REFERENCES TipoTarea(id) ON UPDATE CASCADE, -- Relación con la tabla `TipoTarea`
    CONSTRAINT fk_tarea_usuario FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON UPDATE CASCADE, -- Relación con la tabla `Usuario`
    CONSTRAINT fk_tarea_estado FOREIGN KEY (estado_tarea_id) REFERENCES EstadoTarea(id) ON UPDATE CASCADE -- Relación con la tabla `EstadoTarea`
) ENGINE=InnoDB;

-- Tabla `SolicitudDesbloqueo`: Almacena las solicitudes de desbloqueo de cuentas de usuario.
CREATE TABLE SolicitudDesbloqueo (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único de la solicitud
    usuario_id INT NOT NULL, -- ID del usuario que solicita el desbloqueo
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha y hora de la solicitud
    estado ENUM('PENDIENTE', 'RESUELTO') DEFAULT 'PENDIENTE', -- Estado de la solicitud
    CONSTRAINT fk_solicitud_usuario FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE -- Relación con la tabla `Usuario`
) ENGINE=InnoDB;

-- 3. VISTAS
-- Vista `vista_usuarios_detallados`: Muestra información detallada de los usuarios junto con el nombre de su rol.
CREATE VIEW vista_usuarios_detallados AS SELECT u.*, r.nombre AS rol_nombre FROM Usuario u JOIN Rol r ON u.rol_id = r.id;

-- Vista `vista_clientes_detallados`: Muestra información detallada de los clientes junto con el tipo de cliente.
CREATE VIEW vista_clientes_detallados AS SELECT c.*, tc.nombre AS tipo_nombre FROM Cliente c JOIN TipoCliente tc ON c.tipo_cliente_id = tc.id;

-- Vista `vista_oportunidades_detalladas`: Muestra información detallada de los proyectos junto con el cliente y el estado del proyecto.
CREATE VIEW vista_oportunidades_detalladas AS SELECT o.*, c.nombre AS cliente_nombre, eo.nombre AS estado_nombre FROM Proyecto o JOIN Cliente c ON o.cliente_id = c.id JOIN EstadoProyecto eo ON o.estado_proyecto_id = eo.id;

-- Vista `vista_actividades_detalladas`: Muestra información detallada de las tareas junto con el tipo de tarea y usuario responsable.
CREATE VIEW vista_actividades_detalladas AS SELECT a.*, ta.nombre AS tipo_tarea, u.nombre AS usuario_nombre, et.nombre AS estado_tarea FROM Tarea a JOIN TipoTarea ta ON a.tipo_tarea_id = ta.id LEFT JOIN Usuario u ON a.usuario_id = u.id JOIN EstadoTarea et ON a.estado_tarea_id = et.id;

-- Vista `vista_contactos_detallados`: Muestra información detallada de los contactos junto con el cliente al que pertenecen.
CREATE VIEW vista_contactos_detallados AS SELECT con.*, c.nombre as cliente_nombre FROM Contacto con INNER JOIN Cliente c ON con.cliente_id = c.id;

-- 4. PROCEDIMIENTOS ALMACENADOS
DELIMITER //

-- USUARIOS Y SEGURIDAD
-- Procedimiento `sp_usuario_autenticar`: Autentica a un usuario basado en su correo electrónico.
CREATE PROCEDURE sp_usuario_autenticar(IN p_email VARCHAR(100))
BEGIN
    SELECT id, nombre, email, password, rol_id, activo, intentos_fallidos, bloqueado, fecha_bloqueo
    FROM Usuario
    WHERE email = p_email;
END //

-- Procedimiento `sp_usuario_registrar`: Registra un nuevo usuario en el sistema.
CREATE PROCEDURE sp_usuario_registrar(IN p_nom VARCHAR(100), IN p_email VARCHAR(100), IN p_pass VARCHAR(255), IN p_rol INT)
BEGIN INSERT INTO Usuario (nombre, email, password, rol_id) VALUES (p_nom, p_email, p_pass, p_rol); END //

-- Procedimiento `sp_usuario_listar`: Lista todos los usuarios registrados en el sistema.
CREATE PROCEDURE sp_usuario_listar() BEGIN SELECT * FROM vista_usuarios_detallados ORDER BY nombre; END //

-- Procedimiento `sp_usuario_obtener_uno`: Obtiene la información de un usuario específico por su ID.
CREATE PROCEDURE sp_usuario_obtener_uno(IN p_id INT) BEGIN SELECT * FROM Usuario WHERE id = p_id; END //

-- Procedimiento `sp_usuario_desbloquear`: Desbloquea una cuenta de usuario previamente bloqueada.
CREATE PROCEDURE sp_usuario_desbloquear(IN p_id INT)
BEGIN UPDATE Usuario SET bloqueado = FALSE, intentos_fallidos = 0, fecha_bloqueo = NULL WHERE id = p_id; END //

-- PRODUCTOS
-- Procedimiento `sp_producto_upsert`: Inserta o actualiza un producto en la base de datos.
CREATE PROCEDURE sp_producto_upsert(IN p_id INT, IN p_nom VARCHAR(200), IN p_desc TEXT, IN p_pre DECIMAL(15,2), IN p_act BOOLEAN)
BEGIN
    IF p_id = 0 THEN INSERT INTO Producto (nombre, descripcion, precio, activo) VALUES (p_nom, p_desc, p_pre, p_act);
    ELSE UPDATE Producto SET nombre = p_nom, descripcion = p_desc, precio = p_pre, activo = p_act WHERE id = p_id; END IF;
END //

-- Procedimiento `sp_producto_listar`: Lista todos los productos disponibles.
CREATE PROCEDURE sp_producto_listar() BEGIN SELECT * FROM Producto ORDER BY nombre; END //

-- Procedimiento `sp_producto_obtener_uno`: Obtiene la información de un producto específico por su ID.
CREATE PROCEDURE sp_producto_obtener_uno(IN p_id INT) BEGIN SELECT * FROM Producto WHERE id = p_id; END //

-- Procedimiento `sp_producto_eliminar`: Elimina un producto de la base de datos.
CREATE PROCEDURE sp_producto_eliminar(IN p_id INT) BEGIN DELETE FROM Producto WHERE id = p_id; END //

-- CLIENTES
-- Procedimiento `sp_cliente_guardar_completo`: Inserta o actualiza la información de un cliente.
CREATE PROCEDURE sp_cliente_guardar_completo(IN p_id INT, IN p_nom VARCHAR(200), IN p_tipo INT, IN p_tel VARCHAR(10), IN p_email VARCHAR(100), IN p_act BOOLEAN)
BEGIN
    IF p_id = 0 THEN INSERT INTO Cliente (nombre, tipo_cliente_id, telefono, email, activo) VALUES (p_nom, p_tipo, p_tel, p_email, p_act);
    ELSE UPDATE Cliente SET nombre = p_nom, tipo_cliente_id = p_tipo, telefono = p_tel, email = p_email, activo = p_act WHERE id = p_id; END IF;
END //

-- Procedimiento `sp_cliente_listar_todo`: Lista todos los clientes registrados.
CREATE PROCEDURE sp_cliente_listar_todo() BEGIN SELECT * FROM vista_clientes_detallados ORDER BY nombre; END //

-- Procedimiento `sp_cliente_obtener_uno`: Obtiene la información de un cliente específico por su ID.
CREATE PROCEDURE sp_cliente_obtener_uno(IN p_id INT) BEGIN SELECT * FROM Cliente WHERE id = p_id; END //

-- Procedimiento `sp_cliente_borrar`: Elimina un cliente de la base de datos.
CREATE PROCEDURE sp_cliente_borrar(IN p_id INT) BEGIN DELETE FROM Cliente WHERE id = p_id; END //

-- Procedimiento `sp_cliente_obtener_tipos`: Obtiene la lista de tipos de cliente disponibles.
CREATE PROCEDURE sp_cliente_obtener_tipos() BEGIN SELECT * FROM TipoCliente ORDER BY nombre; END //

-- OPORTUNIDADES (Proyectos)
-- Procedimiento `sp_oportunidad_registrar_completo`: Registra un nuevo proyecto de software.
CREATE PROCEDURE sp_oportunidad_registrar_completo(IN p_cli INT, IN p_est INT, IN p_mon DECIMAL(15,2), IN p_desc TEXT, IN p_fecha DATETIME)
BEGIN INSERT INTO Proyecto (cliente_id, estado_proyecto_id, monto, descripcion, fecha_hora) VALUES (p_cli, p_est, p_mon, p_desc, p_fecha); END //

-- Procedimiento `sp_oportunidad_actualizar_completo`: Actualiza la información de un proyecto existente.
CREATE PROCEDURE sp_oportunidad_actualizar_completo(IN p_id INT, IN p_cli INT, IN p_est INT, IN p_mon DECIMAL(15,2), IN p_desc TEXT, IN p_fecha DATETIME)
BEGIN UPDATE Proyecto SET cliente_id = p_cli, estado_proyecto_id = p_est, monto = p_mon, descripcion = p_desc, fecha_hora = p_fecha WHERE id = p_id; END //

-- Procedimiento `sp_oportunidad_listar`: Lista todos los proyectos registrados.
CREATE PROCEDURE sp_oportunidad_listar() BEGIN SELECT * FROM vista_oportunidades_detalladas; END //

-- Procedimiento `sp_oportunidad_obtener_uno`: Obtiene la información de un proyecto específico por su ID.
CREATE PROCEDURE sp_oportunidad_obtener_uno(IN p_id INT) BEGIN SELECT * FROM Proyecto WHERE id = p_id; END //

-- Procedimiento `sp_oportunidad_eliminar`: Elimina un proyecto de la base de datos.
CREATE PROCEDURE sp_oportunidad_eliminar(IN p_id INT) BEGIN DELETE FROM Proyecto WHERE id = p_id; END //

-- Procedimiento `sp_oportunidad_estados`: Obtiene la lista de estados de proyecto disponibles.
CREATE PROCEDURE sp_oportunidad_estados() BEGIN SELECT * FROM EstadoProyecto; END //

-- CONTACTOS
-- Procedimiento `sp_contacto_upsert`: Inserta o actualiza un contacto asociado a un cliente.
CREATE PROCEDURE sp_contacto_upsert(IN p_id INT, IN p_cli INT, IN p_nom VARCHAR(100), IN p_ema VARCHAR(100), IN p_tel VARCHAR(20), IN p_car VARCHAR(100))
BEGIN
    IF p_id = 0 THEN INSERT INTO Contacto (cliente_id, nombre, email, telefono, cargo) VALUES (p_cli, p_nom, COALESCE(p_ema, ''), p_tel, p_car);
    ELSE UPDATE Contacto SET nombre = p_nom, email = COALESCE(p_ema, ''), telefono = p_tel, cargo = p_car WHERE id = p_id; END IF;
END //

-- Procedimiento `sp_contacto_listar`: Lista todos los contactos registrados.
CREATE PROCEDURE sp_contacto_listar() BEGIN SELECT * FROM vista_contactos_detallados ORDER BY nombre; END //

-- Procedimiento `sp_contacto_obtener_uno`: Obtiene la información de un contacto específico por su ID.
CREATE PROCEDURE sp_contacto_obtener_uno(IN p_id INT) BEGIN SELECT * FROM Contacto WHERE id = p_id; END //

-- Procedimiento `sp_contacto_eliminar`: Elimina un contacto de la base de datos.
CREATE PROCEDURE sp_contacto_eliminar(IN p_id INT) BEGIN DELETE FROM Contacto WHERE id = p_id; END //

-- DOCUMENTOS
-- Procedimiento `sp_documento_registrar`: Registra un nuevo documento asociado a un proyecto.
CREATE PROCEDURE sp_documento_registrar(IN p_proy INT, IN p_cat INT, IN p_nom VARCHAR(200), IN p_desc TEXT, IN p_url TEXT, IN p_ruta VARCHAR(500), IN p_tip VARCHAR(50), IN p_usr INT, IN p_tam INT)
BEGIN INSERT INTO Documento (proyecto_id, categoria_id, nombre, descripcion, url, ruta_archivo, tipo, usuario_id, tamaño_kb) VALUES (p_proy, p_cat, p_nom, p_desc, p_url, p_ruta, p_tip, p_usr, p_tam); END //

-- Procedimiento `sp_documento_actualizar`: Actualiza la información de un documento existente.
CREATE PROCEDURE sp_documento_actualizar(IN p_id INT, IN p_proy INT, IN p_cat INT, IN p_nom VARCHAR(200), IN p_desc TEXT, IN p_url TEXT, IN p_ruta VARCHAR(500), IN p_tip VARCHAR(50))
BEGIN UPDATE Documento SET proyecto_id = p_proy, categoria_id = p_cat, nombre = p_nom, descripcion = p_desc, url = p_url, ruta_archivo = p_ruta, tipo = p_tip WHERE id = p_id; END //

-- Procedimiento `sp_documento_listar`: Lista todos los documentos registrados.
CREATE PROCEDURE sp_documento_listar()
BEGIN SELECT d.*, p.descripcion as proyecto_nombre, c.nombre as categoria_nombre, u.nombre as usuario_nombre FROM Documento d INNER JOIN Proyecto p ON d.proyecto_id = p.id LEFT JOIN CategoriaDocumento c ON d.categoria_id = c.id LEFT JOIN Usuario u ON d.usuario_id = u.id ORDER BY d.fecha_subida DESC; END //

-- Procedimiento `sp_documento_obtener_uno`: Obtiene la información de un documento específico por su ID.
CREATE PROCEDURE sp_documento_obtener_uno(IN p_id INT) BEGIN SELECT * FROM Documento WHERE id = p_id; END //

-- Procedimiento `sp_documento_eliminar`: Elimina un documento de la base de datos.
CREATE PROCEDURE sp_documento_eliminar(IN p_id INT) BEGIN DELETE FROM Documento WHERE id = p_id; END //

-- ACTIVIDADES (Tareas)
-- Procedimiento `sp_actividad_registrar`: Registra una nueva tarea asociada a un proyecto.
CREATE PROCEDURE sp_actividad_registrar(IN p_proy INT, IN p_tip INT, IN p_usr INT, IN p_est INT, IN p_desc TEXT)
BEGIN INSERT INTO Tarea (proyecto_id, tipo_tarea_id, usuario_id, estado_tarea_id, descripcion) VALUES (p_proy, p_tip, p_usr, p_est, p_desc); END //

-- Procedimiento `sp_actividad_actualizar`: Actualiza la información de una tarea existente.
CREATE PROCEDURE sp_actividad_actualizar(IN p_id INT, IN p_usr INT, IN p_est INT, IN p_desc TEXT)
BEGIN UPDATE Tarea SET usuario_id = p_usr, estado_tarea_id = p_est, descripcion = p_desc WHERE id = p_id; END //

-- Procedimiento `sp_actividad_listar`: Lista todas las tareas registradas.
CREATE PROCEDURE sp_actividad_listar() BEGIN SELECT * FROM vista_actividades_detalladas; END //

-- Procedimiento `sp_actividad_obtener`: Obtiene la información de una tarea específica por su ID.
CREATE PROCEDURE sp_actividad_obtener(IN p_id INT) BEGIN SELECT * FROM Tarea WHERE id = p_id; END //

-- Procedimiento `sp_actividad_eliminar`: Elimina una tarea de la base de datos.
CREATE PROCEDURE sp_actividad_eliminar(IN p_id INT) BEGIN DELETE FROM Tarea WHERE id = p_id; END //

-- Procedimiento `sp_actividad_tipos`: Obtiene la lista de tipos de tarea disponibles.
CREATE PROCEDURE sp_actividad_tipos() BEGIN SELECT * FROM TipoTarea ORDER BY nombre; END //

-- Procedimiento `sp_actividad_estados`: Obtiene la lista de estados de tarea disponibles.
CREATE PROCEDURE sp_actividad_estados() BEGIN SELECT * FROM EstadoTarea ORDER BY nombre; END //

-- Procedimientos para SolicitudDesbloqueo
-- Procedimiento `sp_registrar_solicitud_desbloqueo`: Registra una nueva solicitud de desbloqueo para un usuario.
CREATE PROCEDURE sp_registrar_solicitud_desbloqueo(IN p_usuario_id INT)
BEGIN
    INSERT INTO SolicitudDesbloqueo (usuario_id) VALUES (p_usuario_id);
END //

-- Procedimiento `sp_listar_solicitudes_desbloqueo`: Lista todas las solicitudes de desbloqueo registradas.
CREATE PROCEDURE sp_listar_solicitudes_desbloqueo()
BEGIN
    SELECT sd.id, u.nombre AS usuario_nombre, u.email, sd.fecha_solicitud, sd.estado
    FROM SolicitudDesbloqueo sd
    JOIN Usuario u ON sd.usuario_id = u.id
    ORDER BY sd.fecha_solicitud DESC;
END //

DELIMITER ;

-- 1. Roles
INSERT INTO Rol (nombre) VALUES 
('ADMINISTRADOR'),
('VENDEDOR'),
('SUPERVISOR');

-- 2. Tipos de Cliente
INSERT INTO TipoCliente (nombre) VALUES 
('PERSONA'),
('EMPRESA');

-- 3. Estados de Proyecto
INSERT INTO EstadoProyecto (nombre) VALUES 
('EN_PROCESO'),
('COMPLETADO'),
('CANCELADO');

-- 3.1 Categorías de Documento
INSERT INTO CategoriaDocumento (nombre, descripcion) VALUES 
('Especificación', 'Documentos de especificación técnica'),
('Contrato', 'Contratos y acuerdos'),
('Manual', 'Manuales de usuario y guías'),
('Diseño', 'Diseños UI/UX y diagramas'),
('Reporte', 'Reportes y análisis'),
('Otros', 'Otros documentos');

-- 4. Tipos de Tarea
INSERT INTO TipoTarea (nombre) VALUES 
('DESARROLLO'),
('DISEÑO'),
('PRUEBAS'),
('DOCUMENTACION');

-- 5. Estados de Tarea
INSERT INTO EstadoTarea (nombre) VALUES 
('PENDIENTE'),
('EN_PROGRESO'),
('COMPLETADA');

-- 5. Usuarios (Equipo de Desarrollo)
INSERT INTO Usuario (nombre, email, password, rol_id, activo) VALUES 
('Administrador', 'administrador@devsoftware.com', 'admin123', 1, TRUE),
('Daniel Soto', 'daniel.soto@devsoftware.com', 'dev123', 2, TRUE),
('Sofia Reyes', 'sofia.reyes@devsoftware.com', 'qa123', 3, TRUE),
('Lucas Fernández', 'lucas.fernandez@devsoftware.com', 'dev456', 2, TRUE),
('María Vázquez', 'maria.vazquez@devsoftware.com', 'devops123', 2, TRUE);

-- 6. Clientes (Empresas que solicitan software)
INSERT INTO Cliente (nombre, tipo_cliente_id, telefono, email, activo) VALUES 
('FinTech Innovations S.A.', 2, '0912345678', 'contacto@fintech-inn.com', TRUE),
('CloudSync Solutions', 2, '0987654321', 'info@cloudsync.com', TRUE),
('Retail Management Corp', 2, '0923456789', 'ventas@retailmgt.com', TRUE),
('Healthcare Systems', 2, '0934567890', 'contacto@healthsys.com', TRUE),
('Logistic Analytics Pro', 2, '0945678901', 'info@loganalytics.com', TRUE);

-- 7. Contactos (Responsables de Proyectos de Software)
INSERT INTO Contacto (cliente_id, nombre, cargo, email, telefono) VALUES 
(1, 'Patricia Gómez', 'CTO', 'patricia.gomez@fintech-inn.com', '0912345678'),
(1, 'Ricardo Santos', 'Product Manager', 'ricardo.santos@fintech-inn.com', '0912345679'),
(2, 'Elena Martínez', 'Directora de Desarrollo', 'elena.martinez@cloudsync.com', '0987654321'),
(3, 'Gabriela Ruiz', 'Product Owner', 'gabriela.ruiz@retailmgt.com', '0923456789'),
(4, 'Dr. Antonio Vega', 'Director de TI', 'antonio.vega@healthsys.com', '0934567890');

-- 8. registro de producto
INSERT INTO Producto (nombre, descripcion, precio, activo) VALUES
('Desarrollo de Aplicación Web Personalizada', 'Sitio o sistema web a medida con panel administrativo', 4800.00, TRUE),
('Desarrollo de Aplicación Móvil', 'App nativa o híbrida para Android e iOS', 9500.00, TRUE),
('Implementación de Sistema ERP Ligero', 'Gestión de inventarios, ventas y reportes básicos', 13800.00, TRUE),
('Paquete de Mantenimiento Mensual', 'Soporte técnico, actualizaciones y monitoreo', 750.00, TRUE),
('Diseño UI/UX + Prototipado Avanzado', 'Investigación, wireframes, prototipos interactivos en Figma', 3200.00, TRUE);

-- 9. registro de proyecto

INSERT INTO Proyecto (cliente_id, estado_proyecto_id, monto, descripcion, fecha_hora) VALUES
(1, 1,  9200.00, 'Plataforma de microcréditos digitales con scoring automático y panel para analistas', '2025-10-10 09:30:00'),
(2, 1, 16800.00, 'Migración y modernización de sistema de gestión documental a arquitectura serverless', '2025-11-05 11:15:00'),
(3, 2,  6800.00, 'Módulo de marketplace B2B con integración a sistema SAP existente', '2025-09-20 14:45:00'),
(4, 1, 22500.00, 'Sistema de gestión clínica electrónica con módulos de citas, historia y facturación', '2025-12-05 08:20:00'),
(5, 3,  4200.00, 'Desarrollo de dashboard analítico para cadena de suministro (proyecto cancelado)', '2025-10-25 17:10:00');

-- 10. tareas

INSERT INTO Tarea (proyecto_id, tipo_tarea_id, usuario_id, estado_tarea_id, descripcion) VALUES
(1, 2, 4, 2, 'Diseño de wireframes y flujos de usuario para el módulo de scoring crediticio'),
(1, 1, 2, 1, 'Implementación del backend - API REST para reglas de negocio y scoring'),
(2, 1, 5, 2, 'Configuración de entorno AWS Lambda + API Gateway para los nuevos microservicios'),
(2, 3, 3, 1, 'Preparación de casos de prueba automatizados para validación post-migración'),
(3, 1, 2, 3, 'Desarrollo e integración del módulo de cotizaciones y pedidos B2B'),
(4, 4, 3, 2, 'Elaboración de la documentación técnica de integración con estándares HL7'),
(4, 1, 4, 1, 'Desarrollo frontend React del módulo de agenda médica y citas'),
(5, 2, 4, 3, 'Prototipado inicial del dashboard de KPIs de logística (proyecto detenido)');


-- 11 documentos
INSERT INTO Documento (
    proyecto_id, 
    categoria_id, 
    nombre, 
    descripcion, 
    url, 
    ruta_archivo, 
    tipo, 
    usuario_id, 
    tamaño_kb
) VALUES
-- Proyecto 1
(1, 1, 'Especificación Funcional Scoring v1.3.pdf', 'Requisitos detallados del motor de evaluación crediticia', NULL, '/uploads/proy1/especificacion-scoring-v13.pdf', 'PDF', 2, 3120),
(1, 2, 'Propuesta Económica FinTech Oct-2025.pdf', 'Cotización oficial firmada por el cliente', NULL, '/uploads/proy1/propuesta-fintech-oct2025.pdf', 'PDF', 1, 1680),

-- Proyecto 2
(2, 4, 'Diagrama Arquitectura Serverless v2.png', 'Diagrama de componentes y flujo de datos actualizado', NULL, '/uploads/proy2/arquitectura-serverless-v2.png', 'PNG', 5, 450),
(2, 5, 'Matriz de Riesgos y Mitigación Migración.xlsx', 'Análisis de riesgos identificado en la migración', NULL, '/uploads/proy2/matriz-riesgos-migracion.xlsx', 'XLSX', 3, 890),

-- Proyecto 3
(3, 3, 'Guía de Usuario Marketplace B2B v1.0.pdf', 'Manual para administradores y compradores corporativos', NULL, '/uploads/proy3/guia-usuario-marketplace-v10.pdf', 'PDF', 4, 3850),

-- Proyecto 4
(4, 1, 'Especificaciones Integración HL7-FHIR v0.8.docx', 'Requisitos de interoperabilidad y mensajes esperados', NULL, '/uploads/proy4/especificaciones-hl7-fhir-v08.docx', 'DOCX', 2, 2100),
(4, 6, 'Acta de Reunión Inicial 05-Dic-2025.pdf', 'Minuta con acuerdos y alcance definido', NULL, '/uploads/proy4/acta-reunion-inicial.pdf', 'PDF', 1, 920),

-- Proyecto 5 (cancelado)
(5, 4, 'Prototipo Dashboard Logística Figma.link', 'Enlace al prototipo interactivo en Figma (versión preliminar)', 'https://www.figma.com/proto/abc123xyz', NULL, 'link', 4, 0);