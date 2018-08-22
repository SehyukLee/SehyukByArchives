<?php
    $alphabetCount = 26;
    $sumOne = 1;
    $minusOne = 25;
    $alphabet = "A";

    for ($i = 0; $i < $alphabetCount; $i++) {
        for ($j = 0; $j < $sumOne; $j++, $alphabet++) {
            echo $alphabet;
        }

        $alphabet = "A";
        $sumOne++;
        echo "<br>";
    }

    for ($i = 0; $i < $alphabetCount -1; $i++) {
        for ($j = 0; $j < $minusOne; $j++, $alphabet++) {
            echo $alphabet;
        }

        $alphabet = "A";
        $minusOne--;
        echo "<br>";
    }
?>