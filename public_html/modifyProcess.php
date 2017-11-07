<?php
    $user_id = isset($_POST['userid']) ? $_POST['userid'] : false;
    $user_name = isset($_POST['username']) ? $_POST['username'] : false;
    $user_pass = isset($_POST['userpassword']) ? $_POST['userpassword'] : false;
    $user_classi = isset($_POST['classification']) ? $_POST['classification'] : false;
    $user_gender = isset($_POST['gender']) ? $_POST['gender'] : false;
    $user_phone = isset($_POST['phone']) ? $_POST['phone'] : false;
    $user_email = isset($_POST['email']) ? $_POST['email'] : false;
    //<---------- 변수 선언부 ----------->

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

        //<---------- DB 연결 종료 ----------->
        function db_close () {
            mysql_close($this -> db_con);
        }
        //<---------- DB 연결 종료 ----------->
    }

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
?>