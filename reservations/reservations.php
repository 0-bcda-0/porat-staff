<?php

// Universal header
include ("../header-footer/header.php");
// Navigation
include ("../navigation/navigation.php");
// Konekcija na bazu
include("../PHP/db_connection.php");
// Konfiguracija
include("../PHP/conf2.php");
// Functions
include("../PHP/functions.php");


// ||||||||||||||||||||||||||||||||||||||| PRETHODNI I SLJEDECI DAN |||||||||||||||||||||||||||||||||||||||
if (isset($_GET["move"]) && $_GET['move'] == "previous") {
    $dayDisplayed = date("Y-m-d", strtotime("-1 day", strtotime($_GET["day"])));
} elseif (isset($_GET["move"]) &&$_GET['move'] == "next") {
    $dayDisplayed = date("Y-m-d", strtotime("+1 day", strtotime($_GET["day"])));
} elseif (isset($_GET["day"])){
    $dayDisplayed = $_GET["day"];
} elseif (isset($_POST["input-dateSubmit"])) {
    $dayDisplayed = $_POST["input-dateSubmit"];
} else {
    $dayDisplayed = date("Y-m-d");
}


// ||||||||||||||||||||||||||||||||||||||| BRISANJE REZERVACIJE |||||||||||||||||||||||||||||||||||||||
if(isset($_GET["task"]) && $_GET["task"] == "del")
{
    $IDr = (int)$_GET["IDr"];
    $IDr = mysqli_real_escape_string($con, $IDr);

    $query_del = "DELETE FROM reservation WHERE IDReservation = '$IDr'";

    $result_del = mysqli_query($con, $query_del);


    if($result_del)
    {
        // header('Location: reservations.php');
        // exit;
        echo '
        <script>
        function redirectToReservations() {
            var reservationsURL = "reservations.php?day='.$_GET["day"].'";
            window.location.href = reservationsURL;
        }
        redirectToReservations();
        </script>
        ';
    }
    else
    {
        echo 'Greska kod brisanja. Pokusajte ponovo';
    }
}


// ||||||||||||||||||||||||||||||||||||||| HEADER VRIJME |||||||||||||||||||||||||||||||||||||||

// pretvara se u format po zelji
$dayDisplayedMyFormat = dateToCroatianFormat($dayDisplayed);

$dayOfWeekEnglish = dateToDaysOfWeekEnglish($dayDisplayedMyFormat);

$dayOfWeekCroatian = dateToDaysOfWeekCroatian($dayDisplayedMyFormat);

// ||||||||||||||||||||||||||||||||||||||| BROD IKONA PROMJENA BOJE |||||||||||||||||||||||||||||||||||||||
$day = (int)explode("-", $dayDisplayed)[2];

if ($day % 2 == 1) {
    // If the day is odd
    $boatColor = "#f89b3e";
} else {
    // If the day is even
    $boatColor = "#107ec9";
}


// ||||||||||||||||||||||||||||||||||||||| QUERY SELECT ||||||||||||||||||||||||||||||||||||||||
$query = "SELECT 
            reservation.IDReservation,
            boat.Name AS BoatName,
            boat.IDBoat AS IDBoat,
            reservation.StartDate AS StartDate,
            reservation.FinishDate AS FinishDate,
            reservation.StartTime AS StartTime,
            reservation.FinishTime AS FinishTime,
            reservation.Name AS ClientName,
            reservation.Surname AS ClientSurname,
            reservation.TelNum AS ClientTenNum,
            reservation.OIB AS ClientOIB,
            reservation.Price,
            reservation.AdvancePayment,
            reservation.PriceDiffrence,
            reservation.Deposit,
            reservation.CreatedDate,
            reservation.AdvancePaymentDate,
            reservation.PriceDiffrenceDate,
            reservation.DepositDate,
            employee.Username AS Employee,
            reservation.Note,
            reservation.Platform AS Platform,
            reservation.Departure AS Departure
            FROM reservation 
            LEFT JOIN boat ON (reservation.BoatID = boat.IDBoat)
            LEFT JOIN employee ON (reservation.EmployeeID = employee.IDEmployee)
            WHERE '$dayDisplayed' BETWEEN DATE(reservation.StartDate) AND DATE(reservation.FinishDate)
            ORDER BY boat.IDBoat ASC";

$result = mysqli_query($con, $query);

$booked_slots = array();


// ||||||||||||||||||||||||||||||||||||||| OBRADA PODATAKA |||||||||||||||||||||||||||||||||||||
while($row = mysqli_fetch_assoc($result))
{
    $IDReservation = $row['IDReservation'];
    $BoatName = $row['BoatName'];
    $IDBoat = $row['IDBoat'];
    $StartDate = $row['StartDate'];
    $FinishDate = $row['FinishDate'];
    $StartTime = $row['StartTime'];
    $FinishTime = $row['FinishTime'];
    $ClientName = $row['ClientName'];
    $ClientSurname = $row['ClientSurname'];
    $ClientTelNum = $row['ClientTenNum'];
    $ClientOIB = $row['ClientOIB'];
    $Price = $row['Price'];
    $AdvancePayment = $row['AdvancePayment'];
    $PriceDiffrence = $row['PriceDiffrence'];
    $Deposit = $row['Deposit'];
    $CreatedDate = $row['CreatedDate'];
    $AdvancePaymentDate = $row['AdvancePaymentDate'];
    $PriceDiffrenceDate = $row['PriceDiffrenceDate'];
    $DepositDate = $row['DepositDate'];
    $Employee = $row['Employee'];
    $Note = $row['Note'];
    $Platform = $row['Platform'];
    $Departure = $row['Departure'];

    // spustamo sve podatke u polje
    $booked_slots[] = array(
        'IDReservation' => $IDReservation,
        'BoatName' => $BoatName,
        'IDBoat' => $IDBoat,
        'StartDate' => $StartDate,
        'FinishDate' => $FinishDate,
        'StartTime' => $StartTime,
        'FinishTime' => $FinishTime,
        'ClientName' => $ClientName,
        'ClientSurname' => $ClientSurname,
        'ClientTelNum' => $ClientTelNum,
        'ClientOIB' => $ClientOIB,
        'Price' => $Price,
        'AdvancePayment' => $AdvancePayment,
        'PriceDiffrence' => $PriceDiffrence,
        'Deposit' => $Deposit,
        'CreatedDate' => $CreatedDate,
        'AdvancePaymentDate' => $AdvancePaymentDate,
        'PriceDiffrenceDate' => $PriceDiffrenceDate,
        'DepositDate' => $DepositDate,
        'Employee' => $Employee,
        'Note' => $Note,
        'Platform' => $Platform,
        'Departure' => $Departure
    );

}

// Dodavanje polja CardSlotPlace, TimeSlot, CardNumber u polje $booked_slots, te sortiranje po CardNumberu
$booked_slots = modifyArray($booked_slots, $lookup);

$cardFlag = array();

// ||||||||||||||||||||||||||||||||||||||| ISPIS KALENDARA |||||||||||||||||||||||||||||||||||||
echo '
<main  id="blur">
    <div class="spacer"></div>
    <div class="glass">
        <div class="header">
            <div class="flex-column">
                <div class="big-text m-title">Kalendar Rezervacija</div>
                <div class="flexcol-row">
                    <div class="big-text m-title" id="countdown"></div>
                    <a href="reservations.php" class="button-dateSubmit">Danas '.date("d.m.").'</a>
                </div>
            </div>
            <div class="date-wrapper">
                <div class="arrow">
                <a href="reservations.php?day='.$dayDisplayed.'&move=previous">
                <lord-icon class="arrow-icon rotate-arrow"
                    src="../icon/dateArrow.json"
                    trigger="loop-on-hover"
                    delay="500"
                    colors="primary:#F89B3E">
                </lord-icon>
                </a>
                </div>
                <form class="form-dateSubmit" method="POST" action="">
                    <input type="date" id="input-dateSubmit" name="input-dateSubmit" value="'.$dayDisplayed.'" class="input-dateSubmit big-text">
                    <input type="submit" name="input-buttonSubmit" value="Odaberi" class="button-dateSubmit">
                </form>
                    <div class="arrow">
                <a href="reservations.php?day='.$dayDisplayed.'&move=next">
                <lord-icon class="arrow-icon"
                    src="../icon/dateArrow.json"
                    trigger="loop-on-hover"
                    delay="500"
                    colors="primary:#F89B3E">
                </lord-icon>
                </a>
                </div>
            </div>
            <div class="big-text fix-width">'.$dayOfWeekCroatian.' / '.$dayOfWeekEnglish.'</div>
        </div>
        <div class="grid">
            ';

            // Stavljamo sve u arrayu na false
            $cardFlag = array_fill(1, 16, false);

            $previousCardClass = '';

            // Prolazimo kroz sve kartice
            for($cardIndex = 1; $cardIndex <=16; $cardIndex++){
                $cardDisplayed = false;
                // Prolazimo kroz sve rezervacije
                foreach ($booked_slots as $key => $value) {
                    // Ako je dodjeljen broj kartice jednak trenutnom broju kartice
                    if($value['CardNumber'] == $cardIndex){
                        $cardFlag[$cardIndex] = true;

                        // make $value array in json format
                        $json = json_encode($value);

                        if($value['Platform'] == 1){
                            $platformClass = 'platform1';
                        }
                        elseif($value['Platform'] == 2){
                            $platformClass = 'platform2';
                        }
                        else{
                            $platformClass = '';
                        }
                        
                        // Ako je rezervacija na cijeli dan, onda je kartica extended
                        if($value['TimeSlot'] == 3 && $value['CardNumber'] < 8){
                            // Koristi se cudan echo zbog parsiranja jsona
                            echo <<<EOT
                                    <div class="card extended $platformClass" id="card'.$cardIndex.'" onclick='popup(`$json`)'>
                                    EOT;
                        }
                        else{
                            echo <<<EOT
                                    <div class="card $platformClass" id="card'.$cardIndex.'" onclick='popup(`$json`)'>
                                    EOT;
                        }

                            echo '
                            <div class="card-grid">
                                <div class="col">
                                    <div class="card-title">'.$value['BoatName'].' - '.$value['ClientName'].'</div>
                                    <div class="card-time">Od: '.$value['StartTimeH'].':'.$value['StartTimeM'].'h do '.$value['FinishTimeH'].':'.$value['FinishTimeM'].'h</div>
                                    <div class="card-time">Od: '.dateToCroatianFormatNoYear($value['StartDate']).' do '.dateToCroatianFormatNoYear($value['FinishDate']).'</div>
                                    <div class="flex">
                                        <div>Status:</div>
                                        ';
                                        if($value['Departure'] == 1){
                                            echo '<div class="status in-progress"></div>';
                                            echo '<div>Isplovio</div>';
                                        }
                                        else{
                                            echo '<div class="status dead"></div>';
                                            echo '<div>Rezerviran</div>';
                                        }
                                        echo'
                                    </div>
                                </div>
                                <div class="col col-hidden">
                                    <div class="card-textrow"><b>Ime i prezime:</b></div>
                                    <div>'.$value['ClientName'].' '.$value['ClientSurname'].'</div>
                                    <div class="card-textrow"><b>Telefon:</b></div>
                                    <div>'.$value['ClientTelNum'].'</div>
                                    <div class="card-textrow"><b>Rezervirao:</b> '.$value['Employee'].'</div>
                                </div>
                                <div class="col col-hidden col-special">
                                    <div> </div>
                                    <div class="card-textrow"><b>Cijena:</b></div>
                                    <div class="card-textrow"><b>Akontacija:</b></div>
                                    <div class="card-textrow"><b>Razlika:</b></div>
                                </div>
                                <div class="col col-hidden col-align">
                                    <div> </div>
                                    <div class="card-textrow">€'.$value['Price'].'</div>
                                    <div class="card-textrow">€'.$value['AdvancePayment'].'</div>
                                    <div class="card-textrow">€'.$value['PriceDiffrence'].'</div>
                                </div>
                                <div class="col2">
                                    <lord-icon class="card-icon-size"
                                        src="../icon/boat.json"
                                        target="div.card"
                                        trigger="loop-on-hover"
                                        colors="primary:#121331,secondary:'.$boatColor.'">
                                    </lord-icon>
                                </div>
                            </div>
                            </div>
                        ';
                        $cardDisplayed = true;
                        break;
                    }
                }
                if (!$cardDisplayed) {
                    foreach($lookup as $key => $value)
                    {
                        if($value['Card'] == $cardIndex)
                        {
                            // Check if the previous card had the class "extended"
                            if ($previousCardClass === 'extended') {
                                $currentCardClass = 'noclick'; // Replace "disabled" with "noclick"
                            } else {
                                $currentCardClass = ''; // No additional class for the current card
                            }
                            echo '
                            <a href="../addReservation/addReservation.php?BoatSelected='.$value['Card'].'&DateSelected='.$dayDisplayed.'" class="'.$currentCardClass.'">
                            <div class="card disabled " id="card'.$cardIndex.'">
                            <div class="card-grid">
                                <div class="col">
                                    <div class="card-title">'.$value['BoatName'].'</div>
                                    <div class="card-time">Od: h do h</div>
                                    <div class="card-time">Od:</div>
                                    <div class="flex">
                                        <div>Status:</div>
                                        <div class="status open"></div>
                                        <div>Slobodan</div>
                                    </div>
                                </div>
                                <div class="col col-hidden">
                                    <div class="card-textrow"><b>Ime i prezime:</b></div>
                                    <div></div>
                                    <div class="card-textrow"><b>Telefon:</b></div>
                                    <div></div>
                                    <div class="card-textrow"><b>Rezervirao:</b> </div>
                                </div>
                                <div class="col col-hidden col-special">
                                    <div> </div>
                                    <div class="card-textrow"><b>Cijena:</b></div>
                                    <div class="card-textrow"><b>Akontacije:</b></div>
                                    <div class="card-textrow"><b>Razlika:</b></div>
                                </div>
                                <div class="col col-hidden col-align">
                                    <div> </div>
                                    <div class="card-textrow">€</div>
                                    <div class="card-textrow">€</div>
                                    <div class="card-textrow">€</div>
                                </div>
                                <div class="col2">
                                    <lord-icon class="card-icon-size" onclick="popup()"
                                        src="../icon/boat.json"
                                        target="div.card"
                                        trigger="loop-on-hover"
                                        colors="primary:#121331,secondary:'.$boatColor.'">
                                    </lord-icon>
                                </div>
                            </div>
                            </div>
                            </a>
                        ';
                        }
                    }
                    
                }
                // Store the current card's class for the next iteration
                $previousCardClass = (isset($value['TimeSlot']) && $value['TimeSlot'] == 3 && $value['CardNumber'] < 8) ? 'extended' : '';
            }

            
            echo '
        </div>
    </div>

    <div class="spacer spacer-bottom"></div>
</main>

<div id="popup">
<div id="popupWindow">
    <div class="popup-icon-close-position">
        <a href="#" onclick="closepopup()">
        <lord-icon class="popup-icon-close"
            src="../icon/close.json"
            target="div#popup"
            trigger="loop-on-hover"
            delay="200">
        </lord-icon>
        </a>
    </div>
    <div class="popup-title h1" id="popupBoat">Orca</div>
    <div class="popup-col-flex">
        <div class="popup-col">
            <div class="popup-text" id="popupTime">Od: 00h do 00h</div>
            <div class="popup-text"  id="popupDate">Od datuma: 00.00.0000 <br> Do datuma: 00.00.0000</div>
        </div>
        <div class="popup-col popup-col-flex-mobile-icon">
            <lord-icon class="popup-icon-size"
                src="../icon/boat.json"
                trigger="loop-on-hover"
                delay="200"
                colors="primary:#121331,secondary:#f89b3e">
            </lord-icon>
            <a href="#" onclick="delete_popup()" class="button-delete">
            <lord-icon
                src="../icon/delete.json"
                target=".button-delete"
                trigger="loop-on-hover"
                delay="500"
                colors="primary:#da1a20"
                style="width:20px;height:20px">
            </lord-icon>
            <div class="button-text">Obriši</div>
            </a>
        </div>
    </div>
    <div class="popup-col-flex popup-col-flex-mobile">
        <div class="popup-col">
            <div class="popup-flex popup-text">
                <div><b>Ime i prezime:</b></div>
                <div id="popupNameSurname">Gorana Hadzivelkos</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>Telefon:</b></div>
                <div class="popup-flex">
                    <div id="popupTelNum">TEST</div>
                    <div></div>
                    <div class="tooltip-container">
                        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
                        <lord-icon
                            src="https://cdn.lordicon.com/enzmygww.json"
                            trigger="click"
                            colors="primary:#f89b3e"
                            state="hover-2"
                            style="width:24px;height:24px">
                        </lord-icon>
                        <span class="tooltip-text">Stisnite broj za direktan poziv.</span>
                    </div>
                </div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>OIB:</b></div>
                <div id="popupOib">00000000000</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>Rezervirao:</b></div>
                <div id="popupEmployee">TEST</div>
            </div>
        </div>
        <div class="popup-col">
            <div class="popup-flex popup-text">
                <div><b>Cijena:</b></div>
                <div id="popupPrice">€000</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>Akontacije:</b></div>
                <div id="popupAdvancePayment">€00</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>Razlika:</b></div>
                <div id="popupPriceDiffrence">€00</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>Depozit:</b></div>
                <div id="popupDeposit">€000</div>
            </div>
        </div>
    </div>
    <div class="popup-flex popup-text" style="padding: 0; margin-bottom: 30px;">
        <div><b>Bilješka:</b></div>
        <div id="popupNote">Jan</div>
    </div>
    <div class="popup-col-flex-buttons">
        <a href="" class="button-edit" id="editButton">
            <lord-icon
                src="../icon/editButton.json"
                target=".button-edit"
                trigger="loop-on-hover"
                delay="500"
                colors="primary:#337895"
                style="width:20px;height:20px">
            </lord-icon>
            <div class="button-text">Uredi Rezervaciju</div>
        </a>
    </div>
</div>
</div>

<!--
<div id="deleteWindow">
    <div class="deleteWindow-rows">
        <div class="popup-title h4">Potvrdi brisanje rezervacije</div>
        <div class="row">
            <div class="popup-col-flex-buttons">
                <div class="button-delete-deletePopup">
                    <lord-icon
                        src="../icon/delete.json"
                        target=".button-delete-deletePopup"
                        trigger="loop-on-hover"
                        delay="500"
                        colors="primary:#da1a20"
                        style="width:20px;height:20px">
                    </lord-icon>
                    <div class="button-text">Obriši</div>
                </div>  
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
-->

<button id="scrollToTop" class="scrollToTopArrow">
    <lord-icon
        src="../icon/dateArrow.json"
        trigger="loop"
        delay="500"
        colors="primary:#ffffff">
    </lord-icon>
</button>


';

/*
echo "<pre>";
print_r($booked_slots);
echo "</pre>";

echo "<pre>";
print_r($cardFlag);
echo "</pre>";
*/

include ("../header-footer/footer-reservations.php");
include ("../header-footer/footer.php");

?>