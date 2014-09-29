-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: 2014 年 9 月 29 日 17:18
-- サーバのバージョン： 5.5.38
-- PHP Version: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `BulltinBoardSystem`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(11) NOT NULL COMMENT 'カテゴリID',
  `title` varchar(255) NOT NULL COMMENT 'カテゴリ名称',
  `cnt_comment` int(11) NOT NULL COMMENT 'コメント数',
  `creater` int(11) NOT NULL COMMENT '作成者',
  `created` datetime NOT NULL COMMENT '作成日時',
  `updater` int(11) NOT NULL COMMENT '更新者',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時',
  `del_flg` tinyint(1) NOT NULL COMMENT '削除フラグ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='カテゴリ管理';

-- --------------------------------------------------------

--
-- テーブルの構造 `login_users`
--

CREATE TABLE IF NOT EXISTS `login_users` (
`id` int(11) NOT NULL COMMENT 'ユーザID',
  `address` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `name` varchar(32) NOT NULL COMMENT 'アカウント名',
  `name_kana` varchar(32) NOT NULL COMMENT 'アカウント名（カナ）',
  `password_tmp` varchar(255) NOT NULL COMMENT '仮パスワード',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `password_new` varchar(255) NOT NULL COMMENT '新パスワード',
  `photo` varchar(255) DEFAULT NULL COMMENT '写真',
  `hint` varchar(32) DEFAULT NULL COMMENT 'ヒント',
  `admin_flg` tinyint(1) NOT NULL COMMENT '管理者フラグ',
  `first_login_flg` tinyint(1) NOT NULL COMMENT '初回ログインフラグ',
  `creater` int(11) NOT NULL COMMENT '作成者',
  `created` datetime NOT NULL COMMENT '作成日時',
  `updater` int(11) NOT NULL COMMENT '更新者',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時',
  `del_flg` tinyint(1) NOT NULL COMMENT '削除フラグ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ログインユーザ管理';

-- --------------------------------------------------------

--
-- テーブルの構造 `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
`id` int(11) NOT NULL COMMENT 'スレッドID',
  `content` varchar(255) NOT NULL COMMENT 'スレッド内容',
  `creater` int(11) NOT NULL COMMENT '作成者',
  `created` datetime NOT NULL COMMENT '作成日時',
  `updater` int(11) NOT NULL COMMENT '更新者',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
  `del_flg` tinyint(1) NOT NULL COMMENT '削除フラグ'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='スレッド管理';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_users`
--
ALTER TABLE `login_users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'カテゴリID';
--
-- AUTO_INCREMENT for table `login_users`
--
ALTER TABLE `login_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザID';
--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'スレッドID',AUTO_INCREMENT=5;