window.addEventListener('orientationchange', function() {
    // Check the device orientation
    if (Math.abs(window.orientation) === 0) {
      // Redirect the user to a different website
      window.location.href = '../reservations/reservations.php';
    }
});
