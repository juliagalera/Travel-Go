<?php
require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../controladores/LugarController.php');

// Iniciar sesión y obtener el ID del usuario logueado
session_start();
if (!isset($_SESSION['usuario_id'])) {
    include('../../nav.php');
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

// Crear una instancia de LugarController
$lugarController = new LugarController($conn);

// Obtener los lugares creados por el usuario logueado
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

    <a href="formularioCrearLugar.php" class="btn-agregar">Agregar nuevo lugar</a> 

    <table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($lugares) > 0): ?>
            <?php foreach ($lugares as $lugar): ?>
                <tr>
                    <td><?php echo htmlspecialchars($lugar['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($lugar['detalle']); ?></td>
                    <td><?php $categorias = is_array($lugar['categoria']) ? $lugar['categoria'] : [$lugar['categoria']];
                    echo htmlspecialchars(implode(', ', $categorias));?></td>

                    <td>
                        <?php if ($lugar['imagen']): ?>
                            <img src="<?php echo '../../img/' . htmlspecialchars($lugar['imagen']); ?>" alt="<?php echo htmlspecialchars($lugar['nombre']); ?>" width="100">
                        <?php else: ?>
                            <p>No hay imagen</p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="formularioEditarLugar.php?id=<?php echo $lugar['id']; ?>">Editar</a>
                        <a href="eliminarLugar.php?id=<?php echo $lugar['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este lugar?');">Eliminar</a>
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
