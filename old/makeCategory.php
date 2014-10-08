<?php

require_once("../model/DbPdo.php");

// 内部文字エンコーディングをUTF-8に設定
mb_internal_encoding("UTF-8");
// 画面から変数取得
$title = filter_input(INPUT_GET, "title");
$userID = filter_input(INPUT_GET, "userID");

if ($title == "") {
    exit('カテゴリ名を入力してください。');
    // カテゴリ表示画面に遷移
    header('Location: ../view/dispCategories.php');
}

// タイトルの重複チェック
$sql_check = "SELECT * FROM categories WHERE title = " . "'" . $title . "'" . " AND del_flg = 0;";
$result_cnt = DbPdo::CountPdo($sql_check);
if ($result_cnt > 0) {
    exit('そのカテゴリは既に登録されています。');
}

// 登録
$sql = "INSERT INTO categories(title, creater, created, updater) VALUES(" . "'" . $title . "'" . ", " . "'" . $userID . "'" . ", now(), " . "'" . $userID . "'" . ")";
$result = DbPdo::InsUpdDelPdo($sql);
if (!$result) {
    exit('データを登録できませんでした。');
}

// カテゴリ表示画面に遷移する
echo '<a href="../view/dispCategories.php">カテゴリ表示画面へ</a>';
?>