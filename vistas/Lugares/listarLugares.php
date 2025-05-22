<?php
require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../controladores/LugarController.php');

session_start();
if (!isset($_SESSION['usuario_id'])) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>No estás logueado</title>
        <link rel="stylesheet" href="lista.css">
    </head>
    <body>
        <div class="mensaje-container">
            <h2>¡Ups! No estás logueado</h2>
            <p>Necesitas iniciar sesión para ver tus lugares.</p>
            <a href="../Usuarios/login.php" class="btn-login">Iniciar sesión</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

$userId = $_SESSION['usuario_id'];

$lugarController = new LugarController($conn);

$lugares = $lugarController->obtenerLugaresPorUsuario($userId);
include('../../nav.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Lugares</title>
    <link rel="stylesheet" href="lista.css">
</head>
<body>
    <h1>Lista de Lugares</h1>

    <a href="formularioLugar.php" class="btn-agregar">Agregar nuevo lugar</a> 

    <table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Imagen</th> 
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($lugares) > 0): ?>
            <?php foreach ($lugares as $lugar): ?>
                <tr>
                    <td><?= htmlspecialchars($lugar['nombre']) ?></td>
                    <td><?= htmlspecialchars($lugar['detalle']) ?></td>
                    <td>
                        <?php 
                        if (!empty($lugar['imagen'])): 
                            $imagen = htmlspecialchars($lugar['imagen']);
                            if (substr($imagen, 0, 4) === "img/") {
                                $imagen = substr($imagen, 4);
                            }
                        ?>
                            <img src="../../img/<?php echo $imagen; ?>" alt="Imagen del lugar" width="100">
                        <?php else: ?>
                            Sin imagen
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($lugar['categoria']) ?></td>
                    <td>
                        <a class="enlace" href="formularioEditarLugar.php?id=<?= $lugar['id']; ?>">Editar</a>
                        <a class="enlace"  href="eliminarLugar.php?id=<?= $lugar['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este lugar?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No has creado ningún lugar aún.</td>
            </tr>
        <?php endif; ?>
    </tbody>
    </table>

    <?php include('../footer.php'); ?>
</body>
</html>
