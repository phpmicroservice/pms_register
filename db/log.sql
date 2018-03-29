-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 192.168.1.9:3307
-- Generation Time: 2018-03-27 04:11:07
-- 服务器版本： 5.6.31
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dys_config`
--

-- --------------------------------------------------------

--
-- 表的结构 `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL COMMENT '自增',
  `content` text NOT NULL COMMENT '内容',
  `message` text NOT NULL COMMENT 'message',
  `type` enum('EMERGENCE','CRITICAL','ALERT','ERROR','WARNING','NOTICE','INFO','DEBUG','CUSTOM','SPECIAL') NOT NULL COMMENT 'type',
  `time` int(11) NOT NULL COMMENT '时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `log`
--

INSERT INTO `log` (`id`, `content`, `message`, `type`, `time`) VALUES
(1, 'a:0:{}', 'demo_log', 'NOTICE', 1522121959),
(2, 'a:2:{i:0;s:4:\"dadq\";i:1;s:3:\"sss\";}', 'demo_log', 'NOTICE', 1522122037);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
