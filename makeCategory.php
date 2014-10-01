<?php
	// 画面から変数取得
	$title = $_GET['title'];

	if ($title == "") {
		exit('カテゴリ名を入力してください。');
		// カテゴリ表示画面に遷移
		include('dispCategories.php');
	}

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

	// print('<p>接続に成功しました。</p>');

	// MySQLに対する処理
	mysql_set_charset('utf8');

	// クエリ設定、実行
	$sql = "INSERT INTO categories(title, creater, created, updater) VALUES('$title', 1, now(), 1)";
	$result = mysql_query($sql);
	if (!$result) {
		exit('データを登録できませんでした。');
	}

	// サーバ切断
	$close_flag = mysql_close($link);
	if ($close_flag){
	    // print('<p>切断に成功しました。</p>');
	}

	// カテゴリ表示画面に遷移する
	include('dispCategories.php');
?>