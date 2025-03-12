<?php
class Destino{
    private $id;
    private $nombre;
    private $descripcion;
    private $ubicacion;
    private $precio;
    private $conn;
    
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function getUbicacion(){
        return $this->ubicacion;
    }
    public function setUbicacion($ubicacion){
        $this->ubicacion = $ubicacion;
    }

    public function getPrecio(){
        return $this->precio;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }

    public function __construct($conn, $id, $nombre, $descripcion, $ubicacion, $precio){
        $this->conn = $conn;
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion= $descripcion;
        $this->ubicacion = $ubicacion;
        $this->precio = $precio;
    }

    //Método para agregar un nuevo destino

    public function agregarDestino(){
        $stmt= $this->conn->prepare("INSERT INTO destinos(nombre, descripcion, ubicacion, precio)VALUES
        (?,?,?,?)");
        $stmt->bind_param("sssd", $this->nombre, $this->descripcion, $this->ubicacion, $this->precio);
        return $stmt->execute();
    }



     public static function obtenerDestinoPorId($conn, $id) {
        $query = "SELECT * FROM destinos WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $destino = new Destino(
                $conn,
                $row['id'],
                $row['nombre'],
                $row['descripcion'],
                $row['ubicacion'],
                $row['precio']
            );
            return $destino;
        } else {
            return null;
        }
    }


    public function actualizarDestino($id){
        $stmt = $this->conn->prepare("UPDATE destinos SET nombre = ?, descripcion = ?, ubicacion = ?, precio=? WHERE id = ?");
        $stmt->bind_param("sssdi", $this->nombre, $this->descripcion, $this->ubicacion, $this->precio, $id);
        return $stmt->execute();
    }

    //Método para borrar un destino
    public function eliminarDestino($id){
        $stmt = $this->conn->prepare("DELETE FROM destinos WHERE id= ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();

    }
    public static function obtenerTodosDestinos($conn) {
        $query = "SELECT * FROM destinos";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $destinos = [];
        
        while ($row = $result->fetch_assoc()) {
            $destinos[] = new Destino($conn, $row['id'], $row['nombre'], $row['descripcion'], $row['ubicacion']);
        }

        return $destinos;
    }

    public function mostrarInformacionDestinos(){
        return "ID: ". $this->id . ", nombre: ". $this->nombre. ", descripcion: ". $this->descripcion . ", ubicacion: ".
        $this->ubicacion . ", precio: ". $this->precio;
    }
    public static function existeDestino($conn, $id) {
        $query = "SELECT COUNT(*) AS total FROM destinos WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['total'] > 0;
    }

    public static function buscarDestinos($conn, $busqueda){
        $query = "SELECT * FROM destinos WHERE nombre LIKE ? OR ubicacion LIKE ?";
        $stmt = $conn->prepare($query);
        $likeBusqueda= "%".$busqueda."%";
        $stmt->bind_param("ss", $likeBusqueda, $likeBusqueda);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $destinos=[];
        while($fila = $resultado->fetch_assoc()){
            $destinos[]= new Destino ($conn, $fila['id'], $fila['nombre'], $fila['descripcion'], $fila['ubicacion'], $fila['precio']);
        }
        return $destinos;
        
    }
    

}
?>