<?php
    class myForeach implements iterator {
        public $result = 0;                        // �迭�� ���̰� ���� ū ��
        public $arrCount = 0;                      // �迭 ȣ�� ��ȣ
        public $arr1 = array(1, 2, 3, 4, 5);          // 1�� �迭
        public $arr2 = array(5, 6, 7);             // 2�� �迭
        public $arr3 = array(9, 10, 11, 12, 13);   // 3�� �迭
        public function rewind()
        {
            echo "rewind<br>";
            reset($this->arr1);
            reset($this->arr2);
            reset($this->arr3);
            // �� �迭�� ù ��° ���� ���۰����� ����
        }
        public function valid()
        {
            echo "valid<br>";
            $arr1_Count = count($this->arr1);
            $arr2_Count = count($this->arr2);
            $arr3_Count = count($this->arr3);
            // �� �迭�� ����
            $this->result = ($arr1_Count > $arr2_Count) ? $arr1_Count : $arr2_Count;
            $this->result = ($arr3_Count > $this->result) ? $arr3_Count : $this->result;
            // �迭 ���� ��
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
            // �迭 ���̰� ���� ū �迭�� ���� Ű������ �Ǻ�
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
            // ���� arrCount�� ���� ���� �ش� �迭�� Ű�� ��ȯ
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
            // ���� arrCount�� ���� ���� �ش� �迭�� �� ��ȯ
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
                // ���� ������ �迭�� Ű�� �Ǻ��� ���� ���� �迭 ����
                next($this->arr1);  // Ű�� ����
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
                // ���� ������ �迭�� Ű�� �Ǻ��� ���� ���� �迭 ����
                next($this->arr2);  // Ű�� ����
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
                // ���� ������ �迭�� Ű�� �Ǻ��� ���� ���� �迭 ����
                next($this->arr3);  // Ű�� ����
            }
        }
    }
    $obj = new myForeach();
    foreach ($obj as $key=>$value) {
        echo $key.":".$value."<br>";
    }
    // ��ü ��ȯ
?>