<?php
    class DB_info
    {
        const DB_IP = "localhost";
        const DB_userid = "root";
        const DB_userpass = "autoset";
        const DB_name = "chat";
    }

    $roomNum = isset($_POST['roomNum']) ? $_POST['roomNum'] : false;
    $createDeleteBtn = new chatDB();
    $createDeleteBtn->createBtn($roomNum);

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

            $curtains = $db_con->query("select idNum from chatuser where roomNumber=$enterRoomNum and roomEnterNum=(select min(roomEnterNum) from chatuser where roomNumber=$enterRoomNum);");

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