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
    // Kada se ide izracunat, da se na mobilnom uredaju zadrzi trenutna scroll lokacija
    var scrollPosition = $(window).scrollTop();
    // skrola do vrha sto je kontradiktorno, ali kada stavim samo scroll, onda je error
    $(window).scrollTop(scrollPosition);
    // One liner za izračun cijene
    $('#calcOutput').html($('#calcPrice').val() * $('#calcDays').val() + " €");
}

// 8. Funkcionalnost: Auto complete za unos Do datuma
function TimeModify(input, hours){
    var date = input.val();
    date = new Date(date);
    var offset = date.getTimezoneOffset();
    date.setMinutes(0);
    date.setHours(hours - offset / 60);
    input.val(date.toISOString().slice(0, -1));
}

$('#ad-radio-button1').click(function() {
    TimeModify($('#addreserv-datum-od'), 8);
    TimeModify($('#addreserv-datum-do'), 14);
});

$('#ad-radio-button2').click(function() {
    TimeModify($('#addreserv-datum-od'), 15);
    TimeModify($('#addreserv-datum-do'), 19);
});

$('#ad-radio-button3').click(function() {
    TimeModify($('#addreserv-datum-od'), 8);
    TimeModify($('#addreserv-datum-do'), 19);
});

// 9. Autocomplete za kalkulator
$('#addInput-cijena').on('input', function() {
    // Ako je cijena prazna, stavi na "Cijena", ako nije prazna stavi na value od cijene te dane
    if ($(this).val()) {
        var startDate = $('#addreserv-datum-od').val();
        var endDate = $('#addreserv-datum-do').val();

        var start = new Date(startDate);
        var end = new Date(endDate);

        var timeDiff = Math.abs(end.getTime() - start.getTime());
        var numDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 

        // Output cijene
        $('#calcPrice').val($(this).val());
        // Output dana
        $('#calcDays').val(numDays);

    } else {
        $('#calcPrice').val('');
        $('#calcDays').val('');
    }
});
  
  
  