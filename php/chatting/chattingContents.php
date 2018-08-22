<?php
    class DB_info {
        const DB_IP          = "localhost";
        const DB_userid      = "root";
        const DB_userpass    = "autoset";
        const DB_name        = "chat";
    }
    // DB 연결 시 필요한 값들

    $roomNum = isset($_POST['roomNum']) ? $_POST['roomNum'] : false;
    // 현재 방 번호

    if (!$roomNum) {
        echo "no room number";
        exit();
    }
    // 값 없을 시 예외 처리

    $selectConAndCreateDeleteBtn = new chatDB();
    $selectConAndCreateDeleteBtn->selectContents($roomNum);     // 방에 입력한 글 들 검색

    class chatDB {
        function selectContents ($enterRoomNum) {
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

            $idNum = $_SESSION['idNum'];    // 현재 로그인한 유저 고유 번호

            $maxEnterCount = $db_con->query("select max(roomEnterNum) from chat_user where roomNumber=$enterRoomNum;");
            // 현재 방에 들어온 마지막 유저의 순번 검색

            if (!$maxEnterCount) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $maxEnterCountRe = $maxEnterCount->fetch_array(MYSQLI_NUM);

            $lastUser = $db_con->query("select userIdNum from chat_user where roomNumber=$enterRoomNum and roomEnterNum=$maxEnterCountRe[0]");

            if (!$lastUser) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $lastUserRe = $lastUser->fetch_array(MYSQLI_NUM);

            if ($lastUserRe[0] != $idNum) {

                $maxEnterCountRe[0] = $maxEnterCountRe[0] + 1;

                $userRoomNumberUpdate = $db_con->query("update chat_user set roomNumber=$enterRoomNum, roomEnterNum=$maxEnterCountRe[0] where userIdNum=$idNum;");
                // 유저 정보 변경

                if (!$userRoomNumberUpdate) {
                    echo "query send fail";
                    exit();
                }
                // 쿼리문 실패 시 예외 처리
            }

            $selectUserRoomCount = $db_con->query("select count(userIdNum) from chat_user where roomNumber=$enterRoomNum;");
            // 현재 방에 입장한 유저 수 검색

            if (!$selectUserRoomCount) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $selectUserRoomCountRe = $selectUserRoomCount->fetch_array(MYSQLI_NUM);

            $changeRoomUserCount = $db_con->query("update chat_room set roomUserCount=$selectUserRoomCountRe[0] where roomNumber=$enterRoomNum;");
            // 방 정보 변경(현재 방에 입장한 인원수)

            if (!$changeRoomUserCount) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            $contents = $db_con->query("select userId, content from chat_room_info where roomNumber=$enterRoomNum order by contentId;");
            // 현재 입장한 방의 글과 그 글을 쓴 유저 글 쓴 순서대로 검색

            if (!$contents) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외 처리

            for ($i = 0; $i < $contents->num_rows; $i++) {
                $contentsRe = $contents->fetch_array(MYSQLI_NUM);

                echo $contentsRe[0].") ".$contentsRe[1]."<br>";
            }
            // 글 출력
        }
    }
?>