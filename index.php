<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>体重記録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}
    .container{max-width: 600px; margin: 50px auto;}
  </style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="select.php">【体重グラフを見る】</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>体重記録</legend>
     <label>日付：<input type="date" name="date" required value="<?= date('Y-m-d') ?>"></label><br>
     <label>体重（kg）：<input type="number" name="weight" step="0.1" min="0" max="300" required placeholder="例: 65.5"></label><br>
     <label>メモ：<br>
       <textArea name="memo" rows="4" cols="40" placeholder="例: 朝食後に測定"></textArea>
     </label><br>
     <input type="submit" value="記録する" class="btn btn-primary">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
