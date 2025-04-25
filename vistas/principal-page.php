<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <style>
        body, html {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        #sitios-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
        }

        .sitio {
            display: none;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 10px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 250px;
            text-align: center;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-top: 20px;
        }

        h3 {
            text-align: center;
            color: #555;
        }

        .filter-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 20px 0;
        }

        .filter-buttons button {
            border: 1px solid transparent;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .filter-buttons button:nth-child(1) {
            background-color: #e3f2fd;
            color: #0d47a1;
            border-color: #90caf9;
        }

        .filter-buttons button:nth-child(2) {
            background-color: #fce4ec;
            color: #d81b60;
            border-color: #f48fb1;
        }

        .filter-buttons button:nth-child(3) {
            background-color: #f1f8e9;
            color: #33691e;
            border-color: #aed581;
        }

        .filter-buttons button:nth-child(4) {
            background-color: #fff8e1;
            color: #ff6f00;
            border-color: #ffd54f;
        }

        .filter-buttons button:nth-child(5) {
            background-color: #ede7f6;
            color: #4a148c;
            border-color: #b39ddb;
        }

        .filter-buttons button:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        #aceptar {
            border: 1px solid transparent;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4d82be;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
        }

        #aceptar:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        footer {
            width: 100%;
            text-align: center;
            padding: 15px 0;
            background-color: #F7A8E0;
            color: white;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include('../nav.php'); ?>

    <main>
        <h1>Hay un camino para ti...</h1>

        <h3>¿Cuáles son tus preferencias?</h3>

        <div class="filter-buttons">
            <button id="parques" onclick="toggleSelection(this, 'parques')">Parques</button>
            <button id="cultura" onclick="toggleSelection(this, 'cultura')">Cultura</button>
            <button id="gastronomia" onclick="toggleSelection(this, 'gastronomia')">Gastronomía</button>
            <button id="compras" onclick="toggleSelection(this, 'compras')">Compras</button>
            <button id="deportes" onclick="toggleSelection(this, 'deportes')">Deportes</button>
        </div>
        <div style="text-align:center;">
            <button id="aceptar" onclick="mostrarLugares()">Ver lugares recomendados</button>
        </div>
        <p id="error"></p>
    </main>

    <script>
        let selectedCategories = [];


        function toggleSelection(button, category) {
            if (selectedCategories.includes(category)) {
                // Si ya está seleccionado, eliminarlo
                selectedCategories = selectedCategories.filter(item => item !== category);
                button.style.backgroundColor = ""; // Restablecer el estilo
            } else if (selectedCategories.length < 1 ) {
                // Si el número de selecciones es menor al máximo, agregarlo
                selectedCategories.push(category);
                button.style.backgroundColor = "#bbdefb"; // Marcar el botón como seleccionado
            } else {
                alert("Solo puedes seleccionar 1 categoría.");
            }

            console.log("Categorías seleccionadas:", selectedCategories);
        }
    let parques = document.getElementById("parques");
    let cultura = document.getElementById("cultura");
    let compras = document.getElementById("compras");
    let gastronomia = document.getElementById("gastronomia");
    let deportes = document.getElementById("deportes");

    function mostrarLugares() {
    if (selectedCategories.includes("parques")) {
        window.location.href = "/Travel-Go/vistas/Lugares/parques.php";
    } else if (selectedCategories.includes("cultura")) {
        window.location.href = "/Travel-Go/vistas/Lugares/cultura.php";
    } else if (selectedCategories.includes("compras")) {
        window.location.href = "/Travel-Go/vistas/Lugares/compras.php";
    } else if (selectedCategories.includes("gastronomia")) {
        window.location.href = "/Travel-Go/vistas/Lugares/gastronomia.php";
    } else if (selectedCategories.includes("deportes")) {
        window.location.href = "/Travel-Go/vistas/Lugares/deportes.php";
    } else {
        document.getElementById("error").innerHTML = "<p style='color:red; margin-left:330px;'>Selecciona algún filtro, o visita nuestra página principal para ver todas las categorías.</p>";
    }
}

    </script>
    <?php include('footer.php'); ?>
</body>
</html>
        