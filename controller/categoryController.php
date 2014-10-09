<!--*****************************************************************************************
画面名：
機能概要：
        １.
        ２.
        ３.
*****************************************************************************************-->
<?php
// カテゴリモデルクラス読み込み
require_once("../model/category.php");
// 遷移元画面の判断
$beforeDisp = filter_input(INPUT_POST, "action");
$beforeDisp = filter_input(INPUT_GET, "action");

// 画面遷移
switch ($beforeDisp) {
    // 遷移元：ログイン画面
    case "login":
        // ログイン画面から変数取得
        $userID = filter_input(INPUT_POST, "userID");
        // ページャ設定用変数
        $dispLimit = 10;
        // ログイン処理後、カテゴリ表示画面に遷移

        break;
    // 遷移元：カテゴリ作成
    case "makeCategory":
        // カテゴリ表示画面から変数取得
        $title = filter_input(INPUT_GET, "title");
        $userID = filter_input(INPUT_GET, "userID");
        // カテゴリ重複チェック
        if (category::ChkUniqCategory($title) == "OK") {
            // カテゴリ登録
            if (category::InsCategory($title, $userID)) {
                // カテゴリ登録後、カテゴリ選択画面に遷移
                echo '<a href="../view/dispCategories.php">カテゴリ表示画面へ</a>';
            }
        }
        break;

    default:
        break;
}