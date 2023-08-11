<?php

include("../header-footer/header.php");
include("../navigation/navigation.php");

include("../PHP/db_connection.php");

//1 - Obicni korisnik
if($_SESSION["Level"] === '1')
{
    // header("Location: ../reservations/reservations.php");

    if(isset($_POST["btn-prijava"])){
        $prijava = $_POST["prijava"];
        // insert into Text and EmployeeID
        $query = "INSERT INTO bugs (Text, EmployeeID) VALUES ('".$prijava."', '".$_SESSION["IDEmployee"]."')";
        $result = mysqli_query($con, $query);
        if($result){
            echo '<script>alert("Uspješno ste podnijeli prijavu!")</script>';
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo '<script>alert("Greška prilikom podnošenja prijave!")</script>';
        }
    }

    if(isset($_POST["btn-pin"])){
        $cPin = $_POST["user-cPin"];
        $nPin = $_POST["user-nPin"];

        $query = "SELECT * FROM employee WHERE IDEmployee = '".$_SESSION["IDEmployee"]."' AND Pin = '".$cPin."'";
        $result = mysqli_query($con, $query);
        $br_rows = mysqli_num_rows($result);

        if($br_rows <= 0){
            echo '<script>alert("Krivi pin!")</script>';
        }
        else{
            $query = "UPDATE employee SET Pin = '".$nPin."' WHERE IDEmployee = '".$_SESSION["IDEmployee"]."'";
            $result = mysqli_query($con, $query);
            if($result){
                echo '
                <script>
                function redirectToReservations() {
                    var reservationsURL = "settings.php";
                    window.location.href = reservationsURL;
                }
                redirectToReservations();
                </script>
                ';
                //header("Location: settings.php");
            }
            else{
                echo '<script>alert("Greška prilikom promjene pin-a!")</script>';
            }
        }
    }

    echo '
    <main id="blurForErrorFormPopup" class="blurForClearFormPopup">
        <div class="spacer"></div>
            <div class="glass">
                <div class="set-flex">
                    <div class="set-container w45">
                        <div class="set-title">Prijava problema</div>
                        <form method="POST" action="" class="set-userFormContainer">
                            
                                <label for="prijava" class="col-black">Sto Vam se nije svidjelo?</label>
                                <textarea id="prijava" name="prijava" value="" class="set-inputField w90 h"></textarea>
                            
                            <input type="submit" value="Podnesi prijavu" class="add-button-rezerviraj" name="btn-prijava">
                        </form>
                    </div>
                    <div class="set-container w45">
                        <div class="set-title">Promjena pina</div>
                        <form method="POST" action="" class="set-formContainer">
                            <div class="set-inputFlex">
                                <label for="user-cPin" class="col-black">Stari pin:</label>
                                <input type="password" id="user-cPin" name="user-cPin" value="" class="set-inputField" pattern="\d{4,6}" maxlength="6" inputmode="numeric">
                            </div>
                            <div class="set-inputFlex">
                                <label for="user-nPin" class="col-black">Novi pin:</label>
                                <input type="password" id="user-nPin" name="user-nPin" value="" class="set-inputField" pattern="\d{4,6}" maxlength="6" inputmode="numeric">
                            </div>
                            <input type="submit" value="Spremi promjene" class="add-button-rezerviraj" name="btn-pin">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer spacer-bottom"></div>
    </main>

    <div id="errorPopup" class="clearFormPopup">
        <div class="deleteWindow-rows">
            <div class="popup-title h4">Greška prilikom promjene pina!</div>
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
    ';

    echo '<script src="../js/settings.js"></script>';
}
//2 - Voditelj
else if($_SESSION["Level"] === '2')
{
    if(isset($_POST["btnNWD"])){
        if($_SESSION["NWD"] == "js"){
            $_SESSION["NWD"] = "jquery";
            $_SESSION["NWDScript-reservations"] = '<script src="../jquery/jquery-3.4.1.min.js"></script><script src="../jquery/Qreservations.js"></script>';
            $_SESSION["NWDScript-addReservation"] = '<script src="../jquery/jquery-3.4.1.min.js"></script><script src="../jquery/QaddReservation.js"></script>';
        }
        else{
            $_SESSION["NWD"] = "js";
            $_SESSION["NWDScript-reservations"] = '<script src="../js/reservations.js"></script>';
            $_SESSION["NWDScript-addReservation"] = '<script src="../js/addReservation.js"></script>';
        }
    }

    $queryLookup = "SELECT * FROM lookup";
    $resultLookup = mysqli_query($con, $queryLookup);

    
    // Auto fill form za uredjivanje lookup-a
    if(isset($_GET["Card"])){
        $Card = (int)$_GET["Card"];

        $Card = mysqli_real_escape_string($con, $Card);

        $queryLookup = "SELECT * FROM lookup WHERE Card = '$Card'";
        $resultLookup = mysqli_query($con, $queryLookup);

        $lookup = mysqli_fetch_assoc($resultLookup);

        $lookupCard = $lookup["Card"];
        $lookupName = $lookup["BoatName"];
        $lookupPrice = $lookup["BoatPrice"];

        $btnLookupForm = 'btnLookupEdit';
    }
    else{
        $Card = "";
        $lookupName = "";
        $lookupPrice = "";

        $btnLookupForm = 'btnLookupSave';
    }

    // Spremanje novog lookup-a
    if(isset($_POST["btnLookupSave"]))
    {
        $Card = mysqli_real_escape_string($con, $_POST["Card"]);
        $lookupName = mysqli_real_escape_string($con, $_POST["BoatName"]);
        $lookupPrice = mysqli_real_escape_string($con, $_POST["BoatPrice"]);

        $queryLookupSave = "INSERT INTO lookup (Card, BoatName, BoatPrice)
                        VALUES ('$Card', '$lookupName', '$lookupPrice')";
        
        $resultLookupSave = mysqli_query($con, $queryLookupSave);

        if($resultLookupSave)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
        }
    }

    // Uredjivanje lookup-a
    if(isset($_POST["btnLookupEdit"]))
    {
        $lookupName = mysqli_real_escape_string($con, $_POST["lookupName"]);
        $lookupPrice = mysqli_real_escape_string($con, $_POST["lookupPrice"]);

        $Card = (int)$_GET["Card"];
        $Card = mysqli_real_escape_string($con, $Card);

        $queryLookupEdit = "UPDATE lookup
                        SET
                        BoatPrice = '$lookupPrice'
                        WHERE Card = '$Card'";
        
        $resultLookupEdit = mysqli_query($con, $queryLookupEdit);

        if($resultLookupEdit)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
        }
    }

    // Brisanje broda
    /*
    if(isset($_GET["task"]) && $_GET["task"] == "delLookup")
    {
        $Card = (int)$_GET["Card"];
        $Card = mysqli_real_escape_string($con, $Card);

        $queryLookupDelete = "DELETE FROM lookup WHERE Card = '$Card'";
        $resultLookupDelete = mysqli_query($con, $queryLookupDelete);

        if($resultLookupDelete)
        {
            echo 'Podaci su uspjesno obrisani';
            header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno obrisani';
        }
    }
    */


    echo '
    <main>
        <div class="spacer"></div>
            <div class="glass">
            <div class="set-flex">
            <div class="set-container">
                <div class="set-title">Tablica "lookup"</div>
                <form method="POST" action="" class="set-formContainer">
                    <div class="set-inputFlex">
                        <label for="lookupName" class="col-black">Naziv broda:</label>
                        <div id="lookupName" name="lookupName" value="'.$lookupName.'" class="set-inputField inputField">'.$lookupName.'</div>
                    </div>
                    <div class="set-inputFlex">
                        <label for="lookupPrice" class="col-black">Cijena broda:</label>
                        <input type="number" id="lookupPrice" name="lookupPrice" value="'.$lookupPrice.'" class="set-inputField inputField">
                    </div>
                    <input type="submit" value="Spremi" class="add-button-rezerviraj" name="'.$btnLookupForm.'">
                </form>

                <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Cijena</th>
                        <th>Akcija</th>
                    </tr>
                </thead>';
                while($rowLookup = mysqli_fetch_array($resultLookup)){
                    $Card = $rowLookup["Card"];
                    $lookupName = $rowLookup["BoatName"];
                    $lookupPrice = $rowLookup["BoatPrice"];
                    
                    echo '
                    <tr>
                        <td>'.$Card.'</td>
                        <td>'.$lookupName.'</td>
                        <td>'.$lookupPrice.'</td>
                        <td>
                            <a href="settings.php?Card='.$Card.'">Uredi</a>
                            <!--
                            <a href="settings.php?Card='.$Card.'&task=delBoat">Obriši</a>
                            -->
                        </td>
                    </tr>
                    ';
                }
                echo '
                <tbody>
                </tbody>
                </table>
            </div>


        </div>
        
        <div class="spacer spacer-bottom"></div>
    </main>
    ';
}
//0 - Admin
else{

    if(isset($_POST["btnNWD"])){
        if($_SESSION["NWD"] == "js"){
            $_SESSION["NWD"] = "jquery";
            $_SESSION["NWDScript-reservations"] = '<script src="../jquery/jquery-3.4.1.min.js"></script><script src="../jquery/Qreservations.js"></script>';
            $_SESSION["NWDScript-addReservation"] = '<script src="../jquery/jquery-3.4.1.min.js"></script><script src="../jquery/QaddReservation.js"></script>';
        }
        else{
            $_SESSION["NWD"] = "js";
            $_SESSION["NWDScript-reservations"] = '<script src="../js/reservations.js"></script>';
            $_SESSION["NWDScript-addReservation"] = '<script src="../js/addReservation.js"></script>';
        }
    }




    // Query
    $queryBoat = "SELECT * FROM boat";
    $resultBoat = mysqli_query($con, $queryBoat);

    $queryEmployee = "SELECT * FROM employee";
    $resultEmployee = mysqli_query($con, $queryEmployee);

    $queryBugs = "SELECT * FROM bugs";
    $resultBugs = mysqli_query($con, $queryBugs);

    $queryLookup = "SELECT * FROM lookup";
    $resultLookup = mysqli_query($con, $queryLookup);

    // Auto fill form za uredjivanje broda
    if(isset($_GET["IDBoat"])){
        $IDBoat = (int)$_GET["IDBoat"];

        $IDBoat = mysqli_real_escape_string($con, $IDBoat);

        $queryBoat = "SELECT * FROM boat WHERE IDBoat = '$IDBoat'";
        $resultBoat = mysqli_query($con, $queryBoat);

        $boat = mysqli_fetch_assoc($resultBoat);

        $IDBoat = $boat["IDBoat"];
        $Name = $boat["Name"];

        $btnBoatForm = 'btnBoatEdit';
    }
    else{
        $IDBoat = "";
        $Name = "";

        $btnBoatForm = 'btnBoatSave';
    }

    // Spremanje novog broda
    if(isset($_POST["btnBoatSave"]))
    {
        $IDBoat = mysqli_real_escape_string($con, $_POST["IDBoat"]);
        $Name = mysqli_real_escape_string($con, $_POST["boatName"]);

        $queryBoatSave = "INSERT INTO boat (IDBoat, Name)
                        VALUES ('$IDBoat', '$Name')";
        
        $resultBoatSave = mysqli_query($con, $queryBoatSave);

        if($resultBoatSave)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
        }
    }

    // Uredjivanje broda
    if(isset($_POST["btnBoatEdit"]))
    {
        $Name = mysqli_real_escape_string($con, $_POST["boatName"]);

        $IDBoat = (int)$_GET["IDBoat"];
        $IDBoat = mysqli_real_escape_string($con, $IDBoat);

        $queryBoatEdit = "UPDATE boat
                        SET
                        Name = '$Name'
                        WHERE IDBoat = '$IDBoat'";
        
        $resultBoatEdit = mysqli_query($con, $queryBoatEdit);

        if($resultBoatEdit)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
        }
    }

    // Brisanje broda
    if(isset($_GET["task"]) && $_GET["task"] == "delBoat")
    {
        $IDBoat = (int)$_GET["IDBoat"];
        $IDBoat = mysqli_real_escape_string($con, $IDBoat);

        $queryBoatDelete = "DELETE FROM boat WHERE IDBoat = '$IDBoat'";
        $resultBoatDelete = mysqli_query($con, $queryBoatDelete);

        if($resultBoatDelete)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno obrisani';
        }
    }

    // Auto fill form za uredjivanje zaposlenika
    if(isset($_GET["IDEmployee"])){
        $IDEmployee = (int)$_GET["IDEmployee"];

        $IDEmployee = mysqli_real_escape_string($con, $IDEmployee);

        $queryEmployee = "SELECT * FROM employee WHERE IDEmployee = '$IDEmployee'";
        $resultEmployee = mysqli_query($con, $queryEmployee);

        $employee = mysqli_fetch_assoc($resultEmployee);

        $IDEmployee = $employee["IDEmployee"];
        $Username = $employee["Username"];
        $Pin = $employee["Pin"];
        $Level = $employee["Level"];

        $btnEmployeeForm = 'btnEmployeeEdit';
    }
    else{
        $IDEmployee = "";
        $Username = "";
        $Pin = "";
        $Level = "0";

        $btnEmployeeForm = 'btnEmployeeSave';
    }

    // Spremanje novog zaposlenika
    if(isset($_POST["btnEmployeeSave"]))
    {
        $IDEmployee = mysqli_real_escape_string($con, $_POST["IDEmployee"]);
        $Username = mysqli_real_escape_string($con, $_POST["username"]);
        $Pin = mysqli_real_escape_string($con, $_POST["pin"]);

        $queryEmployeeSave = "INSERT INTO employee (IDEmployee, Username, Pin, Level)
                        VALUES ('$IDEmployee', '$Username', '$Pin', '$Level')";

        $resultEmployeeSave = mysqli_query($con, $queryEmployeeSave);

        if($resultEmployeeSave)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
            echo '---------------------GRESKA:' . mysqli_error($con);
        }
    }

    // Uredjivanje zaposlenika
    if(isset($_POST["btnEmployeeEdit"]))
    {
        $IDEmployee = mysqli_real_escape_string($con, $_POST["IDEmployee"]);
        $Username = mysqli_real_escape_string($con, $_POST["username"]);
        $Pin = mysqli_real_escape_string($con, $_POST["pin"]);
        $Level = mysqli_real_escape_string($con, $_POST["level"]);

        $IDEmployee = (int)$_GET["IDEmployee"];
        $IDEmployee = mysqli_real_escape_string($con, $IDEmployee);

        $queryEmployeeEdit = "UPDATE employee
                        SET
                        Username = '$Username',
                        Pin = '$Pin',
                        Level = '$Level'
                        WHERE IDEmployee = '$IDEmployee'";
        
        $resultEmployeeEdit = mysqli_query($con, $queryEmployeeEdit);

        if($resultEmployeeEdit)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
        }
    }

    // Brisanje zaposlenika
    if(isset($_GET["task"]) && $_GET["task"] == "delEmployee")
    {
        $IDEmployee = (int)$_GET["IDEmployee"];

        $IDEmployee = mysqli_real_escape_string($con, $IDEmployee);

        $queryEmployeeDelete = "DELETE FROM employee WHERE IDEmployee = '$IDEmployee'";
        $resultEmployeeDelete = mysqli_query($con, $queryEmployeeDelete);

        if($resultEmployeeDelete)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno obrisani';
        }
    }

    // Brisanje bugs-a
    if(isset($_GET["task"]) && $_GET["task"] == "delBug")
    {
        $IDBugs = (int)$_GET["IDBugs"];

        $IDBugs = mysqli_real_escape_string($con, $IDBugs);

        $queryBugDelete = "DELETE FROM bugs WHERE IDBugs = '$IDBugs'";
        $resultBugDelete = mysqli_query($con, $queryBugDelete);

        if($resultBugDelete)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno obrisani';
        }
    }

    // Auto fill form za uredjivanje lookup-a
    if(isset($_GET["Card"])){
        $Card = (int)$_GET["Card"];

        $Card = mysqli_real_escape_string($con, $Card);

        $queryLookup = "SELECT * FROM lookup WHERE Card = '$Card'";
        $resultLookup = mysqli_query($con, $queryLookup);

        $lookup = mysqli_fetch_assoc($resultLookup);

        $lookupCard = $lookup["Card"];
        $lookupName = $lookup["BoatName"];
        $lookupPrice = $lookup["BoatPrice"];

        $btnLookupForm = 'btnLookupEdit';
    }
    else{
        $Card = "";
        $lookupName = "";
        $lookupPrice = "";

        $btnLookupForm = 'btnLookupSave';
    }

    // Spremanje novog lookup-a
    if(isset($_POST["btnLookupSave"]))
    {
        $Card = mysqli_real_escape_string($con, $_POST["Card"]);
        $lookupName = mysqli_real_escape_string($con, $_POST["BoatName"]);
        $lookupPrice = mysqli_real_escape_string($con, $_POST["BoatPrice"]);

        $queryLookupSave = "INSERT INTO lookup (Card, BoatName, BoatPrice)
                        VALUES ('$Card', '$lookupName', '$lookupPrice')";
        
        $resultLookupSave = mysqli_query($con, $queryLookupSave);

        if($resultLookupSave)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
        }
    }

    // Uredjivanje lookup-a
    if(isset($_POST["btnLookupEdit"]))
    {
        $lookupName = mysqli_real_escape_string($con, $_POST["lookupName"]);
        $lookupPrice = mysqli_real_escape_string($con, $_POST["lookupPrice"]);

        $Card = (int)$_GET["Card"];
        $Card = mysqli_real_escape_string($con, $Card);

        $queryLookupEdit = "UPDATE lookup
                        SET
                        BoatPrice = '$lookupPrice'
                        WHERE Card = '$Card'";
        
        $resultLookupEdit = mysqli_query($con, $queryLookupEdit);

        if($resultLookupEdit)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno spremljeni';
        }
    }

    // Brisanje lookup-a
    
    if(isset($_GET["task"]) && $_GET["task"] == "delLookup")
    {
        $Card = (int)$_GET["Card"];
        $Card = mysqli_real_escape_string($con, $Card);

        $queryLookupDelete = "DELETE FROM lookup WHERE Card = '$Card'";
        $resultLookupDelete = mysqli_query($con, $queryLookupDelete);

        if($resultLookupDelete)
        {
            
            echo '
            <script>
            function redirectToReservations() {
                var reservationsURL = "settings.php";
                window.location.href = reservationsURL;
            }
            redirectToReservations();
            </script>
            ';
            //header("Location: settings.php");
        }
        else{
            echo 'Podaci nisu uspjesno obrisani';
        }
    }
    



    echo '
    <main>
    <div class="spacer"></div>
    <div class="glass">
        <div class="set-flex">
            <div class="set-container">
                <div class="set-title">Tablica "boat"</div>
                <form method="POST" action="" class="set-formContainer">
                    <div class="set-inputFlex">
                        <label for="boatName" class="col-black">Naziv broda:</label>
                        <input type="text" id="boatName" name="boatName" value="'.$Name.'" class="set-inputField">
                    </div>
                    <input type="submit" value="Spremi" class="add-button-rezerviraj" name="'.$btnBoatForm.'">
                </form>

                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Akcija</th>
                        </tr>
                    </thead>';
                    while($rowBoat = mysqli_fetch_array($resultBoat)){
                    $IDBoat = $rowBoat["IDBoat"];
                    $Name = $rowBoat["Name"];

                    echo '
                    <tr>
                        <td>'.$IDBoat.'</td>
                        <td>'.$Name.'</td>
                        <td>
                            <a href="settings.php?IDBoat='.$IDBoat.'">Uredi</a>
                            <a href="settings.php?IDBoat='.$IDBoat.'&task=delBoat">Obriši</a>
                        </td>
                    </tr>
                    ';
                    }
                    echo '
                    <tbody>
                    </tbody>
                </table>
            </div>


            <div>
                <div class="set-container ww-100">
                    <div class="set-title">Tablica "employee"</div>
                    <form method="POST" action="" class="set-formContainer">
                        <div class="set-inputFlex">
                            <label for="username" class="col-black">Username:</label>
                            <input type="text" id="username" name="username" value="'.$Username.'"
                                class="set-inputField">
                        </div>
                        <div class="set-inputFlex">
                            <label for="pin" class="col-black">Pin:</label>
                            <input type="text" id="pin" name="pin" value="'.$Pin.'" class="set-inputField ">
                        </div>
                        <div class="set-inputFlex">
                            <label for="level" class="col-black">Level:</label>
                            <input type="text" id="level" name="level" value="'.$Level.'" class="set-inputField ">
                        </div>
                        <div class="set-inputFlex">
                            <div class="col-black">Levels: 0 - Admin, 1 - User, 2 - Manager</div>
                        </div>
                        <input type="submit" value="Spremi" class="add-button-rezerviraj" name="'.$btnEmployeeForm.'">
                    </form>

                    <table border="1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Pin</th>
                                <th>Level</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>';
                        while($rowEmployee = mysqli_fetch_array($resultEmployee)){

                        $IDEmployee = $rowEmployee['IDEmployee'];
                        $Username = $rowEmployee['Username'];
                        $Pin = $rowEmployee['Pin'];
                        $Level = $rowEmployee['Level'];

                        echo '
                        <tr>
                            <td>'.$IDEmployee.'</td>
                            <td>'.$Username.'</td>
                            <td>'.$Pin.'</td>
                            <td>'.$Level.'</td>
                            <td>
                                <a href="settings.php?IDEmployee='.$IDEmployee.'">Uredi</a>
                                <a href="settings.php?IDEmployee='.$IDEmployee.'&task=delEmployee">Obriši</a>
                            </td>
                        </tr>
                        ';
                        }
                        echo '
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!--
                <div class="set-container ww-100">

                    <div class="set-title">WPT Script Switcher</div>
                    <form method="POST" action="">
                        <div class="set-flex">
                            <div class="set-switch-text">JavaScript</div>
                            <label class="switch">';
                                if($_SESSION['NWD'] === 'js'){
                                echo '<input type="checkbox" id="toggle-input">';
                                }
                                else{
                                echo '<input type="checkbox" id="toggle-input" checked>';
                                }

                                echo '
                                <span class="slider round"></span>
                            </label>
                            <div class="set-switch-text">JQuery</div>
                            <input type="submit" value="Spremi" class="add-button-rezerviraj" name="btnNWD">
                        </div>
                    </form>
                </div>
                -->

            </div>
        <div class="">
            <div class="set-container ww-100">
                <div class="set-title">Tablica "bugs"</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Akcija</th>
                        </tr>
                    </thead>
                    <tbody>';
                        while($rowBugs = mysqli_fetch_array($resultBugs)){
                        $IDBugs = $rowBugs["IDBugs"];
                        $IDEmployeeBugs = $rowBugs["EmployeeID"];
                        $Text = $rowBugs["Text"];

                        echo '
                        <tr>
                            <td>'.$IDEmployeeBugs.'</td>
                            <td>'.$Text.'</td>
                            <td>
                                <a href="settings.php?IDBugs='.$IDBugs.'&task=delBug">Obriši</a>
                            </td>
                        </tr>
                        ';
                        }
                        echo '
                    </tbody>
                </table>
            </div>
            <div class="set-container ww-100">
                <div class="set-title">Tablica "lookup"</div>
                <form method="POST" action="" class="set-formContainer">
                    <div class="set-inputFlex">
                        <label for="lookupName" class="col-black">Naziv broda:</label>
                        <div id="lookupName" name="lookupName" value="'.$lookupName.'" class="set-inputField inputField">'.$lookupName.'</div>
                    </div>
                    <div class="set-inputFlex">
                        <label for="lookupPrice" class="col-black">Cijena broda:</label>
                        <input type="number" id="lookupPrice" name="lookupPrice" value="'.$lookupPrice.'" class="set-inputField inputField">
                    </div>
                    <input type="submit" value="Spremi" class="add-button-rezerviraj" name="'.$btnLookupForm.'">
                </form>

                <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Cijena</th>
                        <th>Akcija</th>
                    </tr>
                </thead>';
                while($rowLookup = mysqli_fetch_array($resultLookup)){
                    $Card = $rowLookup["Card"];
                    $lookupName = $rowLookup["BoatName"];
                    $lookupPrice = $rowLookup["BoatPrice"];
                    
                    echo '
                    <tr>
                        <td>'.$Card.'</td>
                        <td>'.$lookupName.'</td>
                        <td>'.$lookupPrice.'</td>
                        <td>
                            <a href="settings.php?Card='.$Card.'">Uredi</a>
                            <!--
                            <a href="settings.php?Card='.$Card.'&task=delBoat">Obriši</a>
                            -->
                        </td>
                    </tr>
                    ';
                }
                echo '
                <tbody>
                </tbody>
                </table>
            </div>
        </div>

        </div>


    </div>

    <div class="spacer spacer-bottom"></div>
</main>
    ';
}
    include("../header-footer/footer.php");
?>