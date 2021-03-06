const assets = [
  "/",
  "/style.css",
  "/omnio.png",
  "/favicon.ico",
  "/dark-mode.css",
  "/dark-mode-switch.min.js",
];

self.addEventListener("install", (installEvent) => {
  installEvent.waitUntil(
    caches.open("omnio").then((cache) => {
      cache.addAll(assets);
    })
  );
});

self.addEventListener("fetch", (fetchEvent) => {
  fetchEvent.respondWith(
    caches.match(fetchEvent.request).then((res) => {
      return res || fetch(fetchEvent.request);
    })
  );
});
