<?php
session_start();
include 'productos.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    foreach ($productos as $producto) {
        if ($producto['id'] == $id) {
            $_SESSION['carrito'][] = $producto;
            $producto_agregado = $producto;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Producto Añadido</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Producto Añadido</h1>
        <?php if (isset($producto_agregado)): ?>
            <p>El producto <strong><?php echo $producto_agregado['nombre']; ?></strong> se ha añadido correctamente al carrito.</p>
            <img src="<?php echo $producto_agregado['imagen']; ?>" alt="<?php echo $producto_agregado['nombre']; ?>" class="producto-img">
        <?php else: ?>
            <p>Producto no encontrado.</p>
        <?php endif; ?>
        <p><a href="index.php" class="btn">Seguir comprando</a> | <a href="carrito.php" class="btn">Ir al carrito</a></p>
    </div>
</body>
</html>
