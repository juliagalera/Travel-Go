<?php

$host = 'localhost';
$user = 'root';
$passwd = '';
$dbname = 'travel_go';

$conn = new mysqli($host, $user, $passwd);

// Comprobar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si la base de datos ya existe y seleccionarla
if (!$conn->select_db($dbname)) {
    $sql = "CREATE DATABASE $dbname";
    $conn->query($sql); // Crear la base de datos si no existe
}

$conn->select_db($dbname);

// Crear tabla usuarios si no existe
$sql = "CREATE TABLE IF NOT EXISTS usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Crear tabla lugares si no existe
$sql = "CREATE TABLE IF NOT EXISTS lugares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL UNIQUE,
    detalle TEXT,
    imagen VARCHAR(255),
    categoria VARCHAR(255)
)";
$conn->query($sql);

// Crear tabla reseñas si no existe
$sql = "CREATE TABLE IF NOT EXISTS resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    lugar_id INT,
    comentario TEXT,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (lugar_id) REFERENCES lugares(id) ON DELETE CASCADE
)";
$conn->query($sql);


$lugares = [
    ['La Alhambra', 'La Alhambra es un complejo monumental sobre una ciudad palatina andalusí situada en Granada, España. Consiste en un conjunto de antiguos palacios, jardines y fortalezas inicialmente concebido para alojar al emir y la corte del reino Nazarí, más tarde como residencia de los reyes de Castilla y de sus representantes.', 'alhambra.jpg', 'cultura'],
    ['Mirador de San Nicolás', 'El Mirador de San Nicolás, ubicado en el barrio del Albaicín en Granada, es una visita obligada para turistas y locales por sus impresionantes vistas de la Alhambra, la Sierra Nevada y la ciudad antigua. Este lugar es ideal para disfrutar de un atardecer romántico o simplemente relajarse y admirar la belleza natural que rodea a Granada. Con una calificación de 4.5 sobre 5 basada en 1293 reseñas en TripAdvisor, el mirador es famoso por su ambiente bohemio y relajado, permitiendo a los visitantes escapar del bullicio de la ciudad y sumergirse en la historia y cultura del Albaicín.', 'nicolas.jpg', 'cultura'],
    ['Parque Federico García Lorca', 'Un oasis verde en medio de la ciudad, este parque combina naturaleza, arte y tranquilidad. Con jardines cuidados, estanques y zonas de descanso, es ideal para pasear, hacer picnic o simplemente desconectar. Además, su atmósfera recuerda al poeta granadino que le da nombre, convirtiéndolo en un rincón con alma literaria.', 'parqueLorca.jpg', 'parques'],
    ['Ruta en bici por el Genil', 'Descubre Granada desde otra perspectiva recorriendo el margen del río Genil en bicicleta. Esta ruta te conecta con la naturaleza y la historia local, pasando por zonas verdes y paisajes urbanos encantadores. Perfecta para los amantes del deporte y la fotografía.', 'genil.jpg', 'deportes'],
    ['Restaurante Las Tomasas', 'Ubicado en el Albaicín, este restaurante te regala una de las mejores vistas a la Alhambra mientras degustas platos típicos granadinos. Ideal para una velada especial, combina tradición y sabor en un entorno lleno de encanto y autenticidad', 'tomasas.jpg', 'gastronomia'],
    ['Hammam Al Ándalus', 'Sumérgete en una experiencia sensorial única en los baños árabes más emblemáticos de Granada. Inspirados en la tradición andalusí, estos baños ofrecen un viaje al pasado entre mosaicos, vapor y aromas que relajan cuerpo y mente. Una parada obligatoria para quienes buscan bienestar y cultura.', 'hammam.jpg', 'cultura'],
    ['Sendero del Llano de la Perdiz', 'Si lo tuyo es el senderismo, este camino natural ofrece una ruta tranquila con increíbles vistas de la ciudad, Sierra Nevada y la Alhambra. Es un plan perfecto para los que quieren conectar con la naturaleza sin alejarse demasiado de la ciudad.', 'perdiz.jpg', 'deportes'],
    ['Bar Los Diamantes', 'Conocido por sus tapas generosas y especialidad en pescado frito, este bar es todo un clásico en el corazón de Granada. Ideal para vivir el ambiente local y saborear auténtica gastronomía andaluza en un entorno informal y animado.', 'diamantes.jpg', 'gastronomia'],
    ['Centro Comercial Nevada', 'Un espacio moderno y amplio donde podrás pasar el día de compras, disfrutar de una película o comer en alguno de sus numerosos restaurantes. Con fácil acceso desde la ciudad, es perfecto tanto para familias como para amantes del shopping.', 'nevada.jpg', 'compras'],
    ['Alcaicería', 'Antiguo zoco de época nazarí, hoy convertido en un mercado lleno de tiendas de souvenirs, artesanía y productos típicos. Pasear por sus estrechas calles es como viajar en el tiempo, rodeado de aromas exóticos y coloridos mosaicos.', 'alcaiceria.jpg', 'compras'],
    ['Calle Recogidas', 'Una de las arterias comerciales más famosas de Granada. Aquí encontrarás tiendas de moda, cafeterías y el pulso urbano de la ciudad. Es el lugar ideal para quienes quieren combinar compras y ambiente local.', 'recodigas.jpg', 'compras'],
    ['Mercado de San Agustín', 'Este mercado gastronómico te ofrece una deliciosa mezcla de tradición y modernidad. Con puestos de productos frescos, tapas gourmet y ambiente local, es perfecto para saborear Granada con todos los sentidos.', 'agustin.jpg', 'compras'],
    ['Albaicín', 'El alma histórica de Granada. Declarado Patrimonio de la Humanidad, este barrio morisco de calles empedradas y casas blancas guarda siglos de historia, miradores de ensueño y rincones con esencia árabe. Un paseo por el Albaicín es una experiencia mágica que nadie debería perderse.', 'albaicin.jpg', 'cultura'],
    ['Palacio de Dar Al-Horra', 'Descubre el encanto del último palacio nazarí habitado en el Albaicín. El Palacio de Dar Al-Horra es un remanso de historia con vistas privilegiadas y una arquitectura que habla del esplendor musulmán en Granada. Pasear por sus patios es viajar al pasado más íntimo de la realeza nazarí.', 'alhorra.jpg', 'cultura'],
    ['Alquerías', 'Un espacio natural ideal para relajarse, pasear o practicar deporte rodeado de vegetación. Con áreas verdes amplias y zonas de descanso, el Parque Alquerías ofrece un respiro tranquilo dentro del entorno urbano. Perfecto para desconectar.', 'alquerias.jpg', 'parques'],
    ['Ruta del Azafrán', 'Un recorrido para los sentidos que cruza rincones históricos y miradores inolvidables. Ideal para quienes quieren caminar, conocer y dejarse sorprender por el alma auténtica de Granada. Cada paso cuenta una historia.', 'azafran.jpg', 'deportes'],
    ['Ruta de los Bolos', 'Una escapada entre naturaleza, agua y piedra. Esta ruta te guía por paisajes sorprendentes y puentes colgantes, perfecta para los amantes de la aventura y los escenarios únicos. ¡Lleva cámara!', 'bolos.jpg', 'deportes'],
    ['Ruta de los Cahorros', 'Una de las rutas más icónicas de la provincia. Desfiladeros, pasarelas y saltos de agua hacen de este sendero una experiencia vibrante. Ideal para quienes buscan algo diferente sin alejarse mucho de la ciudad.', 'cahorros.jpg', 'deportes'],
    ['Carmen Max Moreau', 'Una joya escondida en el Albaicín. Este carmen fue hogar del pintor belga Max Moreau y hoy es un espacio abierto al arte, la historia y la contemplación. Sus jardines son pura paz', 'carmenMax.jpg', 'cultura'],
    ['Mirador de Carvajales', 'Una de las vistas más románticas hacia la Alhambra. El Mirador de Carvajales es íntimo, tranquilo y perfecto para escapar de las multitudes. Recomendado para atardeceres memorables.', 'carvajales.jpg', 'cultura'],
    ['Catedral de Granada', 'Símbolo imponente del Renacimiento español, la Catedral de Granada es una parada obligatoria para los amantes de la historia, el arte y la espiritualidad. Majestuosa por fuera, impresionante por dentro.', 'catedral.jpg', 'cultura'],
    ['Chantarela', 'Ideal para una copa entre amigos o tapear en un ambiente moderno y relajado. Chantarela combina sabores tradicionales con una propuesta fresca. ¡Siempre hay algo nuevo que probar!', 'chantarela.jpg', 'gastronomia'],
    ['Costajump', 'Diversión asegurada para grandes y pequeños. Costajump es un centro de camas elásticas donde puedes saltar, reír y liberar energía. Una alternativa perfecta para una tarde diferente.', 'costajump.jpg', 'parques'],
    ['Mirador de San Cristóbal', 'Mirador con vistas panorámicas de la ciudad y la Alhambra.', 'cristobal.jpg', 'cultura'],
    ['Cueva del Agua', 'Ubicada en las montañas que rodean Granada, la Cueva del Agua es un enclave natural perfecto para los amantes del senderismo y la aventura. Rodeada de paisajes escarpados y vegetación autóctona, invita a explorar la belleza salvaje de la provincia mientras disfrutas de la tranquilidad y el aire puro. Un rincón escondido ideal para reconectar con la naturaleza.', 'cuevaAgua.jpg', 'parques'],
    ['Acera del Darro', 'Este pintoresco paseo a lo largo del río Darro conecta el bullicioso centro con la historia viva de Granada. Flanqueado por antiguos edificios, tiendas encantadoras y vistas al Albaicín y la Alhambra, es uno de los rincones más románticos y auténticos de la ciudad. Pasear por aquí es como caminar entre siglos de historia con el murmullo del río como banda sonora.', 'darro.jpg', 'cultura'],
    ['Ruta de la Estrella', 'Esta ruta histórica y cultural te lleva a través de paisajes que mezclan naturaleza e historia, con vistas privilegiadas a la ciudad y a la majestuosa Alhambra. Ideal para quienes buscan una experiencia completa al aire libre, esta caminata ofrece un equilibrio entre belleza natural, ejercicio y un repaso visual por el legado granadino.', 'estrella.jpg', 'deportes'],
    ['Restaurante Fábula', 'Un lugar donde la cocina tradicional andaluza se transforma en una experiencia memorable. Fábula destaca por su atención al detalle, un ambiente cálido y acogedor, y una carta que rescata sabores auténticos con un toque moderno. Perfecto para una comida tranquila o una cena especial en el corazón de Granada.', 'fabula.jpg', 'gastronomia'],
    ['Granaita', 'Un espacio moderno donde conviven tiendas, ocio y gastronomía. Ya sea para hacer compras, pasar el rato o comer algo rico, Granaita tiene todo lo que necesitas a pocos minutos del centro.', 'granaita.jpg', 'compras'],
    ['Monasterio de San Jerónimo', 'Un lugar de recogimiento y belleza artística. Este monasterio es uno de los tesoros renacentistas de Granada, con un claustro que invita al silencio y una iglesia que deja sin palabras.', 'jeronimo.jpg', 'cultura'],
    ['Parque Miguel de los Ríos', 'Un pulmón verde donde naturaleza, arte urbano y deporte se encuentran. Justo frente a los cármenes, este parque ofrece zonas de calistenia y senderos para todos. Ideal para pasar la tarde.', 'miguel.jpg', 'parques'],
    ['Museo de Bellas Artes', 'Ubicado en el Palacio de Carlos V, este museo ofrece un recorrido por siglos de arte granadino y español. Un espacio que inspira y conecta con la sensibilidad de la ciudad.', 'museo.jpg', 'cultura'],
    ['Palacio de Deportes', 'Escenario de eventos deportivos, conciertos y espectáculos. Este recinto es símbolo del dinamismo de Granada. Consulta su agenda y vive una experiencia vibrante.', 'palacioDep.jpg', 'deportes'],
    ['Centro Comercial Neptuno', 'Una mezcla de compras, cine y restauración en pleno corazón de la ciudad. Neptuno es ideal para una tarde de ocio y entretenimiento sin complicaciones.', 'neptuno.jpg', 'compras'],
    ['Mirador de San Miguel', 'El mirador más alto de Granada, con una vista completa de la ciudad, la Alhambra y Sierra Nevada. Es el lugar ideal para sentir la inmensidad de Granada y disfrutar de un atardecer inolvidable.', 'sanmiguel.jpg', 'cultura'],
    ['Serrallo Plaza', 'Centro comercial con una oferta variada y un ambiente muy agradable. Perfecto para comprar, tomar algo o simplemente pasear. Además, su decoración suele cambiar según la temporada.', 'serrallo.jpg', 'compras'],
    ['Sherpa', 'Más que una tienda de montaña, Sherpa es punto de encuentro para aventureros y exploradores. Su equipo experto y su selección de productos hacen que siempre salgas listo para tu próxima ruta.', 'sherpa.jpg', 'compras'],
    ['Mirador de la Silla del Moro', 'Ubicado justo frente a la Alhambra, este mirador ofrece una perspectiva única del conjunto monumental. Menos concurrido que otros, es perfecto para una escapada tranquila.', 'silla.jpg', 'cultura'],
    ['La Talega', 'Un rincón donde descubrir los sabores de la tierra. La Talega vende productos locales, ecológicos y con historia. Ideal para llevarse un trocito de Granada en la maleta.', 'talega.jpg', 'compras'],
    ['Jardines del Triunfo', 'Un oasis urbano con fuentes, estatuas y paseos sombreados. Los Jardines del Triunfo son lugar de encuentro, descanso y paseo para locales y visitantes. Un rincón con encanto en pleno centro.', 'jardines.jpg', 'parques'],
    ['Cueva de las Ventanas', 'Una cueva natural que combina belleza geológica con un recorrido interpretativo. Visitarla es adentrarse en un mundo subterráneo lleno de sorpresas. Ideal para familias y curiosos.', 'ventanas.jpg', 'parques'],
    ['Ruta de la Cruz de Víznar', 'Un camino entre naturaleza y memoria. Esta ruta atraviesa parajes bellísimos con vistas panorámicas y espacios cargados de historia. Perfecta para senderistas y amantes de la reflexión.', 'viznar.jpg', 'deportes'],
    ['Casa de Zafra', 'La Casa de Zafra es una residencia hispanomusulmana del siglo XIV ubicada en el barrio del Albaicín, Granada. Construida por una familia importante del reino, pasó a manos de Hernando de Zafra tras la conquista de Granada. Actualmente alberga el Centro de Interpretación del Albaicín, donde se puede conocer la historia del barrio y de la ciudad.', 'zafra.jpg', 'cultura'],
    ['Basilica de San Juan de Dios', 'Una joya del barroco andaluz, la Basílica de San Juan de Dios impresiona con su rica decoración interior, sus retablos dorados y su arquitectura monumental. Más que una iglesia, es un testimonio de devoción artística y espiritual que transporta a quien la visita al esplendor del siglo XVIII granadino.', 'basilica.jpg', 'cultura'],
    ['Sierra de Huétor', 'Un paraíso natural a pocos kilómetros de la ciudad, el Parque Natural de la Sierra de Huétor ofrece rutas de senderismo, áreas recreativas y paisajes de montaña espectaculares. Ideal para desconectar, hacer deporte o simplemente respirar el aire puro de la sierra granadina.', 'huetor.jpg', 'parques'],
    ['Museo Casa de Lorca', 'En esta casa-museo situada en la Vega de Granada, los visitantes pueden sumergirse en el mundo del poeta Federico García Lorca. Conserva objetos personales, manuscritos y recuerdos que permiten comprender mejor su vida y su obra, en un entorno íntimo y emocional.', 'lorca.jpg', 'cultura'],
    ['Carmen de los Mártires', 'Este rincón de Granada combina jardines románticos, estanques con cisnes y una villa señorial con vistas privilegiadas a la Alhambra y Sierra Nevada. Pasear por el Carmen de los Mártires es como entrar en un cuento lleno de paz, historia y belleza.', 'martires.jpg', 'cultura'],
    ['Restaurante Morayma', 'Ubicado en una casa morisca del Albaicín con vistas a la Alhambra, Morayma ofrece cocina granadina en un entorno encantador. Sus platos tradicionales, su ambiente sereno y su historia lo convierten en una experiencia gastronómica única.', 'morayma.jpg', 'gastronomia'],
    ['Sacromonte', 'Famoso por sus casas-cueva y su profunda vinculación con el flamenco, el Sacromonte es el alma gitana de Granada. Callejones empinados, espectáculos auténticos y una conexión directa con la historia viva de la ciudad hacen de este barrio un lugar imprescindible.', 'sacromonte.jpg', 'cultura'],
    ['Paseo de los Tristes', 'Con el río Darro a un lado y la Alhambra vigilante en lo alto, este paseo es uno de los más encantadores de Granada. Antiguo centro de celebraciones populares, hoy ofrece terrazas con encanto y una de las postales más icónicas de la ciudad.', 'tristes.jpg', 'cultura'],
    ['Triunfo', 'Situado junto a los Jardines del Triunfo, este espacio conmemora la victoria sobre las tropas napoleónicas. Rodeado de vegetación, fuentes y bancos, es un lugar lleno de simbolismo donde detenerse a descansar en el corazón de Granada.', 'triunfo.jpg', 'cultura'],
    ['Zafra', 'Esta plazuela escondida en el Albaicín es un remanso de paz. Su belleza reside en su simplicidad: una fuente, unas vistas espectaculares y el silencio de la Granada antigua. Perfecta para perderse un rato lejos del bullicio.', 'zafra.jpg', 'cultura'],
    ['Generalife', 'Los jardines y palacio de verano de los sultanes nazaríes son uno de los grandes tesoros de la Alhambra. Fuentes, miradores y caminos floridos convierten al Generalife en un lugar mágico, ideal para soñar despierto y viajar al pasado andalusí.', 'generalife.jpg', 'parques'],
    ['Barrio del Realejo', 'Antiguo barrio judío de Granada, el Realejo es ahora un espacio vibrante lleno de arte urbano, bares con encanto y una mezcla única de historia y modernidad. Pasear por sus calles es descubrir un rincón diferente y lleno de vida.', 'realejo.jpg', 'cultura'],
    ['La Cartuja', 'El Monasterio de la Cartuja es una joya poco conocida con una explosión barroca en su interior. Su sacristía, considerada una de las más bellas del mundo, y su tranquilidad invitan a la contemplación y al asombro.', 'cartuja.jpg', 'cultura'],
    ['Bañuelo', 'Uno de los baños árabes mejor conservados de España, El Bañuelo ofrece una ventana a la cultura del agua en la época musulmana. Sus bóvedas, arcos y historia convierten la visita en un viaje al pasado más íntimo de Granada.', 'buñuelo.jpg', 'cultura'],
    ['Palacio de los Córdova', 'Este elegante edificio renacentista alberga archivos históricos y ofrece un entorno señorial con jardines cuidados. Un rincón donde la historia se respira en cada rincón, ideal para eventos y para quienes buscan rincones menos turísticos.', 'cordova.jpg', 'cultura'],
    ['Paseo de la Bomba', 'A la orilla del río Genil, este paseo es perfecto para caminar, montar en bici o simplemente disfrutar del sonido del agua y la sombra de los árboles. Muy frecuentado por locales, es un buen lugar para relajarse y ver la vida granadina pasar.', 'bomba.jpg', 'parques'],
    ['Puerta de Elvira', 'Antiguo acceso a la ciudad amurallada, la Puerta de Elvira es uno de los vestigios más importantes del pasado musulmán de Granada. Testigo silencioso de siglos de historia, da la bienvenida a quien se adentra en el Albaicín', 'puertaElvira.jpg', 'cultura'],
    ['La Madraza', 'Fundada en el siglo XIV por Yusuf I, la Madraza fue la primera universidad islámica de Granada. Su mihrab y su decoración interior recuerdan la importancia del saber en al-Ándalus y su legado cultural y educativo.', 'madraza.jpg', 'cultura'],
    ['Club de Golf Granada', 'Ubicado en un entorno natural privilegiado, este club ofrece instalaciones de primer nivel para aficionados y profesionales del golf. Ideal para quienes buscan combinar deporte, naturaleza y vistas espectaculares a Sierra Nevada.', 'golf.jpg', 'deportes'],
    ['Centro Deportivo Municipal Bola de Oro', 'Este complejo moderno cuenta con pistas de fútbol, baloncesto y otras instalaciones deportivas. Perfecto para locales y visitantes que quieren mantenerse activos durante su estancia en la ciudad.', 'bolaOro.jpg', 'deportes'],
    ['Estadio Los Cármenes', 'El Estadio de Los Cármenes es un lugar emblemático de Granada, hogar del Granada CF, y uno de los principales espacios deportivos de la ciudad. Con su impresionante capacidad y ambiente vibrante, es el escenario de importantes partidos de fútbol y eventos deportivos. Ubicado a las afueras del centro de la ciudad, el estadio ofrece una experiencia única tanto para los aficionados al fútbol como para los visitantes que desean conocer una parte importante de la cultura deportiva granadina.', 'carmenes.jpg', 'deportes']
];


foreach ($lugares as $lugar) {
   if (isset($lugar[0]) && isset($lugar[1]) && isset($lugar[2]) && isset($lugar[3])) {
    // Proceder con la inserción si todas las claves están presentes
    $nombre = $lugar[0];
    $detalle = $lugar[1];
    $imagen = $lugar[2];
    $categoria = $lugar[3];

    $stmt = $conn->prepare("INSERT IGNORE INTO lugares (nombre, detalle, imagen, categoria) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $detalle, $imagen, $categoria);
    $stmt->execute();
}else{
    echo "Faltan datos en el array para el lugar: " . json_encode($lugar);
}
}


?>
