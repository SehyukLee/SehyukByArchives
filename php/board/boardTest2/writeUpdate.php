<?php
    $title = isset($_POST['title']) ? $_POST['title'] : false;
    $text = isset($_POST['text']) ? $_POST['text'] : false;
    $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;
    $store = isset($_POST['store']) ? $_POST['store'] : false;
    $text = str_replace(" ", "&nbps;", $text);
    $text = nl2br($text);
    $text = htmlentities($text, ENT_QUOTES);

    echo $board_id."<br>";

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");

    if ($store == "저장") {
        mysql_query("update board set subject = '$title', contents = '$text' where board_id = $board_id");

        echo "<script>";
        echo "window.location = 'board_list.php'";
        echo "</script>";
    }
    else {
        echo "<script>";
        echo "window.location = 'board_list.php'";
        echo "</script>";
    }

    mysql_close();
?>