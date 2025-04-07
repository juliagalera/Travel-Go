<?php
require('../../config/database.php');

if (!isset($_GET['id'])) {
    echo "No se especificó un lugar.";
    exit;
}

$idLugar = intval($_GET['id']); // Asegura que sea un número entero

$query = "SELECT * FROM lugares WHERE id = $idLugar";
$result = mysqli_query($conn, $query);

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
    <title><?php echo $lugar['nombre']; ?> - Detalles</title>
    <link rel="stylesheet" href="../../filtros.css">
</head>
<body>
    <?php include('../../nav.php'); ?>

    <main style="max-width: 800px; margin: 40px auto; padding: 20px; background-color: #fff; border-radius: 10px;">
        <h1><?php echo $lugar['nombre']; ?></h1>
        <img src="../../img/<?php echo $lugar['imagen']; ?>" alt="<?php echo $lugar['nombre']; ?>" style="width:100%; border-radius: 10px;">
        <p style="margin-top: 20px; font-size: 1.2em;"><?php echo $lugar['detalle']; ?></p>
    </main>

    <?php include('../footer.php'); ?>
</body>
</html>
