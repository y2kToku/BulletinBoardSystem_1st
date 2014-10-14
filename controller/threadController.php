<!--*****************************************************************************************
画面名：
機能概要：
        １.
        ２.
        ３.
*****************************************************************************************-->
<?php
session_start();
// スレッドモデルクラス読み込み
require_once("../model/thread.php");

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
// 遷移元画面：カテゴリ表示画面
// 初回表示時
    case 'firstDispThreads':
        // カテゴリ表示画面から変数取得
        if (isset($_SESSION['categoryID'])) {
            // スレッド登録後、遷移した場合
            $categoryID = $_SESSION['categoryID'];
        } else {
            // 初回表示時
            $categoryID = filter_input(INPUT_GET, "categoryID");
            $_SESSION['categoryID'] = $categoryID;
        }
        // スレッド表示画面にてページャを選択した場合
        $dispPage = filter_input(INPUT_GET, "page");
        // 画面表示データ取得後、画面切替画面に遷移
        $dispDefData = thread::getThreads($categoryID, $dispLimit, $dispPage);
        if (isset($dispDefData)) {
            $_SESSION['threadDispDefData'] = $dispDefData;
            echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="dispThreadForm" action="./changeDisp.php" method="POST">
<input type="hidden" name="action" value="threadDispDef">
<script language="JavaScript">document.dispThreadForm.submit();</script>
</form>
</body>
</html>
EOM;
        }

        break;

    // スレッド作成
    case 'makeThread':
        // スレッド表示画面から変数取得
        $content = filter_input(INPUT_GET, "content");
        $userID = $_SESSION['userID'];
        $categoryID = $_SESSION['categoryID'];
        // スレッド入力・重複チェック
        if (isset($content) && thread::ChkUniqThread($content) == "OK") {
            // スレッド登録
            if (thread::InsThread($categoryID, $content, $userID)) {
                // カテゴリテーブル更新
                if (thread::UpdCategoryAfterIns($categoryID, $userID)) {
                    // スレッド表示画面に遷移
                    echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="makeThreadForm" action="./threadController.php" method="GET">
<input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>">
<input type="hidden" name="action" value="firstDispThreads">
<script language="JavaScript">document.makeThreadForm.submit();</script>
</form>
</body>
</html>
EOM;
                }
            }
        }
        break;

    // スレッド修正
    case 'editThread':
        // スレッド修正画面から変数取得
        $content = filter_input(INPUT_GET, "content");
        $threadID = filter_input(INPUT_GET, "threadID");
        $userID = $_SESSION['userID'];
        $categoryID = $_SESSION['categoryID'];
        // スレッドテーブル更新
        if (thread::EditThread($threadID, $content, $userID)) {
            // カテゴリテーブル更新
            if (thread::UpdCategoryAfterEdit($categoryID, $userID)) {
                // スレッド表示画面に遷移
                echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="editThreadForm" action="./threadController.php" method="GET">
<input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>">
<input type="hidden" name="action" value="firstDispThreads">
<script language="JavaScript">document.editThreadForm.submit();</script>
</form>
</body>
</html>
EOM;
            }
        }
        break;

    // スレッド削除
    case 'dltThread':
        // スレッド表示画面から変数取得
        $threadID = filter_input(INPUT_GET, "threadID");
        $userID = $_SESSION['userID'];
        $categoryID = $_SESSION['categoryID'];
        // スレッドテーブル更新
        if (thread::DeleteThread($threadID, $userID)) {
            // カテゴリテーブル更新
            if (thread::UpdCategoryAfterDel($categoryID, $userID)) {
                // スレッド表示画面に遷移
                echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="deleteThreadForm" action="./threadController.php" method="GET">
<input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>">
<input type="hidden" name="action" value="firstDispThreads">
<script language="JavaScript">document.deleteThreadForm.submit();</script>
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