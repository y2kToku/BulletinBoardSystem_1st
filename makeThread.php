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

	print('<p>接続に成功しました。</p>');

	// MySQLに対する処理
	mysql_set_charset('utf8');
	// 画面から変数取得
	$name = $_POST['name'];
	$content = $_POST['content'];

	// クエリ設定、実行
	$sql = "INSERT INTO threads(content, creater, created, updater, del_flg) VALUES('$content', 1, now(), 1, 0)";
	$result = mysql_query($sql);
	if (!$result) {
		exit('データを登録できませんでした。');
	}

	// サーバ切断
	$close_flag = mysql_close($link);
	if ($close_flag){
	    print('<p>切断に成功しました。</p>');
	}
?>
<p>登録が完了しました。<br /><a href="dispThreads.php">戻る</a></p>
</body>
</html>