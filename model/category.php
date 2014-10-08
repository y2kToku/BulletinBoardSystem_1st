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
 * Description of category
 * カテゴリ画面処理
 * @author yusukeT
 */
class category {

    // カテゴリ表示画面用データ取得
    public function getCategories() {
        // カテゴリ全件取得用
        $sql_all = "SELECT * FROM categories WHERE del_flg = 0";
        // カテゴリ画面表示用
        $sql = $sql_all;
        // ページャ条件を追加
        if (isset($dispLimit)) {
            $offset = $dispLimit * ($dispPage - 1);
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
        // カテゴリ登録件数が０件の場合
        if ($cntCategories == 0) {
            exit('現在、登録されているカテゴリはありません。');
        }
        if ($cntCategories < $dispLimit) {
            $dispLimit = $cntCategories;
        }
        for ($i = 0; $i < $dispLimit; $i++) {
            // 各カテゴリに紐づくスレッド数を取得
            $sql_cntThreads = "SELECT * FROM threads WHERE category_id = " . "'" . $dispCategoris[$i]['id'] . "'" . " AND del_flg = 0";
            $cntThreads = DbPdo::CountPdo($sql_cntThreads);
            // 各カテゴリに紐づくスレッドの最新更新日時を取得
            if ($cntThreads > 0) {
                // 各カテゴリにスレッドが紐づいている場合、紐づいているスレッド内で最新更新日を取得
                $sql_latest_updated = "SELECT updated FROM threads WHERE category_id = " . "'" . $dispCategoris[$i]['id'] . "'" . " AND del_flg = 0 ORDER BY updated DESC LIMIT 1";
                $result = DbPdo::SelectPdo($sql_latest_updated);
                $latestUpdated = $result[0]['updated'];
            } else {
                // 各カテゴリにスレッドが紐づいていない場合、カテゴリの更新日を取得
                $latestUpdated = $dispCategoris[$i]['updated'];
            }
        }
        return $dispCategoris;
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
        // 変数の入力チェック
        if ($title == "") {
            exit('カテゴリ名を入力してください。');
            // カテゴリ表示画面に遷移
            header('Location: ../view/dispCategories.php');
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
