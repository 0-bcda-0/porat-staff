<?php

// Universal header
include ("../header-footer/header.php");
// Navigation
include ("../navigation/navigation.php");
// Konekcija na bazu
include("../PHP/db_connection.php");
// Konfiguracija
include("../PHP/conf.php");


// ||||||||||||||||||||||||||||||||||||||| HEADER VRIJME |||||||||||||||||||||||||||||||||||||||
// vuce se trenutni datum
$dayDisplayed = date("2022-12-23");

// pretvara se u format po zelji
$dayDisplayedMyFormat = date("d.m.Y", strtotime($dayDisplayed));

// stvara se varijabla koja ce se koristiti za prikaz dana u engleskom formatu
$dayOfWeekEnglish = date("l", strtotime($dayDisplayedMyFormat));
// stvara se polje hrvatskih dana
$CroatianDays = ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota'];
// pretvaramo u timestamp, zatim sa "w" dobivamo broj dana u tjednu, a sa tim brojem dobivamo hrvatski naziv dana preko polja
$dayOfWeekCroatian = $CroatianDays[date("w", strtotime($dayDisplayedMyFormat))];




// ||||||||||||||||||||||||||||||||||||||| QUERY SELECT ||||||||||||||||||||||||||||||||||||||||
$query = "SELECT 
            reservation.IDReservation,
            boat.Name AS BoatName,
            boat.IDBoat AS IDBoat,
            DATE(reservation.StartDateTime) AS StartDate,
            DATE(reservation.FinishDateTime) AS FinishDate,
            TIME(reservation.StartDateTime) AS StartTime,
            TIME(reservation.FinishDateTime) AS FinishTime,
            client.Name AS ClientName,
            client.Surname AS ClientSurname,
            client.TelNum AS ClientTenNum,
            client.OIB AS ClientOIB,
            reservation.Price,
            reservation.AdvancePayment,
            reservation.PriceDiffrence,
            employee.Username AS Employee
            FROM reservation 
            LEFT JOIN boat ON (reservation.BoatID = boat.IDBoat)
            LEFT JOIN employee ON (reservation.EmployeeID = employee.IDEmployee)
            LEFT JOIN client ON (reservation.ClientID = client.IDClient)
            WHERE '$dayDisplayed' BETWEEN DATE(reservation.StartDateTime) AND DATE(reservation.FinishDateTime)
            ORDER BY boat.IDBoat ASC";

$result = mysqli_query($con, $query);

$booked_slots = array();


// ||||||||||||||||||||||||||||||||||||||| OBRADA PODATAKA |||||||||||||||||||||||||||||||||||||
while($row = mysqli_fetch_assoc($result))
{
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
    $Employee = $row['Employee'];

    // spustamo sve podatke u polje
    $booked_slots[] = array(
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
        'Employee' => $Employee
    );

}


for ($i=0; $i < count($booked_slots); $i++) { 
    // cupamo samo sate iz vremena
    $booked_slots[$i]['StartTimeH'] = date("H", strtotime($booked_slots[$i]['StartTime']));
    $booked_slots[$i]['FinishTimeH'] = date("H", strtotime($booked_slots[$i]['FinishTime']));

    // dodjeljujemo dodatna pomocna polja za lakse racunanje pozicije rezervacije
    if ($booked_slots[$i]['FinishTimeH'] < 16) {
        $booked_slots[$i]['TimeSlot'] = 1;
        $booked_slots[$i]['CardSlotPlace'] = 1;
    }
    else if ($booked_slots[$i]['StartTimeH'] > 12 && $booked_slots[$i]['FinishTimeH'] < 22) {
        $booked_slots[$i]['TimeSlot'] = 2;
        $booked_slots[$i]['CardSlotPlace'] = 2;
    }
    else if ($booked_slots[$i]['StartTimeH'] < 13 && $booked_slots[$i]['FinishTimeH'] < 22) {
        $booked_slots[$i]['TimeSlot'] = 3;
        $booked_slots[$i]['CardSlotPlace'] = 1;
    }


    // RUCNO IZRADENO

    /*
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 1) {
        $booked_slots[$i]['CardNumber'] = 1;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 2 && $booked_slots[$i]['IDBoat'] == 1) {
        $booked_slots[$i]['CardNumber'] = 2;
    }

    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 2) {
        $booked_slots[$i]['CardNumber'] = 3;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 2 && $booked_slots[$i]['IDBoat'] == 2) {
        $booked_slots[$i]['CardNumber'] = 4;
    }

    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 3) {
        $booked_slots[$i]['CardNumber'] = 5;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 2 && $booked_slots[$i]['IDBoat'] == 3) {
        $booked_slots[$i]['CardNumber'] = 6;
    }

    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 4) {
        $booked_slots[$i]['CardNumber'] = 7;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 2 && $booked_slots[$i]['IDBoat'] == 4) {
        $booked_slots[$i]['CardNumber'] = 8;
    }

    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 5) {
        $booked_slots[$i]['CardNumber'] = 9;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 6) {
        $booked_slots[$i]['CardNumber'] = 10;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 7) {
        $booked_slots[$i]['CardNumber'] = 11;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 8) {
        $booked_slots[$i]['CardNumber'] = 12;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 9) {
        $booked_slots[$i]['CardNumber'] = 13;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 10) {
        $booked_slots[$i]['CardNumber'] = 14;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 11) {
        $booked_slots[$i]['CardNumber'] = 15;
    }
    if($booked_slots[$i]['CardSlotPlace'] == 1 && $booked_slots[$i]['IDBoat'] == 12) {
        $booked_slots[$i]['CardNumber'] = 16;
    }
    */
}

// Optimizirani nacin za izracunavanje pozicije rezervacije na kartici
// Tu se referencira sad na $lookup u config.php i iz njega uzima vrijednosti
for ($i = 0; $i < count($booked_slots); $i++) {
    foreach ($lookup as $cardNumber => $values) {
        if ($booked_slots[$i]['CardSlotPlace'] == $values['CardSlotPlace'] && $booked_slots[$i]['IDBoat'] == $values['IDBoat']) {
            $booked_slots[$i]['CardNumber'] = $cardNumber;
            break;
        }
    }
}

// TIMESLOT 1 = 1/2 dana prva poloovica
// TIMESLOT 2 = 1/2 dana druga polovica
// TIMESLOT 3 = cijeli dan

// CARD SLOT PLACE 1 = Lijeva Kartica
// CARD SLOT PLACE 2 = Desna Kartica

// Sortiranje $booked_slots po CardNumberu
usort($booked_slots, function($a, $b) {
    return $a['CardNumber'] <=> $b['CardNumber'];
});

// Milim da mi u krajnjoj linijij ovo ne sluzi nicem osim za provjeru
$cardFlag = array();

// ||||||||||||||||||||||||||||||||||||||| ISPIS KALENDARA |||||||||||||||||||||||||||||||||||||
echo '
<main  id="blur">
    <div class="spacer"></div>
    <div class="glass">
        <form action="#" method="POST" class="header">
            <div class="big-text m-title">Kalendar rezervacija</div>
            <div class="date-wrapper">
                <div class="arrow">
                <button type="submit" name="DateNavButtonLeft" style="align-items: normal; background-color: transparent; border: none; box-sizing: border-box; color: inherit; cursor: default; display: inline; flex-shrink: 0; font: inherit; font-size: 100%; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; margin: 0; outline: none; overflow: visible; padding: 0; text-align: start; text-decoration: none; text-indent: 0; text-overflow: clip; text-shadow: none; text-transform: none; white-space: normal; width: auto;">
                <lord-icon class="arrow-icon rotate-arrow"
                    src="../icon/dateArrow.json"
                    trigger="click"
                    delay="500"
                    colors="primary:#F89B3E">
                </lord-icon>
                </button>
                </div>
                <div class="big-text" id="TitleDate">'.$dayDisplayedMyFormat.'</div>
                <div class="arrow">
                <button type="submit" name="DateNavButtonRight" style="align-items: normal; background-color: transparent; border: none; box-sizing: border-box; color: inherit; cursor: default; display: inline; flex-shrink: 0; font: inherit; font-size: 100%; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; margin: 0; outline: none; overflow: visible; padding: 0; text-align: start; text-decoration: none; text-indent: 0; text-overflow: clip; text-shadow: none; text-transform: none; white-space: normal; width: auto;">
                    <lord-icon class="arrow-icon"
                        src="../icon/dateArrow.json"
                        trigger="click"
                        delay="500"
                        colors="primary:#F89B3E">
                    </lord-icon>
                </button>
                </div>
            </div>
            <div class="big-text">'.$dayOfWeekCroatian.' / '.$dayOfWeekEnglish.'</div>
        </form>
        <div class="grid">
            ';

            // Stavljamo sve u arrayu na false
            $cardFlag = array_fill(1, 16, false);
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

                        echo '
                            <div class="card">
                            <div class="card-grid">
                                <div class="col">
                                    <div class="card-title">'.$value['BoatName'].'</div>
                                    <div class="card-time">Od: '.$value['StartTimeH'].'h do '.$value['FinishTimeH'].'h</div>
                                    <div class="flex">
                                        <div>Status:</div>
                                        <div class="status open"></div>
                                        <div>Rezerviran</div>
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
                                    <div class="card-textrow"><b>Akontacije:</b></div>
                                    <div class="card-textrow"><b>Razlika:</b></div>
                                </div>
                                <div class="col col-hidden col-align">
                                    <div> </div>
                                    <div class="card-textrow">€'.$value['Price'].'</div>
                                    <div class="card-textrow">€'.$value['AdvancePayment'].'</div>
                                    <div class="card-textrow">€'.$value['PriceDiffrence'].'</div>
                                </div>
                                <div class="col2">';
                                    echo <<<EOT
                                            <lord-icon class="card-icon-size" onclick='popup(`$json`)'
                                            EOT;
                                    echo '
                                        src="../icon/boat.json"
                                        trigger="click"
                                        colors="primary:#121331,secondary:#f89b3e">
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
                    echo '
                            <div class="card">
                            <div class="card-grid">
                                <div class="col">
                                    <div class="card-title"></div>
                                    <div class="card-time">Od: h do h</div>
                                    <div class="flex">
                                        <div>Status:</div>
                                        <div class="status open"></div>
                                        <div>Rezerviran</div>
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
                                        trigger="click"
                                        colors="primary:#121331,secondary:#f89b3e">
                                    </lord-icon>
                                </div>
                            </div>
                            </div>
                        ';
                }
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
            <div class="popup-text" id="popupTime">Od: 08h do 13h</div>
            <div class="popup-text"  id="popupDate">Od datuma: 20.08.2023 <br> Do datuma: 23.08.2023</div>
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
                <div id="popupTelNum">+385 99 5921 212</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>OIB:</b></div>
                <div id="popupOib">25485698745</div>
            </div>
        </div>
        <div class="popup-col">
            <div class="popup-flex popup-text">
                <div><b>Cijena:</b></div>
                <div id="popupPrice">€150</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>Akontacije:</b></div>
                <div id="popupAdvancePayment">€50</div>
            </div>
            <div class="popup-flex popup-text">
                <div><b>Razlika:</b></div>
                <div id="popupPriceDiffrence">€100</div>
            </div>
        </div>
    </div>
    <div class="popup-flex popup-text" style="padding: 0; margin-bottom: 30px;">
        <div><b>Rezervirao:</b></div>
        <div id="popupEmployee">Jan</div>
    </div>
    <div class="popup-col-flex-buttons">
        <div class="button-edit">
            <lord-icon
                src="../icon/editButton.json"
                target=".button-edit"
                trigger="loop-on-hover"
                delay="500"
                colors="primary:#337895"
                style="width:20px;height:20px">
            </lord-icon>
            <div class="button-text">Uredi Rezervaciju</div>
        </div>
    </div>
</div>
</div>

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