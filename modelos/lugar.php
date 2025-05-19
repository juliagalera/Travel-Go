<?php
class Lugar {
    private $id;
    private $nombre;
    private $descripcion;
    private $imagen;
    private $categoria; 
    private $conn;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function getCategoria() { 
        return $this->categoria;
    }

    public function setCategoria($categoria) {  
        $this->categoria = $categoria;
    }

    public function __construct($conn, $id = null, $nombre = null, $descripcion = null,  $imagen = null, $categoria = null) {
        $this->conn = $conn;
        $this->id = $id;
        $this->nombre = $nombre ?? null;
        $this->descripcion = $descripcion ?? null;
        $this->imagen = $imagen ?? null;
        $this->categoria = $categoria ?? null;
    }

    // Método para agregar lugar con categoría
    public function agregarLugar() {
        $stmt = $this->conn->prepare("INSERT INTO lugares (nombre, detalle, imagen, categoria) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->nombre, $this->descripcion, $this->imagen, $this->categoria);
        return $stmt->execute();
    }

    // Obtener lugar por id, ahora incluye categoría
    public static function obtenerLugarPorId($conn, $id) {
        $query = "SELECT * FROM lugares WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lugar = new Lugar(
                $conn,
                $row['id'],
                $row['nombre'],
                $row['detalle'],
                $row['imagen'],
                $row['categoria'] 
            );
            return $lugar;
        } else {
            return null;
        }
    }

    // Método para actualizar lugar, incluye categoría
    public function actualizarLugar() {
        $stmt = $this->conn->prepare("UPDATE lugares SET nombre = ?, detalle = ?, imagen = ?, categoria = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $this->nombre, $this->descripcion, $this->imagen, $this->categoria, $this->id);
        return $stmt->execute();
    }


    // Método para eliminar lugar
    public function eliminarLugar() {
        $stmt = $this->conn->prepare("DELETE FROM lugares WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }


    // Método para obtener todos los lugares, incluye categoría
    public static function obtenerTodosLugares($conn) {
        $query = "SELECT * FROM lugares";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $lugares = [];

        while ($row = $result->fetch_assoc()) {
            $lugares[] = new Lugar($conn, $row['id'], $row['nombre'], $row['detalle'], $row['imagen'], $row['categoria']); 
        }

        return $lugares;
    }

    // Método para buscar lugares, incluye categoría en la búsqueda
    public static function buscarLugares($conn, $busqueda) {
        $query = "SELECT * FROM lugares WHERE nombre LIKE ? OR descripcion LIKE ? OR categoria LIKE ?";
        $stmt = $conn->prepare($query);
        $likeBusqueda = "%" . $busqueda . "%";
        $stmt->bind_param("sss", $likeBusqueda, $likeBusqueda, $likeBusqueda);
        $stmt->execute();
        $result = $stmt->get_result();
        $lugares = [];

        while ($row = $result->fetch_assoc()) {
            $lugares[] = new Lugar($conn, $row['id'], $row['nombre'], $row['detalle'], $row['imagen'], $row['categoria']); 
        }

        return $lugares;
    }
}

?>
