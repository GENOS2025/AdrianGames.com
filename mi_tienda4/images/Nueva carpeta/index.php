<?php
session_start();
include 'productos.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda de Videojuegos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Tienda de Videojuegos</h1>
        <?php if (isset($_SESSION['usuario'])): ?>
            <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></p>
        <?php else: ?>
            <p><a href="login.php">Iniciar sesión</a></p>
        <?php endif; ?>
    </header>
    <main>
        <div class="productos">
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
                    <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                    <h2><?php echo $producto['nombre']; ?></h2>
                    <p>$<?php echo $producto['precio']; ?></p>
                    <a href="agregar.php?id=<?php echo $producto['id']; ?>" class="btn">Añadir al carrito</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
