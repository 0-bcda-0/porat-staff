<?php
// db_connection.php

include("../PHP/db_connection.php");

// Fetch data from the database
$query = "SELECT Card, CardSlotPlace, IDBoat, BoatName, BoatPrice FROM lookup"; // Replace 'your_table_name' with the actual table name
$result = mysqli_query($con, $query);

// Create an empty lookup array
$lookup = array();

// Fill the lookup array with data from the database
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['Card'];
    $lookup[$id] = array(
        'Card' => $row['Card'],
        'CardSlotPlace' => $row['CardSlotPlace'],
        'IDBoat' => $row['IDBoat'],
        'BoatName' => $row['BoatName'],
        'BoatPrice' => $row['BoatPrice']
    );
}
?>
