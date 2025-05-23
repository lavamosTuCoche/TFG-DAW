<?php
include_once '../../../features/authGuard.php';

var_dump($_POST);
var_dump($_SESSION);

if (isset($_POST['cerrarSesion'])) {
    include '../../../features/cerrarSesion.php';
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMINISTRAR | LavamosTuCoche</title>
</head>

<body>
    <h1>ADMINISTRACIÓN</h1>
    <form action="" method="post">
        <h2>FORM</h2>
        <button type="submit" name="cerrarSesion">CERRAR SESIÓN</button>
    </form>
</body>

</html>