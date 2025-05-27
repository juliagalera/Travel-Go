<?php
if (session_status() === PHP_SESSION_NONE) {
        session_start();
}

require_once(__DIR__ . '/../config/database.php');       
require_once(__DIR__ . '/../modelos/valoracion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_lugar'], $_POST['valoracion']) && isset($_SESSION['usuario_id'])) {
        $id_lugar = intval($_POST['id_lugar']);
        $valoracion = intval($_POST['valoracion']);
        $id_usuario = $_SESSION['usuario_id']; 

        $valoracionModel = new Valoracion($conn);
        $resultado = $valoracionModel->guardar($id_lugar, $id_usuario, $valoracion);

        if ($resultado) {
            echo "Valoración guardada correctamente.";
        } else {
            echo "Error al guardar la valoración.";
        }
    } else {
        echo "Datos incompletos o usuario no autenticado.";
    }
} 
?>
