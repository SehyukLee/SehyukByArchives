<?php
    $login_user_id = isset($_GET["userid"]) ? $_GET["userid"] : false;      // 유저 아이디
    $inputTitle = isset($_GET["title"]) ? $_GET["title"] : false;           // 게시글 제목
    $inputContent = isset($_GET["content"]) ? $_GET["content"] : false;     // 게시글 내용

    if (!isset($_SESSION[$login_user_id]) || !$login_user_id) {
        // 로그인하지 않았을 경우
        
        echo "<script>
                  alert('로그인이 이미 되어있지 않습니다.');
                  window.location = 'board_login.html';
               </script>";
    }

    if (!$inputTitle) {
        // 제목이 없을 경우
        
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
    // DB연결에 사용할 값 정리

    class board_DB {
        function save_write ($title, $content, $userid) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);
            // DB연결
            
            if (!$db_con) {
                echo "<script>
                           alert('DB connect fail');
                           window.location = 'board_write.html?userid=$userid';
                       </script>";
            }

            $today = date("Y-m-d : H:i:s");     // 현재 날짜

            $save = $db_con->query("insert into board values ('', '$title', '$content', '$userid', '$today');");
            // 게시글 추가
            
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

    $shl_board_db = new board_DB();                                             // DB연결 객체 생성
    $shl_board_db->save_write($inputTitle, $inputContent, $login_user_id);      // 게시글 
?>
