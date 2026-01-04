<?php
//エラー表示
ini_set("display_errors", 1);

//1. 関数ファイル読み込み
require_once('funcs.php');

//2. DB接続（funcs.phpのdb_conn()を使用）
$pdo = db_conn();

//1.  DB接続します
// try {
    //Password:MAMP='root',XAMPP=''
    // $pdo = new PDO('mysql:dbname=gs_db_weight;charset=utf8;host=localhost', 'root', '');
// } catch (PDOException $e) {
    // exit('DBConnectError!!!' . $e->getMessage());
// }

//３．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_weight_table");
$status = $stmt->execute();

//４．データ表示
$view = "";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQL Error!:" . $error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values, JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>体重グラフ</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #c95a3bff;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        #chartContainer {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        canvas {
            max-height: 400px;
        }
    </style>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php" style="margin-top: 8px;">【体重を記録する】</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->


    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron">
            <h2>体重の推移</h2>

            <?php if (count($values) > 0): ?>

                <!-- グラフ表示エリア -->
                <div id="chartContainer">
                    <canvas id="weightChart"></canvas>
                </div>

                <!-- データテーブル -->
                <h3>記録一覧</h3>
                <table>
                    <thead>
                        <tr>
                            <td>日付</td>
                            <td>体重（kg）</td>
                            <td>メモ</td>
                            <td>登録日時</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($values as $v): ?>
                            <tr>
                                <td><?= $v["date"] ?></td>
                                <td><?= $v["weight"] ?> kg</td>
                                <td><?= $v["memo"] ?></td>
                                <td><?= $v["indate"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <p>まだ体重が記録されていません。</p>
                <a href="index.php" class="btn btn-primary">最初の記録をする</a>
            <?php endif; ?>

        </div>
    </div>
    <!-- Main[End] -->


    <script>
        //JSON受け取り
        const data = JSON.parse('<?= $json ?>');
        console.log(data); // データ確認用

        // グラフ用にデータを整形
        const dates = data.map(item => item.date);
        const weights = data.map(item => parseFloat(item.weight));

        // Chart.jsでグラフを描画
        const ctx = document.getElementById('weightChart').getContext('2d');
        const weightChart = new Chart(ctx, {
            type: 'line', // 折れ線グラフ
            data: {
                labels: dates, // X軸（日付）
                datasets: [{
                    label: '体重（kg）',
                    data: weights, // Y軸（体重）
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3, // 線の曲がり具合
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: '体重の推移グラフ',
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false, // 0から始めない
                        title: {
                            display: true,
                            text: '体重（kg）'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: '日付'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>