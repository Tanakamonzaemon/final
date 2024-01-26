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

// GETリクエストの場合、指定されたIDの音楽情報を取得してフォームに表示
if (isset($_GET['id'])) {
    $music_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM Music WHERE music_id = ?");
    $stmt->execute([$music_id]);
    $music = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$music) {
        exit('指定されたIDの音楽が見つかりませんでした。');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTリクエストがあった場合、フォームから送信されたデータを処理

    // フォームから送信されたデータを取得
    $music_id = $_POST['music_id'];
    $music_name = $_POST['music_name'];
    $composer_name = $_POST['composer_name'];
    $youtube_url = $_POST['youtube_url'];
    $category_id = $_POST['category_id']; // 追加: カテゴリIDを取得

    // editMusic関数を呼び出して音楽情報を変更
    editMusic($pdo, $music_id, $music_name, $composer_name, $youtube_url, $category_id);

    // 変更が完了したら一覧ページにリダイレクト
    header('Location: index.php');
    exit();
}

// editMusic関数を追加
function editMusic($conn, $music_id, $music_name, $composer_name, $youtube_url, $category_id) {
    $stmt = $conn->prepare("UPDATE Music SET music_name=?, composer_name=?, youtube_url=?, category_id=? WHERE music_id=?");
    $stmt->execute([$music_name, $composer_name, $youtube_url, $category_id, $music_id]);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>音楽情報を変更</title>
</head>

<body>
    <h2>音楽情報を変更</h2>
    <form method="post" action="">
        <input type="hidden" name="music_id" value="<?php echo $music['music_id']; ?>">
        <label for="music_name">音楽名:</label>
        <input type="text" name="music_name" value="<?php echo $music['music_name']; ?>" required>
        <br>
        <label for="composer_name">作曲者名:</label>
        <input type="text" name="composer_name" value="<?php echo $music['composer_name']; ?>" required>
        <br>
        <label for="youtube_url">YouTube URL:</label>
        <input type="text" name="youtube_url" value="<?php echo $music['youtube_url']; ?>" required>
        <br>
        <!-- 追加: カテゴリを選択するプルダウン -->
        <label for="category">カテゴリ:</label>
        <select name="category_id" required>
            <?php
            $categories = getCategories($pdo);
            foreach ($categories as $category) {
                $selected = ($category['category_id'] == $music['category_id']) ? "selected" : "";
                echo "<option value='{$category['category_id']}' {$selected}>{$category['category_name']}</option>";
            }
            ?>
        </select>
        <br>
        <button type="submit">変更</button>
    </form>
</body>

</html>

<?php
// カテゴリ一覧を取得する関数
function getCategories($conn) {
    $stmt = $conn->prepare("SELECT * FROM Category");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
