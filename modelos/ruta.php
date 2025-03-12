<?php

class Ruta {
    private $conn;
    private $id;
    private $nombre;
    private $descripcion;
    private $intereses;
    private $lugares;

    public function __construct($conn, $id = null, $nombre = "", $descripcion = "", $intereses = "", $lugares = "") {
        $this->conn = $conn;
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->intereses = $intereses;
        $this->lugares = $lugares;
    }

    public function guardarRuta() {
        if ($this->id) {
            $stmt = $this->conn->prepare("UPDATE rutas SET nombre = ?, descripcion = ?, intereses = ?, lugares = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $this->nombre, $this->descripcion, $this->intereses, $this->lugares, $this->id);
        } else {
            $query = "INSERT INTO rutas (nombre, descripcion, intereses, lugares) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssss", $this->nombre, $this->descripcion, $this->intereses, $this->lugares);
        }

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public static function obtenerTodasLasRutas($conn) {
        $query = "SELECT * FROM rutas";
        $resultado = $conn->prepare($query);
        $resultado->execute();
        $result = $resultado->get_result();

        $rutas = [];
        while ($fila = $result->fetch_assoc()) {
            $ruta = new Ruta(
                $conn,
                $fila['id'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['intereses'],
                $fila['lugares']
            );
            $rutas[] = $ruta;
        }
        return $rutas;
    }

    public function generarRuta($interesesIds) {
        $intereses = $this->obtenerInteresesPorIds($interesesIds);
        $interesesString = implode(", ", $intereses);  // Cadena de intereses

        $this->nombre = "Ruta personalizada para: " . implode(", ", $intereses);
        $this->descripcion = "Esta ruta está diseñada para aquellos que disfrutan de los siguientes intereses: " . $interesesString;

        $this->intereses = $interesesString;

        $lugares = $this->obtenerLugaresPorIntereses($interesesIds);
        $this->lugares = implode(", ", $lugares); // Crear una lista de lugares como cadena

        return $this->guardarRuta();
    }

    private function obtenerInteresesPorIds($interesesIds) {
        $intereses = [];
        $query = "SELECT nombre FROM intereses WHERE id IN (" . implode(",", $interesesIds) . ")";
        $resultado = $this->conn->query($query);

        while ($fila = $resultado->fetch_assoc()) {
            $intereses[] = $fila['nombre'];
        }

        return $intereses;
    }

    private function obtenerLugaresPorIntereses($interesesIds) {
        $lugares = [];
        $query = "SELECT l.nombre FROM lugares l 
                  JOIN intereses_lugares il ON il.lugar_id = l.id 
                  WHERE il.interes_id IN (" . implode(",", $interesesIds) . ")";
        $resultado = $this->conn->query($query);

        while ($fila = $resultado->fetch_assoc()) {
            $lugares[] = $fila['nombre'];
        }

        return $lugares;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getIntereses() {
        return $this->intereses;
    }

    public function getLugares() {
        return $this->lugares;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setIntereses($intereses) {
        $this->intereses = $intereses;
    }

    public function setLugares($lugares) {
        $this->lugares = $lugares;
    }
}

?>
