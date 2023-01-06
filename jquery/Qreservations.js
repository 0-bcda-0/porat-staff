// 1. Funkcionalnost: Popup za prikaz svih podataka o rezervaciji
// 4. Funkcionalnost: Otvaranje telefona na klik broja telefona
function popup(json) {
    // Parsiranje jsona u varijablu
    var reservation = JSON.parse(json);
  
    // Dohvacanje i toglanje popupa
    $('#popup').toggleClass('active');
  
    // Konvertiranje datuma u d.m.yyyy format
    var dateStart = new Date(reservation.StartDate);
    var dateStart = dateStart.getDate() + '.' + (dateStart.getMonth() + 1) + '.' + dateStart.getFullYear();
  
    var dateFinish = new Date(reservation.FinishDate);
    var dateFinish = dateFinish.getDate() + '.' + (dateFinish.getMonth() + 1) + '.' + dateFinish.getFullYear();
  
    // Inner html na popupu
    $('#popupBoat').html(reservation.BoatName);
    $('#popupTime').html('Od: ' + reservation.StartTimeH + ' Do: ' + reservation.FinishTimeH);
    $('#popupDate').html('Od datuma: ' + dateStart + ' <br> Do datuma: ' + dateFinish);
    $('#popupNameSurname').html(reservation.ClientName + ' ' + reservation.ClientSurname);
    $('#popupTelNum').html(reservation.ClientTelNum);
    $('#popupOib').html(reservation.ClientOIB);
    $('#popupPrice').html(reservation.Price);
    $('#popupAdvancePayment').html(reservation.AdvancePayment);
    $('#popupPriceDiffrence').html(reservation.PriceDiffrence);
    $('#popupEmployee').html(reservation.Employee);
  
    //  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    // Kreiramo link za telefon
    let a = $('<a>').attr('href', 'tel:' + reservation.ClientTelNum).text(reservation.ClientTelNum);
    // Dodamo link u html
    $('#popupTelNum').html('').append(a);
  
    //  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    // Kreiranje Popupa za potvrdu brisanja rezervacije, te prosljedivanje ID-a rezervacije u reservations.php za brisanje
    $('#popup').after(`
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
    $('#editButton').attr('href', '../addReservation/addReservation.php?IDr=' + reservation.IDReservation);
}

function delete_popup() {
    $('#popupWindow').toggleClass('active');
    $('#deleteWindow').toggleClass('active');
}

function delete_popup_in_popup() {
    $('#popupWindow').toggleClass('active');
    $('#deleteWindow').remove();
}

function closepopup() {
    $('#popup').toggleClass('active');
}

//  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// 5. Funkcionalnost: Tipka za povratak na vrh stranice
$('#scrollToTop').on('click', function() {
    window.scrollTo(0, 0);
});

$(window).on('scroll', function() {
    $('#scrollToTop').css('display', window.scrollY > 100 ? 'flex' : 'none');
});

//  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// 6. Funkcionalnost: Prikazivanje poruke za rotiranje uredjaja
$(window).on('orientationchange', function() {
if (Math.abs(window.orientation) === 90) {
    window.location.href = '../rotated/rotated.html';
} else {
    window.location.href = '../reservations/reservations.php';
}
});

//  ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
// 9. Funkcionalnost: Prikaz Countdown timera, te refresh stranice kada timer istekne
(function refreshPage() {
    // Admin mijenja vrijeme u minutama
    var timeoutInMinutes = 5;

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
        seconds = '0' + seconds;
    }

    // Ispis u html
    $('#countdown').html(minutes + ':' + seconds);
})();

(function refreshCountdown() {
    // Funkcija koja se poziva svakih 1000ms (1s)
    setInterval(function() {
        // Uzimanje vrijednosti iz html-a (namjesteno u prijasnjoj funkciji)
        var countdown = $('#countdown');
        var time = countdown.html();

        // Odvajanje minuta i sekundi
        var parts = time.split(':');
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
        secondsD = '0' + secondsD;
        }

        // Formatiranje za ispis u HTML
        var formattedTime = minutesD + ':' + secondsD;
        countdown.html(formattedTime);

        // Ako je vrijeme isteklo, ispisivanje poruke
        if (totalSeconds == 0) {
        countdown.html('Refreshing...');
        }
    }, 1000);
})();
  
  