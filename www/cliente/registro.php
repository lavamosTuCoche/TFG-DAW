<?php

include_once '../../features/variables.php';
include_once '../../features/authGuard.php';
include_once '../../features/crud.php';

//COMPRUEBA SI SE VIENE COMPROBANDO EL REGISTRO CORRECTO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['terminos'])) {

    $crud = new Crud($userDb, $passDb, $host);
    $crud->connectDb($nombreDb);

    if (isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
    }

    if (isset($_POST['apellidos'])) {
        $apellidos = separarApellidos($_POST['apellidos']);
        $apellido1 = $apellidos[0];
        $apellido2 = $apellidos[1];
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

    $informes = (isset($_POST['informacion'])) ?1:0;

    $crud->registrarUsuarioCliente($nombre, $apellido1,$apellido2, $email, $password, $informes, $terminos);

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cliente | LavamosTuCoche</title>
    <link rel="shortcut icon" href="../../img/logo.png" type="favicon">
    <link rel="stylesheet" href="../../css/registro-cliente.css">
    <script src="../../js/registro-cliente.js"></script>
</head>
<body>
    <div class="container">
        <div id='contenedor-info' class='info-registro'></div>
        <div>
            <h1 class="title">REGISTRARSE</h1>
            <form id="registerForm" class="registerForm" spellcheck="false" autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div>
                    <label for="nombre-apellidos">NOMBRE<span class="obligatorio">*</span></label>
                    <input type="text" id="nombre" name="nombre"
                        placeholder="Ej: David" required>
                </div>
                <div>
                    <label for="apellidos">APELLIDOS<span class="obligatorio">*</span></label>
                    <input type="text" id="apellidos" name="apellidos"
                        placeholder="Ej: Palacios Fernández" required>
                </div>
                <div>
                    <label for="email">EMAIL<span class="obligatorio">*</span></label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@mail.ej" required>
                </div>
                <div>
                    <label for="password">
                        CONTRASEÑA<span class="obligatorio">*</span>
                        <img class="input-size" id="password-toggle" src="../../img/oculto.png" alt="Imagen ojo tachado, indicando campo oculto">
                    </label>
                    <input type="password" id="password" name="password" class="toogle" required>
                </div>
                <div>
                    <label for="confirmarPassword">
                        REPITE LA CONTRASEÑA <span class="obligatorio">*</span>
                    </label>
                    <input type="password" id="confirmarPassword" name="confirmarPassword" class="toogle" required>
                </div>
                <p class="info-text">La contraseña debe tener al menos 10 caracteres e incluir una letra mayúscula y un carácter especial (como @, #, $, %, etc...).</p>
                <div>
                    <label>
                        <input type="checkbox" name="terminos" id="terminos" required>
                        Aceptar términos y condiciones.<span class="obligatorio">*</span>
                    </label>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="informacion" id="informacion">
                        Permite que se te envíen correos electrónicos de carácter informativo.</span>
                    </label>
                </div>
                <button type="submit" class="btn">REGISTRAR</button>
            </form>
        </div>
        <div class="container-errores"></div>
    </div>
</body>
</html>