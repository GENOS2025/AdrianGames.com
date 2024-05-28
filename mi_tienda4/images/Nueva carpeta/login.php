<?php
session_start();
$usuarios = ['usuario' => 'contrasena'];

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
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" required>
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" required>
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
