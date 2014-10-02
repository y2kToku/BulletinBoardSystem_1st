<!--*****************************************************************************************
画面名：カテゴリ表示画面
機能概要：掲示板のカテゴリを一覧表示する
	１.各カテゴリをソートする（更新日時（新旧）、コメント数）
	２.各カテゴリの一覧表示内容（カテゴリ名称、コメント数、更新日時）
	３.１ページあたりの表示件数は、１０件
	４.各カテゴリ名称のリンク押下後、カテゴリに紐づくスレッド表示画面に遷移する
*****************************************************************************************-->

<?php
	// ログイン画面から変数取得
	$userID = $_POST['userID'];
	$userName = $_POST['userName'];
?>


<html>
<head>
	<meta charset="utf-8">
	<!-- TODO CSS読み込み -->
	<link rel="stylesheet" type="text/css" href="basic.css" />
	<title>カテゴリ表示</title>
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
					<!--- ログアウトボタン -->
					<input type="button" name="btnLogout" value="ログアウト" onclick="location.href='logout.php'">
					<!-- TODO 何か画像を添付する -->
					<img style="height: 100px; width=: 100px;" src="sample.jpg">
				</div>
				<div style="float: left; width: 70%;">
					<p><h2>とくとく掲示板β ver. 0.0.1</h2></p>
					<!-- スレッド作成 -->
					<form id="makeCategoryForm" name="makeCategoryForm" action="makeCategory.php" method="GET">
						カテゴリ名：<textarea name="title" cols="30" rows="5"></textarea><br />
						<div id="baseSpace1">
						<input type="submit" name="make" value="作成" />
					</form>
				</div>
			</div>
			<!-- カテゴリ表示フォーム -->
			<!-- <form id="dispCategoriesForm" name="dispCategoriesForm" action="dispThreads.php" method="GET"> -->
				<div style="height: 600px;">
					<!-- ソート順選択 -->
					<div id="baseSpace1">
						<a href="dispCategories.html?sort=orderNew">新しい順</a>
						<a href="dispCategories.html?sort=orderOld">古い順</a>
						<a href="dispCategories.html?sort=orderCntComment">コメント数</a>
					</div>
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
						// クエリ設定、実行
						$sql = "SELECT * FROM categories WHERE del_flg = 0";
						$result = mysql_query($sql);
						if (!$result) {
							exit('データを取得できませんでした。');
						}

						// DBから画面に表示する値を取得し、配列に入れる
						$dispArray[] = "";
						$cntArray = 0;
						while ($row = mysql_fetch_assoc($result)) {
							$dispArray[$cntArray][] = $row;
							$cntArray ++;
						}

						// サーバ切断
						$close_flag = mysql_close($link);
						if ($close_flag){
							//print('<p>切断に成功しました。</p>');
						}
					?>

					<!-- 上記で配列に格納した値を画面用に取り出す -->
					<?php
						for ($i=0; $i < count($dispArray); $i++) {
							// コメント数の取得
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

							// 各カテゴリに紐づくスレッド数を取得
							$sql_cnt = "SELECT COUNT(*) AS cnt FROM threads WHERE category_id = ".$dispArray[$i][0]['id']." AND del_flg = 0";
							$result_cnt = mysql_query($sql_cnt);
							$row = mysql_fetch_assoc($result_cnt);
							$cnt = $row['cnt'];
					?>

						<!-- カテゴリ表示フォーム -->
						<form id="dispCategoriesForm" name="dispCategoriesForm" action="dispThreads.php" method="GET">
							<table>
								<tr>
									<td style="width: 400px;">
										●<?php echo $dispArray[$i][0]['title']; ?>
									</td>
									<td style="width: 150px;">
										スレッド数：<?php echo $cnt; ?>
									</td>
									<td style="width: 300px;">
										最新更新日時：<?php echo $dispArray[$i][0]['updated']; ?>
									</td>
									<td style="width: 100px;">
										<!-- カテゴリIDをGETパラメータで渡す -->
										<input type="hidden" name="userID" value="<?php echo $userID; ?>">
										<input type="hidden" name="userName" value="<?php echo $userName; ?>">
										<input type="hidden" name="categoryID" value="<?php echo $dispArray[$i][0]['id']; ?>">
										<input type="submit" value="スレッド表示画面へ">
									</td>
								</tr>
							</table>
						</form>
					<?php } ?>
					<!-- ページャー -->
					<div id="baseSpace1" />
				</div>
			<!-- </form> -->
		</div>
		<div id="pageFooter"></div>
	</div>
</body>
</html>