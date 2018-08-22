<?php
    class DB_info {
        const DB_IP          = "localhost";
        const DB_userid      = "root";
        const DB_userpass    = "autoset";
        const DB_name        = "chat";
    }
    // DB 연결 시 필요한 값들

    $roomNum     = isset($_POST['roomNum']) ? $_POST['roomNum'] : false;        // 현재 방 번호
    $inputCon    = isset($_POST['contents']) ? $_POST['contents'] : false;     // 입력한 글
    $login_id    = $_SESSION['id'];                                               // 현재 로그인한 유저의 아이디

    if (!$roomNum) {
        echo "no room number";
        exit();
    }

    $insertCon = new chatDB();
    $insertCon->selectContents($roomNum, $inputCon, $login_id);
    // 글 보내기

    class chatDB {
        function selectContents ($enterRoomNum, $content, $user_id) {
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

            $selectLastContentId = $db_con->query("select max(contentId) from chat_room_info where roomNumber=$enterRoomNum");
            // 현재 방의 마지막 글 번호 검색

            if (!$selectLastContentId) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외처리

            $selectLastContentIdRe = $selectLastContentId->fetch_array(MYSQLI_NUM);
            $contentNum = $selectLastContentIdRe[0] + 1;

            $insertCon = $db_con->query("insert into chat_room_info values ($enterRoomNum, '$user_id', '$content', $contentNum);");
            // 보낸 글 채팅 방 정보에 저장

            if (!$insertCon) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외처리

            $show = $db_con->query("select userId, content from chat_room_info where roomNumber=$enterRoomNum order by contentId;");
            // 현재 방의 글 쓴 유저와 글 내용을 글 내용 쓴 순서대로 검색

            if (!$show) {
                echo "query send fail";
                exit();
            }
            // 쿼리문 실패 시 예외처리

            for ($i = 0; $i < $show->num_rows; $i++) {
                $showRe = $show->fetch_array(MYSQLI_NUM);

                echo $showRe[0].") ".$showRe[1]."<br>";
            }
            // 글 내용 순서대로 출력
        }
    }
?>