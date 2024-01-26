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
// 音楽一覧表示
function displayMusicList($conn) {
    $stmt = $conn->prepare("SELECT * FROM Music");
    $stmt->execute();

    echo "<h2>音楽一覧</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>音楽名</th>
                <th>作曲者名</th>
                <th>YouTube URL</th>
                <th>操作</th>
            </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['music_id']}</td>
                <td>{$row['music_name']}</td>
                <td>{$row['composer_name']}</td>
                <td>{$row['youtube_url']}</td>
                <td>
                    <a href='edit.php?id={$row['music_id']}'>編集</a> |
                    <a href='delete.php?id={$row['music_id']}'>削除</a>
                </td>
              </tr>";
    }

    echo "</table>";
}

// 新しい音楽を登録
function addMusic($conn, $music_name, $composer_name, $youtube_url) {
    $stmt = $conn->prepare("INSERT INTO Music (music_name, composer_name, youtube_url) VALUES (?, ?, ?)");
    $stmt->execute([$music_name, $composer_name, $youtube_url]);
}

// 音楽情報を変更
function editMusic($conn, $music_id, $music_name, $composer_name, $youtube_url) {
    $stmt = $conn->prepare("UPDATE Music SET music_name=?, composer_name=?, youtube_url=? WHERE music_id=?");
    $stmt->execute([$music_name, $composer_name, $youtube_url, $music_id]);
}

// 音楽を削除
function deleteMusic($conn, $music_id) {
    $stmt = $conn->prepare("DELETE FROM Music WHERE music_id=?");
    $stmt->execute([$music_id]);
}

// 音楽一覧表示
displayMusicList($conn);

// 新しい音楽を登録（例）
addMusic($conn, "新曲", "新しい作曲者", "https://www.youtube.com/new_song");

// 音楽情報を変更（例）
editMusic($conn, 1, "変更後の曲名", "変更後の作曲者", "https://www.youtube.com/changed_song");

// 音楽を削除（例）
deleteMusic($conn, 2);

// データベース接続を閉じる
$conn = null;
?>
