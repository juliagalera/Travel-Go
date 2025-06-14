<?php
session_start();
require_once '../../../config/database.php';
require_once '../../../controladores/LugarController.php';

$controller = new LugarController($conn);
include('../../../nav.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Lugar</title>
    <link rel="stylesheet" href="../css/formulario.css">
</head>
<body>
    <div class="container">
        <h1>Añadir Nuevo Lugar</h1>
        <form id="nuevoLugar"action="procesarFormulario.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre del lugar:</label>
            <input class="input" type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" rows="5" required></textarea>


            <label for="imagen">Imagen (opcional):</label>
            <input class="input" type="file" name="imagen" id="imagen">

            <label for="categoria">Categoría:</label>
            <select name="categoria" id="categoria">
                <option value="deportes">Deportes</option>
                <option value="cultura">Cultura</option>
                <option value="gastronomia">Gastronomía</option>
                <option value="compras">Compras</option>
                <option value="parques">Parques</option>
            </select>

            <input class="input" type="submit" value="Guardar Lugar">
        </form>
    </div>
    <?php include('../../footer.php'); ?>
</body>
</html>
