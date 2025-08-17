<?php
// ==========================
// INICIO DE REGISTRO.PHP
// ==========================

include 'conex.php'; // Conexión a la base de datos

$mensaje = "";       // Variable para mostrar mensajes al usuario
$redirect = false;   // Para saber si se debe redirigir al login
$backToForm = false; // Para saber si se debe regresar al formulario de registro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ==========================
    // Verificar que todos los campos obligatorios estén presentes y no vacíos
    // ==========================
    if (
        isset($_POST['nombre'], $_POST['correo'], $_POST['contraseña'], $_POST['edad'], $_POST['sexo']) &&
        !empty($_POST['nombre']) &&
        !empty($_POST['correo']) &&
        !empty($_POST['contraseña']) &&
        !empty($_POST['edad']) &&
        !empty($_POST['sexo'])
    ) {
        // ==========================
        // Sanitización de los datos recibidos
        // ==========================
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $correo = $conexion->real_escape_string($_POST['correo']);
        $password = $_POST['contraseña'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encriptamos la contraseña
        $edad = (int) $_POST['edad'];
        $sexo = $conexion->real_escape_string($_POST['sexo']);

        // ==========================
        // Verificar si el correo ya existe
        // ==========================
        $verifica = "SELECT id FROM usuarios WHERE correo = '$correo'";
        $resultado = $conexion->query($verifica);

        if ($resultado && $resultado->num_rows > 0) {
            $mensaje = "❌ Este correo ya está registrado. Redirigiendo al formulario...";
            $backToForm = true;
        } else {
            // ==========================
            // Insertar usuario nuevo
            // ==========================
            $sql = "INSERT INTO usuarios (nombre, correo, contraseña, edad, sexo)
                    VALUES ('$nombre', '$correo', '$hashed_password', $edad, '$sexo')";
            if ($conexion->query($sql) === TRUE) {
                $mensaje = "✅ Cuenta creada correctamente. Redirigiendo a iniciar sesión...";
                $redirect = true;
            } else {
                $mensaje = "❌ Error al crear cuenta: " . $conexion->error;
                $backToForm = true;
            }
        }
    } else {
        $mensaje = "❌ Todos los campos son obligatorios. Redirigiendo al formulario...";
        $backToForm = true;
    }
} else {
    $mensaje = "❌ Acceso no permitido. Redirigiendo al formulario...";
    $backToForm = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
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
           Animación loader circular
           ========================== */
        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none; /* solo se muestra cuando registro es exitoso */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ==========================
           Mensaje al usuario
           ========================== */
        .mensaje {
            font-size: 18px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <!-- ==========================
         Loader
         ========================== -->
    <div class="loader" id="loader"></div>
    <!-- ==========================
         Mensaje de estado
         ========================== -->
    <p class="mensaje"><?php echo $mensaje; ?></p>

    <?php if ($redirect): ?>
        <script>
            // ==========================
            // Registro exitoso → mostrar loader y redirigir al login
            // ==========================
            document.getElementById("loader").style.display = "block";
            setTimeout(() => {
                window.location.href = "iniciar_sesion.html";
            }, 3000);
        </script>
    <?php endif; ?>

    <?php if ($backToForm): ?>
        <script>
            // ==========================
            // Registro fallido → esperar 3s y regresar al formulario
            // ==========================
            setTimeout(() => {
                window.location.href = "crearcuenta.html";
            }, 3000);
        </script>
    <?php endif; ?>
</body>
</html>
