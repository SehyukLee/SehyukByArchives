<?php
    session_destroy();

    $id = isset($_POST['id']) ? $_POST['id'] : false;
    $passwd = isset($_POST['password']) ? $_POST['password'] : false;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board_customer");

    $check = mysql_query("select id, password, name from customer where id = '$id' and password = '$passwd'");
    $check = mysql_fetch_row($check);

    if ($check[0]) {
        session_start();
        $_SESSION['name'] = $check[2];
        $_SESSION['id'] = $id;

        echo "<script>";
        echo "window.location = 'board_list.php'";
        echo "</script>";
    }
    else {
        echo "<script>";
        echo "window.location = 'board_list.php?page=noid'";
        echo "</script>";
    }

    mysql_close();
?>