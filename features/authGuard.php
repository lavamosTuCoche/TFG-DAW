<?php

$freePages = ['inicio.php','iniciar-sesion.php','avisos-legales.php','registro.php'];
    //TODO: Si el hosting no admite page 404 o lista el directorio, buscar solución
    session_start();

    $actual = basename($_SERVER['PHP_SELF']);
    if (!isset($_SESSION['usuario']) && !in_array($actual, $freePages)) {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'iniciar-sesion.php';
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        //TODO: De momento tiene que ir a esta URL luego cambiara el dominio
        header("Location: $protocol://localhost/tfg-DAW/www/iniciar-sesion.php");
        exit;
    }

?>