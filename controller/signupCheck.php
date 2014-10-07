<!--*****************************************************************************************
画面名：サインアップチェック
機能概要：掲示板を利用するアカウントのサインアップをする
        １.画面項目の入力チェック
        ２.アカウント情報の重複チェック（メールアドレスとパスワードで弾く）
        ３.アカウント情報のDB登録
        ４.アカウント情報をセッション変数へ格納
        ５.サインアップ終了後、カテゴリ選択画面に遷移させる
*****************************************************************************************-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php
        // サインアップ画面から変数を取得
        $name = filter_input(INPUT_POST, "name");
        $name_kana = filter_input(INPUT_POST, "nameKana");
        $mailAddress = filter_input(INPUT_POST, "mailAddress");
        $password = filter_input(INPUT_POST, "password");
        $password_confirm = filter_input(INPUT_POST, "passwordConfirm");
        $hint = filter_input(INPUT_POST, "hint");
        $admin_flg = filter_input(INPUT_POST, "admin_flg");
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
                die('接続失敗です。' . mysql_error());
            }
            // DB選択
            $db_selected = mysql_select_db('BulltinBoardSystem', $link);
            if (!$db_selected) {
                die('DB選択失敗です。' . mysql_error());
            }

            // MySQLに対する処理
            mysql_set_charset('utf8');
            // アカウント情報の重複チェック
            $sql_check = "SELECT COUNT(*) AS cnt FROM login_users WHERE address = '$mailAddress' AND password = '$password' AND del_flg = 0;";
            $result_check = mysql_query($sql_check);
            $row = mysql_fetch_assoc($result_check);
            $cnt = $row['cnt'];
            if ($cnt > 0) {
                echo 'このアカウント情報は登録済みです。<br />別のアカウント（メールアドレス）を使用してください。';
                return;
            } else {
                // サインアップ処理
                $sql_signup = "INSERT INTO login_users(address, name, name_kana, password_tmp, password, password_new, hint, admin_flg, creater, created, updater)
					VALUES ('$mailAddress', '$name', '$name_kana', '$password', '$password', '$password', '$hint', '$admin_flg', 1, now(), 1);";
                $result_signup = mysql_query($sql_signup);
                if (!$result_signup) {
                    echo 'サインアップできません。<br />お手数ですが、もう一度サインアップを行ってください。';
                    return;
                } else {
                    ?>
                    <form name="signupCheckForm" action="../view/dispCategories.php" method="POST">
                        <input type="hidden" name="name" value="$name">
                        <input type="hidden" name="nameKana" value="$nameKana">
                        <input type="hidden" name="mailAddress" value="$mailAddress">
                        <input type="hidden" name="password" value="$password">
                        <input type="hidden" name="admin_flg" value="$admin_flg">
                        <input type="submit" name="field1" value="カテゴリ表示画面へ">
                    </form>
                    <?php
                }
            }
        }
        ?>
    </body>
</html>