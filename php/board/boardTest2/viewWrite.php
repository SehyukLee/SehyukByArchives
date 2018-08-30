<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<script>
    function titleCheck() {
        var title = document.getElementById("title_id").value;

        if (title.length == 0) {
            alert("제목을 입력하시오.");
        }
        else {
            document.getElementById("form_id").setAttribute("action", "write.php");
        }
    }
    // 제목 유무 체크
</script>
<body>
<form method="post" id="form_id">
    제목&nbsp;<input type="text" name="title" id="title_id">
    <br>
    내용
    <br>
    <textarea name="text" style="width: 500px; height: 500px">

    </textarea>
    <br>
    <input type="submit" value="저장" name="store" onclick="titleCheck()">
</form>
<form action="board_list.php">
    <input type="submit" value="취소">
</form>
<!-- 글 입력 태그 -->
</body>
</html>
