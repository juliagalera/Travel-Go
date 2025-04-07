<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}


h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 2.5em;
    color: #c14b8a;
}


.categories {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    justify-items: center;
    padding: 20px;
}


.category {
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    margin : 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
    width: 100%;
}

.category img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-bottom: 5px solid #c14b8a;
}

.category h2 {
    font-size: 1.8em;
    margin: 10px 0;
    color: #c14b8a;
}

.category p {
    font-size: 1.1em;
    color: #666;
    padding: 0 15px 20px;
}


.category:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

a{
    text-decoration: none;
    color:  #c14b8a;
}

a:hover{
    color: black;
}
/* Diseño responsive */
@media (max-width: 768px) {
    h1 {
        font-size: 2em;
    }

    .category h2 {
        font-size: 1.5em;
    }

    .category p {
        font-size: 1em;
    }
}
</style>
</head>
<body>
    <?php include('nav.php');?>

    <h1>¿Conoces Granada?</h1>

    
    <section class="categories">
        <div class="category">
            <img src="img/nicolas.jpg" alt="Cultura" />
            <h2>Cultura</h2>
            <p>Descubre los monumentos históricos y museos.</p>
            <a href="vistas/Lugares/cultura.php">Ver cultura</a>
        </div>
        <div class="category">
            <img src="img/alquerias.jpg" alt="Parques" />
            <h2>Naturaleza</h2>
            <p>Explora los hermosos parques y miradores.</p>
            <a href="vistas/Lugares/parques.php">Ver parques</a>
        </div>
        <div class="category">
            <img src="img/chantarela.jpg" alt="Gastronomía" />
            <h2>Gastronomía</h2>
            <p>Prueba los sabores únicos de Granada.</p>
            <a href=vistas/Lugares/gastronomia.php>Ver Gastronomía</a>

        </div>
        <div class="category">
            <img src="img/golf.jpg" alt="Deporte" />
            <h2>Deporte</h2>
            <p>Realiza actividades al aire libre y aventuras.</p>
            <a href="vistas/Lugares/deportes.php">Ver deportes</a>
            
        </div>
        <div class="category">
            <img src="img/nevada.jpg" alt="Compras" />
            <h2>Compras</h2>
            <p>Realiza actividades al aire libre y aventuras.</p>
            <a href="vistas/Lugares/compras.php">Ver Compras</a>
            
        </div>
    </section>

    <?php include('vistas/footer.php'); ?>
</body>
</html>
