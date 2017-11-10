<?php
    $page = isset($_POST['page']) ? $_POST['page'] : 0;
    //<---------- 넘어온 페이지 ----------->

    class database {
        private $db_con;
        private $myList;

        //<---------- DB 연결 ----------->
        function __construct () {
            @$this -> db_con = mysql_connect("localhost", "root", "autoset");

            if (!$this->db_con) {
                throw new Exception();
            }

            mysql_select_db("midtermexam");
        }
        //<---------- DB 연결 ----------->

        function select ($pageNum) {

            //<---------- 해당 페이지 출력 ----------->
            $selectPage = ($pageNum * 5) - 5;
            // 보여주기 시작할 회원 순서

            $pageCount = mysql_query("select count(sysid) from userinfo");
            $pageCount = mysql_fetch_row($pageCount);
            // 총 회원 수 계산

            $this->myList = mysql_query("select * from userinfo limit $selectPage, 5");

            echo "<table border=\"1\" align='center'>
                        <thead align='center'>
                            <tr>
                                <td>sysid</td>
                                <td>userid</td>
                                <td>classification</td>
                                <td>name</td>
                                <td>gender</td>
                                <td>password</td>
                                <td>phone</td>
                                <td>email</td>
                            </tr>
                        </thead>
                        <tbody align='center'>";

            while($print = mysql_fetch_array($this->myList)) {
                echo "<tr>
                         <td>$print[sysid]</td>
                         <td>$print[userid]</td>
                         <td>$print[classification]</td>
                         <td>$print[name]</td>
                         <td>$print[gender]</td>
                         <td>$print[password]</td>
                         <td>$print[phone]</td>
                         <td>$print[email]</td>
                      </tr>";
            }

            $pageCount = ceil($pageCount[0] / 5);
            // 총 보여 줄 수 있는 페이지 계산

            echo "</tbody>
                </table>
                <div align='center'>";

            if ($pageNum % 3 == 1) {
                if ($pageNum != 1) {
                    echo "<a onclick='showList($pageNum - 3)'><</a>&nbsp;";
                }

                for ($i = $pageNum, $j = $pageNum + 3; $i < $j ; $i++) {
                    if ($i > $pageCount) {
                        break;
                    }

                    echo "<a onclick='showList($i)'>$i</a>&nbsp;";
                }

                if ($pageNum + 3 < $pageCount) {
                    echo "<a onclick='showList($pageNum + 3)'>></a>";
                }
                else {
                    if ($pageNum != $pageCount) {
                        echo "<a onclick='showList($pageCount)'>></a>";
                    }
                }

            } elseif ($pageNum % 3 == 2) {
                if ($pageNum == 2) {
                    echo "<a onclick='showList($pageNum - 1)'><</a>&nbsp;";
                }
                else {
                    echo "<a onclick='showList($pageNum - 4)'><</a>&nbsp;";
                }

                for ($i = $pageNum - 1, $j = $pageNum + 2; $i < $j ; $i++) {
                    if ($i > $pageCount) {
                        break;
                    }

                    echo "<a onclick='showList($i)'>$i</a>&nbsp;";
                }

                if ($pageNum + 2 < $pageCount) {
                    echo "<a onclick='showList($pageNum + 2)'>></a>";
                }
                else {
                    if ($pageNum != $pageCount) {
                        echo "<a onclick='showList($pageCount)'>></a>";
                    }
                }
            } else {
                if ($pageNum == 3) {
                    echo "<a onclick='showList($pageNum - 2)'><</a>&nbsp;";
                }
                else {
                    echo "<a onclick='showList($pageNum - 5)'><</a>&nbsp;";
                }

                for ($i = $pageNum - 2, $j = $pageNum + 1; $i < $j ; $i++) {
                    if ($i > $pageCount) {
                        break;
                    }

                    echo "<a onclick='showList($i)'>$i</a>&nbsp;";
                }

                if ($pageNum + 1 < $pageCount) {
                    echo "<a onclick='showList($pageNum + 1)'>></a>";
                }
                else {
                    if ($pageNum != $pageCount) {
                        echo "<a onclick='showList($pageCount)'>></a>";
                    }
                }
            }

            echo "</div>";
            //<---------- 해당 페이지 출력 ----------->
        }

        //<---------- DB 연결 종료 ----------->
        function  db_close () {
            mysql_close($this -> db_con);
        }
        //<---------- DB 연결 종료 ----------->
    }

    try {
        $obj = new database();
        $obj -> select($page);
        $obj -> db_close();
    } catch (Exception $e) {
        echo "<script>
                alert('DB 연결 실패');
                location.href = 'main.html';
               </script>";
    }
?>