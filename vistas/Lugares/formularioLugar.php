<?php
session_start();
require_once '../../config/database.php';
require_once '../../controladores/LugarController.php';

$controller = new LugarController($conn);
include('../../nav.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Lugar</title>
    <link rel="stylesheet" href="formulario.css">
</head>
<body>
    <div class="container">
        <h1>Añadir Nuevo Lugar</h1>
        <form action="procesarFormulario.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre del lugar:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="5" required></textarea>


            <label for="imagen">Imagen (opcional):</label>
            <input type="file" name="imagen" id="imagen">

            <label for="categoria">Categoría:</label>
            <select name="categoria" id="categoria">
                <option value="Deportes">Deportes</option>
                <option value="Cultura">Cultura</option>
                <option value="Gastronomia">Gastronomía</option>
                <option value="compras">Compras</option>
                <option value="Parques">Parques</option>
            </select>

            <input type="submit" value="Guardar Lugar">
        </form>
    </div>
    <?php include('../footer.php'); ?>
</body>
</html>
