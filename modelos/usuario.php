<?php
class Usuario {
    private $id;
    private $nombre;
    private $email;
    private $passwd; // Contraseña almacenada de forma interna (texto claro).
    private $conn;

    // Constructor
    public function __construct($conn, $id = null, $nombre = "", $email = "", $passwd = "") {
        $this->conn = $conn;
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->passwd = $passwd;
    }

    // Métodos para obtener datos del usuario
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    // Método para autenticar usuario
    public function autenticar($email, $passwd) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($usuario && password_verify($passwd, $usuario['password'])) {
            // Inicializar datos del usuario autenticado
            $this->id = $usuario['id'];
            $this->nombre = $usuario['nombre'];
            $this->email = $usuario['email'];
            return true;
        }
        return false; // Credenciales incorrectas
    }

    // Método para registrar un nuevo usuario
    public function registrar() {
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        $passwdHash = password_hash($this->passwd, PASSWORD_DEFAULT); // Hash de la contraseña
        $stmt->bind_param("sss", $this->nombre, $this->email, $passwdHash);
        return $stmt->execute();
    }

    // Método para actualizar la contraseña
    public function actualizarContraseña($nuevaPasswd) {
        $this->passwd = password_hash($nuevaPasswd, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $this->passwd, $this->id);
        return $stmt->execute();
    }

    // Obtener usuario por email
    public function obtenerUsuarioPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        
        if ($usuario) {
            return new Usuario($this->conn, $usuario['id'], $usuario['nombre'], $usuario['email'], $usuario['password']);
        }
        return null;
    }

    // Obtener todos los usuarios
    public function obtenerTodoslosUsuarios() {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $resultado = $stmt->get_result();

        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = new Usuario($this->conn, $fila['id'], $fila['nombre'], $fila['email'], $fila['password']);
        }
        return $usuarios;
    }

    // Eliminar usuario
    public function eliminarUsuario() {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    // Mostrar información del usuario (para depuración)
    public function mostrarInformacionUsuario() {
        echo "ID: " . $this->id . ", Nombre: " . $this->nombre . ", Email: " . $this->email;
    }
}
?>
