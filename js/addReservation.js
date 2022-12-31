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
  // One liner za izračun cijene
  document.getElementById("calcOutput").innerHTML = document.getElementById("calcPrice").value * document.getElementById("calcDays").value + " €";
}

// 8. Funkcionalnost: Auto complete za unos Do datuma
document.getElementById("addreserv-datum-od").addEventListener('change', function(event) {
  // U dateObject spremamo vrijednost iz inputa
  const dateObject = new Date(event.target.value);

  // Dodajemo 19 sati i 00 minuta
  dateObject.setHours(19);
  dateObject.setMinutes(00);

  // Pretvaramo u YYYY-MM-DDTHH:mm:ss.sssZ
  const formattedDateTime = dateObject.toISOString();

  const dateObject2 = new Date(formattedDateTime);

  // Pretvaramo u YYYY-MM-DDTHH:mm
  const formattedDateTime2 = `${dateObject.toISOString().split('T')[0]}T${dateObject2.toString().split(' ')[4]}`;


  document.querySelector('#ad-radio-button').addEventListener('click', event => {
    // One liner za provjeru da li je radio button checked i ako je, onda se vrijednost inputa Do postavlja na vrijednost inputa Od + 19 sati i 00 minuta
    event.target.checked ? document.getElementById("addreserv-datum-do").value = formattedDateTime2 : null;
  });

});


