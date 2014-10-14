<!--*****************************************************************************************
画面名：画面切替画面
機能概要：遷移元画面からGETもしくはPOSTで値を取得し、遷移先画面をそれぞれに設定し、遷移させる
*****************************************************************************************-->
<?php
session_start();

// 遷移元画面取得
$beforeDisp = filter_input(INPUT_POST, "action");

// 各遷移元画面により遷移先画面を設定する
switch ($beforeDisp) {
// 遷移元画面：ログイン画面
    case 'login':
// 遷移先画面：カテゴリコントローラ
        echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="mvLoginForm" action="./categoryController.php" method="POST">
<input type="hidden" name="action" value="firstDisp">
<script language="JavaScript">document.mvLoginForm.submit();</script>
</form>
</body>
</html>
EOM;
        break;

// 遷移元画面：サインアップ画面
    case 'signup':
// 遷移先画面：カテゴリコントローラ
        echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="mvSignupForm" action="./categoryController.php" method="POST">
<input type="hidden" name="action" value="firstDisp">
<script language="JavaScript">document.mvSignupForm.submit();</script>
</form>
</body>
</html>
EOM;
        break;

//遷移元画面：カテゴリコントローラ
    case 'dispDef':
// カテゴリ画面初期表示データ取得
//        $dispDefData = filter_input(INPUT_POST, "dispDefData");
// 遷移先画面：カテゴリ表示画面
        echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="mvDefCategoryForm" action="../view/dispCategories.php" method="POST">
<input type="hidden" name="action" value="firstDisp">
<script language="JavaScript">document.mvDefCategoryForm.submit();</script>
</form>
</body>
</html>
EOM;
        break;

// 遷移元画面：スレッドコントローラ
    case 'threadDispDef':
        // 遷移先画面：スレッド表示画面
        echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="mvDefThreadForm" action="../view/dispThreads.php" method="POST">
<input type="hidden" name="action" value="firstDisp">
<script language="JavaScript">document.mvDefThreadForm.submit();</script>
</form>
</body>
</html>
EOM;
        break;
    default:
        break;
}

