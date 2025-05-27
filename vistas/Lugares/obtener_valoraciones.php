<?php
session_start();
require_once '../config/database.php';
require_once '../modelos/V+valoracion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_lugar'])) {
    $id_lugar = intval($_GET['id_lugar']);
    $valoracionModel = new Valoracion($conexion);

    $valoraciones = $valoracionModel->obtenerPorLugar($id_lugar);

    echo json_encode($valoraciones);
} else {
    echo json_encode(['error' => 'Parámetro id_lugar requerido']);
}
