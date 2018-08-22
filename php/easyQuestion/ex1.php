<?php
    $num = isset($_POST['value1']) ? $_POST['value1'] : null;
    $rowNum = isset($_POST['value2']) ? $_POST['value2'] : null;
    $alphabetCount = 26;

    if ($num == 1) {
        $alphabet = "a";

        for ($i = 0; $i < $alphabetCount; $i++) {
            for ($j = 0; $j < $rowNum; $j++) {
                echo $alphabet;
            }

            $alphabet++;
            echo "<br>";
        }
    }
    else if ($num == 2) {
        $alphabet = "A";
        for ($i = 0; $i < $alphabetCount; $i++) {
            for ($j = 0; $j < $rowNum; $j++) {
                echo $alphabet;
            }

            $alphabet++;
            echo "<br>";
        }
    }
    else {
        echo "잘못된 입력입니다.";
    }
?>