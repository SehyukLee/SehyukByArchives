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
    // 방 번호 없을 시 예외 처리

    $delete = new chatDB();
    $delete->out($roomNum);
    // 방 나가기

    class chatDB {
        function out ($roomNumber) {
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

            $userIdNum = $_SESSION['idNum'];    // 현재 입장한 방 번호
            $updateUserInfo = $db_con->query("update chat_user set roomNumber=0, roomEnterNum=0 where roomNumber=$roomNumber and userIdNum=$userIdNum;");
            // 현재 로그인한 유저 정보 변경(입장한 방번호, 들어간 순서 초기화)

            if (!$updateUserInfo) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $roomUserCount = $db_con->query("select count(userIdNum) from chat_user where roomNumber=$roomNumber;");
            // 현재 방에 있는 인원수 검색

            if (!$roomUserCount) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $roomUserCountRe = $roomUserCount->fetch_array(MYSQLI_NUM);

            if ($roomUserCountRe[0] == 0) {
                // 현재 방의 인원 수가 0명이면 방삭제

                echo "<script>window.location = 'deleteRoom.php?roomNum=' + $roomNumber;</script>";
            }
            else {
                $updateRoomUserCount = $db_con->query("update chat_room set roomUserCount=$roomUserCountRe[0] where roomNumber=$roomNumber;");
                // 현재 방의 인원수 변경

                if (!$updateRoomUserCount) {
                    echo "query send fail";
                    exit();
                }
                // 쿼리문 실패 시 예외 처리

                $selectCurtains = $db_con->query("select userId from chat_user where roomNumber=$roomNumber and roomEnterNum=(select min(roomEnterNum) from chat_user where roomNumber=$roomNumber);");
                // 현재 방의 방장 검색

                if (!$selectCurtains) {
                    echo "query send fail";
                    exit();
                }
                // 쿼리문 실패 시 예외 처리

                $selectCurtainsRe = $selectCurtains->fetch_array(MYSQLI_NUM);

                $updateCurtains = $db_con->query("update chat_room set roomCurtains='$selectCurtainsRe[0]' where roomNumber=$roomNumber;");
                // 현재 방의 방장 변경

                if (!$updateCurtains) {
                    echo "query send fail";
                    exit();
                }
                // 쿼리문 실패 시 예외 처리

               echo "<script>window.location = 'roomList.html'</script>";
                // 리스트 페이지로 이동
            }
        }
    }
?>