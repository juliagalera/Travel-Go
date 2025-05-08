<?php
session_start();

require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/../../modelos/usuario.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /Travel-Go/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener datos actuales del usuario desde la BD
$usuario = Usuario::obtenerPorId($conn, $usuario_id); // Método que debes tener en tu clase Usuario
if (!$usuario) {
    echo "<p style='color:red; text-align:center;'>No se pudo cargar la información del usuario.</p>";
    exit;
}

// Si se envió el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $nueva_contrasena = trim($_POST['nueva_contrasena']);
    $confirmar_contrasena = trim($_POST['confirmar_contrasena']);

    // Validaciones
    if (empty($nombre) || empty($email)) {
        $error = "El nombre y el email son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El email no es válido.";
    } elseif (!empty($nueva_contrasena) || !empty($confirmar_contrasena)) {
        if ($nueva_contrasena !== $confirmar_contrasena) {
            $error = "Las contraseñas no coinciden.";
        } elseif (strlen($nueva_contrasena) < 6) {
            $error = "La contraseña debe tener al menos 6 caracteres.";
        }
    }

    // Si no hay errores, actualizar
    if (!isset($error)) {
        $nuevoHash = !empty($nueva_contrasena) ? password_hash($nueva_contrasena, PASSWORD_BCRYPT) : null;

        $usuarioObj = new Usuario($conn, $usuario_id, $nombre, $email, null, null);
        $actualizado = $usuarioObj->actualizarPerfil($nombre, $usuario['apellido'], $email, $nuevoHash);

        if ($actualizado) {
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['email'] = $email;
            header("Location: perfil.php");
            exit;
        } else {
            $error = "Error al actualizar el perfil.";
        }
    }
}

// Eliminar cuenta
if (isset($_GET['eliminar']) && $_GET['eliminar'] == '1') {
    // Eliminar el usuario de la base de datos
    $usuarioObj = new Usuario($conn, $usuario_id, null, null, null, null);
    $eliminado = $usuarioObj->eliminarUsuario();

    if ($eliminado) {
        session_destroy(); // Destruir sesión
        setcookie('usuario_recordado', '', time() - 3600, '/'); // Eliminar la cookie si existe
        header("Location: /Travel-Go/index.php"); // Redirigir al inicio
        exit;
    } else {
        $error = "Hubo un problema al eliminar tu cuenta.";
    }
}

?>

<?php include_once(__DIR__ . '/../../nav.php'); ?>

<main style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <h2 style="text-align: center; color: #e91e63;">Mi Perfil</h2>

    <p style="text-align: center;">Hola, <strong><?= htmlspecialchars($usuario['nombre']) ?></strong> 👋</p>

    <?php if (isset($_GET['editar']) || $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?= $error ?></p>
        <?php endif; ?>

        <form method="post" style="display: flex; flex-direction: column; gap: 1rem; padding: 1rem;">
            <label>Nombre:
                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </label>
            <label>Email:
                <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            </label>
            <label>Nueva contraseña:
                <input type="password" name="nueva_contrasena" placeholder="Opcional">
            </label>
            <label>Confirmar contraseña:
                <input type="password" name="confirmar_contrasena" placeholder="Opcional">
            </label>
            <button type="submit" style="background-color: #e91e63; color: white; padding: 0.5rem;">Guardar cambios</button>
            <a href="perfil.php" style="text-align:center; color: #555;">Cancelar</a>
        </form>
    <?php else: ?>
        <div style="text-align: center; padding: 1rem;">
            <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
            <a href="perfil.php?editar=1" style="display:inline-block; margin-top:1rem; padding:0.5rem 1rem; background:#e91e63; color:white; border-radius:5px;">Editar perfil</a>
            <br><br>
            <a href="perfil.php?eliminar=1" style="color: red; text-decoration: none; font-weight: bold;">Eliminar mi cuenta</a>
        </div>
    <?php endif; ?>
</main>

<?php include_once('../footer.php'); ?>

<style>
    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        font-family: 'Segoe UI', sans-serif;
        background-color: #fdfdfd;
    }

    main {
        flex: 1;
        padding: 2rem;
        max-width: 600px;
        margin: 0 auto;
    }

    form {
        background-color: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }

    form label {
        display: flex;
        flex-direction: column;
        font-weight: 500;
        color: #444;
    }

    form input {
        margin-top: 0.3rem;
        padding: 0.6rem 1rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: border 0.3s;
    }

    form input:focus {
        border-color: #e91e63;
        outline: none;
    }

    form button {
        background-color: #e91e63;
        color: white;
        padding: 0.8rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    form button:hover {
        background-color: #d81b60;
    }

    form a {
        text-align: center;
        color: #777;
        text-decoration: none;
        margin-top: 0.5rem;
    }

    form a:hover {
        color: #e91e63;
    }
</style>
