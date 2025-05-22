<?php
session_start();
require('../../config/database.php');

if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
    header('Location: /Travel-Go/inicio.php'); 
    exit;
}

$busqueda = trim($_GET['q']);

$query = "SELECT id FROM lugares WHERE nombre LIKE ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
$param = "%".$busqueda."%";
mysqli_stmt_bind_param($stmt, "s", $param);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $lugar = mysqli_fetch_assoc($result);
    $idLugar = $lugar['id'];
    header("Location: /Travel-Go/vistas/lugares/ver_lugar.php?id=$idLugar");
    exit;
} else {
    echo "<script>
        alert('No se ha encontrado ningún lugar con ese nombre.');
        window.history.back();
    </script>";
    exit;
}
?>
