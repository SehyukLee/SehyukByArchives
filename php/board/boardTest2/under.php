<?php
    $underText = isset($_POST['underText']) ? $_POST['underText'] : false;
    $board_id = isset($_POST['board_id']) ? $_POST['board_id'] : false;
    $underText = str_replace(" ", "&nbps;", $underText);
    $underText = htmlentities($underText, ENT_QUOTES);
    $user_id = $_SESSION['id'];
    $user_name = $_SESSION['name'];
    $today = date("Y-m-d H:i:s");

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");

    mysql_query("insert into board values ('', $board_id, '$user_id', '$user_name', '댓글', '$underText', 0, '$today')");

    mysql_close();

    $underText = html_entity_decode($underText);
    $underText = str_replace("&nbps;", " ", $underText);

    echo $underText;
?>