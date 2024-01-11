<?php
$host = 'mysql217.phy.lolipop.lan';
$dbname = 'LAA1517470-inful';
$user = 'LAA1517470';
$pass = 'Influenza';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("データベースに接続できませんでした。エラー: " . $e->getMessage());
}

// 初期化
$error = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡単な一覧表</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px;
            margin: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>一覧表</h2>

<button onclick="addRow()">登録</button>
<button onclick="deleteRow()">削除</button>
<button onclick="editRow()">編集</button>

<table id="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <!-- ここにデータが表示されます -->
    </tbody>
</table>

<script>
    function addRow() {
        var table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);

        cell1.innerHTML = "New ID";
        cell2.innerHTML = "New Name";
        cell3.innerHTML = "New Email";
    }

    function deleteRow() {
        var table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
        if (table.rows.length > 0) {
            table.deleteRow(table.rows.length - 1);
        }
    }

    function editRow() {
        // 編集ロジックをここに追加
    }
</script>

</body>
</html>

