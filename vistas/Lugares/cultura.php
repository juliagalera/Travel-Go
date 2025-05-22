<?php
require('C:/xampp/htdocs/Travel-Go/config/database.php');

// Obtener categoría de la URL, por defecto 'Gastronomia'
$category = isset($_GET['categoria']) ? mysqli_real_escape_string($conn, $_GET['categoria']) : 'Cultura';

// Lista de categorías válidas
$categoriasValidas = ['Parques', 'Gastronomia', 'Deportes', 'Cultura', 'Compras'];

// Validar categoría
if (!in_array($category, $categoriasValidas)) {
    echo "Categoría no válida.";
    exit;
}

// Consulta para obtener lugares de esa categoría
$query = "SELECT * FROM lugares WHERE categoria = '$category'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conn));
}

$limite = 50;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($category); ?> - Granada</title>
    <link rel="stylesheet" href="filtros.css" />
</head>
<body>
    <?php include('../../nav.php'); ?>

    <h1>Lugares de <?php echo htmlspecialchars($category); ?> en Granada</h1>
    <div class="nuevo-lugar-btn">
        <a href="formularioLugar.php">+ Añadir nuevo lugar</a>
        <a href='/Travel-Go/inicio.php'>Ver otras categorías</a>
    </div>

    <section class="categories">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $descripcionCorta = substr($row['detalle'], 0, $limite);
            if (strlen($row['detalle']) > $limite) {
                $descripcionCorta .= '...';
            }
            ?>
            <div class="category"><?php
                 $imagen = htmlspecialchars($row['imagen']);
                if (substr($imagen, 0, 4) === "img/") {
                    $imagen = substr($imagen, 4);
                }
                echo '<img src="../../img/' . $imagen . '" alt="' . htmlspecialchars($row['nombre']) . '" />'; ?>
                <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                <p><?php echo htmlspecialchars($descripcionCorta); ?></p>
                <a href='ver_lugar.php?id=<?php echo urlencode($row["id"]); ?>'>Ver más</a>
            </div>
            <?php
        }
    } else {
        echo '<p>No hay lugares disponibles en esta categoría.</p>';
    }
    mysqli_close($conn);
    ?>
    </section>

    <?php include('../footer.php'); ?>
</body>
</html>
