<?php

require_once 'variables.php';

$conn = new mysqli($host, $userDb, $passDb);

// Verifica conexión
if ($conn->connect_error) {
    die('Conexión fallida: ' . $conn->connect_error);
}

if (isset($_GET['mode']) && $_GET['mode'] === 'reset') {
    $sql = "DROP DATABASE $nombreDb;";
    if ($conn->query($sql) === TRUE) {
        echo 'Base de datos eliminada correctamente.<br>';
    } else {
        echo 'Error al borrar la base de datos: ' . $conn->error . '<br>';
    }
}

// Crear base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS `$nombreDb` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
$conn->query($sql);

// Seleccionar base de datos
$conn->select_db($nombreDb);

// Crear tablas
$statements = [
    // Tabla cuentas
    "CREATE TABLE IF NOT EXISTS cuentas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        rol ENUM('ADMIN','CLIENTE','NEGOCIO') NOT NULL
    ) ENGINE=InnoDB;",

    // Tabla clientes
    "CREATE TABLE IF NOT EXISTS clientes (
        cuenta_id INT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        apellido1 VARCHAR(100) NOT NULL,
        apellido2 VARCHAR(100),
        telefono VARCHAR(20),
        permisos_informes BOOLEAN NOT NULL DEFAULT FALSE,
        FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",

    // Tabla negocios
    "CREATE TABLE IF NOT EXISTS negocios (
        cuenta_id INT PRIMARY KEY,
        nombre_comercial VARCHAR(100) NOT NULL,
        cuit VARCHAR(20),
        logo BLOB,
        permisos_terminos BOOLEAN NOT NULL DEFAULT FALSE,
        FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",

    // Tabla lavaderos
    "CREATE TABLE IF NOT EXISTS lavaderos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        negocio_id INT NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        direccion TEXT,
        latitud DECIMAL(9,6),
        longitud DECIMAL(9,6),
        hora_apertura TIME NOT NULL, 
        hora_cierre TIME NOT NULL,
        tiempo_reserva TINYINT NOT NULL CHECK (tiempo_reserva BETWEEN 1 AND 60),
        imagen BLOB,
        FOREIGN KEY (negocio_id) REFERENCES negocios(cuenta_id) ON DELETE CASCADE,
        CHECK (hora_apertura < hora_cierre)
    ) ENGINE=InnoDB;",

    // Tabla servicios
    "CREATE TABLE IF NOT EXISTS servicios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        lavadero_id INT NOT NULL,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        tipo ENUM('LAVADO','PRODUCTO_LIMPIEZA','ADORNO','RECAMBIO') NOT NULL,
        precio DECIMAL(10,2) NOT NULL CHECK (precio > 0),
        duracion_min SMALLINT,
        FOREIGN KEY (lavadero_id) REFERENCES lavaderos(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;",

    // Tabla reservas
    "CREATE TABLE IF NOT EXISTS reservas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_id INT NOT NULL,
        lavadero_id INT NOT NULL,
        fecha_reserva DATETIME NOT NULL,
        estado ENUM('PENDIENTE','EN_PROCESO','FINALIZADA','CANCELADA') NOT NULL,
        metodo_pago ENUM('EFECTIVO','ONLINE'),
        estado_pago ENUM('PAGADO','SIN_PAGAR'),
        fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (cliente_id) REFERENCES clientes(cuenta_id) ON DELETE CASCADE,
        FOREIGN KEY (lavadero_id) REFERENCES lavaderos(id) ON DELETE CASCADE,
        CHECK (NOT (estado_pago = 'PAGADO' AND estado = 'PENDIENTE'))
    ) ENGINE=InnoDB;",

    // Tabla intermedia reserva_servicios
    "CREATE TABLE IF NOT EXISTS reserva_servicios (
        reserva_id INT NOT NULL,
        servicio_id INT NOT NULL,
        cantidad SMALLINT NOT NULL DEFAULT 1,
        precio_unit DECIMAL(10,2) NOT NULL,
        PRIMARY KEY (reserva_id, servicio_id),
        FOREIGN KEY (reserva_id) REFERENCES reservas(id) ON DELETE CASCADE,
        FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;"
];

// Ejecutar las sentencias con feedback detallado
foreach ($statements as $index => $sql) {
    echo "<h4>🔄 Ejecutando sentencia #" . ($index + 1) . ":</h4><pre>$sql</pre>";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>✅ Sentencia #" . ($index + 1) . " ejecutada correctamente.</p><hr>";
    } else {
        echo "<p style='color:red;'>❌ Error en la sentencia #" . ($index + 1) . ":</p>";
        echo "<pre>" . $conn->error . "</pre><hr>";
    }
}

$conn->close();
?>