<?php

// cardSlotsBoats daje brojeve redoslijed prikazivanja brodova te broj ponavljanja prikaza jednog broda
// Key predstavlja broj kartice, dok value predstavlja IDBroda u $booked_slots
$cardSlotsBoats = array(
    '1' => 1,
    '2' => 1,
    '3' => 2,
    '4' => 2,
    '5' => 3,
    '6' => 3,
    '7' => 4,
    '8' => 4,
    '9' => 5,
    '10' => 6,
    '11' => 7,
    '12' => 8,
    '13' => 9,
    '14' => 10,
    '15' => 11,
    '16' => 12,
);

// cardSlotsTimes daje pravilo koji vremenski interval se smije prikazati u toj kartici
// Key predstavlja broj kartice, dok value predstavlja CardSlotPlace u $booked_slots
$cardSlotsTimes = array(
    '1' => 1,
    '2' => 2,
    '3' => 1,
    '4' => 2,
    '5' => 1,
    '6' => 2,
    '7' => 1,
    '8' => 2,
    '9' => 2,
    '10' => 2,
    '11' => 2,
    '12' => 2,
    '13' => 2,
    '14' => 2,
    '15' => 2,
    '16' => 2,
);

?>