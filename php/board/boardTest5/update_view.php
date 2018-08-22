<?php
    $login_user_id = isset($_POST["userid"]) ? $_POST["userid"] : false;
    $board_idNum = isset($_POST["board_idNum"]) ? $_POST["board_idNum"] : false;

    if (!$login_user_id) {
        echo "no userid data";
        exit();
    }

    if (!$board_idNum) {
        echo "no board_idNum";
        exit();
    }

    class DB_info{
        const IP_ADRESS   = "localhost";
        const USER_NAME   = "root";
        const USER_PASSWD = "autoset";
        const DB_NAME     = "shl_board";
    }

    class board_DB {
        function viewSelect ($userid, $boardNum) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);

            if (!$db_con) {
                echo "DB connect fail";
                exit();
            }

            $view = $db_con->query("select board_name, board_content, user_id from board where board_idNum=$boardNum");

            if (!$view) {
                echo "board select query fail";
            }

            $view_re = $view->fetch_array(MYSQLI_NUM);

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
        }
    }

$shl_board_db = new board_DB();
$shl_board_db->viewSelect($login_user_id, $board_idNum);
?>