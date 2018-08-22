<html>
<head></head>
<body>
<table border="1">
    <thead>
        <tr>
            <td>번호</td>
            <td>아이디</td>
            <td>직업</td>
            <td>이름</td>
            <td>성별</td>
            <td>비밀번호</td>
            <td>폰번호</td>
            <td>이메일</td>
        </tr>
    </thead>
    <tbody>
    <!--  유저 정보   -->
        <?php foreach ($list as $lt) { ?>
                    <tr>
                        <th scope="row">
                            <?php echo $lt->sysid; ?>
                        </th>
                        <td><?php echo $lt->userid; ?></td>
                        <td><?php echo $lt->classification; ?></td>
                        <td><?php echo $lt->name; ?></td>
                        <td><?php echo $lt->gender; ?></td>
                        <td><?php echo $lt->password; ?></td>
                        <td><?php echo $lt->phone; ?></td>
                        <td><?php echo $lt->email; ?></td>
                    </tr>
        <?php } ?>
    <!--  유저 정보   -->
    </tbody>
    <tfoot>
        <tr>
            <th colspan="8"><?php echo $pagination; ?></th>
            <!-- 페이지네이션 -->
        </tr>
    </tfoot>
</table>
</body>
</html>