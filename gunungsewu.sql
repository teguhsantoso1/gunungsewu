-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table gunungsewu.app
CREATE TABLE IF NOT EXISTS `app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `empid` varchar(20) NOT NULL,
  `empname` varchar(100) NOT NULL,
  `quesioner` varchar(200) NOT NULL,
  `bidang_1` int(11) NOT NULL,
  `bidang_1_ket` text NOT NULL,
  `bidang_2` int(11) NOT NULL,
  `bidang_2_ket` text NOT NULL,
  `audit` enum('Y','') NOT NULL,
  `salah` enum('Y','') NOT NULL DEFAULT '',
  `user_create` int(11) NOT NULL,
  `date_create` datetime NOT NULL,
  `user_update` int(11) NOT NULL,
  `date_update` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table gunungsewu.app: ~2 rows (approximately)
/*!40000 ALTER TABLE `app` DISABLE KEYS */;
INSERT INTO `app` (`id`, `code`, `empid`, `empname`, `quesioner`, `bidang_1`, `bidang_1_ket`, `bidang_2`, `bidang_2_ket`, `audit`, `salah`, `user_create`, `date_create`, `user_update`, `date_update`) VALUES
	(1, 1, '', '', '1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,', 1, 'Apa yang paling Anda sukai dalam bekerja di perusahaan ini? Pilihlah bidang yang paling sesuai dan uraikan pendapat atau pandangan Anda', 2, 'dakah hal-hal yang menurut anda perlu ditingkatkan di perusahaan ini? Pilihlah bidang yang sesuai dan uraikan pendapat anda', '', '', 1, '2016-11-22 20:33:16', 0, '0000-00-00 00:00:00'),
	(2, 2, '', '', '4,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,', 3, 'asdasdsad', 0, '', '', '', 1, '2016-11-22 20:35:31', 1, '2016-11-22 20:35:39');
/*!40000 ALTER TABLE `app` ENABLE KEYS */;


-- Dumping structure for table gunungsewu.bidang
CREATE TABLE IF NOT EXISTS `bidang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table gunungsewu.bidang: ~14 rows (approximately)
/*!40000 ALTER TABLE `bidang` DISABLE KEYS */;
INSERT INTO `bidang` (`id`, `name`) VALUES
	(1, 'Empowerment/Autonomy'),
	(2, 'Rewards & Recognition'),
	(3, 'Employer Brand'),
	(4, 'Career Opportunities'),
	(5, 'Diversity & Inclusion'),
	(6, 'Enabling Infrastructure'),
	(7, 'Learning & Development'),
	(8, 'Supervision'),
	(9, 'Performance Management'),
	(10, 'Work Tasks'),
	(11, 'Work/Life Balance'),
	(12, 'Collaboration'),
	(13, 'Talent & Staffing'),
	(14, 'Senior Leadership'),
	(15, 'Other');
/*!40000 ALTER TABLE `bidang` ENABLE KEYS */;


-- Dumping structure for table gunungsewu.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ip_login` varchar(50) NOT NULL,
  `user_agent` varchar(50) NOT NULL,
  `date_login` datetime NOT NULL,
  `user_create` varchar(50) NOT NULL,
  `date_create` datetime NOT NULL,
  `user_update` varchar(50) NOT NULL,
  `date_update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table gunungsewu.user: ~19 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `fullname`, `username`, `password`, `level`, `status`, `ip_login`, `user_agent`, `date_login`, `user_create`, `date_create`, `user_update`, `date_update`) VALUES
	(1, 'Adam Prasetia', 'damz', 'A267796', 1, 1, '::1', 'Windows 7(Google Chrome 54.0.2840.99)', '2016-11-24 16:30:35', '', '2015-09-30 09:35:33', '1', '2015-09-30 15:07:19'),
	(2, 'Teguh Santoso', 'teguh', 'cleopatra', 1, 1, '192.168.10.31', 'Windows 7(Google Chrome 53.0.2785.116)', '2016-10-04 09:51:25', '', '2015-09-30 09:35:52', '', '0000-00-00 00:00:00'),
	(7, 'Firman Rusbandy', 'firman', '10020', 3, 1, '192.168.10.178', 'Windows XP(Mozilla Firefox 41.0)', '2015-10-16 08:24:07', '1', '2015-10-08 14:35:06', '1', '2015-10-08 14:35:06'),
	(8, 'Julius', 'Julius', '11073', 3, 1, '192.168.10.175', 'Windows XP(Mozilla Firefox 14.0.1)', '2015-10-21 12:43:36', '1', '2015-10-08 14:41:32', '1', '2015-10-08 14:41:32'),
	(9, 'Asri Rahayu', 'asri', '15041', 3, 1, '192.168.10.177', 'Windows XP(Mozilla Firefox 37.0)', '2015-10-21 11:27:41', '1', '2015-10-08 15:24:11', '1', '2015-10-08 15:24:11'),
	(10, 'Alfiyani Dewi', 'alfiyani', 'aliyani', 3, 1, '192.168.10.176', 'Windows XP(Mozilla Firefox 24.0)', '2015-10-21 11:26:39', '1', '2015-10-08 15:24:22', '1', '2015-10-08 15:24:22'),
	(11, 'wiwi nurhaeni', 'wiwi', 'wiwi', 3, 1, '::1', 'Windows 7(Google Chrome 53.0.2785.116)', '2016-10-04 12:31:06', '', '2015-10-09 07:49:21', '', '0000-00-00 00:00:00'),
	(12, 'fathiah', 'thia', '230192', 3, 1, '192.168.10.154', 'Windows XP(Mozilla Firefox 20.0)', '2015-10-09 12:51:43', '', '2015-10-09 07:49:51', '', '0000-00-00 00:00:00'),
	(13, 'bogie septino', 'bogie', '130913', 3, 1, '192.168.10.65', 'Windows 7(Mozilla Firefox 41.0)', '2015-10-21 08:01:08', '', '2015-10-09 07:58:46', '', '0000-00-00 00:00:00'),
	(14, 'naila', 'nay', 'azmiprasetya', 3, 1, '192.168.10.155', 'Windows XP(Mozilla Firefox 13.0.1)', '2015-10-09 11:14:53', '', '2015-10-09 07:59:37', '', '0000-00-00 00:00:00'),
	(15, 'rahmat febriawan', 'febi', 'febi', 3, 1, '192.168.10.158', 'Windows XP(Mozilla Firefox 14.0.1)', '2015-10-09 13:02:13', '', '2015-10-09 08:29:54', '', '0000-00-00 00:00:00'),
	(16, 'Altobelly Giovanno', 'agiovanno', 'goodluck', 3, 1, '192.168.10.180', 'Windows XP(Mozilla Firefox 41.0)', '2015-10-27 07:41:31', '', '2015-10-09 09:45:10', '', '0000-00-00 00:00:00'),
	(17, 'wiwit ria meliyani', 'wiwit', '14147', 3, 1, '192.168.10.180', 'Windows XP(Mozilla Firefox 41.0)', '2015-10-15 14:26:56', '', '2015-10-09 10:02:47', '', '0000-00-00 00:00:00'),
	(18, 'De Admin', 'deadmin', 'deadmin123', 3, 1, '192.168.10.71', 'Windows 7(Mozilla Firefox 41.0)', '2015-10-22 07:13:19', '', '2015-10-09 18:21:28', '', '0000-00-00 00:00:00'),
	(19, 'Astri Leoni Agustin', 'leony', '200895', 3, 1, '192.168.10.60', 'Windows XP(Mozilla Firefox 41.0)', '2015-10-27 15:32:40', '', '2015-10-12 07:35:29', '', '0000-00-00 00:00:00'),
	(20, 'damara kartika sari', 'damara', '021293', 3, 1, '192.168.10.155', 'Windows XP(Mozilla Firefox 13.0.1)', '2015-10-13 15:36:12', '', '2015-10-13 07:23:58', '', '0000-00-00 00:00:00'),
	(21, 'shinta tri lestari', 'shinta15', 'shinta150991', 3, 1, '192.168.10.154', 'Windows XP(Mozilla Firefox 20.0)', '2015-10-13 07:38:44', '', '2015-10-13 07:26:55', '', '0000-00-00 00:00:00'),
	(22, 'gelin mandasari', 'gelin', 'pinkstar', 3, 1, '192.168.10.153', 'Windows XP(Mozilla Firefox 20.0)', '2015-10-13 07:53:53', '', '2015-10-13 07:53:38', '', '0000-00-00 00:00:00'),
	(23, 'Ratih Fadjarini', 'ratih', '14051', 3, 1, '192.168.10.156', 'Windows XP(Mozilla Firefox 41.0)', '2015-10-13 15:52:16', '', '2015-10-13 07:57:19', '', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
