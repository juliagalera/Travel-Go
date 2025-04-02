<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        nav {
            width: 100%;
            height: 90px;
            padding: 15px 0;
            background-color: #f7a8e0; /* Rosa pastel */
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Espacio entre los elementos */
            border-bottom: 1.5px solid black;
            position: 
            top: 0;
            left: 0;
            z-index: 1000; /* Asegura que esté en la parte superior */
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

        /* Añade un margen superior al contenido para que no quede oculto por el nav */
        body {
            padding-top: 100px; /* Altura del nav + un poco de espacio */
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="contacto.html">Contacto</a>
    </nav>
</body>
</html>
