<?php
require 'config/database.php';
require 'modelos/lugar.php';

class LugarController {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function crearLugar($nombre, $descripcion, $ubicacion, $imagen = null) {
        $nombre = htmlspecialchars(trim($nombre));
        $descripcion = htmlspecialchars(trim($descripcion));
        $ubicacion = htmlspecialchars(trim($ubicacion));

        if (empty($nombre) || empty($descripcion) || empty($ubicacion)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        $imagenPath = null;
        if ($imagen && $imagen['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $imageExtension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            if (!in_array($imageExtension, $allowedExtensions)) {
                echo "El archivo de imagen no es válido.";
                return;
            }

            if ($imagen['size'] > 2000000) {
                echo "La imagen es demasiado grande. El tamaño máximo es 2MB.";
                return;
            }

            $imagenPath = 'uploads/' . basename($imagen['name']);
            if (!move_uploaded_file($imagen['tmp_name'], $imagenPath)) {
                echo "Error al subir la imagen.";
                return;
            }
        }

        $lugar = new Lugar($this->conn, null, $nombre, $descripcion, $ubicacion, $imagenPath);
        if ($lugar->agregarLugar()) {
            header("Location: listarLugares.php");
            exit();
        } else {
            echo "Hubo un error al crear el lugar.";
        }
    }

    public function listarLugares() {
        $lugares = Lugar::obtenerTodosLugares($this->conn);
        require_once 'vistas/lugares/listarLugares.php'; 
    }

    public function editarLugar($id, $nuevoNombre, $nuevaDescripcion, $nuevaUbicacion, $nuevaImagen = null) {
        $nuevoNombre = htmlspecialchars(trim($nuevoNombre));
        $nuevaDescripcion = htmlspecialchars(trim($nuevaDescripcion));
        $nuevaUbicacion = htmlspecialchars(trim($nuevaUbicacion));

        if (empty($nuevoNombre) || empty($nuevaDescripcion) || empty($nuevaUbicacion)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);
        if ($lugar) {
            $lugar->setNombre($nuevoNombre);
            $lugar->setDescripcion($nuevaDescripcion);
            $lugar->setUbicacion($nuevaUbicacion);

            if ($nuevaImagen && $nuevaImagen['error'] === UPLOAD_ERR_OK) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $imageExtension = strtolower(pathinfo($nuevaImagen['name'], PATHINFO_EXTENSION));

                if (!in_array($imageExtension, $allowedExtensions)) {
                    echo "El archivo de imagen no es válido.";
                    return;
                }

                if ($nuevaImagen['size'] > 2000000) {
                    echo "La imagen es demasiado grande. El tamaño máximo es 2MB.";
                    return;
                }

                $imagenPath = 'uploads/' . basename($nuevaImagen['name']);
                if (!move_uploaded_file($nuevaImagen['tmp_name'], $imagenPath)) {
                    echo "Error al subir la imagen.";
                    return;
                }

                $lugar->setImagen($imagenPath);
            }

            if ($lugar->actualizarLugar($id)) {
                header("Location: listarLugares.php");
                exit();
            } else {
                echo "Hubo un error al actualizar el lugar.";
            }
        } else {
            echo "Lugar no encontrado";
        }
    }

    public function eliminarLugar($id) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);

        if (!$lugar) {
            echo "Lugar no encontrado";
            return;
        }

        if ($lugar->eliminarLugar($id)) {
            header("Location: listarLugares.php");
            exit();
        } else {
            echo "Hubo un error al eliminar el lugar";
        }
    }

    public function obtenerDetallesLugar($id) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);
        if ($lugar) {
            echo "Lugar: " . $lugar->getNombre() . "<br>";
            echo "Descripción: " . $lugar->getDescripcion() . "<br>";
            echo "Ubicación: " . $lugar->getUbicacion() . "<br>";
            echo "Imagen: " . $lugar->getImagen() . "<br>";
        } else {
            echo "Lugar no encontrado";
        }
    }

    public function buscarLugares($busqueda) {
        $busqueda = htmlspecialchars(trim($busqueda)); 
        $lugares = Lugar::buscarLugares($this->conn, $busqueda);

        if ($lugares) {
            foreach ($lugares as $lugar) {
                echo "Lugar: " . $lugar->getNombre() . "<br>";
                echo "Descripción: " . $lugar->getDescripcion() . "<br>";
                echo "Ubicación: " . $lugar->getUbicacion() . "<br>";
                echo "Imagen: " . $lugar->getImagen() . "<br><br>";
            }
        } else {
            echo "No se encontraron lugares";
        }
    }
}
?>
