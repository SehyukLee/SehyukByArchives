<?php
    $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;       // 클릭한 게시판 아이디
    $under_id = isset($_POST['under_id']) ? $_POST['under_id'] : false;     // 클릭한 댓글 아이디

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");
    // DB 연결

    if ($board_id) {
        // 게시글을 삭제할 경우
        
        mysql_query("delete from board where board_id = $board_id");
        // 게시글 삭제
        
        mysql_close();  // DB 연결 종료

        echo "<script>";
        echo "window.location = 'board_list.php'";
        echo "</script>";
        // 게시판 리스트로 페이지 이동
    }
    else {
        // 댓글을 삭제할 경우
        
        mysql_query("delete from board where board_id = $under_id");
        // 댓글 삭제

        mysql_close();
        // DB 연결 종료
    }
 ?>
