<?php
session_start();
include 'productos.php';

// Función para guardar el carrito en un archivo JSON
function guardarCarrito($carrito, $usuario) {
    $dir = 'carritos';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true); // Crear el directorio si no existe
    }
    $filename = "{$dir}/{$usuario}.json";
    file_put_contents($filename, json_encode($carrito));
}

// Función para cargar el carrito desde un archivo JSON
function cargarCarrito($usuario) {
    $filename = "carritos/{$usuario}.json";
    if (file_exists($filename)) {
        return json_decode(file_get_contents($filename), true);
    }
    return [];
}

// Función para guardar el historial en un archivo JSON
function guardarHistorial($historial, $usuario) {
    $dir = 'historial';
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true); // Crear el directorio si no existe
    }
    $filename = "{$dir}/{$usuario}.json";
    file_put_contents($filename, json_encode($historial));
}

// Función para cargar el historial desde un archivo JSON
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

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = cargarCarrito($usuario);
}

if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = cargarHistorial($usuario);
}

$carrito = &$_SESSION['carrito'];
$historial = &$_SESSION['historial'];

// Añadir un producto al carrito
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    if (isset($productos[$id])) {
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += 1;
        } else {
            $carrito[$id] = $productos[$id];
            $carrito[$id]['cantidad'] = 1;
        }
        guardarCarrito($carrito, $usuario);
    }
}

// Eliminar un producto del carrito
if (isset($_POST['eliminar']) && is_numeric($_POST['eliminar'])) {
    $id = intval($_POST['eliminar']);
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;
    if (isset($carrito[$id])) {
        if ($carrito[$id]['cantidad'] > $cantidad) {
            $carrito[$id]['cantidad'] -= $cantidad;
        } else {
            unset($carrito[$id]);
        }
        guardarCarrito($carrito, $usuario);
    }
}

// Procesar la compra
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $total = 0;
    foreach ($carrito as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }

    $historial[] = [
        'fecha' => date('Y-m-d H:i:s'),
        'total' => $total,
        'productos' => $carrito
    ];
    guardarHistorial($historial, $usuario);

    $_SESSION['carrito'] = [];
    guardarCarrito([], $usuario);

    header('Location: confirmacion.php?total=' . $total);
    exit();
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
    <div class="container carrito">
        <h2>Carrito de Compras</h2>
        <?php if (empty($carrito)): ?>
            <p>El carrito está vacío.</p>
        <?php else: ?>
            <ul>
                <?php 
                    $total = 0;
                    foreach ($carrito as $id => $producto):
                        $total += $producto['precio'] * $producto['cantidad'];
                ?>
                    <li>
                        <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="producto-img">
                        <?php echo $producto['nombre']; ?> - $<?php echo $producto['precio']; ?> x <?php echo $producto['cantidad']; ?> = $<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>
                        <form action="carrito.php" method="post" style="display:inline;">
                            <input type="hidden" name="eliminar" value="<?php echo $id; ?>">
                            <label for="cantidad">Cantidad a eliminar:</label>
                            <input type="number" name="cantidad" value="1" min="1" max="<?php echo $producto['cantidad']; ?>">
                            <button type="submit" class="eliminar-btn">Eliminar</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>Total: $<?php echo number_format($total, 2); ?></p>
            <form action="carrito.php" method="post">
                <input type="hidden" name="comprar" value="1">
                <button type="submit" class="btn">Comprar</button>
            </form>
        <?php endif; ?>
        <p><a href="index.php" class="btn">Seguir comprando</a></p>
    </div>
</body>
</html>

