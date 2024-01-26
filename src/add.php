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

// カテゴリ一覧を取得
$categories = getCategories($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $music_name = isset($_POST['music_name']) ? $_POST['music_name'] : null;
    $composer_name = isset($_POST['composer_name']) ? $_POST['composer_name'] : null;
    $youtube_url = isset($_POST['youtube_url']) ? $_POST['youtube_url'] : null;
    
    // カテゴリの選択を受け取る
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;

    // 新しい音楽を登録
    addMusic($pdo, $music_name, $composer_name, $youtube_url, $category_id);

    // 登録が完了したら一覧ページにリダイレクト
    header('Location: index.php');
    exit();
}

function getCategories($conn) {
    $stmt = $conn->prepare("SELECT * FROM Category");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addMusic($conn, $music_name, $composer_name, $youtube_url, $category_id) {
    $stmt = $conn->prepare("INSERT INTO Music (music_name, composer_name, youtube_url, category_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$music_name, $composer_name, $youtube_url, $category_id]);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新しい音楽を追加</title>
</head>

<body>
    <h2>新しい音楽を追加</h2>
    <form method="post" action="">
        <label for="music_name">音楽名:</label>
        <input type="text" name="music_name" required>
        
        <br>
        <label for="composer_name">作曲者名:</label>
        <input type="text" name="composer_name" required>
        <br>
        <label for="youtube_url">YouTube URL:</label>
        <input type="text" name="youtube_url" required>
        <br>
        <!-- カテゴリーの選択用のプルダウンメニュー -->
        <label for="category_id">カテゴリ:</label>
        <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit">登録</button>
    </form>

    <br>
    <!-- カテゴリーを追加するボタン -->
    <a href="add_category.php">新しいカテゴリーを追加</a>
</body>

</html>
