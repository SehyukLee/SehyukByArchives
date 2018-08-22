<?php
    $login_user_id = isset($_GET["userid"]) ? $_GET["userid"] : false;
    $board_idNum = isset($_GET["board_idNum"]) ? $_GET["board_idNum"] : false;

    if (!isset($_SESSION[$login_user_id]) || !$login_user_id) {
        echo "<script>
                  alert('로그인이 되어있지 않습니다.');
                  window.location = 'board_login.html';
               </script>";
    }

    if (!$board_idNum) {
        echo "<script>
                  alert('글번호가 없습니다.');
                  window.location = 'board_list.html?userid=$login_user_id';
               </script>";
    }

    class DB_info{
        const IP_ADRESS   = "localhost";
        const USER_NAME   = "root";
        const USER_PASSWD = "autoset";
        const DB_NAME     = "shl_board";
    }

    class board_DB {
        function delete_view ($userid, $boardNum) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);

            if (!$db_con) {
                echo "<script>
                           alert('DB connect fail');
                           window.location = 'veiw_board.html?userid=$userid&board_idNum=$boardNum';
                       </script>";
            }

            $delete = $db_con->query("delete from board where board_idNum=$boardNum");

            if (!$delete) {
                echo "<script>
                           alert('delete query fail');
                           window.location = 'veiw_board.html?userid=$userid&board_idNum=$boardNum';
                       </script>";
            }

            echo "<script>
                      alert('삭제 완료');
                      window.location = 'board_list.html?userid=$userid';
                  </script>";
        }
    }

    $shl_board_db = new board_DB();
    $shl_board_db->delete_view($login_user_id, $board_idNum);
?>