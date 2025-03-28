<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar usuario</title>
    <link rel="stylesheet" href="registro.css">
</head>
<body>
    <nav>
        <a id="nav" href="index.php">Inicio</a>
        <a id="nav" href="contacto.html">Contacto</a>
    </nav>
    <div id="contenedorLogo">
        <img id="logo" src="logo.png" alt="Logotipo Travel & Go">
        <h1>Registro</h1>
    </div>
    
    <fieldset>
        <form action="index.php?action=registrarUsuario" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required autofocus><br><br>

            <label for="apellido">Apellidos:</label>
            <input type="text" id="apellido" name="apellido" required><br><br>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="passwd1">Contraseña:</label>
            <input type="password" id="passwd1" name="passwd1" required><br><br>

            <label for="passwd2">Repita su contraseña:</label>
            <input type="password" id="passwd2" name="passwd2" required><br><br>

            <div id="terminos">
                <input type="checkbox" id="acepto" name="acepto" required>
                <label for="acepto">Acepto los <a href="terminos.html">términos y condiciones</a></label>
            </div>

            <button type="submit">Registrarme</button>
        </form>
    </fieldset>
</body>
</html>
