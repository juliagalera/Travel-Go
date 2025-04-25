<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="login.css">

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
            <input type="email" name="email" placeholder="Introduce tu email" class="mail" autofocus><br><br>
            <input type="password" name="passwd" class="passwd" placeholder="Introduce tu contraseña"><br><br>
            <input type="checkbox" name="recordar" id="recordar">Mantener sesión iniciada<br><br>
            <button id="login" type="submit">Iniciar sesión</button>
        </form>

    </fieldset>
<?php
include('../footer.php')?>
</body>
</html>