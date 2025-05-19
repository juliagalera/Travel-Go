<?php
session_start();
require_once '../../config/database.php';
require_once '../../controladores/LugarController.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "No estás logueado. Por favor, inicia sesión.";
    exit(); 
}

$user_id = $_SESSION['usuario_id']; 

$controller = new LugarController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $imagen = $_FILES['imagen'];

    // Llamada al método para crear un nuevo lugar
    $controller->crearLugar($nombre, $descripcion, $imagen, $categoria, $user_id);
} else {
    echo "No se ha podido crear.";
}
?>
