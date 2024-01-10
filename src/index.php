<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>課題2-1-input</title>
</head>
<body>
    <h1>今日の日付を選んでください</h1>
    5月22日にすると、、！？
    <form action="kadai2-1-output.php" method="post">
        <select name="month">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                echo '<option value="' . $i . '">' . $i . '月</option>';
            }
            ?>
        </select>
        <select name="day">
            <?php
            for ($i = 1; $i <= 31; $i++) {
                echo '<option value="' . $i . '">' . $i . '日</option>';
            }
            ?>
        </select>
        <button type="submit">送信</button>
    </form>
</body>
</html>
