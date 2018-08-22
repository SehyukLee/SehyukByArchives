<?php
    $MyNum = isset($_POST['number']) ? $_POST['number'] : null;  // html파일에서 가져온 값
    $gender = "";             // 성별
    $distinction = true;      // 판별
    $count = 2;               // 판별식에서 곱하는 수
    $result = 0;              // 판별식 값
    $year = 0;                // 생년
    $month = 0;               // 월
    $day = 0;                 // 일
    $D_birthday = 0;          // 생일까지 남은 날짜
    $startDay = 0;            // 기준 날짜
    $lastDay = 0;             // 지정 날짜
    $today = getdate();       // 오늘 날짜
    $birthAndToday = 0;       // 생후 달수
    $remainder = 0;           // 생후 달수 계산 변수

    if ($MyNum[7] == "1" || $MyNum[7] == "3") {
        $gender = "남성";

        if($MyNum[7] == "1"){
            $year = "19".$MyNum[0].$MyNum[1];
        }
        else{
            $year = "20".$MyNum[0].$MyNum[1];
        }
        // 주민 번호 뒷자리의 첫번째 숫자가 1이면 2000년도 이전 출생한 사람이고
        // 2이면 2000년도 이후 출생한 사람
    }
    elseif ($MyNum[7] == "2" || $MyNum[7] == "4") {
        $gender = "여성";

        if($MyNum[7] == "2"){
            $year = "19".$MyNum[0].$MyNum[1];
        }
        else{
            $year = "20".$MyNum[0].$MyNum[1];
        }
        // 주민 번호 뒷자리의 첫번째 숫자가 1이면 2000년도 이전 출생한 사람이고
        // 2이면 2000년도 이후 출생한 사람
    }
    else{
        $distinction = false;
    }
    // 성별 판별 및 생년 계산

    for($i = 0; $i < strlen($MyNum) - 1; $i++, $count++){
        if($MyNum[$i] == "-"){
            $count--;
            continue;
        }

        if($count == 10){
            $count = 2;
        }

        $result = ($MyNum[$i] * $count) + $result;
    }
    $result = 11 - ($result % 11);
    // 판별식으로 계산

    if($result != $MyNum[strlen($MyNum) - 1]){
        $distinction = false;
    }
    // 판별식으로 나온 값으로 주민등록번호 판별

    if($distinction == true){
        if($MyNum[2] == 0) {
            $month = $MyNum[3];
        }
        else {
            $month = $MyNum[2].$MyNum[3];
        }
        // 월수가 한자리면 앞의 0빼기

        if ($MyNum[4] == 0) {
            $day = $MyNum[5];
        }
        else {
            $day = $MyNum[4].$MyNum[5];
        }
        // 일수가 한자리면 앞의 0빼기

        if ($today["mon"] < $month) {
            $startDay = date("Y-m-d", time());
            $lastDay = Trim($today["year"]."-".$MyNum[2].$MyNum[3]."-".$MyNum[4].$MyNum[5]);
            $remainder = ($month - $today["mon"] - 12) * -1;
        }
        elseif ($today["mon"] == $month) {
            if ($today["mday"] <= $day) {
                $startDay = date("Y-m-d", time());
                $lastDay = Trim($today["year"]."-".$MyNum[2].$MyNum[3]."-".$MyNum[4].$MyNum[5]);
                $remainder = ($month - $today["mon"] - 12) * -1;
            }
            else {
                $startDay = date("Y-m-d", time());
                $lastDay = Trim(($today["year"] + 1)."-".$MyNum[2].$MyNum[3]."-".$MyNum[4].$MyNum[5]);
                $remainder = $month - $today["mon"] + 12;
            }
        }
        else {
            $startDay = date("Y-m-d", time());
            $lastDay = Trim(($today["year"] + 1)."-".$MyNum[2].$MyNum[3]."-".$MyNum[4].$MyNum[5]);
            $remainder = $month - $today["mon"] + 12;
        }
        // 생일이 지난 사람과 안 지난 사람에 따른 날짜 정리 및 지난 번 생일부터 지금까지의 달수 계산

        $D_birthday = intval((strtotime($lastDay) - strtotime($startDay)) / 86400);
        // 오늘부터 생일까지 남은 날짜 계산

        $startDay = date("Y-m-d", time());
        $lastDay = Trim($year."-".$MyNum[2].$MyNum[3]."-".$MyNum[4].$MyNum[5]);
        $birthAndToday = intval((strtotime($lastDay) - strtotime($startDay)) / 86400);
        // 생년월일부터 지금까지의 일수

        $birthAndToday = (((int)($birthAndToday / 365) * 12) - $remainder) * -1;
        // 생후 달수 계산

        echo $MyNum." : ".$gender."<br>";
        echo "유효한 주민번호입니다."."<br>";
        echo "생년월일은 ".$year."년 ".$month."월 ".$day."일 입니다."."<br>";
        echo "생일 D-day: ".$D_birthday."일"."<br>";
        echo "생후 ".$birthAndToday."달"."<br>";
        // 출력
    }
    else {
        echo $MyNum."<br>";
        echo "유효하지 않은 주민번호입니다."."<br>";
    }
    // 판별에 따른 값에 따라 유무효 출력
?>



