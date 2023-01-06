// 1. Funkcionalnost: Popup za prikaz poruke o gresci
function popup() {
    var blur = document.getElementById('blurForErrorFormPopup');
    blur.classList.toggle('active');
    var popup = document.getElementById('errorPopup');
    popup.classList.toggle('active');
} 