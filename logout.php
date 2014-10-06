<!--*****************************************************************************************
画面名：ログアウト画面
機能概要：掲示板を利用するアカウントをログアウトさせ、ログイン画面へのリンクを表示する
	１.セッションの破棄
	２.ログアウト時のメッセージ表示
	３.ログイン画面へのリンク表示
*****************************************************************************************-->

<html>
<head>
	<meta charset="utf-8">
	<!-- TODO CSS読み込み -->
	<link rel="stylesheet" type="text/css" href="basic.css" />
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
					<p><h2>とくとく掲示板β ver. 0.0.1</h2></p>
				</div>
			</div>
			<!-- ログアウト表示 -->
			<?php
				// $_SESSION = array() ; すべてのセッション変数を初期化
				// session_destroy() ; セッションを破棄
			?>
			<p><h2>ログアウトしました。</h2></p>
			<div id="baseSpace1" />
			<a href="login.php">ログイン画面へ</a>
		</div>
		<div id="pageFooter"></div>
	</div>
</body>
</html>