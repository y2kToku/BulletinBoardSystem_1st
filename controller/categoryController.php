<!--*****************************************************************************************
画面名：
機能概要：
        １.
        ２.
        ３.
*****************************************************************************************-->
<?php
session_start();
// カテゴリモデルクラス読み込み
require_once("../model/category.php");

// 遷移元画面の判断
if (filter_input(INPUT_GET, "action") == "") {
    $beforeDisp = filter_input(INPUT_POST, "action");
} else {
    $beforeDisp = filter_input(INPUT_GET, "action");
}

// 画面表示件数
$dispLimit = 10;

// 画面遷移
switch ($beforeDisp) {
    // 遷移元画面：ログイン画面、サインアップ画面
    // 初回表示時
    case 'firstDisp':
        // 画面表示データ取得後、画面切替画面に遷移
        $dispDefData = category::getDefCategories($dispLimit);
        if (isset($dispDefData)) {
            $_SESSION['categoryDispDefData'] = $dispDefData;
            echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="dispCategoryForm" action="./changeDisp.php" method="POST">
<input type="hidden" name="action" value="dispDef">
<script language="JavaScript">document.dispCategoryForm.submit();</script>
</form>
</body>
</html>
EOM;
        }

        break;
    // 遷移元画面：カテゴリ表示画面
    // ソートボタン押下時
    case 'sort':
        break;

    // 遷移先：カテゴリ作成
    case 'makeCategory':
        // カテゴリ表示画面から変数取得
        $title = filter_input(INPUT_GET, "title");
        $userID = $_SESSION['userID'];
        // カテゴリ重複チェック
        if (category::ChkUniqCategory($title) == "OK") {
            // カテゴリ登録
            if (category::InsCategory($title, $userID)) {
                // カテゴリ登録後、カテゴリ表示画面に遷移
                echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="makeCategoryForm" action="../view/dispCategories.php" method="POST">
<input type="hidden" name="action" value="madeCategory">
<script language="JavaScript">document.makeCategoryForm.submit();</script>
</form>
</body>
</html>
EOM;
            }
        }
        break;

    default:
        break;
}