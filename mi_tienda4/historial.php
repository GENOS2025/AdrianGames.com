<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function cargarHistorial($usuario) {
    $filename = "historial/{$usuario}.json";
    if (file_exists($filename)) {
        return json_decode(file_get_contents($filename), true);
    }
    return [];
}

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$historial = cargarHistorial($usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Historial de Compras</h1>
        <?php if (empty($historial)): ?>
            <p>No hay compras en el historial.</p>
        <?php else: ?>
            <table class="historial-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Productos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $compra): ?>
                        <tr>
                            <td><?php echo $compra['fecha']; ?></td>
                            <td>$<?php echo number_format($compra['total'], 2); ?></td>
                            <td>
                                <?php foreach ($compra['productos'] as $producto): ?>
                                    <div class="producto-item">
                                        <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="producto-img">
                                        <div class="producto-info">
                                            <h4><?php echo $producto['nombre']; ?></h4>
                                            <p>Cantidad: <?php echo $producto['cantidad']; ?></p>
                                            <p>Total: $<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <p><a href="index.php" class="btn">Volver a la tienda</a></p>
    </div>
</body>
</html>
