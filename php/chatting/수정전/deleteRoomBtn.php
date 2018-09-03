<?php
    class DB_info
    {
        const DB_IP = "localhost";
        const DB_userid = "root";
        const DB_userpass = "autoset";
        const DB_name = "chat";
    }
    // DB연결에 사용할 값 정리

    $roomNum = isset($_POST['roomNum']) ? $_POST['roomNum'] : false;    // 채팅방 번호
    $createDeleteBtn = new chatDB();                                    // DB연결 객체 생성
    $createDeleteBtn->createBtn($roomNum);                              // 채팅방 삭제

    class chatDB {
        function createBtn ($enterRoomNum) {
            try {
                $db_con = new mysqli(DB_info::DB_IP, DB_info::DB_userid, DB_info::DB_userpass, DB_info::DB_name);

                if (!$db_con) {
                    throw new Exception();
                }
            } catch (Exception $e) {
                echo "DB connect fail";
                exit();
            }
            // DB연결

            $curtains = $db_con->query("select idNum from chatuser where roomNumber=$enterRoomNum and roomEnterNum=(select min(roomEnterNum) from chatuser where roomNumber=$enterRoomNum);");
            // 채팅방 삭제
            
            if ($curtains == false) {
                echo "query send fail";
                exit();
            }

            $curtainsRe = $curtains->fetch_array(MYSQLI_NUM);

            if ($_SESSION['idNum'] == $curtainsRe[0]) {
                echo "<input type='submit' value='방삭제'>";
            }
        }
    }
?>
