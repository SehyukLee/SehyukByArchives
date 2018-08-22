<?php
    $input_id        = isset($_POST['idText']) ? $_POST['idText'] : false;
    $input_passwd    = isset($_POST['passwdText']) ? $_POST['passwdText'] : false;

    if (!$input_id) {
        echo "<script>
                  alert('아이디를 입력하십시오.')
                  window.location = 'join.html';
               </script>";
    }
    elseif (!$input_passwd) {
        echo "<script>
                  alert('비밀번호를 입력하십시오.')
                  window.location = 'join.html';
               </script>";
    }
    else {
        $shl_board_db = new board_DB();
        $shl_board_db->insert_user($input_id, $input_passwd);
    }

    class DB_info{
       const IP_ADRESS   = "localhost";
       const USER_NAME   = "root";
       const USER_PASSWD = "autoset";
       const DB_NAME     = "shl_board";
    }

    class board_DB {
        function insert_user ($input_user_id, $input_user_passwd) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);

            if (!$db_con) {
                echo "<script>
                         alert('DB connect fail');
                         window.location = 'join.html';
                     </script>";
            }

            $check_input_user_id = $db_con->query("select user_id from user where user_id='$input_user_id'");

            if ($check_input_user_id->num_rows != 0) {
                echo "<script>
                         alert('이미 있는 아이디입니다.');
                         window.location = 'join.html';
                       </script>";
            }

            $check_input_user = $db_con->query("insert into user values('', '$input_user_id', '$input_user_passwd', 0)");

            if (!$check_input_user) {
                echo "<script>
                          alert('user insert query fail');
                          window.location = 'join.html';
                       </script>";
            }
            else {
                echo "<script>
                          alert('가입 완료하였습니다.');
                          window.location = 'board_login.html';
                      </script>";
            }
        }
    }
?>