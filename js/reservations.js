// 1. Funkcionalnost: Popup za prikaz svih podataka o rezervaciji
// 4. Funkcionalnost: Otvaranje telefona na klik broja telefona
document.addEventListener("DOMContentLoaded", function() {
function popup2(json) {
    // Parsiranje jsona u varijablu
    var reservation = JSON.parse(json);
    
    // Dohvacanje i toglanje popupa
    document.getElementById('popup').classList.toggle('active');

    // Konvertiranje datuma u d.m.yyyy format
    var dateStart = new Date(reservation.StartDate);
    var dateStart = dateStart.getDate() + "." + (dateStart.getMonth() + 1) + "." + dateStart.getFullYear();

    var dateFinish = new Date(reservation.FinishDate);
    var dateFinish = dateFinish.getDate() + "." + (dateFinish.getMonth() + 1) + "." + dateFinish.getFullYear();

    function formatDate(dateValue) {
        if (dateValue !== null) {
            var dateObj = new Date(dateValue);
            return dateObj.getDate() + "." + (dateObj.getMonth() + 1) + ".";
        } else {
            return '';
        }
    }
    
    var dateAdvancePayment = formatDate(reservation.AdvancePaymentDate);
    var datePriceDiffrence = formatDate(reservation.PriceDiffrenceDate);
    var dateDeposit = formatDate(reservation.DepositDate);
    var dateCreatedDate = formatDate(reservation.CreatedDate);

    console.log(reservation.Employee, dateCreatedDate, reservation.CreatedDate);

    // Inner html na popupu
    document.getElementById('popupBoat').innerHTML = reservation.BoatName + " (N." + reservation.IDReservation + ")";
    document.getElementById('popupTime').innerHTML = "Od: " + reservation.StartTimeH + ":" + reservation.StartTimeM + " Do: " + reservation.FinishTimeH + ":" + reservation.FinishTimeM ;
    document.getElementById('popupDate').innerHTML = "Od datuma: " + dateStart + " <br> Do datuma: " + dateFinish;
    document.getElementById('popupNameSurname').innerHTML = reservation.ClientName + " " + reservation.ClientSurname;
    document.getElementById('popupTelNum').innerHTML = reservation.ClientTelNum;
    document.getElementById('popupOib').innerHTML = reservation.ClientOIB;
    document.getElementById('popupPrice').innerHTML = reservation.Price + "€";
    document.getElementById('popupAdvancePayment').innerHTML = reservation.AdvancePayment !== null ? reservation.AdvancePayment + "€ / " + dateAdvancePayment : '';
    document.getElementById('popupPriceDiffrence').innerHTML = reservation.PriceDiffrence !== null ? reservation.PriceDiffrence + "€ / " + datePriceDiffrence : '';
    document.getElementById('popupDeposit').innerHTML = reservation.Deposit !== null ? reservation.Deposit + "€ / " + dateDeposit : '';
    document.getElementById('popupEmployee').innerHTML = reservation.Employee + " / " + dateCreatedDate;
    document.getElementById('popupNote').innerHTML = reservation.Note;

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
window.popup2 = popup2;
});

function popup(json){
    popup2(json);
}

function delete_popup() {
    document.getElementById('popupWindow').classList.toggle('active');
    document.getElementById('deleteWindow').classList.toggle('active');
}

function delete_popup_in_popup () {
    document.getElementById('popupWindow').classList.toggle('active');
    document.getElementById('deleteWindow').classList.toggle('active');
}

function closepopup() {
    document.getElementById('popup').classList.toggle('active');
}

//tooltip

const tooltipContainer = document.querySelector(".tooltip-container");

tooltipContainer.addEventListener("click", () => {
    tooltipContainer.classList.toggle("active");
});


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

//  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// 9. Funkcionalnost: Prikaz Countdown timera, te refresh stranice kada timer istekne
(function refreshPage() {
    // Admin mijenja vrijeme u minutama
    var timeoutInMinutes = 3;

    // Pretvaramo u milisekunde
    var timeout = timeoutInMinutes * 60 * 1000;

    // Refresh stranice
    setTimeout(function() {
        window.location.reload();
    }, timeout);

    // Pretvaranje u minute i sekunde (za ispis)
    var minutes = Math.floor(timeout / 60000); // minutes
    var seconds = Math.floor((timeout % 60000) / 1000); // seconds

    // Dodavanje nule ako je broj manji od 10
    if (seconds < 10) {
        seconds = "0" + seconds;
    }

    // Ispis u html
    document.getElementById('countdown').innerHTML = minutes + ":" + seconds;
})();

(function refreshCountdown() {
    // Funkcija koja se poziva svakih 1000ms (1s)
    setInterval(function() {
        // Uzimanje vrijednosti iz html-a (namjesteno u prijasnjoj funkciji)
        var countdown = document.getElementById('countdown');
        var time = countdown.innerHTML;

        // Odvajanje minuta i sekundi
        var parts = time.split(":");
        var minutes = parseInt(parts[0], 10);
        var seconds = parseInt(parts[1], 10);

        // Konvertiranje u sekunde
        var totalSeconds = (minutes * 60) + seconds;

        // Oduzimanje jedne sekunde
        totalSeconds--;

        // Od oduzetog vremena izvlacimo minute i sekunde
        var minutesD = Math.floor(totalSeconds / 60);
        var secondsD = totalSeconds % 60;

        // Dodavanje nule ako je broj manji od 10
        if (secondsD < 10) {
            secondsD = "0" + secondsD;
        }

        // Formatiranje za ispis u HTML
        var formattedTime = minutesD + ":" + secondsD;
        countdown.innerHTML = formattedTime;

        // Ako je vrijeme isteklo, ispisivanje poruke
        if (totalSeconds == 0) {
            countdown.innerHTML = "Refreshing...";
        }
    }, 1000);
})();


