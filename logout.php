<?php
// ===== INICIO DE SESIÓN =====
session_start();

// ===== DESTRUIR TODAS LAS VARIABLES DE SESIÓN =====
$_SESSION = array();

// ===== DESTRUIR LA SESIÓN =====
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ===== CONFIGURACIÓN DE META Y TÍTULO ===== -->
    <meta charset="UTF-8">
    <title>Cerrando sesión...</title>

    <!-- ===== ESTILOS INTERNOS ===== -->
    <style>
        /* ===== ESTILO GENERAL DEL BODY ===== */
        body {
            font-family: Arial, sans-serif; /* Fuente del texto */
            text-align: center;             /* Centrar texto horizontal */
            background-color: #111;         /* Fondo oscuro */
            color: white;                   /* Color del texto */
            display: flex;                  /* Uso de flexbox */
            justify-content: center;        /* Centrado horizontal */
            align-items: center;            /* Centrado vertical */
            height: 100vh;                  /* Altura completa de la ventana */
            flex-direction: column;         /* Ordenar elementos verticalmente */
        }

        /* ===== LOADER ANIMADO ===== */
        .loader {
            border: 6px solid #f3f3f3;       /* Borde gris claro */
            border-top: 6px solid #3498db;   /* Borde superior azul */
            border-radius: 50%;               /* Forma circular */
            width: 60px;                      /* Ancho del loader */
            height: 60px;                     /* Alto del loader */
            animation: spin 1s linear infinite; /* Animación de giro */
            margin: 20px auto;                /* Separación y centrado */
        }

        /* ===== ANIMACIÓN DEL SPINNER ===== */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== MENSAJE DE CIERRE DE SESIÓN ===== */
        .mensaje {
            font-size: 18px;  /* Tamaño del texto */
            margin-top: 15px; /* Separación superior respecto al loader */
        }
    </style>
</head>
<body>
    <!-- ===== LOADER VISUAL ===== -->
    <div class="loader"></div>

    <!-- ===== MENSAJE DE CIERRE DE SESIÓN ===== -->
    <p class="mensaje">🔒 Cerrando sesión... Redirigiendo a inicio</p>

    <!-- ===== SCRIPT PARA REDIRECCIÓN AUTOMÁTICA ===== -->
    <script>
        // Espera 3 segundos y redirige al index.php
        setTimeout(() => {
            window.location.href = "index.php"; // Redirige al index después de 3 segundos
        }, 3000);
    </script>
</body>
</html>
