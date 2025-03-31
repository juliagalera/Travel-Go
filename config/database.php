<?php
$host = 'localhost';
$user = 'root';
$passwd = '';
$dbname = 'travel_go';

$conn = new mysqli($host, $user, $passwd);

// Comprobar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si la base de datos ya existe y seleccionarla
if (!$conn->select_db($dbname)) {
    $sql = "CREATE DATABASE $dbname";
    $conn->query($sql); // Crear la base de datos si no existe
}

$conn->select_db($dbname);

// Crear tabla usuarios si no existe
$sql = "CREATE TABLE IF NOT EXISTS usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Crear tabla lugares si no existe
$sql = "CREATE TABLE IF NOT EXISTS lugares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripción TEXT,
    ubicacion VARCHAR(255),
    imagen VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Crear tabla reseñas si no existe
$sql = "CREATE TABLE IF NOT EXISTS resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    lugar_id INT,
    comentario TEXT,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (lugar_id) REFERENCES lugares(id) ON DELETE CASCADE
)";
$conn->query($sql);

// Crear tabla intereses si no existe
$sql = "CREATE TABLE IF NOT EXISTS intereses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
)";
$conn->query($sql);

// Crear tabla intereses_lugares si no existe
$sql = "CREATE TABLE IF NOT EXISTS intereses_lugares (
    interes_id INT,
    lugar_id INT,
    FOREIGN KEY (interes_id) REFERENCES intereses(id),
    FOREIGN KEY (lugar_id) REFERENCES lugares(id),
    PRIMARY KEY (interes_id, lugar_id)
)";
$conn->query($sql);

$conn->close();
?>
