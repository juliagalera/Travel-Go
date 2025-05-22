<?php
require_once '../../config/database.php';
require_once '../../modelos/Lugar.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $categoriaString = $_POST['categoria']; 


    $lugar = Lugar::obtenerLugarPorId($conn, $id);
    if (!$lugar) {
        die("Lugar no encontrado.");
    }

    $nuevaRutaImagen = $lugar->getImagen();

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorioDestino = '../../img/';
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaArchivo = $directorioDestino . time() . '_' . $nombreArchivo;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaArchivo)) {
            $nuevaRutaImagen = $rutaArchivo;
        } else {
            die("Error al subir la nueva imagen.");
        }
    }

    $lugar->setNombre($nombre);
    $lugar->setDescripcion($descripcion);
    $lugar->setCategoria($categoriaString);
    $lugar->setImagen($nuevaRutaImagen);

    $resultado = $lugar->actualizarLugar();
    if($resultado){
        header("Location: listarLugares.php");
        exit;

    }else{
        echo "Error al actualizar el lugar";
    }

}
include '../footer.php';

?>
