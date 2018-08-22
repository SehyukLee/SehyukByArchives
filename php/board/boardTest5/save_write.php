<?php
    $login_user_id = isset($_GET["userid"]) ? $_GET["userid"] : false;
    $inputTitle = isset($_GET["title"]) ? $_GET["title"] : false;
    $inputContent = isset($_GET["content"]) ? $_GET["content"] : false;

    if (!isset($_SESSION[$login_user_id]) || !$login_user_id) {
        echo "<script>
                  alert('로그인이 이미 되어있지 않습니다.');
                  window.location = 'board_login.html';
               </script>";
    }

    if (!$inputTitle) {
        echo "<script>
                  alert('제목을 입력하시오.');
                  window.location = 'board_write.html?userid=$login_user_id';
               </script>";
    }

    class DB_info{
        const IP_ADRESS   = "localhost";
        const USER_NAME   = "root";
        const USER_PASSWD = "autoset";
        const DB_NAME     = "shl_board";
    }

    class board_DB {
        function save_write ($title, $content, $userid) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);

            if (!$db_con) {
                echo "<script>
                           alert('DB connect fail');
                           window.location = 'board_write.html?userid=$userid';
                       </script>";
            }

            $today = date("Y-m-d : H:i:s");

            $save = $db_con->query("insert into board values ('', '$title', '$content', '$userid', '$today');");

            if (!$save) {
                echo "<script>
                           alert('insert query fail');
                           window.location = 'board_write.html?userid=$userid';
                       </script>";
            }

            echo "<script>
                      alert('저장 완료');
                      window.location = 'board_list.html?userid=$userid';
                  </script>";
        }
    }

    $shl_board_db = new board_DB();
    $shl_board_db->save_write($inputTitle, $inputContent, $login_user_id);
?>