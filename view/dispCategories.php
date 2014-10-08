<!--*****************************************************************************************
画面名：カテゴリ表示画面
機能概要：掲示板のカテゴリを一覧表示する
        １.各カテゴリをソートする（更新日時（新旧）、コメント数）
        ２.各カテゴリの一覧表示内容（カテゴリ名称、コメント数、更新日時）
        ３.１ページあたりの表示件数は、１０件
        ４.各カテゴリ名称のリンク押下後、カテゴリに紐づくスレッド表示画面に遷移する
*****************************************************************************************-->

<?php
// TODO 修正反映の為、自画面をリロードする 効いてない・・・
// header("Location: " . $_SERVER['PHP_SELF']);
require_once("../model/DbPdo.php");
// ログイン画面から変数取得
$userID = filter_input(INPUT_POST, "userID");
$userName = filter_input(INPUT_POST, "userName");
// ページャ設定用変数
$dispLimit = 10;
$page = filter_input(INPUT_GET, "page");
if (isset($page)) {
    $dispPage = $page;
} else {
    $dispPage = 1;
}
$offset = "";
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>カテゴリ表示</title>
        <link rel="stylesheet" type="text/css" href="../css/basic.css" />
    </head>
    <body>
        <div id="wrapper" style="width: 1440px; height: 900px; background-color: #F0FFFF;">
            <div style="height: 30px;" id="pageHeader"></div>
            <div style="height: auto;">
                <!-- ロゴ＆説明 -->
                <div style="height: 240px;">
                    <div style="float: left; width: 30%;">
                        <!-- 戻るボタン -->
                        <input type="button" name="btnBack" value="戻る" onclick="history.back()">
                        <!--- ログアウトボタン -->
                        <input type="button" name="btnLogout" value="ログアウト" onclick="location.href = 'logout.php'">
                        <img style="height: 100px; width: 100px;" src="../sample.jpg" alt="">
                    </div>
                    <div style="float: left; width: 70%;">
                        <h2>とくとく掲示板β ver. 0.0.1</h2>
                        <!-- スレッド作成 -->
                        <form id="makeCategoryForm" name="makeCategoryForm" action="../controller/makeCategory.php" method="GET">
                            カテゴリ名：<textarea name="title" cols="30" rows="5"></textarea><br />
                            <input type="hidden" name="userID" value="$userID">
                            <input type="submit" name="make" value="作成">
                        </form>
                    </div>
                    <!-- カテゴリ表示フォーム -->
                    <div style="height: 600px;">
                        <!-- ソート順選択 -->
                        <div id="baseSpace1">
                            <form id="sortCategoriesForm" name="sortCategoriesForm" action="" method="GET">
                                <a href="?page=<?php echo $dispPage; ?>&sort=updated&order=DESC">新しい順</a>
                                <a href="?page=<?php echo $dispPage; ?>&sort=updated&order=ASC">古い順</a>
                                <a href="?page=<?php echo $dispPage; ?>&sort=cnt_comment&order=DESC">コメント数</a>
                            </form>
                        </div>
                        <?php
                        // カテゴリ全件取得用
                        $sql_all = "SELECT * FROM categories WHERE del_flg = 0";
                        // カテゴリ画面表示用
                        $sql = $sql_all;
                        // ソート条件を追加
                        $sort = filter_input(INPUT_GET, "sort");
                        $order = filter_input(INPUT_GET, "order");
                        if (isset($sort) && isset($order)) {
                            $sql = $sql . " ORDER BY " . $sort . " " . $order;
                        }
                        // ページャ条件を追加
                        if (isset($dispLimit)) {
                            $offset = $dispLimit * ($dispPage - 1);
                            $sql = $sql . " LIMIT " . $dispLimit . " OFFSET " . $offset;
                        }
                        // カテゴリ全件のレコード数
                        $cntCategories = DbPdo::CountPdo($sql_all);
                        // 表示カテゴリデータ
                        $dispCategoris = DbPdo::SelectPdo($sql);
                        // 
                        if ($cntCategories == 0 || !isset($dispCategoris)) {
                            exit('データを取得できませんでした。');
                        }
                        // 表示上限ページ数
                        $max_page = ceil($cntCategories / $dispLimit);
                        ?>

                        <!-- 上記で配列に格納した値を画面用に取り出す -->
                        <?php
                        // ページャ
                        // カテゴリ登録件数が０件の場合
                        if (count($allArray) == 0) {
                            echo '現在、登録されているカテゴリはありません。';
                            return;
                        }
                        if (count($dispArray) < $dispLimit) {
                            $dispLimit = count($dispArray);
                        }
                        for ($i = 0; $i < $dispLimit; $i++) {
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

                            // 各カテゴリに紐づくスレッドの最新更新日時を取得
                            if ($dispArray[$i][0]['cnt_comment'] > 0) {
                                $sql_latest_updated = "SELECT updated AS latestUpdated FROM threads WHERE category_id = " . $dispArray[$i][0]['id'] . " AND del_flg = 0 ORDER BY updated DESC LIMIT 1";
                                $result_latest_updated = mysql_query($sql_latest_updated);
                                if (!$result_latest_updated) {
                                    echo 'データを取得できませんでした。';
                                    return;
                                }
                                $row = mysql_fetch_assoc($result_latest_updated);
                                $latestUpdated = $row['latestUpdated'];
                            } else {
                                $latestUpdated = $dispArray[$i][0]['updated'];
                            }
                            ?>
                            <!-- カテゴリ表示フォーム -->
                            <form id="dispCategoriesForm" name="dispCategoriesForm" action="./dispThreads.php" method="GET">
                                <table>
                                    <tr>
                                        <td style="width: 400px;">
                                            ●<?php echo $dispArray[$i][0]['title']; ?>
                                        </td>
                                        <td style="width: 150px;">
                                            スレッド数：<?php echo $dispArray[$i][0]['cnt_comment']; ?>
                                        </td>
                                        <td style="width: 300px;">
                                            最新更新日時：<?php echo $latestUpdated; ?>
                                        </td>
                                        <td style="width: 100px;">
                                            <!-- カテゴリIDをGETパラメータで渡す -->
                                            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                                            <input type="hidden" name="userName" value="<?php echo $userName; ?>">
                                            <input type="hidden" name="categoryID" value="<?php echo $dispArray[$i][0]['id']; ?>">
                                            <input type="submit" value="スレッド表示画面へ">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        <?php } ?>
                        <!-- ページャ表示 -->
                        <div id="baseSpace1" style="text-align: center;">
                            <?php for ($i = 1; $i <= $max_page; $i++) { ?>
                                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="pageFooter"></div>
        </div>
    </body>
</html>