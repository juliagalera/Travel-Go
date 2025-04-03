<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página principal</title>
    <style>
        /* General styles for the page */
/* General styles for the page */
body, html {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa; /* Fondo suave */
    color: #333; /* Texto oscuro */
    height: 100%,
    flex-direction: column;
}

/* Encabezado principal */
h1 {
    text-align: center;
    color: #444;
    margin-top: 20px;
}

h3 {
    text-align: center;
    color: #555;
}

/* Div contenedor de los botones de filtro */
.filter-buttons {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin: 20px 0;
}

/* Estilos para los botones */
.filter-buttons button {
    border: 1px solid transparent;
    border-radius: 5px;
    padding: 10px 20px;
    margin: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

/* Colores únicos para cada botón */
.filter-buttons button:nth-child(1) {
    background-color: #e3f2fd; /* Azul claro */
    color: #0d47a1; /* Azul fuerte */
    border-color: #90caf9; /* Borde azul */
}

.filter-buttons button:nth-child(2) {
    background-color: #fce4ec; /* Rosa claro */
    color: #d81b60; /* Rosa fuerte */
    border-color: #f48fb1; /* Borde rosa */
}

.filter-buttons button:nth-child(3) {
    background-color: #f1f8e9; /* Verde claro */
    color: #33691e; /* Verde fuerte */
    border-color: #aed581; /* Borde verde */
}

.filter-buttons button:nth-child(4) {
    background-color: #fff8e1; /* Amarillo claro */
    color: #ff6f00; /* Naranja fuerte */
    border-color: #ffd54f; /* Borde amarillo */
}

.filter-buttons button:nth-child(5) {
    background-color: #ede7f6; /* Morado claro */
    color: #4a148c; /* Morado fuerte */
    border-color: #b39ddb; /* Borde morado */
}

/* Efecto al pasar el ratón por encima */
.filter-buttons button:hover {
    transform: scale(1.05);
    opacity: 0.9;
}

/* Pie de página */
footer {
    text-align: center;
    padding: 10px;
    background-color: #e0e0e0; /* Gris claro */
    color: #666;
}


    </style>
</head>
<body>
    <?php include('../nav.php');?>

    <h1>Hay un camino para tí...</h1>

    <h3>¿Cuales son tus preferencias?</h3>

    <div class="filter-buttons">
        <button onclick="toggleSelection(this, 'parques')">Parques</button>
        <button onclick="toggleSelection(this, 'cultura')">Cultura</button>
        <button onclick="toggleSelection(this, 'gastronomia')">Gastronomía</button>
        <button onclick="toggleSelection(this, 'compras')">Compras</button>
        <button onclick="toggleSelection(this, 'deportes')">Deportes</button>
    </div>

    <?php include('footer.php');?>

    <script>
        // Array para rastrear las categorías seleccionadas
        let selectedCategories = [];

        // Función para alternar selección
        function toggleSelection(button, category) {
            if (selectedCategories.includes(category)) {
                // Si ya está seleccionado, eliminarlo
                selectedCategories = selectedCategories.filter(item => item !== category);
                button.style.backgroundColor = ""; // Restablecer el estilo
            } else if (selectedCategories.length < 3) {
                // Si el número de selecciones es menor al máximo, agregarlo
                selectedCategories.push(category);
                button.style.backgroundColor = "#bbdefb"; // Marcar el botón como seleccionado
            } else {
                alert("Puedes seleccionar hasta 3 categorías.");
            }

            console.log("Categorías seleccionadas:", selectedCategories);
        }
    </script>
</body>
</html>
