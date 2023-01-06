// 1. Funkcionalnost: Popup za prikaz svih podataka o rezervaciji
// 4. Funkcionalnost: Otvaranje telefona na klik broja telefona
function popup(json) {
    // console.log("Povezao sam se sa popup.js");

    // Parsiranje jsona u varijablu
    var reservation = JSON.parse(json);
    
    // Dohvacanje i toglanje popupa
    document.getElementById('popup').classList.toggle('active');

    // Konvertiranje datuma u d.m.yyyy format
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

    //  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    // Kreiranje Popupa za potvrdu brisanja rezervacije, te prosljedivanje ID-a rezervacije u reservations.php za brisanje
    document.getElementById('popup').insertAdjacentHTML('afterend', `
    <div id="deleteWindow">
    <div class="deleteWindow-rows">
        <div class="popup-title h4">Potvrdi brisanje rezervacije br. `+ reservation.IDReservation +`</div>
        <div class="row">
            <div class="popup-col-flex-buttons">
                <a href="reservations.php?IDr=`+ reservation.IDReservation +`&task=del&day=`+ reservation.StartDate +`"  class="button-delete-deletePopup">
                    <lord-icon
                        src="../icon/delete.json"
                        target=".button-delete-deletePopup"
                        trigger="loop-on-hover"
                        delay="500"
                        colors="primary:#da1a20"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <div class="button-text">Obriši</div>
                </a>  
                <a href="#" onclick="delete_popup_in_popup()" class="button-edit">
                    <lord-icon class="rotate-arrow"
                        src="../icon/dateArrow.json"
                        target=".button-edit"
                        trigger="loop-on-hover"
                        delay="500"
                        colors="primary:#337895"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <div class="button-text">Odustani</div>
                </a>   
            </div>
        </div>
    </div>
    </div>
    `);

    //  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    // Prosljedivanje ID-a rezervacije u addReservation.php za edit
    document.querySelector('#editButton').href = `../addReservation/addReservation.php?IDr=`+ reservation.IDReservation +``;


}

function delete_popup() {
    document.getElementById('popupWindow').classList.toggle('active');
    document.getElementById('deleteWindow').classList.toggle('active');
}

function delete_popup_in_popup () {
    document.getElementById('popupWindow').classList.toggle('active');
    document.getElementById('deleteWindow').remove();
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
    if (Math.abs(window.orientation) === 90) {
      window.location.href = '../rotated/rotated.html';
    }
    else {
      window.location.href = '../reservations/reservations.php';
    }
}); 

