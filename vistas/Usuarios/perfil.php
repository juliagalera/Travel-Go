<?php

// Asegúrate de que no haya salida antes de session_start()
session_start();

// Cambia las rutas a rutas relativas si es necesario
require_once ('C:/xampp/htdocs/Travel-Go/config/database.php');
require_once ('C:/xampp/htdocs/Travel-Go/modelos/usuario.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y validar entradas
    $nombre = trim($_POST['nombre']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $nueva_contrasena = trim($_POST['nueva_contrasena']);
    $confirmar_contrasena = trim($_POST['confirmar_contrasena']);

    if (empty($nombre) || empty($email)) {
        echo '<p style="color:red; text-align:center;">El nombre y el email son obligatorios.</p>';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p style="color:red; text-align:center;">El email no es válido.</p>';
        exit;
    }

    // Validar contraseña solo si se proporciona
    if (!empty($nueva_contrasena) || !empty($confirmar_contrasena)) {
        if ($nueva_contrasena !== $confirmar_contrasena) {
            echo '<p style="color:red; text-align:center;">Las contraseñas no coinciden.</p>';
            exit;
        }

        if (strlen($nueva_contrasena) < 6) {
            echo '<p style="color:red; text-align:center;">La contraseña debe tener al menos 6 caracteres.</p>';
            exit;
        }
    }

    // Generar el hash de la nueva contraseña si se proporciona
    $nuevoHash = null;
    if (!empty($nueva_contrasena)) {
        $nuevoHash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
    }

    // Verificar si la sesión contiene el ID del usuario
    if (!isset($_SESSION['usuario_id'])) {
        echo '<p style="color:red; text-align:center;">La sesión ha expirado. Por favor, inicia sesión nuevamente.</p>';
        exit;
    }

    // Crear objeto Usuario
    $usuario_id = $_SESSION['usuario_id'];
    $usuario = new Usuario($conn, $usuario_id, $nombre, $email, null, null);

    // Actualizar perfil
    if ($usuario->actualizarPerfil($nombre, $apellido, $email, $nuevoHash)) {
        // Actualizar variables de sesión
        $_SESSION['usuario_nombre'] = $nombre;
        $_SESSION['email'] = $email;

        // Redirigir al perfil
        header("Location: perfil.php");
        exit;
    } else {
        echo '<p style="color:red; text-align:center;">Error al actualizar el perfil.</p>';
        exit;
    }
} else {
    header("Location: perfil.php");
    exit;
}
?>