<?php

include("../header-footer/header.php");
include("../navigation/navigation.php");

include("../PHP/db_connection.php");

// Query
$queryBoat = "SELECT * FROM boat";
$resultBoat = mysqli_query($con, $queryBoat);

$queryEmployee = "SELECT * FROM employee";
$resultEmployee = mysqli_query($con, $queryEmployee);

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
        echo 'Podaci su uspjesno spremljeni';
        header("Location: settings.php");
    }
    else{
        echo 'Podaci nisu uspjesno spremljeni';
    }
}

// Uredjivanje broda
if(isset($_POST["btnBoatEdit"]))
{
    $IDBoat = mysqli_real_escape_string($con, $_POST["IDBoat"]);
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
        echo 'Podaci su uspjesno spremljeni';
        header("Location: settings.php");
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
        echo 'Podaci su uspjesno obrisani';
        header("Location: settings.php");
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

    $btnEmployeeForm = 'btnEmployeeEdit';
}
else{
    $IDEmployee = "";
    $Username = "";
    $Pin = "";

    $btnEmployeeForm = 'btnEmployeeSave';
}

// Spremanje novog zaposlenika
if(isset($_POST["btnEmployeeSave"]))
{
    $IDEmployee = mysqli_real_escape_string($con, $_POST["IDEmployee"]);
    $Username = mysqli_real_escape_string($con, $_POST["username"]);
    $Pin = mysqli_real_escape_string($con, $_POST["pin"]);

    $queryEmployeeSave = "INSERT INTO employee (IDEmployee, Username, Pin)
                    VALUES ('$IDEmployee', '$Username', '$Pin')";

    $resultEmployeeSave = mysqli_query($con, $queryEmployeeSave);

    if($resultEmployeeSave)
    {
        echo 'Podaci su uspjesno spremljeni';
        header("Location: settings.php");
    }
    else{
        echo 'Podaci nisu uspjesno spremljeni';
    }
}

// Uredjivanje zaposlenika
if(isset($_POST["btnEmployeeEdit"]))
{
    $IDEmployee = mysqli_real_escape_string($con, $_POST["IDEmployee"]);
    $Username = mysqli_real_escape_string($con, $_POST["username"]);
    $Pin = mysqli_real_escape_string($con, $_POST["pin"]);

    $IDEmployee = (int)$_GET["IDEmployee"];
    $IDEmployee = mysqli_real_escape_string($con, $IDEmployee);

    $queryEmployeeEdit = "UPDATE employee
                    SET
                    Username = '$Username',
                    Pin = '$Pin'
                    WHERE IDEmployee = '$IDEmployee'";
    
    $resultEmployeeEdit = mysqli_query($con, $queryEmployeeEdit);

    if($resultEmployeeEdit)
    {
        echo 'Podaci su uspjesno spremljeni';
        header("Location: settings.php");
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
        echo 'Podaci su uspjesno obrisani';
        header("Location: settings.php");
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
                    <label for="boatName" class="col-white">Naziv broda:</label>
                    <input type="text" id="boatName" name="boatName" value="'.$Name.'" class="set-inputField">
                </div>
                <input type="submit" value="Spremi" class="add-button-rezerviraj" name="'.$btnBoatForm.'">
            </form>

            <table border="1">
            <thead>
                <tr>
                    <th>IDBoat</th>
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
        <div class="set-container">
        <div class="set-title">Tablica "employee"</div>
            <form method="POST" action="" class="set-formContainer">
                <div class="set-inputFlex">
                    <label for="username" class="col-white">Username:</label>
                    <input type="text" id="username" name="username" value="'.$Username.'" class="set-inputField">
                </div>
                <div class="set-inputFlex">
                    <label for="pin" class="col-white">Pin:</label>
                    <input type="text" id="pin" name="pin" value="'.$Pin.'" class="set-inputField ">
                </div>
                <input type="submit" value="Spremi" class="add-button-rezerviraj" name="'.$btnEmployeeForm.'">
            </form>

            <table border="1">
            <thead>
                <tr>
                    <th>IDEmployee</th>
                    <th>Username</th>
                    <th>Pin</th>
                    <th>Akcija</th>
                </tr>
            </thead>';
            while($rowEmployee = mysqli_fetch_array($resultEmployee)){

                $IDEmployee = $rowEmployee['IDEmployee'];
                $Username = $rowEmployee['Username'];
                $Pin = $rowEmployee['Pin'];

                echo '
                <tr>
                    <td>'.$IDEmployee.'</td>
                    <td>'.$Username.'</td>
                    <td>'.$Pin.'</td>
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
        </div>
    </div>
    <!--
    <div class="set-title">WPT Script Switcher</div>
    <div class="set-flex">
        <div class="set-switch-text">JavaScript</div>
        <label class="switch">
            <input type="checkbox" id="toggle-input">
            <span class="slider round"></span>
        </label>
        <div class="set-switch-text">JQuery</div>
    </div>
    -->
    <div class="spacer spacer-bottom"></div>
</main>
';

include("../header-footer/footer.php");

?>