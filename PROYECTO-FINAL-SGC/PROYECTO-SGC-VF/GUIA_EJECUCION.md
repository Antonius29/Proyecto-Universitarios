# Guía de Ejecución del Proyecto

## Requisitos Previos

Antes de ejecutar el proyecto, asegúrate de tener instalado:

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Un servidor web (Apache, Nginx o similar)
- Un navegador web actualizado (Chrome, Firefox, Edge, Safari)
- Git (opcional, para clonar el repositorio)

## Paso 1: Preparar el Entorno

### 1.1 Instalar XAMPP (recomendado para Windows)

1. Descarga XAMPP desde https://www.apachefriends.org/
2. Ejecuta el instalador y sigue las instrucciones
3. Instala Apache y MySQL
4. Inicia los servicios desde el panel de control

### 1.2 Configurar la Base de Datos

1. Abre phpMyAdmin en http://localhost/phpmyadmin
2. Crea una nueva base de datos llamada "sgc_db"
3. Selecciona la base de datos
4. Ve a la pestaña "SQL"
5. Copia el contenido del archivo "scripts/bd_clientes.sql"
6. Pega el SQL y haz clic en ejecutar

Esto creará automáticamente:
- Todas las tablas necesarias
- Las vistas requeridas
- Los procedimientos almacenados
- Los datos de ejemplo

### 1.3 Configurar la Conexión a la Base de Datos

1. Abre el archivo CapaPresentacion/config.php
2. Verifica que los datos de conexión sean correctos:
   - Host: localhost
   - Usuario: root
   - Contraseña: (vacía por defecto en XAMPP)
   - Base de datos: sgc_db

## Paso 2: Colocar los Archivos del Proyecto

1. Navega a la carpeta htdocs de XAMPP (C:\xampp\htdocs en Windows)
2. Crea una carpeta llamada "sgc" o copia los archivos del proyecto
3. Asegúrate que la estructura sea:
   ```
   C:\xampp\htdocs\sgc\
   ├── CapaDatos\
   ├── CapaEntidades\
   ├── CapaExcepciones\
   ├── CapaNegocio\
   ├── CapaPresentacion\
   ├── scripts\
   └── ... otros archivos
   ```

## Paso 3: Iniciar el Sistema

### Opción A: Usando XAMPP Control Panel

1. Abre XAMPP Control Panel
2. Inicia Apache
3. Inicia MySQL
4. Abre tu navegador
5. Ve a http://localhost/sgc/CapaPresentacion/index.html

### Opción B: Usando Terminal/CMD

1. Abre terminal o CMD
2. Navega a la carpeta del proyecto
3. Si tienes PHP instalado globalmente, ejecuta:
   ```
   php -S localhost:8000
   ```
4. Abre http://localhost:8000/CapaPresentacion/index.html

### Opción C: Ejecutar los Scripts Proporcionados

En Windows:
1. Doble clic en "iniciar_servidor.bat"
2. El servidor se iniciará automáticamente

En Linux/Mac:
1. Abre terminal
2. Ve a la carpeta del proyecto
3. Ejecuta: chmod +x iniciar_servidor.sh
4. Ejecuta: ./iniciar_servidor.sh

## Paso 4: Acceder al Sistema

1. Abre tu navegador web
2. Ve a http://localhost/sgc/CapaPresentacion/index.html
3. Verás la pantalla de login
4. Usa las credenciales de prueba:

   Usuario: admin@sistema.com
   Contraseña: admin123

   O cualquiera de estos usuarios:
   - daniel.soto@devsoftware.com / dev123
   - sofia.reyes@devsoftware.com / qa123
   - lucas.fernandez@devsoftware.com / dev456
   - maria.vazquez@devsoftware.com / devops123

## Paso 5: Explorar el Sistema

Una vez dentro del sistema, podrás:

1. Ver el Dashboard con información general
2. Navegar por los diferentes módulos:
   - Clientes: Gestiona empresas clientes
   - Equipo: Gestiona contactos de clientes
   - Proyectos: Crea y da seguimiento a proyectos
   - Tareas: Asigna y completa tareas
   - Productos: Catálogo de servicios
   - Documentos: Sube y descarga archivos

## Solución de Problemas

### Problema: Error de conexión a la base de datos

Solución:
- Verifica que MySQL esté corriendo
- Comprueba las credenciales en config.php
- Asegúrate de que la base de datos "sgc_db" existe

### Problema: Página en blanco

Solución:
- Verifica que Apache esté corriendo
- Comprueba que PHP está habilitado
- Revisa el error log de Apache

### Problema: No puedo subir documentos

Solución:
- Verifica que la carpeta "uploads" existe
- Comprueba los permisos de carpeta (755)
- Verifica que el tamaño máximo de subida esté configurado correctamente en php.ini

### Problema: Las sesiones se cierran

Solución:
- Verifica que las cookies estén habilitadas en el navegador
- Comprueba la configuración de sesión en php.ini

### Problema: Datos no se guardan

Solución:
- Verifica conexión a base de datos
- Comprueba permisos de usuario en MySQL
- Revisa los logs de error en el navegador (F12)

## Arquitectura de Carpetas

```
sgc/
├── CapaDatos/              - Acceso a datos (DAO)
├── CapaEntidades/          - Entidades/Modelos
├── CapaExcepciones/        - Excepciones personalizadas
├── CapaNegocio/            - Lógica de negocio
├── CapaPresentacion/       - Interfaz de usuario
│   ├── api/               - Endpoints API
│   ├── auth/              - Autenticación
│   ├── css/               - Estilos
│   ├── js/                - JavaScript
│   └── *.php              - Páginas principales
├── scripts/                - SQL de base de datos
├── documentacion/          - Documentos del proyecto
└── README.md               - Este archivo
```

## Puertos Utilizados

- Apache: 80 (HTTP) o 8000 (si usas php -S)
- MySQL: 3306
- phpMyAdmin: http://localhost/phpmyadmin

## Archivos Importantes

- config.php: Configuración de conexión a BD
- index.html: Página de login
- dashboard.php: Panel principal después del login
- scripts/bd_clientes.sql: Script de base de datos

## Próximos Pasos

1. Leer el archivo ACERCA_DEL_PROYECTO.md para entender la funcionalidad
2. Consultar PLAN_DE_PRUEBAS.md para validar todas las características
3. Revisar CAMBIOS_REALIZADOS.md para ver las modificaciones recientes
4. Explorar los módulos y crear datos de prueba propios

## Soporte

Si encuentras problemas:
1. Verifica los logs en la consola del navegador (F12)
2. Revisa el error log de Apache
3. Consulta phpMyAdmin para verificar la base de datos
4. Intenta en un navegador diferente
