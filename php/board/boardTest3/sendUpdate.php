<?php
    $update_id = isset($_POST['update_id']) ? $_POST['update_id'] : null;   // 수정 할 게시글 아이디
    $subject = isset($_POST['notNull']) ? $_POST['notNull'] : null;         // 수정 할 게시글 제목
    $content = isset($_POST['content']) ? $_POST['content'] : null;         // 수정 할 게시글 내용

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");
    // DB연결

    mysql_query("update ycj_first_board set subject = '$subject', contents = '$content' where board_id = $update_id");
    // 게시글 수정

    mysql_close($db_con);   // DB연결 종료
?>
<script>
    alert("수정 되었습니다.");
    location.href = 'list.php'
</script>
