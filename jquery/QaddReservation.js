// 1. Funkcionalnost: Popup za potvrdu resetiranja forme
function delete_popup() {
    $('#blurForClearFormPopup').toggleClass('active');
    $('#clearFormPopup').toggleClass('active');
}
  
// 2. Funkcionalnost: Resetiranje forme
function clearForm() {
    $('#reservationForm')[0].reset();
    $('#blurForClearFormPopup').toggleClass('active');
    $('#clearFormPopup').toggleClass('active');
}

// 3. Funkcionalnost: Submit forme na enter
$('#reservationForm').on('keypress', function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        $('#submitButton').click();
    }
});

// 7. Funkcionalnost: Izračun cijene
function calculatePrice() {
    // One liner za izračun cijene
    $('#calcOutput').html($('#calcPrice').val() * $('#calcDays').val() + " €");
}

// 8. Funkcionalnost: Auto complete za unos Do datuma
$('#addreserv-datum-od').on('click', function(event) {
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
  
  
    $('#ad-radio-button').on('click', event => {
      // One liner za provjeru da li je radio button checked i ako je, onda se vrijednost inputa Do postavlja na vrijednost inputa Od + 19 sati i 00 minuta
      event.target.checked ? $('#addreserv-datum-do').val(formattedDateTime2) : null;
    });
  
  });
  
  