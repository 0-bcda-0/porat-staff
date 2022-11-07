var cacheName = 'porat-stuff';
var filesToCache2 = [
  '/',
  '/index.php',
  '/__icons/addReservation.json',
  '/__icons/calendar.json',
  '/__icons/photoGallery.json',
  '/__icons/settings.json',
  '/__icons/switchUser.json',
  '/__header-footer/header.php',
  '/__header-footer/footer.php',
  '/__css/background.css',
  '/__css/bootstrap.min.css',
  '/__img/Bcg.jpg',
  '/__img/FullLogo.png',
  '/__img/Ico.ico',
  '/__img/Logo.png',
  '/__img/Logo-192.png',
  '/__img/Logo-512.png',
  'https://fonts.googleapis.com/css?family=Montserrat',
];
var filesToCache = [
  '/',
  '__icons/addReservation.json',
  '__icons/calendar.json',
  '__icons/photoGallery.json',
  '__icons/settings.json',
  '__icons/switchUser.json',
  '__header-footer/header.php',
  '__header-footer/footer.php',
  '__css/background.css',
  '__css/bootstrap.min.css',
  '__img/Bcg.jpg',
  '__img/FullLogo.png',
  '__img/Logo.png',
  '__img/Logo-192.png',
  '__img/Logo-512.png',
  'https://fonts.googleapis.com/css?family=Montserrat',

];

self.addEventListener('install', e => {
  console.log('[ServiceWorker] Install');
  e.waitUntil(
    caches.open(cacheName).then(cache => {
      console.log('[ServiceWorker] Caching app shell');
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('fetch', e => {
    e.respondWith(
        caches.match(e.request)
        .then(function(response) {
          if(response) {
            // ovu liniju zakomentirati ako se ne zeli koristiti cache
            return response;
          }
          return fetch(e.request);
        })
    );
});