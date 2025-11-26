<?php
// listar_pedidos.php
require_once __DIR__ . '/db.php';

$query = new MongoDB\Driver\Query([], [
    'sort' => ['fecha' => -1],
    'limit' => 50
]);

$cursor = $mongoManager->executeQuery('victiusdb.pedidos', $query);
$pedidos = iterator_to_array($cursor);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos guardados - Victius Veracruz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#0d1117; color:#fff; }
        .card{ background:#161b22; border:1px solid #30363d; border-radius:16px; }
    </style>
</head>
<body class="p-4">
<div class="container">
    <h1 class="h3 mb-3">📋 Pedidos / Carritos guardados en MongoDB</h1>
    <p class="text-muted">Últimos 50 registros de la colección <code>victiusdb.pedidos</code>.</p>

    <?php if (empty($pedidos)): ?>
        <div class="alert alert-warning">Aún no hay pedidos guardados.</div>
    <?php else: ?>
        <?php foreach ($pedidos as $p): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-1">
                        <div>
                            <strong>Estado:</strong> <?= htmlspecialchars($p->estado ?? '–') ?>
                        </div>
                        <div class="text-success fw-bold">
                            Total: $<?= number_format($p->total ?? 0, 2) ?> MXN
                        </div>
                    </div>
                    <div class="small text-muted mb-2">
                        Fecha:
                        <?php
                        if (isset($p->fecha)) {
                            $ts = $p->fecha->toDateTime();
                            echo $ts->format('Y-m-d H:i:s');
                        } else {
                            echo '—';
                        }
                        ?>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php if (!empty($p->items)): ?>
                            <?php foreach ($p->items as $it): ?>
                                <li class="list-group-item bg-transparent text-white d-flex justify-content-between">
                                    <span><?= htmlspecialchars($it->nombre) ?> (x<?= (int)$it->cantidad ?>)</span>
                                    <span>$<?= number_format($it->subtotal, 2) ?> MXN</span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
