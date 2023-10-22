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

if(!isset($_SESSION['IDEmployee']))
{
    // header("Location: ../index.php");
    // exit;
    echo '
        <script>
        function redirectToReservations() {
            var reservationsURL = "../index.php";
            window.location.href = reservationsURL;
        }
        redirectToReservations();
        </script>
    ';
}

//1 - Obicni korisnik i demo korisnik
if($_SESSION["Level"] !== '0')
{
    echo '
        <script>
        function redirectToReservations() {
            var reservationsURL = "../reservations/reservations.php";
            window.location.href = reservationsURL;
        }
        redirectToReservations();
        </script>
    ';
}

?>

<!-- load map -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.2/leaflet.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.2/leaflet.js"></script>

<div id="map"></div>
<div class="con">
Odaberite brod: <select id="units" class="dropdown"><option></option></select>
<!-- <div id="log"></div> -->
</div>

    <script src="script.js"></script>
</body>
</html>

<?php

include ("../header-footer/footer.php");

?>