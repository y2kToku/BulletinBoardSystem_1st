<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>スレッド登録</title>
    </head>
    <body>
        <?php
        // DB接続クラス読み込み
        require_once("../model/DbPdo.php");
        // 画面から変数取得
        $content = filter_input(INPUT_GET, "content");
        $userID = filter_input(INPUT_GET, "userID");
        $categoryID = filter_input(INPUT_GET, "categoryID");

        // スレッド新規作成
        $sql = "INSERT INTO threads(category_id, content, creater, created, updater) VALUES("."'".$categoryID."' , '".$content."' , '".$userID."' , now(), '".$userID."')";
        $result = DbPdo::InsUpdDelPdo($sql);
        if (!$result) {
            exit('データを登録できませんでした。');
        }

        // スレッド作成成功時、スレッドが紐づくカテゴリのスレッド数を取得
        $sql_chk_category = "SELECT * FROM categories WHERE id = '".$categoryID."' AND del_flg = 0";
        $result_chk_category = DbPdo::SelectPdo($sql_chk_category);
        if (!$result_chk_category) {
            exit('カテゴリ情報を取得できませんでした。');
        }
        $cnt_comment = $result_chk_category['cnt_comment'];
        $cnt_comment ++;

        // スレッド作成成功時、スレッドが紐づくカテゴリを更新
        $sql_upd_category = "UPDATE categories SET cnt_comment = '".$cnt_comment."', updater = '".$userID."' WHERE id = '".$categoryID."'";
        $result_upd_category = DbPdo::InsUpdDelPdo($sql_upd_category);
        if (!$result_upd_category) {
            exit('カテゴリを更新できませんでした。');
        }
        ?>
        <p>登録が完了しました。<br /><a href="../view/dispThreads.php?userID=<?php echo $userID; ?>&categoryID=<?php echo $categoryID; ?>">戻る</a></p>
    </body>
</html>