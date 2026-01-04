<?php
//エラー表示
ini_set("display_errors", 1); //0=非表示

//1. POSTデータ取得
$date = $_POST['date'];
$weight = $_POST['weight'];
$memo = $_POST['memo'];

//2. 関数ファイル読み込み
require_once('funcs.php');

//3. DB接続（funcs.phpのdb_conn()を使用）
$pdo = db_conn();

// try {
  //Password:MAMP='root',XAMPP=''
  // $pdo = new PDO('mysql:dbname=gs_db_weight;charset=utf8;host=localhost','root','');
// } catch (PDOException $e) {
  // exit('DBConnectError!!!'.$e->getMessage());
// }


//４．データ登録SQL作成
$sql = "INSERT INTO gs_weight_table(date, weight, memo, indate)VALUES(:date, :weight, :memo, sysdate());"; //ここにINSERT文
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date', $date); //サニタイジング・無効化
$stmt->bindValue(':weight', $weight);
$stmt->bindValue(':memo', $memo);
$status = $stmt->execute(); //$status true = 成功, false = SQLエラー

//５．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError!!:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit();
}
?>
