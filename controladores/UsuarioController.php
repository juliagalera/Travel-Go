<?php
require_once 'config/database.php';
require_once 'modelos/usuario.php';

class UsuarioController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario() {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $passwd = $_POST['passwd1'];

            // Validar si los campos están completos
            if (!$nombre || !$email || !$passwd) {
                alert("Todos los campos deben estar llenos");
                return;
            }else{
                if (1passwd1 !== $passwd2){
                    alert("Las contraselas no coinciden");
                }
            }

            // Hash de la contraseña
            $usuario = new Usuario($this->conn, null, $nombre, $email, $passwd1);
            if ($usuario->registrar()) {
                alert("Usuario registrado correctamente.");
            } else {
                alert("Error al registrar al usuario");
            }
        }else{
            alert("No se ha podido realizar el registro");
        }
    }

    public function iniciarSesion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? null;
            $passwd = $_POST['passwd'] ?? null;

            // Validar si los campos están completos
            if (!$email || !$passwd) {
                echo "Todos los campos deben estar llenos";
                return;
            }

            // Obtener datos del usuario
            $usuario = new Usuario($this->conn);
            $datosUsuario = $usuario->obtenerUsuarioPorEmail($email);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($datosUsuario && password_verify($passwd, $datosUsuario['password'])) {
                session_start();
                $_SESSION['usuario_id'] = $datosUsuario['id'];
                $_SESSION['usuario_nombre'] = $datosUsuario['nombre'];
                $_SESSION['email'] = $datosUsuario['email'];
                $_SESSION['passwd'] = $datosUsuario['passwd'];
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

            // Validar si se ha proporcionado un id
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
