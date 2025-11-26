<?php
// carrito.php
session_start();

// Mensaje de guardado (viene de guardar_pedido.php)
$estadoGuardado = isset($_GET['guardado']) ? $_GET['guardado'] : null;

// Obtenemos el carrito desde la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

// Calculamos el total
$total = 0;
foreach ($carrito as $item) {
    $subtotal = ($item['precio'] ?? 0) * ($item['cantidad'] ?? 1);
    $total += $subtotal;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de compras - VictiusStore</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS -->
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="bg-dark text-light">

<?php
if (file_exists('navbar.php')) {
    include 'navbar.php';
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center">🛒 Carrito de compras</h1>

    <!-- ALERT BONITO DE GUARDADO -->
    <?php if ($estadoGuardado === '1'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Tu pedido se guardó correctamente en la base de datos.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($estadoGuardado === '0'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ❌ Ocurrió un error al guardar tu pedido. Intenta de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($carrito)): ?>
        <div class="alert alert-warning text-center">Tu carrito está vacío.</div>

        <div class="text-center mt-3">
            <a href="tienda.php" class="btn btn-primary">⬅️ Volver a la tienda</a>
        </div>
    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $item): ?>
                        <?php
                        $nombre   = $item['nombre']   ?? 'Producto';
                        $precio   = $item['precio']   ?? 0;
                        $cantidad = $item['cantidad'] ?? 1;
                        $subtotal = $precio * $cantidad;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($nombre) ?></td>
                            <td class="text-center"><?= (int)$cantidad ?></td>
                            <td class="text-end">$<?= number_format($precio, 2) ?></td>
                            <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th class="text-end">$<?= number_format($total, 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-between mt-4">

            <!-- Seguir comprando -->
            <a href="tienda.php" class="btn btn-secondary">⬅️ Seguir comprando</a>

            <!-- Vaciar carrito -->
            <a href="vaciar_carrito.php" class="btn btn-danger">🗑️ Vaciar carrito</a>

            <!-- Guardar pedido en Mongo -->
            <form action="guardar_pedido.php" method="POST">
                <button type="submit" class="btn btn-warning">
                    💾 Guardar pedido
                </button>
            </form>

            <!-- Proceder al pago -->
            <a href="pago.php" class="btn btn-success ms-auto">💳 Proceder al pago</a>

        </div>

    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
