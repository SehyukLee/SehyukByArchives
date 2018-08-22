<?php
    class DB_info {
        const DB_IP          = "localhost";
        const DB_userid      = "root";
        const DB_userpass    = "autoset";
        const DB_name        = "chat";
    }
    // DB 연결 시 필요한 값들

    $userId = $_SESSION['id'];
    // 로그인한 유저 아이디

    $listUp = new chatDB();
    $listUp->selectRoomList($userId);
    // 리스트 검색

    class chatDB {
        function selectRoomList ($user_id) {
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

            $checkRoom = $db_con->query("select * from chat_room");
            // 모든 채팅방 검색

            if (!$checkRoom) {
                echo "query send fail";
                exit();
            }
            // 검색 쿼리 실패 시 예외처리

            if ($checkRoom->num_rows == 0) {
                // 채팅방이 없을 시

                echo "no data<br>";
                echo "<div>
                        <table>
                            <tr>
                                <td>아이디</td>
                                <td>$user_id</td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <form action='logOut.php'>
                                        <input type='submit' value='로그아웃'>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>";
                exit();
            }

            echo "<div align='center'>
                    <div>
                        <table>
                            <tr>
                                <td>아이디</td>
                                <td>$user_id</td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <form action='logOut.php'>
                                        <input type='submit' value='로그아웃'>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table border='1'>
                        <thead>
                            <tr>
                                <td>번호</td>
                                <td>채팅방 이름</td>
                                <td>방장</td>
                                <td>인원</td>
                                <td>개설일자</td>
                            </tr>
                        </thead><tbody>";

            // 채팅방 출력
            for ($i = 0; $i < $checkRoom->num_rows; $i++) {
                $checkRoomResult = $checkRoom->fetch_array(MYSQLI_NUM);

                echo "<tr>";

                for ($j = 0; $j < $checkRoom->field_count; $j++) {
                    echo "<td>";

                    if ($j == 1) {
                        echo "<a href='chattingRoom.html?roomNum=$checkRoomResult[0]'>$checkRoomResult[$j]</a>";
                    }
                    else {
                        echo $checkRoomResult[$j];
                    }

                    echo "</td>";
                }

                echo "</tr>";
            }

            echo "</tbody></table></div>";
        }
    }
?>