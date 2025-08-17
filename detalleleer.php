<?php
include 'conex.php';

// Validar parámetro id
if (!isset($_GET['id'])) {
    echo "<p>❌ Datos incompletos.</p>";
    exit();
}

$id_libro = intval($_GET['id']);

// Si no se envía 'cap', asumimos el capítulo 1
$num_capitulo = isset($_GET['cap']) ? intval($_GET['cap']) : 1;

// Libros permitidos en detalle.php (gratis)
$libros_detalle = [8, 9, 10, 33, 34]; // Cambia según los libros que muestres en detalle.php

if (!in_array($id_libro, $libros_detalle)) {
    echo "<p>❌ No puedes leer este libro desde esta página.</p>";
    exit();
}

// Traer capítulo del libro
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

// Total de capítulos del libro
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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($capitulo['titulo']); ?> - Capítulo <?php echo $num_capitulo; ?></title>
<link rel="stylesheet" href="capitulo.css">
</head>
<body>

<header class="header">
    <a href="detalle.php?id=<?php echo $id_libro; ?>" class="btn-volver">⬅ Volver al libro</a>
</header>

<div class="linea"></div>

<div class="banner-container">
    <img class="BannerCC1" src="<?php echo htmlspecialchars($capitulo['banner']); ?>" alt="Banner del capítulo">
</div>

<h1>Capítulo <?php echo $capitulo['numero_capitulo']; ?>: <?php echo htmlspecialchars($capitulo['titulo']); ?></h1>

<div class="cuadro">
    <p><?php echo nl2br(htmlspecialchars($capitulo['contenido'])); ?></p>
</div>

<!-- Botones de navegación entre capítulos -->
<div class="botones">
    <?php if ($num_capitulo > 1): ?>
        <a href="detalleleer.php?id=<?php echo $id_libro; ?>&cap=<?php echo $num_capitulo - 1; ?>">
            <button>⬅ Anterior</button>
        </a>
    <?php endif; ?>

    <?php if ($num_capitulo < $total_capitulos): ?>
        <a href="detalleleer.php?id=<?php echo $id_libro; ?>&cap=<?php echo $num_capitulo + 1; ?>">
            <button>Siguiente ➡</button>
        </a>
    <?php endif; ?>
</div>

</body>
</html>
