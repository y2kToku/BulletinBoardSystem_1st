<!--*****************************************************************************************
画面名：画面分岐
機能概要：画面全般の画面分岐を制御する
	１.
	２.
	３.
*****************************************************************************************-->

<?php
	// ログイン画面　→　カテゴリ表示画面
	if (isset($_POST['loginCheckBranch'])) {
		header('Location: dispCategories.php');
		// echo "###";
	}

	// スレッド表示画面　→　カテゴリ表示画面
?>

