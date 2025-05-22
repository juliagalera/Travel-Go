<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            justify-content: space-between; 
            min-height: 100vh; 
        }

        #loader {
            font-size: 3rem;
            color: #444; 
            text-align: center;
            margin-top: 20px;
            animation: pulse 1.5s infinite;
            font-weight: bold;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        #content {
            display: none;
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #555;
        }

        #inicio {
            text-decoration: none;
            font-size: 1.2rem;
            color: white;
            background-color: #F7A8E0;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        #inicio:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <main>
        <div id="loader">Bienvenido!!</div>

        <div id="content">
            <?php include('nav.php'); ?>
            <h1>¡Registro exitoso!</h1><br>
            <p>Gracias por registrarte. Ahora puedes iniciar sesión.</p><br>
            <a id="inicio" href="/Travel-Go/vistas/Usuarios/login.php">Iniciar Sesión</a>
        </div>
    </main>

  <?php include('vistas/footer.php'); ?>

    <script>
        setTimeout(() => {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        }, 3000);
    </script>
</body>
</html>
