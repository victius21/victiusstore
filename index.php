<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Victius · Veracruz Tech Demo</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;800&display=swap" rel="stylesheet">

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

  <!-- Estilos propios -->
  <link rel="stylesheet" href="assets/css/styles.css?v=1">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm main-navbar">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">Victius Veracruz</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="tienda.php">Tienda</a></li>
          <li class="nav-item"><a class="nav-link" href="carrito.php">Carrito</a></li>
          <li class="nav-item"><a class="nav-link" href="pago.php">Pago</a></li>
        </ul>
        <div id="authArea" class="d-flex align-items-center gap-2">
          <!-- Google Identity Services -->
          <div id="g_id_onload"
               data-client_id="607080967321-uiugoie2e2iianor09p61uj86goi7s4u.apps.googleusercontent.com"
               data-context="signin"
               data-ux_mode="popup"
               data-callback="handleCredentialResponse"
               data-auto_prompt="false"
               data-itp_support="true"></div>

          <div id="gsiBtn" class="g_id_signin"
               data-type="standard"
               data-shape="pill"
               data-theme="outline"
               data-size="large"></div>

          <div id="userMini" class="d-none align-items-center gap-2">
            <img id="userAvatar" src="" alt="avatar" class="rounded-circle" width="36" height="36">
            <span id="userName" class="text-white small"></span>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main class="py-5 mt-4">
    <div class="container">
      <!-- Hero -->
      <section class="text-center py-4">
        <h1 class="display-6 fw-bold">Victius · Demo Tecnológica para Veracruz</h1>
        <p class="lead mb-0">
          Autenticación con Google · Mapa Interactivo · BTC en vivo · Video cultural
        </p>
      </section>

      <div class="row g-4">
        <!-- Login explicativo -->
        <section class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <h2 class="h5 mb-2">1) Autenticación con Google</h2>
              <p class="mb-0">
                Usa el botón de Google en la parte superior derecha para iniciar sesión.
                Después de iniciar, verás tu nombre y foto en la barra de navegación.
              </p>
            </div>
          </div>
        </section>

        <!-- Mapa -->
        <section class="col-12 col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="h5 mb-0">2) Mapa Interactivo (Leaflet)</h2>
                <button id="btn-mypos" class="btn btn-warning btn-sm">📍 Mi ubicación</button>
              </div>
              <div id="map" class="rounded-3"></div>
              <div class="form-text">Centrado en Veracruz, MX (OpenStreetMap + Leaflet).</div>
            </div>
          </div>
        </section>

        <!-- BTC en vivo -->
        <section class="col-12 col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <h2 class="h5">3) Precio BTC/USDT en Vivo</h2>
              <div class="p-3 rounded-3 live-box">
                <div class="small text-uppercase text-muted">Último precio</div>
                <div id="ws-price" class="display-6 fw-bold mb-0">—</div>
              </div>
              <div class="form-text">
                WebSocket a: <code>wss://stream.binance.com:9443/ws/btcusdt@trade</code>
              </div>
            </div>
          </div>
        </section>

        <!-- Video Veracruz -->
        <section class="col-12 col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <h2 class="h5">4) Veracruz: Cultura y Tradición</h2>
              <div class="ratio ratio-16x9 rounded-3 overflow-hidden border">
                <iframe src="https://www.youtube.com/embed/8Ch-s-XCm-s"
                        title="Veracruz Cultura y Tradición"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </section>

        <!-- Accesos a tienda/pago -->
        <section class="col-12 col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex flex-column">
              <h2 class="h5">5) Flujo de E-commerce</h2>
              <p>Explora la tienda de antojitos, arma tu carrito y paga en modo demo con PayPal sandbox.</p>
              <div class="mt-auto d-flex flex-wrap gap-2">
                <a href="tienda.php" class="btn btn-primary">Ir a la tienda</a>
                <a href="carrito.php" class="btn btn-outline-light">Ver carrito</a>
                <a href="pago.php" class="btn btn-success">Ir a pagar</a>
              </div>
            </div>
          </div>
        </section>

      </div>
    </div>
  </main>

  <footer class="py-4 bg-dark text-white-50 mt-5">
    <div class="container text-center small">
      © <?php echo date('Y'); ?> Victius · Demo integrada con APIs
    </div>
  </footer>

  <!-- Librerías JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS propio -->
  <script src="assets/js/main.js?v=1"></script>
</body>
</html>
