// 1. Funkcionalnost: Resetiranje forme
// 2. Funkcionalnost: Popup za potvrdu resetiranja forme
function delete_popup() {
    document.getElementById('blurForClearFormPopup').classList.toggle('active');
    document.getElementById('clearFormPopup').classList.toggle('active');
}

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


// |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
