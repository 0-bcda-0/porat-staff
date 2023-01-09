// 1. Funkcionalnost: Popup za potvrdu resetiranja forme
function delete_popup() {
    document.getElementById('blurForClearFormPopup').classList.toggle('active');
    document.getElementById('clearFormPopup').classList.toggle('active');
}

// 2. Funkcionalnost: Resetiranje forme
function clearForm() {
    document.getElementById("reservationForm").reset();
    document.getElementById('blurForClearFormPopup').classList.toggle('active');
    document.getElementById('clearFormPopup').classList.toggle('active');
}

// 3. Funkcionalnost: Submit forme na enter
document.getElementById("reservationForm").addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("submitButton").click();
  }
});

// 7. Funkcionalnost: Izračun cijene
function calculatePrice() {
  // Kada se ide izracunat, da se na mobilnom uredaju zadrzi trenutna scroll lokacija
  var scrollPosition = window.pageYOffset;
  window.scrollTo(0, scrollPosition);
  // One liner za izračun cijene
  document.getElementById("calcOutput").innerHTML = document.getElementById("calcPrice").value * document.getElementById("calcDays").value + " €";
}

// 8. Funkcionalnost: Auto complete za unos Do datuma
function TimeModify(input, hours){
  var date = input.value;
  date = new Date(date);
  var offset = date.getTimezoneOffset();
  date.setMinutes(0);
  date.setHours(hours - offset / 60);
  input.value = date.toISOString().slice(0, -1);
}

document.getElementById('ad-radio-button1').addEventListener('click', function() {
  TimeModify(document.getElementById('addreserv-datum-od'), 8);
  TimeModify(document.getElementById('addreserv-datum-do'), 14);
});

document.getElementById('ad-radio-button2').addEventListener('click', function() {
  TimeModify(document.getElementById('addreserv-datum-od'), 15);
  TimeModify(document.getElementById('addreserv-datum-do'), 19);
});

document.getElementById('ad-radio-button3').addEventListener('click', function() {
  TimeModify(document.getElementById('addreserv-datum-od'), 8);
  TimeModify(document.getElementById('addreserv-datum-do'), 19);
});

// 9. Autocomplete za kalkulator
document.getElementById('addInput-cijena').addEventListener('input', function() {
  // Ako je cijena prazna, stavi na "Cijena", ako nije prazna stavi na value od cijene te dane
  if (document.getElementById('addInput-cijena').value) {
    var startDate = document.getElementById('addreserv-datum-od').value;
    var endDate = document.getElementById('addreserv-datum-do').value;

    var start = new Date(startDate);
    var end = new Date(endDate);

    var timeDiff = Math.abs(end.getTime() - start.getTime());
    var numDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

    // Output cijene
    document.getElementById('calcPrice').value = document.getElementById('addInput-cijena').value;
    // Output dana
    document.getElementById('calcDays').value = numDays;

  } else {
    document.getElementById('calcPrice').value = '';
    document.getElementById('calcDays').value = '';
  }
});




