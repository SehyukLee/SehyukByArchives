<?php
    $user_id = isset($_POST['userid']) ? $_POST['userid'] : false;
    $user_name = isset($_POST['username']) ? $_POST['username'] : false;
    $user_pass = isset($_POST['userpassword']) ? $_POST['userpassword'] : false;
    $user_classi = isset($_POST['classification']) ? $_POST['classification'] : false;
    $user_gender = isset($_POST['gender']) ? $_POST['gender'] : false;
    $user_phone = isset($_POST['phone']) ? $_POST['phone'] : false;
    $user_email = isset($_POST['email']) ? $_POST['email'] : false;
    //<---------- 변수 선언부 ----------->

    //<---------- 변수 검사 ----------->
    if (!($user_id && $user_name && $user_pass && $user_phone && $user_email)) {
        echo "데이터를 전부 넣지 않았습니다.<br>";

        $data_arr = array($user_id, $user_name, $user_pass, $user_phone, $user_email, $user_classi, $user_gender);

        if (!$data_arr[0]) {
            echo "사용자 ID ";
        }

        if (!$data_arr[1]) {
            echo "이름 ";
        }

        if (!$data_arr[2]) {
            echo "암호 ";
        }

        if (!$data_arr[3]) {
            echo "전화번호 ";
        }

        if (!$data_arr[4]) {
            echo "이메일 ";
        }
        //<---------- 변수 검사 ----------->

        include "register.html";

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
    else {
        //<---------- DB 연결 실패 시 예외처리 ----------->
        try {
            $obj = new database();
            $obj -> insert($user_id, $user_name, $user_pass, $user_classi, $user_gender, $user_phone, $user_email);
            $obj -> db_close();

            echo "<script>
               alert('수정완료');
               location.href='main.html';
               </script>";
        } catch (Exception $e) {
            echo "<script>
                alert('DB 연결 실패');
                location.href = 'main.html';
               </script>";
        }
        //<---------- DB 연결 실패 시 예외처리 ----------->
    }

    class database {
        private $db_con;

        //<---------- DB 연결 ----------->
        function __construct () {
            @$this -> db_con = mysql_connect("localhost", "root", "autoset");

            if (!$this->db_con) {
                throw new Exception();
            }

            @mysql_select_db("midtermexam");
        }
        //<---------- DB 연결 ----------->

        //<---------- 정보 추가 ----------->
        function insert ($id, $name, $pass, $classi, $gender, $phone, $email) {
            mysql_query("insert into userinfo() values ('', '$id', '$classi', '$name', '$gender', '$pass', '$phone', '$email')");
        }
        //<---------- 정보 추가 ----------->

        //<---------- DB 연결 종료 ----------->
        function db_close () {
            mysql_close($this -> db_con);
        }
        //<---------- DB 연결 종료 ----------->
    }
?>