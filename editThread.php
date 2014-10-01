<!--*****************************************************************************************
画面名：スレッド編集画面
機能概要：スレッド表示画面にて選択したスレッドを編集する
	１.初期表示：スレッド表示画面の表示項目をセッションから取得し、そのまま表示する（通番、アカウント名、更新日時、写真、内容）
	２.以下項目のみ編集可能な状態にする（内容）
	３.修正ボタン押下後、threadsテーブルを更新し、修正完了メッセージを表示する
	４.戻るボタン押下後、スレッド表示画面に遷移させる
*****************************************************************************************-->

<html>
<head>
	<meta charset="utf-8">
	<!-- TODO CSS読み込み -->
	<link rel="stylesheet" type="text/css" href="basic.css" />
	<title>スレッド編集</title>
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
					<form id="editThreadForm" name="editThreadForm" action="" method="POST">
						<table>
							<tr>
								<td style="disabled: true;">通番：<?php echo ; ?>
									 作成者名：<?php echo ; ?>
									 作成日時：<?php echo ; ?>
								</td>
								<td>
									<!-- 写真 -->
									<textarea name="content"> 内容：<?php echo ; ?>/>
								</td>
								<td id="baseSpace1">
								<input type="submit" name="edit" value="修正">
								</td>
							</tr>
						</table>
					</form>
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
						$sql_updThread = "UPDATE THREADS SET content = '".$_GET['content']."'";
						$result_updThread = mysql_query($sql_updThread);
						if (!$result_updThread) {
							exit('データを更新できませんでした。');
						}
					?>
				</div>
			</div>
		</div>
		<div id="pageFooter"></div>
	</div>
</body>
</html>