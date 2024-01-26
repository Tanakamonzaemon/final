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

// GETリクエストの場合、指定されたIDの音楽を削除
if (isset($_GET['id'])) {
    $music_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM Music WHERE music_id = ?");
    $stmt->execute([$music_id]);

    // 削除が完了したら一覧ページにリダイレクト
    header('Location: index.php');
    exit();
} else {
    exit('IDが指定されていません。');
}
?>

