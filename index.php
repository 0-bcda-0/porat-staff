<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();

// Set session timeout to a very high value
$sessionTimeout = 60 * 60 * 24 * 365 * 10; // 10 years in seconds

// Check if the session is still active
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessionTimeout)) {
    // Session has expired due to inactivity, so destroy it
    session_unset();     // Unset $_SESSION variable for the run-time 
    session_destroy();   // Destroy session data in storage
}

// Update the last activity timestamp
$_SESSION['LAST_ACTIVITY'] = time();

// Regenerate session ID periodically to enhance security
$sessionRegenerateTime = 60 * 60 * 24 * 30; // 30 days in seconds

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > $sessionRegenerateTime) {
    // Regenerate session ID
    session_regenerate_id(true);    // Change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // Update creation time
}


$_SESSION['NWD'] = 'js';
$_SESSION["NWDScript-reservations"] = '<script src="../js/reservations.js"></script>';
$_SESSION["NWDScript-addReservation"] = '<script src="../js/addReservation.js"></script>';

include("PHP/db_connection.php");

echo'
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="color-scheme" content="light only">
    
        <!-- Bootstrap CSS -->
        <link href="css/login.css" rel="stylesheet">
        <!-- <link href="../css/background.css" rel="stylesheet"> -->
        <link href="reservations/reservations.css" rel="stylesheet">

        <!-- PWA - Web Aplication  -->
        <link rel="manifest" href="manifest.json">
        <meta name="theme-color" content="#F89B3E">
        <link rel="apple-touch-icon" href="img/Logo-192.png">

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

        <!-- Navigacija ikone -->
    
        <title>Rent a boat Porat</title>
        <link rel = "icon" href = "img/Icon.ico" type = "image/x-icon">

    </head>

<body>
    <main id="blurForErrorFormPopup" class="blurForClearFormPopup">
        <div class="container" >
            <div class="logo">
                <img src="img/FullLogo.png" alt="Porat Logo" width="250px">
            </div>
            <div class="box">
            <form method="POST" action="#">
                <div class="field">
                    <input type="text" name="frm_u2" class="input input-top" placeholder="Username" value="" />
                    <!-- <label for="frm_u2" class="label">Username</label> -->
                </div>
        
                <div class="field">
                    <input type="password" name="bgh_u1" class="input input-bottom" placeholder="Pin"pattern="\d{4,6}" maxlength="6" inputmode="numeric" value=""/>
                    <!-- <label for="bgh_u1" class="label">Pin</label> -->
                </div>
                <div class="buttonFrame">
                    <!-- a element je privremen dok se ne poveze PHP i SQL -->
                    <input type="submit" name="submit" value="Login" class="button">
                </div>
            </form>
            </div>
        </div>
    </main>
    <div id="errorPopup" class="clearFormPopup">
        <div class="deleteWindow-rows">
            <div class="popup-title h4">Krivi username ili pin.</div>
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
</body>

<script src="js/login.js"></script>
<script src="pwa.js"></script>
<script src="js/background.js"></script>
</html>
';

if (isset($_POST['frm_u2'])) {
    $username = $_POST['frm_u2'];
    $pin = $_POST['bgh_u1'];

    // $query = "SELECT * FROM employee WHERE Username = ? AND Pin = ? LIMIT 1";
    $query = "SELECT * FROM employee WHERE Username = '".$username."' AND Pin = '".$pin."'";
    $result = mysqli_query($con, $query);

    $br_rows = mysqli_num_rows($result);

    if($br_rows <= 0)
    {
        echo '<script type="text/javascript">';
        echo 'popup();';
        echo '</script>';
    }
    else
    {
        $korisnik = mysqli_fetch_assoc($result);

        $_SESSION['Level'] = $korisnik["Level"];
        $_SESSION['IDEmployee'] = $korisnik["IDEmployee"];
        //header("Location: reservations/reservations.php");
        echo '
        <script>
        function redirectToReservations() {
            var reservationsURL = "reservations/reservations.php";
            window.location.href = reservationsURL;
        }
        redirectToReservations();
        </script>
        ';

    }
}

?>