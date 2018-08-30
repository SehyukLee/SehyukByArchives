<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<style>
    .table {
        border: 1px solid black;
        border-collapse: collapse;
    }
    // 테이블 스타일
</style>
<body>
<h1 align="center">
    목&nbsp;&nbsp;&nbsp;록
</h1>
<table class="table" align="center" width="800px">
    <tr align="center" bgcolor="#d3d3d3">
        <td class="table">글 번호</td>
        <td class="table">제목</td>
        <td class="table">조회 수</td>
        <td class="table">작성 시간</td>
    </tr>
    <?php
    $inputPage = isset($_GET['page']) ? $_GET['page'] : 1;      // 페이지 번호
    $page = ($inputPage - 1) * 5;                               // 페이지 계산

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");
    // DB연결

    $result = mysql_query("select board_id, subject, hits, reg_date from ycj_first_board where board_pid = 0 order by reg_date desc limit $page, 5");
    // 페이지 내용 검색
    
    $row = mysql_num_rows($result);         // 열의 개수
    $field = mysql_num_fields($result);     // 행의 개수

    $All = mysql_query("select count(board_id) from ycj_first_board where board_pid = 0");
    $All = mysql_fetch_row($All);
    // 전체 게시글 개수 검색
    
    $pageCount = ceil($All[0] / 5);     // 게시글 개수 정리

    for ($i = 0; $i < $row; $i++) {
        $resultArr = mysql_fetch_row($result);

        echo "<tr class=\"table\">";

        for ($j = 0; $j < $field; $j++) {
            echo "<td class=\"table\" width='200px' align='center'>";

            if ($resultArr[$j] == null) {
                echo "";
            }
            else {
                if ($j == 1) {
                    echo "<a href='view_board.php?id=$resultArr[0]'>";
                    echo $resultArr[$j];
                    echo "</a>";
                }
                else {
                    echo $resultArr[$j];
                }
            }

            echo "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    // 게시글 내용 출력
    
    echo "<br>";
    
    // 페이지네이션
    echo "<div align='center'>";

    $nextPage = $inputPage;
    $returnPage = $inputPage;

    if($pageCount > 5) {
        for ($i = 0; $i < 6; $i++) {
            if ($i == 0 && ($nextPage % 5) == 1) {
                $nextPage++;
                continue;
            }

            if (($nextPage % 5) == 1) {
                break;
            }

            $nextPage++;

            if ($nextPage >= $pageCount) {
                $nextPage = $pageCount;
                break;
            }
        }

        $backCount = 0;

        if ($inputPage != 1 && $inputPage != 2 && $inputPage != 3 && $inputPage != 4 && $inputPage != 5) {
            for ($i = 0; $i < 11; $i++) {
                if ($i == 0 && ($returnPage % 5) == 1) {
                    $returnPage--;
                    $backCount = 1;
                    continue;
                }

                if (($returnPage % 5) == 1) {
                    if($backCount == 0) {
                        $backCount++;
                        $returnPage--;
                        continue;
                    }

                    break;
                }

                $returnPage--;
            }
        }
    }

    $startPage = $inputPage;
    $lastPage = $inputPage;

    for ($i = 0; $i < 5; $i++) {
        if(($startPage % 5) == 1){
            break;
        }

        $startPage--;
    }

    for ($i = 0; $i < 5; $i++) {
        if ($lastPage >= $pageCount) {
            $lastPage = $pageCount;
            break;
        }

        if(($lastPage % 5) == 0){
            break;
        }

        $lastPage++;
    }

    if ($pageCount > 5) {
        echo "<a href='list.php?page=$returnPage'>";
        echo "<<";
        echo "</a>";
        echo "&nbsp;";
    }

    for ($i = $startPage; $i <= $lastPage; $i++) {
        echo "<a href='list.php?page=$i' >";
        echo $i;
        echo "</a>";
        echo "&nbsp;";
    }

    if ($pageCount > 5) {
        echo "<a href='list.php?page=$nextPage'>";
        echo ">>";
        echo "</a>";
    }

    echo "</div>";
    // 페이지네이션

    mysql_close($db_con);   // DB연결 종료

    if (isset($_SESSION['userid'])) {
        // 로그인 했을 경우
        
        echo $_SESSION['name']."님이 로그인하셨습니다.<br>";
        echo "<form action=\"logout.php\">";
        echo "<input type=\"submit\" value=\"로그아웃\">";
        echo "</form>";
        echo "<div align=\"center\">";
        echo "<form action=\"writePage.html\">";
        echo "<input type=\"submit\" value=\"글쓰기\">";
        echo "</form>";
        echo "</div>";
    }
    else {
        // 로그인 되어 있지 않을 경우
        
        echo "<form action=\"log_page.html\">";
        echo "<input type=\"submit\" value=\"로그인\">";
        echo "</form>";
    }
    ?>
    <div align="center">
        <form action="find.php" method="get">
            <input type="text" name="find">
            <input type="submit" value="찾기">
        </form>
    </div>
</body>
</html>
