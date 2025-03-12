<?php
require_once 'config/database.php';
require_once 'modelos\destino.php';

class DestinoController {

    private $conn;

    // Constructor: inicializa la conexión con la base de datos
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Crear un nuevo destino
    public function crearDestino($nombre, $descripcion, $ubicacion, $precio = null) {
        $destino = new Destino($this->conn, null, $nombre, $descripcion, $ubicacion, $precio);
        if ($destino->agregarDestino()) {
            echo "Destino creado exitosamente";
        } else {
            echo "Hubo un error al crear el destino";
        }
    }
    
    public function verDestinos(){
        $destinos = Destino::obtenerTodosDestinos($this->conn);  
        require_once 'vistas/destinos/listarDestinos.php'; 
    }


    public function editarDestino($id, $nuevoNombre, $nuevaDescripcion, $nuevaUbicacion, $nuevoPrecio) {
        $destino = Destino::obtenerDestinoPorId($this->conn, $id);
        if ($destino) {
            $destino->setNombre($nuevoNombre);
            $destino->setDescripcion($nuevaDescripcion);
            $destino->setUbicacion($nuevaUbicacion);
            $destino->setPrecio($nuevoPrecio);
    
            if ($destino->actualizarDestino($id)) {
                echo "Destino actualizado correctamente";
            } else {
                echo "Hubo un error al actualizar el destino";
            }
        } else {
            echo "Destino no encontrado";
        }
    }
    

    // Eliminar un destino por su ID
    public function eliminarDestino($id) {
        $destino = Destino::obtenerDestinoPorId($this->conn, $id);
        
        if (!$destino) {
            echo "Destino no encontrado";
            return;
        }
    
        if ($destino->eliminarDestino($id)) { // <-- Llamando al método de la instancia
            echo "Destino eliminado correctamente";
        } else {
            echo "Hubo un error al eliminar el destino";
        }
    }
    
    

    public function listarDestinos() {
        $destinos = Destino::obtenerTodosDestinos($this->conn);
        if ($destinos) {
            foreach ($destinos as $destino) {
                echo "Destino: " . $destino->getNombre() . "<br>";
                echo "Descripción: " . $destino->getDescripcion() . "<br>";
                echo "Ubicación: " . $destino->getUbicacion() . "<br>";
                echo "Precio: " . $destino->getPrecio() . "<br><br>";
            }
        } else {
            echo "No hay destinos disponibles";
        }
    }
    

    public function obtenerDetallesDestino($id) {
        $destino = Destino::obtenerDestinoPorId($this->conn, $id);
        if ($destino) {
            echo "Destino: " . $destino->getNombre() . "<br>";
            echo "Descripción: " . $destino->getDescripcion() . "<br>";
            echo "Ubicación: " . $destino->getUbicacion() . "<br>";
            echo "Precio: " . $destino->getPrecio() . "<br>";
        } else {
            echo "Destino no encontrado";
        }
    }

    public function buscarDestinos($busqueda){
        $destinos = Destino::buscarDestinos($this->conn, $busqueda);
        if($destinos){
            foreach($destinos as $destino) {
                echo "Destino". $destino->getNombre() . "<br>";
                echo "Descripción". $destino->getDescripcion(). "<br>";
                echo "Ubicacion". $destino->getUbicacion() . "<br>";
                echo "Precio". $destinos->getPrecio() ."<br>";
            }
        }else{
            echo "No se encontró destino";
        }
    }
}  

?>