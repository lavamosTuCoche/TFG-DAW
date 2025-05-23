<?php

    if (session_status() === PHP_SESSION_ACTIVE) {
        $email = $_SESSION['usuario']['email'];
        
        session_destroy();
        
        $success = empty($_SESSION) ? "Sí" : "No";
        
        $fecha = new DateTime("now", new DateTimeZone('America/Lima'));
        $logData = '[' . $fecha->format('Y-m-d H:i:s') . ']: El usuario ' . $email . ' cierra la sesión';
        
        $logFile = fopen($pathURL.'logs/sessionLogs.txt', 'a');
        if ($logFile !== false) {
            fwrite($logFile, $logData . PHP_EOL);
            fclose($logFile);
        } else {
            die('No se pudo crear/abrir el fichero de logs');
        }
        redirectUser("{$baseURL}");
    }

?>
