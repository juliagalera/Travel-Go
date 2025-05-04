<?php
require_once(__DIR__ . '/../config/database.php');

require_once(__DIR__ . '/../modelos/usuario.php');

class UsuarioController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validación de datos
            $nombre   = htmlspecialchars($_POST['nombre']);
            $apellido = htmlspecialchars($_POST['apellido']);
            $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $passwd1  = $_POST['passwd1'];
            $passwd2  = $_POST['passwd2'];
    
            if (empty($nombre) || empty($apellido) || empty($email) || empty($passwd1) || empty($passwd2)) {
                echo "<script>alert('Todos los campos son obligatorios.');</script>";
                return;
            }
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('El correo electrónico no es válido.');</script>";
                return;
            }
    
            if ($passwd1 !== $passwd2) {
                echo "<script>alert('Las contraseñas no coinciden.');</script>";
                return;
            }
    
            if (strlen($passwd1) < 6) {
                echo "<script>alert('La contraseña debe tener al menos 6 caracteres.');</script>";
                return;
            }
    
            // Encriptar la contraseña antes de guardarla.
            $hashedPasswd = password_hash($passwd1, PASSWORD_BCRYPT);
            $usuario = new Usuario($this->conn, null, $nombre, $email, $hashedPasswd, date('d-m-Y'));
    
            $usuario->registrar();
        }
    

    }
    public function iniciarSesion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $passwd = $_POST['passwd'];

            if (!$email || !$passwd) {
                echo "<script>alert('Todos los campos deben estar llenos.')</script>";
                return;
            }

            // Obtener el usuario por su email
            $usuario = new Usuario($this->conn);
            $datosUsuario = $usuario->obtenerUsuarioPorEmail($email);
            
            if (!$datosUsuario){
                echo "<script>alert('Usuario no registrado'</script>";
            }
            // Verificar si el usuario existe y la contraseña es correcta
            if ($datosUsuario && $passwd === $datosUsuario['password']) {
                session_start();
                $_SESSION['usuario_id'] = $datosUsuario['id'];
                $_SESSION['usuario_nombre'] = $datosUsuario['nombre'];
                $_SESSION['email'] = $datosUsuario['email'];
                header("Location: /Travel-Go/vistas/principal-page.php");
            } else {
                echo "<script>alert('Email o contraseña incorrectos')</script>";
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
