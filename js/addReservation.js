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
  // var scrollPosition = window.pageYOffset;
  // window.scrollTo(0, scrollPosition);
  // One liner za izračun cijene
  document.getElementById("calcOutput").innerHTML = document.getElementById("calcPrice").value * document.getElementById("calcDays").value + " €";
}

// 8. Funkcionalnost: Auto complete za unos Do datuma
/*function TimeModify(input, hours){
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
});*/

// 9. Funkcionalnost: Autocomplete addInput-razlika (razlika u cijeni) na temelju addInput-cijena i addInput-akontacija
document.getElementById('addInput-akontacija').addEventListener('input', function() {
  if (document.getElementById('addInput-cijena').value && document.getElementById('addInput-akontacija').value) {
    document.getElementById('addInput-Razlika-Span').innerHTML = document.getElementById('addInput-cijena').value - document.getElementById('addInput-akontacija').value;
  } else {
    document.getElementById('addInput-Razlika-Span').innerHTML = '()';
  }
});

if(document.getElementById('addInput-razlika').value) {
  razlika2 = parseFloat(document.getElementById('addInput-razlika').value)
  console.log(razlika2);

  // Get the input values
  const cijena = document.getElementById('addInput-cijena').value;
  const akontacija = document.getElementById('addInput-akontacija').value;

  // Calculate the new value (adding akontacija to cijena)
  const razlika = cijena - akontacija;

  console.log(razlika);

  // Set the updated value to the element
  document.getElementById('addInput-Razlika-Span').innerHTML = "(" + razlika + ")";

}

// 10.Funkcionalnost
document.getElementById('addInput-cijena').addEventListener('input', function() {
  // Get the start and end date values
  var startDate = document.getElementById('addreserv-datum-od').value;
  var endDate = document.getElementById('addreserv-datum-do').value;

  // Check if both start and end dates are selected
  if (startDate && endDate) {
    var start = new Date(startDate);
    var end = new Date(endDate);

    // Calculate the number of days between the selected dates
    var timeDiff = Math.abs(end.getTime() - start.getTime());
    var numDays = (Math.ceil(timeDiff / (1000 * 3600 * 24))) + 1; 

    // Output cijene
    document.getElementById('calcPrice').value = document.getElementById('addInput-cijena').value;
    // Output dana
    document.getElementById('calcDays').value = numDays;
  } else {
    // If either start or end date is missing, clear the outputs
    document.getElementById('calcPrice').value = '';
    document.getElementById('calcDays').value = '';
  }
});

function checkDateRequired(input, date) {
  // Get the input elements
  console.log(input);
  const addInputAkontacija = document.getElementById(input);
  const advancePaymentDate = document.getElementById(date);

  console.log(addInputAkontacija, advancePaymentDate);
  // If the value in "addInput-akontacija" is not empty, set "required" on "AdvancePaymentDate" input
  if (addInputAkontacija.value.trim() !== "") {
    advancePaymentDate.setAttribute("required", "required");
  } else {
    // If the value is empty, remove the "required" attribute from "AdvancePaymentDate" input
    advancePaymentDate.removeAttribute("required");
  }
}

// 11. Funkcionalnost: Autocomplete placeholder of id="addInput-cijena" when 



















