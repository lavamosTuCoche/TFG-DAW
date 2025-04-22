<?php

    if (session_status() === 2) {

        $nombre = session_name().$_SESSION['nombre'];
        session_destroy();
        $success = session_unset();
        $fecha = new date("Y-m-d H:i:s");
    
        $logFile = fopen('../logs/sessionLogs.txt','a',true);
        $logData = '['.$fecha.']: El usuario '.$nombre.' cierra la sessión correctamente: '.$success;
        fwrite($logFile,$logData);
        fclose($logFile);
        
    }

?>