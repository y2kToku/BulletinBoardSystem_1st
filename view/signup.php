<!--*****************************************************************************************
画面名：サインアップ画面
機能概要：掲示板を利用するアカウントの新規登録をする
        １.アカウント名とパスワードのAND検索で重複チェック
        ２.写真登録する場合は、各画面用のサムネイル画像を生成し、DBに合わせて保存する
        ３.ヒントはフリーワード入力で、パスワードを忘れた場合の検索キーとしてアカウント名と共に使用する
        ４.登録ボタン押下後、カテゴリ選択画面に遷移する
*****************************************************************************************-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/basic.css" />
        <title>サインアップ</title>
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
                        <!-- TODO 何か画像を添付する -->
                    </div>
                    <div style="float: left; width: 70%;">
                        <h2>とくとく掲示板β ver. 0.0.1</h2>
                    </div>
                </div>
                <!-- ユーザ入力フォーム -->
                <form id="signupForm" name="signupForm" action="../controller/signupController.php" method="POST">
                    <div style="height: 600px;">
                        <table>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    アカウント名：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="text" name="name" maxlength="32">
                                </td>
                                <td style="width: 20%; text-align: left;">
                                    <p style="color: red;">＊</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    アカウント名（カナ）：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="text" name="nameKana" maxlength="32">
                                </td>
                                <td style="width: 20%; text-align: left;">
                                    <p style="color: red;">＊</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    アカウント（メールアドレス）：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="text" name="mailAddress" maxlength="32">
                                </td>
                                <td style="width: 20%; text-align: left;">
                                    <p style="color: red;">＊</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    パスワード：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="password" name="password">
                                </td>
                                <td style="width: 20%; text-align: left;">
                                    <p style="color: red;">＊</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    確認用パスワード：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="password" name="passwordConfirm">
                                </td>
                                <td style="width: 20%; text-align: left;">
                                    <p style="color: red;">＊</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    Photo：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="file" id="filupload_signUp">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    ヒント：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="text" name="hint" maxlength="32">
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%; text-align: right;">
                                    管理者権限：
                                </td>
                                <td style="width: 40%; text-align: left;">
                                    <input type="checkbox" name="admin_flg" value="">
                                </td>
                                <td style="width: 20%; text-align: left;">
                                    <p style="color: red;">＊</p>
                                </td>
                            </tr>
                            <tr id="baseSpace1"></tr>
                            <tr>
                                <td>
                                    <input type="submit" id="signup" name="signup" value="登録">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
            <div id="pageFooter"></div>
        </div>
    </body>
</html>