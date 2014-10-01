<!--*****************************************************************************************
画面名：サインアップチェック
機能概要：掲示板を利用するアカウントのサインアップをする
	１.画面項目の入力チェック
	２.アカウント情報の重複チェック（メールアドレスとパスワードで弾く）
	３.アカウント情報のDB登録
	４.アカウント情報をセッション変数へ格納
	５.サインアップ終了後、カテゴリ選択画面に遷移させる
*****************************************************************************************-->

<?php
	// サインアップ画面から変数を取得
	$name = $_POST['name'];
	$name_kana = $_POST['nameKana'];
	$mailAddress = $_POST['mailAddress'];
	$password = $_POST['password'];
	$password_confirm = $_POST['passwordConfirm'];
	$hint = $_POST['hint'];
	$admin_flg = $_POST['admin_flg'];

	// エラーフラグ
	$err_flg = false;
	// レコード数
	$cnt = 0;

	// 変数の入力チェック
	if ($mailAddress == "") {
		echo "アカウントが入力されていません。<br />";
		$err_flg = true;
	}
	if ($password == "") {
		echo "パスワードが入力されていません。<br />";
		$err_flg = true;
	} elseif ($password != $password_confirm) {
		echo "確認用パスワードには同じパスワードを入力してください。";
		$err_flg = true;
	}

	if (!$err_flg) {
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
		// アカウント情報の重複チェック
		$sql_check = "SELECT COUNT(*) AS cnt FROM login_users WHERE address = '$mailAddress' AND password = '$password' AND del_flg = 0;";
		$result_check = mysql_query($sql_check);
		$row = mysql_fetch_assoc($result_check);
		$cnt = $row['cnt'];
		if ($cnt > 0) {
			exit('このアカウント情報は登録済みです。<br />別のアカウント（メールアドレス）を使用してください。');
		} else {
			// サインアップ処理
			$sql_signup = "INSERT INTO login_users(address, name, name_kana, password_tmp, password, password_new, hint, admin_flg, creater, created, updater)
					VALUES ('$mailAddress', '$name', '$name_kana', '$password', '$password', '$password', '$hint', '$admin_flg', 1, now(), 1);";
			$result_signup = mysql_query($sql_signup);
			if (!$result_signup) {
				exit('サインアップできません。<br />お手数ですが、もう一度サインアップを行ってください。<br />');
			} else {
				// サインアップ処理成功時、セッションにアカウント情報を格納し、カテゴリ表示画面に遷移する
				session_start();
				$_SESSION['login'] = "OK";
				$_SESSION['name'] = $name;
				$_SESSION['nameKana'] = $name_kana;
				$_SESSION['mailAddress'] = $mailAddress;
				$_SESSION['password'] = $password;
				$_SESSION['admin_flg'] = $admin_flg;

				// カテゴリ表示画面に遷移
				include('dispCategories.php');
			}
		}
	}
?>