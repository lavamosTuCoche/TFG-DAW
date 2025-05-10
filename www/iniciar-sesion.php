<?php

    include_once '../features/variables.php';
    include_once '../features/authGuard.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIAR SESIÓN | LavamosTuCoche</title>
    <link rel="shortcut icon" href="../img/logo.png" type="favicon">
    <script src="../js/login.js"></script>
    <style>
        .logo-form {
            width: 50px;
            heigth: 50px;
        }
        .input-size {
            width: 20px;
            heigth: 20px;
        }
        .error-element {
            padding: 10px;
            border: black 1px solid;
            background-color: red;
            border-radius: 8px;
            text-color: black;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../img/logo.png" alt="Logo lavamosTuCoche" class="logo-form">
        <h1>Iniciar Sesión</h1>
        <form action="#" method="post" id="loginForm" autocomplete="off">
            <div class="form-group">
                <label for="email">EMAIL:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">CONTRASEÑA:</label>
                <input type="password" id="password" name="password">
                <img class="input-size" id="password-toggle" src="../img/oculto.png" alt="Imagen ojo tachado, indicando campo oculto">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        <div class="container-errores"></div>
    </div>
</body>
</html>