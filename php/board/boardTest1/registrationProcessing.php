<?php
    try {
        $user_id = isset($_POST['userid']) ? $_POST['userid'] : false;
        $user_name = isset($_POST['username']) ? $_POST['username'] : false;
        $user_pass = isset($_POST['userpassword']) ? $_POST['userpassword'] : false;
        $user_classi = isset($_POST['classification']) ? $_POST['classification'] : false;
        $user_gender = isset($_POST['gender']) ? $_POST['gender'] : false;
        $user_phone = isset($_POST['phone']) ? $_POST['phone'] : false;
        $user_email = isset($_POST['email']) ? $_POST['email'] : false;
        //<---------- �Ѿ�� �� ���� Ȯ�� ----------->
        if (!($user_id && $user_name && $user_pass && $user_phone && $user_email)) {
            throw new Exception();
            //<---------- �Ѿ�� �� �ϳ��� ���� �� ���ܹ߻� ----------->
        }
        else {
            //<---------- DB ���� ���� �� ����ó�� ----------->
            try {
                $obj = new database();
                $obj -> insert($user_id, $user_name, $user_pass, $user_classi, $user_gender, $user_phone, $user_email);
                $obj -> db_close();
                echo "<script>
               alert('�����Ϸ�');
               location.href='main.html';
               </script>";
            } catch (Exception $e) {
                echo "<script>
                alert('DB ���� ����');
                location.href = 'main.html';
               </script>";
            }
            //<---------- DB ���� ���� �� ����ó�� ----------->
        }
    } catch (Exception $e) {
        echo "�����͸� ���� ���� �ʾҽ��ϴ�.<br>";
        $data_arr = array($user_id, $user_name, $user_pass, $user_phone, $user_email, $user_classi, $user_gender);
        if (!$data_arr[0]) {
            echo "����� ID ";
        }
        if (!$data_arr[1]) {
            echo "�̸� ";
        }
        if (!$data_arr[2]) {
            echo "��ȣ ";
        }
        if (!$data_arr[3]) {
            echo "��ȭ��ȣ ";
        }
        if (!$data_arr[4]) {
            echo "�̸��� ";
        }
        //<---------- ���� ���� ����ڵ鿡�� ǥ�� ----------->
        include "register.html";
        echo "<script>";
        //<---------- �Է� �� �״�� ������Ű�� ----------->
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
        //<---------- �Է� �� �״�� ������Ű�� ----------->
        echo "</script>";
    }
    class database {
        private $db_con;
        //<---------- DB ���� ----------->
        function __construct () {
            @$this -> db_con = mysql_connect("localhost", "root", "autoset");
            if (!$this->db_con) {
                throw new Exception();
            }
            @mysql_select_db("midtermexam");
        }
        //<---------- DB ���� ----------->
        //<---------- ���� �߰� ----------->
        function insert ($id, $name, $pass, $classi, $gender, $phone, $email) {
            mysql_query("insert into userinfo() values ('', '$id', '$classi', '$name', '$gender', '$pass', '$phone', '$email')");
        }
        //<---------- ���� �߰� ----------->
        //<---------- DB ���� ���� ----------->
        function db_close () {
            mysql_close($this -> db_con);
        }
        //<---------- DB ���� ���� ----------->
    }
?>