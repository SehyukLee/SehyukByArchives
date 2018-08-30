<?php
    session_destroy();  // 세션 삭제

    $input_id = isset($_POST['input_id']) ? $_POST['input_id'] : null;                      // 입력한 아이디
    $input_password = isset($_POST['input_password']) ? $_POST['input_password'] : null;    // 입력한 비밀번호

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("log_test");
    // DB연결

    $result = mysql_query("select * from user where userid='$input_id' and password='$input_password'");
    $resultArr = mysql_fetch_row($result);
    // 입력한 아이디와 비밀번호를 가진 유저가 있는지 확인

    if (isset($resultArr[0])) {
        // 있을 경우
        
        session_start();
        $_SESSION['userid'] = $resultArr[0];    // 세션 아이디 저장
        $_SESSION['name'] = $resultArr[2];      // 세션 이름 저장
        echo "<script>";
        echo "location.href = 'list.php';";
        echo "</script>";
    }
    else {
        // 없을 경우
        
        echo "<script>";
        echo "alert('로그인 실패');";
        echo "location.href = 'list.php';";
        echo "</script>";
    }
?>
