<?php

include ("../header-footer/header.php");
include ("../navigation/navigation.php");
// Konekcija na bazu
include("../PHP/db_connection.php");

if(isset($_POST["btn_edit"]))
{
    $BoatID = mysqli_real_escape_string($con, $_POST["BoatID"]);
    $StartDateTime = mysqli_real_escape_string($con, $_POST["StartDateTime"]);
    $FinishDateTime = mysqli_real_escape_string($con, $_POST["FinishDateTime"]);
    $ClientName = mysqli_real_escape_string($con, $_POST["ClientName"]);
    $ClientSurname = mysqli_real_escape_string($con, $_POST["ClientSurname"]);
    $ClientTelNum = mysqli_real_escape_string($con, $_POST["ClientTelNum"]);
    $ClientOIB = mysqli_real_escape_string($con, $_POST["ClientOIB"]);
    $Price = mysqli_real_escape_string($con, $_POST["Price"]);
    $AdvancePayment = mysqli_real_escape_string($con, $_POST["AdvancePayment"]);
    $PriceDiffrence = mysqli_real_escape_string($con, $_POST["PriceDiffrence"]);
    $EmployeeID = mysqli_real_escape_string($con, $_POST["EmployeeID"]);

    $IDr = (int)$_GET["IDr"];
    $IDr = mysqli_real_escape_string($con, $IDr);

    $query_upd = "UPDATE reservation
                  SET
                  BoatID = '$BoatID',
                  StartDateTime = '$StartDateTime',
                  FinishDateTime = '$FinishDateTime',
                  Name = '$ClientName',
                  Surname = '$ClientSurname',
                  TelNum = '$ClientTelNum',
                  OIB = '$ClientOIB',
                  Price = '$Price',
                  AdvancePayment = '$AdvancePayment',
                  PriceDiffrence = '$PriceDiffrence',
                  EmployeeID = '$EmployeeID'
                  WHERE IDReservation = '$IDr'";
    
    $result_upd = mysqli_query($con, $query_upd);

    if($result_upd)
    {
        // echo 'Podaci su uspjesno spremljeni';
        header("Location: ../reservations/reservations.php");
        exit;
    }
    else
    {
        echo 'Greska kod edita. Pokusajte ponovo';
    }
}

if(isset($_POST["btn_save"]))
{
  echo 'SAVE';
  $BoatID = mysqli_real_escape_string($con, $_POST["BoatID"]);
  $StartDateTime = mysqli_real_escape_string($con, $_POST["StartDateTime"]);
  $FinishDateTime = mysqli_real_escape_string($con, $_POST["FinishDateTime"]);
  $ClientName = mysqli_real_escape_string($con, $_POST["ClientName"]);
  $ClientSurname = mysqli_real_escape_string($con, $_POST["ClientSurname"]);
  $ClientTelNum = mysqli_real_escape_string($con, $_POST["ClientTelNum"]);
  $ClientOIB = mysqli_real_escape_string($con, $_POST["ClientOIB"]);
  $Price = mysqli_real_escape_string($con, $_POST["Price"]);
  $AdvancePayment = mysqli_real_escape_string($con, $_POST["AdvancePayment"]);
  $PriceDiffrence = mysqli_real_escape_string($con, $_POST["PriceDiffrence"]);
  $EmployeeID = mysqli_real_escape_string($con, $_POST["EmployeeID"]);

  $query_ins = "INSERT INTO reservation
                (BoatID, StartDateTime, FinishDateTime, Name, Surname, TelNum, OIB, Price, AdvancePayment, PriceDiffrence, EmployeeID)
                VALUES
                ('$BoatID', '$StartDateTime', '$FinishDateTime', '$ClientName', '$ClientSurname', '$ClientTelNum', '$ClientOIB', '$Price', '$AdvancePayment', '$PriceDiffrence', '$EmployeeID')";
  
  $result_ins = mysqli_query($con, $query_ins);

  if($result_ins)
  {
    // echo 'Podaci su uspjesno spremljeni';
    header("Location: ../reservations/reservations.php");
    exit;
  }
  else
  {
    echo 'Greska kod unosa. Pokusajte ponovo';
  }
}

// ZA UREDIVANJE REZEZRVACIJE
if(isset($_GET["IDr"])){
    $IDr = (int)$_GET["IDr"];

    // Ugradena funkcija da ne prolaze parametri koji nisu broj
    // Security feature
    $IDr = mysqli_real_escape_string($con, $IDr);

    $query = "SELECT 
            reservation.IDReservation,
            boat.Name AS BoatName,
            boat.IDBoat AS IDBoat, 
            reservation.StartDateTime,
            reservation.FinishDateTime,
            reservation.Name AS ClientName,
            reservation.Surname AS ClientSurname,
            reservation.TelNum AS ClientTenNum,
            reservation.OIB AS ClientOIB,
            reservation.Price,
            reservation.AdvancePayment,
            reservation.PriceDiffrence,
            employee.Username AS Employee,
            employee.IDEmployee AS IDEmployee
            FROM reservation 
            LEFT JOIN boat ON (reservation.BoatID = boat.IDBoat)
            LEFT JOIN employee ON (reservation.EmployeeID = employee.IDEmployee)
            WHERE IDReservation = '$IDr'";

    $result = mysqli_query($con, $query);

    $reservation = mysqli_fetch_assoc($result);

    $IDReservation = $reservation['IDReservation'];
    $BoatName = $reservation['BoatName'];
    $IDBoat = $reservation['IDBoat'];
    $StartDateTime = $reservation['StartDateTime'];
    $FinishDateTime = $reservation['FinishDateTime'];
    $ClientName = $reservation['ClientName'];
    $ClientSurname = $reservation['ClientSurname'];
    $ClientTelNum = $reservation['ClientTenNum'];
    $ClientOIB = $reservation['ClientOIB'];
    $Price = $reservation['Price'];
    $AdvancePayment = $reservation['AdvancePayment'];
    $PriceDiffrence = $reservation['PriceDiffrence'];
    $IDEmployee = $reservation['IDEmployee'];
    $Employee = $reservation['Employee'];

    $btn = 'btn_edit';

}
else{
    $IDReservation = "";
    $BoatName = "";
    $IDBoat = "";
    $StartDateTime = "";
    $FinishDateTime = "";
    $ClientName = "";
    $ClientSurname = "";
    $ClientTelNum = "";
    $ClientOIB = "";
    $Price = "";
    $AdvancePayment = "";
    $PriceDiffrence = "";
    $IDEmployee = "";
    $Employee = "";

    $btn = 'btn_save';
}

echo '
<main id="blur">
  <div class="spacer"></div>
  <div class="add-glass-container blurForClearFormPopup" id="blurForClearFormPopup">
    <!--LIJEVI DIO-->
    <div class="add-glass-left">

      <div class="add-title-container">
        <div class="add-title">
          Nova Rezervacija
        </div>
      </div>

      <div class="add-panel-left">
        <div class="add-panel-left-content">

        <form id="reservationForm" style="height:100%" method="POST" action="">

          <!-- dropdown -->
          <div class="addBrodovi-dropdown-container">
            <select id="addBrodovi-dropdown"  name="BoatID" required>
              <option value="">Odaberite svoj brod...</option>';

              $query_boat = "SELECT * FROM boat ORDER BY IDBoat ASC";
              $result_boat = mysqli_query($con, $query_boat);

              while($row = mysqli_fetch_assoc($result_boat))
              {
                  $BoatID = $row["IDBoat"];
                  $name = $row["Name"];

                  if($BoatID == $IDBoat)
                  {
                      $selected = 'selected = "selected"';
                  }
                  else
                  {
                      $selected = "";
                  }

                  echo '<option value="'.$BoatID.'" '.$selected.'>'.$name.'</option>';
              }

          echo '
            </select>
          </div>

        <!-- content-top -->


          <div class="add-panel-left-content-top">

            <div class="add-inputs-top">
              <label class="add-date-label" for="addreserv-datum-od">Od datuma:</label>
              <input type="datetime-local" id="addreserv-datum-od"  class="inputField" name="StartDateTime" value="'.$StartDateTime.'" required>
              <label class="add-date-label" for="addreserv-datum-do">Do datuma:</label>
              <input type="datetime-local" id="addreserv-datum-do" class="inputField" name="FinishDateTime" value="'.$FinishDateTime.'">
            </div>

            <div class="add-radio-button-container">
              <label class="add-date-label" for="ad-radio-button">Vraćam brod isti dan </label>
              <input type="checkbox" id="ad-radio-button">
            </div>

            <!--
            <div class="add-time-input-container">
              <label class="add-time-label" for="addreserv-vrijeme-od">Od sati:</label>
              <input type="time" id="addreserv-vrijeme-od" >
              <label class="add-time-label" for="addreserv-vrijeme-do">Do sati:</label>
              <input type="time" id="addreserv-vrijeme-do" >
            </div>
            -->

          </div>

          <!-- content-bottom -->

          <div class="add-panel-left-content-bottom">

            <!-- lijeva strana bottom contenta -->
            <div class="add-panel-left-content-bottom-left-side">
              <div>
                <label for="add-input-ime">Ime: </label>
                <input type="text" id="add-input-ime" class="add-input-field"  name="ClientName" value="'.$ClientName.'" required>
              </div>
              <div>
                <label for="add-input-prezime">Prezime: </label>
                <input type="text" id="add-input-prezime" class="add-input-field"  name="ClientSurname" value="'.$ClientSurname.'" required>
              </div>
              <div>
                <label for="add-input-mobitel">Mobitel: </label>
                <input type="text" id="add-input-mobitel" class="add-input-field"  name="ClientTelNum" value="'.$ClientTelNum.'" required>
              </div>
              <div>
                <label for="add-input-oib">OIB: </label>
                <input type="number" id="add-input-oib" class="add-input-field" name="ClientOIB" value="'.$ClientOIB.'">
              </div>
            </div>

              <!-- desna strana bottom contenta -->
            <div class="add-panel-left-content-bottom-right-side">
              <div class="addDjelatnici-dropdown-container">
                <select id="addDjelatnici-dropdown"  class="inputField" name="EmployeeID" required>
                  <option value="">Rezervirao...</option>
                  ';

                  $query_employee = "SELECT * FROM employee ORDER BY IDEmployee ASC";
                  $result_employee = mysqli_query($con, $query_employee);

                  while($row = mysqli_fetch_assoc($result_employee))
                  {
                      $EnployeeID = $row["IDEmployee"];
                      $username = $row["Username"];

                      if($EnployeeID == $IDEmployee)
                      {
                          $selected = 'selected = "selected"';
                      }
                      else
                      {
                          $selected = "";
                      }

                      echo '<option value="'.$EnployeeID.'" '.$selected.'>'.$username.'</option>';
                  }

              echo '
                </select>
              </div>
              <div class="add-input-bottomright-container">
                <label for="addInput-cijena">Cijena: </label>
                <input type="number" id="addInput-cijena"   class="inputFieldNumbers" name="Price" value="'.$Price.'" required>
              </div>
              <div class="add-input-bottomright-container">
                <label for="addInput-akontacija">Akontacija: </label>
                <input type="number" id="addInput-akontacija" class="inputFieldNumbers" name="AdvancePayment" value="'.$AdvancePayment.'">
              </div>
              <div class="add-input-bottomright-container">
                <label for="addInput-razlika">Razlika: </label>
                <input type="number" id="addInput-razlika" class="inputFieldNumbers" name="PriceDiffrence" value="'.$PriceDiffrence.'">
              </div>
            </div>

          </div>

          <!-- buttoni -->

          <div class="add-panel-left-content-buttons">
            <div class="add-button-half">
              <div class="add-button-container">
                <input type="button" value="Očisti" class="add-button-ocisti" onclick="delete_popup()">
              </div>
            </div>
            <div class="add-button-half">
              <div class="add-button-container">
                <input type="submit" id="submitButton" value="Rezerviraj" class="add-button-rezerviraj" name="'.$btn.'">
              </div>
            </div>
          </div>
        </div>

        </form> 
        
      </div>    
    </div>

  <!--DESNI DIO-->

    <div class="add-glass-right">

      <div class="add-title-container">
        <div class="add-title">
          Kalendar Cijene
        </div>
      </div>

      <div class="add-panel-right calculator-container">
      <div class="calcInputContainer">
        <input type="number" id="calcPrice" name="calcPrice" placeholder="Cijena po danu" class="calcInput">
        <div>x</div>
        <input type="number" id="calcDays" name="calcDays" placeholder="Broj dana" class="calcInput">
      </div>
      <a href="#" onclick="calculatePrice()" class="button-edit">
          <div class="button-text">Izračunaj</div>
      </a>
      <div class="calcResult" id="calcOutput">0</div>   
      </div>

      <div class="add-title-container">
        <div class="add-title">
          Kalendar Rezervacija
        </div>
      </div>

      <!--
      <div class="add-panel-right">
        <div class="add-panel-right-content">
        </div>
      </div>
      -->

    </div>
</div>

<div id="clearFormPopup" class="clearFormPopup">
    <div class="deleteWindow-rows">
        <div class="popup-title h4">Potvrdi čišćenje unosa</div>
        <div class="row">
            <div class="popup-col-flex-buttons">
                <a href="#" onclick="clearForm()" class="button-delete-deletePopup">
                    <lord-icon
                        src="../icon/delete.json"
                        target=".button-delete-deletePopup"
                        trigger="loop-on-hover"
                        delay="500"
                        colors="primary:#da1a20"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <div class="button-text">Očisti</div>
                </a> 
                <a href="#" onclick="delete_popup()" class="button-edit">
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
<div class="spacer"></div>

</main>

';


include ("../header-footer/footer-addReservation.php");
include ("../header-footer/footer.php");

?>