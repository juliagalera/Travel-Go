<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="css/contacto.css">
</head>
<body>
<?php include("nav.php"); ?>
    <div id="contenedorLogo">
        <img id="logo" src="vistas/Usuarios/logo.png" alt="Logo">
        <h1 class="TyG">Travel & Go</h1>
    </div>

    <fieldset>
        <legend><strong>Contacto</strong></legend>
        <form action="travel&go@gmail.com" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <textarea name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
            <button id="button" type="submit">Enviar</button>
        </form>
    </fieldset>

   <?php include("vistas/footer.php"); ?>
</body>
</html>
