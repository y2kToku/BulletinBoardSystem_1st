<?php

// 内部文字エンコーディングをUTF-8に設定
mb_internal_encoding("UTF-8");
// 画面から変数取得
$title = filter_input(INPUT_GET, "title");

if ($title == "") {
    echo 'カテゴリ名を入力してください。';
    // カテゴリ表示画面に遷移
    header('Location: ../view/dispCategories.php');
}

// サーバ接続
$link = mysql_connect('localhost', 'root', 'root');
if (!$link) {
    die('接続失敗です。' . mysql_error());
}
// DB選択
$db_selected = mysql_select_db('BulltinBoardSystem', $link);
if (!$db_selected) {
    die('DB選択失敗です。' . mysql_error());
}

// MySQLに対する処理
mysql_set_charset('utf8');

// タイトルの重複チェック
$sql_check = "SELECT COUNT(*) AS cnt FROM categories WHERE title = '$title' AND del_flg = 0;";
$result_check = mysql_query($sql_check);
$row = mysql_fetch_assoc($result_check);
$cnt = $row['cnt'];
if ($cnt > 0) {
    echo 'そのカテゴリは既に登録されています。';
    return;
}

// 登録
$sql = "INSERT INTO categories(title, creater, created, updater) VALUES('$title', 1, now(), 1)";
$result = mysql_query($sql);
if (!$result) {
    echo 'データを登録できませんでした。';
    return;
}

// サーバ切断
$close_flag = mysql_close($link);
if (!$close_flag) {
    // print('<p>切断に成功しました。</p>');
    echo 'サーバ切断に失敗しました。';
    return;
}

// カテゴリ表示画面に遷移する
header('Location: ../view/dispCategories.php');
?>