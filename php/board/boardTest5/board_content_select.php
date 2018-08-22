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
        function veiwSelect ($userid, $boardNum) {
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

            if ($view_re[2] == $userid) {
                echo "<div align=\"center\">
                            <input type=\"button\" value=\"수정하기\" onclick=\"view_update()\">
                            <input type=\"button\" value=\"삭제하기\" onclick=\"view_delete()\">
                            <input type=\"button\" value=\"취소\" onclick=\"backList(1)\">
                       </div>";
            }
            else {
                echo "<div align=\"center\">
                            <input type=\"button\" value=\"취소\" onclick=\"backList(1)\">
                       </div>";
            }
        }
    }

    $shl_board_db = new board_DB();
    $shl_board_db->veiwSelect($login_user_id, $board_idNum);
?>