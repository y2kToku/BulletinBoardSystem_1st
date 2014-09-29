<!--*****************************************************************************************
画面名：サインアップ画面
機能概要：掲示板を利用するアカウントの新規登録をする
	１.アカウント名とパスワードのAND検索で重複チェック
	２.写真登録する場合は、各画面用のサムネイル画像を生成し、DBに合わせて保存する
	３.ヒントはフリーワード入力で、パスワードを忘れた場合の検索キーとしてアカウント名と共に使用する
	４.登録ボタン押下後、カテゴリ選択画面に遷移する
*****************************************************************************************-->

<!--<?php
// require 'password.php';
// // セッション開始
// session_start();

// // 変数の初期化
// $name = "";
// $password = "";
// // エラーメッセージの初期化
// $errorMsg = "";

// // ログインボタン押下時
// if (isset($_POST["login"])) {
//   // ユーザIDの入力チェック
//   if (empty($_POST["name"])) {
//     $errorMsg = "ユーザIDが未入力です。";
//   } else if (empty($_POST["password"])) {
//     $errorMsg = "パスワードが未入力です。";
//   }

//   // ユーザIDとパスワードが入力されていたら認証する
//   if (!empty($_POST["name"]) && !empty($_POST["password"])) {
//     // mysqlへの接続
//     // $mysqli = new mysqli(DBサーバアドレス, ユーザID, パスワード);
//     // if ($mysqli->connect_errno) {
//     //   print('<p>データベースへの接続に失敗しました。</p>' . $mysqli->connect_error);
//     //   exit();
//     }

//     // データベースの選択
//     // $mysqli->select_db($db['dbname']);

//     // 入力値のサニタイズ
//     // $name = $mysqli->real_escape_string($_POST["name"]);
//     $name =
//     $password =

//     // クエリの実行
//     $query = "SELECT * FROM LOGIN_USERS WHERE name =".  . $userid . "'";
//     $result = $mysqli->query($query);
//     if (!$result) {
//       print('クエリーが失敗しました。' . $mysqli->error);
//       $mysqli->close();
//       exit();
//     }

//     while ($row = $result->fetch_assoc()) {
//       // パスワード(暗号化済み）の取り出し
//       $db_hashed_pwd = $row['password'];
//     }

//     // データベースの切断
//     $mysqli->close();

//     // ３．画面から入力されたパスワードとデータベースから取得したパスワードのハッシュを比較します。
//     //if ($_POST["password"] == $pw) {
//     if (password_verify($_POST["password"], $db_hashed_pwd)) {
//       // ４．認証成功なら、セッションIDを新規に発行する
//       session_regenerate_id(true);
//       $_SESSION["USERID"] = $_POST["userid"];
//       header("Location: main.php");
//       exit;
//     }
//     else {
//       // 認証失敗
//       $errorMsg = "ユーザIDあるいはパスワードに誤りがあります。";
//     }
//   } else {
//     // 未入力なら何もしない
//   }
// }

?>
-->

<html>
<head>
	<meta charset="utf-8">
	<!-- TODO CSS読み込み -->
	<link rel="stylesheet" type="text/css" href="basic.css" />
	<title>サインアップ</title>
</head>
<body>
	<div id="wrapper" style="width: 1440px; height: 900px; background-color: #F0FFFF;">
		<div style="height: 30px;" id="pageHeader"></div>
		<div style="height: auto;">
			<!-- ロゴ＆説明 -->
			<div style="height: 240px;">
				<div style="float: left; width: 30%;">
					<!-- 戻るボタン -->
					<input type="button" name="btnBack" value="戻る" onclick="history.back()">
					<!-- TODO 何か画像を添付する -->
				</div>
				<div style="float: left; width: 70%;">
					<p><h2>とくとく掲示板β ver. 0.0.1</h2></p>
				</div>
			</div>
			<!-- ユーザ入力フォーム -->
			<form id="loginForm" name="loginForm" action="dispCategories.php" method="POST">
				<div style="height: 600px;">
					<table>
						<tr>
							<td style="width: 40%; text-align: right;">
								アカウント名：
							</td>
							<td style="width: 40%; text-align: left;">
								<input type="text" name="name" maxlength="32">
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
						<tr>
							<td style="width: 40%; text-align: right;">
								Photo：
							</td>
							<td style="width: 40%; text-align: left;">
								<input type="file" id="filupload_signUp">
							</td>
						</tr>
						<tr>
							<td style="width: 40%; text-align: right;">
								ヒント：
							</td>
							<td style="width: 40%; text-align: left;">
								<input type="text" name="name" maxlength="32">
							</td>
						</tr>
						<tr id="baseSpace1"></tr>
						<tr>
							<td>
								<input type="submit" id="signup" name="signup" value="登録">
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