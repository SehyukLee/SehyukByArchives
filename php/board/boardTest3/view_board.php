<?php
    $view_id = isset($_GET['id']) ? $_GET['id'] : null;
    // 글 번호

    @$db_con = mysql_connect("localhost", "root", "autoset");
    mysql_select_db("ycj_test");
    // 데이터베이스 연결

    $hitCount = mysql_query("select hits from ycj_first_board where board_id = $view_id");
    $hitCountArr = mysql_fetch_row($hitCount);
    // 글번호에 따른 조회수

    if (!isset($_COOKIE[$view_id])) {
        // 쿠키가 없을 경우

        $hitCountArr[0]++;
        // 조회수 증가

        mysql_query("update ycj_first_board set hits = $hitCountArr[0] where board_id = $view_id");
        // 조회수 데이터베이스에 저장

        setcookie($view_id, $hitCountArr[0], time() + 86400);
        // 쿠키 생성
    }

    $result = mysql_query("select subject, contents from ycj_first_board where board_id = $view_id");
    $result = mysql_fetch_row($result);
    // 글 번호에따른 제목과 내용

    $result[1] = htmlspecialchars_decode($result[1]);
    $result[1] = nl2br($result[1]);
    // 내용 변환

    echo "<div align='center'>";

    echo "<div align='center' style='width: 300px; height: 100px; border: 1px solid black;'>";
    echo "<h1>$result[0]</h1>";
    echo "</div>";

    echo "<div align='center' style='width: 300px; height: 100px; border: 1px solid black;'>";
    echo "<h5>$result[1]</h5>";
    echo "</div>";

    echo "</div>";
    // 제목과 내용 출력

    if(isset($_SESSION['userid'])) {
        // 로그인 되어있을 시

        $login_id = $_SESSION['userid'];  // 로그인 아이디
        $logResult = mysql_query("select board_id from ycj_first_board where user_id = '$login_id' and board_pid = 0");
        // 로그인한 아이디로 올린 글 번호

        $logRow = mysql_num_rows($logResult);       // 로그인한 아이디로 올린 글번호들의 테이블의 열 수
        $logField = mysql_num_fields($logResult);   // 로그인한 아이디로 올린 글번호들의 테이블의 필드 수

        for ($i = 0; $i < $logRow; $i++) {
            $logResultArr = mysql_fetch_row($logResult);

            for ($j = 0; $j < $logField; $j++) {
                if ($logResultArr[$j] == $view_id) {
                    // 사용자가 올린 글일 때

                    echo "<div align='center'>";
                    echo "<input type='submit' value='수정' onclick='transfer()'>";
                    echo "<input type='submit' value='삭제' onclick='deleteData()'>";
                    echo "</div>";
                }
            }
        }
        // 로그인한 아이디로 쓴 글일 때 수정, 삭제 기능 가능

        echo "<div align='center'>";
        echo "<input type='text' id='underText'>";
        echo "<input type='submit' value='댓글달기' onclick='underText()'>";

        $viewUnder = mysql_query("select user_id, contents, reg_date, board_id from ycj_first_board where board_pid = $view_id");
        $row =mysql_num_rows($viewUnder);
        $field = mysql_num_fields($viewUnder);
        // 해당 글에 쓴 모든 댓글

        echo "<table id='under' width='600px'>";
        for ($i = 0; $i < $row; $i++) {
            $viewUnderArr = mysql_fetch_row($viewUnder);

            echo "<tr>";

            for ($j = 0; $j < $field; $j++) {
                if ($viewUnderArr[$j] == null) {
                    echo "<td align='center'>";
                    echo "";
                }
                else {
                    if ($j == 1) {
                        echo "<td align='center' id='td$viewUnderArr[3]'>";

                        $viewUnderArr[$j] = htmlspecialchars_decode($viewUnderArr[$j]);
                        $viewUnderArr[$j] = nl2br($viewUnderArr[$j]);

                        echo "<p id='$viewUnderArr[3]' ondblclick='updateUnder(this.id)'>";
                        echo $viewUnderArr[$j];
                        echo "</p>";
                        echo "</td>";
                        continue;
                    }
                    else {
                        echo "<td align='center'>";

                        if ($j == 2) {
                            echo "<p id='date$viewUnderArr[3]'>";
                            echo "$viewUnderArr[$j]";
                            echo "</td>";
                            continue;
                        }

                        if ($j == 3) {
                            $user = mysql_query("select user_id from ycj_first_board where board_id = $viewUnderArr[3]");
                            $userArr = mysql_fetch_row($user);

                            if($userArr[0] == $_SESSION['userid']) {
                                echo "<input type='button' value='삭제' onclick='deleteUnder($viewUnderArr[$j])'>";
                                echo "</td>";
                                continue;
                            }
                            else {
                                echo "";
                                echo "</td>";
                                continue;
                            }

                        }

                        echo $viewUnderArr[$j];
                    }
                }

                echo "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }

    echo "<script>";
    echo "function transfer() { location.href = 'Update.php?id=$view_id' }";
    echo "function deleteData() { location.href = 'delete.php?id=$view_id' }";
    echo "</script>";
?>
<script>
    function underText() {
        var text = document.getElementById("underText").value;

        httpRequest = new XMLHttpRequest();

        httpRequest.open("POST", "underText.php", true);
        httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        <?php
            echo "var data = 'text=' + text + '&id=' + $view_id" ;
            mysql_close($db_con);
        ?>

        httpRequest.send(data);

        httpRequest.onreadystatechange = function () {
            if(httpRequest.readyState == 4 && httpRequest.status == 200) {
                var inputText = httpRequest.responseText;

                var textArr = inputText.split("|");
                var window = document.createElement("tr");

                for (var i = 0; i < textArr.length; i++) {

                    var underWindow = document.createElement("td");
                    underWindow.setAttribute("align", "center");

                    if (i ==textArr.length - 2) {
                        underWindow.id = "date" + textArr[3];
                    }

                    if (i == textArr.length - 3) {
                        underWindow.id = "td" + textArr[3];
                        var pTag = document.createElement("p");
                        pTag.id = textArr[3];
                        pTag.innerHTML = textArr[i];
                        pTag.setAttribute("ondblclick", "updateUnder(this.id)");
                        underWindow.appendChild(pTag);
                    }
                    else if (i == textArr.length - 1) {
                        var del = document.createElement("input");
                        del.setAttribute("type", "button")
                        del.value = "삭제";
                        del.id = textArr[i];
                        del.setAttribute("onclick", "deleteUnder(this.id)")
                        underWindow.appendChild(del);
                    }
                    else {
                        underWindow.innerHTML = textArr[i];
                    }

                    window.appendChild(underWindow);
                    document.getElementById("under").appendChild(window);
                }
            }
        }
    }

    function deleteUnder(board_id) {
        location.href = "delete.php?id=" + board_id;
    }

    function updateUnder(under_id) {
        var textUnder = document.createElement("input");
        textUnder.setAttribute("type", "text");
        textUnder.id = "text" + under_id;
        textUnder.value = document.getElementById(under_id).innerText;

        var store = document.createElement("input");
        store.setAttribute("type", "button");
        store.value = "변경";
        store.setAttribute("onclick", "underDataAjax(" + under_id + ")");

        var td = document.getElementById("td" + under_id);
        td.removeChild(td.firstChild);
        td.appendChild(textUnder);
        td.appendChild(store);
    }

    function underDataAjax(id_data) {
        var content = document.getElementById("text" + id_data).value;

        httpRequest = new XMLHttpRequest();

        httpRequest.open("POST", "underUpdate.php", true);
        httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var data = 'text=' + content + '&id=' + id_data;

        httpRequest.send(data);

        httpRequest.onreadystatechange = function () {
            if(httpRequest.readyState == 4 && httpRequest.status == 200) {
                var inputText = httpRequest.responseText;

                while (document.getElementById("td" + id_data).hasChildNodes()) {
                    document.getElementById("td" + id_data).removeChild(document.getElementById("td" + id_data).firstElementChild);
                }

                var textArr = inputText.split("|");

                var tag_p = document.createElement("p");
                tag_p.id = id_data;
                tag_p.setAttribute("ondblclick", "updateUnder(this.id)");
                tag_p.innerHTML = textArr[0];

                document.getElementById("td" + id_data).appendChild(tag_p);
                document.getElementById("date" + id_data).innerHTML = textArr[1];
            }
        }
    }
</script>