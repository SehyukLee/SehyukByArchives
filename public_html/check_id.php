<?php
    $checkId = isset($_POST['ckeckId']) ? $_POST['ckeckId'] : false;
    //<---------- 변수 선언부 ----------->

    class database {
        private $db_con;
        private $result;

        //<---------- DB 연결 ----------->
        function __construct()
        {
            @$this -> db_con = mysql_connect("localhost", "root", "autoset");

            if (!$this->db_con) {
                throw new Exception();
            }

            mysql_select_db("midtermexam");
        }
        //<---------- DB 연결 ----------->

        function select ($id) {
            //<---------- ID 검사 ----------->
            $this -> result = mysql_query("select userid, name, password, classification, gender, phone, email from userinfo where userid = '$id' ");
            $result_arr = mysql_fetch_row($this->result);

            include "modify.html";

            echo "<script>";


            if (!($result_arr[0] == $id)) {
                echo "alert('해당 ID는 없는 아이디입니다.');";
            }
            //<---------- ID 검사 ----------->

            //<---------- 입력 값 그대로 유지시키기 ----------->
            else {
                echo "document.getElementsByName('userid')[0].value = '$result_arr[0]';";
                echo "document.getElementsByName('username')[0].value = '$result_arr[1]';";
                echo "document.getElementsByName('userpassword')[0].value = '$result_arr[2]';";

                if ($result_arr[3] == "staff") {
                    echo "document.getElementsByName('classification')[0].selectedIndex = '0';";
                } else {
                    echo "document.getElementsByName('classification')[0].selectedIndex = '1';";
                }

                if ($result_arr[4] == "male") {
                    echo "document.getElementsByName('gender')[0].selectedIndex = '0';";
                } else {
                    echo "document.getElementsByName('gender')[0].selectedIndex = '1';";
                }

                echo "document.getElementsByName('gender')[0].value = '$result_arr[4]';";
                echo "document.getElementsByName('phone')[0].value = '$result_arr[5]';";
                echo "document.getElementsByName('email')[0].value = '$result_arr[6]';";
            }
            //<---------- 입력 값 그대로 유지시키기 ----------->

            echo "</script>";
        }

        //<---------- DB 연결 종료 ----------->
        function  db_close()
        {
            mysql_close($this -> db_con);
        }
        //<---------- DB 연결 종료 ----------->
    }

    //<---------- DB 연결 실패 시 예외처리 ----------->
    try {
        $obj = new database();
        $obj -> select($checkId);
        $obj ->db_close();
    } catch (Exception $e) {
        echo "<script>
                alert('DB 연결 실패');
                location.href = 'main.html';
               </script>";
    }
    //<---------- DB 연결 실패 시 예외처리 ----------->
?>