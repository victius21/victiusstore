<?php
session_start();

// Calcular total
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
    <title>Carrito - Victius Veracruz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#0d1117; color:#fff; }
        .card{ background:#161b22; border:1px solid #30363d; border-radius:16px; }
        .navbar{ background:#161b22; }
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
        <li class="nav-item"><a class="nav-link active" href="carrito.php">Carrito</a></li>
        <li class="nav-item"><a class="nav-link" href="pago.php">Pago</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container pb-5">
    <h2 class="mb-4">🛒 Carrito</h2>

    <div class="card p-4">
        <?php if (!empty($_SESSION['carrito'])): ?>
            <div class="table-responsive mb-3">
                <table class="table table-dark table-striped align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($_SESSION['carrito'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td class="text-center"><?= (int)$item['cantidad'] ?></td>
                            <td class="text-end">$<?= number_format($item['precio'], 2) ?> MXN</td>
                            <td class="text-end">$<?= number_format($item['precio'] * $item['cantidad'], 2) ?> MXN</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th class="text-end text-success">$<?= number_format($total, 2) ?> MXN</th>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="tienda.php" class="btn btn-outline-light btn-sm">Seguir comprando</a>
                <a href="pago.php" class="btn btn-primary btn-sm">Ir a pagar</a>

                <!-- 🔹 NUEVO BOTÓN: Guardar carrito en Mongo -->
                <button id="btn-guardar-mongo" class="btn btn-success btn-sm">
                    Guardar carrito en Mongo (sin pagar)
                </button>
            </div>
        <?php else: ?>
            <p class="text-warning mb-0">Tu carrito está vacío.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const btn = document.getElementById('btn-guardar-mongo');
if (btn) {
    btn.addEventListener('click', () => {
        fetch('guardar_pedido.php', {
            method: 'POST',
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(json => {
            console.log('Respuesta Mongo:', json);
            if (json.ok) {
                alert('Carrito guardado en MongoDB ✔');
            } else {
                alert('Error guardando en Mongo: ' + (json.msg || 'desconocido'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('No se pudo conectar al backend.');
        });
    });
}
</script>

</body>
</html>
