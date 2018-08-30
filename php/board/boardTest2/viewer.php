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
        // 테이블 스타일
    </style>
</head>
<body>
<?php
    $id = isset($_GET['id']) ? $_GET['id'] : false;         // 게시글 아이디
    $page = isset($_GET['page']) ? $_GET['page'] : 1;       // 페이지 번호

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("sehyuk_board");
    // DB연결
    
    $find = mysql_query("select subject, contents, user_id from board where board_id = $id");
    $find_result = mysql_fetch_row($find);
    // 게시글 번호의 내용 검색

    $find_result[1] = html_entity_decode($find_result[1]);
    $find_result[1] = str_replace("&nbps;", " ", $find_result[1]);
    // 문자열 처리

    echo "<table align='center'>";
    echo "<tr><td class='tableStyle' style='height: 100px; width: 500px'>$find_result[0]</td></tr>";
    echo "<tr><td class='tableStyle' style='height: 400px; width: 500px'>$find_result[1]</td></tr>";
    echo "</table>";
    // 게시글 내용 출력

    if (isset($_SESSION['name']) && $_SESSION['id'] == $find_result[2]) {
        // 로그인한 상태일 경우
        
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
        // 댓글달기 태그

        $under_list_count = mysql_query("select count(board_id) from board where board_pid = $id");
        $under_list_count = mysql_fetch_row($under_list_count);
        // 게시글에 달린 댓글 갯수 검색

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
        // 게시글에 달린 댓글 내용 검색

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
                    // 댓글 삭제 버튼
                }
                else {
                    echo "<input type='button' value='수정' onclick='under_update($under_list_result[3])'>";
                    // 댓글 수정 버튼
                }

                echo "</td>";
            }

            echo "</tr>";
        }
        // 댓글 내용 출력

        echo "</table>";
        echo "</div>";

        echo "<div align='center'>";
        echo "<form method='post' action='reWrite.php?board_id=$id'>";
        echo "<input type='submit' value='수정'>";
        echo "</form>";
        // 게시글 수정 버튼

        echo "<form method='post' action='remove_board.php?board_id=$id'>";
        echo "<input type='submit' value='삭제'>";
        echo "</form>";
        echo "</div>";
        // 게시글 삭제 버튼
    }

    echo "<div align='center'>";
    echo "<input type='button' value='돌아가기' onclick='returnPage($page)'>";
    echo "</div>";
    // 뒤로가기 버튼
?>
</body>
<script>
    function underTextFunc(id) {
        var underText = document.getElementById("underText").value;     // 입력한 댓글 내용
        var today = new Date();                                         // 날짜 객체 생성
        var year =  today.getUTCFullYear();                             // 현재 년도
        var month = today.getUTCMonth() + 1;                            // 현재 달
        var day = today.getUTCDate();                                   // 현재 일
        var time = (today.getUTCHours() + 9) + ":" + today.getUTCMinutes() + ":" + today.getUTCSeconds();
        // 현재 시간

        if (underText.length != 0) {
            // 입력한 값이 있을 경우
            
            // Ajax이용
            httpRequest = new XMLHttpRequest();

            httpRequest.open("post", "under.php", true)
            httpRequest.setRequestHeader('content-type', 'application/x-www-form-urlencoded');

            data = "board_id=" + id + "&underText=" + underText;

            httpRequest.send(data);

            httpRequest.onreadystatechange = function () {
                // 입력한 내용 출력
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
            // 입력한 내용이 없을 경우
            
            alert("내용을 입력하시오.");
        }

    }
    // 입력한 댓글 저장 후 출력하기

    function returnPage(page) {
        window.location = 'board_list.php?page=' + page;
    }
    // 페이지 돌아가기

    function delete_under(under_id, tr_id) {
        
        // Ajax이용
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
    // 댓글 삭제

    function under_update(under_id) {
        alert(under_id);
    }
    // 댓글 수정
</script>
</html>


