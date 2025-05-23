<?php

    include_once '../features/variables.php';
    include '../features/authGuard.php';
    include_once '../features/crud.php';

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $userEmail = $_POST['email'];
        $userPassword = $_POST['password'];

        $crud = new Crud($userDb,$passDb,$host);

        $crud->connectDb($nombreDb);

        $resultLogin = $crud->checkLogin($userEmail,$userPassword);

        if ($resultLogin) {

            $resultStorage = $crud->storageUser($userEmail);
            if ($resultStorage) {
                include $pathURL.'features/authGuard.php';
            }
            die();
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIAR SESIÓN | LavamosTuCoche</title>
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/iniciar-sesion.css">
    <script src="../js/login.js"></script>
</head>
<body>
    <div class="container">
        <img src="../img/logo.png" alt="Logo lavamosTuCoche" class="logo-form">
        <h1>INICIAR SESIÓN</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id="loginForm" autocomplete="off">
            <div class="form-group">
                <label for="email">EMAIL</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">
                    <span>CONTRASEÑA</span>
                    <img class="input-size" id="password-toggle" src="../img/oculto.png" alt="Imagen ojo tachado, indicando campo oculto" >
                </label>
                <input type="password" id="password" name="password" title="La contraseña debe tener al menos 10 caracteres e incluir una letra mayúscula y un carácter especial (como @, #, $, %, etc.)." required>
            </div>
            <button type="submit" class="btn btn-primary">INICIAR SESIÓN</button>
        </form>
        <div class="container-errores">
            <?php

            if (isset($resultLogin) && !$resultLogin || isset($resultStorage) && !$resultStorage) {
                echo '<p class="error-element">Ha ocurrido algún problema con el inicio de sesión</p>';
                ?>
                <script>
                    const errorElements = document.getElementsByClassName('error-element');

                    if (errorElements) {
                        for (const element of errorElements) {
                            element.addEventListener("click", ($event) => {
                                $event.target.remove();
                            });
                        }
                    }
                </script>
                <?php
            }

            ?>
        </div>
    </div>
</body>
</html>