<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       nav {
            width: 100%;
            height: 70px; /* Ajusta el tamaño según lo que necesites */
            padding: 15px 0;
            background-color: #f7a8e0; /* Rosa pastel */
            display: flex;
            justify-content: center; /* Centra los enlaces */
            align-items: center;
            gap: 20px; /* Espacio entre los enlaces */
            border-bottom: 1.5px solid black;
            position: absolute;
            top: 0;
            left: 0;
        }

        nav img {
            height: 50px; /* Aumenta el tamaño del logo */
            position: absolute; /* Permite que el logo esté fuera del flujo del flexbox */
            left: 20px; /* Espacio a la izquierda del logo */
            top: 50%; /* Centra verticalmente */
            transform: translateY(-50%); /* Asegura que se centre correctamente */
            background: none; /* Asegura que no haya fondo */
        }

        nav a {
            text-decoration: none;
            color: black;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s ease; /* Transición suave para hover */
        }

        nav a:hover {
            color: azure;
        }

        body {
            padding-top: 80px;
        }
    </style>
</head>
<body>
    <nav>
        <img src="/Travel-Go/vistas/Usuarios/logo.png" alt="Logo">
        <a href="/Travel-Go/inicio.php">Inicio</a>
        <a href="/Travel-Go/contacto.php">Contacto</a>
        <a href="/Travel-Go/vistas/Usuarios/registro.php">Registro</a>
        <a href="/Travel-Go/vistas/Usuarios/login.php">Iniciar sesión </a>
    </nav>
</body>
</html>
