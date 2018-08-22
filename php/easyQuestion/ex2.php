<?php
    $alphabetCount = 26;
    $sumOne = 1;
    $alphabet = "A";

    for ($i = 0; $i < $alphabetCount; $i++) {
        for($j = 0; $j < $sumOne; $j++, $alphabet++) {
            echo $alphabet;
        }
        $alphabet = "A";
        $sumOne++;
        echo "<br>";
    }
?>