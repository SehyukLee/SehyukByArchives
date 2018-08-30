<?php
    session_destroy();      // 세션 삭제

    $id = isset($_POST['id']) ? $_POST['id'] : false;                   // 입력한 아이디
    $passwd = isset($_POST['password']) ? $_POST['password'] : false;   // 입력한 비밀번호 

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board_customer");
    // DB 연결

    $check = mysql_query("select id, password, name from customer where id = '$id' and password = '$passwd'");
    $check = mysql_fetch_row($check);
    // 입력한 아이디와 비밀번호를 동시에 가진 유저가 있는지 확인

    if ($check[0]) {
        // 있을 경우
        
        session_start();                // 세션 시작
        $_SESSION['name'] = $check[2];  // 세션 이름
        $_SESSION['id'] = $id;          // 세션 아이디

        echo "<script>";
        echo "window.location = 'board_list.php'";
        echo "</script>";
        // 로그인 된 상태로 게시판 리스트 페이지로 이동
    }
    else {
        // 없을 경우
        
        echo "<script>";
        echo "window.location = 'board_list.php?page=noid'";
        echo "</script>";
        // 로그인 안된 상태로 리스트 페이지로 이동
    }

    mysql_close();
?>
