<?php

function dateToCroatianFormat($date) {
    // pretvara se u format po zelji
    $dayDisplayedMyFormat = date("d.m.Y", strtotime($date));
    return $dayDisplayedMyFormat;
}

function dateToDaysOfWeekEnglish($date) {
    $dayOfWeek = date("l", strtotime($date));
    return $dayOfWeek;
}

function dateToDaysOfWeekCroatian($date) {
    // stvara se polje hrvatskih dana
    $CroatianDays = ['Nedjelja', 'Ponedjeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota'];

    // pretvaramo u timestamp, zatim sa "w" dobivamo broj dana u tjednu, a sa tim brojem dobivamo hrvatski naziv dana preko polja
    $dayOfWeekCroatian = $CroatianDays[date("w", strtotime($date))];
    return $dayOfWeekCroatian;
}

function modifyArray($array, $lookup) {
    for ($i=0; $i < count($array); $i++) { 
        // cupamo samo sate iz vremena
        $array[$i]['StartTimeH'] = date("H", strtotime($array[$i]['StartTime']));
        $array[$i]['FinishTimeH'] = date("H", strtotime($array[$i]['FinishTime']));
    
        // dodjeljujemo dodatna pomocna polja za lakse racunanje pozicije rezervacije
        if ($array[$i]['FinishTimeH'] <= 16) {
            $array[$i]['TimeSlot'] = 1;
            $array[$i]['CardSlotPlace'] = 1;
        }
        else if ($array[$i]['StartTimeH'] > 12 && $array[$i]['FinishTimeH'] <= 23) {
            $array[$i]['TimeSlot'] = 2;
            $array[$i]['CardSlotPlace'] = 2;
        }
        else if ($array[$i]['FinishTimeH'] <= 23) {
            $array[$i]['TimeSlot'] = 3;
            $array[$i]['CardSlotPlace'] = 1;
        }
        else {
            $array[$i]['TimeSlot'] = 3;
            $array[$i]['CardSlotPlace'] = 1;
        }

        // TIMESLOT 1 = 1/2 dana prva poloovica
        // TIMESLOT 2 = 1/2 dana druga polovica
        // TIMESLOT 3 = cijeli dan

        // CARD SLOT PLACE 1 = Lijeva Kartica
        // CARD SLOT PLACE 2 = Desna Kartica
        
    
    
        // RUCNO IZRADENO
    
        /*
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 1) {
            $array[$i]['CardNumber'] = 1;
        }
        if($array[$i]['CardSlotPlace'] == 2 && $array[$i]['IDBoat'] == 1) {
            $array[$i]['CardNumber'] = 2;
        }
    
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 2) {
            $array[$i]['CardNumber'] = 3;
        }
        if($array[$i]['CardSlotPlace'] == 2 && $array[$i]['IDBoat'] == 2) {
            $array[$i]['CardNumber'] = 4;
        }
    
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 3) {
            $array[$i]['CardNumber'] = 5;
        }
        if($array[$i]['CardSlotPlace'] == 2 && $array[$i]['IDBoat'] == 3) {
            $array[$i]['CardNumber'] = 6;
        }
    
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 4) {
            $array[$i]['CardNumber'] = 7;
        }
        if($array[$i]['CardSlotPlace'] == 2 && $array[$i]['IDBoat'] == 4) {
            $array[$i]['CardNumber'] = 8;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 5) {
            $array[$i]['CardNumber'] = 9;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 6) {
            $array[$i]['CardNumber'] = 10;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 7) {
            $array[$i]['CardNumber'] = 11;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 8) {
            $array[$i]['CardNumber'] = 12;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 9) {
            $array[$i]['CardNumber'] = 13;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 10) {
            $array[$i]['CardNumber'] = 14;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 11) {
            $array[$i]['CardNumber'] = 15;
        }
        if($array[$i]['CardSlotPlace'] == 1 && $array[$i]['IDBoat'] == 12) {
            $array[$i]['CardNumber'] = 16;
        }
        */
    }

    // Optimizirani nacin za izracunavanje pozicije rezervacije na kartici
    // Tu se referencira sad na $lookup u config.php i iz njega uzima vrijednosti
    for ($i = 0; $i < count($array); $i++) {
        foreach ($lookup as $cardNumber => $values) {
            if ($array[$i]['CardSlotPlace'] == $values['CardSlotPlace'] && $array[$i]['IDBoat'] == $values['IDBoat']) {
                $array[$i]['CardNumber'] = $cardNumber;
                break;
            }
        }
    }

    // Sortiranje $array po CardNumberu
    usort($array, function($a, $b) {
        return $a['CardNumber'] <=> $b['CardNumber'];
    });

    return $array;
}

?>