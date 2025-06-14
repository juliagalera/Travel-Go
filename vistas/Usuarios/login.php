<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<?php include('../../nav.php'); ?>
    <div id="contenedorLogo">
        <img id="logo" src="logo.png" alt="Logotipo Travel & Go">
        <h1 class="TyG">TRAVEL & <span style="color:black;">GO</span>!</h1>
    </div>
    
    <fieldset>
    <legend><strong>Inicio de sesión</strong></legend>
        <form action="/Travel-Go/index.php?action=iniciarSesion" method="post">
            <input class="input" type="email" name="email" placeholder="Introduce tu email" class="mail" autofocus
                   value="<?php echo isset($_COOKIE['usuario_recordado_email']) ? $_COOKIE['usuario_recordado_email'] : ''; ?>"><br><br>
            
            <input class="input" type="password" name="passwd" class="passwd" placeholder="Introduce tu contraseña"
                   value="<?php echo isset($_COOKIE['usuario_recordado_passwd']) ? $_COOKIE['usuario_recordado_passwd'] : ''; ?>"><br><br>

                <label class="checkbox-container">
                    <input type="checkbox" name="recordar" id="recordar">
                    <span>Mantener sesión iniciada</span>
                </label>
<br>
                <label class="checkbox-container">
                    <input class="input" type="checkbox" name="recordarDatos" id="recordarDatos">
                    <span>Recordar mi email y contraseña</span>
                </label>

<br>

            <button id="login" type="submit">Iniciar sesión</button>
        </form>
    </fieldset>
    
<?php include('../footer.php') ?>
</body>
</html>
