<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="login.css">

</head>
<body>
    <nav>
        <a id="nav" href="index.html">Inicio</a>
        <a id="nav" href="contacto.html">Contacto</a>
    </nav>
    <div id="contenedorLogo">
        <img id="logo" src="logo.png" alt="Logotipo Travel & Go">
        <h1 class="TyG">TRAVEL & GO</h1>
    </div>
    <fieldset>
        <form action="" method="post">
            Email: <input type="email" placeholder="Introduce tu email" class="mail"><br><br>
            Contraseña: <input type="password" class="psswd" placeholder="Introduce tu contraseña"><br><br>
            <input type="checkbox" name="recordar" id="recordar">Mantener sesión iniciada<br><br>
            <button id="login" type="submit">Iniciar sesión</button>
        </form>

    </fieldset>
<?php
include('../footer.php')?>
</body>
</html>