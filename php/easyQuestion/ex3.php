<?php
    $alphabetCount = 26;
    $sumOne = 0;
    $minusOne = 26;
    $alphabet = "A";

    for ($i = 0; $i < $alphabetCount; $i++) {
        for ($k = 0; $k < $sumOne; $k++) {
            echo "&nbsp";
        }

        for ($j = 0; $j < $minusOne; $j++, $alphabet++) {
            echo $alphabet;
        }

        $alphabet = "A";
        $sumOne++;
        $minusOne--;
        echo "<br>";
    }
?>