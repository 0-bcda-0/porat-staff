function popup(json) {
    console.log("Povezao sam se sa popup.js");

    // Parsiranje jsona u varijablu
    var reservation = JSON.parse(json);
    
    // Dohvacanje i toglanje popupa
    document.getElementById('popup').classList.toggle('active');

    // Ako se radi sa varijablama
    // var popupBoat = document.getElementById('popupBoat');
    // var popupTime = document.getElementById('popupTime');
    // var popupDate = document.getElementById('popupDate');
    // var popupNameSurname = document.getElementById('popupNameSurname');
    // var popupTelNum = document.getElementById('popupTelNum');
    // var popupOib = document.getElementById('popupOib');
    // var popupPrice = document.getElementById('popupPrice');
    // var popupAdvancePayment = document.getElementById('popupAdvancePayment');
    // var popupPriceDiffrence = document.getElementById('popupPriceDiffrence');
    // var popupEmployee = document.getElementById('popupEmployee');

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


}

function closepopup() {
    document.getElementById('popup').classList.toggle('active');
}