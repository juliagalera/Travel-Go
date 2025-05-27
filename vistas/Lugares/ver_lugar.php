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
    <link rel="stylesheet" href="css/filtros.css">
    <style>

    </style>
</head>
<body>
    <?php include('../../nav.php'); ?>

    <main>
        <h1><?php echo htmlspecialchars($lugar['nombre']); ?></h1>
        <?php 
        $imagen = htmlspecialchars($lugar['imagen']);
        if (substr($imagen, 0, 4) === "img/") {
            $imagen = substr($imagen, 4);
        }
        ?>
        <img id="lugar" src="../../img/<?php echo $imagen; ?>" alt="Imagen de <?php echo htmlspecialchars($lugar['nombre']); ?>">
        <p style="margin-top: 20px; font-size: 1.2em;"><?php echo htmlspecialchars($lugar['detalle']); ?></p>

       <div class="rating" data-id-lugar="<?php echo $lugar['id']; ?>">
        <span data-value="1">★</span>
        <span data-value="2">★</span>
        <span data-value="3">★</span>
        <span data-value="4">★</span>
        <span data-value="5">★</span>
        </div>

        <p class="resultado"></p>
        <?php 
        require_once '../../modelos/valoracion.php';
        require_once '../../controladores/LugarController.php';

        $id_lugar = $_GET['id'] ?? null;
        $valoraciones = [];

        if ($id_lugar) {
            $valoracion = new Valoracion($conn);
            $valoraciones = $valoracion->obtenerValoracionesConUsuario($id_lugar);
        }
        ?>

        <div class="valoraciones">
            <h2>Valoraciones</h2>

            <?php if (!empty($valoraciones)): ?>
                <ul>
                <?php foreach ($valoraciones as $val): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($val['usuario_nombre']); ?></strong>
                        <?php 
                        for ($i = 1; $i <= 5; $i++) {
                            $clase = $i <= $val['valoracion'] ? 'estrella' : 'estrella vacia';
                            echo "<span class=\"$clase\">" . ($i <= $val['valoracion'] ? '★' : '☆') . "</span>";
                        }
                        ?>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay valoraciones aún.</p>
            <?php endif; ?>
        </div>




    </main>

    <?php include('../footer.php'); ?>
    <script>
document.querySelectorAll(".rating").forEach(contenedor => {
  const estrellas = contenedor.querySelectorAll("span");

  estrellas.forEach(star => {
    star.addEventListener("mouseenter", () => {
      const valor = parseInt(star.getAttribute("data-value"));
      estrellas.forEach(s => {
        const val = parseInt(s.getAttribute("data-value"));
        if (val <= valor) {
          s.style.color = "gold";
        } else {
          s.style.color = "gray";
        }
      });
    });

    star.addEventListener("mouseleave", () => {
      const seleccionadas = contenedor.querySelectorAll("span.selected");
      if (seleccionadas.length === 0) {
        estrellas.forEach(s => s.style.color = "gray");
      } else {
        const maxValor = Math.max(...Array.from(seleccionadas).map(s => parseInt(s.getAttribute("data-value"))));
        estrellas.forEach(s => {
          const val = parseInt(s.getAttribute("data-value"));
          s.style.color = val <= maxValor ? "gold" : "gray";
        });
      }
    });

    star.addEventListener("click", () => {
      const valor = parseInt(star.getAttribute("data-value"));

      estrellas.forEach(s => s.classList.remove("selected"));
      estrellas.forEach(s => {
        const val = parseInt(s.getAttribute("data-value"));
        if (val <= valor) s.classList.add("selected");
      });

      const idLugar = contenedor.getAttribute("data-id-lugar");

      fetch("../../controladores/guardar_valoracion.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id_lugar=${idLugar}&valoracion=${valor}`
      })
      .then(res => res.text())
      .then(texto => {
        contenedor.nextElementSibling.textContent = texto;
      });
    });
  });
});



</script>

</body>
</html>
