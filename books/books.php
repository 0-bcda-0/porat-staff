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

date_default_timezone_set("Europe/Zagreb");

$queryDeposit = "SELECT 
                    reservation.*,
                    boat.Name AS BoatName
                FROM reservation
                LEFT JOIN boat ON (reservation.BoatID = boat.IDBoat)
                WHERE reservation.DepositStatus = '1'
                ORDER BY reservation.FinishDate ASC;";
$resultDeposit = mysqli_query($con, $queryDeposit);

$queryAdvancePayment = "SELECT 
                            reservation.*,
                            boat.Name AS BoatName
                            FROM reservation
                            LEFT JOIN boat ON (reservation.BoatID = boat.IDBoat)
                            WHERE reservation.AdvancePaymentStatus = '1'
                            ORDER BY reservation.StartDate ASC;";
$resultAdvancePayment = mysqli_query($con, $queryAdvancePayment);

// Create DepositSum variable that will be used to calculate the sum of all deposits from the database
$depositSum = 0;
$advancePaymentSum = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['DepositSubmitButton'])) {
    $reservationId = $_POST['reservationId'];
    
    // Update the DepositStatus to 0 for the selected reservation
    $updateQuery = "UPDATE reservation SET DepositStatus = '2' WHERE IDReservation = '$reservationId'";
    $updateResult = mysqli_query($con, $updateQuery);
    
    if ($updateResult) {
        echo '<script type="text/javascript">window.location.replace("books.php");</script>';
    } else {
        // Handle error, if the update query fails
        echo '<script type="text/javascript">alert("Greška prilikom vraćanja akontacije!");</script>';
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AdvancePaymentSubmitButton'])) {
    $reservationId = $_POST['reservationId'];
    
    // Update the AdvancePaymentStatus to 0 for the selected reservation
    $updateQuery = "UPDATE reservation SET AdvancePaymentStatus = '2' WHERE IDReservation = '$reservationId'";
    $updateResult = mysqli_query($con, $updateQuery);
    
    if ($updateResult) {
        echo '<script type="text/javascript">window.location.replace("books.php");</script>';
    } else {
        // Handle error, if the update query fails
        echo '<script type="text/javascript">alert("Greška prilikom vraćanja akontacije!");</script>';
    }
}


?>

<main id="blur">
    <div class="spacer"></div>
    <div class="add-glass-container blurForClearFormPopup" id="blurForClearFormPopup">
        <!--DEPOSIT-->
        <div class="add-glass">

            <div class="add-title">Deposit</div>

            <div class="add-panel add-panel-left">
                <table>
                    <thead>
                        <th class="books-th">DZR</th>
                        <th class="books-th">Rezervacija</th>
                        <th class="books-th">Iznos</th>
                        <th class="books-th">Akcija</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowDeposit = mysqli_fetch_array($resultDeposit)) {
                            $depositSum += $rowDeposit['Deposit'];
                            if($rowDeposit['FinishDate'] == date('Y-m-d') || $rowDeposit['FinishDate'] < date('Y-m-d')){
                                $classRedDeposit = 'red';
                            } else {
                                $classRedDeposit = 'NiJeReD';
                            }
                            echo '<tr class="'.$classRedDeposit.'">';
                                echo '<td>'. dateToCroatianFormatNoYear($rowDeposit['FinishDate']) . '</td>';
                                echo '<td>'.$rowDeposit['BoatName'].' - '.$rowDeposit['Name'].'</td>';
                                echo '<td>€'. $rowDeposit['Deposit'] .'</td>';
                                echo '<td>
                                        <form id="depositForm" method="POST" action="">
                                            <input type="hidden" name="reservationId" value="' . $rowDeposit['IDReservation'] . '">
                                            <input type="submit" id="DepositSubmitButton" value="Vraćen" class="add-button-rezerviraj" name="DepositSubmitButton" style="font-size:14px;">
                                        </form>
                                    </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div>*DZR - Datum Završetka Rezervacije</div>
                <div class="add-input-title">Ukupno:  €<?php echo $depositSum; ?></div>

            </div>
        </div>

        <!--AKONTACIJE-->
        
        <div class="add-glass">

            <div class="add-title">Akontacija</div>

            <div class="add-panel add-panel-left">
                <table>
                    <thead>
                        <th>DPR</th>
                        <th>Rezervacija</th>
                        <th>Iznos</th>
                        <th>Akcija</th>
                    </thead>
                    <tbody>
                        <?php
                        while ($rowAdvancePayment = mysqli_fetch_array($resultAdvancePayment)) {
                            $advancePaymentSum += $rowAdvancePayment['AdvancePayment'];
                            if($rowAdvancePayment['StartDate'] == date('Y-m-d')){
                                $classRedAdvancedPayment = 'red';
                            } else {
                                $classRedAdvancedPayment = 'NiJeReD';
                            }
                            echo '<tr class="'.$classRedAdvancedPayment.'">';
                                echo '<td>' . dateToCroatianFormatNoYear($rowAdvancePayment['StartDate']) . '</td>';
                                echo '<td>'.$rowAdvancePayment['BoatName'].' - '.$rowAdvancePayment['Name'].'</td>';
                                echo '<td>€'. $rowAdvancePayment['AdvancePayment'] .'</td>';
                                echo '<td>
                                        <form id="depositForm" method="POST" action="">
                                            <input type="hidden" name="reservationId" value="' . $rowAdvancePayment['IDReservation'] . '">
                                            <input type="submit" id="AdvancePaymentSubmitButton" value="Prebacen" class="add-button-rezerviraj" name="AdvancePaymentSubmitButton" style="font-size:13px;">
                                        </form>
                                    </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div>*DZR - Datum Početka Rezervacije</div>
                <div class="add-input-title">Ukupno:  €<?php echo $advancePaymentSum; ?></div>
            </div>
        </div>

        <!-- DNEVNI-->
        
    </div>

    <div class="spacer-bottom"></div>
    <div class="spacer-bottom"></div>
    <div class="spacer-bottom"></div>
</main>
