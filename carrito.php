<?php
// carrito.php
session_start();

// Obtenemos el carrito desde la sesión (si no existe, arreglo vacío)
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

// Calculamos total
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
    <!-- Bootstrap (opcional pero recomendado) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS propio (ajusta la ruta si lo tienes en otro lado) -->
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body class="bg-dark text-light">

<?php
// Si tienes un navbar común en navbar.php lo incluimos
if (file_exists('navbar.php')) {
    include 'navbar.php';
}
?>

<div class="container py-5">
    <h1 class="mb-4 text-center">🛒 Carrito de compras</h1>

    <?php if (empty($carrito)): ?>
        <div class="alert alert-warning text-center">
            Tu carrito está vacío.
        </div>

        <div class="text-center mt-3">
            <a href="tienda.php" class="btn btn-primary">
                ⬅️ Volver a la tienda
            </a>
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
            <a href="tienda.php" class="btn btn-secondary">
                ⬅️ Seguir comprando
            </a>

            <!-- Vaciar carrito (NUEVO BOTÓN) -->
            <a href="vaciar_carrito.php" class="btn btn-danger">
                🗑️ Vaciar carrito
            </a>

            <!-- Ir a pagar -->
            <a href="pago.php" class="btn btn-success ms-auto">
                💳 Proceder al pago
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- JS de Bootstrap (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
