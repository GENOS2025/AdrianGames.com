<?php
// Esta es una versión simplificada para mostrar la contraseña en la página
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    
    // Cargar los usuarios desde el archivo JSON
    $usuarios = json_decode(file_get_contents('usuarios.json'), true);
    
    if (isset($usuarios[$usuario])) {
        // Obtener la contraseña del usuario
        $contrasena = $usuarios[$usuario];
        $mensaje = "La contraseña para el usuario $usuario es: $contrasena";
    } else {
        $mensaje = "El usuario no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Contraseña</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Mostrar Contraseña</h1>
        <?php if (isset($mensaje)): ?>
            <p class="message"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <div class="recover-form-container">
            <form method="post" class="recover-form">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" required>
                <button type="submit" class="btn">Mostrar Contraseña</button>
            </form>
            <p><a href="index.php">Volver al inicio</a></p>
        </div>
    </div>
</body>
</html>
