<?php

session_start();

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
 * Description of category
 * カテゴリ画面処理
 * @author yusukeT
 */
class category {

    // カテゴリ表示画面_初回表示時
    public function getDefCategories($dispLimit) {
        // 表示用_スレッド更新日時を含まない
        $dispData = array();
        // カテゴリ全件取得用
        $sql_all = "SELECT * FROM categories WHERE del_flg = 0";
        // カテゴリ画面表示用
        $sql = $sql_all;
        // ページャ条件を追加
        if (isset($dispLimit)) {
            // 初回表示時、1ページ目を表示する為、OFFSETは0にする
            $offset = 0;
//            $offset = $dispLimit * ($dispPage - 1);
            $sql = $sql . " LIMIT " . $dispLimit . " OFFSET " . $offset;
        }
        // カテゴリ全件のレコード数
        $cntCategories = DbPdo::CountPdo($sql_all);
        // 表示カテゴリデータ
        $dispCategoris = DbPdo::SelectPdo($sql);
        if ($cntCategories == 0 || !isset($dispCategoris)) {
            exit('データを取得できませんでした。');
        }
        // 表示上限ページ数
        $max_page = ceil($cntCategories / $dispLimit);
        // カテゴリ全件数 < 画面表示件数　の場合
        if ($cntCategories < $dispLimit) {
            $dispLimit = $cntCategories;
        }
        return $dispCategoris += array('maxPage' => $max_page);
    }

    // カテゴリ表示画面用最大ページ取得
    public function getMaxPage($dispLimit, $dispPage) {
        $sql = "SELECT * FROM categories WHERE del_flg = 0";
        if (isset($dispLimit)) {
            $offset = $dispLimit * ($dispPage - 1);
            $sql = $sql . " LIMIT " . $dispLimit . " OFFSET " . $offset;
        }
    }

    // カテゴリ重複チェック
    public function ChkUniqCategory($title) {
        // エラーフラグ
        $err_flg = "false";
        // 変数の入力チェック
        if ($title == "") {
            echo "カテゴリ名が入力されていません。<br />";
            $err_flg = "true";
        }
        $sql = "SELECT * FROM categories WHERE title = " . "'" . $title . "'" . " AND del_flg = 0;";
        $result_cnt = DbPdo::CountPdo($sql);
        $result = $result_cnt == 0 ? "OK" : "NG";
        return $result;
    }

    //カテゴリ登録
    public function InsCategory($title, $userID) {
        $sql = "INSERT INTO categories(title, creater, created, updater) VALUES(" . "'" . $title . "'" . ", " . "'" . $userID . "'" . ", now(), " . "'" . $userID . "'" . ")";
        $result = DbPdo::InsUpdDelPdo($sql);
        return $result;
    }

}
