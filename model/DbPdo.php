<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DbPdo
 * DB接続クラス
 * @author yusukeT
 */
Class DbPdo extends PDO {

// DB接続情報
    const DB_URL = "mysql:dbname=BulltinBoardSystem;host=localhost";
    const USER = "root";
    const PW = "root";

    // インスタンス
    protected static $db;
    // データセット
    protected static $dsn;

    public function __construct() {
        parent::__construct(self::DB_URL, self::USER, self::PW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
        );
    }

    /**
     * DB接続
     */
    public static function connect() {
        // DBに未接続であればDBに接続する
        if (!self::$db) {
            self::$db = new self();
            // DB関連の処理失敗時は例外を投げるように設定
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$db;
    }

    // SELECT用
    public function SelectPdo($sql) {
        try {
            // DB接続
            $pdo = self::connect();
            // クエリ読込
            $stmt = $pdo->prepare($sql);
            // クエリ実行
            $stmt->execute();
            // 結果取得用配列
            $result = array();
            // 実行結果取得
            foreach ($stmt as $row) {
                $result[] = $row;
            }
            return $result;
        } catch (PDOException $e) {
            // データベース接続失敗
            exit('データベース接続失敗。' . $e->getMessage());
        }
    }

    // カウント取得用
    // SELECT用
    public function CountPdo($sql) {
        try {
            // DB接続
            $pdo = self::connect();
            // クエリ読込
            $stmt = $pdo->prepare($sql);
            // クエリ実行
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // データベース接続失敗
            exit('データベース接続失敗。' . $e->getMessage());
        }
    }

    // INSERT,UPDATE,DELETE用
    public function InsUpdDelPdo($sql) {
        try {
            // DB接続
            $pdo = self::connect();
            // クエリ読込
            $stmt = $pdo->prepare($sql);
            // クエリ実行
            return $stmt->execute();
        } catch (PDOException $e) {
            // データベース接続失敗
            exit('データベース接続失敗。' . $e->getMessage());
        }
    }

}
