<?php
// guardar_pedido.php
session_start();

require 'db.php'; // aquí tienes $mongoManager

try {
    // Verificar que haya carrito
    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
        header('Location: carrito.php?guardado=0');
        exit();
    }

    $carrito = $_SESSION['carrito'];

    // Calcular total
    $total = 0;
    foreach ($carrito as $item) {
        $precio   = $item['precio']   ?? 0;
        $cantidad = $item['cantidad'] ?? 1;
        $total += $precio * $cantidad;
    }

    // Documento del pedido
    $pedido = [
        'items' => $carrito,
        'total' => $total,
        'fecha' => new MongoDB\BSON\UTCDateTime(), // requiere la librería de Mongo
    ];

    // Insertar en la colección "pedidos" de la BD "victiusstore"
    $bulk = new MongoDB\Driver\BulkWrite();
    $bulk->insert($pedido);

    $result = $mongoManager->executeBulkWrite('victiusstore.pedidos', $bulk);

    if ($result->getInsertedCount() > 0) {
        // Opcional: vaciar carrito después de guardar
        unset($_SESSION['carrito']);

        // Redirigimos con mensaje de éxito
        header('Location: carrito.php?guardado=1');
        exit();
    } else {
        // Algo falló al insertar
        header('Location: carrito.php?guardado=0');
        exit();
    }

} catch (Throwable $e) {
    // En caso de error, redirigimos con fallo
    // (no mostramos el error real al usuario final)
    header('Location: carrito.php?guardado=0');
    exit();
}
