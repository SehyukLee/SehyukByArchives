<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .tableStyle {
            border: solid 1px;
            border-color: black;
            text-align: center;
        }
    </style>
</head>
<body>
<h1 align="center">세혁이의 게시판</h1>
<br>
<div align="center">
    <form method="get" action="find.php">
        <input type="text" name="finder">
        <input type="submit" value="검색">
    </form>
</div>
<br>
<table class="tableStyle" style="height: 300px; width: 700px" align="center">
    <tr>
        <td class="tableStyle">글번호</td>
        <td class="tableStyle" style="width: 150px">제목</td>
        <td class="tableStyle">날짜</td>
        <td class="tableStyle">조회수</td>
    </tr>
    <?php
    $find = isset($_GET['finder']) ? $_GET['finder'] : false;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $pageCount = ($page - 1) * 5;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");

    $board = mysql_query("select board_id, subject, reg_date, hits from board where subject like '%$find%' order by board_id desc limit $pageCount, 5");

    for ($i = 0; $i < mysql_num_rows($board); $i++) {
        $board_result = mysql_fetch_row($board);

        if ($board_result[0] == null) {
            echo "<script>";
            echo "window.location = 'board_list.php?page=no'";
            echo "</script>";
        }

        echo "<tr>";

        for ($j = 0; $j < count($board_result); $j++) {
            echo "<td class=\"tableStyle\">";

            if ($j == 1) {
                echo "<a href='viewer.php?id=$board_result[0]'>";
                echo $board_result[$j];
                echo "</a>";
            }
            else {
                echo $board_result[$j];
            }

            echo "</td>";
        }

        echo "</tr>";
    }
    echo "</table>";

    echo "<br><div align='center'>";

    $id_count = mysql_query("select count(board_id) from board where subject like '%$find%'");
    $id_count = mysql_fetch_row($id_count);

    $lastPage = 0;
    $firstPage = 0;
    $stopPage = ceil($id_count[0] / 5);

    for ($i = $page; $i < $page + 5; $i++) {
        if ($i % 5 == 0) {
            $lastPage = $i;

            if ($lastPage > $stopPage) {
                $lastPage = $stopPage;
            }

            break;
        }
    }

    for ($i = $page; $i > $page - 5; $i--) {
        if ($i % 5 == 1) {
            $firstPage = $i;
            break;
        }
    }

    if ($page > 5) {
        $returnPage = $firstPage - 5;

        echo "<a href='find.php?page=$returnPage&finder=$find'>";
        echo "<";
        echo "</a>";
        echo "&nbsp;";
    }

    for ($i = $firstPage; $i <= $lastPage; $i++) {
        echo "<a href='find.php?page=$i&finder=$find'>";
        echo $i;
        echo "</a>";
        echo "&nbsp;";
    }

    if ($id_count[0] > 25) {
        if ($lastPage % 5 == 0) {
            $nextPage = $lastPage + 1;

            echo "<a href='find.php?page=$nextPage&finder=$find'>";
            echo ">";
            echo "</a>";
        }
    }

    echo "</div>";

    mysql_close();
    ?>

    <br>
    <div align="center">
        <form action="viewWrite.html">
            <input type="submit" value="글쓰기">
        </form>
    </div>
</body>
</html>
