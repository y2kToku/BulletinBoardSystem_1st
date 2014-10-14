<?php
session_start();

/*
 * 画面名：スレッド表示画面
 * 機能概要：
 * 選択したカテゴリIDに紐づくスレッド全件の一覧表示
 * スレッドの作成・修正・削除
 * ログアウト
 * ページャ
 * カテゴリ表示画面への遷移
 */

// 初回表示時、表示データ取得
if (filter_input(INPUT_POST, "action") == "firstDisp") {
    $dispDefData = $_SESSION['threadDispDefData'];
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
        <title>スレッド表示</title>
        <link rel="stylesheet" type="text/css" href="../css/basic.css" />
        <script type="text/javascript">
            function submitChk() {
                var ret = confirm("本当に削除してもよろしいですか？");
                return ret;
            }
        </script>
    </head>
    <body>
        <div id="wrapper" style="width: 1440px; height: 900px; background-color: #F0FFFF;">
            <div style="height: 30px;" id="pageHeader"></div>
            <div style="height: auto;">
                <!-- ロゴ＆説明 -->
                <div style="height: 240px;">
                    <div style="float: left; width: 30%;">
                        <!-- 戻るボタン -->
                        <input type="button" name="btnBack" value="カテゴリ表示画面へ戻る" onclick="location.href = '../controller/categoryController.php?action=firstDisp'">
                        <!--- ログアウトボタン -->
                        <input type="button" name="btnLogout" value="ログアウト" onclick="location.href = 'logout.php'">
                        <img style="height: 100px; width: 100px;" src="../sample.jpg" alt="">
                    </div>
                    <div style="float: left; width: 70%;">
                        <h2>とくとく掲示板β ver. 0.0.1</h2>
                        <!-- スレッド作成 -->
                        <form id="makeThreadForm" name="makeThreadForm" action="../controller/threadController.php" method="GET">
                            内容：<textarea name="content" cols="30" rows="5"></textarea><br />
                            <input type="hidden" name="action" value="makeThread">
                            <input type="submit" value="スレッド作成">
                        </form>
                    </div>
                    <!-- スレッド表示フォーム -->
                    <div style="height: 600px;">
                        <!-- 画面表示データ配列からmaxPageを除外する為、-1する -->
                        <?php for ($i = 0; $i < COUNT($dispDefData) - 1; $i++) { ?>
                            <table>
                                <tr id="dispThreadsDiv">
                                    <td>通番：<?php echo $dispDefData[$i]['id']; ?>
                                        作成者名：<?php echo $dispDefData[$i]['creater']; ?>
                                        更新日時：<?php echo $dispDefData[$i]['updated']; ?>
                                    </td>
                                    <td>
                                        内容：<?php echo $dispDefData[$i]['content']; ?>
                                    </td>
                                    <td>
                                        <form id="dispThreadsForm" name="dispThreadsForm" action="./editThread.php" method="GET">
                                            <input type="hidden" name="threadID" value="<?php echo $dispDefData[$i]['id']; ?>">
                                            <input type="hidden" name="creater" value="<?php echo $dispDefData[$i]['creater']; ?>">
                                            <input type="hidden" name="created" value="<?php echo $dispDefData[$i]['created']; ?>">
                                            <input type="hidden" name="content" value="<?php echo $dispDefData[$i]['content']; ?>">
                                            <input type="submit" value="修正">
                                        </form>
                                        <form id="dispThreadsForm" name="dispThreadsForm" action="../controller/threadController.php" method="GET" onsubmit="return submitChk()">
                                            <input type="hidden" name="threadID" value="<?php echo $dispDefData[$i]['id']; ?>">
                                            <input type="hidden" name="action" value="dltThread">
                                            <input type="submit" value="削除">
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        <?php } ?>
                        <!-- ページャ表示 -->
                        <div id="baseSpace1" style="text-align: center;">
                            <?php for ($i = 1; $i <= $dispDefData['maxPage']; $i++) { ?>
                                <a href="../controller/threadController.php?action=firstDispThreads&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="pageFooter"></div>
        </div>
    </body>
</html>