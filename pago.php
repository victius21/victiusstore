<?php
session_start();

// Calcula total del carrito
$total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Seguro - Victius Veracruz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- PayPal SDK (USANDO CLIENT-ID sb DE PRUEBA) -->
    <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=MXN"></script>

    <style>
        body{
            background:#0d1117;
            color:#fff;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        }
        .card{
            background:#161b22;
            border:1px solid #30363d;
            border-radius:16px;
        }
        .navbar{
            background:#161b22;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-5">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Victius Veracruz</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="tienda.php">Tienda</a></li>
        <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
        <li class="nav-item"><a class="nav-link active" href="pago.php">Pago</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container pb-5">
    <h2 class="text-center mb-4">💳 Pago Seguro</h2>

    <div class="card mx-auto p-4" style="max-width: 520px;">
        <h5 class="mb-3">Resumen del carrito</h5>
        <hr>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <ul class="list-group mb-3">
                <?php foreach ($_SESSION['carrito'] as $item): ?>
                    <li class="list-group-item bg-transparent text-white d-flex justify-content-between">
                        <span><?= htmlspecialchars($item['nombre']) ?> (x<?= (int)$item['cantidad'] ?>)</span>
                        <strong>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?> MXN</strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-warning">Tu carrito está vacío.</p>
        <?php endif; ?>

        <h4 class="text-end">
            Total: <span class="text-success">$<?= number_format($total, 2) ?> MXN</span>
        </h4>

        <hr>
        <p class="mb-2">Paga con PayPal (modo prueba sandbox).</p>

        <!-- AQUÍ VA EL BOTÓN -->
        <div id="paypal-button-container" class="mt-3"></div>
    </div>
</div>

<script>
const ORDER_TOTAL = <?= number_format($total, 2, '.', '') ?>;
console.log("ORDER_TOTAL:", ORDER_TOTAL, typeof ORDER_TOTAL);

if (typeof paypal === 'undefined') {
    console.error('❌ PayPal SDK NO se cargó');
} else {
    console.log('✅ PayPal SDK cargado');

    paypal.Buttons({
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: ORDER_TOTAL.toString()
                    }
                }]
            });
        },
        onApprove: (data, actions) => {
            return actions.order.capture().then(details => {
                alert('Pago de PRUEBA completado por ' + (details.payer.name.given_name || 'cliente') +
                      ' por $' + ORDER_TOTAL + ' MXN');
                // Aquí luego volvemos a meter guardar_pedido.php
            });
        },
        onError: (err) => {
            console.error('Error PayPal:', err);
            alert('Hubo un problema con PayPal.');
        }
    }).render('#paypal-button-container');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
