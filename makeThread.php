<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>スレッド登録</title>
</head>
<body>
	<?php
		// サーバ接続
		$link = mysql_connect('localhost', 'root', 'root');
		if (!$link) {
		    die('接続失敗です。'.mysql_error());
		}
		// DB選択
		$db_selected = mysql_select_db('BulltinBoardSystem', $link);
		if (!$db_selected){
		    die('DB選択失敗です。'.mysql_error());
		}

		// MySQLに対する処理
		mysql_set_charset('utf8');
		// 画面から変数取得
		$name = $_GET['name'];
		$content = $_GET['content'];
		$userID = $_GET['userID'];
		$categoryID = $_GET['categoryID'];

		// クエリ設定、実行
		$sql = "INSERT INTO threads(category_id, content, creater, created, updater) VALUES($categoryID ,'$content', '$userID', now(), 'userID')";
		$result = mysql_query($sql);
		if (!$result) {
			exit('データを登録できませんでした。');
		}

		// サーバ切断
		$close_flag = mysql_close($link);
		if ($close_flag){
		    // print('<p>切断に成功しました。</p>');
		}
	?>
<p>登録が完了しました。<br /><a href="dispThreads.php?categoryID=<?php echo $categoryID; ?>">戻る</a></p>
</body>
</html>