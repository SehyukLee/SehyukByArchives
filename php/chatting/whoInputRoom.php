<?php
    class DB_info {
        const DB_IP          = "localhost";
        const DB_userid      = "root";
        const DB_userpass    = "autoset";
        const DB_name        = "chat";
    }
    // DB 연결 시 필요한 값들

    $roomNum = isset($_POST['roomNum']) ? $_POST['roomNum'] : false;    // 현재 방 번호
    $userId = $_SESSION['id'];                                             // 현재 로그인한 유저 아이디

    if ($roomNum == false) {
        echo "no room number";
        exit();
    }
    // 쿼리문 실패 시 예외 처리

    $who = new chatDB();
    $who->who_inputRoom($roomNum, $userId);
    // 채팅방에 들어온 유저 알림

    $who->createBtn($roomNum);          // 방 삭제 버튼 생성

    class chatDB {
        function who_inputRoom($roomNumber, $user) {
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

            $maxContentId = $db_con->query("select max(contentId) from chat_room_info where roomNumber=$roomNumber");
            // 현재 방의 마지막 글 번호 검색

            if (!$maxContentId) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            if ($maxContentId->num_rows == 0) {
                $insertWho = $db_con->query("insert into chat_room_info values ($roomNumber, '$user', '--->$user 님이 입장하셨습니다.', 1);");
                // 현재방에 입장 알림

                if (!$insertWho) {
                    echo "query send fail";
                    exit();
                }
                // 쿼리문 실패 시 예외 처리
            }
            else {
                $maxContentIdRe = $maxContentId->fetch_array(MYSQLI_NUM);
                $maxContentIdCount = $maxContentIdRe[0] + 1;

                $insertWho = $db_con->query("insert into chat_room_info values ($roomNumber, '$user', '--->$user 님이 입장하셨습니다.', 1);");
                // 현재방에 입장 알림

                if (!$insertWho) {
                    echo "query send fail";
                    exit();
                }
                // 쿼리문 실패 시 예외 처리
            }
        }

        function createBtn ($enterRoomNum) {
            // 방 삭제 버튼 생성

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

            $curtains = $db_con->query("select userIdNum from chat_user where roomNumber=$enterRoomNum and roomEnterNum=(select min(roomEnterNum) from chat_user where roomNumber=$enterRoomNum);");
            // 현재 입장한 방의 방장 검색

            if (!$curtains) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $curtainsRe = $curtains->fetch_array(MYSQLI_NUM);

            if ($_SESSION['idNum'] == $curtainsRe[0]) {
                echo "true";
            }
            // 현재 로그인한 유저가 방장이면 방 삭제 버튼 생성
        }
    }
?>