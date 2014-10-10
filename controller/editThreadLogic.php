<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php
        // DB接続クラス読み込み
        require_once("../model/DbPdo.php");
        // スレッド編集画面から変数取得
        $content = filter_input(INPUT_GET, "content");
        $threadID = filter_input(INPUT_GET, "threadID");
        $categoryID = filter_input(INPUT_GET, "categoryID");

        // スレッド修正
        $sql = "UPDATE threads SET content = '" . $content . "' WHERE id = '" . $threadID . "' AND del_flg = 0";
        $result = DbPdo::InsUpdDelPdo($sql);
        if (!$result) {
            exit('データを更新できませんでした。');
        }
        ?>
        <!-- スレッド表示画面に遷移 -->
        <div>スレッドを修正できました。</div>
        <br />
        <div>
            <a href='../view/dispThreads.php?categoryID=<?php echo $categoryID; ?>'>スレッド表示画面へ</a>
        </div>
    </body>
</html>
