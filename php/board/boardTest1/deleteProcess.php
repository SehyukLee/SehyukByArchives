<?php
    try {
        $userid = isset($_POST['user_id']) ? $_POST['user_id'] : false;
        $userPass = isset($_POST['user_pass']) ? $_POST['user_pass'] : false;
        //<---------- �Ѿ�� �� ���� Ȯ�� ----------->
        if (!($userid && $userPass)) {
            throw new Exception();
        }
        else {
            //<---------- DB ���� ���� �� ����ó�� ----------->
            try {
                $obj = new database();
                $obj -> delete($userid, $userPass);
                $obj -> db_close();
            } catch (Exception $e) {
                echo "<script>
                alert('DB ���� ����');
                location.href = 'main.html';
               </script>";
            }
            //<---------- DB ���� ���� �� ����ó�� ----------->
        }
    } catch (Exception $e) {
        echo "<script>
                alert('�Ʒ� �׸��� �ʼ� �׸� �Դϴ�.');
                window.location = 'delete.html';
               </script>";
    }
    class database {
        private $db_con;
        private $result;
        private $checkId;
        private $checkPass;
        private $checkIdCount;
        private $checkPassCount;
        private $count;
        //<---------- DB ���� ----------->
        function __construct()
        {
            @$this -> db_con = mysql_connect("localhost", "root", "autoset");
            if (!$this->db_con) {
                throw new Exception();
            }
            mysql_select_db("midtermexam");
        }
        //<---------- DB ���� ----------->
        function delete ($id, $pass) {
            //<---------- ID, PASSWORD ���� �˻� ----------->
            $this -> result = mysql_query("select count(sysid) from userinfo where userid = '$id' AND password = '$pass'");
            $this -> count = mysql_fetch_row($this -> result);
            if ($this -> count[0] > 0) {
                mysql_query("delete from userinfo where userid = '$id' AND password = '$pass'");
                //<---------- ���� ��� ���� ----------->
                echo "<script>
                        alert('�����Ϸ�');
                        location.href='main.html';
                       </script>";
            }
            else {
                $this -> checkId = mysql_query("select count(sysid) from userinfo WHERE userid = '$id'");
                $this -> checkIdCount = mysql_fetch_row($this -> checkId);
                $this -> checkPass = mysql_query("select count(sysid) from userinfo WHERE password = '$pass'");
                $this -> checkPassCount = mysql_fetch_row($this -> checkPass);
                echo "<script>";
                if ($this -> checkIdCount[0] == 0) {
                    echo "alert('�ش� ���̵��� �����ϴ�.');";
                }
                else {
                    echo "alert('�ش� ����� �����ϴ�.');";
                }
                echo "</script>";
                include "delete.html";
            }
            //<---------- ID, PASSWORD ���� �˻� ----------->
        }
        //<---------- DB ���� ���� ----------->
        function db_close()
        {
            mysql_close($this -> db_con);
        }
        //<---------- DB ���� ���� ----------->
    }
?>