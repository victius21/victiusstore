<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'msg' => 'Carrito vacío']);
    exit;
}

// Intentamos conectar a Mongo
try {
    require __DIR__ . '/db.php';
} catch (Throwable $e) {
    // Aquí caemos si no está instalada la extensión o la URI está mal
    echo json_encode(['ok' => false, 'msg' => 'Error Mongo: ' . $e->getMessage()]);
    exit;
}

$carrito = $_SESSION['carrito'];

$total = 0;
$items = [];

foreach ($carrito as $item) {
    $subtotal = $item['precio'] * $item['cantidad'];
    $total += $subtotal;

    $items[] = [
        'nombre'   => $item['nombre'],
        'precio'   => $item['precio'],
        'cantidad' => $item['cantidad'],
        'subtotal' => $subtotal,
    ];
}

$pedido = [
    'fecha'  => new MongoDB\BSON\UTCDateTime((new DateTime())->getTimestamp() * 1000),
    'items'  => $items,
    'total'  => $total,
    'estado' => 'pendiente',
    'origen' => 'victiusstore'
];

$bulk = new MongoDB\Driver\BulkWrite();
$bulk->insert($pedido);

try {
    // OJO: cambia "victiusdb" si tu BD tiene otro nombre
    $result = $mongoManager->executeBulkWrite('victiusdb.pedidos', $bulk);
    echo json_encode([
        'ok'       => true,
        'inserted' => $result->getInsertedCount()
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'msg' => 'Error al insertar: ' . $e->getMessage()]);
}
