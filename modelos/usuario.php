<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../controladores/UsuarioController.php');

class Usuario {
    private $conn;
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $passwd;

    public function __construct($conn, $id = null, $nombre = null, $apellido = null, $email = null, $passwd = null) {
        $this->conn = $conn;
        $this->id = $id ?? null;
        $this->nombre = isset($_POST['nombre']) ? $_POST['nombre'] : $nombre;
        $this->apellido = isset($_POST['apellido']) ? $_POST['apellido'] : $apellido;
        $this->email = isset($_POST['email']) ? $_POST['email'] : $email;
        $this->passwd = isset($_POST['passwd1']) ? $_POST['passwd1'] : $passwd;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function autenticar($email, $passwd) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($usuario && password_verify($passwd, $usuario['passwd'])) {
            $this->id = $usuario['id'];
            $this->nombre = $usuario['nombre'];
            $this->email = $usuario['email'];
            return true;
        }
        return false;
    }

    public function registrar() {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            echo "<script>alert('El correo electrónico ya está registrado.')</script>";
            return false;
        } else {
            $hashedPasswd = password_hash($this->passwd, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, apellido, email, password, fecha_registro) VALUES (?, ?, ?, ?, CURRENT_DATE)");
            $stmt->bind_param("ssss", $this->nombre, $this->apellido, $this->email, $hashedPasswd);
            if ($stmt->execute()) {
                header('location:/Travel-Go/principal.php');
                exit();
            } else {
                echo "<script>alert('Error al registrar al usuario.')</script>";
            }
        }
    }

    public function actualizarContraseña($nuevaPasswd) {
        if (!$this->conn) {
            throw new Exception("La conexión a la base de datos no está inicializada.");
        }

        $this->passwd = password_hash($nuevaPasswd, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE usuarios SET passwd = ? WHERE id = ?");
        $stmt->bind_param("si", $this->passwd, $this->id);
        return $stmt->execute();
    }

    public function obtenerUsuarioPorEmail($email) {
        if (!$this->conn) {
            throw new Exception("La conexión a la base de datos no está inicializada.");
        }

        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        return $usuario ? $usuario : null;
    }

    public function obtenerTodoslosUsuarios() {
        if (!$this->conn) {
            throw new Exception("La conexión a la base de datos no está inicializada.");
        }

        $stmt = $this->conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $resultado = $stmt->get_result();

        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = new Usuario($this->conn, $fila['id'], $fila['nombre'], $fila['apellido'], $fila['email'], $fila['passwd']);
        }
        return $usuarios;
    }

    public function eliminarUsuario() {
        if (!$this->conn) {
            throw new Exception("La conexión a la base de datos no está inicializada.");
        }

        if ($this->id === null) {
            throw new Exception("Usuario no autenticado.");
        }

        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function mostrarInformacionUsuario() {
        echo "ID: " . $this->id . ", Nombre: " . $this->nombre . ", Email: " . $this->email;
    }

    public function actualizarPerfil($nuevoNombre, $nuevoApellido, $nuevoEmail, $nuevaPasswd = null) {
        if (!$this->conn) {
            throw new Exception("La conexión a la base de datos no está inicializada.");
        }

        if ($nuevaPasswd) {
            $passwdHash = password_hash($nuevaPasswd, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, passwd = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nuevoNombre, $nuevoApellido, $nuevoEmail, $passwdHash, $this->id);
        } else {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nuevoNombre, $nuevoApellido, $nuevoEmail, $this->id);
        }

        if ($stmt->execute()) {
            $this->nombre = $nuevoNombre;
            $this->apellido = $nuevoApellido;
            $this->email = $nuevoEmail;

            if ($nuevaPasswd) {
                $this->passwd = $passwdHash;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function obtenerPorId($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}
?>
