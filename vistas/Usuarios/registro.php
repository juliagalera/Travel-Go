<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar usuario</title>
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
    
<?php include('../../nav.php');
?>
    <div id="contenedorLogo">
        <img id="logo" src="logo.png" alt="Logotipo Travel & Go">
        <h1>Registro</h1>
    </div>
    
    <fieldset>
    <legend><strong>Registro</strong></legend>
        <form id="registroForm" action="/Travel-Go/index.php?action=registrarUsuario" method="post">
            <label for="nombre">Nombre:</label>
            <input class="forminp" type="text" id="nombre" name="nombre" autofocus><br><br>

            <label for="apellido">Apellidos:</label>
            <input class="forminp" type="text" id="apellido" name="apellido"><br><br>

            <label for="email">Correo electrónico:</label>
            <input class="forminp" type="email" id="email" name="email"><br><br>

            <label for="passwd1">Contraseña:</label>
            <input class="forminp" type="password" id="passwd1" name="passwd1" ><br><br>

            <label for="passwd2">Repita su contraseña:</label>
            <input class="forminp" type="password" id="passwd2" name="passwd2" ><br><br>

            <div id="AceptarTerminos">
                <input type="checkbox" id="terminos" name="terminos" >
                <label for="terminos">Acepto los <a href="terminos.html">términos y condiciones</a></label>
            </div>

            <button class="button" type="submit">Registrarme</button>
        </form>
    </fieldset>
    <script>
    document.getElementById('registroForm').addEventListener('submit', function(event) {
        const terminos = document.getElementById('terminos');
        if (!terminos.checked) {
            event.preventDefault(); 

            alert('Debes aceptar los términos y condiciones para registrarte.');
        }
    });
    </script>
    <?php

include('../footer.php')?>
</body>
</html>
