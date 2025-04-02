<?php
require_once 'config/database.php';
require_once 'modelos/usuario.php';

class UsuarioController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validación de datos
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellido = htmlspecialchars($_POST['apellido']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $passwd1 = $_POST['passwd1'];
            $passwd2 = $_POST['passwd2'];

            if (empty($nombre) || empty($apellido) || empty($email) || empty($passwd1) || empty($passwd2)) {
                echo "Todos los campos son obligatorios.";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "El correo electrónico no es válido.";
                return;
            }

            if ($passwd1 !== $passwd2) {
                echo "Las contraseñas no coinciden.";
                return;
            }

            if (strlen($passwd1) < 6) {
                echo "La contraseña debe tener al menos 6 caracteres.";
                return;
            }

            // Guardar el usuario en la base de datos
            $hashedPasswd = password_hash($passwd1, PASSWORD_DEFAULT);
            $usuario = new Usuario($this->conn, null, $nombre, $apellido, $email, $hashedPasswd);

            if ($usuario->registrar()) {
                // Redirigir a una página específica después del registro
                header("Location: /Travel-Go/principal.php");
                exit();
            } else {
                echo "Error al registrar el usuario.";
            }
        }
    }


    public function iniciarSesion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $passwd = $_POST['passwd'];

            if (!$email || !$passwd) {
                echo "Todos los campos deben estar llenos";
                return;
            }

            // Obtener el usuario por su email
            $usuario = new Usuario($this->conn);
            $datosUsuario = $usuario->obtenerUsuarioPorEmail($email);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($datosUsuario && password_verify($passwd, $datosUsuario['password'])) {
                session_start();
                $_SESSION['usuario_id'] = $datosUsuario['id'];
                $_SESSION['usuario_nombre'] = $datosUsuario['nombre'];
                $_SESSION['email'] = $datosUsuario['email'];
                echo "Inicio de sesión exitoso";
            } else {
                echo "Email o contraseña incorrectos";
            }
        }
    }

    public function mostrarFormularioRegistro() {
        require_once '../vistas/registro.php';
    }

    public function listarUsuarios() {
        $usuario = new Usuario($this->conn);
        $usuarios = $usuario->obtenerTodoslosUsuarios();
        require_once 'vistas/Usuarios/usuarios.php';
    }

    public function eliminarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo "Debes seleccionar un usuario";
                return;
            }

            $usuario = new Usuario($this->conn, $id);
            if ($usuario->eliminarUsuario()) {
                echo "Usuario eliminado con éxito";
            } else {
                echo "Error al eliminar el usuario";
            }
        }
    }
}
?>
