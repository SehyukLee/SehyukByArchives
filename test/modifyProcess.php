<?php
    try {
        $user_id = isset($_POST['userid']) ? $_POST['userid'] : false;
        $user_name = isset($_POST['username']) ? $_POST['username'] : false;
        $user_pass = isset($_POST['userpassword']) ? $_POST['userpassword'] : false;
        $user_classi = isset($_POST['classification']) ? $_POST['classification'] : false;
        $user_gender = isset($_POST['gender']) ? $_POST['gender'] : false;
        $user_phone = isset($_POST['phone']) ? $_POST['phone'] : false;
        $user_email = isset($_POST['email']) ? $_POST['email'] : false;
        $checkId = isset($_POST['ckeckId']) ? $_POST['ckeckId'] : false;
        //<---------- 넘어온 값 유무 확인 ----------->

        if(!$checkId) {
            //<---------- 등록하기 버튼 눌렀을 시 ----------->

            if (!($user_id && $user_name && $user_pass && $user_phone && $user_email)) {
                throw new Exception();
                //<---------- 넘어온 값 하나라도 없을 시 예외발생 ----------->
            }
            else {
                //<---------- DB 연결 실패 시 예외처리 ----------->
                try {
                    $obj = new database();
                    $obj -> update($user_id, $user_name, $user_pass, $user_classi, $user_gender, $user_phone, $user_email);
                    $obj -> db_close();
                } catch (Exception $e) {
                    echo "<script>
                alert('DB 연결 실패');
                location.href = 'main.html';
               </script>";
                }
                //<---------- DB 연결 실패 시 예외처리 ----------->
            }
        }
        else {
            //<---------- 사용자 정보 조회 시 ----------->

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
        }
    } catch (Exception $e) {

        $data_arr = array($user_id, $user_name, $user_pass, $user_phone, $user_email, $user_classi, $user_gender);

        echo "<script>
                alert('아래 항목은 필수 항목 입니다.');
               </script>";
        //<---------- 값이 없음을 사용자들에게 표시 ----------->

        include "modify.html";

        echo "<script>";

        //<---------- 입력 값 그대로 유지시키기 ----------->
        if ($data_arr[0]) {
            echo "document.getElementsByName('userid')[0].value = '$data_arr[0]';";
        }

        if ($data_arr[1]) {
            echo "document.getElementsByName('username')[0].value = '$data_arr[1]';";
        }

        if ($data_arr[2]) {
            echo "document.getElementsByName('userpassword')[0].value = '$data_arr[2]';";
        }

        if ($data_arr[3]) {
            echo "document.getElementsByName('phone')[0].value = '$data_arr[3]';";
        }

        if ($data_arr[4]) {
            echo "document.getElementsByName('email')[0].value = '$data_arr[4]';";
        }

        if ($data_arr[5]) {
            if ($data_arr[5] == "staff") {
                echo "document.getElementsByName('classification')[0].selectedIndex = '0';";
            } else {
                echo "document.getElementsByName('classification')[0].selectedIndex = '1';";
            }
        }

        if ($data_arr[6]) {
            if ($data_arr[6] == "male") {
                echo "document.getElementsByName('gender')[0].selectedIndex = '0';";
            } else {
                echo "document.getElementsByName('gender')[0].selectedIndex = '1';";
            }
        }
        //<---------- 입력 값 그대로 유지시키기 ----------->

        echo "</script>";
    }

    class database {
        private $db_con;

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

        //<---------- 정보 수정 ----------->
        function update ($id, $name, $pass, $classi, $gender, $phone, $email) {
            mysql_query("update userinfo set classification = '$classi', name = '$name', gender = '$gender', password = '$pass', phone = '$phone', email = '$email' where userid = '$id'");

            echo "<script>
                  alert('수정완료');
                  location.href='main.html';
                  </script>";
        }
        //<---------- 정보 수정 ----------->

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
        function db_close () {
            mysql_close($this -> db_con);
        }
        //<---------- DB 연결 종료 ----------->
    }
?>