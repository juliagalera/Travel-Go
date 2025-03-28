<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- Sección del carrusel con texto -->
    <div class="seccion-carrusel">
        <div class="carrusel">
            <img src="img/granada1.jpg" alt="Imagen Granada 1">
            <img src="img/granada2.jpg" alt="Imagen Granada 2">
            <img src="img/granada3.jpg" alt="Imagen Granada 3">
            <img src="img/granada4.jpg" alt="Imagen Granada 4">
        </div>
        <div class="texto-carrusel">
            <h1>Bienvenido a Travel & Go</h1>
        </div>
        <button class="prev">‹</button>
        <button class="next">›</button>
    </div>

    <!-- Sección estrecha con fondo rosa -->
    <div class="welcome">
        <h1>Ven a visitar Granada...</h1>
        <button id="iniciarSesion"onclick()="/vistas/login.php">Ya tengo cuenta</button>
        <button id="crearSesion"onclick()="/vistas/registro.php">Aun no tengo cuenta</button>
    </div>
</div>


<script>
const carrusel = document.querySelector('.carrusel');
const images = document.querySelectorAll('.carrusel img');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let index = 0;
const intervalTime = 3000; // Tiempo en milisegundos entre cambios automáticos

// Función para mostrar la imagen actual
function showImage() {
    carrusel.style.transform = `translateX(-${index * 100}%)`;
}

// Avanzar a la siguiente imagen
function nextImage() {
    index = (index + 1) % images.length; // Cicla al inicio si llega al final
    showImage();
}

// Retroceder a la imagen anterior
function prevImage() {
    index = (index - 1 + images.length) % images.length; // Cicla al final si está al inicio
    showImage();
}

// Cambio automático de imágenes
let autoSlide = setInterval(nextImage, intervalTime);

// Event listeners para los botones
nextButton.addEventListener('click', () => {
    nextImage();
    clearInterval(autoSlide); // Detiene el autoplay temporalmente
    autoSlide = setInterval(nextImage, intervalTime); // Reinicia el autoplay
});

prevButton.addEventListener('click', () => {
    prevImage();
    clearInterval(autoSlide); // Detiene el autoplay temporalmente
    autoSlide = setInterval(nextImage, intervalTime); // Reinicia el autoplay
});

</script>
</body>
</html>
