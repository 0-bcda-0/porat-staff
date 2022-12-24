function popup() {
    console.log("uspješno");
    var blur = document.getElementById('blurForErrorFormPopup');
    blur.classList.toggle('active');
    var popup = document.getElementById('errorPopup');
    popup.classList.toggle('active');
} 