<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: auto;
            background-color: white;
        }

        #loader {
            font-size: 10rem;
            color: black;
            text-align: center;
            margin-top: 50px
            text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.5);
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
            color: black;
            width: 100%;
            height: 100%;
        }

        h1 {
            font-size: 3rem;
        }

        p {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <div id="loader">Bienvenido!!</div>
    <div id="content">
        <?php include('nav.php') ?>
        <h1>¡Registro exitoso!</h1>
        <p>Gracias por registrarte. Ahora puedes iniciar sesión.</p>
        <a href="/Travel-Go/vistas/Usuarios/login.php">Iniciar Sesión</a>
        <?php include('vistas/footer.php'); ?>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        }, 5000);
    </script>
</body>
</html>
