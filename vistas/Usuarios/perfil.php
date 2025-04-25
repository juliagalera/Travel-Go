<?php

$archivo ='C:\xampp\htdocs\Travel-Go\config\database.php';
echo "Intentando cargar: " . $archivo . "<br>";

if (!file_exists($archivo)) {
    die("Archivo no encontrado en: " . realpath($archivo));
} else {
    echo "Archivo encontrado, procediendo a incluirlo.";
}

require_once $archivo;

// require_once 'C:\xampp\htdocs\Travel-Go\config\database.php';
// require_once 'C:\xampp\htdocs\Travel-Go\modelos\usuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre               = trim($_POST['nombre']);
    $email                = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $nueva_contrasena     = trim($_POST['nueva_contrasena']);
    $confirmar_contrasena = trim($_POST['confirmar_contrasena']);

    if (empty($nombre) || empty($email)) {
        echo '<p style="color:red; text-align:center;">El nombre y el email son obligatorios.</p>';
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p style="color:red; text-align:center;">El email no es válido.</p>';
        exit;
    }

    // Validar contraseña solo en caso de que se ingrese algún dato
    if (($nueva_contrasena !== '' || $confirmar_contrasena !== '') && $nueva_contrasena !== $confirmar_contrasena) {
        echo '<p style="color:red; text-align:center;">Las contraseñas no coinciden.</p>';
        exit;
    }

    $nuevoHash = null;
    if (!empty($nueva_contrasena) && !empty($confirmar_contrasena)) {
        if (strlen($nueva_contrasena) < 6) {
            echo '<p style="color:red; text-align:center;">La contraseña debe tener al menos 6 caracteres.</p>';
            exit;
        }
        $nuevoHash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
    }

    // Se crea el objeto Usuario usando el ID almacenado en la sesión
    $usuario = new Usuario($conn, $_SESSION['usuario_id'], $nombre, $email, null, null);

    // Se asume que el método actualizarPerfil($nuevoHash) actualiza el nombre, email y, si $nuevoHash no es null, la contraseña.
    if ($usuario->actualizarPerfil($nuevoHash)) {
        // Actualizar las variables de sesión y redirigir a la página de perfil
        $_SESSION['usuario_nombre'] = $nombre;
        $_SESSION['email']          = $email;
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
