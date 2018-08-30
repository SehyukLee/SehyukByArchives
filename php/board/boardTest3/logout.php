<?php
    session_destroy();  // 세션 삭제

    echo "<script>";
    echo "location.href = 'list.php';";
    echo "</script>";
    // 리스트 페이지로 이동
?>
