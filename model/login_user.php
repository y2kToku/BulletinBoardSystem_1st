<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// DB接続クラス読み込み
require_once("DbPdo.php");

// エラーフラグ
$err_flg = false;

/**
 * Description of logins
 * ログイン処理（DB）
 * @author yusukeT
 */
class login_user {

    // アカウント情報の重複チェック
    public function ChkUniqAccount($mailAddress, $password) {
        // 変数の入力チェック
        if ($mailAddress == "") {
            echo "アカウントが入力されていません。<br />";
            $err_flg = true;
        }
        if ($password == "") {
            echo "パスワードが入力されていません。<br />";
            $err_flg = true;
        }
        // 重複チェック
        $sql = "SELECT * FROM login_users WHERE address = " . "'" . $mailAddress . "'" . " AND password = " . "'" . $password . "'" . " AND del_flg = 0;";
        $result_cnt = DbPdo::CountPdo($sql);
        $result = $result_cnt == 1 ? "OK" : "NG";
        return $result;
    }

    // ユーザID取得
    public function GetUserID($mailAddress, $password) {
        $sql = "SELECT * FROM login_users WHERE address = " . "'" . $mailAddress . "'" . " AND password = " . "'" . $password . "'" . " AND del_flg = 0;";
        $result = DbPdo::SelectPdo($sql);
        return $result[0]['id'];
    }

}
