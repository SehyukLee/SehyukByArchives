<?php
    $insertDataTitle    = isset($_POST['writerTitle']) ? $_POST['writerTitle'] : false;
    $insertDataContent  = isset($_POST['writerContent']) ? $_POST['writerContent'] : false;

    try {
        if ($insertDataTitle == false) {
            throw new Exception();
        }
        else {
            $connectedDB = new myDBMS();
            $connectedDB->insertData($insertDataTitle, $insertDataContent);
        }
    } catch (Exception $e) {
        include 'writerCreate.html';
        echo "<script>alert('제목을 입력하시오.');</script>";
    }

    class constantValue {
        const IP_adress  = 'localhost';
        const user_name  = 'root';
        const user_pass  = 'autoset';
        const use_db     = 'sehyuk_board';
    }

    class myDBMS {
        function insertData ($subject, $contents) {
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

            try {
                $sendQuery = $db_con->query("insert into board values ('', 0, 'lsh', '이세혁', '$subject', '$contents', 0, 0);");

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
                          window.location = 'writerCreate.html';
                        }
                        </script>";
                echo "<input type='button' value='뒤로가기' onclick='backWriter()'>";
            }
        }
    }
?>