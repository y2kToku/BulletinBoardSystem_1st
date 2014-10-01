<!--*****************************************************************************************
画面名：ログイン画面
機能概要：掲示板を利用するアカウントのログインをする
	１.アカウント名とパスワードのAND検索で重複チェック
	２.ログインボタン押下後、カテゴリ選択画面に遷移する
	３.「コチラ」リンク押下後、サインアップ画面に遷移する
*****************************************************************************************-->

<html>
<head>
	<meta charset="utf-8">
	<!-- TODO CSS読み込み -->
	<link rel="stylesheet" type="text/css" href="basic.css" />
	<title>ログイン</title>
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
			<!-- ユーザ入力フォーム -->
			<form id="loginForm" name="loginForm" action="loginCheck.php" method="POST">
				<div style="height: 600px;">
					<table>
						<tr>
							<td style="width: 40%; text-align: right;">
								アカウント（メールアドレス）：
							</td>
							<td style="width: 40%; text-align: left;">
								<input type="text" name="mailAddress">
							</td>
							<td style="width: 20%; text-align: left;">
								<p style="color: red;">＊</p>
							</td>
						</tr>
						<tr>
							<td style="width: 40%; text-align: right;">
								パスワード：
							</td>
							<td style="width: 40%; text-align: left;">
								<input type="password" name="password">
							</td>
							<td style="width: 20%; text-align: left;">
								<p style="color: red;">＊</p>
							</td>
						</tr>
						<tr id="baseSpace1"></tr>
						<tr>
							<td>
								<input type="submit" id="login" name="login" value="ログイン">
							</td>
						</tr>
						<tr>
						<td>
							初めての方は
							<a href="signup.php">コチラ</a>
							からどうぞ！
						</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
		<div id="pageFooter"></div>
	</div>
</body>
</html>