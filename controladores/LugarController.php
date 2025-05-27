<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../modelos/lugar.php');

class LugarController {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerLugaresPorUsuario($usuarioId) {
        $stmt = $this->conn->prepare("SELECT * FROM lugares WHERE user_id = ?");
        $stmt->bind_param("i", $usuarioId);  
        $stmt->execute();
        $resultado = $stmt->get_result();

       
        $lugares = [];
        while ($lugar = $resultado->fetch_assoc()) {
            $lugares[] = $lugar; 
        }

        return $lugares;  
    }

private function manejarImagen($archivo, $directorio = 'img/'){
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));


    if(!in_array($extension, $allowedExtensions)){
        return ['error' => "El archivo de imagen no es válido"];
    }


    if ($archivo['size' > 2000000]) {
        return ['error', "La imagen es demasiado grande."];
    }

    $nombreUnico = uniqid() . '.' . $extension;
    $rutaDestino = $directorio . $nombreUnico¨;


    if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        return ['error' => "Error al subir la imagen"];
    }

    return ['ruta' => $rutaDestino];
}
public function crearLugar($nombre, $descripcion, $imagen = null, $categoria, $usuarioId) {
    $nombre = htmlspecialchars(trim($nombre));
    $descripcion = htmlspecialchars(trim($descripcion));
    $categoria = is_array($categoria) ? implode(',', $categoria) : $categoria;
    $categoria = htmlspecialchars(trim($categoria));

    if (empty($nombre) || empty($descripcion) || empty($categoria)) {
        echo "Todos los campos son obligatorios.";
        return;
    }

    $stmt = $this->conn->prepare("SELECT * FROM lugares WHERE nombre = ? AND user_id = ?");
    $stmt->bind_param("si", $nombre, $usuarioId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $lugarExistente = $resultado->fetch_assoc();
        echo "<div class='aviso-duplicado'>";
        echo "<p>Ya has creado un lugar con ese nombre.</p>";
        echo "<a href='formularioEditarLugar.php?id=" . $lugarExistente['id'] . "'>Editar lugar existente</a> | ";
        echo "<a href='listarLugares.php'>Cancelar</a>";
        echo "</div>";
        return;
    }

    $imagenPath = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen'];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExtension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $allowedExtensions)) {
            echo "El archivo de imagen no es válido.";
            return;
        }

        if ($imagen['size'] > 2000000) {
            echo "La imagen es demasiado grande. El tamaño máximo es 2MB.";
            return;
        }

       $nombreArchivo = basename($imagen['name']);
        $nombreArchivo = basename($imagen['name']);
        $directorioDestino = __DIR__ . '/../img/';
        $rutaAbsoluta = $directorioDestino . $nombreArchivo;

        if (!file_exists($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);
        }

        if (!move_uploaded_file($imagen['tmp_name'], $rutaAbsoluta)) {
            echo "Error al subir la imagen.";
            return;
        }

        $imagenPath = 'img/' . $nombreArchivo;


        echo "<img src='$imagenPath' alt='" . htmlspecialchars($imagen['name']) . "' width='100'>";
    } elseif (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        echo "Error al cargar la imagen o la imagen no es válida.";
        return;
    }

    $stmt = $this->conn->prepare("INSERT INTO lugares (nombre, detalle, imagen, categoria, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nombre, $descripcion, $imagenPath, $categoria, $usuarioId);

    if ($stmt->execute()) {
        header('Location: listarLugares.php');
        exit;
    } else {
        echo "Error al guardar el lugar.";
    }
}

    

    public function listarLugares() {
        $lugares = Lugar::obtenerTodosLugares($this->conn);
        require_once 'vistas/lugares/listarLugares.php'; 
    }

    public function editarLugar($id, $nuevoNombre, $nuevaDescripcion, $nuevaImagen = null, $nuevaCategoria) {
        $nuevoNombre = htmlspecialchars(trim($nuevoNombre));
        $nuevaDescripcion = htmlspecialchars(trim($nuevaDescripcion));
        $nuevaCategoria = htmlspecialchars(trim($nuevaCategoria));

        if (empty($nuevoNombre) || empty($nuevaDescripcion) || empty($nuevaCategoria)){
            echo "Todos los campos son obligatorios.";
            return;
        }

        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);
        if ($lugar) {
            $lugar->setNombre($nuevoNombre);
            $lugar->setDescripcion($nuevaDescripcion);
            $lugar->setCategoria($nuevaCategoria);  

            if ($nuevaImagen && $nuevaImagen['error'] === UPLOAD_ERR_OK) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $imageExtension = strtolower(pathinfo($nuevaImagen['name'], PATHINFO_EXTENSION));

                if (!in_array($imageExtension, $allowedExtensions)) {
                    echo "El archivo de imagen no es válido.";
                    return;
                }

                if ($nuevaImagen['size'] > 2000000) {
                    echo "La imagen es demasiado grande. El tamaño máximo es 2MB.";
                    return;
                }

                $imagenPath = 'img/' . basename($nuevaImagen['name']);
                if (!move_uploaded_file($nuevaImagen['tmp_name'], $imagenPath)) {
                    echo "Error al subir la imagen.";
                    return;
                }

                $lugar->setImagen($imagenPath);
            }

            if ($lugar->actualizarLugar($id)) {
                header("Location: listarLugares.php");
                exit();
            } else {
                echo "Hubo un error al actualizar el lugar.";
            }
        } else {
            echo "Lugar no encontrado";
        }
    }

    public function eliminarLugar($id) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);

        if (!$lugar) {
            echo "Lugar no encontrado";
            return;
        }

        if ($lugar->eliminarLugar($id)) {
            header("Location: listarLugares.php");
            exit();
        } else {
            echo "Hubo un error al eliminar el lugar";
        }
    }

    public function obtenerDetallesLugar($id) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);
        if ($lugar) {
            echo "Lugar: " . $lugar->getNombre() . "<br>";
            echo "Descripción: " . $lugar->getDescripcion() . "<br>";
            echo "Imagen: " . $lugar->getImagen() . "<br>";
            echo "Categoría: " . $lugar->getCategoria() . "<br>";  
        } else {
            echo "Lugar no encontrado";
        }
    }

    public function buscarLugares($busqueda) {
        $busqueda = htmlspecialchars(trim($busqueda)); 
        $lugares = Lugar::buscarLugares($this->conn, $busqueda);

        if ($lugares) {
            foreach ($lugares as $lugar) {
                echo "Lugar: " . $lugar->getNombre() . "<br>";
                echo "Descripción: " . $lugar->getDescripcion() . "<br>";
                echo "Imagen: " . $lugar->getImagen() . "<br>";
                echo "Categoría: " . $lugar->getCategoria() . "<br><br>";  
            }
        } else {
            echo "No se encontraron lugares";
        }
    }

    public function obtenerLugarConValoraciones($id_lugar) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id_lugar);
        if (!$lugar) {
            return null;
        }

        $valoracionModel = new Valoracion($this->conn);
        $valoraciones = $valoracionModel->obtenerValoracionesConUsuario($id_lugar);

        return [
            'lugar' => $lugar,
            'valoraciones' => $valoraciones
        ];
    }
    

}
?>

