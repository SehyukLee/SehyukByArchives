<?php
    $input_user_id = isset($_POST['idText']) ? $_POST['idText'] : false;                // 유저 아이디
    $input_user_passwd = isset($_POST['passwdText']) ? $_POST['passwdText'] : false;    // 유저 비밀번호

    if (!$input_user_id) {
        // 아이디를 입력하지 않았을 경우
        
        echo "<script>
                  alert('아이디를 입력하십시오.');
                  window.location = 'board_login.html';
               </script>";
    }
    else if (!$input_user_passwd) {
        // 비밀번호를 입력하지 않았을 경우
        
        echo "<script>
                  alert('비밀번호를 입력하십시오.');
                  window.location = 'board_login.html';
               </script>";
    }
    else {
        $shl_board_db = new board_DB();                                         // DB연결 객체 생성
        $shl_board_db->check_id_passwd($input_user_id, $input_user_passwd);     // 유저 유무 확인하기
    }

    class DB_info{
        const IP_ADRESS   = "localhost";
        const USER_NAME   = "root";
        const USER_PASSWD = "autoset";
        const DB_NAME     = "shl_board";
    }
    // DB연결에 사용할 값 정리

    class board_DB {
        function check_id_passwd ($user_id, $user_passwd) {
            $db_con = new mysqli(DB_info::IP_ADRESS, DB_info::USER_NAME, DB_info::USER_PASSWD, DB_info::DB_NAME);
            // DB연결
            
            if (!$db_con) {
                echo "<script>
                           alert('DB connect fail');
                           window.location = 'board_login.html';
                       </script>";
            }

            $user_check = $db_con->query("select * from user where user_id='$user_id' and user_passwd='$user_passwd'");
            // 입력한 아이디와 비밀번호를 가진 유저가 있는지 확인
            
            if (!$user_check) {
                echo "<script>
                          alert('user select query fail');
                       </script>";
            }

            if ($user_check->num_rows == 1) {
                // 유저가 있을 경우
                
                $user_check_re = $user_check->fetch_array(MYSQLI_NUM);
                $login_user_id = $user_check_re[1];

                if ($user_check_re[3] == 1) {
                    // 이미 로그인한 유저일 경우
                    
                    echo "<script>
                              alert('이미 로그인한 유저입니다.');
                              window.location = 'board_login.html';
                           </script>";
                }
                else {
                    $loginUpdate = $db_con->query("update user set user_login=1 where user_id='$login_user_id'");

                    if (!$loginUpdate) {
                        echo "<script>
                                alert('login update query fail');
                                window.location = 'board_login.html';
                              </script>";
                    }

                    if (session_status() == PHP_SESSION_DISABLED) {
                        session_status();
                    }

                    $_SESSION[$login_user_id] = $login_user_id;

                    echo "<script>
                         alert('세혁이의 게시판입니다.');
                         window.location = 'board_list.html?userid=$login_user_id';
                       </script>";
                }
            }
        }
    }
?>
