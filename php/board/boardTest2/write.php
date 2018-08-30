<?php
    $title = isset($_POST['title']) ? $_POST['title'] : false;      // 게시글 제목
    $text = isset($_POST['text']) ? $_POST['text'] : false;         // 게시글 내용
    
    $text = str_replace(" ", "&nbps;", $text);
    $text = nl2br($text);
    $text = htmlentities($text, ENT_QUOTES);
    // 문자열 처리

    $today = date("Y-m-d H:i:s");   // 현재 날짜

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");
    // DB연결

    $id = $_SESSION['id'];          // 로그인한 유저 아이디
    $name = $_SESSION['name'];      // 로그인한 유저 이름

    mysql_query("insert into board values ('', 0, '$id', '$name', '$title', '$text', 0, '$today')");
    // 게시글 저장

    mysql_close();                  // DB연결 종료

    echo "<script>";
    echo "window.location = 'board_list.php'";
    echo "</script>";
    // 게시판 리스트로 페이지 이동
?>
