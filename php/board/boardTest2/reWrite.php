<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <?php
        $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;

        @$db_con = mysql_connect("localhost", "root", "autoset");
        mysql_select_db("sehyuk_board");

        $result = mysql_query("select subject, contents from board where board_id = $board_id");
        $result = mysql_fetch_row($result);

        $result[1] = html_entity_decode($result[1]);
        $result[1] = str_replace("&nbps;", " ", $result[1]);
        $result[1] = strip_tags($result[1]);

        echo "<form method=\"post\" action=\"writeUpdate.php?board_id=$board_id\">";
        echo "제목&nbsp;<input type=\"text\" name=\"title\" value='$result[0]'>";
        echo "<br>내용<br>";
        echo "<textarea name=\"text\" style=\"width: 500px; height: 500px\">$result[1]</textarea><br>";

        mysql_close();
    ?>
    <input type="submit" value="저장" name="store">
    <input type="submit" value="취소" name="exit">
</form>
</body>
</html>