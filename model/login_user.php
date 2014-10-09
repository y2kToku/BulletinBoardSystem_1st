<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// DB接続クラス読み込み
require_once("DbPdo.php");

/**
 * Description of logins
 * ログイン処理（DB）
 * @author yusukeT
 */
class login_user {

    // アカウント情報の重複チェック_ログイン
    public function ChkUniqAccount($mailAddress, $password) {
        // エラーフラグ
        $err_flg = "false";
        // 変数の入力チェック
        if ($mailAddress == "") {
            echo "アカウントが入力されていません。<br />";
            $err_flg = "true";
        }
        if ($password == "") {
            echo "パスワードが入力されていません。<br />";
            $err_flg = "true";
        }
        if ($err_flg == "false") {
            // 重複チェック
            $sql = "SELECT * FROM login_users WHERE address = " . "'" . $mailAddress . "'" . " AND password = " . "'" . $password . "'" . " AND del_flg = 0;";
            $result_cnt = DbPdo::CountPdo($sql);
            $result = $result_cnt == 1 ? "OK" : "NG";
            return $result;
        }
    }

    // ユーザID取得
    public function GetUserID($mailAddress, $password) {
        $sql = "SELECT * FROM login_users WHERE address = " . "'" . $mailAddress . "'" . " AND password = " . "'" . $password . "'" . " AND del_flg = 0;";
        $result = DbPdo::SelectPdo($sql);
        return $result[0]['id'];
    }

    // アカウント情報の重複チェック_サインアップ
    public function ChkUniqAccountS($mailAddress, $password, $password_confirm) {
        // エラーフラグ
        $err_flg = "false";
        // 変数の入力チェック
        if ($mailAddress == "") {
            echo "アカウントが入力されていません。<br />";
            $err_flg = "true";
        }
        if ($password == "") {
            echo "パスワードが入力されていません。<br />";
            $err_flg = "true";
        } elseif ($password != $password_confirm) {
            echo "確認用パスワードには同じパスワードを入力してください。";
            $err_flg = "true";
        }
        if ($err_flg == "false") {
            // 重複チェック
            $sql = "SELECT * FROM login_users WHERE address = " . "'" . $mailAddress . "'" . " AND password = " . "'" . $password . "'" . " AND del_flg = 0;";
            $result_cnt = DbPdo::CountPdo($sql);
            $result = $result_cnt == 0 ? "OK" : "NG";
            return $result;
        }
    }

    // サインアップ処理
    public function InsUser($mailAddress, $name, $name_kana, $password, $hint, $admin_flg) {
        $sql = "INSERT INTO login_users(address, name, name_kana, password_tmp, password, password_new, hint, admin_flg, creater, created, updater) VALUES ('" . $mailAddress . "', '" . $name . "', '" . $name_kana . "', '" . $password . "', '" . $password . "', '" . $password . "', '" . $hint . "', '" . $admin_flg . "', 1, now(), 1)";
        echo 'SQL:' . $sql;
        $result = DbPdo::InsUpdDelPdo($sql);
        echo 'result:' . $result;
        return $result;
    }

}
