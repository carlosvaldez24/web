<?php
// ==========================
// INICIO DE LOGIN.PHP
// ==========================

session_start(); // Inicia la sesión para guardar datos del usuario

// ==========================
// Conexión a la base de datos
// ==========================
$conexion = new mysqli("localhost", "root", "", "infinitibooksjuly14");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// ==========================
// Variables de control
// ==========================
$mensaje = "";        // Mensaje que se mostrará al usuario
$redirect = false;    // Si el login es exitoso → redirigir a principal.php
$backToForm = false;  // Si hay error → regresar al formulario de login

// ==========================
// Procesar solo si el método es POST
// ==========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ==========================
    // Verificar que los campos correo y contraseña no estén vacíos
    // ==========================
    if (!empty($_POST['correo']) && !empty($_POST['contraseña'])) {
        $correo = $conexion->real_escape_string($_POST['correo']); // Sanitiza correo
        $password = $_POST['contraseña']; // Contraseña ingresada

        // ==========================
        // Consultar la base de datos por el usuario
        // ==========================
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo' LIMIT 1";
        $resultado = $conexion->query($sql);

        if ($resultado && $resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            // ==========================
            // Verificar la contraseña con password_verify
            // ==========================
            if (password_verify($password, $usuario['contraseña'])) {
                // ==========================
                // Login correcto → guardar sesión
                // ==========================
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_correo'] = $usuario['correo'];

                $mensaje = "✅ Sesión iniciada correctamente. Redirigiendo a principal.php...";
                $redirect = true;
            } else {
                // ==========================
                // Contraseña incorrecta → mensaje y regresar al formulario
                // ==========================
                $mensaje = "❌ Contraseña incorrecta. Redirigiendo al formulario...";
                $backToForm = true;
            }
        } else {
            // ==========================
            // Usuario no encontrado → mensaje y regresar al formulario
            // ==========================
            $mensaje = "❌ Usuario no encontrado. Redirigiendo al formulario...";
            $backToForm = true;
        }
    } else {
        // ==========================
        // Campos vacíos → mensaje y regresar al formulario
        // ==========================
        $mensaje = "❌ Todos los campos son obligatorios. Redirigiendo al formulario...";
        $backToForm = true;
    }
} else {
    // ==========================
    // Acceso no permitido si no es POST
    // ==========================
    $mensaje = "❌ Acceso inválido. Redirigiendo al formulario...";
    $backToForm = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* ==========================
           Estilos generales del body
           ========================== */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #111;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        /* ==========================
           Loader circular animado
           ========================== */
        .loader {
            border: 6px solid #f3f3f3;         /* Color de fondo del círculo */
            border-top: 6px solid #3498db;      /* Color de la parte que gira */
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite; /* Animación de giro infinito */
            margin: 20px auto;
            display: none;                       /* Solo se muestra en login correcto */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ==========================
           Mensaje que se muestra al usuario
           ========================== */
        .mensaje {
            font-size: 18px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <!-- ==========================
         Loader (animación)
         ========================== -->
    <div class="loader" id="loader"></div>

    <!-- ==========================
         Mensaje al usuario
         ========================== -->
    <p class="mensaje"><?php echo $mensaje; ?></p>

    <?php if ($redirect): ?>
        <script>
            // ==========================
            // Login correcto → mostrar loader y redirigir a principal.php
            // ==========================
            document.getElementById("loader").style.display = "block";
            setTimeout(() => {
                window.location.href = "principal.php";
            }, 3000); // 3 segundos
        </script>
    <?php endif; ?>

    <?php if ($backToForm): ?>
        <script>
            // ==========================
            // Login fallido → esperar 3 segundos y regresar al formulario
            // ==========================
            setTimeout(() => {
                window.location.href = "iniciar_sesion.html";
            }, 3000); // 3 segundos
        </script>
    <?php endif; ?>
</body>
</html>
