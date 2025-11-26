<?php
// db.php – Conexión a MongoDB

// Primero intentamos leer la URI desde las variables de entorno (Render)
$mongoUri = getenv('MONGO_URI');

if (!$mongoUri || $mongoUri === "") {
    // URI de respaldo (solo para pruebas)
    $mongoUri = "mongodb+srv://victius:victius@cluster0.wjunrvg.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";
}

try {
    $mongoManager = new MongoDB\Driver\Manager($mongoUri);
} catch (Throwable $e) {
    die("Error conectando a MongoDB: " . $e->getMessage());
}
?>
