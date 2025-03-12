<?php
require_once 'config/database.php';
require_once 'modelos/ruta.php';

class RutaController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Método para generar una ruta personalizada según los intereses
    public function generarRuta($intereses) {
        $nombre = "Ruta personalizada";
        $descripcion = "Esta ruta está basada en tus intereses en: " . implode(", ", $intereses);
        $lugares = ""; 

        $interesesString = implode(",", $intereses);

        // Crear objeto Ruta
        $ruta = new Ruta($this->conn, null, $nombre, $descripcion, $interesesString, $lugares);
        
        // Intentar guardar la ruta
        if ($ruta->guardarRuta()) {
            echo "Ruta generada y guardada con éxito.";
        } else {
            echo "Hubo un error al guardar la ruta.";
        }
    }

    // Obtener detalles de todas las rutas (o se puede hacer por ID si es necesario)
    public function obtenerDetallesRuta() {
        $rutas = Ruta::obtenerTodasLasRutas($this->conn);  // Ahora es un array de rutas
        if (count($rutas) > 0) {
            foreach ($rutas as $ruta) {
                echo "Ruta: " . $ruta->getNombre() . "<br>";
                echo "Descripción: " . $ruta->getDescripcion() . "<br>";
                echo "Intereses: " . $ruta->getIntereses() . "<br>";
                echo "Lugares: " . $ruta->getLugares() . "<br><br>";
            }
        } else {
            echo "No se encontraron rutas.";
        }
    }

    // Si necesitas obtener los detalles de una ruta específica, por ID
    public function obtenerRutaPorId($id) {
        $ruta = Ruta::obtenerRutaPorId($this->conn, $id);
        if ($ruta) {
            echo "Ruta: " . $ruta->getNombre() . "<br>";
            echo "Descripción: " . $ruta->getDescripcion() . "<br>";
            echo "Intereses: " . $ruta->getIntereses() . "<br>";
            echo "Lugares: " . $ruta->getLugares() . "<br>";
        } else {
            echo "Ruta no encontrada.";
        }
    }
}
?>
