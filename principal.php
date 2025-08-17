<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

include 'conex.php';

// Consulta de 16 libros aleatorios
$sql_sugerencias = "SELECT ID, title, images FROM books ORDER BY RAND() LIMIT 16";
$resultado = mysqli_query($conexion, $sql_sugerencias);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="icon" href="logos/hoysi.png" type="image/jpg">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Infinity Books</title>
  <link rel="stylesheet" href="css/principal.css" />
</head>
<body>
  
  <!-- Header incluido -->
  <?php include 'header.php'; ?>

  <!-- Carrusel de banners -->
  <div class="slider-container">
    <div class="slider-track" id="slider">
      <img src="banersprinci/diosesbaner.jpg" alt="Libro 1" />
      <img src="banersprinci/elreinobaner.jpg" alt="Libro 2" />
      <img src="banersprinci/elecobaner.jpg" alt="Libro 3" />
      <img src="banersprinci/wildeheartbaner.jpg" alt="Libro 4" />
      <img src="banersprinci/falirbaner.jpg" alt="Libro 5" />
      <img src="banersprinci/veranosbaner.jpg" alt="Libro 6" />
      <img src="banersprinci/sombrasbaner.jpg" alt="Libro 7" />
      <img src="banersprinci/diosesbaner.jpg" alt="Libro 1 Clon" />
    </div>
    <button class="slider-btn left" id="btn-left">&#10094;</button>
    <button class="slider-btn right" id="btn-right">&#10095;</button>
  </div>

  <!-- Sección de libros sugeridos -->
  <div class="seccion-libros">
    <h2>Las mejores sugerencias para ti</h2>
    <div class="libros-carrusel">
      <button class="flecha izquierda" id="flecha-izq">&#10094;</button>
      <div class="contenedor-libros" id="contenedor-libros">
        <?php while ($book = mysqli_fetch_assoc($resultado)) { ?>
          <a href="libro1.php?id=<?php echo $book['ID']; ?>">
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

  <?php
  $categorias = ['Romance', 'Ciencia Ficción', 'Misterio'];
  foreach ($categorias as $categoria) {
      $sql_categoria = "SELECT ID, title, images FROM books WHERE category = '" . mysqli_real_escape_string($conexion, $categoria) . "'";
      $resultado_categoria = mysqli_query($conexion, $sql_categoria);
      if (mysqli_num_rows($resultado_categoria) > 0) { ?>
        <div class="seccion-libros" id="<?php echo $categoria; ?>">
          <h2><?php echo htmlspecialchars($categoria); ?></h2>
          <div class="libros-carrusel">
            <button class="flecha izquierda">&#10094;</button>
            <div class="contenedor-libros">
              <?php while ($book = mysqli_fetch_assoc($resultado_categoria)) { ?>
                <a href="libro1.php?id=<?php echo $book['ID']; ?>">
                  <div class="libro">
                    <img src="<?php echo htmlspecialchars($book['images']); ?>" alt="Portada de <?php echo htmlspecialchars($book['title']); ?>">
                    <p><?php echo htmlspecialchars($book['title']); ?></p>
                  </div>
                </a>
              <?php } ?>
            </div>
            <button class="flecha derecha">&#10095;</button>
          </div>
        </div>
  <?php }
  } ?>

  <!-- JS principal -->
  <script src="js/principal.js"></script>

  <!-- Scroll suave al seleccionar categoría con compensación por header fijo -->
  <script>
    function scrollToCategoria(categoria) {
        const seccion = document.getElementById(categoria);
        if (seccion) {
            const header = document.querySelector('.header');
            const headerHeight = header.offsetHeight + 10; // margen extra
            const seccionPos = seccion.getBoundingClientRect().top + window.pageYOffset - headerHeight;

            window.scrollTo({
                top: seccionPos,
                behavior: 'smooth'
            });
        }
    }
  </script>
</body>
</html>
