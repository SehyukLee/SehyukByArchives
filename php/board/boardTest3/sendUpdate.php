<?php
    $update_id = isset($_POST['update_id']) ? $_POST['update_id'] : null;
    $subject = isset($_POST['notNull']) ? $_POST['notNull'] : null;
    $content = isset($_POST['content']) ? $_POST['content'] : null;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");

    mysql_query("update ycj_first_board set subject = '$subject', contents = '$content' where board_id = $update_id");

    mysql_close($db_con);
?>
<script>
    alert("수정 되었습니다.");
    location.href = 'list.php'
</script>
