<?php
// Cargar la configuración de la base de datos
require 'config/database.php';
require_once 'controladores/UsuarioController.php';
require_once 'controladores/RutasController.php';
require_once 'controladores/ReseñaController.php';
require_once 'controladores/DestinoController.php';

$accion = $_GET['accion'] ?? null;


$conn = $conn;  // Esto ya está instanciado desde el archivo 'database.php'

// Crear las instancias de los controladores
$usuarioController = new UsuarioController($conn);
$rutaController = new RutaController($conn);
$resenaController = new ReseñaController($conn);
$destinoController = new DestinoController($conn);


switch ($accion) {
    // Rutas para el controlador de Usuario
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
    
    // Rutas para el controlador de Ruta
    case 'listarRutas':
        $rutaController->obtenerDetallesRuta();
        break;

    case 'generarRuta':
        $rutaController->generarRuta();
        break;

    // Rutas para el controlador de Resena
    case 'agregarReseña':
        $resenaController->crearReseña();
        break;

    // Rutas para el controlador de Destino
    case 'verDestinos':
        $destinoController->verDestinos();  
        break;

   
    default:
        require_once 'index.php';  
        break;
}
?>
