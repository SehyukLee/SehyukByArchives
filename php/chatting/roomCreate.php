<?php
    class DB_info {
        const DB_IP          = "localhost";
        const DB_userid      = "root";
        const DB_userpass    = "autoset";
        const DB_name        = "chat";
    }
    // DB 연결 시 필요한 값들

    $roomName = isset($_POST['inputName']) ? $_POST['inputName'] : false;
    // 입력한 방 이름

    if (!$roomName) {
        // 방 이름 입력 안 했을 시 다시 입력 페이지로 돌아가기
        echo "<script>
                alert('방의 이름을 입력하시오.');
                window.location = 'roomCreateInputName.html';
              </script>";
    }
    else {
        $createRoom = new chatDB();
        $createRoom->insertRoom($roomName);
        // 방 생성하기
    }

    class chatDB {
        function insertRoom ($inputName) {
            try {
                $db_con = new mysqli(DB_info::DB_IP, DB_info::DB_userid, DB_info::DB_userpass, DB_info::DB_name);
                // DB 연결

                if (!$db_con) {
                    throw new Exception();
                    // DB 연결 실패 시 예외 처리
                }
            } catch (Exception $e) {
                echo "DB connect fail";
                exit();
            }

            $curtains    = $_SESSION['id'];                 // 로그인 한 유저 아이디
            $userIdNum   = $_SESSION['idNum'];              // 로그인 한 유저 고유 번호
            $nowTime     = date("Y-m-d H:i:s");     // 현재 날짜

            try {
                $insertRoom = $db_con->query("insert into chat_room values ('', '$inputName', '$curtains', 1, '$nowTime');");
                // 방 생성

                if (!$insertRoom) {
                    throw new Exception();
                    // 쿼리문 실패 시 예외 처리
                }

                $selectRoomNum = $db_con->query("select roomNumber from chat_room where roomCurtains='$curtains';");
                // 현재 만든 방의 번호 검색

                if (!$selectRoomNum) {
                    throw new Exception();
                    // 쿼리문 실패 시 예외 처리
                }

                $selectRoomNumRes = $selectRoomNum->fetch_array(MYSQLI_NUM);

                $updateUser = $db_con->query("update chat_user set roomNumber=$selectRoomNumRes[0], roomEnterNum=1 where userIdNum=$userIdNum");
                // 유저 정보 변경 (현재 들어간 방 번호, 방에 들어간 순서)

                if (!$updateUser) {
                    throw new Exception();
                    // 쿼리문 실패 시 예외 처리
                }

            } catch (Exception $e) {
                echo "query send fail";
                exit();
            }

            echo "<script>
                    window.location = 'chattingRoom.html?roomNum=$selectRoomNumRes[0]';
                </script>";
            // 채팅 페이지로 가기
        }
    }
?>