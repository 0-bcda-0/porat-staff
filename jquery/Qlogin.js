// 1. Funkcionalnost: Popup za prikaz poruke o gresci
function popup() {
  var blur = $('#blurForErrorFormPopup');
  blur.toggleClass('active');
  var popup = $('#errorPopup');
  popup.toggleClass('active');
}
