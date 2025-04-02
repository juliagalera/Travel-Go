<?php
class Usuario {
    private $conn;
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $passwd;

    public function __construct($conn, $id = null, $nombre , $apellido, $email , $passwd) {
        $this->conn = $conn;
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->passwd = $passwd;
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
        if (!$this->conn) {
            throw new Exception("La conexión a la base de datos no está inicializada.");
        }

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
        // Verificar si el correo ya está registrado
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            echo "El correo electrónico ya está registrado.";
            return false;
        }

        // Insertar usuario en la base de datos
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, apellido, email, passwd) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->nombre, $this->apellido, $this->email, $this->passwd);
        return $stmt->execute();
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

        if ($usuario) {
            return new Usuario($this->conn, $usuario['id'], $usuario['nombre'], $usuario['email'], $usuario['passwd']);
        }
        return null;
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
            $usuarios[] = new Usuario($this->conn, $fila['id'], $fila['nombre'], $fila['email'], $fila['passwd']);
        }
        return $usuarios;
    }

    
    public function eliminarUsuario() {
        if (!$this->conn) {
            throw new Exception("La conexión a la base de datos no está inicializada.");
        }

        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    
    public function mostrarInformacionUsuario() {
        echo "ID: " . $this->id . ", Nombre: " . $this->nombre . ", Email: " . $this->email;
    }
}
?>
