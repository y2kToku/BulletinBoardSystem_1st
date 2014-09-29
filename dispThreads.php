<!--*****************************************************************************************
画面名：スレッド表示画面
機能概要：掲示板の各カテゴリに紐づくスレッドを一覧表示する
	１.スレッドを作成し、一覧表示に追加する（ページリロードする）
	２.各スレッドを一覧表示する（通番、アカウント名、作成（更新）日時、アカウントに紐づく写真、スレッド内容）
	３.１ページあたりの表示件数は、１０件
	４.スレッドの削除は、管理者しかできない
*****************************************************************************************-->



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
					<!-- TODO 何か画像を添付する -->
				</div>
				<div style="float: left; width: 70%;">
					<p><h2>とくとく掲示板β ver. 0.0.1</h2></p>
				</div>
			</div>
			<!-- カテゴリ選択フォーム -->
			<form id="dispThreadsForm" name="dispThreadsForm" action="" method="GET">
				<div style="height: 600px;">
					<!-- スレッド作成 -->
					<table>
						<tr>
							<td>アカウント名：</td>
							<td></td>
						</tr>
						<tr>
							<!-- スレッド内容記入欄 -->
						</tr>
						<tr>
							<input type="button" name="createThread" value="作成">
						</tr>
					</table>
					<!-- 各スレッド一覧表示 -->
					<table>
						<tr>
							<td>
								<!-- 通番 -->
								<!-- アカウント名 -->
								<!-- 作成日時 -->
							</td>
							<td>
								<!-- 写真 -->
								<!-- スレッド内容表示欄 -->
							</td>
							<td id="baseSpace1">
								<input type="button" name="mod" value="修正">
								<input type="button" name="dlt" value="削除">
							</td>
						</tr>
					</table>
					<!-- ページャー -->
					<div id="baseSpace1">
					</div>
				</div>
			</form>
		</div>
		<div id="pageFooter"></div>
	</div>
</body>
</html>