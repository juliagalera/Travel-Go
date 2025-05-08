<?php
require('../../config/database.php');

if (!isset($_GET['id'])) {
    echo "No se especificó un lugar.";
    exit;
}

$idLugar = intval($_GET['id']); 

$query = "SELECT * FROM lugares WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    echo "Error al preparar la consulta.";
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $idLugar); 
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo "Lugar no encontrado.";
    exit;
}

$lugar = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($lugar['nombre']); ?> - Detalles</title>
    <link rel="stylesheet" href="../../filtros.css">
    <style>
        main {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #lugar {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        #lugar:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <?php include('../../nav.php'); ?>

    <main>
        <h1><?php echo htmlspecialchars($lugar['nombre']); ?></h1>
        <img  id="lugar" src="../../img/<?php echo htmlspecialchars($lugar['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($lugar['nombre']); ?>">
        <p style="margin-top: 20px; font-size: 1.2em;"><?php echo htmlspecialchars($lugar['detalle']); ?></p>
    </main>

    <?php include('../footer.php'); ?>
</body>
</html>
