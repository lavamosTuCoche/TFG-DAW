<?php

    include_once '../features/variables.php';
    include_once '../features/authGuard.php';

    if( isset($_POST['cerrarSesion'])) {
        include '../features/cerrarSesion.php';
        die();
    }

    echo var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO | LavamosTuCoche</title>
    <link rel="shortcut icon" href="favicon.ico" type="">
</head>
<body>
    <?php
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']['rol'] == 'CLIENTE') {
        ?>
        <div>
            <h1>CERRAR SESIÓN</h1>
            <form class="cerrarSesionForm" autocomplete="off"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
                method="post" id="cerrarSesionForm">
                <button name="cerrarSesion" class="btn">SALIR</button>
            </form>
        </div>
        <?php
    }
    ?>
</body>
</html>