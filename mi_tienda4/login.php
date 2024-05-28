<?php
session_start();
$usuarios = json_decode(file_get_contents('usuarios.json'), true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if (isset($usuarios[$usuario]) && $usuarios[$usuario] == $contrasena) {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit();
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("contrasena");
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
        <h1>Iniciar Sesión</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <div class="login-form-container">
            <form method="post" class="login-form">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" required>
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" required>
                <button type="button" id="togglePassword" onclick="togglePassword()">Mostrar Contraseña</button>
                <button type="submit" class="btn">Iniciar Sesión</button>
            </form>
            <p><a href="recuperar.php">¿Olvidaste tu contraseña?</a></p>
            <p><a href="registrar.php">Crear nuevo usuario</a></p>
        </div>
    </div>
</body>
</html>
