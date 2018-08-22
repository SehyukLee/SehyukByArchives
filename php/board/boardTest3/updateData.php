<?php
    $subject = isset($_POST['notNull']) ? $_POST['notNull'] : null;
    $content = isset($_POST['content']) ? $_POST['content'] : null;
    $content = nl2br($content);
    $content = str_replace(" ", "&nbsp;", $content);
    $content = htmlspecialchars($content, ENT_QUOTES);
    $toDay = date("Y-m-d H:i:s");

    if ($subject == null) {
        echo "<script>";
        echo "window.history.back()";
        echo "</script>";
    }
    else {
        @$db_con = mysql_connect("localhost", "root", "autoset");
        mysql_select_db("ycj_test");

        $id = $_SESSION['userid'];
        $name = $_SESSION['name'];

        mysql_query("insert into ycj_first_board values('', 0, '$id', '$name', '$subject', '$content', 0, '$toDay')");
        echo "<script>";
        echo "window.location.replace('list.php')";
        echo "</script>";

        mysql_close($db_con);
    }
?>

