<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Compra</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>¡Compra realizada con éxito!</h1>
        <?php
        if (isset($_GET['total'])) {
            $total = floatval($_GET['total']);
            echo "<p>Total a pagar: $" . number_format($total, 2) . "</p>";
        } else {
            echo "<p>Error al obtener el total.</p>";
        }
        ?>
        <p>¡Gracias por tu compra!</p>
        <p><a href="index.php" class="btn">Seguir comprando</a></p>
    </div>
</body>
</html>



