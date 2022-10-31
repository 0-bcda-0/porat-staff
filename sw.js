self.addEventListener('install', e => {
  e.waitUntil(
    caches.open('pwabuilder-offline').then(cache => {
        // stavitve datoteke za cache (ne foldere, nego datoteke)
    //   return cache.addAll(['./', './index.html', './index.js', './index.css', './images/logo.png']);
      return cache.addAll(['./']);
    })
  );
});

self.addEventListener('fetch', e => {
    e.respondWith(
        caches.match(e.request).then(response => {
        return response || fetch(e.request);
        })
    );
});
