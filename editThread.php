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
	<?php
	// スレッド表示画面から変数取得
	$categoryID = $_GET['categoryID'];
	$threadID = $_GET['threadID'];
	$creater = $_GET['creater'];
	$created = $_GET['created'];
	$content = $_GET['content'];
	?>

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
					<!-- スレッド編集 -->
					<table>
						<tr>
							<td> 通番：<?php echo $threadID; ?>
								 作成者名：<?php echo $creater; ?>
								 作成日時：<?php echo $created; ?>
							</td>
						</tr>
						<tr>
							<form id="editThreadForm" name="editThreadForm" action="editThreadLogic.php" method="GET">
								<td> コメント：
									<!-- 写真 -->
									<textarea name="content" cols="30" rows="5"><?php echo $content; ?></textarea>
									<input type="hidden" name="threadID" value="<?php echo $threadID; ?>">
									<input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>">
								</td>
								<td id="baseSpace1">
									<input type="submit" value="修正">
								</td>
							</form>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div id="pageFooter"></div>
	</div>
</body>
</html>