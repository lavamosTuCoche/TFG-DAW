<?php

include_once '../../features/variables.php';
include_once '../../features/authGuard.php';
include_once '../../features/crud.php';

//COMPRUEBA SI SE VIENE COMPROBANDO EL REGISTRO CORRECTO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['terminos'])) {

    $crud = new Crud($userDb, $passDb, $host);
    $crud->connectDb($nombreDb);

    if (isset($_POST['nombreNegocio'])) {
        $nombre = $_POST['nombreNegocio'];
    }

    if (isset($_POST['logo'])) {
        $logo = gzdeflate($_POST['logo']);
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    if (isset($_POST['password']) && isset($_POST['confirmarPassword'])) {
        
        $password = $_POST['password'];
        $confirmarPassword = $_POST['confirmarPassword'];
        
        if ($password == $confirmarPassword) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
    }

    $terminos = (isset($_POST['terminos'])) ? 1:0;

    $result = $crud->registrarUsuarioNegocio($nombre, $logo, $email, $password, $terminos);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Negocio | LavamosTuCoche</title>
    <link rel="shortcut icon" href="../../img/logo.png" type="favicon">
    <link rel="stylesheet" href="../../css/registro-negocio.css">
    <script src="../../js/registro-negocio.js"></script>
</head>

<body>
    <div id='contenedor-info' class='info-registro'></div>
    <div class="container">
        <div>
            <h1 class="title">REGISTRO NUEVO NEGOCIO</h1>
            <form id="registerForm" class="registerForm" spellcheck="false" autocomplete="off" method="post"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="two-columns">
                    <div>
                        <div>
                            <label for="nombreNegocio">NOMBRE NEGOCIO</label>
                            <input type="text" id="nombreNegocio" name="nombreNegocio"
                                placeholder="Ej: Lavadero Joaquin Fernández" required>
                        </div>
                        <div>
                            <label for="logo">SUBIR LOGO:</label>
                            <input name="logo" id="logo" type="file" accept="image/*" hidden>
                            <button type="button" id="logoBtn" class="custom-file-upload">SELECCIONAR IMAGEN</button>
                        </div>
                    </div>
                    <img class="logo-negocio" src="../../img/logo-default.png" alt="Imagen por defecto para logos">
                </div>
                <div>
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@mail.ej" required>
                </div>
                <div>
                    <span class="info-text">La contraseña debe tener al menos 10 caracteres e incluir una letra
                        mayúscula y un carácter especial (como @, #, $, %, etc.).</span>
                    <label for="password">
                        <span>CONTRASEÑA</span>
                        <img class="input-size" id="password-toggle" src="../../img/oculto.png"
                            alt="Imagen ojo tachado, indicando campo oculto">
                    </label>
                    <input type="password" id="password" name="password" class="toogle" required>
                </div>

                <div>
                    <label for="confirmarPassword">REPITE LA CONTRASEÑA</label>
                    <input type="password" id="confirmarPassword" class="toogle" name="confirmarPassword" required>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="terminos" id="terminos" required>
                        Aceptar términos y condiciones
                    </label>
                </div>
                <button type="submit" class="btn">REGISTRAR</button>
            </form>
            <div class="container-errores"></div>
        </div>
</body>

</html>