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
                header('Location:../vistas/registro.php');
                return;
            }

            if ($passwd1 !== $passwd2) {
                echo "<script>alert('Las contraseñas no coinciden.');</script>";
                header('Location: ../vistas/registro.php');
                return;
            }

            if (strlen($passwd1) < 6) {
                echo "<script>alert('La contraseña debe tener al menos 6 caracteres.');</script>";
                return;
            }
            if($email){
                echo "<script> alert('el correo ya está registrado.');</scrip>";
            }

            $hashedPasswd = password_hash($passwd1, PASSWORD_BCRYPT);

            $usuario = new Usuario($this->conn, null, $nombre, $email, $hashedPasswd, date('d-m-Y'));

            $usuario->registrar();

            session_start();
            $_SESSION['user_id'] = $usuario->getId();
            $_SESSION['user_name'] = $nombre;

            if (isset($_POST['email'])) {
                setcookie('user_email', $email, time() + 3600 * 24 * 30, '/', '', false, true);  
            }

            header("Location: /Travel-Go/index.php");
            exit;
        }
    }

    public function iniciarSesion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
    
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $passwd = trim($_POST['passwd']);
    
            if (empty($email) || empty($passwd)) {
                echo "<script>alert('Todos los campos deben estar llenos.')</script>";
                return;
            }
    
            $usuario = new Usuario($this->conn);
            $datosUsuario = $usuario->obtenerUsuarioPorEmail($email);
    
            if (!$datosUsuario) {
                echo "<script>alert('Usuario no registrado');</script>";
                return;
            }
    
            if (password_verify($passwd, $datosUsuario['password'])) {
                $_SESSION['usuario_id'] = $datosUsuario['id'];
                $_SESSION['usuario_nombre'] = $datosUsuario['nombre'];
                $_SESSION['email'] = $datosUsuario['email'];
    
                if (isset($_POST['recordar'])) {
                    setcookie('usuario_recordado', $email, time() + (86400 * 30), "/"); 
                }
    
                if (isset($_POST['recordarDatos'])) {
                    setcookie('usuario_recordado_email', $email, time() + (86400 * 30), "/");
                    setcookie('usuario_recordado_passwd', $passwd, time() + (86400 * 30), "/");
                } else {
                    setcookie('usuario_recordado_email', $email, time() + (86400 * 365 * 10), "/");
                    setcookie('usuario_recordado_passwd', $passwd, time() + (86400 * 365 * 10), "/");
                    
                }
    
                header("Location: /Travel-Go/vistas/principal-page.php");
                exit;
            } else {
                echo "<script>alert('Email o contraseña incorrectos');</script>";
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
