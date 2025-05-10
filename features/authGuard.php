<?php

    $freePages = ['inicio.php', 'iniciar-sesion.php', 'avisos-legales.php', 'registro.php'];

    session_start();

    $actual = basename($_SERVER['SCRIPT_NAME']);
    if (!isset($_SESSION['usuario']) && !in_array($actual, $freePages)) {
        $baseURL = ($_SERVER['SERVER_NAME'] === 'localhost') ? "http://localhost/tfg-DAW/www/" : "https://tudominio.com/";
        header("Location: {$baseURL}iniciar-sesion.php");
        exit;
    }
    
?>
