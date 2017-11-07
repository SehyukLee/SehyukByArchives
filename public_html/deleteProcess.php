<?php
    $userid = isset($_POST['user_id']) ? $_POST['user_id'] : false;
    $userPass = isset($_POST['user_pass']) ? $_POST['user_pass'] : false;
    //<---------- 변수 선언부 ----------->

    class database {
        private $db_con;
        private $result;
        private $checkId;
        private $checkPass;
        private $checkIdCount;
        private $checkPassCount;
        private $count;

        //<---------- DB 연결 ----------->
        function __construct()
        {
            @$this -> db_con = mysql_connect("localhost", "root", "autoset");

            if (!$this->db_con) {
                throw new Exception();
            }

            mysql_select_db("midtermexam");
        }
        //<---------- DB 연결 ----------->

        function delete ($id, $pass) {
            //<---------- ID, PASSWORD 유무 검사 ----------->
            $this -> result = mysql_query("select count(sysid) from userinfo where userid = '$id' AND password = '$pass'");
            $this -> count = mysql_fetch_row($this -> result);

            if ($this -> count[0] > 0) {
                mysql_query("delete from userinfo where userid = '$id' AND password = '$pass'");
                //<---------- 있을 경우 삭제 ----------->

                echo "<script>
                        alert('수정완료');
                        location.href='main.html';
                       </script>";
            }
            else {
                $this -> checkId = mysql_query("select count(sysid) from userinfo WHERE userid = '$id'");
                $this -> checkIdCount = mysql_fetch_row($this -> checkId);

                $this -> checkPass = mysql_query("select count(sysid) from userinfo WHERE password = '$pass'");
                $this -> checkPassCount = mysql_fetch_row($this -> checkPass);

                echo "<script>";

                if ($this -> checkIdCount[0] == 0 && $this -> checkPassCount[0] == 0) {
                    echo "alert('해당 아이디, 비번이 없습니다.');";
                }
                elseif ($this -> checkIdCount[0] == 0) {
                    echo "alert('해당 아이디이 없습니다.');";
                }
                else {
                    echo "alert('해당 비번이 없습니다.');";
                }

                echo "</script>";

                include "delete.html";
            }
            //<---------- ID, PASSWORD 유무 검사 ----------->
        }

        //<---------- DB 연결 종료 ----------->
        function db_close()
        {
            mysql_close($this -> db_con);
        }
        //<---------- DB 연결 종료 ----------->
    }

    //<---------- DB 연결 실패 시 예외처리 ----------->
    try {
        $obj = new database();
        $obj -> delete($userid, $userPass);
        $obj -> db_close();
    } catch (Exception $e) {
        echo "<script>
                alert('DB 연결 실패');
                location.href = 'main.html';
               </script>";
    }
    //<---------- DB 연결 실패 시 예외처리 ----------->
?>