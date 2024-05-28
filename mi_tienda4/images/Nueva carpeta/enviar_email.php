<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = isset($_POST['total']) ? floatval($_POST['total']) : 0;
    $mensaje = "Gracias por tu compra. El total gastado es de $" . number_format($total, 2);
    $correo_destino = "joseadrianmelendezsanchez@gmail.com";
    $asunto = "Compra realizada en la tienda";
    $cabeceras = "From: mi_tienda@example.com";

    if (mail($correo_destino, $asunto, $mensaje, $cabeceras)) {
        echo "<p>Mensaje enviado correctamente.</p>";
    } else {
        echo "<p>Error al enviar el mensaje.</p>";
    }
} else {
    echo "<p>No se recibieron datos del formulario.</p>";
}
?>
