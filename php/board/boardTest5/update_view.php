<?php
    $login_user_id = isset($_POST["userid"]) ? $_POST["userid"] : false;            // 유저 아이디
    $board_idNum = isset($_POST["board_idNum"]) ? $_POST["board_idNum"] : false;    // 게시글 아이디

    if (!$login_user_id) {
        // 로그인하지 않았을 경우
        
        echo "no userid data";
        exit();
    }

    if (!$board_idNum) {
        // 게시글 번호가 없을 경우
        
        echo "no board_idNum";
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
        function viewSelect ($userid, $boardNum) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);
            // DB연결
            
            if (!$db_con) {
                echo "DB connect fail";
                exit();
            }

            $view = $db_con->query("select board_name, board_content, user_id from board where board_idNum=$boardNum");
            // 게시글 검색
            
            if (!$view) {
                echo "board select query fail";
            }

            $view_re = $view->fetch_array(MYSQLI_NUM);
            
            // 게시글 출력
            echo "<form action='save_updateView.php?userid=$userid&board_idNum=$boardNum' method='post'>
                    <table align=\"center\">
                        <thead>
                            <tr align=\"center\">
                                <td>
                                    제목
                                </td>
                                <td>
                                    <input type='text' value='$view_re[0]' name=\"title\">
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan=\"2\">
                                    <textarea style=\"width: 300px; height: 300px\" name=\"content\">
                                        $view_re[1]
                                    </textarea>
                                </td>
                            </tr>
                        </tbody>
                       </table>
                       <div align=\"center\">
                            <input type=\"submit\" value=\"수정완료\">
                            <input type=\"button\" value=\"취소\" onclick=\"backList(2)\">
                       </div>
                       </form>";
            // 게시글 출력
        }
    }

$shl_board_db = new board_DB();                             // DB연결 객체 생성
$shl_board_db->viewSelect($login_user_id, $board_idNum);    // 게시글 출력하기
?>
