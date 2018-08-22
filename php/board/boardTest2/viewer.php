<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .tableStyle {
            border: solid 1px;
            border-color: black;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
    $id = isset($_GET['id']) ? $_GET['id'] : false;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");
    $find = mysql_query("select subject, contents, user_id from board where board_id = $id");
    $find_result = mysql_fetch_row($find);

    $find_result[1] = html_entity_decode($find_result[1]);
    $find_result[1] = str_replace("&nbps;", " ", $find_result[1]);

    echo "<table align='center'>";
    echo "<tr><td class='tableStyle' style='height: 100px; width: 500px'>$find_result[0]</td></tr>";
    echo "<tr><td class='tableStyle' style='height: 400px; width: 500px'>$find_result[1]</td></tr>";
    echo "</table>";

    if (isset($_SESSION['name']) && $_SESSION['id'] == $find_result[2]) {
        echo "<div align=\"center\">";
        echo "<table>";
        echo "<tr><td>";
        echo "<input type=\"text\" id=\"underText\" style=\"width: 300px;\">";
        echo "</td>";
        echo "<td>";
        echo "<input type=\"button\" value=\"댓글달기\" onclick='underTextFunc($id)'>";
        echo "</td></tr>";
        echo "</table>";
        echo "</div>";

        $under_list_count = mysql_query("select count(board_id) from board where board_pid = $id");
        $under_list_count = mysql_fetch_row($under_list_count);

        echo "<div align='center'>";
        echo "<table id='underTable' class='tableStyle'>";

        echo "<tr class='tableStyle'>";
        echo "<td class='tableStyle'>";
        echo "내용";
        echo "</td>";
        echo "<td class='tableStyle'>";
        echo "아이디";
        echo "</td>";
        echo "<td class='tableStyle'>";
        echo "날짜";
        echo "</td>";
        echo "<td class='tableStyle'>";
        echo "삭제";
        echo "</td>";
        echo "<td class='tableStyle'>";
        echo "수정";
        echo "</td>";
        echo "</tr>";

        $under_list = mysql_query("select contents, user_id, reg_date, board_id from board where board_pid = $id");

        for ($i = 0; $i < $under_list_count[0]; $i++) {
            $under_list_result = mysql_fetch_row($under_list);

            echo "<tr class='tableStyle' id='$i'>";

            for($j = 0; $j < 5; $j++) {
                echo "<td class='tableStyle'>";

                if ($j < 3) {
                    echo $under_list_result[$j];
                }
                elseif ($j == 3) {
                    echo "<input type='button' value='삭제' onclick='delete_under($under_list_result[$j], $i)'>";
                }
                else {
                    echo "<input type='button' value='수정' onclick='under_update($under_list_result[3])'>";
                }

                echo "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";

        echo "<div align='center'>";
        echo "<form method='post' action='reWrite.php?board_id=$id'>";
        echo "<input type='submit' value='수정'>";
        echo "</form>";

        echo "<form method='post' action='remove_board.php?board_id=$id'>";
        echo "<input type='submit' value='삭제'>";
        echo "</form>";
        echo "</div>";
    }

    echo "<div align='center'>";
    echo "<input type='button' value='돌아가기' onclick='returnPage($page)'>";
    echo "</div>";
?>
</body>
<script>
    function underTextFunc(id) {
        var underText = document.getElementById("underText").value;
        var today = new Date();
        var year =  today.getUTCFullYear();
        var month = today.getUTCMonth() + 1;
        var day = today.getUTCDate();
        var time = (today.getUTCHours() + 9) + ":" + today.getUTCMinutes() + ":" + today.getUTCSeconds();

        if (underText.length != 0) {
            httpRequest = new XMLHttpRequest();

            httpRequest.open("post", "under.php", true)
            httpRequest.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

            data = "board_id=" + id + "&underText=" + underText;

            httpRequest.send(data);

            httpRequest.onreadystatechange = function () {
                if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                    var insertUnder = httpRequest.responseText;

                    var seletTab = document.getElementById("underTable");

                    var newTr = document.createElement("tr");
                    newTr.setAttribute("class", "tableStyle");

                    var newTd = Array();

                    for (var i = 0; i < 5; i++) {
                        newTd.push(document.createElement("td"));
                    }

                    newTd[0].setAttribute("class", "tableStyle");
                    newTd[1].setAttribute("class", "tableStyle");
                    newTd[2].setAttribute("class", "tableStyle");
                    newTd[3].setAttribute("class", "tableStyle");
                    newTd[4].setAttribute("class", "tableStyle");

                    var inputEle = document.createElement("input");
                    inputEle.type = "button";
                    inputEle.value = "삭제";

                    newTr.id;

                    <?php
                        $maxBoard_id = mysql_query("select board_id from board");
                        $maxBoard_id_result = mysql_fetch_row($maxBoard_id);

                        echo "newTr.id = "

                        echo "inputEle.onclick = 'delete_under($maxBoard_id_result[0], )'";

                        mysql_close();
                    ?>



                    newTd[3].appendChild(inputEle);

                    var inputEle_up = document.createElement("input");
                    inputEle_up.type = "button";
                    inputEle_up.value = "수정";
                    inputEle_up.onclick = "under_update($under_list_result[$j])";

                    newTd[4].appendChild(inputEle_up);

                    newTd[0].innerText = insertUnder;

                    <?php
                    $user_id = $_SESSION['id'];

                    echo "newTd[1].innerText = '$user_id';";
                    ?>

                    newTd[2].innerText = year + "-" + month + "-" + day + " " + time;

                    for (var i = 0; i < 5; i++) {
                        newTr.appendChild(newTd[i]);
                    }

                    seletTab.appendChild(newTr);
                }
            }
        }
        else {
            alert("내용을 입력하시오.");
        }

    }

    function returnPage(page) {
        window.location = 'board_list.php?page=' + page;
    }

    function delete_under(under_id, tr_id) {

        httpRequest = new XMLHttpRequest();

        httpRequest.open("post", "remove_board.php", true)
        httpRequest.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

        var data = "under_id=" + under_id;

        httpRequest.send(data);

        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState == 4 && httpRequest.status == 200) {
                var tr = document.getElementById(tr_id);

                while (tr.hasChildNodes()) {
                    tr.removeChild(tr.firstElementChild);
                }

                tr.parentNode.removeChild(tr);
            }
        }
    }

    function under_update(under_id) {
        alert(under_id);
    }
</script>
</html>


