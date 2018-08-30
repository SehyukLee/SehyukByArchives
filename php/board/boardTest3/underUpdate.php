<?php
    $under_id = isset($_POST['id']) ? $_POST['id'] : null;      // 댓글 아이디
    $content = isset($_POST['text']) ? $_POST['text'] : null;   // 댓글 내용

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");
    // DB연결

    $content = nl2br($content);
    $content = str_replace(" ", "&nbsp;", $content);
    $content = htmlspecialchars($content, ENT_QUOTES);
    // 문자열 처리

    $toDay = date("Y-m-d H:i:s");   // 현재 날짜

    mysql_query("update ycj_first_board set contents = '$content', reg_date = '$toDay' where board_id = $under_id");
    // 댓글 수정

    $update_under = mysql_query("select contents, reg_date from ycj_first_board where board_id = $under_id");
    $update_under_Arr = mysql_fetch_row($update_under);
    // 댓글 검색

    $update_under_Arr[0] = htmlspecialchars_decode($update_under_Arr[0]);
    $update_under_Arr[0] = nl2br($update_under_Arr[0]);
    // 문자열 처리

    mysql_close($db_con);   // DB연결 종료

    echo $update_under_Arr[0]."|".$update_under_Arr[1];     // 데이터 전송
?>






