<?php

    include_once '../../features/variables.php';
    include_once '../../features/authGuard.php';
    include_once '../../features/crud.php';

    //COMPRUEBA SI SE VIENE COMPROBANDO EL REGISTRO CORRECTO
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['terminos'])) {
        
        $crud->abrirConexion($host,$userDb,$passDb,$nombreDb);
        
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }

        if (isset($_POST['apellidos'])) {
            $apellidos = $_POST['apellidos'];
        }

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }

        if (isset($_POST['password']) ) {
            $password = $_POST['password'];
        }

        if (isset($_POST['terminos']) ) {
            $informes = ($_POST['terminos'] === 'on') ? 1 : 0;
        }

        $val = isset($_POST['informacion']);
        $informes = (!isset($_POST['informacion']))? 0 : 1;

        $crud->registrarUsuarioCliente($nombre,$apellidos,$email,$password,$informes,$terminos);

    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO CLIENTE| LavamosTuCoche</title>
    <link rel="shortcut icon" href="../../img/logo.png" type="favicon">
    <script src="../../js/registro-cliente.js"></script>
</head>
<body>
    <div class="container">
        <?php

            //Aqui se procesan los errores o avisos (No se registro error base de datos o el correo ya existe)
            if (isset($crud->con->err_no)) {
                
                echo "<div id='contenedor-info' class='info-registro'><p>". $crud->error ."</p></div>";

            }

            $crud->cerrarConexion();

        ?>
        <div class="img-grid">
            <img src="../../img/logo.png" alt="Logo lavamosTuCoche" class="logo-aside-form">
        </div>
        <div class="form-grid">
            <h1 class="title">REGISTRO</h1>
            <form id="registerForm" class="registerForm" spellcheck="false" autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="double-input">
                    <div class="label-input-container">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: David">
                    </div>
                    <div class="label-input-container">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="Ej: Palacios Fernández">
                    </div>
                </div>

                <div class="label-input-container full-width">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@mail.ej">
                </div>

                <div class="double-input">
                    <span class="info-text">La contraseña debe tener al menos 10 caracteres e incluir una letra mayúscula y un carácter especial (como @, #, $, %, etc.).</span>
                    <div class="label-input-container">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <div class="label-input-container">
                        <label for="confirmarPassword">Repite la contraseña</label>
                        <input type="password" id="confirmarPassword" name="confirmarPassword">
                    </div>
                </div>

                <div class="checkbox-container">
                    <label>
                        <input type="checkbox" name="terminos" id="terminos">
                        Aceptar términos y condiciones
                    </label>
                </div>

                <div class="checkbox-container">
                    <label>
                        <input type="checkbox" name="informacion" id="informacion">
                        Permite que se te envíen correos electrónicos de carácter informativo <span class="optional-text">(Opcional)</span>
                    </label>
                </div>

                <input type="submit" name="registro" value="REGISTRARSE" class="submit-button"></input>
            </form>
        </div>
    </div>
    <div class="container-errores"></div>
</body>
</html>