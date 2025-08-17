<?php
include 'conex.php';

// Verificar parámetros
if (!isset($_GET['id']) || !isset($_GET['cap'])) {
    echo "<p>❌ Datos incompletos.</p>";
    exit();
}

$id_libro = intval($_GET['id']);
$num_capitulo = intval($_GET['cap']);

// Consulta para obtener capítulo actual
$sql = "SELECT * FROM tablechapters WHERE id_libro = ? AND numero_capitulo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_libro, $num_capitulo);
$stmt->execute();
$result = $stmt->get_result();
$capitulo = $result->fetch_assoc();

if (!$capitulo) {
    echo "<p>❌ Capítulo no encontrado.</p>";
    exit();
}

// Consultar el total de capítulos del libro
$sql_total = "SELECT COUNT(*) AS total FROM tablechapters WHERE id_libro = ?";
$stmt_total = $conexion->prepare($sql_total);
$stmt_total->bind_param("i", $id_libro);
$stmt_total->execute();
$res_total = $stmt_total->get_result()->fetch_assoc();
$total_capitulos = $res_total['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="logos/hoysi.png" type="image/jpg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($capitulo['titulo']); ?> - Capítulo <?php echo $num_capitulo; ?></title>
    <link rel="stylesheet" href="css/capitulo.css">
</head>
<body>

<!-- Header con logo y botón -->
<header class="header">
    <div class="left-header">
        <a href="principal.php">
            <img src="logos/infinity books.jpg" alt="Logo Infinity Books" class="logo">
        </a>
    </div>
    <a href="libro1.php?id=<?php echo $id_libro; ?>" class="btn-volver">⬅ Volver al libro</a>
</header>

<div class="linea"></div>

<div class="banner-container">
    <img class="BannerCC1" src="<?php echo htmlspecialchars($capitulo['banner']); ?>" alt="Banner del capítulo">
</div>

<h1>Capítulo <?php echo $capitulo['numero_capitulo']; ?>: <?php echo htmlspecialchars($capitulo['titulo']); ?></h1>

<div class="cuadro">
    <p><?php echo nl2br(htmlspecialchars($capitulo['contenido'])); ?></p>
</div>

<!-- Botones de navegación -->
<div class="botones">
    <?php if ($num_capitulo > 1): ?>
        <a href="capitulo.php?id=<?php echo $id_libro; ?>&cap=<?php echo $num_capitulo - 1; ?>">
            <button>⬅ Anterior</button>
        </a>
    <?php endif; ?>

    <a href="libro1.php?id=<?php echo $id_libro; ?>" class="boton-volver-abajo">Volver al libro</a>

    <?php if ($num_capitulo < $total_capitulos): ?>
        <a href="capitulo.php?id=<?php echo $id_libro; ?>&cap=<?php echo $num_capitulo + 1; ?>">
            <button>Siguiente ➡</button>
        </a>
    <?php endif; ?>
</div>

</body>
</html>
