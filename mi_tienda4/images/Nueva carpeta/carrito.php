<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

// Eliminar un producto del carrito
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $indice = intval($_GET['eliminar']);
    if (isset($carrito[$indice])) {
        unset($carrito[$indice]);
        $_SESSION['carrito'] = array_values($carrito); // Reindexar el array
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Carrito de Compras</h1>
        <?php if (empty($carrito)): ?>
            <p>El carrito está vacío.</p>
        <?php else: ?>
            <ul>
                <?php 
                    $total = 0;
                    foreach ($carrito as $indice => $producto):
                        $total += $producto['precio'];
                ?>
                    <li>
                        <?php echo $producto['nombre']; ?> - $<?php echo $producto['precio']; ?>
                        <a href="carrito.php?eliminar=<?php echo $indice; ?>" class="eliminar-btn">Eliminar</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>Total: $<?php echo number_format($total, 2); ?></p>
            <form action="enviar_email.php" method="post">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button type="submit" class="btn">Comprar</button>
            </form>
        <?php endif; ?>
        <p><a href="index.php" class="btn">Seguir comprando</a></p>
    </div>
</body>
</html>
