// 1. Funkcionalnost: Popup za potvrdu resetiranja forme
function delete_popup() {
    document.getElementById('blurForClearFormPopup').classList.toggle('active');
    document.getElementById('clearFormPopup').classList.toggle('active');
}

function popup() {
  document.getElementById('blurForClearFormPopup').classList.toggle('active');
  document.getElementById('errorPopup').classList.toggle('active');
} 

function datumpopup() {
  document.getElementById('blurForClearFormPopup').classList.toggle('active');
  document.getElementById('datumPopup').classList.toggle('active');
} 

// 2. Funkcionalnost: Resetiranje forme
//* 3.3.
function clearForm() {
    document.getElementById("reservationForm").reset();
    document.getElementById('blurForClearFormPopup').classList.toggle('active');
    document.getElementById('clearFormPopup').classList.toggle('active');
}

// 3. Funkcionalnost: Submit forme na enter
//* 3.4.
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

// 9. Funkcionalnost: Autocomplete addInput-razlika (razlika u cijeni) na temelju addInput-cijena i addInput-akontacija
//* 3.5.
document.getElementById('addInput-akontacija').addEventListener('input', function() {
  if (document.getElementById('addInput-cijena').value && document.getElementById('addInput-akontacija').value) {
    document.getElementById('addInput-Razlika-Span').innerHTML = document.getElementById('addInput-cijena').value - document.getElementById('addInput-akontacija').value;
  } else {
    document.getElementById('addInput-Razlika-Span').innerHTML = '()';
  }
});

// 9. Funkcionalnost: Autocomplete addInput-razlika (razlika u cijeni) na temelju addInput-cijena i addInput-akontacija kada je addInput-razlika prazan
//* 3.6.
if(document.getElementById('addInput-razlika').value == "") {
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

// 11. Funkcionalnost: Provjera da li je addInput-akontacija popunjen, ako je, onda je addInput-AdvancePaymentDate required
//* 3.7.
function checkDateRequired(input, date) {
  // Get the input elements
  const addInputAkontacija = document.getElementById(input);
  const advancePaymentDate = document.getElementById(date);

  // If the value in "addInput-akontacija" is not empty, set "required" on "AdvancePaymentDate" input
  if (addInputAkontacija.value.trim() !== "") {
    advancePaymentDate.setAttribute("required", "required");
  } else {
    // If the value is empty, remove the "required" attribute from "AdvancePaymentDate" input
    advancePaymentDate.removeAttribute("required");
  }
}

/*
  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.ad-checkbox');
    const dropdown = document.getElementById('addDjelatnici-dropdown');

    function updateDropdownState() {
      const isAnyCheckboxChecked = [...checkboxes].some((checkbox) => checkbox.checked);
      dropdown.disabled = isAnyCheckboxChecked;
      if (!isAnyCheckboxChecked) {
        dropdown.value = ''; // Reset the dropdown selection when no checkbox is checked.
      }
    }

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener('click', () => {
        updateDropdownState();
      });
    });

    dropdown.addEventListener('change', () => {
      if (dropdown.disabled) {
        dropdown.selectedIndex = 0; // Reset the dropdown selection to the default option.
      }
    });

    updateDropdownState();
  });*/


//Toglanje required atributa na dropdownu i na razlici
const samBoatCheckbox = document.getElementById("samBoatCheckbox");
const clickAndBoatCheckbox = document.getElementById("clickAndBoatCheckbox");
const addDjelatniciDropdown = document.getElementById("addDjelatnici-dropdown");
const Departure = document.getElementById("Departure");
const addInputRazlika = document.getElementById("addInput-razlika");
  
samBoatCheckbox.addEventListener("change", function() {
    if (samBoatCheckbox.checked) {
        clickAndBoatCheckbox.checked = false;
        
        addDjelatniciDropdown.removeAttribute("required");
    } else {
        
        addDjelatniciDropdown.setAttribute("required", "true");
    }
});
  
clickAndBoatCheckbox.addEventListener("change", function() {
    if (clickAndBoatCheckbox.checked) {
      samBoatCheckbox.checked = false;
      addDjelatniciDropdown.removeAttribute("required");
    } else {  
      addDjelatniciDropdown.setAttribute("required", "true");
    }
});

Departure.addEventListener("change", function() {
  if (Departure.checked) {
    addInputRazlika.setAttribute("required", "true");
    console.log("Departure checked");
  } else {  
    addInputRazlika.removeAttribute("required");
    console.log("Departure unchecked");
  }
});





























