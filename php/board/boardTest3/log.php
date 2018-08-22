<?php
    session_destroy();

    $input_id = isset($_POST['input_id']) ? $_POST['input_id'] : null;
    $input_password = isset($_POST['input_password']) ? $_POST['input_password'] : null;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("log_test");

    $result = mysql_query("select * from user where userid='$input_id' and password='$input_password'");
    $resultArr = mysql_fetch_row($result);

    if (isset($resultArr[0])) {
        session_start();
        $_SESSION['userid'] = $resultArr[0];
        $_SESSION['name'] = $resultArr[2];
        echo "<script>";
        echo "location.href = 'list.php';";
        echo "</script>";
    }
    else {
        echo "<script>";
        echo "alert('로그인 실패');";
        echo "location.href = 'list.php';";
        echo "</script>";
    }
?>