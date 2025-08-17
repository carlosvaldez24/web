<?php
include 'conex.php';

if (!isset($_GET['id'])) {
    echo "<p>❌ No se encontró ningún libro.</p>";
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM books WHERE ID = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    echo "<p>❌ Libro no encontrado.</p>";
    exit();
}

$images = !empty($book['images']) ? $book['images'] : 'default.jpg';

// --- Aumentar vistas ---
$stmt_update = $conexion->prepare("UPDATE books SET views = views + 1 WHERE ID = ?");
$stmt_update->bind_param("i", $id);
$stmt_update->execute();
$stmt_update->close();

// --- Consultar vistas y favoritos actualizados ---
$sql_stats = "SELECT views, favorites FROM books WHERE ID = ?";
$stmt_stats = $conexion->prepare($sql_stats);
$stmt_stats->bind_param("i", $id);
$stmt_stats->execute();
$result_stats = $stmt_stats->get_result();
$stats = $result_stats->fetch_assoc();
$stmt_stats->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="icon" href="logos/hoysi.png" type="image/jpg">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($book['title']); ?> - Infinity Books</title>
  <!-- Header universal -->
  <link rel="stylesheet" href="css/header.css" />
  <!-- Estilos solo del contenido del libro -->
  <link rel="stylesheet" href="css/libro1.css" />
</head>
<body data-libro-id="<?php echo $id; ?>">

  <!-- Header universal -->
  <?php include 'header.php'; ?>

  <!-- Contenido del libro -->
  <main class="contenido-libro">
    <div class="portada">
      <img src="<?php echo htmlspecialchars($images); ?>" alt="Portada del Libro" />
      <button class="btn-creador">
        <img src="<?php echo htmlspecialchars($book['image_author']); ?>" alt="Creador/a" />
        <span><?php echo htmlspecialchars($book['author']); ?></span>
      </button>
    </div>
    <div class="info-libro">
      <h1><?php echo htmlspecialchars($book['title']); ?></h1>
      <p class="autor">por <?php echo htmlspecialchars($book['author']); ?></p>
      <div class="stats">
        <span>👁️ <?php echo number_format($stats['views']); ?> vistas</span>
        <button id="btn-favorito" style="background:none; border:none; cursor:pointer; font-size:1.2em;">⭐</button>
        <span id="num-favoritos"><?php echo number_format($stats['favorites']); ?></span>
      </div>

<div class="botones-libro">
    <a href="capitulo.php?id=<?php echo $id; ?>&cap=1" class="btn-leer">📖 Leer ahora</a>
    <a href="principal.php" class="btn-leer">🔙 Regresar</a>
</div>

      <h3>Sinopsis</h3>
      <p class="sinopsis">
        <?php echo nl2br(htmlspecialchars($book['synopsis'])); ?>
      </p>
    </div>
  </main>

  <?php
  $sql_sugerencias_extra = "SELECT ID, title, images FROM books ORDER BY RAND() LIMIT 14";
  $resultado_sugerencias = mysqli_query($conexion, $sql_sugerencias_extra);
  ?>

  <section class="sugerencias">
    <h2>Libros sugeridos</h2>
    <div class="carrusel-container">
      <button class="flecha izquierda">❮</button>
      <div class="carrusel">
        <?php while ($libro_sugerido = mysqli_fetch_assoc($resultado_sugerencias)) { ?>
          <a href="libro1.php?id=<?php echo $libro_sugerido['ID']; ?>">
            <div class="libro">
              <img src="<?php echo htmlspecialchars($libro_sugerido['images']); ?>" alt="Portada de <?php echo htmlspecialchars($libro_sugerido['title']); ?>" />
              <p><?php echo htmlspecialchars($libro_sugerido['title']); ?></p>
            </div>
          </a>
        <?php } ?>
      </div>
      <button class="flecha derecha">❯</button>
    </div>
  </section>

  <script src="js/libro1.js"></script>

</body>
</html>
