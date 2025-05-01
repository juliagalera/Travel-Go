<?php
require 'config/database.php';
require 'modelos\lugar.php';

class LugarController {

    private $conn;

    // Constructor: inicializa la conexión con la base de datos
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Crear un nuevo lugar
    public function crearLugar($nombre, $descripcion, $ubicacion, $imagen = null) {
        $lugar = new Lugar($this->conn, null, $nombre, $descripcion, $ubicacion, $imagen);
        if ($lugar->agregarLugar()) {
            echo "Lugar creado exitosamente";
        } else {
            echo "Hubo un error al crear el lugar";
        }
    }
    
    // Ver lista de lugares
    public function listarLugares() {
        $lugares = Lugar::obtenerTodosLugares($this->conn);
        require_once 'vistas/lugares/listarLugares.php'; 
    }

    // Editar un lugar
    public function editarLugar($id, $nuevoNombre, $nuevaDescripcion, $nuevaUbicacion, $nuevaImagen) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);
        if ($lugar) {
            $lugar->setNombre($nuevoNombre);
            $lugar->setDescripcion($nuevaDescripcion);
            $lugar->setUbicacion($nuevaUbicacion);
            $lugar->setImagen($nuevaImagen);
    
            if ($lugar->actualizarLugar($id)) {
                echo "Lugar actualizado correctamente";
            } else {
                echo "Hubo un error al actualizar el lugar";
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
            echo "Lugar eliminado correctamente";
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
