<?php

class Reseña{
    private $conn;
    private $id;
    private $usuario_id;
    private $destino_id;
    private $comentario;
    private $calificacion;
    private $fecha;


    public function __construct($conn, $id, $usuario_id, $destino_id, $comentario, $calificacion, $fecha){
        $this->conn = $conn;
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->destino_id = $destino_id;
        $this->comentario = $comentario;
        $this->calificacion = $calificacion;
        $this->fecha = $fecha;
    }

    public function agregarReseña(){
        $stmt = $this->conn->prepare("INSERT INTO reseñas (usuario_id, destino_id, comentario, calificacion) VALUES 
        (?,?,?,?)" );
        $stmt->bind_param("iisi", $this->usuario_id, $this->destino_id, $this->comentario, $this->calificacion);
        $stmt->execute();
    }

    public static function obtenerReseñaPorId($conn, $id) {
        $query = "SELECT * FROM reseñas WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_object(); 
        }
    
        return null;
    }
    public static function obtenerReseñas($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM reseñas WHERE destino_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function actualizarReseña($id){
        $stmt = $this->conn->prepare("UPDATE reseñas SET comentario = ?, calificacion =? WHERE id = ?");
        $stmt->bind_param("sii", $this->comentario, $this->calificacion, $id);
        return $stmt->execute();

    }
    public function eliminarReseña($id){
        $stmt  = $this->conn->prepare("DELETE from reseñas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

    }

    public function mostrarInformacion(){
        return "Usuario ID: " . $this->usuario_id . ", Destino ID: " . $this->destino_id . ", Calificación: " . $this->calificacion . ", Comentario: " . $this->comentario . ", Fecha: " . $this->fecha;
    }

    public function getId(){
        return $this->id;
    }
    public function getUsuarioId(){
        return $this->usuario_id;
    }
    public function getDestinoId(){
        return $this->destino_id;
    }
    public function getComentario(){
        return $this->comentario;
    }
    public function getCalificacion(){
        return $this->calificacion;
    }

    public function setUsuarioId($usuario_id){
        $this->usuario_id = $usuario_id;
    }
    public function setDestinoId($destino_id){
        $this->destino_id = $destino_id;
    }

    public function setComentario($comentario){
        $this->comentario = $comentario;
    }

    public function setCalificacion($calificacion){
        $this->calificacion = $calificacion;
    }


}


?>