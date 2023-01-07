<?php

session_start();

$_SESSION['NWD'] = 'js';
$_SESSION["NWDScript-reservations"] = '<script src="../js/reservations.js"></script>';
$_SESSION["NWDScript-addReservation"] = '<script src="../js/addReservation.js"></script>';

include("PHP/db_connection.php");

// if(isset($_POST['username'])){
//     $username = $_POST['username'];
//     $pin = $_POST['pin'];

//     $query = "SELECT * FROM employee WHERE Username = '".$username."' AND Pin = '".$pin."' limit 1";

//     $result = mysqli_query($con, $query);

//     if(mysqli_num_rows($result) == 1){
//         header("Location: reservations/reservations.php");
//     }else{
//         echo "Wrong username or pin";
//     }
// }


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
        <link rel="stylesheet" href="css/watermark-remove.css">
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
                    <input type="text" name="frm_u2" class="input" placeholder=" " value="" />
                    <label for="frm_u2" class="label">Username</label>
                </div>
        
                <div class="field">
                    <input type="password" name="bgh_u1" class="input" placeholder=" "pattern="\d{4,6}" maxlength="6" inputmode="numeric" value=""/>
                    <label for="bgh_u1" class="label">Pin</label>
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
        // print_r($_SERVER['Level']);
        header("Location: reservations/reservations.php");
    }
}

?>