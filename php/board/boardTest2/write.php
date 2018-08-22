<?php
    $title = isset($_POST['title']) ? $_POST['title'] : false;
    $text = isset($_POST['text']) ? $_POST['text'] : false;
    $text = str_replace(" ", "&nbps;", $text);
    $text = nl2br($text);
    $text = htmlentities($text, ENT_QUOTES);
    $today = date("Y-m-d H:i:s");

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");

    $id = $_SESSION['id'];
    $name = $_SESSION['name'];

    mysql_query("insert into board values ('', 0, '$id', '$name', '$title', '$text', 0, '$today')");
    mysql_close();

    echo "<script>";
    echo "window.location = 'board_list.php'";
    echo "</script>";

    mysql_close();
?>