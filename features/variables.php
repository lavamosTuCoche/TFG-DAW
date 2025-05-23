<?php

$dropOrder = [
    'reserva_servicios',
    'reservas',
    'servicios',
    'lavaderos',
    'negocios',
    'clientes',
    'cuentas'
];

// URL's
$googleDriveEndpoint = '';
$freeCoverterEndpoint = '';

// Rutas web  
$pathURL = ($_SERVER['SERVER_NAME'] === 'localhost') ? "C:/xampp/htdocs/tfg-daw/" : "https://tudominio.com/";
$baseURL = ($_SERVER['SERVER_NAME'] === 'localhost') ? "http://localhost/tfg-daw/" : "https://tudominio.com/";
$baseURLWWW = $baseURL . "www/";

// APIKEYS
$GoogleApiKey = '';
$freeCoverterApikey = '';

// Usuario y contraseña BD
$host = 'localhost';
$userDb = 'tfgUser';
$passDb = 'Cuenca@2025';
$nombreDb = 'lavamos_tu_coche';

// RUTAS WEB
$publicPages = ['inicio.php', 'iniciar-sesion.php', 'politicas-privacidad.php', 'contrato-servicio.php', 'registro.php'];
$unprotectedPages = ['iniciar-sesion.php', 'registro.php']; // Páginas que no requieren redirección si el usuario está autenticado
$clientePages = ['pago.php', 'reservar.php', 'datos.php', 'historial.php'];
$negocioPages = ['lavaderos.php', 'reservas.php', 'datos.php'];
$adminPages = ['backups.php', 'listado-negocios.php', 'listado-usuarios.php', 'listado-reservas.php'];

?>
