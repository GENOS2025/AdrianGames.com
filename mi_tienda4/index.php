<?php
session_start();
include 'productos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Game store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Game Store</h1>
        <p><a href="carrito.php" class="btn">Ir al carrito</a></p>
        <?php if (isset($_SESSION['usuario'])): ?>
            <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></p>
            <p><a href="historial.php" class="btn">Historial de Compras</a></p>
        <?php else: ?>
            <p><a href="login.php">Iniciar sesión</a></p>
        <?php endif; ?>
    </header>
    <main>
        <div class="productos">
            <?php foreach ($productos as $id => $producto): ?>
                <div class="producto">
                    <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" style="width: 200px; height: 270px; object-fit: cover;">
                    <h2><?php echo $producto['nombre']; ?></h2>
                    <p>$<?php echo $producto['precio']; ?></p>
                    <a href="carrito.php?id=<?php echo $id; ?>" class="btn">Añadir al carrito</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
