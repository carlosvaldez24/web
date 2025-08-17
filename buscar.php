<?php
/* ===== INCLUIR CONEXIÓN A BASE DE DATOS ===== */
include 'conex.php';

/* ===== VERIFICAR SI SE RECIBIÓ EL PARÁMETRO DE BÚSQUEDA ===== */
if (isset($_GET['q'])) {
    /* ===== LIMPIAR EL INPUT DE BÚSQUEDA PARA EVITAR INYECCIONES SQL ===== */
    $busqueda = mysqli_real_escape_string($conexion, $_GET['q']);

    /* ===== CONSULTA: BUSCAR LIBROS CUYO TÍTULO CONTENGA LA CADENA BUSCADA (LIKE) ===== */
    $sql = "SELECT ID, title, images FROM books WHERE title LIKE '%$busqueda%' LIMIT 10";

    /* ===== EJECUTAR LA CONSULTA ===== */
    $resultado = mysqli_query($conexion, $sql);

    /* ===== VERIFICAR SI HAY RESULTADOS ===== */
    if (mysqli_num_rows($resultado) > 0) {
        /* ===== RECORRER CADA FILA Y CONSTRUIR HTML PARA RESULTADOS ===== */
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo '<div class="resultado-item">'; // Contenedor del resultado individual
            echo '<a href="libro1.php?id=' . $row['ID'] . '" style="display:flex; align-items:center; color:white; text-decoration:none;">'; // Enlace al libro
            echo '<img src="' . $row['images'] . '" alt="' . htmlspecialchars($row['title']) . '" />'; // Imagen de portada
            echo '<span>' . htmlspecialchars($row['title']) . '</span>'; // Título del libro
            echo '</a>'; // Cierre del enlace
            echo '</div>'; // Cierre del contenedor del resultado
        }
    } else {
        /* ===== SI NO HAY RESULTADOS, MOSTRAR MENSAJE ===== */
        echo '<div class="resultado-item"><span>No se encontraron libros.</span></div>';
    }
}
?>
