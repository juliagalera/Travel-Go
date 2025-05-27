<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../controladores/guardar_valoracion.php');
require_once(__DIR__ . '/../controladores/UsuarioController.php');

class Valoracion {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function guardar($id_lugar, $id_usuario, $valoracion) {
        $sql = "INSERT INTO valoraciones (id_lugar, id_usuario, valoracion) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE valoracion = VALUES(valoracion)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $id_lugar, $id_usuario, $valoracion);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    public function obtenerPorLugar($id_lugar) {
        $sql = "SELECT v.valoracion, u.nombre AS usuario
                FROM valoraciones v
                JOIN usuarios u ON v.id_usuario = u.id
                WHERE v.id_lugar = ?
                ORDER BY v.fecha DESC"; // Si tienes campo fecha
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_lugar);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $valoraciones = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $valoraciones;
    }
    public function obtenerValoracionesConUsuario($id_lugar) {
    $sql = "SELECT v.valoracion, v.fecha, u.nombre AS usuario_nombre 
            FROM valoraciones v
            JOIN usuarios u ON v.id_usuario = u.id
            WHERE v.id_lugar = ?
            ORDER BY v.fecha DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $id_lugar);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $valoraciones = [];
    while ($fila = $resultado->fetch_assoc()) {
        $valoraciones[] = $fila;
    }

    return $valoraciones;
}

}
