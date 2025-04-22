<?php

    require_once 'variables.php';

    $conn = new mysqli($host, $userDb, $passDb);

    // Verifica conexión
    if ($conn->connect_error) {
        die('Conexión fallida: ' . $conn->connect_error);
    }

    if (isset($_GET['mode']) && $_GET['mode'] === 'reset' ) {
        $sql = "DROP DATABASE $nombreDb;";
        if ($conn->query($sql) === TRUE) {
            echo 'Tabla eliminada correctamente.<br>';
        } else {
            echo 'Error al borrar la DATABSE: ' . $conn->error . '<br>';
        }
    }

    // Crear base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS $nombreDb";
    $conn->query($sql);

    // Seleccionar base de datos
    $conn->select_db($nombreDb);

    // Crear tablas (con comillas simples y protección contra duplicación)
    $tables = [
        'CREATE TABLE IF NOT EXISTS CUENTAS (
            EMAIL VARCHAR(100) PRIMARY KEY,
            PASSWORD VARCHAR(255),
            FECHA_REGISTRO DATE
        )',

        'CREATE TABLE IF NOT EXISTS CLIENTES (
            EMAIL VARCHAR(100) PRIMARY KEY,
            NOMBRE VARCHAR(50),
            APELLIDO1 VARCHAR(50),
            APELLIDO2 VARCHAR(50),
            IMAGEN TEXT, -- URL de imagen (por ejemplo, subida a MinIO)
            PERMISOS_INFORMES BOOLEAN,
            PERMISOS_TERMINOS BOOLEAN,
            FOREIGN KEY (EMAIL) REFERENCES CUENTAS(EMAIL)
        )',

        'CREATE TABLE IF NOT EXISTS ADMIN (
            EMAIL VARCHAR(100) PRIMARY KEY,
            TIPO VARCHAR(50),
            FOREIGN KEY (EMAIL) REFERENCES CUENTAS(EMAIL)
        )',

        'CREATE TABLE IF NOT EXISTS LAVADEROS (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            LOGO TEXT, -- URL del logo
            NOMBRE_PÚBLICO VARCHAR(100),
            PERMISOS_TERMINOS BOOLEAN
        )',

        'CREATE TABLE IF NOT EXISTS LOCALES (
            ID_LOCAL INT AUTO_INCREMENT PRIMARY KEY,
            EMAIL VARCHAR(100),
            LATITUD FLOAT,
            LONGITUD FLOAT,
            APERTURA TIME,
            CIERRE TIME,
            NOMBRE_LOCAL VARCHAR(100),
            IMAGEN TEXT, -- URL de imagen
            TIEMPO_LIMITE_RESERVA INT,
            ID_LAVADERO INT,
            FOREIGN KEY (ID_LAVADERO) REFERENCES LAVADEROS(ID)
        )',

        'CREATE TABLE IF NOT EXISTS RESERVAS (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            EMAIL VARCHAR(100),
            ID_LOCAL INT,
            FECHA_RESERVA DATE,
            ESTADO VARCHAR(50),
            METODO_PAGO VARCHAR(50),
            FECHA_REGISTRO DATE,
            FOREIGN KEY (EMAIL) REFERENCES CLIENTES(EMAIL),
            FOREIGN KEY (ID_LOCAL) REFERENCES LOCALES(ID_LOCAL)
        )',

        'CREATE TABLE IF NOT EXISTS SERVICIOS (
            ID_SERVICIO INT AUTO_INCREMENT PRIMARY KEY,
            ID_LOCAL INT,
            TIPO VARCHAR(50),
            EMAIL VARCHAR(100),
            PRECIO DECIMAL(10,2),
            DESCRIPCION TEXT,
            NOMBRE VARCHAR(100),
            FOREIGN KEY (ID_LOCAL) REFERENCES LOCALES(ID_LOCAL)
        )',

        'CREATE TABLE IF NOT EXISTS RESERVAS_SERVICIOS (
            ID_RESERVA INT,
            ID_SERVICIO INT,
            PRIMARY KEY (ID_RESERVA, ID_SERVICIO),
            FOREIGN KEY (ID_RESERVA) REFERENCES RESERVAS(ID),
            FOREIGN KEY (ID_SERVICIO) REFERENCES SERVICIOS(ID_SERVICIO)
        )'
    ];

    // Ejecutar la creación de tablas
    foreach ($tables as $sql) {
        if ($conn->query($sql) === TRUE) {
            echo 'Tabla creada correctamente.<br>';
        } else {
            echo 'Error creando tabla: ' . $conn->error . '<br>';
        }
    }

    $conn->close();
?>
