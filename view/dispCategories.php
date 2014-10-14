<?php
session_start();

/*
 * 画面名：カテゴリ表示画面
 * 機能概要：
 * カテゴリ全件の一覧表示
 * カテゴリ作成
 * ログアウト
 * ソート
 * ページャ
 * 紐づくスレッド表示画面への遷移
 */
// 初回表示時、表示データ取得
if (filter_input(INPUT_POST, "action") == "firstDisp") {
    $dispDefData = $_SESSION['categoryDispDefData'];
}

// カテゴリ作成画面から変数取得
$dispStatus = filter_input(INPUT_POST, "madeCategory");
if (isset($dispStatus)) {
// カテゴリ作成画面からカテゴリ表示画面に遷移した場合のみ、画面をリロードする
    echo '<script type="text/javascript">window.location.reload();</script>';
}

$page = filter_input(INPUT_GET, "page");
if (!isset($page)) {
    $dispPage = 1;
}
$offset = "";
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>カテゴリ表示</title>
        <link rel="stylesheet" type="text/css" href="../css/basic.css" />
        <script type="text/javascript"></script>
    </head>
    <body>
        <div id="wrapper" style="width: 1440px; height: 900px; background-color: #F0FFFF;">
            <div style="height: 30px;" id="pageHeader"></div>
            <div style="height: auto;">
                <!-- ロゴ＆説明 -->
                <div style="height: 240px;">
                    <div style="float: left; width: 30%;">
                        <!--- ログアウトボタン -->
                        <input type="button" name="btnLogout" value="ログアウト" onclick="location.href = './logout.php'">
                        <img style="height: 100px; width: 100px;" src="../sample.jpg" alt="">
                    </div>
                    <div style="float: left; width: 70%;">
                        <h2>とくとく掲示板β ver. 0.0.1</h2>
                        <!-- カテゴリ作成 -->
                        <form id="makeCategoryForm" name="makeCategoryForm" action="../controller/categoryController.php" method="GET">
                            カテゴリ名：<textarea name="title" cols="30" rows="5"></textarea><br />
                            <input type="hidden" name="action" value="makeCategory">
                            <input type="submit" value="カテゴリ作成">
                        </form>
                    </div>
                    <!-- カテゴリ表示フォーム -->
                    <div style="height: 600px;">
                        <!-- ソート順選択 -->
                        <div id="baseSpace1">
                            <a href="../controller/categoryController.php?action=firstDisp&page=<?php echo $dispPage; ?>&sort=updated&order=DESC">新しい順</a>
                            <a href="../controller/categoryController.php?action=firstDisp&page=<?php echo $dispPage; ?>&sort=updated&order=ASC">古い順</a>
                            <a href="../controller/categoryController.php?action=firstDisp&page=<?php echo $dispPage; ?>&sort=cnt_comment&order=DESC">コメント数</a>
                        </div>
                        <!-- カテゴリ表示フォーム -->
                        <!-- 画面表示データ配列からmaxPageを除外する為、-1する -->
                        <?php for ($i = 0; $i < COUNT($dispDefData) - 1; $i++) { ?>
                            <form id="dispCategoriesForm" name="dispCategoriesForm" action="../controller/threadController.php" method="GET">
                                <table>
                                    <tr>
                                        <td style="width: 400px;">
                                            ●<?php echo $dispDefData[$i]['title']; ?>
                                        </td>
                                        <td style="width: 150px;">
                                            スレッド数：<?php echo $dispDefData[$i]['cnt_comment']; ?>
                                        </td>
                                        <td style="width: 300px;">
                                            最新更新日時：<?php echo $dispDefData[$i]['updated']; ?>
                                        </td>
                                        <td style="width: 100px;">
                                            <!-- カテゴリIDをGETパラメータで渡す -->
                                            <input type="hidden" name="categoryID" value="<?php echo $dispDefData[$i]['id']; ?>">
                                            <input type="hidden" name="action" value="firstDispThreads">
                                            <input type="submit" value="スレッド表示画面へ">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        <?php } ?>
                        <!-- ページャ表示 -->
                        <div id="baseSpace1" style="text-align: center;">
                            <?php for ($i = 1; $i <= $dispDefData['maxPage']; $i++) { ?>
                                <a href="../controller/categoryController.php?action=firstDisp&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="pageFooter"></div>
        </div>
    </body>
</html>