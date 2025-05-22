<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
html, body {
  margin: 0;
  padding: 0;
}

nav {
  width: 100%;
  height: 70px;
  background-color: white;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px; 
  border-bottom: 1.5px solid black;
  box-sizing: border-box;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000; 
}

.left-section,
.right-section {
  width: 150px;
}

.center-links {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  margin-left: 250px;
  position: relative;
}

.center-links .links-container {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex: 1;
}

.center-links form {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  margin-left: 20px;
  min-width: 180px;
  max-width: 250px; 
  justify-content: flex-end;
  box-sizing: border-box;
}

.center-links form input[type="text"] {
  width: 140px;
  padding: 5px 10px;
  border-radius: 15px;
  border: 1px solid #ccc;
  font-size: 14px;
  box-sizing: border-box;
  transition: width 0.3s ease;
}

.center-links form input[type="text"]:focus {
  width: 230px;
  outline: none;
  border-color: #e580ce;
}

.center-links form button {
  cursor: pointer;
  padding: 5px 12px;
  border: none;
  border-radius: 15px;
  background-color: #e580ce;
  color: white;
  font-size: 16px;
  width: 40px;      
  height: 32px;     
  display: flex;
  justify-content: center;
  align-items: center;
  transition: background-color 0.3s ease;
  box-sizing: border-box;
}

.center-links form button:hover {
  background-color: #d45ba1;
}

.left-section img {
  height: 50px;
}

.center-links a {
  text-decoration: none;
  color: black;
  font-size: 18px;
  font-weight: bold;
  transition: color 0.3s ease;
}

.center-links a:hover {
  color: #e580ce;
}

.right-section {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.right-section a {
  text-decoration: none;
  color: black;
  font-size: 14px; 
  font-weight: bold;
  padding: 3px 8px;
  background-color: white;
  border-radius: 5px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

.right-section a:hover {
  background-color: #e580ce;
  color: white;
}

.logout-link {
  font-size: 7px; 
  color: #666; 
  margin-top: 5px; 
  text-decoration: none; 
}

.logout-link:hover {
  color: #e580ce; 
}

body {
  padding-top: 80px; 
}


  </style>
</head>
<body>
  <nav>
    <div class="left-section">
      <a href="/Travel-Go/inicio.php">
       <img src="/Travel-Go/vistas/Usuarios/logo.png" alt="Logo">
      </a>
    </div>
    <div class="center-links">
      <a href="/Travel-Go/inicio.php">Inicio</a>
      <a href="/Travel-Go/contacto.php">Contacto</a>
      <?php
        if (isset($_SESSION['usuario_id'])) {
          echo '<a href="/Travel-Go/vistas/Lugares/listarLugares.php">Mis lugares</a>';
        } else {
          echo '<a href="/Travel-Go/vistas/Usuarios/registro.php">Registro</a>';
        }
      ?>
    </div>
    <form method="GET" action="/Travel-Go/vistas/Lugares/buscar_lugar.php" style="display: inline-flex; align-items: center; margin-left: 20px;">
      <input type="text" name="q" placeholder="Buscar lugar..." 
        style="padding: 5px 10px; border-radius: 15px; border: 1px solid #ccc; font-size: 14px;"
        value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
      <button type="submit" 
        style="margin-left: 5px; padding: 5px 10px; border: none; border-radius: 15px; background-color: #f78fb3; color: white; cursor: pointer;">
        🔍
      </button>
    </form>

    <div class="right-section">
      <?php
        if (isset($_SESSION['usuario_id'])) {
            echo '<a href="/Travel-Go/vistas/Usuarios/perfil.php">Hola, ' . $_SESSION['usuario_nombre'] . '</a>';
            echo '<a href="/Travel-Go/vistas/Usuarios/logout.php" class="logout-link">Cerrar sesión</a>';
        } else {
            echo '<a href="/Travel-Go/vistas/Usuarios/login.php">Iniciar sesión</a>';
        }
      ?>
    </div>
  </nav>
</body>
</html>
