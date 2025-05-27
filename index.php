<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="seccion-carrusel">
        <div class="carrusel">
            <img src="img/granada1.jpg" alt="Imagen Granada 1">
            <img src="img/granada2.jpg" alt="Imagen Granada 2">
            <img src="img/granada3.jpg" alt="Imagen Granada 3">
            <img src="img/granada4.jpg" alt="Imagen Granada 4">
        </div>
        <div class="texto-carrusel">
            <h1>Bienvenido a Travel & Go</h1>
        </div>
        <button class="prev">‹</button>
        <button class="next">›</button>
    </div>

    <div class="welcome">
        <h1>Ven a visitar Granada...</h1>
        <button id="iniciarSesion">Ya tengo cuenta</button>
        <button id="crearSesion">Aún no tengo cuenta</button>
        <a href="inicio.php">Aún no me quiero identificar</a>
    </div>
</div>

<?php

require 'config/database.php';
require 'controladores/UsuarioController.php';

session_start();

if (isset($_COOKIE['usuario_recordado']) && !isset($_SESSION['email'])) {
    $usuario = new Usuario($conn);
    $datosUsuario = $usuario->obtenerUsuarioPorEmail($_COOKIE['usuario_recordado']);

    if ($datosUsuario) {
        $_SESSION['usuario_id'] = $datosUsuario['id'];
        $_SESSION['usuario_nombre'] = $datosUsuario['nombre'];
        $_SESSION['email'] = $datosUsuario['email'];
    }
}

if (!isset($conn) || !$conn) {
    $conn = new mysqli('localhost', 'root', '', 'travel_go');
    if ($conn->connect_error) {
        die("Error en la conexión a la base de datos: " . $conn->connect_error);
    }
}

if (isset($_GET['action'])) {
    $usuarioController = new UsuarioController($conn); 
    $accion = htmlspecialchars($_GET['action']); 
    echo($accion);
    switch ($accion) {
        case 'registrarUsuario':
            $usuarioController->registrarUsuario();
            break;

        case 'iniciarSesion':
            $usuarioController->iniciarSesion();
            break;

        case 'listarUsuarios':
            $usuarioController->listarUsuarios();
            break;

        case 'eliminarUsuario':
            $usuarioController->eliminarUsuario();
            break;

        case 'listarRutas':
            require_once 'controladores/RutaController.php';
            $rutaController = new RutaController($conn);
            break;

        case 'generarRuta':
            require_once 'controladores/RutaController.php';
            $rutaController = new RutaController($conn); 
            $rutaController->generarRuta();
            break;

        case 'agregarReseña':
            require_once 'controladores/ResenaController.php';
            $resenaController = new ResenaController($conn); 
            $resenaController->crearReseña();
            break;

        case 'verDestinos':
            require_once 'controladores/DestinoController.php';
            $destinoController = new DestinoController($conn); 
            $destinoController->verDestinos();
            break;

        default:
            echo "Acción no reconocida.";
            break;
    }
} 
?>

<script>
const carrusel = document.querySelector('.carrusel');
const images = document.querySelectorAll('.carrusel img');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let index = 0;
const intervalTime = 3000;

function showImage() {
    carrusel.style.transform = `translateX(-${index * 100}%)`;
}

function nextImage() {
    index = (index + 1) % images.length; 
    showImage();
}

function prevImage() {
    index = (index - 1 + images.length) % images.length; 
    showImage();
}

let autoSlide = setInterval(nextImage, intervalTime);

nextButton.addEventListener('click', () => {
    nextImage();
    clearInterval(autoSlide);
    autoSlide = setInterval(nextImage, intervalTime);
});

prevButton.addEventListener('click', () => {
    prevImage();
    clearInterval(autoSlide);
    autoSlide = setInterval(nextImage, intervalTime);
});

document.getElementById("iniciarSesion").addEventListener('click', () => {
    window.location.href="vistas/Usuarios/login.php";
});

document.getElementById("crearSesion").addEventListener('click', () => {
    window.location.href = "vistas/Usuarios/registro.php";
});
</script>
</body>
</html>
