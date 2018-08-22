<?php
    $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;
    $under_id = isset($_POST['under_id']) ? $_POST['under_id'] : false;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");

    if ($board_id) {
        mysql_query("delete from board where board_id = $board_id");

        mysql_close();

        echo "<script>";
        echo "window.location = 'board_list.php'";
        echo "</script>";
    }
    else {
        mysql_query("delete from board where board_id = $under_id");

        mysql_close();
    }
 ?>