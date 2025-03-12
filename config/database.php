<?php
$host = 'localhost';
$user = 'root';
$passwd = '';
$dbname = 'travel_go';


$conn = new mysqli($host, $user, $passwd, $dbname);

//Comprobamos que conecta
if($conn->connect_error){
    echo "Error de conexión" . $conn->connect_error;
}

//Creación base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

if($conn->query($sql)== TRUE){
    echo "Base de datos creada correctamente";

}else{
    die("Error al crear la base de datos ". $conn->error);
}

$conn->select_db($dbname);

//Creación tabla usuarios
$sql="CREATE TABLE IF NOT EXISTS usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($sql);

//Creación tabla deestinos
$sql = "CREATE TABLE IF NOT EXISTS destinos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    ubicación VARCHAR(255),
    imagen VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($sql);

//Creación tabla reseñas
$sql = "CREATE TABLE IF NOT EXISTS reseñas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    destino_id INT,
    comentario TEXT,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (destino_id) REFERENCES destinos(id) ON DELETE CASCADE
)"; 

$conn->query($sql);

$sql = "CREATE TABLE rutas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    intereses TEXT,  
    lugares TEXT
)";

$conn->query($sql);

$sql = "CREATE TABLE intereses (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    nombre VARCHAR(255) NOT NULL
)";

$conn->query($sql);
$sql = "CREATE TABLE lugares (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(255) NOT NULL
)";
$conn->query($sql);

$sql = "CREATE TABLE intereses_lugares (
    interes_id INT,                
    lugar_id INT,   
    FOREIGN KEY (interes_id) REFERENCES intereses(id), 
    FOREIGN KEY (lugar_id) REFERENCES lugares(id),  
    PRIMARY KEY (interes_id, lugar_id)
)";
$conn->query($sql);


echo "tablas creadas correctamente";



$conn->close();
?>