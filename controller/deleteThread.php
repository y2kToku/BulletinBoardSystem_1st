<!--*****************************************************************************************
画面名：スレッド削除機能
機能概要：掲示板の各カテゴリに紐づくスレッドを削除する。
        １.スレッド修正画面に遷移させる（権限制限：無し）
        ２.スレッド削除機能（権限制限：管理者のみ(admin_flg == true)）
        ３.スレッド削除実行後、スレッド表示画面に遷移させる
*****************************************************************************************-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php
        // スレッド表示画面から変数取得
        $threadID = filter_input(INPUT_GET, "threadID");
        $categoryID = filter_input(INPUT_GET, "categoryID");

        // 権限チェック
        // $sql_chkUser = "SELECT * FROM login_users WHERE id = ".$userID;
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
        // スレッド削除
        $sql = "UPDATE threads SET del_flg = 1 WHERE id = '$threadID' AND del_flg = 0";
        $result = mysql_query($sql);
        if (!$result) {
            exit('データを削除できませんでした。');
        }
        ?>

        <!-- スレッド表示画面に遷移 -->
        <div>スレッドを削除できました。</div>
        <br />
        <div>
            <a href='../view/dispThreads.php?categoryID=<?php echo $categoryID; ?>'>スレッド表示画面へ</a>
        </div>
    </body>
</html>