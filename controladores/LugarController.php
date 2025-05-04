<?php
require 'config/database.php';
require 'modelos/lugar.php';

class LugarController {

    private $conn;

    // Constructor: inicializa la conexión con la base de datos
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Crear un nuevo lugar
    public function crearLugar($nombre, $descripcion, $ubicacion, $imagen = null) {
        // Validar datos
        $nombre = htmlspecialchars(trim($nombre));
        $descripcion = htmlspecialchars(trim($descripcion));
        $ubicacion = htmlspecialchars(trim($ubicacion));

        if (empty($nombre) || empty($descripcion) || empty($ubicacion)) {
            echo "Todos los campos son obligatorios.";
            return;
        }

        // Verificar imagen
        $imagenPath = null;
        if ($imagen) {
            // Verificación simple de la imagen (tamaño, tipo, etc.)
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $imageExtension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

            if (!in_array($imageExtension, $allowedExtensions)) {
                echo "El archivo de imagen no es válido.";
                return;
            }

            if ($imagen['size'] > 2000000) { // 2MB máximo
                echo "La imagen es demasiado grande. El tamaño máximo es 2MB.";
                return;
            }

            $imagenPath = 'uploads/' . basename($imagen['name']);
            move_uploaded_file($imagen['tmp_name'], $imagenPath);
        }

        $lugar = new Lugar($this->conn, null, $nombre, $descripcion, $ubicacion, $imagenPath);
        if ($lugar->agregarLugar()) {
            header("Location: listarLugares.php"); // Redireccionar después de crear el lugar
            exit();
        } else {
            echo "Hubo un error al crear el lugar.";
        }
    }

    // Ver lista de lugares
    public function listarLugares() {
        $lugares = Lugar::obtenerTodosLugares($this->conn);
        require_once 'vistas/lugares/listarLugares.php'; 
    }

    // Editar un lugar
    public function editarLugar($id, $nuevoNombre, $nuevaDescripcion, $nuevaUbicacion, $nuevaImagen) {
        // Validar datos
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

            // Verificar si se sube una nueva imagen
            if ($nuevaImagen) {
                // Verificación simple de la imagen
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $imageExtension = strtolower(pathinfo($nuevaImagen['name'], PATHINFO_EXTENSION));

                if (!in_array($imageExtension, $allowedExtensions)) {
                    echo "El archivo de imagen no es válido.";
                    return;
                }

                if ($nuevaImagen['size'] > 2000000) { // 2MB máximo
                    echo "La imagen es demasiado grande. El tamaño máximo es 2MB.";
                    return;
                }

                $imagenPath = 'uploads/' . basename($nuevaImagen['name']);
                move_uploaded_file($nuevaImagen['tmp_name'], $imagenPath);
                $lugar->setImagen($imagenPath);
            }

            if ($lugar->actualizarLugar($id)) {
                header("Location: listarLugares.php"); // Redireccionar después de editar
                exit();
            } else {
                echo "Hubo un error al actualizar el lugar.";
            }
        } else {
            echo "Lugar no encontrado";
        }
    }

    // Eliminar un lugar por su ID
    public function eliminarLugar($id) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);
        
        if (!$lugar) {
            echo "Lugar no encontrado";
            return;
        }
    
        if ($lugar->eliminarLugar($id)) {
            header("Location: listarLugares.php"); // Redireccionar después de eliminar
            exit();
        } else {
            echo "Hubo un error al eliminar el lugar";
        }
    }
    
    // Obtener detalles de un lugar específico
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

    // Buscar lugares por término de búsqueda
    public function buscarLugares($busqueda) {
        $busqueda = htmlspecialchars(trim($busqueda)); // Sanitizar la búsqueda
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
