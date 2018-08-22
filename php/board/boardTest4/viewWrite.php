<?php
    $board_id = isset($_GET['board_id']) ? $_GET['board_id'] : false;

    if ($board_id == false) {
        echo "board_id select fail";
        exit();
    }

    class constantValue {
        const IP_adress  = 'localhost';
        const user_name  = 'root';
        const user_pass  = 'autoset';
        const use_db     = 'sehyuk_board';
    }

    $selectView = new myDBMS();
    $selectView->showView($board_id);

    class myDBMS {
        function showView ($showBoard_id) {
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
                $sendQuery = $db_con->query("select subject, contents from board where board_id=$showBoard_id");

                if ($sendQuery == false) {
                    throw new Exception();
                }
                else {
                    $sendQueryResult = $sendQuery->fetch_array(MYSQLI_NUM);

                    echo "<script>function sendUpdate () {
                                window.location = 'updateView.php?board_id=$showBoard_id';
                            }
                            function sendDelete () {
                                window.location = 'delete.php?board_id=$showBoard_id';
                            }</script>
                            <div align='center'><table>
                            <tr><td>$sendQueryResult[0]</td></tr>
                            <tr><td>$sendQueryResult[1]</td></tr>
                            </table><br>
                            <input type='button' value='수정하기' onclick='sendUpdate()'>
                            <input type='button' value='삭제하기' onclick='sendDelete()'>
                            </div>";
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