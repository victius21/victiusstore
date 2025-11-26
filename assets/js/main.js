// ================== GOOGLE LOGIN ==================
function parseJwt(token){
  try{
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g,'+').replace(/_/g,'/');
    const jsonPayload = decodeURIComponent(
      atob(base64).split('').map(c =>
        '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)
      ).join('')
    );
    return JSON.parse(jsonPayload);
  }catch(e){
    console.error('Error parseJwt:', e);
    return {};
  }
}

function handleCredentialResponse(response){
  try{
    const data = parseJwt(response.credential || '');
    const gsiBtn   = document.getElementById('gsiBtn');
    const userMini = document.getElementById('userMini');
    const userName = document.getElementById('userName');
    const userAvatar = document.getElementById('userAvatar');

    if (userName)  userName.textContent = data.name || 'Usuario';
    if (userAvatar && data.picture) userAvatar.src = data.picture;

    if (gsiBtn)   gsiBtn.classList.add('d-none');
    if (userMini) userMini.classList.remove('d-none');
  }catch(e){
    console.error('Error en handleCredentialResponse:', e);
    alert('No se pudo iniciar sesión con Google.');
  }
}

// ================== MAPA LEAFLET ==================
let mapInstance = null;
let userMarker  = null;

function initMap(){
  const mapDiv = document.getElementById('map');
  if (!mapDiv || typeof L === 'undefined') return;

  if (mapInstance) return;

  const veracruz = [19.1809, -96.1429];
  mapInstance = L.map('map').setView(veracruz, 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(mapInstance);

  L.marker(veracruz).addTo(mapInstance).bindPopup('Centro · Veracruz');
}

function initGeoButton(){
  const btn = document.getElementById('btn-mypos');
  if (!btn) return;

  btn.addEventListener('click', () => {
    if (!navigator.geolocation){
      alert('Tu navegador no soporta geolocalización.');
      return;
    }
    navigator.geolocation.getCurrentPosition(
      pos => {
        const { latitude, longitude } = pos.coords;
        if (!mapInstance) initMap();
        if (!mapInstance) return;

        if (userMarker){
          mapInstance.removeLayer(userMarker);
        }
        userMarker = L.marker([latitude, longitude])
          .addTo(mapInstance)
          .bindPopup('Tu ubicación')
          .openPopup();

        mapInstance.setView([latitude, longitude], 14);
      },
      err => {
        console.error('Error geolocalización:', err);
        alert('No se pudo obtener tu ubicación.');
      }
    );
  });
}

// ================== BTC EN VIVO (WebSocket) ==================
let ws = null;

function startWS(){
  const priceSpan = document.getElementById('ws-price');
  if (!priceSpan) return;

  try{
    ws = new WebSocket('wss://stream.binance.com:9443/ws/btcusdt@trade');

    ws.onopen = () => console.log('WebSocket Binance conectado');

    ws.onmessage = (e) => {
      try{
        const d = JSON.parse(e.data);
        const price = parseFloat(d.p);
        if (!isNaN(price)) {
          priceSpan.textContent = '$' + price.toFixed(2) + ' USD';
        }
      }catch(err){
        console.error('Error parseando mensaje WS:', err);
      }
    };

    ws.onerror = (e) => {
      console.error('WS error:', e);
      priceSpan.textContent = 'Error WS';
    };

    ws.onclose = () => {
      console.warn('WS cerrado');
    };
  }catch(e){
    console.error('Error en startWS:', e);
    priceSpan.textContent = 'Error';
  }
}

// ================== INIT GENERAL ==================
window.addEventListener('DOMContentLoaded', () => {
  console.log('DOM listo · Inicializando mapa y WebSocket...');
  initMap();
  initGeoButton();
  startWS();
});
