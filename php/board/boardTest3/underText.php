<?php
    $user_id = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : null;

    $board_id = isset($_POST['id']) ? $_POST['id'] : null;
    $underText = isset($_POST['text']) ? $_POST['text'] : null;

    $underText = nl2br($underText);
    $underText = str_replace(" ", "&nbsp;", $underText);
    $underText = htmlspecialchars($underText, ENT_QUOTES);
    $toDay = date("Y-m-d H:i:s");

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");

    mysql_query("insert into ycj_first_board values('', $board_id, '$user_id', '$name', '댓글', '$underText', 0, '$toDay')");
    $result = mysql_query("select user_id, contents, reg_date, board_id from ycj_first_board where board_pid = $board_id order by reg_date desc");
    $result = mysql_fetch_row($result);

    $result[1] = htmlspecialchars_decode($result[1]);
    $result[1] = nl2br($result[1]);

    $sendText = $result[0]."|".$result[1]."|".$result[2]."|".$result[3];

    echo $sendText;

    mysql_close($db_con);
?>