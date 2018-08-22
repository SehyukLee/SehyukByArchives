<?php
    class DB_info {
        const DB_IP         = "localhost";
        const DB_userid     = "root";
        const DB_userpass   = "autoset";
        const DB_name       = "chat";
    }
    // DB 연결 시 필요한 값들

    $user_id         = isset($_POST['user_id']) ? $_POST['user_id'] : false;
    $user_password   = isset($_POST['user_pass']) ? $_POST['user_pass'] : false;
    // 입력 받은 아이디와 비밀번호

    if ($user_id == false || $user_password == false) {
        // 아이디 또는 비밀번호를 입력하지 않을 시 다시 로그인 페이지로 돌아가기
        echo "<script>
                alert('잘못된 아이디, 비번입니다.');
                window.location = 'login.html';
               </script>";
    }
    else {
        $selectUser = new chatDB();
        $selectUser->selectIdPass($user_id, $user_password);
        // 아이디, 비밀번호 확인
    }

    class chatDB {
        function selectIdPass ($id, $password) {
            try {
                $db_con = new mysqli(DB_info::DB_IP, DB_info::DB_userid, DB_info::DB_userpass, DB_info::DB_name);
                // DB 연결

                if (!$db_con) {
                    throw new Exception();
                    // DB 연결 실패 시 예외처리
                }
            } catch (Exception $e) {
                echo "DB connect fail";
                exit();
            }

            $check_user = $db_con->query("select userIdNum from chat_user where userId='$id' and userPasswd='$password'");
            // DB에서 입력한 아이디, 비밀번호를 가진 유저 확인

            if (!$check_user) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $check_userResert = $check_user->fetch_array(MYSQLI_NUM);

            if ($check_user->num_rows > 0) {
                // 아이디, 비밀번호가 맞을 시

                if ($_SESSION['idNum'] == $check_userResert[0] || $_SESSION['id'] == $id) {
                    echo "<script>alert('이미 접속한 유저의 아이디, 비번입니다.');
                                    window.location='login.html'</script>";
                }
                // 세션 변수가 있다면 삭제

                if (!session_start()) {
                    echo "세션 시작 실패";
                    exit();
                }

                $_SESSION['idNum']   = $check_userResert[0];  // 유저의 고유번호 세션 변수로 선언
                $_SESSION['id']      = $id;                   // 유저의 아이디 세션 변수로 선언

                echo "<script>
                          window.location = 'roomList.html';
                      </script>";
                // 리스트 페이지로 이동
            }
            else {
                echo "<script>
                alert('없는 아이디, 비번입니다.');
                window.location = 'login.html';
               </script>";
            }
        }
    }
?>
