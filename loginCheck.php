<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<body>
		<?php
		try {
			// ログイン画面から変数を取得
			$name = $_POST['name'];
			$password = $_POST['password'];
			// エラーメッセージの初期化
			$errorMsg = "";

			// 変数の入力チェック
			if ($name == "") {
				print 'アカウント名が入力されていません。<br />'
			}
			if ($password == "") {
				print 'パスワードが入力されていません。<br />'
			}

			// DB接続
			$dsn = 'msql_dbname=BulletinBoardSystem;host=localhost';
			$user = 'root';
			$psw = 'root';
			$dbh = new PDO($dsn,$user,$psw);
			$dbh->query('SET NAMES utf8');

			// クエリの実行
			$sql = 'SELECT * from login_users where name = '.$name.' AND password = '.$password.';';
			$stmt = $dbh->prepare($sql);
			$stmt->execute();

			$dbh = null;
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($rec) {
				// ログイン処理成功時、
				header("location: http://localhost/BulletinBoardSystem_1st/dispCategories.php");
  				exit();
			}
		} catch (Exception $e) {
			header("location: http://localhost/BulletinBoardSystem_1st/login.php");
			print 'アカウント名とパスワードのいづれかが一致しません。もう一度、入力してください。';
			exit();
		}


		?>
	</body>
</head>
</html>