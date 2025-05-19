<?php
include '../../nav.php';
require_once '../../config/database.php';
require_once '../../modelos/Lugar.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger y validar datos
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $categorias = isset($_POST['categoria']) ? $_POST['categoria'] : [];
    $categoriasTexto = implode(',', $categorias);

    // Obtener lugar existente
    $lugar = Lugar::obtenerLugarPorId($conn, $id);
    if (!$lugar) {
        die("Lugar no encontrado.");
    }

    // Procesar imagen si se ha subido una nueva
    $nuevaRutaImagen = $lugar->getImagen(); // Por defecto, mantener la existente

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorioDestino = '../../imagenes/';
        $nombreArchivo = basename($_FILES['imagen']['name']);
        $rutaArchivo = $directorioDestino . time() . '_' . $nombreArchivo;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaArchivo)) {
            $nuevaRutaImagen = $rutaArchivo;
        } else {
            die("Error al subir la nueva imagen.");
        }
    }

    // Actualizar el lugar
    $lugar->setNombre($nombre);
    $lugar->setDescripcion($descripcion);
    $lugar->setCategoria($categoriasTexto);
    $lugar->setImagen($nuevaRutaImagen);

    $resultado = $lugar->actualizarLugar($conn);
}
include '../footer.php';

?>
