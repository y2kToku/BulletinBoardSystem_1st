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
		$userName = $_GET['userName'];
		$categoryID = $_GET['categoryID'];

		// スレッド新規作成
		$sql = "INSERT INTO threads(category_id, content, creater, created, updater) VALUES($categoryID ,'$content', '$userID', now(), '$userID')";
		$result = mysql_query($sql);
		if (!$result) {
			exit('データを登録できませんでした。');
		}

		// スレッド作成成功時、スレッドが紐づくカテゴリのスレッド数を取得
		$sql_chk_category = "SELECT cnt_comment FROM categories WHERE id = '$categoryID' AND del_flg = 0";
		$result_chk_category = mysql_query($sql_chk_category);
		if (!$result_chk_category) {
			exit('カテゴリ情報を取得できませんでした。');
		}
		$row = mysql_fetch_assoc($result_chk_category);
		$cnt_comment = $row['cnt_comment'];
		$cnt_comment ++;

		// スレッド作成成功時、スレッドが紐づくカテゴリを更新
		$sql_upd_category = "UPDATE categories SET cnt_comment = '$cnt_comment', updater = '$userID' WHERE id = '$categoryID'";
		$result_upd_category = mysql_query($sql_upd_category);
		if (!$result_upd_category) {
			exit('カテゴリを更新できませんでした。');
		}

		// サーバ切断
		$close_flag = mysql_close($link);
		if ($close_flag){
		    // print('<p>切断に成功しました。</p>');
		}
	?>
<p>登録が完了しました。<br /><a href="dispThreads.php?userID=<?php echo $userID; ?>&userName=<?php echo $userName; ?>&categoryID=<?php echo $categoryID; ?>">戻る</a></p>
</body>
</html>