<html>
<head></head>
<body>
<form action="./userIdFind" method="post">
    <b>수정할 ID를 입력하세요</b><br>
    ID: <input type="text" name="ckeckId">
    <input type="submit" value="사용자 정보 조회">
</form>
<form action="./userUpdate/<?php echo $userid ?>" method="POST">
    <ol>
        <li>사용자 ID: <input type="text" name="userid" value="<?php echo $userid ?>" disabled></li>
        <li>이름: <input type="text" name="username" value="<?php echo $name ?>"></li>
        <li>암호: <input type="text" name="userpassword" value="<?php echo $password ?>"></li>
        <li>구분: <select name="classification">
                <option value="staff" <?php if($classification == 'staff'){ echo "selected";} ?>>교직원</option>
                <option value="student" <?php if($classification == 'student'){ echo "selected";} ?>>학생</option>
            </select></li>
        <li>성별: <select name="gender">
                <option value="male" <?php if($gender == 'male'){ echo "selected";} ?>>남성</option>
                <option value="female" <?php if($gender == 'female'){ echo "selected";} ?>>여성</option>
            </select></li>
        <li>전화번호: <input type="text" name="phone" value="<?php echo $phone ?>"></li>
        <li>이메일: <input type="text" name="email" value="<?php echo $email ?>"></li>
    </ol>
    <input type="submit" value="등록하기">
</form>
</body>
</html>