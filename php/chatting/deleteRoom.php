<?php
    class DB_info {
        const DB_IP          = "localhost";
        const DB_userid      = "root";
        const DB_userpass    = "autoset";
        const DB_name        = "chat";
    }
    // DB 연결 시 필요한 값들

    $roomNum = isset($_GET['roomNum']) ? $_GET['roomNum'] : false;
    // 현재 방 번호

    if (!$roomNum) {
        echo "no room number";
        exit();
    }
    // 방 번호 없을 시 예외처리

    $delete = new chatDB();
    $delete->del($roomNum);
    // 방 삭제

    class chatDB {
        function del ($roomNumber)
        {
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

            $delUserRoomNum = $db_con->query("update chat_user set roomNumber=0, roomEnterNum=0 where roomNumber=$roomNumber");
            // 유저 정보 변경(현재 입장한 방번호, 들어온 순서 초기화)

            if (!$delUserRoomNum) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $delRoom = $db_con->query("delete from chat_room where roomNumber=$roomNumber");
            // 현재 방 삭제

            if (!$delRoom) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $delRoomInfo = $db_con->query("delete from chat_room_info where roomNumber=$roomNumber");
            // 현재 방에 대한 정보들 삭제

            if (!$delRoomInfo) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            echo "<script>window.location = 'roomList.html'</script>";
            // 리스트 페이지로 이동
        }
    }
?>