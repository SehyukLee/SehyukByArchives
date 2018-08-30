<?php
    session_destroy();      // 세션 삭제

    echo "<script>";
    echo "window.location = 'board_list.php'";
    echo "</script>";
    // 게시판 리스트로 페이지 이동
?>
