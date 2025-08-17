<?php
include 'conex.php';

// IDs fijos de libros que quieres mostrar en el carrusel
$libros_ids = [8, 9, 10, 33, 34, 32, 1]; // Cambia estos según tus libros destacados
$ids_string = implode(',', $libros_ids);
$sql_sugerencias = "SELECT ID, title, images FROM books WHERE ID IN ($ids_string)";
$resultado = mysqli_query($conexion, $sql_sugerencias);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="icon" href="logos/hoysi.png" type="image/jpg">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Infinity Books - Inicio</title>

  <!-- Tus estilos -->
  <link rel="stylesheet" href="css/index.css" />

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="no-scroll"><!-- bloqueamos scroll mientras está la portada -->

  <!-- ====== PORTADA (SPLASH) ====== -->
  <div id="portada">
    <canvas id="estrellas"></canvas>
    <div id="logo">
      <!-- Asegúrate de que esta imagen exista; usa / (no backslash) -->
      <img src="logos/logoflash.png" alt="Logo Infinity Books">
    </div>
  </div>

  <!-- ====== CONTENIDO REAL (OCULTO AL INICIO) ====== -->
  <div id="contenido" style="display:none;">

    <!-- Header -->
    <header class="header">
      <img src="logos/infinity books.jpg" alt="Logo" class="logo">
      <div class="nav-buttons">
        <a href="iniciar_sesion.html" class="btn">Iniciar sesión</a>
        <a href="crearcuenta.html" class="btn">Registrarse</a>
      </div>
    </header>

    <!-- Línea blanca -->
    <div class="linea-blanca"></div>

    <!-- Sección principal -->
    <section class="main" data-aos="fade-up" data-aos-duration="3000">
      <h2>¡Bienvenido a Infinity Books!</h2>
      <p>Tu espacio digital para leer, compartir y descubrir libros.</p>
    </section>

    <!-- Carrusel banners original -->
    <div class="slider-container">
      <div class="slider-track" id="slider">
        <img src="carrusel/wildeheart.jpg" alt="Banner 1" />
        <img src="carrusel/eleco.jpg" alt="Banner 2" />
        <img src="carrusel/falir.jpg" alt="Banner 3" />
        <img src="carrusel/elreino.jpg" alt="Banner 4" />
      </div>
      <button id="btn-left" class="slider-btn left">&#10094;</button>
      <button id="btn-right" class="slider-btn right">&#10095;</button>
    </div>

    <!-- NUEVO Carrusel libros seleccionados -->
    <div class="seccion-libros">
      <h2>Las mejores sugerencias para ti</h2>
      <div class="libros-carrusel">
        <button class="flecha izquierda" id="flecha-izq">&#10094;</button>
        <div class="contenedor-libros" id="contenedor-libros" data-aos="fade-up" data-aos-duration="3000">
          <?php while ($book = mysqli_fetch_assoc($resultado)) { ?>
            <a href="detalle.php?seleccion=personalizada&id=<?php echo $book['ID']; ?>">
              <div class="libro">
                <img src="<?php echo $book['images']; ?>" alt="Portada de <?php echo htmlspecialchars($book['title']); ?>">
                <p><?php echo htmlspecialchars($book['title']); ?></p>
              </div>
            </a>
          <?php } ?>
        </div>
        <button class="flecha derecha" id="flecha-der">&#10095;</button>
      </div>
    </div>

    <!-- Testimonios -->
    <section class="testimonials" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500">
      <div class="testimonial">
        <img src="nosotros/carlos.jpg" alt="Ana Martínez" class="testimonial-img">
        <blockquote>
          “Me encanta esta plataforma, encuentro libros increíbles todos los días.”
          <footer>— Carlos Valdez</footer>
        </blockquote>
      </div>
      <div class="testimonial">
        <img src="nosotros/yoshi.jpg" alt="Carlos Ramírez" class="testimonial-img">
        <blockquote>
          “Infinity Books ha cambiado mi forma de leer. Todo es digital y accesible.”
          <footer>— Yoselin Cortéz</footer>
        </blockquote>
      </div>
      <div class="testimonial">
        <img src="nosotros/natalia.jpg" alt="Laura Pérez" class="testimonial-img">
        <blockquote>
          “Puedo compartir mis historias y recibir comentarios. ¡Es genial!”
          <footer>— Jennifer Jimenez</footer>
        </blockquote>
      </div>
      <div class="testimonial">
        <img src="nosotros/ninet.jpg" alt="Luis Gómez" class="testimonial-img">
        <blockquote>
          “Excelente diseño y fácil de usar. Muy recomendado.”
          <footer>— Khatherinne Trinidad</footer>
        </blockquote>
      </div>
      <div class="testimonial">
        <img src="nosotros/marip.jpg" alt="Sofia Herrera" class="testimonial-img">
        <blockquote>
          “Una comunidad lectora con mucho potencial.”
          <footer>— María Andree Barrera</footer>
        </blockquote>
      </div>
      <div class="testimonial">
        <img src="nosotros/daniela.jpg" alt="Sofia Herrera" class="testimonial-img">
        <blockquote>
          “Una comunidad lectora con mucho potencial.”
          <footer>— Dulce Aguirre</footer>
        </blockquote>
      </div>
    </section>

    <!-- Imagen final -->
    <section class="imagen-final">
      <img src="carrusel/dise.jpg" alt="Computadora" />
    </section>

  </div><!-- /#contenido -->

  <!-- ====== SCRIPTS ====== -->
  <!-- Portada primero -->
  <script src="js/portada.js"></script>

  <!-- Tu JS existente -->
  <script src="js/index.js"></script>

  <!-- AOS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
