window.addEventListener('orientationchange', function() {
    // Provjera orijentacije uredjaja
    if (Math.abs(window.orientation) === 0) {
      // Preusmjeravanje korisnika na drugu stranicu
      window.location.href = '../reservations/reservations.php';
    }
});
