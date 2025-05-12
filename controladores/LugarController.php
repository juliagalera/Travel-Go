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
public function crearLugar($nombre, $descripcion, $imagen = null, $categoria, $usuarioId) {
    // Sanear las entradas de nombre, descripcion y categoria (solo cadenas)
    $nombre = htmlspecialchars(trim($nombre));
    $descripcion = htmlspecialchars(trim($descripcion));
    $categoria = is_array($categoria) ? implode(',', $categoria) : $categoria;
    $categoria = htmlspecialchars(trim($categoria));


    // Validación de campos vacíos
    if (empty($nombre) || empty($descripcion) || empty($categoria)) {
        echo "Todos los campos son obligatorios.";
        return;
    }

    // Verificar si ya existe un lugar con ese nombre para este usuario
    $stmt = $this->conn->prepare("SELECT * FROM lugares WHERE nombre = ? AND user_id = ?");
    $stmt->bind_param("si", $nombre, $usuarioId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Si el lugar ya existe, mostrar el mensaje de duplicado
        $lugarExistente = $resultado->fetch_assoc();
        echo "<div class='aviso-duplicado'>";
        echo "<p>Ya has creado un lugar con ese nombre.</p>";
        echo "<a href='formularioEditarLugar.php?id=" . $lugarExistente['id'] . "'>Editar lugar existente</a> | ";
        echo "<a href='listarLugares.php'>Cancelar</a>";
        echo "</div>";
        return;
    }

    // Si no existe, proceder a insertar el nuevo lugar
    $imagenPath = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen']; // Asignamos el archivo a la variable imagen
        
        // Validar imagen
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExtension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
    
        // Verificar si la extensión es válida
        if (!in_array($imageExtension, $allowedExtensions)) {
            echo "El archivo de imagen no es válido.";
            return;
        }
    
        // Verificar tamaño de la imagen (máximo 2MB)
        if ($imagen['size'] > 2000000) {
            echo "La imagen es demasiado grande. El tamaño máximo es 2MB.";
            return;
        }
    
        // Mover imagen al directorio
        $imagenPath = 'img/' . basename($imagen['name']);
        if (!move_uploaded_file($imagen['tmp_name'], $imagenPath)) {
            echo "Error al subir la imagen.";
            return;
        }
    
        // Si todo va bien, puedes guardar el nombre de la imagen en la base de datos y mostrarla
        echo "<img src='$imagenPath' alt='" . htmlspecialchars($imagen['name']) . "' width='100'>";
    } else {
        echo "Error al cargar la imagen o la imagen no es válida.";
    }
    
    
    
    

    // Preparar la consulta de inserción
    $stmt = $this->conn->prepare("INSERT INTO lugares (nombre, detalle, imagen, categoria, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nombre, $descripcion, $imagenPath, $categoria, $usuarioId);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: listarLugares.php");
        exit;
    } else {
        echo "Error al guardar el lugar.";
    }
}

    
    

    // Listar todos los lugares
    public function listarLugares() {
        $lugares = Lugar::obtenerTodosLugares($this->conn);
        require_once 'vistas/lugares/listarLugares.php'; 
    }

    // Editar lugar con categoría
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
            $lugar->setCategoria($nuevaCategoria);  // Actualizamos la categoría

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

                $imagenPath = 'uploads/' . basename($nuevaImagen['name']);
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

    // Eliminar lugar
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

    // Obtener detalles de un lugar
    public function obtenerDetallesLugar($id) {
        $lugar = Lugar::obtenerLugarPorId($this->conn, $id);
        if ($lugar) {
            echo "Lugar: " . $lugar->getNombre() . "<br>";
            echo "Descripción: " . $lugar->getDescripcion() . "<br>";
            echo "Imagen: " . $lugar->getImagen() . "<br>";
            echo "Categoría: " . $lugar->getCategoria() . "<br>";  // Mostramos la categoría
        } else {
            echo "Lugar no encontrado";
        }
    }

    // Buscar lugares con categoría incluida en la búsqueda
    public function buscarLugares($busqueda) {
        $busqueda = htmlspecialchars(trim($busqueda)); 
        $lugares = Lugar::buscarLugares($this->conn, $busqueda);

        if ($lugares) {
            foreach ($lugares as $lugar) {
                echo "Lugar: " . $lugar->getNombre() . "<br>";
                echo "Descripción: " . $lugar->getDescripcion() . "<br>";
                echo "Imagen: " . $lugar->getImagen() . "<br>";
                echo "Categoría: " . $lugar->getCategoria() . "<br><br>";  // Mostramos la categoría
            }
        } else {
            echo "No se encontraron lugares";
        }
    }
}
?>
