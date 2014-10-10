<!--*****************************************************************************************
画面名：スレッド表示画面
機能概要：掲示板の各カテゴリに紐づくスレッドを一覧表示する
        １.スレッドを作成し、一覧表示に追加する（ページリロードする）
        ２.各スレッドを一覧表示する（通番、アカウント名、作成（更新）日時、アカウントに紐づく写真、スレッド内容）
        ３.１ページあたりの表示件数は、１０件
        ４.スレッドの削除は、管理者しかできない
*****************************************************************************************-->
<?php
session_start();
// DB接続クラス読み込み
require_once("../model/DbPdo.php");
// カテゴリ表示画面から変数取得
$userID = filter_input(INPUT_GET, "userID");
$categoryID = filter_input(INPUT_GET, "categoryID");

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
        <link rel="stylesheet" type="text/css" href="../css/basic.css" />
        <title>スレッド表示</title>
    </head>
    <body>
        <div id="wrapper" style="width: 1440px; height: 900px; background-color: #F0FFFF;">
            <div style="height: 30px;" id="pageHeader"></div>
            <div style="height: auto;">
                <!-- ロゴ＆説明 -->
                <div style="height: 240px;">
                    <div style="float: left; width: 30%;">
                        <!-- カテゴリ選択画面へ -->
                        <a href="./dispCategories.php">カテゴリ表示画面へ</a>
                        <!-- 戻るボタン -->
                        <input type="button" name="btnBack" value="戻る" onclick="history.back()">
                        <!--- ログアウトボタン -->
                        <input type="button" name="btnLogout" value="ログアウト" onclick="location.href = 'logout.php'">
                        <!-- 画像 -->
                        <img style="height: 100px; width: 100px;" src="../sample.jpg" alt="">
                    </div>
                    <div style="float: left; width: 70%;">
                        <h2>とくとく掲示板β ver. 0.0.1</h2>
                        <!-- スレッド作成 -->
                        <form id="makeThreadForm" name="makeThreadForm" action="../controller/makeThread.php" method="GET">
                            コメント：<textarea name="content" cols="30" rows="5"></textarea><br />
                            <div id="baseSpace1">
                                <input type="hidden" name="userID" value="<?php echo $userID; ?>" />
                                <input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>" />
                                <input type="submit" name="make" value="作成" />
                            </div>
                        </form>
                    </div>

                    <div style="height: 600px;">
                        <!-- 各スレッド一覧表示 -->
                        <?php
                        // 選択したカテゴリに紐づくスレッドの件数取得
                        $sql_all = "SELECT * FROM threads WHERE category_id = '" . $categoryID . "' AND del_flg = 0";
                        $cntThreads = DbPdo::CountPdo($sql_all);
                        if ($cntThreads != 0) {
                            // 選択したカテゴリに紐づくスレッドが存在する場合
                            // スレッド画面表示用
                            $sql = $sql_all;
                            // ページャ条件を追加
                            if (isset($dispLimit)) {
                                $offset = $dispLimit * ($dispPage - 1);
                                $sql = $sql . " LIMIT " . $dispLimit . " OFFSET " . $offset;
                            }
                            $result = DbPdo::SelectPdo($sql);
                            if (!$result) {
                                exit('データを取得できませんでした。');
                            }
                            // 表示上限ページ数
                            $max_page = ceil($cntThreads / $dispLimit);
                            // 表示スレッド数
                            if ($cntThreads < $dispLimit) {
                                $dispLimit = $cntThreads;
                            }
                        }
                        ?>
                        <!-- 上記で配列に格納した値を画面用に取り出す -->

                        <?php for ($i = 0; $i < $dispLimit; $i++) { ?>
                            <table>
                                <tr id="dispThreadsDiv">
                                    <td>通番：<?php echo $result[$i]['id']; ?>
                                        作成者名：<?php echo $result[$i]['creater']; ?>
                                        更新日時：<?php echo $result[$i]['updated']; ?>
                                    </td>
                                    <td>
                                        内容：<?php echo $result[$i]['content']; ?>
                                    </td>
                                    <td>
                                        <form id="dispThreadsForm" name="dispThreadsForm" action="./editThread.php" method="GET">
                                            <input type="hidden" name="threadID" value="<?php echo $result[$i]['id']; ?>">
                                            <input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>">
                                            <input type="hidden" name="creater" value="<?php echo $result[$i]['creater']; ?>">
                                            <input type="hidden" name="created" value="<?php echo $result[$i]['created']; ?>">
                                            <input type="hidden" name="content" value="<?php echo $result[$i]['content']; ?>">
                                            <input type="submit" value="修正">
                                        </form>
                                        <form id="dispThreadsForm" name="dispThreadsForm" action="../controller/deleteThread.php" method="GET">
                                            <input type="hidden" name="threadID" value="<?php echo $result[$i]['id']; ?>">
                                            <input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>">
                                            <input type="submit" value="削除">
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        <?php } ?>

                        <!-- ページャー -->
                        <div id="baseSpace1" style="text-align: center;">
                            <?php for ($i = 1; $i <= $max_page; $i++) { ?>
                                <a href="?userID=<?php echo $userID; ?>&categoryID=<?php echo $categoryID; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div id="pageFooter"></div>
            </div>
    </body>
</html>