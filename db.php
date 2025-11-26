<?php
// db.php
// Conexión a MongoDB usando el driver nativo

// Primero intenta leer la URI desde la variable de entorno (Render)
$mongoUri = getenv('MONGO_URI');

if (!$mongoUri) {
    // URI de respaldo para pruebas locales (NO usar en producción pública)
    $mongoUri = 'mongodb+srv://victius:victius@cluster0.wjunrvg.mongodb.net/victiusdb?retryWrites=true&w=majority&appName=Cluster0';
}

try {
    $mongoManager = new MongoDB\Driver\Manager($mongoUri);
} catch (Throwable $e) {
    // En producción lo ideal es loguear, no mostrar el error en pantalla
    die("Error conectando a MongoDB: " . $e->getMessage());
}
