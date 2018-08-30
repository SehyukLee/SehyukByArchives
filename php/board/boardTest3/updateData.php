<?php
    $subject = isset($_POST['notNull']) ? $_POST['notNull'] : null;     // 게시글 제목
    $content = isset($_POST['content']) ? $_POST['content'] : null;     // 게시글 내용
    
    $content = nl2br($content);
    $content = str_replace(" ", "&nbsp;", $content);
    $content = htmlspecialchars($content, ENT_QUOTES);
    // 문자열 처리

    $toDay = date("Y-m-d H:i:s");   // 현재 날짜

    if ($subject == null) {
        // 제목이 없을 경우
        
        echo "<script>";
        echo "window.history.back()";
        echo "</script>";
        // 뒤로 돌아가기
    }
    else {
        @$db_con = mysql_connect("localhost", "root", "autoset");
        mysql_select_db("ycj_test");
        // DB연결

        $id = $_SESSION['userid'];  // 유저 아이디
        $name = $_SESSION['name'];  // 유저 이름

        mysql_query("insert into ycj_first_board values('', 0, '$id', '$name', '$subject', '$content', 0, '$toDay')");
        // 게시글 저장
        
        mysql_close($db_con);   // DB연결 종료
        
        echo "<script>";
        echo "window.location.replace('list.php')";
        echo "</script>";
        // 게시판 리스트 페이지로 이동
    }
?>

