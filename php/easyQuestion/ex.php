<?php
    $num = isset($_POST['value1']) ? $_POST['value1'] : null;        // 문제 1번의 첫번째 입력 값
    $rowNum = isset($_POST['value2']) ? $_POST['value2'] : null;     // 문제 1번의 두번째 입력 값
    $ex2 = isset($_POST['value3']) ? $_POST['value3'] : null;        // 문제 2번
    $ex3 = isset($_POST['value4']) ? $_POST['value4'] : null;        // 문제 3번
    $ex4 = isset($_POST['value5']) ? $_POST['value5'] : null;        // 문제 4번
    $ex5 = isset($_POST['value6']) ? $_POST['value6'] : null;        // 문제 5번
    $ex6 = isset($_POST['value7']) ? $_POST['value7'] : null;        // 문제 6번

    if ($ex2 == "문제 2번 보기") {
        // 문제 2번 실행

        $alphabetCount = 26;   // 알파벳 개수
        $sumOne = 1;           // 1씩 증가하도록 할 변수
        $alphabet = "A";       // 화면에 출력할 문자

        for ($i = 0; $i < $alphabetCount; $i++) {
            for($j = 0; $j < $sumOne; $j++, $alphabet++) {
                echo $alphabet;
            }
            $alphabet = "A";
            $sumOne++;
            echo "<br>";
        }
        // 삼각형모양으로 알파벳 출력
    }
    else if ($ex3 == "문제 3번 보기") {
        // 3번 문제 실행

        $alphabetCount = 26;    // 알파벳 개수
        $sumOne = 0;            // 1씩 증가하도록 할 변수
        $minusOne = 26;         // 1씩 감소하도록 할 변수
        $alphabet = "A";        // 화면에 출력할 문자

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
        // 역직삼각형모양으로 알파벳 출력
    }
    else if ($ex4 == "문제 4번 보기") {
        // 4번 문제 실행

        $alphabetCount = 26;    // 알파벳 개수
        $sumOne = 1;            // 1씩 증가하도록 할 변수
        $minusOne = 25;         // 1씩 감소하도록 할 변수
        $alphabet = "A";        // 화면에 출력할 문자

        for ($i = 0; $i < $alphabetCount; $i++) {
            for ($j = 0; $j < $sumOne; $j++, $alphabet++) {
                echo $alphabet;
            }

            $alphabet = "A";
            $sumOne++;
            echo "<br>";
        }
        // 삼각형모양으로 알파벳 출력

        for ($i = 0; $i < $alphabetCount -1; $i++) {
            for ($j = 0; $j < $minusOne; $j++, $alphabet++) {
                echo $alphabet;
            }

            $alphabet = "A";
            $minusOne--;
            echo "<br>";
        }
        // 뒤집은 삼각형모양으로 알파벳 출력
    }
    else if ($ex5 == "문제 5번 보기") {
        $alphabetCount = 26;   // 알파벳 개수
        $sumOne = 1;           // 1씩 증가하도록 할 변수
        $minusOne = 25;        // 1씩 감소하도록 할 변수
        $alphabet = "A";       // 화면에 출력할 문자
        $Ask = 65;             // A의 아스키 코드 값
        $jumpMinus = 50;       // 2씩 증가 할 띄워쓰기 개수
        $jumpPlus = 2;         // 2씩 감소 할 띄워쓰기 개수
        $reduce = 0;           // 아스키 코드 값 조절 변수

        for ($i = 0; $i < $alphabetCount; $i++) {
            for ($j = 0; $j < $sumOne; $j++, $alphabet++) {
                echo $alphabet;
            }
            // 삼각형 모양으로 알파벳 출력

            for ($k = 0; $k < $jumpMinus; $k++) {
                echo "&nbsp";
            }
            // 빈 공간 생성

            for ($s = 0; $s < $sumOne; $s++, $reduce++) {
                echo chr($Ask - $reduce);
            }
            // 역 삼각형 모양으로 알파벳 출력

            $reduce = 0;                   // 아스키 코드 조절 초기화
            $jumpMinus = $jumpMinus - 2;   // 띄워쓰기 개수 감소
            $sumOne++;                     // 알파벳 출력 1씩 증가
            $alphabet = "A";               // 알파벳 모양 초기화
            $Ask++;                        // 아스키 코드 값 증가
            echo "<br>";
        }

        $Ask = 89;      // Z의 아스키 코드 값
        $reduce = 0;    // 아스키 코드 조절 변수 초기화

        for ($i = 0; $i < $alphabetCount - 1; $i++) {
            for ($j = 0; $j < $minusOne; $j++, $alphabet++) {
                echo $alphabet;
            }
            // 뒤집어진 삼각형 모양으로 알파벳 출력

            for ($k = 0; $k < $jumpPlus; $k++) {
                echo "&nbsp";
            }
            // 빈 공간 생성

            for ($s = 0; $s < $minusOne; $s++, $reduce++) {
                echo chr($Ask - $reduce);
            }
            // 뒤집어진 역삼각형 모양으로 알파벳 출력

            $reduce = 0;                  // 아스키 코드 조절 초기화
            $jumpPlus = $jumpPlus + 2;    // 띄워쓰기 개수 증가
            $minusOne--;                  // 알파벳 출력 1씩 감소
            $alphabet = "A";              // 알파벳 모양 초기화
            $Ask--;                       // 아스키코드 값 감소
            echo "<br>";
        }
    }
    else if ($ex6 == "문제 6번 보기") {
        $alphabetCount = 26;    // 알파벳 개수
        $sumOne = 1;            // 1씩 증가하도록 할 변수
        $minusOne = 25;         // 1씩 감소하도록 할 변수
        $alphabet = "A";        // 화면에 출력할 문자
        $Ask = 65;              // A의 아스키 코드 값
        $jumpMinus = 50;        // 2씩 증가 할 띄워쓰기 개수
        $jumpPlus = 2;          // 2씩 감소 할 띄워쓰기 개수
        $reduce = 0;            // 아스키 코드 값 조절 변수

        for ($i = 0; $i < $alphabetCount; $i++) {
            for ($j = 0; $j < $sumOne; $j++, $alphabet++) {
                if($i == $alphabetCount - 1){
                    echo $alphabet;
                }
                // 반복문의 마지막에는 알파벳 전체 출력
                else if($j == 0 || $j == $sumOne -1){
                    echo $alphabet;
                }
                // 처음과 끝만 출력
                else {
                    echo "&nbsp";
                }
                // 처음과 끝사이의 빈 공간 생성
            }

            for ($k = 0; $k < $jumpMinus; $k++) {
                echo "&nbsp";
            }
            // 빈 공간 생성

            for ($s = 0; $s < $sumOne; $s++, $reduce++) {
                if($i == $alphabetCount - 1){
                    echo chr($Ask - $reduce);
                }
                // 반복문의 마지막에는 알파벳 전체 출력

                else if($s == 0 || $s == $sumOne -1){
                    echo chr($Ask - $reduce);;
                }
                // 처음과 끝만 출력

                else {
                    echo "&nbsp";
                }
                // 처음과 끝사이의 빈 공간 생성
            }

            $reduce = 0;                    // 아스키 코드 조절 초기화
            $jumpMinus = $jumpMinus - 2;    // 띄워쓰기 개수 감소
            $sumOne++;                      // 알파벳 출력 1씩 증가
            $alphabet = "A";                // 화면에 출력할 문자
            $Ask++;                         // 아스키 코드 값 증가
            echo "<br>";
        }

        $Ask = 89;       // Z의 아스키 코드 값
        $reduce = 0;     // 아스키 코드 조절 변수 초기화

        for ($i = 0; $i < $alphabetCount - 1; $i++) {
            for ($j = 0; $j < $minusOne; $j++, $alphabet++) {
                if($j == 0 || $j == $minusOne -1){
                    echo $alphabet;
                }
                // 처음과 끝만 출력

                else {
                    echo "&nbsp";
                }
                // 처음과 끝사이의 빈 공간 생성
            }

            for ($k = 0; $k < $jumpPlus; $k++) {
                echo "&nbsp";
            }
            // 빈 공간 생성

            for ($s = 0; $s < $minusOne; $s++, $reduce++) {
                if($s == 0 || $s == $minusOne -1){
                    echo chr($Ask - $reduce);
                }
                // 처음과 끝만 출력

                else {
                    echo "&nbsp";
                }
                // 처음과 끝사이의 빈 공간 생성
            }

            $reduce = 0;                    // 아스키 코드 조절 초기화
            $jumpPlus = $jumpPlus + 2;      // 띄워쓰기 개수 증가
            $minusOne--;                    // 알파벳 출력 1씩 감소
            $alphabet = "A";                // 알파벳 모양 초기화
            $Ask--;                         // 아스키코드 값 감소
            echo "<br>";
        }
    }
    else {
        $alphabetCount = 26;   // 알파벳 개수

        if ($num == 1) {
            // 첫번째 입력 값이 1인 경우

            $alphabet = "a";   // 알파벳을 소문자로 변경

            for ($i = 0; $i < $alphabetCount; $i++) {
                for ($j = 0; $j < $rowNum; $j++) {
                    echo $alphabet;
                }

                $alphabet++;
                echo "<br>";
            }
            // 알파벳을 두번째 입력값만큼 행을 늘여서 출력
        }
        else if ($num == 2) {
            // 첫번째 입력 값이 2인 경우

            $alphabet = "A";    // 알파벳을 대문자로 변경

            for ($i = 0; $i < $alphabetCount; $i++) {
                for ($j = 0; $j < $rowNum; $j++) {
                    echo $alphabet;
                }

                $alphabet++;
                echo "<br>";
            }
            // 알파벳을 두번째 입력값만큼 행을 늘여서 출력
        }
        else {
            echo "잘못된 입력입니다.";
        }
        // 첫번째 입력 값이 1, 2 이외의 값이 올 경우
    }
?>

<div id="time">
    <script>
        var setTime = 10;  // 시간 초기값

        setInterval(function () {
            setTime--;  // 1초씩 감소

            document.getElementById("time").innerText = setTime;
            // 화면에 남은 시간 출력

            if(setTime == 0){
                window.history.back();
            }
            // 10초가 지나면 전 페이지로 가기
        }, 1000);
        // 1초마다 작동
    </script>
</div>
