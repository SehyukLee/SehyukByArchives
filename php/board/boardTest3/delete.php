<?php
    $delete_id = isset($_GET['id']) ? $_GET['id'] : null;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");

    $goView = mysql_query("select board_pid from ycj_first_board where board_id = $delete_id");
    $goviewArr = mysql_fetch_row($goView);

    $result = mysql_query("delete from ycj_first_board where board_id = $delete_id");

    mysql_close($db_con);
?>
<script>
    alert("삭제 되었습니다.");
    <?php
            if ($goviewArr[0] == 0) {
                echo "location.href = 'list.php'";
            }
            else {
                echo "location.href = 'view_board.php?id=$goviewArr[0]'";
            }
    ?>
</script>
