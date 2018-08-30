<?php
    $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;   // 게시글 아이디

    if ($board_id == false) {
        // 게시글 아이디가 없을 경우
        
        echo "board_id select fail";
        exit();
    }

    class constantValue {
        const IP_adress  = 'localhost';
        const user_name  = 'root';
        const user_pass  = 'autoset';
        const use_db     = 'sehyuk_board';
    }
    // DB연결 값 정리

    $selectView = new myDBMS();         // DB연결 객체 생성
    $selectView->deleteView($board_id); // deleteView로 값 전달

    class myDBMS {
        function deleteView ($deleteBoard_id) {
            try {
                $db_con = new mysqli(constantValue::IP_adress, constantValue::user_name, constantValue::user_pass, constantValue::use_db);

                if ($db_con->errno != 0) {
                    throw new Exception();
                }
            } catch (Exception $e) {
                echo "DB connect fail<br>";
                echo "<script>
                            function backWriter() {
                            window.location = 'list_up.php';
                            }
                        </script>";
                echo "<input type='button' value='뒤로가기' onclick='backWriter()'>";
            }
            // DB연결

            try {
                $sendQuery = $db_con->query("delete from board where board_id=$deleteBoard_id;");
                // 게시글 삭제

                if ($sendQuery == false) {
                    throw new Exception();
                }
                else {
                    echo "<script>
                            function moveList() {
                                window.location = 'list_up.php';
                            }
                            moveList();
                        </script>";
                }
            } catch (Exception $e) {
                echo "Query send fail";
                echo "<script>
                            function backWriter() {
                                window.location = 'list_up.php';
                            }
                        </script>";
                echo "<input type='button' value='뒤로가기' onclick='backWriter()'>";
            }
            // 게시글 삭제
        }
    }
?>
