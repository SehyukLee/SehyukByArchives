<?php
    class constantValue {
        const IP_adress  = 'localhost';
        const user_name  = 'root';
        const user_pass  = 'autoset';
        const use_db     = 'sehyuk_board';
    }
    // DB연결에 사용할 값 정리

    $list = new myDBMS();   // DB연결 객체 생성
    $list->selectList();    // 리스트 호출

    class myDBMS {
        function selectList () {
            $db_con = new mysqli(constantValue::IP_adress, constantValue::user_name, constantValue::user_pass, constantValue::use_db);
            // DB연결
            
            try {
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

            $select = $db_con->query("select board_id, user_id, subject, reg_date from board;");
            // 리스트 검색
            
            // 리스트 출력
            echo "<!DOCTYPE html>
                    <html lang=\"en\">
                    <head>
                    <meta charset=\"UTF-8\">
                    <title>Title</title>
                    </head>
                    <script>
                        function GoWriterCreate() {
                          window.location = 'writerCreate.html';
                        }
                    </script>
                    <body>
                        <div align=\"center\">
                            <table>
                                <thead>
                                    <tr>
                                        <td>글 번호</td>
                                        <td>아이디</td>
                                        <td>글 제목</td>
                                        <td>저장 날짜</td>
                                    </tr>
                                </thead>
                                <tbody id=\"list\">";

                                    for ($i = 0; $i < $select->num_rows; $i++) {
                                        $selectResult = $select->fetch_array(MYSQLI_NUM);
                                        echo "<tr>";

                                        foreach ($selectResult as $key=>$value) {
                                            echo "<td>";

                                            if ($key == 2) {
                                                echo "<a href='viewWrite.php?board_id=$selectResult[0]'>$value</a>";
                                            }
                                            else {
                                                echo $value;
                                            }

                                            echo "</td>";
                                        }

                                        echo "</tr>";
                                    }

                            echo"</tbody>
                             </table>
                             <br>
                             <input type='button' value='글 쓰기' onclick='GoWriterCreate()'>
                        </div>
                    </body>
                    </html>";
             // 리스트 출력
        }
    }
?>
