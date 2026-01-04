<?php
//共通に使う関数を記述

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}


//DBConnection
function db_conn(){
     // ローカル環境用のデータベース接続情報
    $db_name = *********;              // データベース名
    $db_host = *********;                 // DBホスト
    $db_id   = *********;                      // ユーザー名
    $db_pw   = *********;                          // パスワード（XAMPPは空、MAMPは'root'）
    
    // try catch構文でデータベースの情報取得を実施
    try {
        $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
        $pdo = new PDO($server_info, $db_id, $db_pw);
        return $pdo; // PDOオブジェクトを返す
    } catch (PDOException $e) {
        // エラーだった場合の情報を返す処理
        exit('DB Connection Error:' . $e->getMessage());
    }
}








?>