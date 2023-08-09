<?php

include ("../header-footer/header.php");
include ("../navigation/navigation.php");
include("../PHP/db_connection.php");
include("../PHP/conf2.php");
include("../PHP/functions.php");


if(isset($_POST["btn_edit"]))
{
    $BoatID = mysqli_real_escape_string($con, $_POST["BoatID"]);
    $StartDate = mysqli_real_escape_string($con, $_POST["StartDate"]);
    $FinishDate = mysqli_real_escape_string($con, $_POST["FinishDate"]);
    $StartTime = mysqli_real_escape_string($con, $_POST["StartTime"]);
    $FinishTime = mysqli_real_escape_string($con, $_POST["FinishTime"]);
    $ClientName = mysqli_real_escape_string($con, $_POST["ClientName"]);
    $ClientSurname = mysqli_real_escape_string($con, $_POST["ClientSurname"]);
    $ClientTelNum = mysqli_real_escape_string($con, $_POST["ClientTelNum"]);
    $ClientOIB = mysqli_real_escape_string($con, $_POST["ClientOIB"]);
    $Price = mysqli_real_escape_string($con, $_POST["Price"]);
    $AdvancePayment = formatData($_POST["AdvancePayment"]);
    $PriceDiffrence = formatData($_POST["PriceDiffrence"]);
    $Deposit = formatData($_POST["Deposit"]);
    $AdvancePaymentDate = formatData($_POST["AdvancePaymentDate"]);
    $PriceDiffrenceDate = formatData($_POST["PriceDiffrenceDate"]);
    $DepositDate = formatData($_POST["DepositDate"]);
    $EmployeeID = mysqli_real_escape_string($con, $_POST["EmployeeID"]);
    $SessionEmployeeID = $_SESSION['IDEmployee'];
    $Note = mysqli_real_escape_string($con, $_POST["Note"]);

    $Platform = mysqli_real_escape_string($con, $_POST["Platform"]);

    $IDr = (int)$_GET["IDr"];
    $IDr = mysqli_real_escape_string($con, $IDr);

    $query_upd = "UPDATE reservation
                    SET
                    BoatID = '$BoatID',
                    StartDate = '$StartDate',
                    FinishDate = '$FinishDate',
                    StartTime = '$StartTime',
                    FinishTime = '$FinishTime',
                    Name = '$ClientName',
                    Surname = '$ClientSurname',
                    TelNum = '$ClientTelNum',
                    OIB = '$ClientOIB',
                    Price = '$Price',
                    AdvancePayment = $AdvancePayment,
                    PriceDiffrence = $PriceDiffrence,
                    Deposit = $Deposit,
                    AdvancePaymentDate = $AdvancePaymentDate,
                    PriceDiffrenceDate = $PriceDiffrenceDate,
                    DepositDate = $DepositDate,
                    EmployeeID = '$EmployeeID',
                    SessionEmployeeID = '$SessionEmployeeID',
                    Note = '$Note',
                    Platform = '$Platform'
                    WHERE IDReservation = '$IDr'";
    
    $result_upd = mysqli_query($con, $query_upd);

    if ($result_upd) {
        //header('Location: ../reservations/reservations.php?day='.date("Y-m-d", strtotime($StartDate)).'');
        $redirectDate = date("Y-m-d", strtotime($StartDate));
        echo '
        <script>
        // Function to redirect the user to the reservations page with the specified date
        function redirectToReservations(redirectDate) {
            var reservationsURL = "../reservations/reservations.php?day=" + redirectDate;
            window.location.href = reservationsURL;
        }
    
        // Automatically redirect the user to the reservations page on page load
        redirectToReservations("' . $redirectDate . '"); // Enclose $redirectDate in quotes
        </script>
        ';
    }    
    else
    {
        echo 'Error in the SQL query (postojeca): ' . mysqli_error($con);
    }
}

if (isset($_POST["btn_save"])) {

    $BoatID = mysqli_real_escape_string($con, $_POST["BoatID"]);
    $StartDate = mysqli_real_escape_string($con, $_POST["StartDate"]);
    $FinishDate = mysqli_real_escape_string($con, $_POST["FinishDate"]);
    $StartTime = mysqli_real_escape_string($con, $_POST["StartTime"]);
    $FinishTime = mysqli_real_escape_string($con, $_POST["FinishTime"]);
    $ClientName = mysqli_real_escape_string($con, $_POST["ClientName"]);
    $ClientSurname = mysqli_real_escape_string($con, $_POST["ClientSurname"]);
    $ClientTelNum = mysqli_real_escape_string($con, $_POST["ClientTelNum"]);
    $ClientOIB = mysqli_real_escape_string($con, $_POST["ClientOIB"]);
    $Price = mysqli_real_escape_string($con, $_POST["Price"]);
    $AdvancePayment = formatData($_POST["AdvancePayment"]);
    $PriceDiffrence = formatData($_POST["PriceDiffrence"]);
    $Deposit = formatData($_POST["Deposit"]);
    $CreatedDate = date("Y-m-d");
    $AdvancePaymentDate = formatData($_POST["AdvancePaymentDate"]);
    $PriceDiffrenceDate = formatData($_POST["PriceDiffrenceDate"]);
    $DepositDate = formatData($_POST["DepositDate"]);
    $EmployeeID = mysqli_real_escape_string($con, $_POST["EmployeeID"]);
    $SessionEmployeeID = $_SESSION['IDEmployee'];
    $Note = mysqli_real_escape_string($con, $_POST["Note"]);

    $Platform = mysqli_real_escape_string($con, $_POST["Platform"]);

    // Provjera dal je $Finish time prije $StartTime
    if (strtotime($FinishDate) < strtotime($StartDate)) {
        echo '<script type="text/javascript">';
        echo '// Wrap the code inside a DOMContentLoaded event listener
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("blurForClearFormPopup").classList.toggle("active");
            document.getElementById("datumPopup").classList.toggle("active");
        });
        ';
        echo '</script>';
    } 
    else {

        // Provjera overbookinga
        $query_check_overlap = "SELECT * FROM reservation 
                                WHERE BoatID = '$BoatID' 
                                AND StartDate <= '$FinishDate' 
                                AND FinishDate >= '$StartDate' 
                                AND StartTime <= '$FinishTime' 
                                AND FinishTime >= '$StartTime'";
        
        $result_check_overlap = mysqli_query($con, $query_check_overlap);

        //Ako je overbook: prikazi popup
        if (mysqli_num_rows($result_check_overlap) > 0) {
            echo '<script type="text/javascript">';
            echo '// Wrap the code inside a DOMContentLoaded event listener
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("blurForClearFormPopup").classList.toggle("active");
                document.getElementById("errorPopup").classList.toggle("active");
            });
            ';
            echo '</script>';
        }
        //Ako nije overbook: nastavi s insertom 
        else {
            $query_ins = "INSERT INTO reservation
                            (BoatID, StartDate, StartTime, FinishDate, FinishTime, Name, Surname, TelNum, OIB, Price, AdvancePayment, PriceDiffrence, Deposit, CreatedDate, AdvancePaymentDate, PriceDiffrenceDate, DepositDate, EmployeeID, SessionEmployeeID, Note, Platform)
                            VALUES
                            ('$BoatID', '$StartDate', '$StartTime', '$FinishDate', '$FinishTime', '$ClientName', '$ClientSurname', '$ClientTelNum', '$ClientOIB', '$Price', $AdvancePayment, $PriceDiffrence, $Deposit, '$CreatedDate', $AdvancePaymentDate, $PriceDiffrenceDate, $DepositDate, '$EmployeeID', '$SessionEmployeeID', '$Note', '$Platform')";
        
            $result_ins = mysqli_query($con, $query_ins);
        
            if ($result_ins) {
                //STARA VERZIJA
                //header('Location: ../reservations/reservations.php?day=' . date("Y-m-d", strtotime($StartDate)));
                //exit;

                $redirectDate = date("Y-m-d", strtotime($StartDate));
                echo '
                <script>
                // Function to redirect the user to the reservations page with the specified date
                function redirectToReservations(redirectDate) {
                    var reservationsURL = "../reservations/reservations.php?day=" + redirectDate;
                    window.location.href = reservationsURL;
                }
            
                // Automatically redirect the user to the reservations page on page load
                redirectToReservations("' . $redirectDate . '"); // Enclose $redirectDate in quotes
                </script>
                ';
                
            } else {
                echo 'Error in the SQL query (nova): ' . mysqli_error($con);
            }
        }
        }
}


// Ako je stisnuta postojeca rezervacija
if(isset($_GET["IDr"])){
    $IDr = (int)$_GET["IDr"];

    // Ugradena funkcija da ne prolaze parametri koji nisu broj
    // Security feature
    $IDr = mysqli_real_escape_string($con, $IDr);

    $query = "SELECT 
            reservation.IDReservation,
            boat.Name AS BoatName,
            boat.IDBoat AS IDBoat, 
            reservation.StartDate,
            reservation.FinishDate,
            reservation.StartTime,
            reservation.FinishTime,
            reservation.Name AS ClientName,
            reservation.Surname AS ClientSurname,
            reservation.TelNum AS ClientTenNum,
            reservation.OIB AS ClientOIB,
            reservation.Price,
            reservation.AdvancePayment,
            reservation.PriceDiffrence,
            reservation.Deposit,
            reservation.AdvancePaymentDate,
            reservation.PriceDiffrenceDate,
            reservation.DepositDate,
            employee.Username AS Employee,
            employee.IDEmployee AS IDEmployee,
            reservation.SessionEmployeeID,
            reservation.Note,
            reservation.Platform
            FROM reservation 
            LEFT JOIN boat ON (reservation.BoatID = boat.IDBoat)
            LEFT JOIN employee ON (reservation.EmployeeID = employee.IDEmployee)
            WHERE IDReservation = '$IDr'";

    $result = mysqli_query($con, $query);

    $reservation = mysqli_fetch_assoc($result);

    $IDReservation = $reservation['IDReservation'];
    $BoatName = $reservation['BoatName'];
    $IDBoat = $reservation['IDBoat'];
    $StartDate = $reservation['StartDate'];
    $FinishDate = $reservation['FinishDate'];
    $StartTime = $reservation['StartTime'];
    $FinishTime = $reservation['FinishTime'];
    $ClientName = $reservation['ClientName'];
    $ClientSurname = $reservation['ClientSurname'];
    $ClientTelNum = $reservation['ClientTenNum'];
    $ClientOIB = $reservation['ClientOIB'];
    $Price = $reservation['Price'];
    $AdvancePayment = $reservation['AdvancePayment'];
    $PriceDiffrence = $reservation['PriceDiffrence'];
    $Deposit = $reservation['Deposit'];
    $AdvancePaymentDate = $reservation['AdvancePaymentDate'];
    $PriceDiffrenceDate = $reservation['PriceDiffrenceDate'];
    $DepositDate = $reservation['DepositDate'];
    $IDEmployee = $reservation['IDEmployee'];
    $SessionEmployeeID = $reservation['SessionEmployeeID'];
    $Employee = $reservation['Employee'];
    $Note = $reservation['Note'];
    $Platform = $reservation['Platform'];
    $BoatPrice = "";

    $btn = 'btn_edit';

}
// Ako je stisnuta prazna kartica
elseif (isset($_GET["BoatSelected"]) && isset($_GET["DateSelected"])) {
    $convertedDate = $_GET['DateSelected'];

    foreach($lookup as $item) {
    if($item['Card'] == $_GET['BoatSelected']) {
        $boatid = $item['IDBoat'];
        $boatprice = $item['BoatPrice'];
        if($item['CardSlotPlace'] == 1){
            $finishtime = "19:00";
        }
        else{
            $finishtime = "13:00";
        }
    }
    }

    $IDReservation = "";
    $BoatName = "";
    $IDBoat = $boatid;
    $BoatPrice = $boatprice;
    $StartDate = $convertedDate;
    $FinishDate = "";
    $StartTime = "08:00";
    $FinishTime = $finishtime;
    $ClientName = "";
    $ClientSurname = "";
    $ClientTelNum = "";
    $ClientOIB = "";
    $Price = "";
    $AdvancePayment = "";
    $PriceDiffrence = "";
    $Deposit = "";
    $AdvancePaymentDate = "";
    $PriceDiffrenceDate = "";
    $DepositDate = "";
    $IDEmployee = "";
    $Employee = "";
    $Note = "";
    $Platform = "0";


    $btn = 'btn_save';
}
// Ako je samo otvorena addReservation.php
else{
    $IDReservation = "";
    $BoatName = "";
    $IDBoat = "";
    $BoatPrice = "";
    $StartDate = "";
    $FinishDate = "";
    $StartTime = "08:00";
    $FinishTime = "19:00";
    $ClientName = "";
    $ClientSurname = "";
    $ClientTelNum = "";
    $ClientOIB = "";
    $Price = "";
    $AdvancePayment = "";
    $PriceDiffrence = "";
    $Deposit = "";
    $AdvancePaymentDate = "";
    $PriceDiffrenceDate = "";
    $DepositDate = "";
    $IDEmployee = "";
    $Employee = "";
    $Note = "";
    $Platform = "0";


    $btn = 'btn_save';
}

echo '
<main id="blur">
    <div class="spacer"></div>
    <div class="add-glass-container blurForClearFormPopup" id="blurForClearFormPopup">
        <!--LIJEVI DIO-->
        <div class="add-glass">

            <div class="add-title">Nova Rezervacija</div>

            <div class="add-panel add-panel-left">

                <form id="reservationForm" style="height:100%" method="POST" action="">

                    <!-- dropdown -->
                    <div class="add-dropdown-container">
                        <select class="add-dropdown addBrodovi-dropdown" name="BoatID" required>
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

                    <!-- Booking information -->


                    <div class="add-input-title">Booking Information:</div>

                    <div class="add-inputs-top">
                        <div class="add-input-container-flex">
                            <label class="add-input-label" for="addreserv-datum-od">Od datuma:</label>
                            <input type="date" id="addreserv-datum-od" class="inputField"
                                name="StartDate" value="'.$StartDate.'" required>
                        </div>
                        <div class="add-input-container-flex">
                            <label class="add-input-label" for="addreserv-datum-do">Do datuma:</label>
                            <input type="date" id="addreserv-datum-do" class="inputField"
                                name="FinishDate" value="'.$FinishDate.'" required>
                        </div>
                    </div>

                    <!-- Radio buttons za fiksno vrijeme -->
                    <!--
                    <div class="add-radio-button-container">
                        <label class="add-input-label" for="ad-radio-button">1/2 dana</label>
                        <input type="radio" id="ad-radio-button1" name="TimeSlot" class="ad-radio-button">
                        <label class="add-input-label" for="ad-radio-button">2/2 dana</label>
                        <input type="radio" id="ad-radio-button2" name="TimeSlot" class="ad-radio-button">
                        <label class="add-input-label" for="ad-radio-button">Cijeli dan</label>
                        <input type="radio" id="ad-radio-button3" name="TimeSlot" class="ad-radio-button">
                    </div>
                    -->

                    <div class="add-inputs-top" style="margin-top:20px;">
                        <div class="add-input-container-flex">
                            <label class="add-time-label" for="addreserv-vrijeme-od">Od sati:</label>
                            <input type="time" id="addreserv-vrijeme-od" name="StartTime" value="'.$StartTime.'" class="inputField" required>
                        </div>
                        <div class="add-input-container-flex">
                            <label class="add-time-label" for="addreserv-vrijeme-do">Do sati:</label>
                            <input type="time" id="addreserv-vrijeme-do" name="FinishTime" value="'.$FinishTime.'" class="inputField" required>
                        </div>
                    </div>


                    <div class="add-dropdown-container addDjelatnici-dropdown-container">
                        
                        <div class="add-radio-button-container">
                            <div class="add-radio-button-div-container">
                                SamBoat
                                <input type="checkbox" name="Platform" value="1" id="samBoatCheckbox"
                                ';
                                if($Platform == "1")
                                {
                                    echo 'checked';
                                }
                                echo '
                                >
                            </div>
                            <div class="add-radio-button-div-container">
                                Click&Boat
                                <input type="checkbox" name="Platform" value="2" id="clickAndBoatCheckbox"
                                ';
                                if($Platform == "2")
                                {
                                    echo 'checked';
                                }
                                echo '
                                >
                            </div>
                        </div>
                        
                        <select id="addDjelatnici-dropdown" class="add-dropdown addDjelatnici-dropdown color-grey" name="EmployeeID" required>
                            <option value="">Rezervirao...</option>
                            ';

                            $query_employee = "SELECT * FROM employee WHERE Username != 'Admin' ORDER BY IDEmployee ASC";
                            $result_employee = mysqli_query($con, $query_employee);

                            while($row = mysqli_fetch_assoc($result_employee))
                            {
                                $EnployeeID = $row["IDEmployee"];
                                $username = $row["Username"];

                                if($EnployeeID == $_SESSION["IDEmployee"] && $IDEmployee == "")
                                {
                                    $selected = 'selected="selected"';
                                }
                                elseif($EnployeeID == $IDEmployee)
                                {    
                                    $selected = 'selected="selected"';
                                }
                                else{
                                    $selected = "";
                                }

                                echo '<option value="'.$EnployeeID.'" '.$selected.'>'.$username.'</option>';
                            }

                            echo '
                        </select>
                    </div>

                    <!-- Client / Price Informatiom -->

                    <div class="add-input-container-flex2">

                        <!-- Lijeva strana (Client Information) -->
                        <div class="add-small-container">

                            <div class="add-input-title">Client Information:</div>

                            <div class="add-input-group-flex">
                                <input class="add-input add-input-first" type="text" id="add-input-ime" placeholder="Ime" name="ClientName" value="'.$ClientName.'" required>
                            </div>
                            <div class="add-input-group-flex">
                                <input class="add-input add-input-middle" type="text" id="add-input-prezime"  placeholder="Prezime" name="ClientSurname" value="'.$ClientSurname.'">
                            </div>
                            <div class="add-input-group-flex">
                                <input class="add-input add-input-middle" type="tel" id="add-input-mobitel"  placeholder="Telefon" name="ClientTelNum" value="'.$ClientTelNum.'" required>
                            </div>
                            <div class="add-input-group-flex">
                                <input class="add-input add-input-last" type="text" id="add-input-oib"  placeholder="OIB" name="ClientOIB" value="'.$ClientOIB.'">
                            </div>
                        </div>

                        <!-- Desna strana (Price Information) -->

                        <div class="add-small-container">

                            <div class="add-input-title">Price Information:</div>

                            <div class="add-input-group-flex-left">
                                <input type="number" id="addInput-cijena" step="0.01" class="add-input add-input-first" placeholder="Cijena (€'.$BoatPrice.')" name="Price" value="'.$Price.'" required>
                            </div>

                            <div class="add-panel-flex">

                                <div class="add-panel-left-content-bottom-right-side">
                                    <div class="add-input-group-flex-left-half">
                                        <input type="number" id="addInput-akontacija" class="add-input add-input-middle" placeholder="Akontacija" name="AdvancePayment" value="'.$AdvancePayment.'" oninput="
                                            ';echo <<<EOT
                                            checkDateRequired('addInput-akontacija', 'AdvancePaymentDate')
                                            EOT;
                                            echo '">
                                    </div>
                                    <div class="add-input-group-flex-left-half add-razlika-container">
                                        <input type="number" id="addInput-razlika" class="add-input add-input-middle add-razlika-left" placeholder="Razlika" name="PriceDiffrence" value="'.$PriceDiffrence.'" oninput="
                                        ';echo <<<EOT
                                        checkDateRequired('addInput-razlika', 'PriceDiffrenceDate')
                                        EOT;
                                        echo '">
                                        
                                        <div class="add-input add-input-middle add-razlika-right" id="addInput-Razlika-Span"></div> 
                                    </div>
                                    <div class="add-input-group-flex-left-half">
                                        <input type="number" id="addInput-deposit" class="add-input add-input-last-left" placeholder="Depozit" name="Deposit" value="'.$Deposit.'" oninput="
                                        ';echo <<<EOT
                                        checkDateRequired('addInput-deposit', 'DepositDate')
                                        EOT;
                                        echo '">
                                    </div>
                                </div>
                                <div class="add-panel-left-content-bottom-right-side">
                                    <div>
                                        <input type="date" id="AdvancePaymentDate" class="add-input add-input-middle color-grey" name="AdvancePaymentDate" value="'.$AdvancePaymentDate.'">
                                    </div>
                                    <div>
                                        <input type="date" id="PriceDiffrenceDate" class="add-input add-input-middle color-grey" name="PriceDiffrenceDate" value="'.$PriceDiffrenceDate.'" >
                                    </div>
                                    <div>
                                        <input type="date" id="DepositDate" class="add-input add-input-last-right color-grey" name="DepositDate" value="'.$DepositDate.'">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Biljeska -->
                    <div class="add-input-title">Aditional Information:</div>
                    <div class="add-text-area-container">
                        <textarea class="add-text-area" placeholder="Bilješka" name="Note">'.$Note.'</textarea>
                    </div>
                    <!-- Tipke -->
                    <div class="add-panel-left-content-buttons">
                        <input type="button" value="Očisti" class="add-button-spacing add-button-ocisti" onclick="delete_popup()">
                        <input type="submit" id="submitButton" value="Rezerviraj" class="add-button-spacing add-button-rezerviraj" name="'.$btn.'">
                    </div>
            </div>

            </form>
        </div>

        <!--DESNI DIO-->

        <div class="add-glass">

            
            <div class="add-title">Kalendar Cijene</div>

            <div class="add-panel calculator-container">
                <div class="calculator-container calculator-container-input">
                    <input type="number" id="calcPrice" name="calcPrice" placeholder="Cijena" class="inputField">
                    <div>x</div>
                    <input type="number" id="calcDays" name="calcDays" placeholder="Broj dana" class="inputField">
                </div>
                <a href="#calcPrice" onclick="calculatePrice()" class="button-edit">
                    <div class="button-text">Izračunaj</div>
                </a>
                <div class="inputField" id="calcOutput">0</div>
            </div>

            <div class="add-title">Kalendar Rezervacija</div>

            <!--
            <div class="add-panel">
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
                        <lord-icon src="../icon/delete.json" target=".button-delete-deletePopup" trigger="loop-on-hover"
                            delay="500" colors="primary:#da1a20" style="width:20px;height:20px">
                        </lord-icon>
                        <div class="button-text">Očisti</div>
                    </a>
                    <a href="#" onclick="delete_popup()" class="button-edit">
                        <lord-icon class="rotate-arrow" src="../icon/dateArrow.json" target=".button-edit"
                            trigger="loop-on-hover" delay="500" colors="primary:#337895" style="width:20px;height:20px">
                        </lord-icon>
                        <div class="button-text">Odustani</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="errorPopup" class="clearFormPopup">
        <div class="deleteWindow-rows">
            <div class="popup-title h4">Rezervacija u tom terminu već postoji.</div>
            <div class="row">
                <div class="popup-col-flex-buttons">
                    <a href="#" onclick="popup()" class="button-edit">
                        <lord-icon class="rotate-arrow"
                            src="../icon/dateArrow.json"
                            target=".button-edit"
                            trigger="loop-on-hover"
                            delay="500"
                            colors="primary:#337895"
                            style="width:20px;height:20px">
                        </lord-icon>
                        <div class="button-text">Pokušaj ponovno</div>
                    </a>   
                </div>
            </div>
            </div>
        </div>
    <div id="datumPopup" class="clearFormPopup">
        <div class="deleteWindow-rows">
            <div class="popup-title h4">Datum završetka je prije datuma početka.</div>
            <div class="row">
                <div class="popup-col-flex-buttons">
                    <a href="#" onclick="datumpopup()" class="button-edit">
                        <lord-icon class="rotate-arrow"
                            src="../icon/dateArrow.json"
                            target=".button-edit"
                            trigger="loop-on-hover"
                            delay="500"
                            colors="primary:#337895"
                            style="width:20px;height:20px">
                        </lord-icon>
                        <div class="button-text">Pokušaj ponovno</div>
                    </a>   
                </div>
            </div>
        </div>
    </div>
    <div class="spacer spacer-bottom"></div>

</main>

';


include ("../header-footer/footer-addReservation.php");
include ("../header-footer/footer.php");


?>