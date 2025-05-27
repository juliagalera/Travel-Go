<?php
require('C:/xampp/htdocs/Travel-Go/config/database.php');

$category = isset($_GET['categoria']) ? $_GET['categoria'] : 'Gastronomia';

$categoriasValidas = ['Parques', 'Gastronomia', 'Deportes', 'Cultura', 'Compras'];
if (!in_array($category, $categoriasValidas)) {
    echo "Categoría no válida.";
    exit;
}

$query = "SELECT * FROM lugares WHERE FIND_IN_SET(?, categoria)";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$limite = 50;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($category); ?> - Granada</title>
    <link rel="stylesheet" href="css/filtros.css" />
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
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $descripcionCorta = substr($row['detalle'], 0, $limite);
                if (strlen($row['detalle']) > $limite) {
                    $descripcionCorta .= '...';
                }

                echo '<div class="category">';
                 $imagen = htmlspecialchars($row['imagen']);
                if (substr($imagen, 0, 4) === "img/") {
                    $imagen = substr($imagen, 4);
                }
                echo '<img src="../../img/' . $imagen . '" alt="' . htmlspecialchars($row['nombre']) . '" />';
                echo '<h2>' . htmlspecialchars($row['nombre']) . '</h2>';
                echo '<p>' . htmlspecialchars($descripcionCorta) . '</p>';
                echo '<a href="ver_lugar.php?id=' . urlencode($row["id"]) . '">Ver más</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No hay lugares disponibles en esta categoría.</p>';
        }
        $stmt->close();
        $conn->close();
        ?>
    </section>

    <?php include('../footer.php'); ?>
</body>
</html>
