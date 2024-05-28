<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_usuario = $_POST['nuevo_usuario'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    
    // Cargar los usuarios desde el archivo JSON
    $usuarios = json_decode(file_get_contents('usuarios.json'), true);
    
    if (!isset($usuarios[$nuevo_usuario])) {
        $usuarios[$nuevo_usuario] = $nueva_contrasena;
        file_put_contents('usuarios.json', json_encode($usuarios));
        $mensaje = "Usuario creado exitosamente.";
    } else {
        $error = "El usuario ya existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("nueva_contrasena");
            var toggleButton = document.getElementById("togglePassword");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Ocultar Contraseña";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Mostrar Contraseña";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Usuario</h1>
        <?php if (isset($mensaje)): ?>
            <p class="message"><?php echo $mensaje; ?></p>
            <p><a href="index.php">Ir al inicio de sesión</a></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <div class="register-form-container">
            <form method="post" class="register-form">
                <label for="nuevo_usuario">Nuevo Usuario:</label>
                <input type="text" name="nuevo_usuario" id="nuevo_usuario" required>
                <label for="nueva_contrasena">Nueva Contraseña:</label>
                <input type="password" name="nueva_contrasena" id="nueva_contrasena" required>
                <button type="button" id="togglePassword" onclick="togglePassword()">Mostrar Contraseña</button>
                <button type="submit" class="btn">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>
