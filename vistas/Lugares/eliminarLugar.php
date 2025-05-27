<?php
session_start();
require_once '../../config/database.php';
require_once '../../modelos/Lugar.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Usuarios/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de lugar inválido.");
}

$id = intval($_GET['id']);
$userId = $_SESSION['usuario_id'];

$lugar = Lugar::obtenerLugarPorId($conn, $id);

if (!$lugar || $lugar->getUserId() != $userId) {
    die("No tienes permiso para eliminar este lugar o el lugar no existe.");
}

$resultado = $lugar->eliminarLugar($conn);

if ($resultado) {
    header("Location: listarLugares.php");
    exit();
} else {
    echo "Error al eliminar el lugar.";
}
?>
