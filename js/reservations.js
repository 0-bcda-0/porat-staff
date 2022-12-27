// 1. Funkcionalnost: Popup za prikaz svih podataka o rezervaciji
// 4. Funkcionalnost: Otvaranje telefona na klik broja telefona
function popup(json) {
    // console.log("Povezao sam se sa popup.js");

    // Parsiranje jsona u varijablu
    var reservation = JSON.parse(json);
    
    // Dohvacanje i toglanje popupa
    document.getElementById('popup').classList.toggle('active');

    // convert the date to d.m.yyyy format
    var dateStart = new Date(reservation.StartDate);
    var dateStart = dateStart.getDate() + "." + (dateStart.getMonth() + 1) + "." + dateStart.getFullYear();

    var dateFinish = new Date(reservation.FinishDate);
    var dateFinish = dateFinish.getDate() + "." + (dateFinish.getMonth() + 1) + "." + dateFinish.getFullYear();

    // Inner html na popupu
    document.getElementById('popupBoat').innerHTML = reservation.BoatName;
    document.getElementById('popupTime').innerHTML = "Od: " + reservation.StartTimeH + " Do: " + reservation.FinishTimeH;
    document.getElementById('popupDate').innerHTML = "Od datuma: " + dateStart + " <br> Do datuma: " + dateFinish;
    document.getElementById('popupNameSurname').innerHTML = reservation.ClientName + " " + reservation.ClientSurname;
    document.getElementById('popupTelNum').innerHTML = reservation.ClientTelNum;
    document.getElementById('popupOib').innerHTML = reservation.ClientOIB;
    document.getElementById('popupPrice').innerHTML = reservation.Price;
    document.getElementById('popupAdvancePayment').innerHTML = reservation.AdvancePayment;
    document.getElementById('popupPriceDiffrence').innerHTML = reservation.PriceDiffrence;
    document.getElementById('popupEmployee').innerHTML = reservation.Employee;

    //  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    // Kreiramo link za telefon
    let a = document.createElement('a');
    // Dodamo href atribut
    a.href = 'tel:' + reservation.ClientTelNum;
    // Dodamo text
    a.innerHTML = reservation.ClientTelNum;
    // Dodamo link u html
    document.getElementById('popupTelNum').innerHTML = '';
    document.getElementById('popupTelNum').appendChild(a);
}

function delete_popup() {
    document.getElementById('popupWindow').classList.toggle('active');
    document.getElementById('deleteWindow').classList.toggle('active');
}

function closepopup() {
    document.getElementById('popup').classList.toggle('active');
}

//  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// 5. Funkcionalnost: Tipka za povratak na vrh stranice
document.getElementById('scrollToTop').addEventListener('click', function() {
    window.scrollTo(0, 0);
});

window.addEventListener('scroll', function() {
    document.getElementById('scrollToTop').style.display = window.scrollY > 100 ? 'flex' : 'none';
});


//  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// 6. Funkcionalnost: Prikazivanje poruke za rotiranje uredjaja
window.addEventListener('orientationchange', function() {
    // Check the device orientation
    if (Math.abs(window.orientation) === 90) {
      // Display "Orientation not supported" on the page
      window.location.href = '../rotated/rotated.html';
    }
    else {
      // Clear the message from the page
      window.location.href = '../reservations/reservations.php.html';
    }
});
  