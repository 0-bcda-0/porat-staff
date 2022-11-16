/*
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
*/
/*
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
*/

// dont cache anything
/*
self.addEventListener('fetch', function(event) {
  event.respondWith(fetch(event.request));
});
*/

// ------------------------------------------------------------
// the cache version gets updated every time there is a new deployment
const CACHE_VERSION = 10;
const CURRENT_CACHE = `main-${CACHE_VERSION}`;

// these are the routes we are going to cache for offline support
const cacheFiles = [
  'icons/addReservation.json',
  'icons/calendar.json',
  'icons/photoGallery.json',
  'icons/settings.json',
  'icons/switchUser.json',
  'css/background.css',
  'css/bootstrap.min.css',
  'img/Bcg.jpg',
  'img/FullLogo.png',
  'img/Logo.png',
  'img/Logo-192.png',
  'img/Logo-512.png',
  'https://fonts.googleapis.com/css?family=Montserrat',
];

// on activation we clean up the previously registered service workers
self.addEventListener('activate', evt =>
  evt.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CURRENT_CACHE) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  )
);

// on install we download the routes we want to cache for offline
self.addEventListener('install', evt =>
  evt.waitUntil(
    caches.open(CURRENT_CACHE).then(cache => {
      return cache.addAll(cacheFiles);
    })
  )
);

// fetch the resource from the network
const fromNetwork = (request, timeout) =>
  new Promise((fulfill, reject) => {
    const timeoutId = setTimeout(reject, timeout);
    fetch(request).then(response => {
      clearTimeout(timeoutId);
      fulfill(response);
      update(request);
    }, reject);
  });

// fetch the resource from the browser cache
const fromCache = request =>
  caches
    .open(CURRENT_CACHE)
    .then(cache =>
      cache
        .match(request)
        .then(matching => matching || cache.match('/offline/'))
    );

// cache the current page to make it available for offline
const update = request =>
  caches
    .open(CURRENT_CACHE)
    .then(cache =>
      fetch(request).then(response => cache.put(request, response))
    );

// general strategy when making a request (eg if online try to fetch it
// from the network with a timeout, if something fails serve from cache)
self.addEventListener('fetch', evt => {
  evt.respondWith(
    fromNetwork(evt.request, 10000).catch(() => fromCache(evt.request))
  );
  evt.waitUntil(update(evt.request));
});