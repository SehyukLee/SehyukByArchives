<?php
    $under_id = isset($_POST['id']) ? $_POST['id'] : null;
    $content = isset($_POST['text']) ? $_POST['text'] : null;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");

    $content = nl2br($content);
    $content = str_replace(" ", "&nbsp;", $content);
    $content = htmlspecialchars($content, ENT_QUOTES);
    $toDay = date("Y-m-d H:i:s");


    mysql_query("update ycj_first_board set contents = '$content', reg_date = '$toDay' where board_id = $under_id");

    $update_under = mysql_query("select contents, reg_date from ycj_first_board where board_id = $under_id");
    $update_under_Arr = mysql_fetch_row($update_under);

    $update_under_Arr[0] = htmlspecialchars_decode($update_under_Arr[0]);
    $update_under_Arr[0] = nl2br($update_under_Arr[0]);

    echo $update_under_Arr[0]."|".$update_under_Arr[1];
?>






