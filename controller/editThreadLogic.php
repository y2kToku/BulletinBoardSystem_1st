<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php
        // スレッド編集画面から変数取得
        $content = filter_input(INPUT_GET, "content");
        $threadID = filter_input(INPUT_GET, "threadID");
        $categoryID = filter_input(INPUT_GET, "categoryID");

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
        // クエリ設定、実行
        $sql = "UPDATE threads SET content = '$content' WHERE id = '$threadID' AND del_flg = 0";
        $result = mysql_query($sql);
        if (!$result) {
            exit('データを更新できませんでした。');
        }
        ?>
        <!-- スレッド表示画面に遷移 -->
        <div>スレッドを修正できました。</div>
        <br />
        <div>
            <a href='.//view/dispThreads.php?categoryID=<?php echo $categoryID; ?>'>スレッド表示画面へ</a>
        </div>
    </body>
</html>
