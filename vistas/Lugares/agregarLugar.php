<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: /Travel-Go/vistas/Usuarios/login.php');
    exit;
}
include('../../nav.php');ç

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Lugar</title>
    <link rel="stylesheet" href="agregar.css">
</head>
<body>
    <h1>Agregar un nuevo lugar</h1>

    <form action="/Travel-Go/rutas/procesar_agregar_lugar.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del lugar:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="ubicacion">Ubicación:</label><br>
        <input type="text" id="ubicacion" name="ubicacion" required><br><br>

        <label for="imagen">Imagen (opcional):</label><br>
        <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>

        <button type="submit">Agregar Lugar</button>
    </form>

    <br>
    <a href="/Travel-Go/vistas/principal-page.php">Volver a la página principal</a>
    <?php
    include('../footer.php'); ?>
</body>
</html>
