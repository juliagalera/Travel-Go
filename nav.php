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
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  padding-top: 80px;
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
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  box-sizing: border-box;
  flex-wrap: wrap; 
}

.left-section,
.right-section {
  width: 150px;
  display: flex;
  align-items: center;
}

.left-section img {
  height: 50px;
  max-width: 100%;
  object-fit: contain;
}

.center-links {
  flex: 1 1 auto; 
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  position: relative;
  flex-wrap: wrap;
}

.center-links .links-container {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.center-links a {
  text-decoration: none;
  color: black;
  font-size: 18px;
  font-weight: bold;
  transition: color 0.3s ease;
  white-space: nowrap;
}

.center-links a:hover {
  color: #e580ce;
}

.center-links form {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  min-width: 180px;
  max-width: 250px;
  justify-content: flex-end;
  box-sizing: border-box;
  flex-shrink: 1;
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

.right-section {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 5px;
  flex-shrink: 0;
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
  white-space: nowrap;
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


@media (max-width: 900px) {
  nav {
    height: auto;
    padding: 10px 15px;
  }
  .left-section,
  .right-section {
    width: auto;
  }
  .center-links {
    margin: 10px 0 0 0;
    justify-content: flex-start;
    gap: 10px;
  }
  .center-links form {
    max-width: 100%;
    min-width: auto;
    flex-grow: 1;
  }
  .center-links form input[type="text"] {
    width: 100%;
    max-width: none;
  }
}

@media (max-width: 600px) {
  nav {
    flex-direction: column;
    align-items: flex-start;
    height: auto;
  }
  .left-section,
  .center-links,
  .right-section {
    width: 100%;
    justify-content: flex-start;
    margin: 5px 0;
  }
  .center-links {
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 10px;
  }
  .center-links .links-container {
    flex-wrap: wrap;
    justify-content: flex-start;
  }
  .right-section {
    flex-direction: row;
    gap: 10px;
  }
  .right-section a {
    font-size: 12px;
    padding: 5px 10px;
  }
  .logout-link {
    font-size: 9px;
  }
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
