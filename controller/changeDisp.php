<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChangeDisp
 * 画面切替用クラス
 * @author yusukeT
 */
$afterDisp = filter_input(INPUT_GET, "action");

class changeDisp {

    public function moveDisp($afterDisp) {
        switch ($afterDisp) {
            // カテゴリ表示画面に遷移
            case dispCategories:
                $url = "http://localhost/BulletinBoardSystem_1st/view/dispCategories.php";
                header("Location: " . $url);

                break;

            default:
                break;
        }
    }

}
