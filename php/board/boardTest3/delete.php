<?php
    $delete_id = isset($_GET['id']) ? $_GET['id'] : null;       // 삭제할 게시글 아이디

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");
    // DB연결

    $goView = mysql_query("select board_pid from ycj_first_board where board_id = $delete_id");
    $goviewArr = mysql_fetch_row($goView);
    // 돌아갈 번호 확인

    $result = mysql_query("delete from ycj_first_board where board_id = $delete_id");
    // 게시글 삭제

    mysql_close($db_con);   // DB연결 종료
?>
<script>
    alert("삭제 되었습니다.");
    
    <?php
            if ($goviewArr[0] == 0) {
                // 돌아갈 번호 없을 경우
                
                echo "location.href = 'list.php'";
            }
            else {
                // 돌아갈 번호 있을 경우
                
                echo "location.href = 'view_board.php?id=$goviewArr[0]'";
            }
    ?>
</script>
