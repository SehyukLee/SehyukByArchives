<?php
    $value = $_GET['textInputValue'];    // html 파일에서 가져온 값
    $AllArrayList = array();              // 값을 하나씩 넣을 배열
    $arrayList = array();                 // 숫자만 넣을 배열
    $arrayListOrigin = array();           // 숫자 배열 순서를 바꾸기위해 만든 배열
    $calculatorArr = array();             // 연산자만 넣을 배열
    $calculatorArrOrigin = array();       // 연산자 배열 순서를 바꾸기위해 만든 배열
    $oneString = "";                      // 문자 하나만 저장 할 변수
    $number = "";                         // 숫자를 정리하기 위해 만든 변수(ex> 123, 23 등)
    $result = 0;                          // 결과 값
    $first = 0;                           // 계산 첫번째 자리
    $second = 0;                          // 계산 두번째 자리

    for ($i = strlen($value) - 1; $i >= 0; $i--) {
        array_push($AllArrayList, $value[$i]);
    }
    // html에서 가져온 값을 하나씩 나눠서 배열에 담기

    for ($j = 0; $j < strlen($value); $j++) {
        $oneString = array_pop($AllArrayList);

        if (is_numeric($oneString)) {
            $number = $number.$oneString;

            if($j == strlen($value) - 1){
                array_push($arrayList, $number);
            }
        }
        else {
            array_push($arrayList, $number);
            array_push($calculatorArr, $oneString);
            $number = "";
        }
    }
    // 나눈 배열을 숫자는 숫자대로 연산자는 연산자대로 나누기
    // 연속된 숫자는 합쳐서 배열에 넣기

    $arrayListCount = count($arrayList);          // 숫자 개수
    $calculatorArrCount = count($calculatorArr);  // 연산자 개수

    for ($r = 0; $r < $arrayListCount; $r++){
        array_push($arrayListOrigin, array_pop($arrayList));
    }
    // 숫자 순서가 반대로 되있으므로 순서정렬

    for ($t = 0; $t < $calculatorArrCount; $t++){
        array_push($calculatorArrOrigin, array_pop($calculatorArr));
    }
    // 연산자 순서가 반대로 되있으므로 순서정렬

    $calculatorCount = count($calculatorArrOrigin);
    // 연산자 개수

    for ($s = 0; $s < $calculatorCount; $s++) {
        if ($s == 0) {
            $first = array_pop($arrayListOrigin);
            $second = array_pop($arrayListOrigin);
        }
        else {
            $first = $result;
            $second = array_pop($arrayListOrigin);
        }
        // 계산할 두 숫자 가져오기

        $calculator = array_pop($calculatorArrOrigin);
        // 계산할 연산자 가져오기

        if ($calculator == "+") {
            $result = $first + $second;
        }
        elseif ($calculator == "-") {
            $result = $first - $second;
        }
        elseif ($calculator == "*") {
            $result = $first * $second;
        }
        elseif ($calculator == "/") {
            $result = $first / $second;
        }
        // 연산자 별 계산
    }
    // 계산

    echo $result;
    // 결과값 출력
?>