<?php
session_start();

$productos = [
    1 => ['nombre' => 'Elote preparado',       'precio' => 35.00, 'img' => 'elote.jpg'],
    2 => ['nombre' => 'Esquites',              'precio' => 30.00, 'img' => 'esquites.jpg'],
    3 => ['nombre' => 'Churros con chocolate', 'precio' => 40.00, 'img' => 'churros.jpg'],
    4 => ['nombre' => 'Tostilocos',            'precio' => 45.00, 'img' => 'tostilocos.jpg'],
];

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = &$_SESSION['carrito'];
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if (isset($productos[$id])) {
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            $carrito[$id] = [
                'nombre'   => $productos[$id]['nombre'],
                'precio'   => $productos[$id]['precio'],
                'cantidad' => 1,
            ];
        }
        $mensaje = "Se agregó «{$productos[$id]['nombre']}» al carrito.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Tienda Victius</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<?php include("navbar.php"); ?> <!-- Si usas navbar compartida -->

<main class="py-4">
<div class="container">
    <h1 class="h3">Tienda de Antojitos</h1>
    <p class="text-muted">Agrega tus antojitos favoritos al carrito.</p>

    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <div class="row g-4">

        <?php foreach ($productos as $id => $p): ?>
        
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 shadow-sm">
                
                <img src="assets/img/<?php echo $p['img']; ?>"
                     class="card-img-top"
                     style="height:170px; object-fit:cover;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $p['nombre']; ?></h5>
                    <p class="small text-muted">Delicioso antojito veracruzano.</p>
                    <p class="fw-bold">$<?php echo number_format($p['precio'], 2); ?> MXN</p>

                    <form method="post" class="mt-auto">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button class="btn btn-primary w-100">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>

</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
