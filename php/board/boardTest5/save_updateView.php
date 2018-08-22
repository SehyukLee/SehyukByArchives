<?php
    $login_user_id = isset($_GET["userid"]) ? $_GET["userid"] : false;
    $board_idNum = isset($_GET["board_idNum"]) ? $_GET["board_idNum"] : false;
    $inputTitle = isset($_POST["title"]) ? $_POST["title"] : false;
    $inputContent = isset($_POST["content"]) ? $_POST["content"] : false;

    if (!isset($_SESSION[$login_user_id]) || !$login_user_id) {
        echo "<script>
                  alert('로그인이 이미 되어있지 않습니다.');
                  window.location = 'board_login.html';
               </script>";
    }

    if (!$board_idNum) {
        echo "<script>
                  alert('글번호가 없습니다.');
                  window.location = 'board_list.html?userid=$login_user_id';
               </script>";
    }

    if (!$inputTitle) {
        echo "<script>
                  alert('제목이 없습니다.');
                  window.location = 'veiw_board.html?userid=$login_user_id&board_idNum=$board_idNum';
               </script>";
    }

    class DB_info{
        const IP_ADRESS   = "localhost";
        const USER_NAME   = "root";
        const USER_PASSWD = "autoset";
        const DB_NAME     = "shl_board";
    }

    class board_DB {
        function save_update ($title, $content, $userid, $boardNum) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);

            if (!$db_con) {
                echo "<script>
                           alert('DB connect fail');
                           window.location = 'veiw_board.html?userid=$userid&board_idNum=$boardNum';
                       </script>";
            }

            $today = date("Y-m-d : H:i:s");

            $save = $db_con->query("update board set board_name='$title', board_content='$content', board_create_date='$today' where board_idNum=$boardNum");

            if (!$save) {
                echo "<script>
                           alert('update query fail');
                           window.location = 'veiw_board.html?userid=$userid&board_idNum=$boardNum';
                       </script>";
            }

            echo "<script>
                      alert('저장 완료');
                      window.location = 'veiw_board.html?userid=$userid&board_idNum=$boardNum';
                  </script>";
        }
    }

    $shl_board_db = new board_DB();
    $shl_board_db->save_update($inputTitle, $inputContent, $login_user_id, $board_idNum);
?>