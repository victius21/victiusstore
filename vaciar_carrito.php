<?php
// vaciar_carrito.php
session_start();

// Si existe el carrito en la sesión, lo eliminamos
if (isset($_SESSION['carrito'])) {
    unset($_SESSION['carrito']);
}

// Redirigimos de regreso a la página del carrito
header("Location: carrito.php");
exit();
