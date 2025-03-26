<?php

class Reseña {
    private $conn;
    private $id;
    private $usuario_id;
    private $lugar_id;
    private $comentario;
    private $calificacion;
    private $fecha;

    // Constructor
    public function __construct($conn, $id = null, $usuario_id = null, $lugar_id = null, $comentario = null, $calificacion = null, $fecha = null) {
        $this->conn = $conn;
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->lugar_id = $lugar_id;
        $this->comentario = $comentario;
        $this->calificacion = $calificacion;
        $this->fecha = $fecha;
    }

    // Método para agregar una reseña
    public function agregarReseña() {
        $stmt = $this->conn->prepare("INSERT INTO reseñas (usuario_id, lugar_id, comentario, calificacion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $this->usuario_id, $this->lugar_id, $this->comentario, $this->calificacion);
        return $stmt->execute();
    }

    // Método para obtener una reseña por ID
    public static function obtenerReseñaPorId($conn, $id) {
        $query = "SELECT * FROM reseñas WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Reseña(
                $conn,
                $row['id'],
                $row['usuario_id'],
                $row['lugar_id'],
                $row['comentario'],
                $row['calificacion'],
                $row['fecha']
            );
        }

        return null;
    }

    // Método para obtener todas las reseñas de un lugar
    public static function obtenerReseñas($conn, $lugar_id) {
        $query = "SELECT * FROM reseñas WHERE lugar_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $lugar_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reseñas = [];

        while ($row = $result->fetch_assoc()) {
            $reseñas[] = new Reseña(
                $conn,
                $row['id'],
                $row['usuario_id'],
                $row['lugar_id'],
                $row['comentario'],
                $row['calificacion'],
                $row['fecha']
            );
        }

        return $reseñas;
    }

    // Método para actualizar una reseña
    public function actualizarReseña($id) {
        $stmt = $this->conn->prepare("UPDATE reseñas SET comentario = ?, calificacion = ? WHERE id = ?");
        $stmt->bind_param("sii", $this->comentario, $this->calificacion, $id);
        return $stmt->execute();
    }

    // Método para eliminar una reseña
    public function eliminarReseña($id) {
        $stmt = $this->conn->prepare("DELETE FROM reseñas WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Método para mostrar información de la reseña
    public function mostrarInformacion() {
        return "Usuario ID: " . $this->usuario_id . ", Lugar ID: " . $this->lugar_id . ", Calificación: " . $this->calificacion . ", Comentario: " . $this->comentario . ", Fecha: " . $this->fecha;
    }

    // Getters y Setters
    public function getId() {
        return $this->id;
    }
    public function getUsuarioId() {
        return $this->usuario_id;
    }
    public function getLugarId() {
        return $this->lugar_id;
    }
    public function getComentario() {
        return $this->comentario;
    }
    public function getCalificacion() {
        return $this->calificacion;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }
    public function setLugarId($lugar_id) {
        $this->lugar_id = $lugar_id;
    }
    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }
    public function setCalificacion($calificacion) {
        $this->calificacion = $calificacion;
    }
}

?>
