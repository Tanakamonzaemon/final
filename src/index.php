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

// add.php ファイルの先頭に追加
error_reporting(E_ALL);
ini_set('display_errors', 'On');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $music_name = isset($_POST['music_name']) ? $_POST['music_name'] : null;
    $composer_name = isset($_POST['composer_name']) ? $_POST['composer_name'] : null;
    $youtube_url = isset($_POST['youtube_url']) ? $_POST['youtube_url'] : null;
    
    // カテゴリの選択を受け取る
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;

    // デバッグ用：確認
    var_dump($music_name, $composer_name, $youtube_url, $category_id);

    // 新しい音楽を登録
    addMusic($pdo, $music_name, $composer_name, $youtube_url, $category_id);

    // 登録が完了したら一覧ページにリダイレクト
    header('Location: index.php');
    exit();
}

function addMusic($conn, $music_name, $composer_name, $youtube_url, $category_id) {
    $stmt = $conn->prepare("INSERT INTO Music (music_name, composer_name, youtube_url, category_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$music_name, $composer_name, $youtube_url, $category_id]);
}

function displayMusicList($conn, $category_id = null) {
    $sql = "SELECT Music.music_id, Category.category_name, Music.music_name, Music.composer_name, Music.youtube_url
            FROM Music LEFT JOIN Category ON Music.category_id = Category.category_id";
    $params = [];

    if ($category_id !== null) {
        $sql .= " WHERE Music.category_id = ?";
        $params[] = $category_id;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    echo "<h2>音楽一覧</h2>";

    // カテゴリー一覧を取得
    $categories = $conn->query("SELECT * FROM Category")->fetchAll(PDO::FETCH_ASSOC);

    // カテゴリー切り替え用のプルダウンメニュー
    echo "<form method='post' action=''>
            <label for='category_id'>カテゴリー選択:</label>
            <select name='category_id' id='category_id' onchange='this.form.submit()'>
                <option value=''>すべてのカテゴリー</option>";

    foreach ($categories as $category) {
        $selected = ($category_id == $category['category_id']) ? 'selected' : '';
        echo "<option value='{$category['category_id']}' $selected>{$category['category_name']}</option>";
    }

    echo "</select>
          </form>";

    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>カテゴリー</th>
                <th>音楽名</th>
                <th>作曲者名</th>
                <th>YouTube URL</th>
                <th>操作</th>
            </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['music_id']}</td>
                <td>{$row['category_name']}</td>
                <td>{$row['music_name']}</td>
                <td>{$row['composer_name']}</td>
                <td>{$row['youtube_url']}</td>
                <td>
                    <a href='edit.php?id={$row['music_id']}'>変更</a> |
                    <a href='delete.php?id={$row['music_id']}'>削除</a>
                </td>
              </tr>";
    }

    echo "</table>";
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>音楽一覧</title>
</head>

<body>
    <?php
    // カテゴリが選択されている場合はそのカテゴリに絞り込んで表示
    if (isset($_POST['category_id'])) {
        $selectedCategory = $_POST['category_id'];
        displayMusicList($pdo, $selectedCategory);
    } else {
        // カテゴリが選択されていない場合は全ての音楽を表示
        displayMusicList($pdo);
    }
    ?>
    <br>
    <a href='add.php'>新しい音楽を追加</a>
</body>

</html>
