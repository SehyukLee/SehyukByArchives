<?php
$alphabetCount = 26;
$sumOne = 1;
$minusOne = 25;
$alphabet = "A";
$Ask = 65;
$jumpMinus = 50;
$jumpPlus = 2;
$reduce = 0;

for ($i = 0; $i < $alphabetCount; $i++) {
    for ($j = 0; $j < $sumOne; $j++, $alphabet++) {
        if($i == $alphabetCount - 1){
            echo $alphabet;
        }
        else if($j == 0 || $j == $sumOne -1){
            echo $alphabet;
        }
        else {
            echo "&nbsp";
        }
    }

    for ($k = 0; $k < $jumpMinus; $k++) {
        echo "&nbsp";
    }

    for ($s = 0; $s < $sumOne; $s++, $reduce++) {
        if($i == $alphabetCount - 1){
            echo chr($Ask - $reduce);
        }
        else if($s == 0 || $s == $sumOne -1){
            echo chr($Ask - $reduce);;
        }
        else {
            echo "&nbsp";
        }
    }

    $reduce = 0;
    $jumpMinus = $jumpMinus - 2;
    $sumOne++;
    $alphabet = "A";
    $Ask++;
    echo "<br>";
}

$Ask = 89;
$reduce = 0;

for ($i = 0; $i < $alphabetCount - 1; $i++) {
    for ($j = 0; $j < $minusOne; $j++, $alphabet++) {
        if($j == 0 || $j == $minusOne -1){
            echo $alphabet;
        }
        else {
            echo "&nbsp";
        }
    }

    for ($k = 0; $k < $jumpPlus; $k++) {
        echo "&nbsp";
    }

    for ($s = 0; $s < $minusOne; $s++, $reduce++) {
        if($s == 0 || $s == $minusOne -1){
            echo chr($Ask - $reduce);
        }
        else {
            echo "&nbsp";
        }
    }

    $reduce = 0;
    $jumpPlus = $jumpPlus + 2;
    $minusOne--;
    $alphabet = "A";
    $Ask--;
    echo "<br>";
}
?>