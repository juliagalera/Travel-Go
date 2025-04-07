<?php

require('C:/xampp/htdocs/Travel-Go/config/database.php');

$category = isset($_GET['categoria']) ? $_GET['categoria'] : 'Cultura';

$query = "SELECT * FROM lugares WHERE categoria = '$category'";
$result = mysqli_query($conn, $query);

$limite = 50; // Límite de caracteres para la descripción

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category; ?> - Granada</title>
    <link rel="stylesheet" href="filtros.css">
</head>
<body>
    <?php include('../../nav.php');?>

    <h1>Lugares de <?php echo $category; ?> en Granada</h1>

    <section class="categories">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Recortar la descripción
                $descripcionCorta = substr($row['detalle'], 0, $limite); 

                echo '<div class="category">';
                echo '<img src="../../img/' . $row['imagen'] . '" alt="' . $row['nombre'] . '" />';
                echo '<h2>' . $row['nombre'] . '</h2>';
                // Mostrar solo la descripción recortada
                echo '<p>' . $descripcionCorta . '...</p>';
                ?>
                
                <a href='ver_lugar.php?id=<?php echo urlencode($row["id"]); ?>'>Ver más</a>
<?php

                echo '</div>';
            }
        } else {
            echo '<p>No hay lugares disponibles en esta categoría.</p>';
        }
        ?>
    </section>

    <?php include('../footer.php'); ?>
</body>
</html>
