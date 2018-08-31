<?php
    $login_user_id = isset($_POST["userid"]) ? $_POST["userid"] : false;            // 유저 아이디
    $board_idNum = isset($_POST["board_idNum"]) ? $_POST["board_idNum"] : false;    // 게시글 아이디

    if (!$login_user_id) {
        // 유저 아이디가 없을 경우
        
        echo "no userid data";
        exit();
    }

    if (!$board_idNum) {
        // 게시글 아이디가 없을 경우
        
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
        function veiwSelect ($userid, $boardNum) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);
            // DB연결
            
            if (!$db_con) {
                echo "DB connect fail";
                exit();
            }

            $view = $db_con->query("select board_name, board_content, user_id from board where board_idNum=$boardNum");
            // 게시글의 내용 검색
            
            if (!$view) {
                echo "board select query fail";
            }

            $view_re = $view->fetch_array(MYSQLI_NUM);
            
            // 게시글 내용 출력
            echo "<table align=\"center\">
                        <thead>
                            <tr align=\"center\">
                                <td>
                                    제목
                                </td>
                                <td>
                                    $view_re[0]
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan=\"2\">
                                    $view_re[1]
                                </td>
                            </tr>
                        </tbody>
                       </table>";
            // 게시글 내용 출력

            if ($view_re[2] == $userid) {
                // 로그인 했을 경우
                
                echo "<div align=\"center\">
                            <input type=\"button\" value=\"수정하기\" onclick=\"view_update()\">
                            <input type=\"button\" value=\"삭제하기\" onclick=\"view_delete()\">
                            <input type=\"button\" value=\"취소\" onclick=\"backList(1)\">
                       </div>";
            }
            else {
                // 로그인 하지 않았을 경우
                
                echo "<div align=\"center\">
                            <input type=\"button\" value=\"취소\" onclick=\"backList(1)\">
                       </div>";
            }
        }
    }

    $shl_board_db = new board_DB();                             // DB연결 객체 생성
    $shl_board_db->veiwSelect($login_user_id, $board_idNum);    // 게시글 
?>
