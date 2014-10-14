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
 * Description of thread
 * スレッド画面処理
 * @author yusukeT
 */
class thread {

    // スレッド表示画面_初回表示時
    public function getThreads($categoryID, $dispLimit, $dispPage) {
        // スレッド全件取得用
        $sql_all = "SELECT * FROM threads WHERE category_id = " . $categoryID . " AND del_flg = 0 ORDER BY id ASC";
        // スレッド画面表示用
        $sql = $sql_all;
        // ページャ条件を追加
        if (isset($dispLimit)) {
            if (!isset($dispPage)) {
                $dispPage = 1;
            }
            // 初回表示時、1ページ目を表示する為、OFFSETは0にする
            $offset = $dispLimit * ($dispPage - 1);
            $sql = $sql . " LIMIT " . $dispLimit . " OFFSET " . $offset;
        }
        // スレッド全件のレコード数
        $cntThreads = DbPdo::CountPdo($sql_all);
        // 表示カテゴリデータ
        $dispThreads = DbPdo::SelectPdo($sql);
        // 表示上限ページ数
        if ($cntThreads == 0) {
            // 初回表示時
            $max_page = 1;
        } else {
            $max_page = ceil($cntThreads / $dispLimit);
        }
        // スレッド全件数 < 画面表示件数　の場合
        if ($cntThreads < $dispLimit) {
            $dispLimit = $cntThreads;
        }
        return $dispThreads += array('maxPage' => $max_page);
    }

    // スレッド表示画面用最大ページ取得
    public function getMaxPage($dispLimit, $dispPage) {
        $sql = "SELECT * FROM threads WHERE del_flg = 0";
        if (isset($dispLimit)) {
            $offset = $dispLimit * ($dispPage - 1);
            $sql = $sql . " LIMIT " . $dispLimit . " OFFSET " . $offset;
        }
    }

    // スレッド重複チェック
    public function ChkUniqThread($content) {
        // エラーフラグ
        $err_flg = "false";
        // 変数の入力チェック
        if ($content == "") {
            echo "内容が入力されていません。<br />";
            $err_flg = "true";
        }
        $sql = "SELECT * FROM threads WHERE content = " . "'" . $content . "'" . " AND del_flg = 0;";
        $result_cnt = DbPdo::CountPdo($sql);
        $result = $result_cnt == 0 ? "OK" : "NG";
        return $result;
    }

    // スレッド登録
    public function InsThread($categoryID, $content, $userID) {
        // スレッドテーブルにレコード追加
        $sql = "INSERT INTO threads(category_id,content, creater, created, updater) VALUES(" . $categoryID . ", '" . $content . "', '" . $userID . "', now(), '" . $userID . "')";
        $result = DbPdo::InsUpdDelPdo($sql);
        return $result;
    }

    // スレッド登録後、カテゴリテーブル更新
    public function UpdCategoryAfterIns($categoryID, $userID) {
        $sql_getCnt = "SELECT * FROM categories WHERE id = " . $categoryID . " AND del_flg = 0";
        $result_getCnt = DbPdo::SelectPdo($sql_getCnt);
        $cntThreads = $result_getCnt[0]['cnt_comment'] += 1;
        $sql = "UPDATE categories SET cnt_comment = " . $cntThreads . ", updater = " . $userID . ", updated = now() WHERE id = " . $categoryID;
        $result = DbPdo::InsUpdDelPdo($sql);
        return $result;
    }

    // スレッド編集
    public function EditThread($threadID, $content, $userID) {
        $sql = "UPDATE threads SET content = '" . $content . "', updater = " . $userID . " WHERE id = " . $threadID;
        $result = DbPdo::InsUpdDelPdo($sql);
        return $result;
    }

    //スレッド編集後、カテゴリテーブル更新
    public function UpdCategoryAfterEdit($categoryID, $userID) {
        $sql = "UPDATE categories SET updater = " . $userID . ", updated = now() WHERE id = " . $categoryID . " AND del_flg = 0";
        $result = DbPdo::InsUpdDelPdo($sql);
        return $result;
    }

    // スレッド削除
    public function DeleteThread($threadID, $userID) {
        $sql = "UPDATE threads SET del_flg = 1, updater = " . $userID . " WHERE id = " . $threadID;
        $result = DbPdo::InsUpdDelPdo($sql);
        return $result;
    }

    // スレッド削除後、カテゴリテーブル更新
    public function UpdCategoryAfterDel($categoryID, $userID) {
        $sql_getCnt = "SELECT * FROM categories WHERE id = " . $categoryID . " AND del_flg = 0";
        $result_getCnt = DbPdo::SelectPdo($sql_getCnt);
        $cntThreads = $result_getCnt[0]['cnt_comment'] -= 1;
        $sql = "UPDATE categories SET cnt_comment = " . $cntThreads . ", updater = " . $userID . ", updated = now() WHERE id = " . $categoryID;
        $result = DbPdo::InsUpdDelPdo($sql);
        return $result;
    }

}
