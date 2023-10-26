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

// Define current year
$currentYear = date("Y");

// Define current season
$seasonSartDate = $currentYear."-01-01";
$seasonEndDate = $currentYear."-12-20";

$data = array();

//* Rekodni najmodavac
// Query that finds number of reservations made by each employee from seasonSratDate to seasonEndDate (current season). And store the result in $rn array that has 2 columns: employeeUsername and NumberOfReservations
$rnQuery = "SELECT 
                    employee.Username AS employeeUsername,
                    COUNT(reservation.IDReservation) AS NumberOfReservations
                FROM reservation
                LEFT JOIN employee ON (reservation.EmployeeID = employee.IDEmployee)
                WHERE reservation.StartDate >= '$seasonSartDate' AND reservation.FinishDate <= '$seasonEndDate' AND reservation.Deleted = '0'
                GROUP BY employee.Username
                ORDER BY NumberOfReservations DESC;";
$rnResult = mysqli_query($con, $rnQuery);

$data['rn'] = array();
while($row = mysqli_fetch_array($rnResult)){
    $data['rn'][] = $row;
}

//* Vodeca platforma
// Query that finds number of reservations made by each platform from seasonSratDate to seasonEndDate (current season). And store the result in $vp array (There is no platform name, only platform column and data 0,1 or 2)
$vpQuery = "SELECT 
                    reservation.Platform AS platform,
                    COUNT(reservation.IDReservation) AS NumberOfReservations
                FROM reservation
                WHERE reservation.StartDate >= '$seasonSartDate' AND reservation.FinishDate <= '$seasonEndDate' AND reservation.Deleted = '0'
                GROUP BY reservation.Platform
                ORDER BY NumberOfReservations DESC;";
$vpResult = mysqli_query($con, $vpQuery);

// modify array vpResults so it has two colums: one is named platformName and depending on value it gets data (Platform 0 = Pult, 1 = SamBoat, 2 = Click&Boat), and another named NumberOfReservations
$vpResult = mysqli_fetch_all($vpResult, MYSQLI_ASSOC);
foreach($vpResult as $key => $value){
    if($value['platform'] == 0){
        $vpResult[$key]['platformName'] = "Pult";
    }else if($value['platform'] == 1){
        $vpResult[$key]['platformName'] = "SamBoat";
    }else if($value['platform'] == 2){
        $vpResult[$key]['platformName'] = "Click&Boat";
    }
    unset($vpResult[$key]['platform']);
}

$data['vp'] = array();
foreach($vpResult as $key => $value){
    $data['vp'][] = $value;
}

//* Najpopularniji brodovi
// Query that finds number of reservations each boat has from seasonSratDate to seasonEndDate (current season). And store the result in $bt array that has 2 columns: boatName and NumberOfReservations
$btQuery = "SELECT 
                    boat.Name AS boatName,
                    COUNT(reservation.IDReservation) AS NumberOfReservations
                FROM reservation
                LEFT JOIN boat ON (reservation.BoatID = boat.IDBoat)
                WHERE reservation.StartDate >= '$seasonSartDate' AND reservation.FinishDate <= '$seasonEndDate' AND reservation.Deleted = '0'
                GROUP BY boat.Name
                ORDER BY NumberOfReservations DESC;";
$btResult = mysqli_query($con, $btQuery);

$data['bt'] = array();
while($row = mysqli_fetch_array($btResult)){
    $data['bt'][] = $row;
}

//* Analiza najbolje sezone
// Query that finds number of reservations each week has from seasonSratDate to seasonEndDate (current season). And store the result in $anz array that has 2 columns: weekNumber and NumberOfReservations
$anzQuery = "SELECT 
                    WEEK(reservation.StartDate) AS weekNumber,
                    COUNT(reservation.IDReservation) AS NumberOfReservations
                FROM reservation
                WHERE reservation.StartDate >= '$seasonSartDate' AND reservation.FinishDate <= '$seasonEndDate' AND reservation.Deleted = '0'
                GROUP BY WEEK(reservation.StartDate)
                ORDER BY NumberOfReservations DESC;";
$anzResult = mysqli_query($con, $anzQuery);


$data['anz'] = array();
while($row = mysqli_fetch_array($anzResult)){
    $data['anz'][] = $row;
}

$randomNumber = rand();

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<main id="blur">
    <div class="spacer"></div>
    <div class="add-glass-container blurForClearFormPopup" id="blurForClearFormPopup">
        <!--DEPOSIT-->
        <div class="add-glass">

            <div class="add-title">Najpopularniji brodovi</div>
            <div class="add-panel add-panel-left">
            <canvas id="bt-chart" style="width:100%;max-width:600px"></canvas>
            </div>

            <div class="add-title">Vodeća platforma</div>
            <div class="add-panel add-panel-left">
                <canvas id="vp-chart" style="width:100%;max-width:600px"></canvas>
            </div>

            
        </div>

        <!--AKONTACIJE-->
        
        <div class="add-glass">

            <div class="add-title">Rekordni najmodavac</div>
            <div class="add-panel add-panel-left">
                <canvas id="nd-chart" style="width:100%;max-width:600px"></canvas>
            </div>

            <div class="add-title">Analiza najbolje sezone</div>
            <div class="add-panel add-panel-left">
                <canvas id="anz-chart" style="width:100%;max-width:600px"></canvas>
            </div>

            <!-- <div class="add-title">Top 5 država klijenata</div>
            <div class="add-panel add-panel-left">
                <canvas id="drzave-chart" style="width:100%;max-width:600px"></canvas>
            </div> -->
        </div>

        <!-- DNEVNI-->
        
    </div>

    <div class="spacer-bottom"></div>
    <div class="spacer-bottom"></div>
    <div class="spacer-bottom"></div>
</main>

<?php

echo '<script src="../js/statistics.js?='.$randomNumber.'"></script>'

?>
<script>
    var phpData = <?php echo json_encode($data); ?>;
</script>
<?php
include ("../header-footer/footer.php");
?>