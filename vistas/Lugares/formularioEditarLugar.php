<?php

include '../../config/database.php';
require_once ('../../controladores/LugarController.php');

$id = intval($_GET['id']);
$lugar = Lugar::obtenerLugarPorId($conn, $id);

if(!$lugar){
    echo "Lugar no encontrado";
}

$categpriaActual = $lugar->getCategoria();
$categoriasSeleccionadas = explode(',', $categpriaActual);

$categoriasDisponibles = ['Parque', 'Restaurantes', 'Compras', 'Cultura', 'Deportes'];

include '../../nav.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Lugar</title>
    <link rel="stylesheet" href="formularioEdit.css">

</head>
<body>

<h2>Editar Lugar</h2>

<form action="procesarEditarLugar.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $lugar->getId(); ?>">

    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($lugar->getNombre()); ?>"><br><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion" rows="5" required><?php echo htmlspecialchars($lugar->getDescripcion()); ?></textarea><br><br>

    <label>Categoría:</label><br>
    <?php foreach ($categoriasDisponibles as $categoria): ?>
        <label>
            <input type="checkbox" name="categoria[]" value="<?php echo $categoria; ?>"
                <?php echo in_array($categoria, $categoriasSeleccionadas) ? 'checked' : ''; ?>>
            <?php echo $categoria; ?>
        </label><br>
    <?php endforeach; ?>
    <br>

    <label>Imagen actual:</label><br>
    <?php if ($lugar->getImagen()): ?>
        <img src="<?php echo htmlspecialchars($lugar->getImagen()); ?>" alt="Imagen lugar" width="150"><br><br>
    <?php else: ?>
        <p>No hay imagen subida.</p>
    <?php endif; ?>

    <label for="imagen">Cambiar imagen (opcional):</label><br>
    <input type="file" name="imagen" id="imagen" accept="image/*"><br><br>

    <input type="submit" value= "Guardar cambios">
</form>
<?php include '../footer.php'; ?>
</body>
</html>