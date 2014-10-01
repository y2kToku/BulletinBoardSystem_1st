<!--*****************************************************************************************
画面名：スレッド表示画面
機能概要：掲示板の各カテゴリに紐づくスレッドを一覧表示する
	１.スレッドを作成し、一覧表示に追加する（ページリロードする）
	２.各スレッドを一覧表示する（通番、アカウント名、作成（更新）日時、アカウントに紐づく写真、スレッド内容）
	３.１ページあたりの表示件数は、１０件
	４.スレッドの削除は、管理者しかできない
*****************************************************************************************-->
<?php
	// セッション読み込み
	session_start();
?>

<html>
<head>
	<meta charset="utf-8">
	<!-- TODO CSS読み込み -->
	<link rel="stylesheet" type="text/css" href="basic.css" />
	<title>スレッド表示</title>
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
					<form id="makeThreadForm" name="makeThreadForm" action="makeThread.php" method="GET">
						名前：<input type="text" name="name" size="30" value="" /><br />
						コメント：<textarea name="content" cols="30" rows="5"></textarea><br />
						<div id="baseSpace1">
						<input type="submit" name="make" value="作成" />
					</form>
				</div>
			</div>
			<!-- スレッド選択フォーム -->
			<!-- <form id="dispThreadsForm" name="dispThreadsForm" action="" method="GET"> -->
				<div style="height: 600px;">
					<!-- 各スレッド一覧表示 -->
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
						print_r($_SESSION['categoryID']);
						// クエリ設定、実行
						// $sql = "SELECT * FROM threads WHERE category_id = '$_SESSION['categoryID']' AND del_flg = 0";
						// echo $sql;
						// $result = mysql_query($sql);
						// if (!$result) {
						// 	exit('データを取得できませんでした。');
						// }

						// // DBから画面に表示する値を取得し、配列に入れる
						// $dispArray[] = "";
						// $cntArray = 0;
						// while ($row = mysql_fetch_assoc($result)) {
						// 	$dispArray[$cntArray][] = $row;
						// 	$cntArray ++;
						// }
						// print_r($dispArray);

						// // サーバ切断
						// $close_flag = mysql_close($link);
						// if ($close_flag){
						// 	//print('<p>切断に成功しました。</p>');
						// }
					?>

					<!-- 上記で配列に格納した値を画面用に取り出す -->
					<?php for ($i=0; $i < count($dispArray); $i++) { ?>
						<table>
							<tr>
								<td>通番：<?php echo $dispArray[$i][0]['id']; ?>
									作成者名：<?php echo $dispArray[$i][0]['creater']; ?>
									作成日時：<?php echo $dispArray[$i][0]['created']; ?>
								</td>
								<td>
									<!-- 写真 -->
									内容：<?php echo $dispArray[$i][0]['content']; ?>
								</td>
								<td id="baseSpace1">
									<input type="button" name="btn_edit" value="修正" onclick="location.href='editThread.php'">
									<input type="button" name="dlt" value="削除" onclick="location.href='deleteThread.php'">
								</td>
							</tr>
						</table>
					<?php } ?>

					<!-- ページャー -->
					<div id="baseSpace1">
					</div>
				</div>
			<!-- </form> -->
		</div>
		<div id="pageFooter"></div>
	</div>
</body>
</html>