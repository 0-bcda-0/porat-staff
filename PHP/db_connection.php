<?php

// db_connection.php

$db_server   = "localhost";
$db_user     = "root";
$db_password = "";
$database    = "porat-staff";

$con = mysqli_connect($db_server, $db_user, $db_password, $database);

if(mysqli_connect_errno() > 0)
{
    echo 'Problem u spajanju na bazu podataka.';
    echo mysqli_connect_error();
    exit;
}

?>