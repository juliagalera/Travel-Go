<?php

require('C:/xampp/htdocs/Travel-Go/config/database.php');

$category = isset($_GET['categoria']) ? mysqli_real_escape_string($conn, $_GET['categoria']) : 'Gastronomia';

$categoriasValidas = ['Parques', 'Gastronomia', 'Deportes', 'Cultura', 'Compras'];
if (!in_array($category, $categoriasValidas)) {
    echo "Categoría no válida.";
    exit;
}

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category); ?> - Granada</title>
    <link rel="stylesheet" href="filtros.css">
</head>
<body>
    <?php include('../../nav.php');?>

    <h1>Lugares de <?php echo htmlspecialchars($category); ?> en Granada</h1>

    <section class="categories">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $descripcionCorta = substr($row['detalle'], 0, $limite);
                if (strlen($row['detalle']) > $limite) {
                    $descripcionCorta .= '...';  
                }

                echo '<div class="category">';
                echo '<img src="../../img/' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '" />';
                echo '<h2>' . htmlspecialchars($row['nombre']) . '</h2>';
                echo '<p>' . htmlspecialchars($descripcionCorta) . '</p>';
                ?>
                
                <a href='ver_lugar.php?id=<?php echo urlencode($row["id"]); ?>'>Ver más</a>
                <?php

                echo '</div>';
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
