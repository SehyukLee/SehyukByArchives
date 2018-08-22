<?php
    $login_user_id = isset($_GET["userid"]) ? $_GET["userid"] : false;

    if (!isset($_SESSION[$login_user_id]) || !$login_user_id) {
        echo "<script>
                  alert('로그인이 이미 되어있지 않습니다.');
                  window.location = 'board_login.html';
               </script>";
    }

    class DB_info{
        const IP_ADRESS   = "localhost";
        const USER_NAME   = "root";
        const USER_PASSWD = "autoset";
        const DB_NAME     = "shl_board";
    }

    class board_DB {
        function logout ($userid) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);

            if (!$db_con) {
                echo "<script>
                           alert('DB connect fail');
                           window.location = 'board_list.html?userid=$userid';
                       </script>";
            }

            $out = $db_con->query("update user set user_login=0 where user_id='$userid';");

            if (!$out) {
                echo "<script>
                           alert('update query fail');
                           window.location = 'board_list.html?userid=$userid';
                       </script>";
            }

            unset($_SESSION[$userid]);

            echo "<script>
                      alert('로그아웃 완료');
                      window.location = 'board_login.html';
                  </script>";
        }
    }

    $shl_board_db = new board_DB();
    $shl_board_db->logout($login_user_id);
?>