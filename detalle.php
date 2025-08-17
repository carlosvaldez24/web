<?php
include 'conex.php';

// IDs fijos que quieres mostrar en el carrusel
$sugerencias_ids = [8, 9, 10, 33, 341, 1]; // Cambia estos según tus libros destacados

// Validar el ID del libro actual
if (!isset($_GET['id']) || !in_array((int)$_GET['id'], $sugerencias_ids)) {
    echo "Libro no disponible para esta vista.";
    exit();
}

$id_libro = (int)$_GET['id'];

// Traer datos del libro actual
$sql_libro = "SELECT * FROM books WHERE ID = $id_libro";
$resultado_libro = mysqli_query($conexion, $sql_libro);

if (!$resultado_libro || mysqli_num_rows($resultado_libro) == 0) {
    echo "Libro no encontrado.";
    exit();
}
$libro = mysqli_fetch_assoc($resultado_libro);

// Traer sugerencias, quitando el libro actual
$ids_str = implode(',', $sugerencias_ids);
$sql_sugerencias = "SELECT ID, title, images FROM books WHERE ID IN ($ids_str) AND ID != $id_libro";
$resultado_sugerencias = mysqli_query($conexion, $sql_sugerencias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="icon" href="logos/hoysi.png" type="image/jpg">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($libro['title']); ?> - Infinity Books</title>
  <link rel="stylesheet" href="css/detalle.css" />
</head>
<body>

  <!-- Header solo con logo -->
  <header class="header">
    <div class="left-header">
      <a href="index.php">
        <img src="logos/infinity books.jpg" alt="Logo Infinity Books" class="logo">
      </a>
    </div>
  </header>

  <div class="linea-blanca"></div>

  <!-- Contenido principal del libro -->
  <main class="contenido-libro">
    <div class="portada">
      <img src="<?php echo htmlspecialchars($libro['images']); ?>" alt="Portada de <?php echo htmlspecialchars($libro['title']); ?>">
      <button class="btn-creador" type="button" title="Autor">
        <img src="<?php echo htmlspecialchars($libro['image_author']); ?>" alt="Autor <?php echo htmlspecialchars($libro['author']); ?>">
        <?php echo htmlspecialchars($libro['author']); ?>
      </button>
    </div>

    <div class="info-libro">
      <h1><?php echo htmlspecialchars($libro['title']); ?></h1>
      <p class="sinopsis"><?php echo nl2br(htmlspecialchars($libro['synopsis'])); ?></p>
      <!-- Botón Leer ahora apunta a detalleleer.php -->
      <a href="detalleleer.php?id=<?php echo $libro['ID']; ?>" class="btn-leer">Leer ahora</a>
    </div>
  </main>

  <!-- Carrusel de sugerencias -->
  <section class="sugerencias">
    <h2>Libros sugeridos</h2>
    <div class="carrusel-container">
      <button class="flecha izquierda" id="flecha-izq">&#10094;</button>
      <div class="carrusel" id="carrusel-libros">
        <?php while ($book = mysqli_fetch_assoc($resultado_sugerencias)) { ?>
          <a href="detalle.php?id=<?php echo $book['ID']; ?>" class="libro">
            <img src="<?php echo htmlspecialchars($book['images']); ?>" alt="Portada de <?php echo htmlspecialchars($book['title']); ?>">
            <p><?php echo htmlspecialchars($book['title']); ?></p>
          </a>
        <?php } ?>
      </div>
      <button class="flecha derecha" id="flecha-der">&#10095;</button>
    </div>
  </section>

  <script>
    const carrusel = document.getElementById('carrusel-libros');
    const flechaIzq = document.getElementById('flecha-izq');
    const flechaDer = document.getElementById('flecha-der');

    flechaDer.addEventListener('click', () => {
      carrusel.scrollBy({ left: 300, behavior: 'smooth' });
    });

    flechaIzq.addEventListener('click', () => {
      carrusel.scrollBy({ left: -300, behavior: 'smooth' });
    });
  </script>
</body>
</html>
