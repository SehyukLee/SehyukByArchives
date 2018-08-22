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
            echo $alphabet;
        }

        for ($k = 0; $k < $jumpMinus; $k++) {
            echo "&nbsp";
        }

        for ($s = 0; $s < $sumOne; $s++, $reduce++) {
            echo chr($Ask - $reduce);
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
            echo $alphabet;
        }

        for ($k = 0; $k < $jumpPlus; $k++) {
            echo "&nbsp";
        }

        for ($s = 0; $s < $minusOne; $s++, $reduce++) {
            echo chr($Ask - $reduce);
        }

        $reduce = 0;
        $jumpPlus = $jumpPlus + 2;
        $minusOne--;
        $alphabet = "A";
        $Ask--;
        echo "<br>";
    }
?>