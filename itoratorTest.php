<?php
    class myForeach implements iterator {

        public $result = 0;                        // 배열의 길이가 제일 큰 값
        public $arrCount = 0;                      // 배열 호출 번호
        public $arr1 = array(1, 2, 3, 4, 5);          // 1번 배열
        public $arr2 = array(5, 6, 7);             // 2번 배열
        public $arr3 = array(9, 10, 11, 12, 13);   // 3번 배열

        public function rewind()
        {
            echo "rewind<br>";

            reset($this->arr1);
            reset($this->arr2);
            reset($this->arr3);
            // 각 배열의 첫 번째 값을 시작값으로 지정
        }

        public function valid()
        {
            echo "valid<br>";

            $arr1_Count = count($this->arr1);
            $arr2_Count = count($this->arr2);
            $arr3_Count = count($this->arr3);
            // 각 배열의 길이

            $this->result = ($arr1_Count > $arr2_Count) ? $arr1_Count : $arr2_Count;
            $this->result = ($arr3_Count > $this->result) ? $arr3_Count : $this->result;
            // 배열 길이 비교

            if ($this->result == $arr3_Count) {
                if (key($this->arr3) !== null && key($this->arr3) !== false) {
                    return true;
                }
            }
            elseif ($this->result == $arr2_Count) {
                if (key($this->arr2) !== null && key($this->arr2) !== false) {
                    return true;
                }
            }
            else {
                if (key($this->arr1) !== null && key($this->arr1) !== false) {
                    return true;
                }
            }
            // 배열 길이가 제일 큰 배열의 현재 키값으로 판별

            return false;
        }

        public function key()
        {
            if ($this->arrCount == 0) {
                return key($this->arr1);
            }
            elseif ($this->arrCount == 1) {
                return key($this->arr2);
            }
            else {
                return key($this->arr3);
            }
            // 현재 arrCount의 값에 따라 해당 배열의 키값 반환
        }

        public function current()
        {
            if ($this->arrCount  == 0) {
                return current($this->arr1);
            }
            elseif ($this->arrCount == 1) {
                return current($this->arr2);
            }
            else {
                return current($this->arr3);
            }
            // 현재 arrCount의 값에 따라 해당 배열의 값 반환
        }

        public function next()
        {
            if ($this->arrCount == 0) {
                if (key($this->arr2) !== null && key($this->arr2) !== false) {
                    $this->arrCount++;
                }
                elseif (key($this->arr3) !== null && key($this->arr3) !== false) {
                    $this->arrCount = 2;
                }
                else {
                    $this->arrCount = 0;
                }
                // 다음 순번의 배열의 키값 판별에 따라 다음 배열 지정

                next($this->arr1);  // 키값 증가
            }
            elseif ($this->arrCount == 1) {
                if (key($this->arr3) !== null && key($this->arr3) !== false) {
                    $this->arrCount++;
                }
                elseif (key($this->arr1) !== null && key($this->arr1) !== false) {
                    $this->arrCount = 0;
                }
                else {
                    $this->arrCount = 1;
                }
                // 다음 순번의 배열의 키값 판별에 따라 다음 배열 지정

                next($this->arr2);  // 키값 증가
            }
            else {
                if (key($this->arr1) !== null && key($this->arr1) !== false) {
                    $this->arrCount = 0;
                }
                elseif (key($this->arr2) !== null && key($this->arr2) !== false) {
                    $this->arrCount = 1;
                }
                else {
                    $this->arrCount = 2;
                }
                // 다음 순번의 배열의 키값 판별에 따라 다음 배열 지정

                next($this->arr3);  // 키값 증가
            }
        }
    }

    $obj = new myForeach();

    foreach ($obj as $key=>$value) {
        echo $key.":".$value."<br>";
    }
    // 객체 순환
?>