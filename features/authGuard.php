<?php

include_once 'variables.php';

session_name('lavamosTuCoche');
session_start();

$actual = basename($_SERVER['SCRIPT_NAME']);

// Comprobar si la página actual es pública o protegida para usuarios no autenticados
if (!isset($_SESSION['usuario']) && !in_array($actual, $publicPages)) {
    header("Location: {$baseURLWWW}iniciar-sesion.php");
    exit;
}

// Comprobar si la página actual está en las páginas de registro o inicio de sesión y el usuario ya está autenticado
if (isset($_SESSION['usuario']) && in_array($actual, $unprotectedPages)) {
    header("Location: {$baseURLWWW}");
    exit;
}

if (isset($_SESSION['usuario'])) {
    $rol = $_SESSION['usuario']['rol'];

    if (!in_array($actual, $publicPages) && !in_array($actual, $unprotectedPages)) {
        switch ($rol) {
            case 'CLIENTE':
                if (!in_array($actual, $clientePages)) {
                    header("Location: {$baseURLWWW}/inicio.php  ");
                    exit;
                }
                break;

            case 'NEGOCIO':
                if (!in_array($actual, $negocioPages)) {
                    header("Location: {$baseURLWWW}/negocios/gestion/lavaderos.php");
                    exit;
                }
                break;

            case 'ADMIN':
                if (!in_array($actual, $adminPages)) {
                    header("Location: {$baseURLWWW}admin/gestion/listado-negocios.php");
                    exit;
                }
                break;

            default:
                session_unset();
                session_destroy();
                header("Location: iniciar-sesion.php");
                exit;
        }
    }
}
?>
