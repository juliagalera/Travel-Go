<?php
class Lugar {
    private $id;
    private $nombre;
    private $descripcion;
    private $ubicacion;
    private $imagen;
    private $conn;

    // Getters y Setters
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
    public function getUbicacion() {
        return $this->ubicacion;
    }
    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }
    public function getImagen() {
        return $this->imagen;
    }
    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    // Constructor
    public function __construct($conn, $id = null, $nombre = null, $descripcion = null, $ubicacion = null, $imagen = null) {
        $this->conn = $conn;
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->ubicacion = $ubicacion;
        $this->imagen = $imagen;
    }

    // Método para agregar un lugar
    public function agregarLugar() {
        $stmt = $this->conn->prepare("INSERT INTO lugares (nombre, descripcion, ubicacion, imagen) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->nombre, $this->descripcion, $this->ubicacion, $this->imagen);
        return $stmt->execute();
    }

    // Método para obtener un lugar por ID
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
                $row['descripcion'],
                $row['ubicacion'],
                $row['imagen']
            );
            return $lugar;
        } else {
            return null;
        }
    }

    // Método para actualizar un lugar
    public function actualizarLugar($id) {
        $stmt = $this->conn->prepare("UPDATE lugares SET nombre = ?, descripcion = ?, ubicacion = ?, imagen = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $this->nombre, $this->descripcion, $this->ubicacion, $this->imagen, $id);
        return $stmt->execute();
    }

    // Método para eliminar un lugar
    public function eliminarLugar($id) {
        $stmt = $this->conn->prepare("DELETE FROM lugares WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Método para obtener todos los lugares
    public static function obtenerTodosLugares($conn) {
        $query = "SELECT * FROM lugares";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $lugares = [];

        while ($row = $result->fetch_assoc()) {
            $lugares[] = new Lugar($conn, $row['id'], $row['nombre'], $row['descripcion'], $row['ubicacion'], $row['imagen']);
        }

        return $lugares;
    }

    // Método para buscar lugares por término
    public static function buscarLugares($conn, $busqueda) {
        $query = "SELECT * FROM lugares WHERE nombre LIKE ? OR ubicacion LIKE ?";
        $stmt = $conn->prepare($query);
        $likeBusqueda = "%" . $busqueda . "%";
        $stmt->bind_param("ss", $likeBusqueda, $likeBusqueda);
        $stmt->execute();
        $result = $stmt->get_result();
        $lugares = [];

        while ($row = $result->fetch_assoc()) {
            $lugares[] = new Lugar($conn, $row['id'], $row['nombre'], $row['descripcion'], $row['ubicacion'], $row['imagen']);
        }

        return $lugares;
    }
}
?>
