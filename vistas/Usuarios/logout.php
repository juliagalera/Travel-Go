<?php
session_start();

if (isset($_COOKIE['usuario_recordado'])) {
    setcookie('usuario_recordado', '', time() - 3600, '/'); // Eliminar la cookie
}

session_destroy();

header("Location: ../../index.php");
exit();
?>
