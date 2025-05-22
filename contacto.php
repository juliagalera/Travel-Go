<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="contacto.css">
</head>
<body>
<?php include("nav.php"); ?>
    <div id="contenedorLogo">
        <img id="logo" src="logo.png" alt="Logo">
        <h1 class="TyG">Travel & Go</h1>
    </div>

    <fieldset>
        <legend><strong>Contacto</strong></legend>
        <form action="travel&go@gmail.com" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <textarea name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
            <div id="recordar">
                <input type="checkbox" name="suscripcion"> Suscribirme a novedades
            </div>
            <button id="button" type="submit">Enviar</button>
        </form>
    </fieldset>

   <?php include("vistas/footer.php"); ?>
</body>
</html>
