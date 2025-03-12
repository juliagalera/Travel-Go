<?php
require_once 'config/database.php';
require_once 'modelos/reseña.php';

class ReseñaController {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Método para crear una reseña
    public function crearReseña($usuario_id, $destino_id, $comentario, $calificacion){
        // Validación de datos
        if (empty($comentario) || !is_numeric($calificacion) || $calificacion < 1 || $calificacion > 5) {
            return $this->respuestaJSON(false, 'Datos inválidos');
        }

        $fecha = date('Y-m-d H:i:s'); // Fecha actual

        $reseña = new Reseña($this->conn, null, $usuario_id, $destino_id, $comentario, $calificacion, $fecha);
        
        try {
            if ($reseña->agregarReseña()) {
                return $this->respuestaJSON(true, 'Reseña guardada con éxito');
            } else {
                return $this->respuestaJSON(false, 'Hubo un error al guardar la reseña');
            }
        } catch (Exception $e) {
            return $this->respuestaJSON(false, 'Error en el servidor: ' . $e->getMessage());
        }
    }

    // Método para editar una reseña
    public function editarReseña($id, $nuevoComentario, $nuevaCalificacion){
        // Validación de datos
        if (empty($nuevoComentario) || !is_numeric($nuevaCalificacion) || $nuevaCalificacion < 1 || $nuevaCalificacion > 5) {
            return $this->respuestaJSON(false, 'Datos inválidos');
        }

        $reseña = Reseña::obtenerReseñaPorId($this->conn, $id);
        
        if (!$reseña) {
            return $this->respuestaJSON(false, 'Reseña no encontrada');
        }

        $reseña->setComentario($nuevoComentario);
        $reseña->setCalificacion($nuevaCalificacion);
        
        try {
            if ($reseña->actualizarReseña($id)) {
                return $this->respuestaJSON(true, 'Reseña actualizada');
            } else {
                return $this->respuestaJSON(false, 'Hubo un error al actualizar la reseña');
            }
        } catch (Exception $e) {
            return $this->respuestaJSON(false, 'Error en el servidor: ' . $e->getMessage());
        }
    }

    // Método para borrar una reseña
    public function borrarReseña($id){
        $reseña = Reseña::obtenerReseñaPorId($this->conn, $id);
        
        if (!$reseña) {
            return $this->respuestaJSON(false, 'Reseña no encontrada');
        }

        try {
            $reseña->eliminarReseña($id);
            return $this->respuestaJSON(true, 'Reseña eliminada correctamente');
        } catch (Exception $e) {
            return $this->respuestaJSON(false, 'Error en el servidor: ' . $e->getMessage());
        }
    }

    // Método para listar todas las reseñas de un destino
    public function listarReseñas($destino_id){
        $reseñas = Reseña::obtenerReseñas($this->conn, $destino_id);
        
        if (empty($reseñas)) {
            return $this->respuestaJSON(false, 'No se encontraron reseñas');
        }

        return $this->respuestaJSON(true, 'Reseñas encontradas', $reseñas);
    }

    // Método para obtener detalles de una reseña
    public function obtenerDetallesReseña($id){
        $reseña = Reseña::obtenerReseñaPorId($this->conn, $id);
        
        if (!$reseña) {
            return $this->respuestaJSON(false, 'Reseña no encontrada');
        }

        // Obtener detalles en formato adecuado
        $detalles = [
            'id' => $reseña->getId(),
            'comentario' => $reseña->getComentario(),
            'calificacion' => $reseña->getCalificacion(),
            'usuario_id' => $reseña->getUsuarioId(),
            'destino_id' => $reseña->getDestinoId(),
        ];

        return $this->respuestaJSON(true, 'Detalles de la reseña', $detalles);
    }

    // Método para devolver respuestas JSON
    private function respuestaJSON($exito, $mensaje, $datos = null){
        $respuesta = [
            'exito' => $exito,
            'mensaje' => $mensaje,
        ];

        if ($datos !== null) {
            $respuesta['datos'] = $datos;
        }

        return json_encode($respuesta);
    }
}
?>
