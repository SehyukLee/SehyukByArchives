<?php
    $user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;     // 유저 아이디
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : null;            // 유저 이름

    $board_id = isset($_POST['id']) ? $_POST['id'] : null;                  // 게시글 아이디
    $underText = isset($_POST['text']) ? $_POST['text'] : null;             // 댓글 내용

    $underText = nl2br($underText);
    $underText = str_replace(" ", "&nbsp;", $underText);
    $underText = htmlspecialchars($underText, ENT_QUOTES);
    // 문자열 처리

    $toDay = date("Y-m-d H:i:s");   // 현재 날짜

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");
    // DB연결

    mysql_query("insert into ycj_first_board values('', $board_id, '$user_id', '$name', '댓글', '$underText', 0, '$toDay')");
    // 댓글 저장

    $result = mysql_query("select user_id, contents, reg_date, board_id from ycj_first_board where board_pid = $board_id order by reg_date desc");
    $result = mysql_fetch_row($result);
    // 댓글 검색

    $result[1] = htmlspecialchars_decode($result[1]);
    $result[1] = nl2br($result[1]);
    $sendText = $result[0]."|".$result[1]."|".$result[2]."|".$result[3];
    // 문자열 처리

    mysql_close($db_con);   // DB연결 종료

    echo $sendText; // 데이터 전송
?>
