<?php
// ===== INICIO DE SESIÓN =====
// Verifica si la sesión no ha sido iniciada y la inicia
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- ===== ENLACE AL CSS DEL HEADER ===== -->
<link rel="stylesheet" href="css/header.css">

<!-- ===== INICIO DEL HEADER PRINCIPAL ===== -->
<header class="header">
    <div class="left-header">
        <!-- ===== LOGO ===== -->
        <img src="logos/infinity books.jpg" alt="Logo Infinity Books" class="logo" />

        <!-- ===== DROPDOWN DE CATEGORÍAS ===== -->
        <div class="dropdown">
            <!-- Botón que despliega las categorías -->
            <button class="dropbtn">Categorías</button>

            <!-- Contenido del dropdown -->
            <div class="dropdown-content">
                <!-- Opción 1: Romance, llama a la función scrollToCategoria -->
                <a href="javascript:void(0);" onclick="scrollToCategoria('Romance')">Romance</a>

                <!-- Opción 2: Ciencia Ficción, llama a la función scrollToCategoria -->
                <a href="javascript:void(0);" onclick="scrollToCategoria('Ciencia Ficción')">Ciencia Ficción</a>

                <!-- Opción 3: Misterio, llama a la función scrollToCategoria -->
                <a href="javascript:void(0);" onclick="scrollToCategoria('Misterio')">Misterio</a>

                <!-- ===== NUEVA SECCIÓN: CERRAR SESIÓN ===== -->
                <!-- Verifica si el usuario ha iniciado sesión y muestra el link de logout -->
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <a href="logout.php">Cerrar sesión</a>
                <?php endif; ?>
            </div> <!-- FIN DE dropdown-content -->
        </div> <!-- FIN DE dropdown -->
    </div> <!-- FIN DE left-header -->

    <!-- ===== SECCIÓN DERECHA DEL HEADER (BUSCADOR) ===== -->
    <div class="right-header">
        <div class="search-container">
            <!-- Input del buscador -->
            <input type="text" id="searchInput" placeholder="Buscar..." onkeyup="buscarLibro()">

            <!-- Botón del buscador -->
            <button onclick="buscarLibro()" class="search-btn">🔍</button>

            <!-- Contenedor para mostrar resultados del buscador -->
            <div id="resultadosBusqueda" class="resultados-busqueda"></div>
        </div> <!-- FIN DE search-container -->
    </div> <!-- FIN DE right-header -->
</header> <!-- FIN DEL HEADER PRINCIPAL -->

<!-- ===== LÍNEA BLANCA DE SEPARACIÓN DE HEADER ===== -->
<div class="linea-blanca"></div>
