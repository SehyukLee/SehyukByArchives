<?php
    $title = isset($_POST['title']) ? $_POST['title'] : false;              // 게시글 제목
    $text = isset($_POST['text']) ? $_POST['text'] : false;                 // 게시글 내용
    $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;       // 게시글 아이디
    $store = isset($_POST['store']) ? $_POST['store'] : false;              // 저장 유무 확인

    $text = str_replace(" ", "&nbps;", $text);
    $text = nl2br($text);
    $text = htmlentities($text, ENT_QUOTES);
    // 문자열 처리

    echo $board_id."<br>";

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");
    // DB연결

    if ($store == "저장") {
        // 저장일 경우
        
        mysql_query("update board set subject = '$title', contents = '$text' where board_id = $board_id");
        // 내용 수정
    }

    mysql_close();  // DB 연결 종료
    
    echo "<script>";
    echo "window.location = 'board_list.php'";
    echo "</script>";
    // 게시판 리스트 페이지로 이동
?>
