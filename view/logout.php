<!--*****************************************************************************************
画面名：ログアウト画面
機能概要：掲示板を利用するアカウントをログアウトさせ、ログイン画面へのリンクを表示する
        １.セッションの破棄
        ２.ログアウト時のメッセージ表示
        ３.ログイン画面へのリンク表示
*****************************************************************************************-->
<?php
session_start();
// 全てのセッション変数を初期化
$_SESSION = array();
// セッションを破棄
session_destroy();
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/basic.css" />
        <title>ログアウト</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="pageHeader"></div>
            <div style="height: auto;">
                <!-- ロゴ＆説明 -->
                <div style="height: 240px;">
                    <div style="float: left; width: 30%;">
                        <!-- TODO 何か画像を添付する -->
                    </div>
                    <div style="float: left; width: 70%;">
                        <h2>とくとく掲示板β ver. 0.0.1</h2>
                    </div>
                </div>
                <h2>ログアウトしました。</h2>
                <div id="baseSpace1" />
                <a href="./login.php">ログイン画面へ</a>
            </div>
            <div id="pageFooter"></div>
        </div>
    </div>
</body>
</html>