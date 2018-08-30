<?php
    $updateDataTitle    = isset($_POST['writerTitle']) ? $_POST['writerTitle'] : false;         // 수정할 게시글 제목
    $updateDataContent  = isset($_POST['writerContent']) ? $_POST['writerContent'] : false;     // 수정할 게시글 내용
    $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;                           // 수정할 게시글 아이디

    try {
        if ($updateDataTitle == false) {
            // 제목이 없을 경우
            
            throw new Exception();
        }
        else {
            // 제목이 있을 경우
            
            $connectedDB = new myDBMS();                                                // DB연결 객체 생성
            $connectedDB->updateData($updateDataTitle, $updateDataContent, $board_id);  // 게시글 수정
        }
    } catch (Exception $e) {
        include "viewWrite.php?board_id=$board_id";
        echo "<script>alert('제목을 입력하시오.');</script>";
    }

    class constantValue {
        const IP_adress  = 'localhost';
        const user_name  = 'root';
        const user_pass  = 'autoset';
        const use_db     = 'sehyuk_board';
    }
    // DB연결에 사용할 값 정리

    class myDBMS {
        function updateData ($subject, $contents, $updateViewBoard_id) {
            try {
                $db_con = new mysqli(constantValue::IP_adress, constantValue::user_name, constantValue::user_pass, constantValue::use_db);

                if ($db_con->errno != 0) {
                    throw new Exception();
                }
            } catch (Exception $e) {
                echo "DB connect fail<br>";
                echo "<script>
                        function backWriter() {
                          window.location = 'writerCreate.html';
                        }
                        </script>";
                echo "<input type='button' value='뒤로가기' onclick='backWriter()'>";
            }
            // DB연결

            try {
                $sendQuery = $db_con->query("update board set subject='$subject', contents='$contents' where board_id=$updateViewBoard_id;");

                if ($sendQuery == false) {
                    throw new Exception();
                }
                else {
                    echo "<script>
                            function backWriter() {
                                window.location = 'list_up.php';
                            }
                        
                            backWriter();
                            </script>";
                }
            } catch (Exception $e) {
                echo "Query send fail";
                echo "<script>
                            function backWriter() {
                                window.location = 'viewWrite.php?board_id=$updateViewBoard_id';
                        }
                        </script>";
                echo "<input type='button' value='뒤로가기' onclick='backWriter()'>";
            }
            // 게시글 
        }
    }
?>
