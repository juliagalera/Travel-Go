<?php

require_once 'config/database.php';
require_once 'controladores\UsuarioController.php';

$conn = new mysqli('localhost', 'root','', 'travel_go');

if ($conn->connect_error) {
    die('
    "Error de conexion'. $conn->connect_error);
}

if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    switch ($accion) {
        case 'registrarUsuario':
            require_once 'controladores/UsuarioController.php';
            $controller = new UsuarioController();
            $controller->registrarUsuario();
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
            require_once 'login.php';  
            break;
        }
}else{
    header('Location: vistas/Usuarios/login.php');
    exit();
}


?>

