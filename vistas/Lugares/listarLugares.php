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
                    <td><?php $stmt = "SELECT nombre FROM LUGARES WHERE user_id = $userId";
                        $conn->query($stmt);
                    ?>
                </td>
                    <td><?php $stmt = "SELECT detalle FROM LUGARES WHERE user_id = $userId"; 
                    $conn->query($stmt);
                    ?></td>


                    <td>      
                     <?php $stmt = "SELECT imagen FROM LUGARES WHERE user_id = $userId" ; 
                     $conn->query($stmt);?>
                    </td>
                    <td><?php $stmt = "SELECT categoria FROM LUGARES WHERE user_id = $userId" ;
                    $conn->query($stmt);?></td>
                    <td>
                        <a href="formularioEditarLugar.php?id=<?php echo $lugar['id']; ?>">Editar</a>
                        <a href="listarLugares.php" onclick="return confirm('¿Estás seguro de eliminar este lugar?');">Eliminar</a>
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
