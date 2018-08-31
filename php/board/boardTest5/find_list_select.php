<?php
    $login_user_id = isset($_POST["userid"]) ? $_POST["userid"] : false;    // 유저 아이디
    $findText = isset($_POST["findView"]) ? $_POST["findView"] : false;     // 찾을 게시글 내용
    $nowPage = isset($_POST["page"]) ? $_POST["page"] : 1;                  // 현재 페이지

    if (!$login_user_id) {
        // 로그인 하지 않았을 경우
        
        echo "no userid data";
        exit();
    }

    class DB_info{
        const IP_ADRESS   = "localhost";
        const USER_NAME   = "root";
        const USER_PASSWD = "autoset";
        const DB_NAME     = "shl_board";
    }
    // DB연결에 사용할 값 정리

    class board_DB {
        function findListUp ($userid, $page, $text) {
        $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);
        // DB 연결
            
        if (!$db_con) {
            echo "DB connect fail";
            exit();
        }

        $showPage = ($page * 5) - 5;    // 보여줄 페이지 계산

        $board_list = $db_con->query("select * from board where board_name like '%$text%' order by board_idNum desc limit $showPage, 5");
        // 보여줄 게시글 검색
            
        if (!$board_list) {
            // 검색 실패할 경우
            
            echo "board select query fail";
        }
        else if ($board_list->num_rows == 0) {
            // 찾는 게시글이 없을 경우
            
            echo "no list data";
            exit();
        }
        else {
            // 게시글이 있는 경우
            
            // 게시글 출력
            echo "<div align='center'>";
            echo "<table>";
            echo "<tr align='center'>";
            echo "<td>";
            echo "$userid 님이 로그인하였습니다.";
            echo "</td>";
            echo "</tr>";
            echo "<tr align='center'>";
            echo "<td>";
            echo "<form action='logout.php?userid=$userid' method='post'>";
            echo "<input type='submit' value='로그아웃'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";

            echo "<div align=\"center\">";
            echo "<table>";
            echo "<thead>";
            echo "<tr align='center'><td>글 번호</td><td>제목</td><td>글쓴이</td><td>작성 시간</td></tr>";
            echo "</thead>";
            echo "<tbody>";
          
            for ($i = 0; $i < $board_list->num_rows; $i++) {
                $board_list_re = $board_list->fetch_array(MYSQLI_NUM);

                echo "<tr align='center'>";

                for ($j = 0; $j < $board_list->field_count; $j++) {
                    if ($j == 2) {
                        continue;
                    }

                    echo "<td>";

                    if ($j == 1) {
                        echo "<a href='veiw_board.html?userid=$userid&board_idNum=$board_list_re[0]&findView=$text'>$board_list_re[$j]</a>";
                    }
                    else {
                        echo $board_list_re[$j];
                    }

                    echo "</td>";
                }

                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            // 게시글 출력
            
            // 페이지네이션
            $board_list_page_count = $db_con->query("select count(board_idNum) from board where board_name like '%$text%';");

            if (!$board_list_page_count) {
                echo "page count fail";
                exit();
            }

            $board_list_page_count_re = $board_list_page_count->fetch_array(MYSQLI_NUM);

            echo "<div>";

            $underShowPageStart = $page;
            $underShowPageEnd = $page;
            $lastPage = ceil($board_list_page_count_re[0]/5);

            while ($underShowPageStart % 5 != 1) {
                $underShowPageStart--;
            }

            while ($underShowPageEnd % 5 != 0) {
                $underShowPageEnd++;
            }

            if ($page > 1) {
                if ($page < 6) {
                    echo "<a href='#' onclick='selectList(1)'><<</a>&nbsp;";
                }
                else {
                    echo "<a href='#' onclick='selectList($underShowPageStart-5)'><<</a>&nbsp;";
                }

                echo "<a href='#' onclick='selectList($page-1)'><</a>&nbsp;";
            }

            for ($i = $underShowPageStart; $i <= $underShowPageEnd; $i++) {
                if ($i > $lastPage) {
                    break;
                }

                if ($page == $i) {
                    echo "$i&nbsp;";
                }
                else {
                    echo "<a href='#' onclick='selectList($i)'>$i</a>&nbsp;";
                }
            }

            if ($page != $lastPage) {
                echo "<a href='#' onclick='selectList($page+1)'>></a>&nbsp;";

                if ($lastPage - $underShowPageStart < 5) {
                    echo "<a href='#' onclick='selectList($lastPage)'>>></a>&nbsp;";
                }
                else {
                    echo "<a href='#' onclick='selectList($underShowPageStart+5)'>>></a>&nbsp;";
                }
            }
            // 페이지네이션

            echo "</div>";
            echo "</div>
                       <div align=\"center\">
                            <input type=\"button\" value=\"글쓰기\" onclick=\"board_write()\">
                            <input type=\"text\" id='findView'>
                            <input type=\"button\" value=\"검색\" onclick='find()'>
                       </div>";
            // 버튼 출력

        }
    }
}

$shl_board_db = new board_DB();                                     // DB연결 객체 생성
$shl_board_db->findListUp($login_user_id, $nowPage, $findText);     // 찾는 내용을 가진 게시글 
?>
