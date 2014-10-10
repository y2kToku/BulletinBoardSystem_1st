<!--*****************************************************************************************
画面名：サインアップチェック
機能概要：掲示板を利用するアカウントのサインアップをする
        １.画面項目の入力チェック
        ２.アカウント情報の重複チェック（メールアドレスとパスワードで弾く）
        ３.アカウント情報のDB登録
        ４.アカウント情報をセッション変数へ格納
        ５.サインアップ終了後、カテゴリ選択画面に遷移させる
*****************************************************************************************-->

<?php
session_start();
// ログインモデルクラス読み込み
require_once("../model/login_user.php");

// サインアップ画面から変数を取得
$name = filter_input(INPUT_POST, "name");
$name_kana = filter_input(INPUT_POST, "nameKana");
$mailAddress = filter_input(INPUT_POST, "mailAddress");
$password = filter_input(INPUT_POST, "password");
$password_confirm = filter_input(INPUT_POST, "passwordConfirm");
$hint = filter_input(INPUT_POST, "hint");
$admin_flg = filter_input(INPUT_POST, "admin_flg");
// エラーフラグ
$err_flg = false;

// アカウント情報の重複チェック
if (login_user::ChkUniqAccountS($mailAddress, $password, $password_confirm) == "OK") {
// サインアップ処理
    if (login_user::InsUser($mailAddress, $name, $name_kana, $password, $hint, $admin_flg)) {
// サインアップ処理後、登録したユーザーID取得
        $userID = login_user::GetUserID($mailAddress, $password);
// ユーザIDをセッションに格納
        $_SESSION['userID'] = $userID;
// サインアップ処理成功後、画面切替画面に遷移
        echo <<< EOM
<html>
<head><title></title>
</head>
<body>
<form name="signupForm" action="./changeDisp.php" method="POST">
<input type="hidden" name="action" value="signup">
<script language="JavaScript">document.signupForm.submit();</script>
</form>
</body>
</html>
EOM;
    }
}