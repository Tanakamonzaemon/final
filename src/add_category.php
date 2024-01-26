<?php
$host = 'mysql220.phy.lolipop.lan';
$dbname = 'LAA1517470-final';
$user = 'LAA1517470';
$pass = 'Pass0522';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("データベースに接続できませんでした。エラー: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    // 新しいカテゴリーを登録
    addCategory($pdo, $category_name);

    // 登録が完了したら一覧ページにリダイレクト
    header('Location: index.php');
    exit();
}

function addCategory($conn, $category_name) {
    $stmt = $conn->prepare("INSERT INTO Category (category_name) VALUES (?)");
    $stmt->execute([$category_name]);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新しいカテゴリーを追加</title>
</head>

<body>
    <h2>新しいカテゴリーを追加</h2>
    <form method="post" action="">
        <label for="category_name">カテゴリー名:</label>
        <input type="text" name="category_name" required>
        <br>
        <button type="submit">登録</button>
    </form>
</body>

</html>
