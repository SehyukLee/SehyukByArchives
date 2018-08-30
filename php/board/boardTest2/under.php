<?php
    $underText = isset($_POST['underText']) ? $_POST['underText'] : false;  // 댓글 내용
    $board_id = isset($_POST['board_id']) ? $_POST['board_id'] : false;     // 게시글 아이디
    
    $underText = str_replace(" ", "&nbps;", $underText);
    $underText = htmlentities($underText, ENT_QUOTES);
    // 문자열 처리

    $user_id = $_SESSION['id'];         // 로그인한 유저 아이디
    $user_name = $_SESSION['name'];     // 로그인한 유저 이름
    $today = date("Y-m-d H:i:s");       // 현재 날짜

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");
    // DB연결

    mysql_query("insert into board values ('', $board_id, '$user_id', '$user_name', '댓글', '$underText', 0, '$today')");
    // 입력한 댓글 저장

    mysql_close();  // DB 연결 종료

    $underText = html_entity_decode($underText);
    $underText = str_replace("&nbps;", " ", $underText);
    // 문자열 처리

    echo $underText;    // 댓글 출력
?>
