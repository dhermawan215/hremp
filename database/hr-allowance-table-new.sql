-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table hrapp_karyawan.aktivitas
CREATE TABLE IF NOT EXISTS `aktivitas` (
  `id_aktivitas` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_aktivitas`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.aktivitas: ~3 rows (approximately)
INSERT INTO `aktivitas` (`id_aktivitas`, `nama`, `deskripsi`, `created_by`, `created_at`, `updated_at`) VALUES
	(1, 'Pendidikan', 'biaya kuliah', 'admin', '2024-02-19 08:01:27', '2024-02-27 04:45:15'),
	(2, 'Kesehatan dan Olahraga', 'biaya beli obat', 'admin', '2024-02-19 08:02:24', '2024-03-01 03:05:15'),
	(3, 'Rekreasi', 'biaya nonton bioskop', 'admin', '2024-02-19 08:03:04', '2024-03-01 03:04:57');

-- Dumping structure for table hrapp_karyawan.aktivitas_detail
CREATE TABLE IF NOT EXISTS `aktivitas_detail` (
  `id_aktivitas_detail` int NOT NULL AUTO_INCREMENT,
  `aktivitas_id` int DEFAULT NULL,
  `nama_detail` varchar(255) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_aktivitas_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hrapp_karyawan.aktivitas_detail: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.allowance
CREATE TABLE IF NOT EXISTS `allowance` (
  `id_allowance` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `nomer` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `cost_center_id` int DEFAULT NULL,
  `departement_id` int DEFAULT NULL,
  `period` year DEFAULT NULL,
  `total` double DEFAULT '0',
  `hr_approve` int DEFAULT '0',
  `hr_notes` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hr_check_at` timestamp NULL DEFAULT NULL,
  `manager_approve` int DEFAULT '0',
  `manager_note` text COLLATE utf8mb4_general_ci,
  `manager_approve_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_allowance`),
  UNIQUE KEY `nomer` (`nomer`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.allowance: ~2 rows (approximately)
INSERT INTO `allowance` (`id_allowance`, `users_id`, `nomer`, `transaction_date`, `nama`, `company_id`, `cost_center_id`, `departement_id`, `period`, `total`, `hr_approve`, `hr_notes`, `hr_check_at`, `manager_approve`, `manager_note`, `manager_approve_at`, `created_at`, `updated_at`) VALUES
	(1, 36, 'ARF-022800001', NULL, 'Klaim pembelian kacanmata dan alat kesehatan', NULL, NULL, 12, NULL, 2500000, 0, NULL, NULL, 0, NULL, NULL, '2024-02-28 08:56:48', '2024-02-28 08:56:48'),
	(2, 36, 'ARF-022900002', NULL, 'Pendidikan', NULL, NULL, 12, NULL, 3000000, 0, NULL, NULL, 0, NULL, NULL, '2024-02-29 06:57:05', '2024-02-29 06:57:05');

-- Dumping structure for table hrapp_karyawan.allowance_detail
CREATE TABLE IF NOT EXISTS `allowance_detail` (
  `id_all_det` int NOT NULL AUTO_INCREMENT,
  `allowance_id` int DEFAULT NULL,
  `aktivitas_id` int DEFAULT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `jumlah_biaya_bon` double DEFAULT NULL,
  `jumlah_biaya_klaim` double DEFAULT NULL,
  `tanggal_aktivitas` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_all_det`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.allowance_detail: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.allowance_file
CREATE TABLE IF NOT EXISTS `allowance_file` (
  `id_allowance_file` int NOT NULL AUTO_INCREMENT,
  `allowance_id` int DEFAULT NULL,
  `path` text,
  `uploaded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_allowance_file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hrapp_karyawan.allowance_file: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.allowance_limit
CREATE TABLE IF NOT EXISTS `allowance_limit` (
  `id_allowance_limit` int NOT NULL AUTO_INCREMENT,
  `nama_limit` varchar(255) DEFAULT NULL,
  `saldo_limit` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_allowance_limit`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hrapp_karyawan.allowance_limit: ~3 rows (approximately)
INSERT INTO `allowance_limit` (`id_allowance_limit`, `nama_limit`, `saldo_limit`, `created_at`, `updated_at`) VALUES
	(1, 'Limit 1', 3000000, '2024-02-21 09:08:57', '2024-02-27 02:53:33'),
	(2, 'Limit 2', 4200000, '2024-02-21 09:10:49', '2024-02-22 03:53:49'),
	(3, 'Limit 3', 6000000, '2024-02-21 09:13:02', '2024-02-21 09:13:02');

-- Dumping structure for table hrapp_karyawan.allowance_wallet
CREATE TABLE IF NOT EXISTS `allowance_wallet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `limit_id` int DEFAULT NULL,
  `saldo_awal` double DEFAULT NULL,
  `saldo_transaksi` int DEFAULT NULL,
  `saldo_sisa` double DEFAULT NULL,
  `periode_saldo` year DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.allowance_wallet: ~5 rows (approximately)
INSERT INTO `allowance_wallet` (`id`, `users_id`, `limit_id`, `saldo_awal`, `saldo_transaksi`, `saldo_sisa`, `periode_saldo`, `created_at`, `updated_at`) VALUES
	(1, 38, 2, 4200000, NULL, NULL, '2024', '2024-02-20 07:46:03', '2024-02-23 09:21:25'),
	(2, 36, 3, 6000000, NULL, 6000000, '2024', '2024-02-20 08:08:28', '2024-03-01 03:14:33'),
	(3, 39, 2, 4200000, NULL, 4200000, '2024', '2024-02-20 08:09:32', '2024-02-27 02:51:59'),
	(4, 41, 2, 4200000, NULL, 4200000, '2024', '2024-02-20 08:09:54', '2024-02-26 08:47:00'),
	(5, 40, 3, 6000000, NULL, NULL, '2024', '2024-02-20 08:11:32', '2024-02-23 09:21:35'),
	(7, 2, 3, 6000000, NULL, 6000000, '2024', '2024-02-23 06:52:26', '2024-02-23 06:52:26'),
	(8, 3, 3, 6000000, NULL, 6000000, '2024', '2024-02-27 02:51:38', '2024-02-27 02:51:38');

-- Dumping structure for table hrapp_karyawan.allowance_wallet_transaction
CREATE TABLE IF NOT EXISTS `allowance_wallet_transaction` (
  `id_aw_tr` int NOT NULL AUTO_INCREMENT,
  `allowance_id` int DEFAULT NULL,
  `users_id` int DEFAULT NULL,
  `total` double DEFAULT NULL,
  `tanggal_transaksi` timestamp NULL DEFAULT NULL,
  `periode_saldo` year DEFAULT NULL,
  `is_delete` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_aw_tr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.allowance_wallet_transaction: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.company
CREATE TABLE IF NOT EXISTS `company` (
  `IdCompany` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`IdCompany`),
  KEY `company_name` (`company_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.company: ~4 rows (approximately)
INSERT INTO `company` (`IdCompany`, `company_name`) VALUES
	(2, 'PT Acme Indonesia'),
	(4, 'PT Miltonia Warna Asia'),
	(3, 'PT Powerindo Kimia Mineral'),
	(1, 'PT Zeus Kimiatama Indonesia');

-- Dumping structure for table hrapp_karyawan.cost_center
CREATE TABLE IF NOT EXISTS `cost_center` (
  `id_cost_center` int NOT NULL AUTO_INCREMENT,
  `company_id` int DEFAULT NULL,
  `cost_center_name` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cost_center`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hrapp_karyawan.cost_center: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.cost_center_department
CREATE TABLE IF NOT EXISTS `cost_center_department` (
  `id_cost_department` int NOT NULL AUTO_INCREMENT,
  `cost_center_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cost_department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table hrapp_karyawan.cost_center_department: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.department
CREATE TABLE IF NOT EXISTS `department` (
  `id_dept` int NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '',
  PRIMARY KEY (`id_dept`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.department: ~21 rows (approximately)
INSERT INTO `department` (`id_dept`, `dept_name`) VALUES
	(1, 'Management'),
	(2, 'Operation'),
	(3, 'Legal'),
	(4, 'Production'),
	(5, 'Supply Chain and Purchasing'),
	(6, 'Human Resource & GA'),
	(7, 'Finance'),
	(8, 'RnD'),
	(9, 'HSE'),
	(10, 'Accounting'),
	(11, 'BU Chemical'),
	(12, 'Information Technology'),
	(13, 'BU O&G'),
	(14, 'BU Santint'),
	(15, 'BU IWT'),
	(16, 'BU Water'),
	(17, 'BU Mining'),
	(18, 'BU Mineral'),
	(19, 'Helper'),
	(20, 'Security'),
	(21, 'Gardener');

-- Dumping structure for table hrapp_karyawan.documents
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `upload_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.documents: ~0 rows (approximately)
INSERT INTO `documents` (`id`, `file_name`, `path`, `upload_time`, `created_at`) VALUES
	(6, 'FORM-IT-004-User-Access-Creation_Email-David', '2023122429-FORM-IT-004-User-Access-Creation_Email-David.pdf', '2023-12-23 22:53:29', '2023-12-23 22:53:29');

-- Dumping structure for table hrapp_karyawan.education
CREATE TABLE IF NOT EXISTS `education` (
  `id_edu` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `pendidikan_terakhir` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jurusan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `asal_sekolah` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_edu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.education: ~2 rows (approximately)
INSERT INTO `education` (`id_edu`, `emp_id`, `pendidikan_terakhir`, `jurusan`, `asal_sekolah`) VALUES
	(1, 158, 'S1', 'TEKNIK INDUSTRI', 'INSTITUT TEKNOLOGI BANDUNG'),
	(2, 160, 'S1', 'ADMINISTRASI NIAGA', 'POLITEKNIK NEGERI JAKARTA'),
	(3, 161, 'D4', 'test abc', 'test abc'),
	(4, 162, 'SMA/SMK', 'TKR', 'SMK Bekasi');

-- Dumping structure for table hrapp_karyawan.emergency
CREATE TABLE IF NOT EXISTS `emergency` (
  `id_emergency` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `no_telp` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hubungan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_emergency`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.emergency: ~3 rows (approximately)
INSERT INTO `emergency` (`id_emergency`, `emp_id`, `nama`, `alamat`, `no_telp`, `hubungan`) VALUES
	(1, 158, 'HERI RISWANDHONO', 'JALAN PEPAYA RAYA NO. 124, CIBODASARI, CIBODAS, TANGERANG 15138', '0878-7139-9189', 'Orang Tua'),
	(2, 159, 'AGUS RAHARDJA MADJIAH', 'MAHONI RAYA BLOK D12 GSP\r\n', '0812-8928-2755', 'Orang Tua'),
	(3, 160, 'ASTRI NURLAELI', 'JL. A RAHIM,002/003,MERUYUNG,LIMO,DEPOK,JAWA BARAT\r\n', '0857-8287-9014', 'SAUDARA'),
	(4, 161, 'test abc', 'test abc', '123456', 'test abc');

-- Dumping structure for table hrapp_karyawan.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `id_employee` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_emp` int DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comp_id` int DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_kartap` date DEFAULT NULL,
  `email_kantor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pangkat` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bpjstk` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bpjskes` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dept_id` int DEFAULT NULL,
  `is_resigned` int DEFAULT '0',
  PRIMARY KEY (`id_employee`) USING BTREE,
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.employee: ~160 rows (approximately)
INSERT INTO `employee` (`id_employee`, `nip`, `status_emp`, `lokasi`, `nama`, `comp_id`, `tgl_masuk`, `tgl_kartap`, `email_kantor`, `pangkat`, `jabatan`, `bpjstk`, `bpjskes`, `dept_id`, `is_resigned`) VALUES
	(1, 'M01', 1, 'TOWER', 'SUMANTRI ISHAK', 1, '1997-06-30', '0000-00-00', 'sumantri@zekindo.com', 'DIRECTOR', 'DIRECTOR', '09005525713', '0001516470862', 1, 0),
	(2, '00004', 1, 'AD', 'HESTI INDAH PUSPITASARI', 4, '2005-01-10', '0000-00-00', 'hesti@acmechem.co.id', 'DIRECTOR', 'DIRECTOR', '09005525812', '0002241955833', 1, 0),
	(3, '00007', 1, 'SUNGKAI', 'EDI JUNAEDI', 1, '2006-04-03', '0000-00-00', 'edi.junaedi@zekindo.com', 'SUPERVISOR', 'PRODUCTION SUPERVISOR', '09005525739', '0001516470941', 4, 0),
	(4, '00009', 1, 'SUNGKAI', 'ASA SUBAGJA', 1, '2007-09-07', '0000-00-00', NULL, 'STAFF', 'DRIVER', '09005525762', '0001622162428', 2, 0),
	(5, '00016', 1, 'JABABEKA', 'FANY KURNIAWAN', 2, '2010-10-05', '0000-00-00', 'Fany_Kurniawan@zekindo.com', 'MANAGER', 'MANAGER ACCOUNTING', '12027971626', '0001516470851', 10, 0),
	(6, '00017', 1, 'SUNGKAI', 'RINDU WAHONO', 1, '2011-03-03', '0000-00-00', 'rindu.wahono@zekindo.com', 'MANAGER', 'PLANT MANAGER LIPPO', '12018959705', '0001516471042', 2, 0),
	(7, '00023', 1, 'AD', 'WARIN NIRWANA', 4, '2013-04-01', '0000-00-00', NULL, 'STAFF', 'OPERATOR PRODUCTION', '09012117512', '0001516470928', 4, 0),
	(8, '00031', 1, 'SUNGKAI', 'SAEFUDIN', 1, '2014-01-06', '0000-00-00', NULL, 'STAFF', 'OPERATOR PRODUCTION', '14018858598', '0001516471097', 4, 0),
	(9, '00033', 1, 'JABABEKA', 'ADI KHAFIDH PERSADA', 2, '2014-03-10', '0000-00-00', 'adi.khafidh@acmechem.co.id', 'SENIOR MANAGER', 'GENERAL MANAGER SALES & OPERATION', '14026013400', '0001622162349', 11, 0),
	(10, '00034', 1, 'AD', 'SYAMROH FUAJI', 4, '2014-03-10', '0000-00-00', NULL, 'SUPERVISOR', 'PRODUCTION SUPERVISOR', '14026013418', '0001622162338', 4, 0),
	(11, '00051', 1, 'TOWER', 'IKA ARUM SARI', 1, '2019-01-01', '0000-00-00', 'ikaarumsari@zekindo.com', 'MANAGER', 'BUSINESS DEVELOPMENT MANAGER', '15035200623', '0002305558394', 13, 0),
	(12, '00058', 1, 'SUNGKAI', 'HANNA LIYANA', 1, '2015-08-28', '0000-00-00', 'hanna.liyana@zekindo.co.id', 'MANAGER', 'WHOLESALES ACCOUNT MANAGER', '16023580729', '0001766475009', 13, 0),
	(13, '00059', 1, 'TOWER', 'DHAMMA SULUH', 2, '2015-08-31', '0000-00-00', 'dhamma.suluh@acmechem.co.id', 'MANAGER', 'BU COATING MANAGER', '16005014663', '0001741304002', 14, 0),
	(14, '00060', 1, 'SUNGKAI', 'MERY ROGENTINA SIREGAR', 1, '2015-09-07', '0000-00-00', 'mery.siregar@zekindo.co.id', 'SENIOR OFFICER', 'MR & DOC. CONT', '17009930797', '0001648362227', 1, 0),
	(15, '00061', 1, 'SUNGKAI', 'RIA KUSUMA DEWI', 1, '2015-09-16', '0000-00-00', 'ria.kusuma@acmechem.co.id', 'MANAGER', 'BUSINESS UNIT MANAGER', '16000527545', '0001468554535', 15, 0),
	(16, '00076', 1, 'BUKIT INDAH', 'AULIA DWI CAHYANI', 1, '2016-10-19', '0000-00-00', 'aulia@zekindo.com', 'MANAGER', 'PLANT MANAGER KBI', '17009930789', '0000091453318', 4, 0),
	(17, '00077', 1, 'TOWER', 'RHESA AVILA ZAINAL', 3, '2016-11-01', '0000-00-00', 'rhesa.avila@pocs.co.id', 'DIRECTOR', 'DIRECTOR', '17009930466', '0003050044661', 1, 0),
	(18, '00093', 1, 'SUNGKAI', 'ENTIS SUTISNA', 1, '2016-10-03', '0000-00-00', NULL, 'STAFF', 'DRIVER', '16046840225', '0002101282953', 2, 0),
	(19, '00094', 1, 'JABABEKA', 'ADRIANSYAH VIRGIAWAN IBRAHIM', 2, '2016-10-07', '0000-00-00', NULL, 'STAFF', 'TECHNICAL SUPPORT', '16046840217', '0001622162259', 14, 0),
	(20, '00105', 1, 'SUNGKAI', 'SUTRISMIYANTO', 1, '2018-04-02', '0000-00-00', 'sutrismiyanto@zekindo.co.id', 'OFFICER', 'IT SUPPORT', '12036075468', '0001148572787', 12, 0),
	(21, '00109', 1, 'TOWER', 'ALFINO RAHEL', 3, '2018-07-25', '0000-00-00', 'alfino.rahel@pocs.co.id', 'OFFICER', 'BU MANAGER', '18070189776', '0001428794335', 16, 0),
	(22, '00117', 1, 'TOWER', 'MARTY RAMADHAN', 3, '2019-01-02', '0000-00-00', 'marty@pocs.co.id', 'OFFICER', 'BU MANAGER', '19036855617', '0001257988803', 17, 0),
	(23, '00123', 1, 'SUNGKAI', 'AMUNG', 1, '2019-06-25', '0000-00-00', NULL, 'STAFF', 'TECHNICAL SUPPORT', '18053004802', '0001907676955', 15, 0),
	(24, '00124', 1, 'SUNGKAI', 'ABING BIN PATA', 2, '2019-06-04', '0000-00-00', NULL, 'STAFF', 'DRIVER', '17015563426', '0001151502377', 2, 0),
	(25, '00125', 1, 'TOWER', 'WILIS WULANDARI', 1, '2019-05-06', '0000-00-00', 'wilis.wulandari@acmechem.co.id', 'JUNIOR MANAGER', 'ACCOUNTING & TAX HEAD', '19070051800', '0001658814017', 10, 0),
	(26, '00151', 1, 'SUNGKAI', 'MOHAMAD DIWAWAN', 1, '2019-12-27', '2020-04-26', NULL, 'STAFF', 'OPERATOR PRODUCTION', '19024687022', '0001744148889', 4, 0),
	(27, '00157', 1, 'TOWER', 'UTARI', 1, '2020-04-13', '2020-07-13', 'utari@zekindo.co.id', 'MANAGER', 'SUPPLY CHAIN MANAGER', '16055254565', '0001465869655', 5, 0),
	(28, '00163', 1, 'JABABEKA', 'MOURDANI SUSILO', 2, '2019-09-19', '2020-09-19', 'warehouse.sparepart@acmechem.co.id', 'OFFICER', 'WAREHOUSE & EXIM', '19080009509', '0002137633042', 2, 0),
	(29, '00165', 1, 'SUNGKAI', 'NADYA INTAN PRATIWI', 1, '2020-09-14', '2021-03-14', 'nadya.intan@zekindo.co.id', 'SUPERVISOR', 'CS & DELIVERY SUPERVISOR', '20072700816', '0001591814046', 2, 0),
	(30, '00166', 1, 'JABABEKA', 'NURUL HIKMAH RAMADHANI', 2, '2020-09-21', '2021-12-21', 'nurul.hikmah@tritonkencanatirta.co.id', 'OFFICER', 'TECHNICAL SALES ENGINEER', '20071265134', '0001080738562', 11, 0),
	(31, '00167', 1, 'TOWER', 'GALLO IBNU FAJAR', 3, '2020-09-28', '2021-03-28', 'gallo.ibnu@acmechem.co.id', 'OFFICER', 'TECHNICAL SALES ENGINEER', '20083115368', '0002911773047', 16, 0),
	(32, '00168', 1, 'TOWER', 'ANDREA GILANG FAUZI', 3, '2020-09-28', '2021-12-28', 'andrea.gilang@pocs.co.id', 'OFFICER', 'SERVICE ENGINEER', '20082729581', '0000039385405', 16, 0),
	(33, '00169', 1, 'TOWER', 'STELLA AVINCA', 2, '2020-10-05', '2021-04-05', 'stella.avinca@acmechem.co.id', 'OFFICER', 'TECHNICAL SALES ENGINEER', '20083115350', '0002377046823', 11, 0),
	(34, '00170', 1, 'BUKIT INDAH', 'GUSTIN NURANI PUTRI', 1, '2020-11-23', '2021-05-23', 'gustin.nurani@acmechem.co.id', 'OFFICER', 'PRODUCTION ENGINEER', '20094666128', '0001812279352', 4, 0),
	(35, '00171', 1, 'TOWER', 'SENNA ARDIANSYAH', 3, '2020-11-30', '2020-11-30', 'senna.ardiansyah@pocs.co.id', 'OFFICER', 'TECHNICAL SALES ENGINEER', '17022992022', '0001645999222', 18, 0),
	(36, '00172', 1, 'SUNGKAI', 'ZAINAL ARIFIN', 1, '2020-06-10', '2020-12-10', 'accounting@acmechem.co.id', 'SUPERVISOR', 'ACCOUNTING & TAX SUPERVISOR', '20044827911', '0000073594754', 10, 0),
	(37, '00173', 1, 'BUKIT INDAH', 'SATRIYO DIBYO SUMBOGO', 1, '2021-02-15', '2020-05-15', 'satriyo.dibyo@zekindo.co.id', 'JUNIOR MANAGER', 'LABORATORY MANAGER', '21018995973', '0001495455704', 8, 0),
	(38, '00176', 1, 'TOWER', 'MUHAMMAD IQBAL', 3, '2021-03-22', '2021-06-22', 'm.iqbal@pocs.co.id', 'OFFICER', 'SERVICE ENGINEER', '21028458475', '0002198134034', 17, 0),
	(39, '00180', 1, 'SUNGKAI', 'RAJIUL FADLI', 1, '2021-05-28', '2021-08-28', 'rajiul.fadli@zekindo.co.id', 'OFFICER', 'JAVA KALIMANTAN ACCT. MANAGER', '21040903508', '0000021772258', 13, 0),
	(40, '00181', 1, 'SUNGKAI', 'SAFIRA NADILA PUTRI', 1, '2021-06-02', '2021-09-02', 'safira.nadila@acmechem.co.id', 'OFFICER', 'TECHNICAL SALES ENGINEER', '21050649793', '0000036374556', 15, 0),
	(41, '00182', 1, 'TOWER', 'PUTRI BERLIANA', 2, '2021-06-02', '2021-12-02', 'putri.berliana@acmechem.co.id', 'OFFICER', 'TECHNICAL SALES ENGINEER', '21050649801', '0001110241304', 11, 0),
	(42, '00183', 1, 'BUKIT INDAH', 'KARIN FADILLA AGUSTIN', 1, '2020-05-18', '2021-05-18', 'karin.fadilla@zekindo.co.id', 'OFFICER', 'FINANCE SUPERVISOR', '20039864903', '0001791525363', 7, 0),
	(43, '00184', 1, 'JABABEKA', 'RIDHO LUTHFI ARISANDI', 2, '2021-06-14', '2021-09-14', 'ridho.luthfi@acmechem.co.id', 'OFFICER', 'IT SUPPORT', '21050649819', '0001450600727', 12, 0),
	(44, '00188', 1, 'TOWER', 'PRICILIA FLORENTINA', 3, '2021-09-07', '2021-12-07', 'pricilia.florentina@pocs.co.id', 'OFFICER', 'SUPPLY CHAIN ENGINEER', '21076435870', '0001371810058', 5, 0),
	(45, '00190', 1, 'JABABEKA', 'ALIF AHMADSYAH GIBRAN', 2, '2021-10-18', '2022-01-18', 'ahmadsyah.gibran@acmechem.co.id', 'OFFICER', 'TECHNICAL SALES ENGINEER', '21088050998', '0001959670888', 11, 0),
	(46, '00193', 1, 'TOWER', 'RIZQI AFFAN ALFITRI', 1, '2021-11-04', '2022-02-04', 'rizqi.affan@zekindo.co.id', 'OFFICER', 'CORPORATE PLANNING & PERFORMANCE MANAGEMENT HEAD', '21099891448', '0001769914866', 7, 0),
	(47, '00195', 1, 'BUKIT INDAH', 'SALSABILA MUTHIAH', 1, '2021-11-23', '2022-02-23', 'salsabila.muthiah@zekindo.co.id', 'OFFICER', 'RESEARCH ENGINEER', '21099891463', '0001837102015', 8, 0),
	(48, '00196', 1, 'SUNGKAI', 'NABILA FARRAS BALQIS', 1, '2021-11-23', '2022-02-23', 'nabila.farras@zekindo.co.id', 'OFFICER', 'SUPPLY CHAIN ENGINEER', '21099891471', '0002088559394', 5, 0),
	(49, '00198', 1, 'JABABEKA', 'ELSA ODELIA MUMU', 2, '2021-12-09', '2022-03-09', 'elsa.odelia@acmechem.co.id', 'OFFICER', 'ACCOUNTING OFFICER', '22006399418', '0001896767212', 10, 0),
	(50, '00202', 1, 'JABABEKA', 'MILLENIA RAHMA FADHILA', 2, '2022-02-07', '2022-05-07', 'millenia.rahma@acmechem.co.id', 'OFFICER', 'SUPPLY CHAIN OFFICER', '22029176298', '0003297104739', 5, 0),
	(51, '00203', 1, 'TOWER', 'FAITHA KHARIS PUTRA PRANANTO', 1, '2022-02-14', '2022-05-14', 'faitha.kharis@zekindo.co.id', 'OFFICER', 'BUDGETING STAFF', '22043690415', '0001733348913', 7, 0),
	(52, '00204', 1, 'SUNGKAI', 'ISWADI', 1, '2022-02-15', '2022-02-15', 'iswadi@zekindo.co.id', 'SENIOR OFFICER', 'MAINTENANCE', '19012816229', '0001824850787', 2, 0),
	(53, '00208', 1, 'TOWER', 'MARIA XENA INDRIANI', 3, '2022-04-08', '2022-07-08', 'maria.xena@acmechem.co.id', 'OFFICER', 'ACCOUNTING OFFICER', '21006355644', '0002044475111', 10, 0),
	(54, '00209', 1, 'TOWER', 'MEGA SETIA MAWARNI SIGALINGGING', 2, '2022-04-21', '2022-07-21', 'mega.sigalingging@acmechem.co.id', 'OFFICER', 'AR OFFICER', '22048835536', '0000197449839', 7, 0),
	(55, '00210', 1, 'SUNGKAI', 'NUR CAHYANINGRUM', 1, '2022-05-09', '2022-08-09', 'nur.cahya@zekindo.co.id', 'OFFICER', 'PROCUREMENT - SOURCING', '22063967487', '0000718840653', 5, 0),
	(56, '00212', 1, 'TOWER', 'KHALISHA QATRUNNADA', 1, '2022-07-04', '2022-10-04', 'khalisha.qatrunnada@zekindo.co.id', 'OFFICER', 'IPO PROJECT OFFICER', '22089343879', '0001629861985', 1, 0),
	(57, '00213', 1, 'JABABEKA', 'FANNICA DAINA', 2, '2022-07-08', '2022-12-08', 'fannica.daina@acmechem.co.id', 'OFFICER', 'CS & DELIVERY', '19027254788', '0001807564397', 2, 0),
	(58, '00216', 1, 'TOWER', 'NATASYA', 2, '2022-08-15', '2022-11-16', 'natasya@acmechem.co.id ', 'OFFICER', 'TECHNICAL SALES ENGINEER', '22103842864', '0003306090633', 14, 0),
	(59, '00217', 1, 'BUKIT INDAH', 'FRANSISKA SELLY PRAMESTI', 1, '2022-08-15', '2022-11-15', 'fransiska.selly@zekindo.co.id', 'Asisstant Manager', 'Laboratory Assistant Manager', '22103842849', '0003544617161', 8, 0),
	(60, '00221', 1, 'JABABEKA', 'PERMATA SALSABILLA RAMADHINI', 2, '2022-09-05', '2022-12-05', 'hr.admin@acmechem.co.id', 'OFFICER', 'HR REPRESENTATIVE', '21069212815', '0002139172997', 6, 0),
	(61, '00222', 1, 'JABABEKA', 'MUHAMMAD GILANG NURUL IMAN', 1, '2022-09-12', '2022-12-13', 'gilang.nurul@zekindo.co.id', 'OFFICER', 'LEGAL & PERMIT OFFICER', '22120977198', '0001314835751', 1, 0),
	(62, '00223', 1, 'TOWER', 'YUSUF AZZAM SHOFIYUDDIN', 1, '2022-09-12', '2022-12-13', 'yusuf.azzam@zekindo.co.id', 'SUPERVISOR', 'SUPPLY CHAIN SUPERVISOR', '22120977206', '0001469550982', 5, 0),
	(63, 'P0224', 1, 'ALSUT', 'PRISKILLA BUNA KRISTIANTO', 3, '2022-09-15', '2023-01-16', 'priskilla.buna@zekindo.co.id', 'OFFICER', 'FINANCE OFFICER', '22144773565', '0001806726846', 7, 0),
	(64, '00225', 1, 'BUKIT INDAH', 'CAROLYNE TIATIRA', 2, '2022-09-19', '2022-12-20', 'carolyne.tiatira@acmechem.co.id', 'ENGINEER', 'COLOR MATCHING SPECIALIST', '22037673062', '0001832423117', 11, 0),
	(65, '00226', 1, 'LAHAT', 'KAWA BENTA KUBILLAH', 3, '2022-09-22', '2022-12-23', 'kawa.benta@pocs.co.id', 'ENGINEER', 'SERVICE ENGINEER', '22129522656', '0001182293054', 17, 0),
	(66, '00227', 1, 'SUNGKAI', 'ERICA CHRISTY', 1, '2022-09-23', '2022-12-24', 'erica.christy@zekindo.co.id', 'OFFICER', 'PRODUCTION ENGINEER', '21091802773', '0001469146533', 4, 0),
	(67, '00228', 1, 'BUKIT INDAH', 'ARDI IRAWAN', 1, '2020-07-08', '2022-10-08', NULL, 'STAFF', 'WAREHOUSE OPERATOR', '20081564104', '0001030955185', 4, 0),
	(68, '00229', 1, 'SUNGKAI', 'NABIILAH SALSABIIL', 1, '2022-10-12', '2023-01-13', 'nabiilah.salsabiil@zekindo.co.id', 'OFFICER', 'ACT.LAB / FIELD ENGINEER', '22137817858', '0000080237463', 13, 0),
	(69, '00230', 1, 'SUNGKAI', 'CAHYA AJISAPUTRA', 1, '2022-11-01', '2023-02-01', 'cahya.aji@zekindo.co.id', 'OFFICER', 'SENIOR TECHNICIAN', '16014479543', '0001681572622', 15, 0),
	(70, '00231', 1, 'JABABEKA', 'MUHAMMAD FATHUL ISLAM', 2, '2022-11-10', '2023-02-10', 'fathul.islam@acmechem.co.id', 'OFFICER', 'OPERATION MANAGER', '21058883725', '0002072236127', 2, 0),
	(71, '00234', 1, 'BUKIT INDAH', 'AYUB MUSALIM', 1, '2019-11-01', '2022-11-03', NULL, 'STAFF', 'OPERATOR PRODUCTION', '19102758984', '0002917178908', 4, 0),
	(72, '00235', 1, 'JABABEKA', 'FARHAN AJI MUKTI', 2, '2022-12-01', '2023-03-02', 'farhan.aji@acmechem.co.id', 'ENGINEER', 'TECHNICAL SALES ENGINEER', '23009212137', '0002435480166', 11, 0),
	(73, '00237', 1, 'SUNGKAI', 'ULFAH SITI FAUZIAH', 1, '2022-12-01', '2023-06-02', 'ulfah.fauziah@zekindo.co.id', 'OFFICER', 'ACCOUNTING & TAX OFFICER', '0001480971003', '00022053425090', 10, 0),
	(74, '00241', 1, 'SUNGKAI', 'NURHADA JAELANI', 1, '2019-06-17', '2022-12-26', NULL, 'STAFF', 'OPERATOR WAREHOUSE', '19080009491', '0001159024432', 2, 0),
	(75, '00243', 1, 'SUNGKAI', 'AINUN ESRA PRADITA', 1, '2023-01-16', '2023-04-17', 'ainun.esra@zekindo.co.id', 'STAFF', 'ENVIRONMENT OFFICER', '23050883810', '0001908443777', 9, 0),
	(76, '00244', 1, 'BUKIT INDAH', 'DEDEN DANI SAPUTRA', 1, '2023-02-06', '2023-05-06', 'deden.dani@zekindo.co.id', 'ENGINEER', 'PRODUCTION ENGINEER', '23035315243', '0001275568165', 4, 0),
	(77, '00245', 1, 'BUKIT INDAH', 'AMELIA NAOMI AGUSTINA', 1, '2023-02-06', '2023-05-06', 'amelia.naomi@zekindo.co.id', 'ENGINEER', 'RESEARCH ENGINEER', '23035315235', '0000076012863', 8, 0),
	(78, '00246', 1, 'BATU KAJANG', 'FATHONI HIDAYAT', 3, '2023-04-03', '2023-07-03', 'fathoni.hidayat@pocs.co.id', 'ENGINEER', 'SERVICE ENGINEER', '22054044247', '0001090245464', 17, 0),
	(79, '00248', 1, 'TOWER', 'ADIBAH QONITANTI', 1, '2023-05-02', '2023-08-02', 'adibah.qonitanti@zekindo.co.id', 'ENGINEER', 'ADMIN TENDER (OIL AND GAS BUSINESS UNIT)', 'N/A', '0001537043196', 13, 0),
	(80, '00249', 1, 'BALIK PAPAN', 'SEPTIAN HERDIYANTO', 1, '2023-04-06', '2023-07-06', 'septian.herdiyanto@zekindo.co.id', 'ENGINEER', 'FIELD SERVICE ENGINEER ', '20048938441', '0001547618106', 13, 0),
	(81, '00145', 1, 'BUKIT INDAH', 'MIFTAH FARID TRINANDA', 1, '2022-05-09', '2023-05-09', NULL, 'STAFF', 'OPERATOR PRODUCTION', '22103842856', '0002135667699', 4, 0),
	(82, '00250', 1, 'BUKIT INDAH', 'LUTFIAH INDAH RIZKI', 2, '2023-05-22', '2023-08-22', 'lutfiah.indah@acmechem.co.id', 'OFFICER', 'FINANCE OFFICER', 'N/A', 'N/A', 7, 0),
	(83, '00251', 1, 'TANJUNG ENIM', 'DENNY LUKMAN PRASETYO', 3, '2023-06-13', '2023-09-13', 'denny.lukman@pocs.co.id', 'ENGINEER', 'SERVICE ENGINEER', '22068276199', '0000037080538', 17, 0),
	(84, '00252', 1, 'ALSUT', 'AURA DWI SAPUTRI', 3, '2023-07-13', '2023-10-12', 'aura.saputri@pocs.co.id', 'ENGINEER', 'TECHNICAL SALES ENGINEER', '23126780693', '0001322745928', 18, 0),
	(85, '00253', 1, 'SUNGKAI', 'ASEP SAEPULOH', 1, '2020-01-15', '0000-00-00', NULL, 'STAFF', 'TECHNICAL SUPPORT', '20016493999', '0002510781827', 15, 0),
	(86, '00254', 1, 'SUNGKAI', 'AAT ZAKI MUBAROK', 1, '2023-07-20', '2023-10-20', 'aat.zaki@zekindo.co.id', 'ENGINEER', 'TECHNICAL SALES ENGINEER', '23119365775', '0000976769987', 15, 0),
	(87, '00255', 1, 'ALSUT', 'PANNYAVARA KIRANASETA', 1, '2023-07-26', '2023-10-26', 'pannyavara.kirana@zekindo.co.id', 'ENGINEER', ' Enzyme Specialist', '23119365791', '0001786139177', 1, 0),
	(88, 'P0256', 6, 'TANJUNG ENIM', 'MGS FADHIL ADLI', 3, '2023-08-08', '0000-00-00', 'fadhil.adli@pocs.co.id', 'ENGINEER', 'TECHNICAL SERVICE ENGINEER', '22160572552', '0001786139177', 17, 0),
	(89, '00257', 1, 'BUKIT INDAH', 'MUHAMMAD KHUSNUL KHOLUQ', 1, '2023-05-26', '2023-03-04', 'khusnul.kholuq@acmechem.co.id', 'SENIOR OFFICER', 'FINANCE OFFICER', '23009212145', '00027601033686', 7, 0),
	(90, 'P0258', 6, 'BATU KAJANG', 'ABYAN DANDI FARHANANDA', 3, '2023-09-04', '0000-00-00', 'abyan.dandi@pocs.co.id', 'ENGINEER', 'TECHNICAL SERVICE ENGINEER', 'N/A', 'N/A', 18, 0),
	(91, '00259', 1, 'BUKIT INDAH', 'MUHAMMAD LUTFAN AKBAR', 1, '2023-09-04', '2023-12-04', 'lutfan.akbar@zekindo.co.id', 'ENGINEER', 'PROCESS ENGINEER', '23157875628', '1111', 4, 0),
	(92, '00260', 1, 'SUNGKAI', 'UTARI SHINTYA DEWI', 1, '2023-09-11', '2023-12-11', 'utari.shintya@zekindo.co.id', 'OFFICER', 'QUALITY CONTROL', '22032224473', '0001424265603', 2, 0),
	(93, '00261', 1, 'TOWER', 'GABRIELA CARISSA AVERINA', 1, '2023-09-18', '2023-12-18', 'gabriela.carissa@zekindo.co.id', 'OFFICER', 'HR COORDINATOR', 'N/A', '0001798722369', 6, 0),
	(94, '00262', 1, 'TOWER', 'HARSA ARISYI MAHARAMIS POETRA', 1, '2023-09-11', '2023-12-11', 'harsa.poetra@zekindo.co.id', 'ENGINEER', 'OPERATION EXCELLENCE ENGINEER', '23157875669', '0001817470157', 5, 0),
	(95, '00263', 1, 'BUKIT INDAH', 'DICKY HERMAWAN', 1, '2022-09-12', '2023-09-13', 'dicky.hermawan@zekindo.co.id', 'STAFF', 'IT SUPPORT', '22017262480', '0001979499666', 12, 0),
	(96, '00264', 1, 'JABABEKA', 'ROJALI', 2, '2022-09-21', '2023-09-21', NULL, 'OPERATOR', 'WAREHOUSE COATING', '22122291663', '0002137146996', 2, 0),
	(97, 'P0265', 6, 'JABABEKA', 'MUHAMMAD HISYAM', 2, '2023-10-09', '0000-00-00', 'muhammad.hisyam@acmechem.co.id', 'ENGINEER', 'TECHNICAL ENGINEER', '22070429786', '0001826096308', 11, 0),
	(98, 'P0266', 6, 'TOWER', 'PRAMATYA RIZQI ANINDITA', 1, '2023-10-09', '0000-00-00', 'pramatya.anindita@zekindo.co.id', 'OFFICER', 'MIS Officer', 'N/A', '0001868141057', 7, 0),
	(99, 'P0267', 6, 'TOWER', 'SEKARSARI ILMI HAQI YUSVI', 1, '2023-10-10', '0000-00-00', 'sekarsari@zekindo.co.id', 'ENGINEER', 'TECHNICAL ASSISTANCE', 'N/A', '000114814214', 1, 0),
	(100, 'P0268', 6, 'BUKIT INDAH', 'SHODIQ YUSTI WARDANA', 1, '2023-10-30', '0000-00-00', 'shodiq.wardana@zekindo.co.id', 'ENGINEER', 'RESEARCH AND DEVELOPMENT ENGINEER', 'N/A', '0002447800841', 8, 0),
	(101, 'P0269', 6, 'JABABEKA', 'MOCHAMMAD AZIZ GHOFFAR', 2, '2023-11-07', '0000-00-00', 'aziz.ghoffar@acmechem.co.id', 'OFFICER', 'ACCOUNTING OFFICER', 'N/A', '0002699725296', 10, 0),
	(102, 'P0270', 6, 'JABABEKA', 'TIARA NADYA', 2, '2023-11-13', '0000-00-00', 'tiara.nadya@acmechem.co.id', 'ENGINEER', 'TECHNICAL SALES ENGINEER', 'N/A', '0001881217528', 11, 0),
	(103, 'M03', 2, 'SUNGKAI', 'EKO WIDIATMOKO', 1, '2017-11-27', '0000-00-00', 'eko.widiatmoko@zekindo.co.id', 'DIRECTOR', 'OPERATION DIRECTOR', '90K22178304', '0001770688765', 1, 0),
	(104, 'M02', 2, 'TOWER', 'IR.ISTIYARSO', 1, '2020-01-02', '0000-00-00', 'istiyarso@zekindo.co.id', 'DIRECTOR', 'O&G DIRECTOR', '22076963473', '-', 1, 0),
	(105, 'K0082', 2, 'SUNGKAI', 'MUHAMAD RIFKI YAKUP', 1, '2021-10-14', '0000-00-00', NULL, 'STAFF', 'TECHNICAL SUPPORT', '22039652940', '0002876117861', 15, 0),
	(106, 'K0149', 2, 'BUNGA MAYANG', 'AGAZ ANDIKA FENIO PUTRA', 2, '2022-06-01', '0000-00-00', NULL, 'STAFF', 'OPERATOR ANALYST', 'BPU', '-', 11, 0),
	(107, 'K0150', 2, 'SUNGKAI', 'SUTADI SOSROATMOJO', 1, '2022-06-13', '0000-00-00', 'sutadi@zekindo.co.id', 'ADVISOR', 'HSE COORDINATOR', '22076963465', '0002378205292', 9, 0),
	(108, 'K0158', 2, 'BUKIT INDAH', 'DENI FRANS SAKKA', 1, '2022-09-01', '0000-00-00', 'deni.sakka@zekindo.co.id', 'ENGINEER', 'RESEARCH ENGINEER', '15042622587', '0001742044217', 8, 1),
	(109, 'K0165', 2, 'TOWER', 'DODY DWI PRASETIYO', 1, '2022-09-26', '0000-00-00', 'dody.prasetiyo@zekindo.co.id', 'STAFF', 'CORPORATE INTERNAL AUDIT', '89J50031551', '000165787878', 1, 0),
	(110, 'O0244', 4, 'TOWER', 'LINDA EVAYANI', 2, '2023-11-26', '0000-00-00', 'Lindaevayanil@gmail.com', 'STAFF', 'HELPER', '23009212152', '0002308579929', 19, 0),
	(111, 'K0182', 2, 'RUKO', 'EVIRNA LISNAWATY', 1, '2014-09-26', '0000-00-00', 'evirna.lisnawaty@zekindo.co.id', 'DIRECTOR', 'FINANCE & ACCOUNTING DIRECTOR', '17041312251', '0001621286886', 1, 0),
	(112, 'K0183', 2, 'TOWER', 'DJUNAEDI WINATA', 1, '2022-05-20', '0000-00-00', 'djunaedi@rochtec.co.id', 'DIRECTOR', 'IWT BU HEAD', '22084461163', '-', 1, 0),
	(113, 'K0185', 2, 'TOWER', 'YANA MARLIANTY SAFAQOH', 1, '2014-10-01', '0000-00-00', 'yana@zekindo.com', 'DIRECTOR', 'BUSINESS SUPPORT DIRECTOR', '17063699635', '0001516470873', 1, 0),
	(114, 'K0187', 2, 'AB', 'NUR SYAMSUDIN', 2, '2023-02-27', '0000-00-00', NULL, 'STAFF', 'WAREHOUSE OPERATOR', 'BPU', '0002201301505', 2, 0),
	(115, 'K0195', 2, 'SUNGKAI', 'CEVI NAWAWI', 1, '2022-03-13', '0000-00-00', NULL, 'STAFF', 'OPERATOR PRODUCTION', 'N/A', NULL, 4, 0),
	(116, 'K0196', 2, 'SUNGKAI', 'GUNI PRIKUSUMA', 1, '2022-10-06', '0000-00-00', NULL, 'STAFF', 'OPERATOR PRODUCTION', 'N/A', NULL, 4, 0),
	(117, 'K0199', 2, 'BUKIT INDAH', 'DENY RAY', 1, '2023-05-15', '0000-00-00', NULL, 'STAFF', 'OPERATOR PRODUCTION', 'BPU', '-', 4, 0),
	(118, 'K0200', 2, 'BUKIT INDAH', 'NAZIM  ASFI PRATAMA', 1, '2023-05-15', '0000-00-00', NULL, 'STAFF', 'OPERATOR PRODUCTION', '23057193429', '-', 4, 0),
	(119, 'K0201', 2, 'BUKIT INDAH', 'FAIZAL ARDIEN', 1, '2023-05-15', '0000-00-00', NULL, 'STAFF', 'OPERATOR PRODUCTION', '20055388043', '-', 4, 0),
	(120, 'K0206', 2, 'SUNGKAI', 'SEPTI EMBRIANI', 1, '2023-04-26', '0000-00-00', NULL, 'STAFF', 'PROCUREMENT NON RAW MATERIAL', '21021628090', NULL, 5, 0),
	(121, 'K0221', 2, 'TANJUNG ENIM', 'WIDIYA TRI UTAMA', 3, '2023-07-18', '0000-00-00', 'N/A', 'STAFF', 'ADMIN OPERATIONAL SITE TANJUNG ENIM', '', '0000309262961', 17, 0),
	(122, 'K0222', 2, 'ALSUT', 'EMA HALIMAH', 1, '2023-08-01', '0000-00-00', 'ema.halimah@zekindo.com', 'SPECIALIST', 'RND ADVISOR', '23119365783', '0001641068144', 8, 0),
	(123, 'K0230', 2, 'BALIKPAPAN', 'KUSMIADI', 1, '2023-10-01', '0000-00-00', 'N/A', 'STAFF', 'TECHNICIAN SITE NPU BALIKPAPAN', '100310762340', '0001835613832', 13, 0),
	(124, 'K0231', 2, 'BALIKPAPAN', 'SUGENG NURHABIB', 1, '2023-10-01', '0000-00-00', 'N/A', 'STAFF', 'TECHNICIAN SITE NPU BALIKPAPAN', '23051265546', '0001683819246', 13, 0),
	(125, 'K0232', 2, 'BALIKPAPAN', 'YUSRI', 1, '2023-10-01', '0000-00-00', 'N/A', 'STAFF', 'TECHNICIAN SITE NPU BALIKPAPAN', '17028136954', '0001546706215', 13, 0),
	(126, 'K0233', 2, 'BALIKPAPAN', 'VEDERISON ALBERTUS KENEDY ISU', 1, '2023-10-01', '0000-00-00', 'N/A', 'STAFF', 'TECHNICIAN SITE NPU BALIKPAPAN', '12032934163', '0001148103764', 13, 0),
	(127, 'K0234', 2, 'BALIKPAPAN', 'BUDI KURNIAWAN', 1, '2023-10-01', '0000-00-00', 'N/A', 'STAFF', 'FLYING TECHNICIAN SITE NPU BALIKPAPAN', '18081851547', '0002358914692', 13, 0),
	(128, 'K0237', 2, 'BUKIT INDAH', 'MANDA RAHMANIA AZKIA', 1, '2023-10-16', '0000-00-00', 'N/A', 'STAFF', 'CS SUPPORT', 'N/A', '0001817988963', 2, 0),
	(129, 'K0239', 2, 'SUNGKAI', 'ALMAIDA YULIANTI', 1, '2023-10-25', '0000-00-00', 'almaida.yulianti@zekindo.co.id', 'ENGINEER', 'WAREHOUSE OFFICER', 'N/A', '0001600772466', 2, 0),
	(130, 'K0240', 2, 'BUKIT INDAH', 'FAJAR ADI PRATAMA', 1, '2023-10-26', '0000-00-00', 'N/A', 'STAFF', 'OPERATOR PRODUCTION', 'BPU', 'N/A', 4, 0),
	(131, 'K0242', 2, 'BALIKPAPAN', 'ANDI PRASETYO', 1, '2023-11-15', '0000-00-00', '', 'STAFF', 'TECHNICIAN SITE NPU, PHM', '18033057318', '0000562574979', 13, 0),
	(132, 'K0243', 2, 'BALIKPAPAN', 'SAHARUDDIN', 1, '2023-11-15', '0000-00-00', '-', 'STAFF', 'TECHNICIAN SITE NPU, PHM', 'N/A', '0001547618488', 13, 0),
	(133, 'O0170', 4, 'BUKIT INDAH', 'TEE SAMSUDIN', 1, '2022-09-14', '0000-00-00', '-', 'STAFF', 'OB CIKAMPEK', 'N/A', 'N/A', 19, 0),
	(134, 'O0173', 4, 'BUKIT INDAH', 'UJANG SUPRIYATNA', 1, '2022-10-13', '0000-00-00', '-', 'STAFF', 'SECURITY CIKAMPEK', 'N/A', 'N/A', 20, 0),
	(135, 'O0186', 4, 'JABABEKA', 'RAHMAT HIDAYATULLAH', 2, '2023-01-26', '0000-00-00', '-', 'STAFF', 'HELPER', 'N/A', 'N/A', 19, 0),
	(136, 'O0192', 4, 'SUNGKAI', 'AGUS HASANUDIN', 1, '2023-03-01', '0000-00-00', '-', 'STAFF', 'SECURITY SUNGKAI', 'N/A', 'N/A', 20, 0),
	(137, 'O0193', 4, 'JABABEKA', 'SAEFUL FAJRI', 2, '2023-02-01', '0000-00-00', '-', 'STAFF', 'SECURITY JABABEKA', 'N/A', 'N/A', 20, 0),
	(138, 'O0202', 4, 'SUNGKAI', 'RIAN NIFAL', 1, '2023-05-26', '0000-00-00', '-', 'STAFF', 'OB SUNGKAI', 'N/A', 'N/A', 19, 0),
	(139, 'O0203', 4, 'BUKIT INDAH', 'APRI APRIYANA', 1, '2023-05-26', '0000-00-00', '-', 'STAFF', 'SECURITY CIKAMPEK', 'N/A', 'N/A', 20, 0),
	(140, 'O0204', 4, 'BUKIT INDAH', 'CHANDRA SAPUTRA', 1, '2023-05-26', '0000-00-00', '-', 'STAFF', 'SECURITY CIKAMPEK', 'N/A', 'N/A', 20, 0),
	(141, 'O0205', 4, 'BUKIT INDAH', 'SAEFULLOH EFENDI', 1, '2023-05-26', '0000-00-00', '-', 'STAFF', 'SECURITY CIKAMPEK', 'N/A', 'N/A', 20, 0),
	(142, 'O0223', 4, 'BUKIT INDAH', 'ROBI NURCAHYA', 1, '2023-08-26', '0000-00-00', '-', 'STAFF', 'OB KBI', 'BPU', 'N/A', 19, 0),
	(143, 'O0227', 4, 'SUNGKAI', 'ITEUNG ROSMAWATI', 1, '2023-09-26', '0000-00-00', '-', 'STAFF', 'HELPER', '19068260835', '-', 19, 0),
	(144, 'O0228', 4, 'BUKIT INDAH', 'SALIM', 1, '2023-08-26', '0000-00-00', '-', 'STAFF', 'GARDENER', '221038442823', '0001010183297', 21, 0),
	(145, 'O0229', 4, 'SUNGKAI', 'AMAN SUHARMANTO', 1, '2023-08-26', '0000-00-00', '-', 'STAFF', 'GARDENER', '20014564502', '0001636220092', 21, 0),
	(146, 'O0238', 4, 'SUNGKAI', 'KARMAN ADI', 1, '2023-10-16', '0000-00-00', '-', 'STAFF', 'DRIVER FUSO', 'N/A', 'N/A', 2, 0),
	(147, 'I0220', 5, 'SUNGKAI', 'MUHAMMAD BILAL HIBATULLOH', 1, '2023-07-07', '0000-00-00', 'bilalhbtllh16@gmail.com', 'STAFF', 'ACCOUNTING INTERN', 'BPU', '0001461162903', 10, 0),
	(148, 'I0225', 5, 'SUNGKAI', 'ANASTASIA KARINA KUSUMA', 1, '2023-08-21', '0000-00-00', 'anastasiakarinakusuma@gmail.com', 'STAFF', 'QC INTERN', 'BPU', 'N/A', 2, 0),
	(149, 'I0226', 5, 'SUNGKAI', 'RINDA WARDHANI', 1, '2023-08-21', '0000-00-00', 'rindawardhani17@gmail.com', 'STAFF', 'QC INTERN', 'BPU', 'N/A', 2, 0),
	(150, 'I0235', 5, 'JABABEKA', 'MUHAMMAD DEVAN PAMUNGKAS', 2, '2023-09-18', '0000-00-00', 'devanpamungkas04@gmail.com', 'STAFF', 'OPERATION INTERN', 'N/A', 'N/A', 2, 0),
	(151, 'I0236', 5, 'JABABEKA', 'DIAN PUSPITA DEWI', 2, '2023-09-19', '0000-00-00', 'puspitadian631@gmail.com', 'STAFF', 'ACCOUNTING INTERN', 'N/A', 'N/A', 10, 0),
	(152, 'I0241', 5, 'ALSUT', 'THEODORUS DEVIN GINTING', 2, '2023-11-13', '0000-00-00', 'tdevin10@gmail.com', 'STAFF', 'FINANCE INTERN', 'BPU', 'N/A', 7, 0),
	(153, 'O0245', 4, 'TOWER', 'MUHAMAD REFSA HANDANI', 1, '2022-12-09', '0000-00-00', 'MuhamamdRefsa@gmail.com', 'STAFF', 'HELPER', '1111', '111', 19, 0),
	(154, 'H0188', 3, 'MARUNDA', 'MUHAMAD RIFALDI', 3, '2023-03-06', '0000-00-00', 'rifaldihercules@gmail.com', 'STAFF', 'OPERATOR SITE MADURA BEKASI', '', '', 16, 0),
	(155, 'H0190', 3, 'MARUNDA', 'WAHYUDA', 3, '2023-03-06', '0000-00-00', 'yudaw4121@gmail.com', 'STAFF', 'OPERATOR SITE MADURA BEKASI', '', '', 16, 0),
	(156, 'H0197', 3, 'TOWER', 'ANAS MA`RUF', 1, '2023-04-24', '0000-00-00', 'anasdes0212@gmail.com', 'STAFF', 'DRIVER PAK SUMANTRI', '', '', 2, 0),
	(157, 'H0218', 3, 'MARUNDA', 'FIRMANSYAH', 3, '2023-06-19', '0000-00-00', 'vimensyah28@gmail.com', 'STAFF', 'OPERATOR SITE MADURA BEKASI', '', '', 16, 0),
	(158, 'P0271', 6, 'BUKIT INDAH', 'SHERGIO RIZKYPUTRA', 1, '2023-11-23', NULL, 'shergio.rizkyputra@zekindo.co.id', 'Officer', 'Finance Officer', '1111', '0001770229326', 7, 0),
	(159, 'P0272', 6, 'TOWER', 'DAVID ANINDITYA MADJIAH', 1, '2023-12-27', NULL, 'belumada@gmail.com', 'ENGINEER', 'TECHNICAL ENGINEER', '11111', '0002207850074', 13, 0),
	(160, 'P0273', 6, 'Jababeka', 'ADINDA TIARA MAULIDINA', 2, '2023-12-27', NULL, 'Warehouse@acmechem.co.id', 'Officer', 'WAREHOUSE AND EXIM OFFICER', '1111', '0001185844476', 2, 0),
	(161, 'ABC1234', 2, 'abc test', 'test kar 1', 4, '2023-12-29', NULL, 'test1@gmail.com', 'test abc', 'test abc', 'test abc', 'test abc', 12, 0),
	(162, 'test1234', 1, 'Jababeka', 'test1234', 2, '2023-12-12', '2024-01-12', 'testabc@gmail.com', 'STAFF', 'IT SUPPORT', '22017262480', '0001424265603', 1, 0);

-- Dumping structure for table hrapp_karyawan.employee_history
CREATE TABLE IF NOT EXISTS `employee_history` (
  `id_history` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `comp_id` int DEFAULT NULL,
  `jabatan_terakhir` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `periode_masuk` date DEFAULT NULL,
  `periode_keluar` date DEFAULT NULL,
  `perubahan_status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_mutasi` int DEFAULT '0',
  PRIMARY KEY (`id_history`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.employee_history: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.emp_families
CREATE TABLE IF NOT EXISTS `emp_families` (
  `id_family` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `nama_suami_istri` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anak1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anak2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anak3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anak4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_family`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.emp_families: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.emp_personal
CREATE TABLE IF NOT EXISTS `emp_personal` (
  `id_personal` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `status_pernikahan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `agama` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `golongan_darah` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `npwp` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `npwp_pemadanan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `domisili` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_personal`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.emp_personal: ~160 rows (approximately)
INSERT INTO `emp_personal` (`id_personal`, `emp_id`, `tempat_lahir`, `tanggal_lahir`, `status_pernikahan`, `agama`, `gender`, `nik`, `golongan_darah`, `email`, `no_hp`, `npwp`, `npwp_pemadanan`, `domisili`) VALUES
	(1, 1, 'BUKIT TINGGI', '1969-07-21', 'Menikah', 'ISLAM', 'Laki-Laki', '3674012107690007', 'O', 'sumantri@zekindo.com', '0811-1901-167', NULL, NULL, 'Virginia Lagoon Blok B.3/10 Bsd,002/008,Lengkong Gudang,Serpong,Tangerang Selatan,Banten,'),
	(2, 2, 'PEMALANG', '1983-04-18', 'Menikah', 'ISLAM', 'Perempuan', '3276025804830015', 'A', 'hesti@acmechem.co.id', '0811-8693-013', NULL, NULL, 'Cluster Parthenon Blok N/A, Kota Deltamas, Sukamahi, Cikarang Pusat'),
	(3, 3, 'BEKASI', '1986-01-17', 'Menikah', 'ISLAM', 'Laki-Laki', '3216201701860002', 'A', 'edi.junaedi@zekindo.com', '0811-8693-015', NULL, NULL, 'Kp. Cimahi,003/002,Sukamahi,Cikarang Pusat,Bekasi,Jawa Barat,'),
	(4, 4, 'BEKASI', '1988-03-30', 'Menikah', 'ISLAM', 'Laki-Laki', '3216193003880001', 'N/A', 'asasubagjasubagja@gmail.com', '0811-8693-016', NULL, NULL, 'Kp. Cimahi,003/007,Pasirranji,Cikarang Pusat,Bekasi,Jawa Barat,'),
	(5, 5, 'BENGKULU', '1987-11-22', 'Belum Menikah', 'KRISTEN', 'Perempuan', '3216116211870003', 'A', 'fany_kurniawan87@yahoo.com', '0819-0674-4455', NULL, NULL, 'Jl. Gardenia Raya H/2 Cikarang Baru,003/011,Sertajaya,Cikarang Timur,Bekasi,Jawa Barat'),
	(6, 6, 'SUKOHARJO', '1988-06-25', 'Menikah', 'ISLAM', 'Laki-Laki', '3373022506880002', 'O', 'rindu.wahono@zekindo.com', '0812-8472-1745', NULL, NULL, 'Perumahan Puri Sentosa Blok A17 No. 11,003/006,Cicau,Cikarang Pusat,Bekasi,Jawa Barat'),
	(7, 7, 'BEKASI', '1985-05-15', 'Menikah', 'ISLAM', 'Laki-Laki', '3216201505850008', 'B', 'Warinnirwana@gmail.com', '0895-0412-2711', NULL, NULL, 'Kp. Paparean,007/004,Pasir Tanjung,Cikarang Pusat,Bekasi,Jawa Barat,'),
	(8, 8, 'BOGOR', '1986-04-10', 'Menikah', 'ISLAM', 'Laki-Laki', '3201061004860019', 'N/A', 'sairayulianti@gmail.com', '0858-8082-0704', NULL, NULL, 'Tegal Badak, Cilangkara, Serang Baru, Bekasi'),
	(9, 9, 'CILACAP', '1991-05-17', 'Menikah', 'ISLAM', 'Laki-Laki', '3301221705910004', 'B', 'adi.khafidh@acmechem.co.id', '0812-8788-5761', NULL, NULL, 'Cluster Roseville No E6 Deltamas Cikarang Pusat Kab Bekasi'),
	(10, 10, 'GARUT', '1994-12-09', 'Menikah', 'ISLAM', 'Laki-Laki', '3271050912940003', 'O', 'Ujefauzi46@gmail.com', '0898-7987-658', NULL, NULL, 'Perum Telaga Harmony Residence Blok E2 No. 44  Kec Serang Baru, Cikarang Selatan Kab Bekasi 17330'),
	(11, 11, 'MEDAN', '1989-12-03', 'Menikah', 'ISLAM', 'Perempuan', '3201374312890002', 'B', 'ika_arum03@yahoo.com', '0813-8263-9787', NULL, NULL, 'Serpong Jaya, Cluster The Height, Jl. The Height Vi, Blok He03, Serpong, Tangerang Selatan'),
	(12, 12, 'ACEH', '1992-10-24', 'Menikah', 'ISLAM', 'Perempuan', '3175096410920012', 'A', 'hanna.liyana@POWERINDO.co.id', '0852-6289-4649', NULL, NULL, 'Cluster Calgary Deltamas, Cikarang Pusat'),
	(13, 13, 'JAKARTA', '1977-02-09', 'Menikah', 'KATHOLIK', 'Laki-Laki', '3172010902770008', 'B', 'dhammaspratama@gmail.com', '0815-9164-991', NULL, NULL, 'Serpong Natura City Cluster Cattleya V No: 30, Jl. Serpong-Gunung Sindur, Ds. Pengasinan, Bogor'),
	(14, 14, 'P. BRANDAN', '1970-11-09', 'Menikah', 'KRISTEN', 'Perempuan', '3175074911700002', 'B', 'mery72gar@gmail.com', '0812-8217-0939', NULL, NULL, 'Taman Sentosa Blok D4 No.26,022/007,Pasir Sari,Cikarang Selatan,Bekasi,Jawa Barat,'),
	(15, 15, 'TEGAL', '1993-12-25', 'Menikah', 'ISLAM', 'Perempuan', '3328156512930008', 'B', NULL, '0857-4202-8494', NULL, NULL, 'Perum Puri Sentosa Blok A17 No.11,003/006,Cicau,Cikarang Pusat,Bekasi,Jawa Barat,'),
	(16, 16, 'KLATEN', '1995-01-07', 'Menikah', 'ISLAM', 'Perempuan', '3310174701950002', 'A', 'auliadc07@gmail.com', '0813-9128-3855', NULL, NULL, 'Jl. Melati 19 No 8, Taman Sari Puspa, Taman Lembah Hijau, Lippo Cikarang Selatan'),
	(17, 17, 'JAKARTA', '1994-03-17', 'Menikah', 'ISLAM', 'Laki-Laki', '3276041703940006', 'O', 'rhesa@zekindo.com', '0812-1000-555', NULL, NULL, 'Jl. Melati Lestari Indah Blok O No.5, Lebak Bulus, Jakarta Selatan 12440'),
	(18, 18, 'KARAWANG', '1976-09-09', 'Menikah', 'ISLAM', 'Laki-Laki', '3215271112730001', 'N/A', 'entis01sutisna@gmail.com', '0856-9335-6133', NULL, NULL, 'Perum Cikarang Utama Residence Jalan Kicau 7 Blok C5/5 Rt 031 Rw 013 Desa Jaya Sampurna Kec Serang Baru  Bekasi'),
	(19, 19, 'KARAWANG', '1998-08-26', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3215012608980004', 'A', 'adriansyahvirgiawan18@gmail.com', '0838-1475-3337', NULL, NULL, 'Kp. Gempol Rawa,011/003,Tanjungpura,Karawang Barat,Karawang,Jawa Barat,'),
	(20, 20, 'PURWOREJO', '1991-03-12', 'Menikah', 'ISLAM', 'Laki-Laki', '3275011203910024', 'N/A', 'sutrismiyanto12@gmail.com', '0819-9838-4562', NULL, NULL, 'Perum Pilar Mas Persada Blok B2 No. 3,002/008,Sukarukun,Sukatani,Bekasi,Jawa Barat,'),
	(21, 21, 'PEKANBARU', '1996-04-15', 'Menikah', 'ISLAM', 'Laki-Laki', '1471111504960002', 'B', 'alfino.rahel@acmechem.co.id', '0823-8599-4256', NULL, NULL, 'Serpong Garden 2, Cluster Green Land A12/73, Suradita, Cisauk, Kab. Tangerang'),
	(22, 22, 'JAKARTA', '1994-03-12', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3174061203940003', 'AB', 'martyram028@gmail.com', '0821-5439-6286', NULL, NULL, 'Kompleks Villa Delima, Blok E No19, Jl. Lebak Bulus, Jakarta Selatan'),
	(23, 23, 'BEKASI', '1999-07-15', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216201507990009', 'N/A', 'amung15071999@gmail.com', '0897-321-9750', NULL, NULL, 'Kp. Cimahi,004/007,Pasirranji,Cikarang Pusat,Bekasi,Jawa Barat,'),
	(24, 24, 'BEKASI', '1987-05-24', 'Menikah', 'ISLAM', 'Laki-Laki', '3216202405870003', 'N/A', 'inayatusaleha@gmail.com', '0896-1961-4006', NULL, NULL, 'Kp. Cimahi,005/003,Sukamahi,Cikarang Pusat,Bekasi,Jawa Barat'),
	(25, 25, 'KENDAL', '1991-04-03', 'Menikah', 'ISLAM', 'Perempuan', '3173014304910006', 'A', 'wiliswulandari@gmail.com', '0813-1113-6940', NULL, NULL, 'Kp Tajur,001/001,Tajur,Ciledug,Tangerang,Banten,'),
	(26, 26, 'BREBES', '1992-07-12', 'Menikah', 'ISLAM', 'Laki-Laki', '3329071207920003', 'N/A', 'djagalwawan@gmail.com', '0812-9162-5682', NULL, NULL, 'Perum Mutiara Sampurna Blok D2 No.18 Desa Jaya Sampurna Kecamatan Serang Baru Kabupaten Bekasi'),
	(27, 27, 'BEKASI', '1994-01-20', 'Belum Menikah', 'ISLAM', 'Perempuan', '3275016001940018', 'O', 'utariyunus@gmail.com', '0821-2198-3046', NULL, NULL, 'Perumahan Puri Lestari Blok H16/20 Jl. K.H. Asmawi No.1-6, Sukajaya, Kec. Cibitung, Bekasi, Jawa Barat 17520'),
	(28, 28, 'SERANG', '1990-09-10', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216091009900013', 'N/A', 'mourdanisusilo72@gmail.com', '0857-7652-6871', NULL, NULL, 'Kp. Sempu Gardu,004/002,Pasirgombong,Cikarang Utara,Bekasi,Jawa Barat'),
	(29, 29, 'BANDUNG', '1996-08-10', 'Belum Menikah', 'ISLAM', 'Perempuan', '3604015008960039', 'O', 'nadya.intan@zekindo.co.id', '0812-8045-1418', NULL, NULL, 'Perumahan Meadow Green Lippo Cikarang, Jl.Pinus 2 No.20 Kamar 11, Cikarang, 17550'),
	(30, 30, 'JAKARTA', '1998-01-17', 'Belum Menikah', 'ISLAM', 'Perempuan', '3275125701980003', 'O', 'nurulhrdhni17@gmail.com', '0812-9464-0306', NULL, NULL, 'Cluster Calgary Deltamas, Cikarang Pusat'),
	(31, 31, 'MAGELANG', '1996-06-09', 'Menikah', 'ISLAM', 'Laki-Laki', '1403090906960002', 'AB', 'gallomaskar@gmail.com', '0812-2221-9553', NULL, NULL, 'Jalan Melati 23 No.9, Taman Sari Puspa, Komplek Lembah Hijau, Kec. Cikarang Selatan'),
	(32, 32, 'JAKARTA', '1997-02-19', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3201041902970004', 'AB', 'andrea.gilang.f@gmail.com', '0812-1137-7303', NULL, NULL, 'Jalan Manggis Raya Blok Q23, Paku Alam, Serpong Utara, Tangerang Selatan, Banten 15320'),
	(33, 33, 'JAKARTA', '1998-03-23', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3603176303980007', 'AB', 'stellaavincatantra@gmail.com', '0812-8782-0850', NULL, NULL, 'Taman Osaka No 71, Lippo Karawaci, Kelurahan Binong, Kecamatan Curug, Kabupaten Tangerang, Banten 15810'),
	(34, 34, 'MAGELANG', '1997-08-19', 'Belum Menikah', 'ISLAM', 'Perempuan', '3308205908970006', 'B', 'gustinnuraniputri@gmail.com', '0856-4382-0913', NULL, NULL, 'Puri Sentosa Blok A16 No 2, Cikarang Pusat'),
	(35, 35, 'BANDUNG', '1994-03-24', 'Menikah', 'ISLAM', 'Laki-Laki', '3175072403941001', 'A', 'senna.ardiansyah@gmail.com', '0821-1629-2694', NULL, NULL, 'Perumahan Kireina Park, A3 No 2, Rt01/Rw15, Kelurahan Rawa Mekar Jaya, Kecamatan Serpong, Tangerang Selatan'),
	(36, 36, 'GROBOGAN', '1996-09-21', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3315132109960001', 'O', 'zainalarief123@gmail.com', '0896-7905-5986', NULL, NULL, 'Jl. Raya Kedasih 3 No. 97, Jababeka'),
	(37, 37, 'YOGYAKARTA', '1998-05-24', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1471082405980021', 'AB', 'dibyo_satriyoo@yahoo.com', '0813-3067-0121', NULL, NULL, 'Puri Sentosa Blok A20/1, Cicau, Cikarang Pusat, Kab. Bekasi, Jawa Barat\r\n17816"\r\n'),
	(38, 38, 'JAKARTA', '1998-04-04', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3276040404980001', 'B', 'iqbal040498@gmail.com', '0812-3285-1068', NULL, NULL, 'Jalan Kuta 3 Blok D4 Nomor 28 Graha Cinere Depok Jawa Barat'),
	(39, 39, 'PEKANBARU', '1999-02-21', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1408042102990011', 'AB', 'RAJIUL.FADLI@GMAIL.COM', '0811-7095-903', NULL, NULL, 'Jl. Gempol Raya Gg. Singkam No. 36A, Rt/Rw 001/010, Kunciran, Pinang, Kota Tangerang, Banten, 15143\r\n'),
	(40, 40, 'JAKARTA', '1998-03-04', 'Belum Menikah', 'ISLAM', 'Perempuan', '3175074403980006', 'B', 'safiranadilaputri@gmail.com', '0812-2501-3227', NULL, NULL, 'Cluster Calgary Deltamas, Cikarang Pusat'),
	(41, 41, 'JOMBANG', '1998-07-31', 'Belum Menikah', 'ISLAM', 'Perempuan', '3515177107980003', 'A', 'putriberliana17@gmail.com', '0812-3158-5705', NULL, NULL, 'Casa De Parco, Sampora, Kec. Cisauk, Tangerang, Banten 15346'),
	(42, 42, 'TASIKMALAYA', '1997-08-19', 'Menikah', 'ISLAM', 'Perempuan', '3278045908970015', 'O', 'karinfadillaa@gmail.com', '0813-2061-4652', NULL, NULL, 'Casa De Parco, Sampora, Kec. Cisauk, Tangerang, Banten 15346'),
	(43, 43, 'CILACAP', '1997-05-06', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3301060605970001', 'O', 'ridholuthfi77@gmail.com', '0821-4754-8350', NULL, NULL, 'Kos Wisma Raya 1\r\nJl. Villa Mutiara No.14, Ciantra, Cikarang Sel., Bekasi, Jawa Barat 17530'),
	(44, 44, 'BANDAR LAMPUNG', '1999-06-25', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3604016506990999', 'O', 'pricilia.florentina@gmail.com', '0812-8023-3695', NULL, NULL, 'Casa De Parco, Sampora, Kec. Cisauk, Tangerang, Banten 15346'),
	(45, 45, 'PALEMBANG', '2000-04-03', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3201130304000001', 'O', 'gib2000.mail@gmail.com', '0811-1149-993', NULL, NULL, 'Jalan Roseville VII Blok H-31, Cluster Roseville, Zona Amerika Kota Deltamas, Kel. Pasiranji, Kec. Cikarang Pusat, Kab. Bekasi'),
	(46, 46, 'TANGERANG', '1999-01-19', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3674031901990001', 'O', 'rizqiaffana@gmail.com', '0858-8226-2607', NULL, NULL, 'Jl. Titihan VI Blok HF 13 No. 20 Permata Bintaro, RT 004/RW 008, Kel. Parigi, Kec. Pondok Aren, Kota Tangerang Selatan, Banten'),
	(47, 47, 'JAKARTA', '1999-08-14', 'Belum Menikah', 'ISLAM', 'Perempuan', '3276055408990010', 'O', 'salsabilamuthiah@yahoo.co.id', '0858-8319-2921', NULL, NULL, 'Jl. Tirta Kencana 3 No.38, Cibatu, Cikarang Selatan, \r\nBekasi, Jawa Barat\r\n'),
	(48, 48, 'GRESIK', '1999-06-20', 'Belum Menikah', 'ISLAM', 'Perempuan', '3525102006990001', 'B', 'balqisnabila31@gmail.com', '0878-5574-1419', NULL, NULL, 'Jalan Tirta Kencana 3 no. 38, cibatu, cikarang selatan, bekasi'),
	(49, 49, 'BEKASI', '2000-08-30', 'Belum Menikah', 'KRISTEN', 'Perempuan', '3216077008000006', 'B', 'odeliaelsa30@gmail.com', '0812-9785-8166', NULL, NULL, 'Cluster Limonia blok L1 no 30, Metland Tambun, Tambun Selatan, Kab. Bekasi'),
	(50, 50, 'BEKASI', '1999-08-10', 'Belum Menikah', 'ISLAM', 'Perempuan', '3275055008990016', 'A', 'milleniarahmaf@gmail.com', '0812-9946-5214', NULL, NULL, 'Jl. Kedasih VIII, Mekarmukti, Kec. Cikarang Utara, Kab. Bekasi, Jawa Barat'),
	(51, 51, 'SURAKARTA', '1998-02-19', 'Belum Menikah', 'KRISTEN', 'Laki-Laki', '3372041902980002', 'O', 'faitha.fafa@gmail.com', '0822-2130-3475', NULL, NULL, 'Jl. Perintis Kemerdekaan No. 1 RT 005/ RW 003, Kel. Babakan, Kec. Tangerang, Kota Tangerang, Banten 15118'),
	(52, 52, 'KEBUMEN', '1979-11-01', 'Menikah', 'ISLAM', 'Laki-Laki', '3603120111790008', 'N/A', 'iswad1@yahoo.co.id', '0857-7334-6400', NULL, NULL, 'Kp.Pulo.Kel.Sukaraya.Rt.05/Rw 03.Kec.Karang Bahagia.Cikarang Utara.Bekasi Jawa Barat'),
	(53, 53, 'SURABAYA', '1998-10-31', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3302197110980005', 'B', 'xenaindi31@gmail.com', '0812-2985-2305', NULL, NULL, 'Jalan Tapir V N3 No 3-5 Taman Gerbera Perumahan Cikarang Baru, Rt005/Rw010, Desa Jayamukti, Cikarang Pusat, Bekasi, Jawa Barat 17815'),
	(54, 54, 'AMBON', '1999-05-25', 'Belum Menikah', 'KRISTEN', 'Perempuan', '1216066505990004', 'O', 'mega.sigalingging25@gmail.com', '0822-6236-6551', NULL, NULL, 'JL Komplek sekneg blok E8 no 24, RT 016/RW 003, Kel. Penunggangan Utara, Kec. Pinang, Kota Tangerang, Banten'),
	(55, 55, 'SIDOARJO', '1999-06-24', 'Belum Menikah', 'ISLAM', 'Perempuan', '3515036406990002', 'O', 'nurcahya726@gmail.com', '0812-2354-0641', NULL, NULL, 'Jl. Singa II Blok T4 RT.003/009 No 60 Desa Jayamukti Kecamatan Cikarang Pusat, Kabupaten Bekasi Jawa Barat 17530'),
	(56, 56, 'BEKASI', '2000-02-16', 'Belum Menikah', 'ISLAM', 'Perempuan', '3275045602000008', 'O', 'khalisha.qatrunnada@gmail.com', '0813-1028-3626', NULL, NULL, 'Apartemen Casa De Parco, Tower Orchidea, 26/6'),
	(57, 57, 'BANDUNG', '1995-11-26', 'Belum Menikah', 'ISLAM', 'Perempuan', '3273086611950001', 'A', 'Fannicadaina@gmail.com', '0878-2580-2288', NULL, NULL, 'Cluster Meadow Green Jalan Cemara Ii No 88 Lippo Cikarang'),
	(58, 58, 'TANGERANG', '2000-11-08', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3671084811000005', 'A', 'natasyapang@gmail.com', '0812-9122-1929', NULL, NULL, 'Perumahan Illago, Cluster Fiordini Blok FIB No. 11, Gading Serpong, Tangerang, Banten'),
	(59, 59, 'BANDUNG', '2000-11-25', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3273246511000003', 'O', 'sellypramesti@gmail.com', '0821-2615-7144', NULL, NULL, 'Perumahan Griya Indah Cikampek Blok F3 no. 8'),
	(60, 60, 'JAKARTA', '1999-12-22', 'Belum Menikah', 'ISLAM', 'Perempuan', '3216066212990026', 'B', 'permatasalsabilla.ps@gmail.com', '0895-1581-4388', NULL, NULL, 'Jl Hirup Raya Kp Rawa Sapi No 132 Rt/Rw 003/ 010 Jatimulya, Tambun Selatan, Bekasi'),
	(61, 61, 'MEDAN', '1998-12-11', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3275041112980010', 'N/A', 'muhgilangnurul@gmail.com', '0822-9917-7265', NULL, NULL, 'Jl. Sersan Idris Dlm No.89002/004,Margajaya,Bekasi Selatan,Bekasi,Jawa Barat'),
	(62, 62, 'PURWOREJO', '1999-05-11', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3276061105990004', 'A', 'yusufazzams21@gmail.com', '0812-8425-2415', NULL, NULL, 'Jl. Garuda Raya, No. 105, RT 002/RW 001, Kel. Beji Timur, Kec. Beji, Kot. Depok, Jawa Barat'),
	(63, 63, 'PATI', '2001-10-02', 'Belum Menikah', 'KRISTEN', 'Perempuan', '3318084210010001', 'B', 'priskillabuna@gmail.com', '0813-5914-0790', NULL, NULL, 'Jl. Irigasi No. 92 B RT/RW 02/04, Kp. Rw. Sentul Sertajaya, Kec. Cikarang Timur, Bekasi, Jawa Barat 17530'),
	(64, 64, 'MALANG', '1996-12-12', 'Belum Menikah', 'KRISTEN', 'Perempuan', '3573035212960003', 'B', 'ctiatira@gmail.com', '0822-5734-1581', NULL, NULL, 'Perumahan Saraswati Gang Baladewa B-45, Cikampek Selatan, Kec. Cikampek, Karawang, Jawa Barat'),
	(65, 65, 'BANDAR LAMPUNG', '1999-09-01', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1871010109990009', 'AB', 'kubillah.benta@yahoo.com', '0898-2392-927', NULL, NULL, 'Jl. Puri Maerakaca Blok P2 No 21,017/000,Perumnas Way Halim,Way Halim,Bandar Lampung,Lampung'),
	(66, 66, 'JAKARTA', '1998-08-16', 'Belum Menikah', 'ISLAM', 'Perempuan', '3602205608980001', 'B', 'christyericayang@gmail.com', '0858-7676-7694', NULL, NULL, 'Jl. Kasuari VII Blok D No.28 Cikarang Baru Kab. Bekasi Jawa Barat'),
	(67, 67, 'TEGAL', '2000-05-01', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3328060105000002', 'N/A', 'ardi.irawan152000@gmail.com', '0857-8126-5122', NULL, NULL, 'Jl. Raya Industri Pasir Gombong, Kontrakan Hj Tiun No 9 Atas, Gang Unyut Rt 05 Rw 06 Kab. Bekasi - Cikarang Utara, Jawa Barat. Id 17831'),
	(68, 68, 'BREBES', '2000-11-12', 'Belum Menikah', 'ISLAM', 'Perempuan', '3375035211000001', 'O', 'nabiilahsalsabiil@gmail.com', '085-869-100-546', NULL, NULL, 'Perumahan Graha Tirto Asri Jl. Melati No.14, Tanjung, Tirto, Kab. Pekalongan, Jawa Tengah'),
	(69, 69, 'GUNUNGKIDUL', '1990-06-11', 'Cerai Hidup', 'ISLAM', 'Laki-Laki', '3403111106900002', 'N/A', 'adziesaputra@yahoo.co.id', '0822-4464-9544', NULL, NULL, 'Yogyakarta'),
	(70, 70, 'MADIUN', '1998-03-28', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '5171022803980003', 'AB', 'FATHULISLAM.MUHAMMAD@GMAIL.COM', '0878-2205-0439', NULL, NULL, 'Jl. Singa I No.T2/29, Jayamukti, Kec. Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530'),
	(71, 71, 'CILACAP', '2000-05-05', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3301150505000004', 'O', 'Alwyassegaf05@gmail.com', '0823-2908-0628', NULL, NULL, 'Jl.Bakilong Rt 04 Rw 02 Komplek H.Ocim  Ds.Sukadami Serang Baru Cikarang Selatan'),
	(72, 72, 'BATU, MALANG', '2000-03-20', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3579012903000002', 'A', 'farhan.11.aji@gmail.com', '0852-3091-5776', NULL, NULL, 'Jl Roseville VI Blok H2, Cluster Roseville, Deltamas, Cikarang Pusat, Kab Bekasi, 17530'),
	(73, 73, 'TASIKMALAYA', '1997-09-16', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216065609970024', 'O', 'ulfahf16@gmail.com', '0896-7024-6578', NULL, NULL, 'Grand Kertamukti Residence blok E9 No.29, RT.002/RW.025, Ds. Kertamukti, Kec. Cibitung, Bekasi 17520\r\n'),
	(74, 74, 'BEKASI', '1995-07-01', 'Menikah', 'ISLAM', 'Laki-Laki', '3216200107950027', 'N/A', 'nurhadajaelani@gmail.com', '0896-5309-3449', NULL, NULL, 'Kp Cimahi Rt 03 Rw 02 Desa Sukamahi Kec.Cikarang Pusat Kab.Bekasi'),
	(75, 75, 'CIREBON', '2000-11-15', 'Belum Menikah', 'ISLAM', 'Perempuan', '3209065511000005', 'A', 'ainun.esra15@gmail.com', '0853-1534-1637', NULL, NULL, 'Jalan Deltamas Boulevard, Nomor 12, Sukamahi, Kec. Cikarang Pusat, Cikarang Pusat, Jawa Barat 17530\r\n'),
	(76, 76, 'BANDUNG', '2000-04-25', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3273072504000001', 'O', 'deden.danisaputra@gmail.com', '0831-0956-8607', NULL, NULL, 'Jalan Sukajadi Dalam No.556/182A, RT 005/RW 012, Kel. Pasteur, Kec. Sukajadi, Kota Bandung, Jawa Barat'),
	(77, 77, 'JAKARTA PUSAT', '1997-08-13', 'Belum Menikah', 'KRISTEN', 'Perempuan', '3374115308970001', 'A', 'amelianaomiagustina@gmail.com', '0813-2766-2461', NULL, NULL, 'DUTA ELOK NO. 5 DUTA BUKIT MAS,003/009,BANYUMANIK,BANYUMANIK,KOTA SEMARANG,JAWA BARAT'),
	(78, 78, 'JAMBI', '1998-12-29', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1405022912980003', 'B', 'fathoni.hidayat198@gmail.com', '0812-7094-9010', NULL, NULL, 'Jl. William Iskandar No. 234, Pasar Baru, Kel. Sipolu Polu, Kec. Panyabungan, Kab. Mandailing Natal, Sumatera Utara'),
	(79, 79, 'PASURUAN', '2003-03-20', 'Belum Menikah', 'ISLAM', 'Perempuan', '3575026003000001', 'AB', 'adibahqonitanti@gmail.com', '082338624458', NULL, NULL, 'Jl. Tripraja no 99 Kp. Sawah dalam rt 03 rw 05 kelurahan Penunggangan Utara kecamatan pinang Kota Tangerang Banten 15143\r\n'),
	(80, 80, 'NGANJUK', '1990-09-07', 'Menikah', 'ISLAM', 'Laki-Laki', '6471040709900001', 'A', 'septianherdiyanto9@gmail.com', '0852-4619-8178', NULL, NULL, 'JL PERUM SOMBER INDAH BLOK D NO 46 RT 68 GANG FAYAKUN IV BALIKPAPAN UTARA, KALIMANTAN TIMUR'),
	(81, 81, 'PEMALANG', '1998-10-10', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3327111010980005', 'N/A', 'miftahfarid.10ta@gmail.com', '0821-1499-2262', NULL, NULL, 'Kp. Mariuk Rt 002 Rw 003 Kelurahan Gandasari Kecamatan Cikarang Barat Kabupaten Bekasi'),
	(82, 82, 'MEDAN', '2001-07-04', 'Belum Menikah', 'ISLAM', 'Perempuan', '1271094407010001', 'O', 'lutfiahir@gmail.com', '0822-8504-4512', NULL, NULL, 'Jl. Babakan Sembung No. 95B'),
	(83, 83, 'JAKARTA', '1998-08-08', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216080808980007', 'O', 'dennylmn98@gmail.com', '0812-1113-5658', NULL, NULL, 'Perumahan Depsos Blok B7 No.19 008/008 Telaga Asih Cikarang Barat Kab.Bekasi'),
	(84, 84, 'BANYUMAS', '2001-08-30', 'Belum Menikah', 'ISLAM', 'Perempuan', '3174017008011001', 'A', 'auradwisaputri@gmail.com', '0858-9215-1315', NULL, NULL, 'JALAN EDI SANTOSO NO 68, RT 04 RW 07, RATU JAYA, CIPAYUNG, DEPOK'),
	(85, 85, 'BEKASI', '2001-02-10', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216211002010002\r\n', 'N/A', 'asepazharullahasep445@gmail.com', '0857-8294-9029', NULL, NULL, 'Kp Pasir Pogor Kecamatan Serang Baru Kabupaten Bekasi Rt/09 Rw/05'),
	(86, 86, 'MAGELANG', '2001-11-23', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3308152311010002', 'B', 'aatzakimubarok@gmail.com', '0815-7838-9942', NULL, NULL, 'Gang Gewung No.28, RT 001/RW 013, Desa Cicau, Kec. Cikarang Pusat, Kabupaten Bekasi, Jawa Barat.'),
	(87, 87, 'SEMARANG', '2001-06-26', 'Belum Menikah', 'KRISTEN', 'Perempuan', '3172066606010003', 'B', 'kpannyavara@gmail.com', '0822-2564-7544', NULL, NULL, '-'),
	(88, 87, 'PALEMBANG', '2001-03-24', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1671022403010005', 'B', 'fadhiladli98@gmail.com', '0813-2009-6169', NULL, NULL, 'Perum Opi, Opi 3 Kutilang 1 Blok E no 32, RT 040/RW 013, Kel. 15 Ulu , Kec. Seberang Ulu 1, Kota. Palembang, Sumatera Selatan'),
	(89, 89, 'BANDAR JAYA', '2001-11-08', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1871010811010002', 'A', 'muhkhusnulkholuq@gmail.com', '0896-3218-6095', NULL, NULL, 'GRIYA BANDUNG ASRI 2 BLOK D4 No 10, RT 03, RW 09, Bojongsoang, Kab. Bandung, Jawa Barat'),
	(90, 90, 'SURAKARTA', '1999-10-15', 'Belum menikah', 'ISLAM', 'Laki-Laki', '3404121510990005', 'AB', 'abyandandi99@gmail.com', '0898-9264-696', NULL, NULL, 'Jl. Anggrek No.46, RT.8/RW.2, Kelapa Dua, Kec. Kebon Jeruk, Kota Jakarta Barat, DKI Jakarta'),
	(91, 91, 'JAKARTA', '2000-08-07', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3603280708000007', 'O', 'lutfanakbar7@gmail.com', '0812-8080-3460', NULL, NULL, 'JL. ZAITUN IV NO. 4 ISLAMIC VILLAGE,003/014,KELAPA DUA,KELAPA DUA,TANGERANG,BANTEN'),
	(92, 92, 'JAKARTA ', '1997-10-22', 'Belum Menikah', 'ISLAM', 'Perempuan', '3172036210970006', 'B', 'utarishintya@gmail.com', '0821-1338-3043', NULL, NULL, '(Kontrakan Bpk. Komar) Jl. Kp. Cikuya, Cicau, Kec. Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530'),
	(93, 93, 'SURABAYA', '1999-02-20', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3173056002990001', 'B', 'gabrielacarissa@gmail.com', '0812-1010-7023', NULL, NULL, 'Jl. Rasamala Raya No. 3A, RT 005/RW 003, Kel. Jatipulo, Kec. Palmerah, Kota Jakarta Barat, DKI Jakarta'),
	(94, 944, 'JAKARTA', '2000-02-19', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1271021902000005', 'O', 'poetra.harsa@gmail.com', '0813-9857-0280', NULL, NULL, 'Rukita Bless Studento, Perumahan Foresta Cluster Studento Blok L15 No. 1, BSD City, Kabupaten, Pagedangan, Kec. Pagedangan, Kabupaten Tangerang, Banten 15339'),
	(95, 95, 'PEMALANG', '1999-08-20', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3327112008990004', 'A', 'dicky.hermawan2089@gmail.com', '0857-4302-1864', '1234343343', '33271120089990004', 'Perumahan Buana Taman Sari Raya Blok G4 No.1, Kelurahan Kondang Jaya, Kec. Karawang Timur, Karawang, Jawa Barat'),
	(96, 96, 'KAWAWANG', '1993-09-07', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3215220709930001', 'N/A', 'rojaligojali1@gmail.com', '0813-1184-2861', NULL, NULL, 'Kampung Cijambe,RT 004/Rw002,Desa Sukadami,Cikarang Selatan Kontrakan Haji Ocim No 14'),
	(97, 97, 'JAKARTA', '2000-12-12', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3175011212000004', 'B', 'mhmdhisyam21@gmail.com', '0856-9564-7417', NULL, NULL, 'Jalan Industri Utara IV Blok A5 No. 1-3 Jababeka, Cikarang'),
	(98, 98, 'BOGOR', '2001-03-01', 'Belum Menikah', 'ISLAM', 'Perempuan', '3271064103010006', 'A', 'tyanindita@gmail.com', '0815 -8408-2142', NULL, NULL, 'Jl Hanjuang Raya Blok C5 No 20 SektorÂ 1-1Â BSD'),
	(99, 99, 'BANYUWANGI', '2001-01-15', 'Belum Menikah', 'ISLAM', 'Perempuan', '3510095501010000', 'O', 'sekarsarilmy@gmail.com', '0851-5638-1571', NULL, NULL, 'Jln.Rasuna Said No 51 Komplek kost Gapura Merah putih Rt 06/05 Kel.Panunggangan Utara\nKec.Pinang Kota Tangerang 15143\n'),
	(100, 100, 'YOGYAKARTA', '2000-11-25', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216062511000020', 'B', 'shodiqyusti25@gmail.com', '0812-8271-5445', NULL, NULL, 'Jl. Saraswati No.. 41, Cikampek Selatan, Kec. Cikampek, Karawang, Jawa Barat'),
	(101, 101, 'GROBOGAN', '2000-10-14', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3315131410000001', 'B', 'azizghoffar7@gmail.com', '0895-3925-71904', NULL, NULL, 'Puri sentosa A17/11 Cicau, Cikarang Pusat'),
	(102, 102, 'LUBUK LINGGAU', '2002-03-18', 'Belum Menikah', 'ISLAM', 'Perempuan', '1605215803020003', 'O', 'tiaranadyaya@gmail.com', '0821-8260-5801', NULL, NULL, 'Palm Town House Residence'),
	(103, 158, 'KOTA TANGERANG', '2001-07-26', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3671092607010003', 'B', 'shergiorizkyputra@gmail.com', '0877-8554-5189', NULL, NULL, 'Jalan Pepaya Raya No. 124, RT/RW 005/006, Kel. Cibodasari, Kec. Cibodas, Kota Tangerang, Banten 15138'),
	(104, 103, 'BLORA', '1962-04-01', 'Menikah', 'KATHOLIK', 'Laki-Laki', '3275040104620011', 'B', NULL, '0811-1762-91', NULL, NULL, 'Pondok Surya Mandala Blok C1 No.13,004/013,Jaka Mulya,Bekasi Selatan,Bekasi,-,Jawa Barat,'),
	(105, 104, 'SEMARANG', '1962-09-02', 'Menikah', 'ISLAM', 'Laki-Laki', '3674010209620002', 'A', 'istiyarso_ir@yahoo.com', '0812-4420-9955', NULL, NULL, 'Bsd Sektor Ii-3 Blok Al/ 28 Anggrek Loka,001/015,Rawa Buntu,Serpong,Kota Tangerang Selatan,-,Banten'),
	(106, 105, 'BOGOR', '1992-03-19', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3201041903920004', 'O', 'rifkyrangkuty@gmail.com', '0822-1153-7563', NULL, NULL, 'Jl. Katulampa No.28,003/019,Katulampa,Bogor Timur,Bogor,Jawa Barat'),
	(107, 106, 'NEGARA TULANG BAWANG', '1997-05-09', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '1803160905970003', 'N/A', NULL, '0813-9999-5323', NULL, NULL, 'Jl. Kancil,006/004,Negara Tulang Bawang,Bunga Mayang,Lampung Utara,Lampung'),
	(108, 107, 'WONOSOBO', '1952-09-25', 'Menikah', 'ISLAM', 'Laki-Laki', '3674062509520007', 'B', 'sosroatmodjo@gmail.com', '0811-8898 -02', NULL, NULL, 'Jl. H. Saleh No 2,002/002,Benda Baru,Pamulang,Tangerang Selatan,Banten'),
	(109, 108, 'TUMALE', '1994-11-20', 'Belum Menikah', 'KRISTEN', 'Laki-Laki', '7317112011940001', 'O', 'sdenifrans@gmail.com', '0813-9825-4724', NULL, NULL, 'Perumahan Giya Indah Cikampek, Cluster Rafflesia Blok F5 No. 21 RT014/RW 006, Kalihurip, Kec. Cikampek, Kab. Karawang, Jawa Barat'),
	(110, 109, 'MADIUN', '1967-02-10', 'Menikah', 'ISLAM', 'Laki-Laki', '3174081002670001', 'B', 'pomad1719@gmail.com', '0819-0500-0272', NULL, NULL, 'Komplek Puriwijaya No.5, Rt011/Rw01, Kel.Pondok Betung, Kec.Pondok Aren, Tangerang Selatan, Banten 15221'),
	(111, 110, 'TANGERANG', '1982-04-05', 'Menikah', 'ISLAM', 'Perempuan', '3671114504820008', 'N/A', 'Lindaevayanil@gmail.com', '0878-0403-9621', NULL, NULL, 'Kunciran Jaya,006/002,Kunciran Jaya,Pinang,Kota Tangerang,-,Banten'),
	(112, 111, 'BG. SIAPI API', '1973-07-06', 'Menikah', 'BUDHA', 'Perempuan', '3172014607730006', 'A', 'evirna_yang@hotmail.com', '0812-8210-0571', NULL, NULL, 'Virginia Lagoon Blok B3 No.11 Bsd City'),
	(113, 112, 'KUDUS', '1968-07-31', 'Menikah', 'KATHOLIK', 'Laki-Laki', '3674023107680007', 'A', NULL, '0815-8680-9747', NULL, NULL, 'Sutera Delima Iv No.8,004/010,Pondok Jagung,Serpong Utara,Tangerang Selatan,Banten'),
	(114, 113, 'JAKARTA', '1972-01-22', 'Menikah', 'ISLAM', 'Perempuan', '3674016201720007', 'B', 'yana@zekindo.com', '0811-9626-573', NULL, NULL, 'Virginia Lagoon Blok B.3/10 Bsd,002/008,Lengkong Gudang,Serpong,Tangerang,Banten Selatan'),
	(115, 114, 'PURWOREJO', '1997-04-10', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3306051004970001', 'N/A', 'nursyamsudin104@gmail.com', '0815-8484-5442', NULL, NULL, 'Perum Pilar Mas Persada Blok B.02 No.3 Rt.02 Rw.08 Desa Sukarukun,Kec.Sukatani,Kab.Bekasi'),
	(116, 115, 'BEKASI', '1999-09-08', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216210809990006', 'N/A', 'Cevinawawi48@gmail.com', '0857-1772-3495', NULL, NULL, NULL),
	(117, 116, 'BEKASI', '1997-11-17', 'Menikah', 'ISLAM', 'Laki-Laki', '3216200602970003', 'N/A', 'gunipri1123@gmail.com', '0897-9039-662', NULL, NULL, 'Kp. Paparean Rt/Rw 004/003 Desa Pasirtanjung Kecamatan Cikarang Pusat.'),
	(118, 117, 'KARAWANG', '1998-05-15', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3215011505980002', 'N/A', 'denyray621@gmail.com', '0815-7815-2310', NULL, NULL, 'KP. UPAS BUNIAGA008/003TANJUNG MEKARKARAWANG BARATKARAWANGJAWABARAT'),
	(119, 118, 'TEGAL', '2001-04-20', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3328032004020005', 'N/A', 'nazimtere.2112@gmail.com', '0821-1309-1487', NULL, NULL, 'DS. PASIR GOMBONG001/005TUWISCIKARANG UTARA BEKASI JAWA BARAT'),
	(120, 119, 'KEBUMEN', '2000-05-26', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3305142605000006', 'B', 'faizalardien78@gmail.com', '0896-0614-1451', NULL, NULL, 'Ds. Sukadami Rt 04 / Rw 02 Kec. Cikarang Selatan Kab. Bekasi'),
	(121, 120, 'CILACAP', '1997-09-21', 'Menikah', 'ISLAM', 'Perempuan', '3301066109970001', 'O', 'septiembriani1267@gmail.com', '0812-3955-3365', NULL, NULL, 'Jalan Villa Mutiara No. 14, Ciantra, Cikarang Selatan, Kab. Bekasi 17530'),
	(122, 121, 'PULAU PANGGUNG ENIM', '2000-10-02', 'Belum Menikah', 'ISLAM', 'Perempuan', '1603014210000004', 'N/A', 'widiyatriutamaa@gmail.com', '083898303703', NULL, NULL, NULL),
	(123, 122, 'CIANJUR', '1967-03-06', 'Menikah', 'ISLAM', 'Perempuan', '3603284603670015', 'O', 'ema.halimah@gmail.com', '082125612250', NULL, NULL, 'Villa Rizki Ilhami Blok B8 no.22, RT007/RW035, Kel. Bojong Nangka, Kec.Kelapa Dua, Kab. Tangerang, Banten'),
	(124, 123, 'SURABAYA', '1972-07-09', 'Menikah', 'KRISTEN', 'Laki-Laki', '3578200907720003', 'N/A', 'kusmiadi971@gmail.com', '0822-5250-3178', NULL, NULL, NULL),
	(125, 124, 'BLITAR', '1987-07-05', 'Menikah', 'ISLAM', 'Laki-Laki', '3505160507870002', 'AB', 'nurhabib.champion@gmail.com ', '0852-5051-3063', NULL, NULL, 'JL.BUBUTAN NO 46 RT 15, GUNUNG SAMARINDA, BALIKPAPAN UTARA '),
	(126, 125, 'MALLINRUNG', '1985-01-13', 'Menikah', 'ISLAM', 'Laki-Laki', '7308211301850001', 'AB', 'yusri.champion@yahoo.com', '0812-3692-7857', NULL, NULL, 'JL. A. MALLA BTN BONE BIRU INDAH PERMAI D1.52'),
	(127, 126, 'OEKIU', '1983-02-06', 'Belum Menikah', 'KRISTEN', 'Laki-Laki', '5302010602830002', 'A', 'vederisonisu@gmail.com', '0852-5932-3077', NULL, NULL, 'PERUMAHAN BATU AMPAR LESTARI BLOK D1. NO. 21 KELURAHAN BATU AMPAR KECAMATAN BALIKPAPAN UTARA KOTA BALIKPAPAN'),
	(128, 127, 'CIREBON', '1968-04-05', 'Menikah', 'ISLAM', 'Laki-Laki', '3274020504680001', 'B', 'budi.kurniaw@gmail..com', '0812-6887-810', NULL, NULL, NULL),
	(129, 128, 'CIAMIS', '2000-01-11', 'Belum Menikah', 'ISLAM', 'Perempuan', '3215135101000007', 'O', 'mandaazkia1@gmail.com', '0812-8533-4238', NULL, NULL, 'DUSUN JATIRASA,003/006,CIKAMPEK TIMUR,CIKAMPEK,KARAWANG,JAWA BARAT'),
	(130, 129, 'CILEGON', '1998-07-31', 'Belum Menikah', 'ISLAM', 'Perempuan', '3672027107980001', 'AB', 'almaidayulianti@gmail.com', '0878-2503-8296', NULL, NULL, 'Jl Azalea 1 no 166 perum taman lembah hijau lippo cikarang, serang, cikarang selatan \r\nBekasi 17530\r\n'),
	(131, 130, 'SUKADAMAI', '1995-03-26', 'Menikah', 'ISLAM', 'Laki-Laki', '3306042603950002', 'N/A', 'fapjaja@gmail.com', '085715746711', NULL, NULL, 'perum kota baru permai 2 kecamatan kota baru kabupaten karawang'),
	(132, 131, 'SUKOHARJO', '1987-03-27', 'Menikah', 'ISLAM', 'Laki-Laki', '3311072703870003', 'A', 'andichampionbpp@yahoo.com', '0857-5250-6826', NULL, NULL, 'Jalan Mulawarman, Rt. 059 No. 191 Sepinggan Balikpapan'),
	(133, 132, 'MALLINRUNG', '1976-10-17', 'Menikah', 'ISLAM', 'Laki-Laki', '6472021710760001', 'A', 'din76sahar@gmail.com', '0857-9620-2514', NULL, NULL, 'MASSAILE, Mallinrung rt005/rw001 Kec. Libureng Kab. Bone SulSel'),
	(134, 133, 'PURWAKARTA', '1995-12-29', 'Menikah', 'ISLAM', 'Laki-Laki', '3214052912950001', 'N/A', NULL, '0838-1776-4365\r\n', NULL, NULL, 'Kp. Warung Kandang, 016/004 Kel. Sindang Sari Kec. Plered Kab, Purwakarta'),
	(135, 134, 'JAKARTA', '1983-11-19', 'Menikah', 'ISLAM', 'Laki-Laki', '3174011911830003', 'N/A', NULL, '0878-8186-3982', NULL, NULL, 'Kp. Wanareja, 001/001 Kel. Wanareka Kec. Subang Kab. Bekasi'),
	(136, 135, 'JAKARTA', '1994-07-27', 'Menikah', 'ISLAM', 'Laki-Laki', '3174032707940005', 'O', 'rahmatrahmath@gmail.com', '0877-8191-0061', NULL, NULL, NULL),
	(137, 136, 'PEMALANG', '1973-04-12', 'Menikah', 'ISLAM', 'Laki-Laki', '3215011204730009', 'O', NULL, '0857-7965-9233', NULL, NULL, 'KP. UPAS BUNIAGA,008/003,TANJUNG MEKAR,KARAWANG BARAT,KARAWANG,JAWA BARAT'),
	(138, 137, 'BEKASI', '1990-02-04', 'Menikah', 'ISLAM', 'Laki-Laki', '3216100402900005', 'N/A', NULL, '0895-0627-5722', NULL, NULL, 'KP. PULO BAMBU,015/006,KARANG SENTOSA,KARANG BAHAGIA,BEKASI,JAWA BARAT'),
	(139, 138, 'BOGOR', '1986-10-04', 'Menikah', 'ISLAM', 'Laki-Laki', '3201060410860001', 'N/A', 'nifalrian3@gmail.com', '0857-1115-5564', NULL, NULL, NULL),
	(140, 139, 'KARAWANG', '1997-04-30', NULL, 'ISLAM', 'Laki-Laki', '3215233004970002', 'N/A', NULL, '0857-1547-7716', NULL, NULL, NULL),
	(141, 140, 'SUBANG', '1992-10-20', 'Menikah', 'ISLAM', 'Laki-Laki', '3213092410910001', 'N/A', 'cdra3027@gmail.com', '0838-1678-6884', NULL, NULL, NULL),
	(142, 141, NULL, NULL, NULL, 'ISLAM', 'Laki-Laki', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(143, 142, 'PURWAKARTA', '2002-06-10', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3214121006020004', 'N/A', 'sobrayobet@gmail.com', '081280572179', NULL, NULL, 'KP.GANDASOLI,014/003,CIGELAM,BABAKANCIKAO,PURWAKARTA,JAWA BARAT'),
	(144, 143, 'BEKASI', '1991-07-27', 'Menikah', 'ISLAM', 'Perempuan', '3216216707910004', 'N/A', 'rosmawatiii2020@gmail.com', '0895-3302-43969', NULL, NULL, 'Kp. Tegal Badak,010/005,Nagasari,Serang Baru,Bekasi,,Jawa Barat,'),
	(145, 144, 'PURWAKARTA', '1983-03-04', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3214120403830003', 'N/A', 'shalwamoet@gmail.com', '0877-7873-2992', NULL, NULL, 'Sama dengan KTP'),
	(146, 145, 'BEKASI', '1981-04-21', 'Menikah', 'ISLAM', 'Laki-Laki', '3215272104810001', 'N/A', 'amansuharmanto@gmail.com', '0838-0819-7947', NULL, NULL, 'Dsn Ranca Sepat Rt 02 01 Ds Mulya Jaya Kec Teluk Jambe Barat'),
	(147, 146, 'BEKASI', '1994-10-10', 'Menikah', 'ISLAM', 'Laki-Laki', '3216201010940002', 'N/A', NULL, '0896-8391-6049', NULL, NULL, NULL),
	(148, 147, 'SUKABUMI', '2002-08-16', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3275071608020001', 'O', 'bilalhbtllh16@gmail.com', '082117231021', NULL, NULL, 'Pondok Pesantren Al Mushlih, Jl. Sukagalih, RT.10/RW.04, Telukjambe, Telukjambe Timur, Karawang, Jawa Barat 41361'),
	(149, 148, 'MALANG', '2002-05-14', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3514195405020001', 'A', 'anastasiakarinakusuma@gmail.com', '0857-9163-7385', NULL, NULL, 'Carribean'),
	(150, 149, 'SIDOARJO', '2002-06-12', 'Belum Menikah', 'KATHOLIK', 'Perempuan', '3578095206020004', 'A', 'rindawardhani17@gmail.com', '0819-3231-2461', NULL, NULL, 'Carribean'),
	(151, 150, 'BANDUNG', '2002-04-04', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3217040404020012', 'A', 'devanpamungkas04@gmail.com', '0851-5674-5439', NULL, NULL, 'Grand Cikarang City Cluster Kalyana Blok B/9A No.19'),
	(152, 151, 'BEKASI', '2002-12-03', 'Belum Menikah', 'ISLAM', 'Perempuan', '3216084312020008', 'A', 'puspitadian631@gmail.com', '0812-9851-5415', NULL, NULL, 'KP KETAPANG, RT 003/RW 002,KALIJAYA,CIKARANG BARAT,BEKASI'),
	(153, 152, 'TANGGERANG', '1998-12-10', 'Belum Menikah', 'KATHOLIK', 'Laki-Laki', '3174051012980000', 'O', 'tdevin10@gmail.com', '087782964120', NULL, NULL, 'Kompleks Permata Hijau 2 B25, DKI Jakarta'),
	(154, 153, 'TANGERANG', '2000-08-23', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3671112308000002', 'N/A', NULL, '0815-1796-4844', NULL, NULL, 'JL.PULO MAS VB NOMOR 17,006/011,KAYU PUTIH,PULO GADUNG,JAKARTA TIMUR,DKI JAKARTA'),
	(155, 154, 'BEKASI', '2003-06-06', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216010610030005', 'N/A', 'rifaldihercules@gmail.com', '0857-9670-8146', NULL, NULL, 'KP. TANAH BARU002/009DESA PANTAI MAKMURTARUMAJAYAKAB. BEKASIJAWABARAT'),
	(156, 155, 'BEKASI', '2000-07-15', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216011606020008', 'N/A', 'yudaw4121@gmail.com', '0858-1072-4296', NULL, NULL, 'KP. KEBON KELAPA001/005SEGERAJAYATARUMAJAYABEKASIJAWA BARAT'),
	(157, 156, 'BANYUMAS', '1969-02-12', 'Cerai Hidup', 'ISLAM', 'Laki-Laki', '3674011202690002', 'B', 'anasdes0212@gmail.com', '0878-7740-7281', NULL, NULL, NULL),
	(158, 157, 'BEKASI', '1994-08-28', 'Belum Menikah', 'ISLAM', 'Laki-Laki', '3216012808940002', 'N/A', 'vimensyah28@gmail.com', '081564638619', NULL, NULL, 'KP. TAMBUN SUNGAI ANGKE004/005PAHLAWAN SETIATARUMAJAYABEKASIJAWA BARAT'),
	(159, 160, 'JAKARTA', '2001-06-11', 'Belum Menikah', 'Islam', 'Perempuan', '3276045106010001', 'B', 'adintm11@gmail.com', '089647999954', NULL, NULL, 'JL. A RAHIM,002/003,MERUYUNG,LIMO,DEPOK,JAWA BARAT'),
	(160, 161, 'test abc', '2000-12-12', 'Belum Menikah', 'test abc', 'Laki-Laki', '1234', 'O', 'test1@gmail.com', '123456', NULL, NULL, 'test abc'),
	(162, 162, 'bekasi', '2001-10-20', 'Belum Menikah', 'Islam', 'Laki-Laki', '12345678', 'O', 'email@gmail.com', '12345678', '12345678', '12345678', 'bekasi');

-- Dumping structure for table hrapp_karyawan.emp_personal_address
CREATE TABLE IF NOT EXISTS `emp_personal_address` (
  `id_address` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `alamat_ktp` text COLLATE utf8mb4_general_ci,
  `rt` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rw` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelurahan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kecamatan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kota` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `provinsi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_general_ci,
  `no_telp` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_address`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.emp_personal_address: ~2 rows (approximately)
INSERT INTO `emp_personal_address` (`id_address`, `emp_id`, `alamat_ktp`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kota`, `provinsi`, `alamat_lengkap`, `no_telp`) VALUES
	(1, 159, 'MAHONI RAYA BLOK D12 GSP,006/012,KARYAMULYA,KESAMBI,KOTA CIREBON,JAWA BARAT\r\n', '006', '012', 'KARYAMULYA', 'KESAMBI', 'CIREBON', 'JAWA BARAT', 'MAHONI RAYA BLOK D12 GSP,006/012,KARYAMULYA,KESAMBI,KOTA CIREBON,JAWA BARAT', '0821-2494-4003'),
	(2, 160, 'JL. A RAHIM,002/003,MERUYUNG,LIMO,DEPOK,JAWA BARAT\r\n', '002', '003', 'Meruyung', 'Limo', 'Depok', 'JAWA BARAT', 'JL. A RAHIM,002/003,MERUYUNG,LIMO,DEPOK,JAWA BARAT', '0896-4799-9954'),
	(3, 161, 'test abcs', '009', '002', 'test abc', 'test abc', 'test abc', 'test abc', 'test abc', ''),
	(4, 162, 'bekasi 12121212', '09', '09', 'bekasi', 'bekasi', 'bekasi', 'jawa barat', 'hashasasasas', '121212');

-- Dumping structure for table hrapp_karyawan.file
CREATE TABLE IF NOT EXISTS `file` (
  `id_file` int NOT NULL AUTO_INCREMENT,
  `allowance_id` int DEFAULT NULL,
  `nama_file` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.file: ~0 rows (approximately)

-- Dumping structure for table hrapp_karyawan.kontrak_kerja
CREATE TABLE IF NOT EXISTS `kontrak_kerja` (
  `id_kontrak` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `awal_kontrak` date DEFAULT NULL,
  `akhir_kontrak` date DEFAULT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_kontrak`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.kontrak_kerja: ~0 rows (approximately)
INSERT INTO `kontrak_kerja` (`id_kontrak`, `emp_id`, `awal_kontrak`, `akhir_kontrak`, `keterangan`) VALUES
	(1, 106, '2023-12-01', '2024-05-31', 'Perpanjangan Kontrak K5');

-- Dumping structure for table hrapp_karyawan.payroll
CREATE TABLE IF NOT EXISTS `payroll` (
  `id_payrol` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `account` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payroll_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_payrol`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.payroll: ~154 rows (approximately)
INSERT INTO `payroll` (`id_payrol`, `emp_id`, `account`, `payroll_name`) VALUES
	(1, 1, 'sudah ada', 'UOB'),
	(2, 2, '7303147296', 'UOB'),
	(3, 3, '7303187379', 'UOB'),
	(4, 4, '7303185929', 'UOB'),
	(5, 5, '7303187409', 'UOB'),
	(6, 6, '7303162694', 'UOB'),
	(7, 7, '7303181672', 'UOB'),
	(8, 8, '5453703283', 'UOB'),
	(9, 9, '7303204524', 'UOB'),
	(10, 10, '5453703399', 'UOB'),
	(11, 11, '7303146656', 'UOB'),
	(12, 12, '7303156244', 'UOB'),
	(13, 13, '7303213507', 'UOB'),
	(14, 14, '7303186291', 'UOB'),
	(15, 15, '7303156139', 'UOB'),
	(16, 16, '7303161663', 'UOB'),
	(17, 17, '5453703321', 'UOB'),
	(18, 18, '5453703372', 'UOB'),
	(19, 19, '7303162775', 'UOB'),
	(20, 20, '5453703526', 'UOB'),
	(21, 21, '7303177969', 'UOB'),
	(22, 22, '7303194200', 'UOB'),
	(23, 23, '7303177993', 'UOB'),
	(24, 24, '7303185910', 'UOB'),
	(25, 25, '7303874732', 'UOB'),
	(26, 26, '7303162686', 'UOB'),
	(27, 27, '7303176156', 'UOB'),
	(28, 28, '7303185287', 'UOB'),
	(29, 29, '7303190841', 'UOB'),
	(30, 30, '7303154446', 'UOB'),
	(31, 31, '7303156023', 'UOB'),
	(32, 32, '7303179295', 'UOB'),
	(33, 33, '7303202491', 'UOB'),
	(34, 34, '7303171286', 'UOB'),
	(35, 35, '7303201711', 'UOB'),
	(36, 36, '7303276045', 'UOB'),
	(37, 37, '7303212810', 'UOB'),
	(38, 38, '7303196777', 'UOB'),
	(39, 39, '7303513950', 'UOB'),
	(40, 40, '7303489146', 'UOB'),
	(41, 41, '7303489189', 'UOB'),
	(42, 42, '7303254726', 'UOB'),
	(43, 43, '7313662903', 'UOB'),
	(44, 44, '7313429338', 'UOB'),
	(45, 45, '7323160787', 'UOB'),
	(46, 46, '7323448020', 'UOB'),
	(47, 47, '7333509656', 'UOB'),
	(48, 48, '7333431991', 'UOB'),
	(49, 49, '7333434451', 'UOB'),
	(50, 50, '7343968195', 'UOB'),
	(51, 51, '7353178931', 'UOB'),
	(52, 52, '7303136596', 'UOB'),
	(53, 53, '7293500693', 'UOB'),
	(54, 54, '7363034814', 'UOB'),
	(55, 55, '7363185758', 'UOB'),
	(56, 56, '7363721137', 'UOB'),
	(57, 57, '7363780303', 'UOB'),
	(58, 58, '7373357530', 'UOB'),
	(59, 59, '7373414089', 'UOB'),
	(60, 60, '7373716506', 'UOB'),
	(61, 61, '7373974920', 'UOB'),
	(62, 62, '7373735772', 'UOB'),
	(63, 63, '7383395899', 'UOB'),
	(64, 64, '7373907026', 'UOB'),
	(65, 65, '7373952994', 'UOB'),
	(66, 66, '7383016316', 'UOB'),
	(67, 67, '7303273291', 'UOB'),
	(68, 68, '7383395570', 'UOB'),
	(69, 69, '7393056448', 'UOB'),
	(70, 70, '7303609133', 'UOB'),
	(71, 71, '5453703518', 'UOB'),
	(72, 72, '7393204102', 'UOB'),
	(73, 73, '7393250759', 'UOB'),
	(74, 74, '5453703275', 'UOB'),
	(75, 75, '7403094904', 'UOB'),
	(76, 76, '7403322540', 'UOB'),
	(77, 77, '7403323849', 'UOB'),
	(78, 78, '7403965026', 'UOB'),
	(79, 79, '7413469973', 'UOB'),
	(80, 80, '3201022833', 'UOB'),
	(81, 81, '7383468667', 'UOB'),
	(82, 82, '7423069299', 'UOB'),
	(83, 83, '7423374954', 'UOB'),
	(84, 84, '7423718653', 'UOB'),
	(85, 85, '5453703429', 'UOB'),
	(86, 86, '7423799521', 'UOB'),
	(87, 87, '7423852163', 'UOB'),
	(88, 88, '7433061075', 'UOB'),
	(89, 89, '7393171565', 'UOB'),
	(90, 90, '7433107628', 'UOB'),
	(91, 91, '7433231949', 'UOB'),
	(92, 92, '7433404541', 'UOB'),
	(93, 93, '7433138442', 'UOB'),
	(94, 94, '5733716739', 'UOB'),
	(95, 95, '7373909088', 'UOB'),
	(96, 96, '5453703461', 'UOB'),
	(97, 97, '7433826624', 'UOB'),
	(98, 98, '7433962765', 'UOB'),
	(99, 99, '7443074507', 'UOB'),
	(100, 100, '7443091681', 'UOB'),
	(101, 101, '7353487640', 'UOB'),
	(102, 102, ' 7443162279', 'UOB'),
	(103, 103, '7303162449', 'UOB'),
	(104, 104, '4873705536', 'UOB'),
	(105, 105, '4271354015', 'UOB'),
	(106, 106, '1407685951', 'UOB'),
	(107, 107, '1270001023751', 'MANDIRI'),
	(108, 108, '7373624067', 'UOB'),
	(109, 109, '701227621400', 'CIMB NIAGA'),
	(110, 133, 'N/A', 'N/A'),
	(111, 134, 'N/A', 'N/A'),
	(112, 110, '7303439408', 'UOB'),
	(113, 113, '7303325046', 'UOB'),
	(114, 112, '6040195911', 'BCA'),
	(115, 113, '7303191783', 'UOB'),
	(116, 135, 'N/A', 'N/A'),
	(117, 114, '7303360003', 'UOB'),
	(118, 136, 'N/A', 'N/A'),
	(119, 137, 'N/A', 'N/A'),
	(120, 115, '7353908158', 'UOB'),
	(121, 116, '7313754697', 'UOB'),
	(122, 117, '7433408792', 'UOB'),
	(123, 118, '7433311616', 'UOB'),
	(124, 119, '7433314070', 'UOB'),
	(125, 138, 'N/A', 'N/A'),
	(126, 139, 'N/A', 'N/A'),
	(127, 140, 'N/A', 'N/A'),
	(128, 141, 'N/A', 'N/A'),
	(129, 120, '7363292058', 'UOB'),
	(130, 147, '7425427407', 'BCA'),
	(131, 121, '1120020680620', 'MANDIRI'),
	(132, 122, '1760003657101', 'MANDIRI'),
	(133, 142, '1730010448901', 'MANDIRI'),
	(134, 148, '0899040777', 'BCA'),
	(135, 149, '1850003002869', 'MANDIRI'),
	(136, 143, '7303156538', 'UOB'),
	(137, 144, '2310548041', 'BCA'),
	(138, 145, '7353749548', 'UOB'),
	(139, 123, '3723712740', 'UOB'),
	(140, 124, '7433703743', 'UOB'),
	(141, 125, '7433658888', 'UOB'),
	(142, 126, '7433313872', 'UOB'),
	(143, 127, '3103711221', 'UOB'),
	(144, 150, '5775900765', 'BCA'),
	(145, 151, '3431854323', 'BCA'),
	(146, 128, '7433897262', 'UOB'),
	(147, 146, 'N/A', 'N/A'),
	(148, 129, '7433899982', 'UOB'),
	(149, 130, '7433968100', 'UOB'),
	(150, 152, '5465036351', 'BCA'),
	(151, 131, '7443205253', 'UOB'),
	(152, 132, '3203705792', 'UOB'),
	(153, 158, '7443421436', 'UOB'),
	(154, 160, '7443952180', 'UOB'),
	(155, 161, '123456', 'test abc'),
	(156, 162, 'UOB', '213121313');

-- Dumping structure for table hrapp_karyawan.pengalaman_kerja
CREATE TABLE IF NOT EXISTS `pengalaman_kerja` (
  `id_pengalaman` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `perusahaan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `periode_masuk` date DEFAULT NULL,
  `periode_keluar` date DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_pengalaman`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.pengalaman_kerja: ~0 rows (approximately)
INSERT INTO `pengalaman_kerja` (`id_pengalaman`, `emp_id`, `perusahaan`, `jabatan`, `periode_masuk`, `periode_keluar`, `keterangan`) VALUES
	(1, 161, 'test abc', 'test abc', '2022-12-12', '2023-12-12', 'test abc');

-- Dumping structure for table hrapp_karyawan.resigned
CREATE TABLE IF NOT EXISTS `resigned` (
  `id_resigned` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tgl_resign` date DEFAULT NULL,
  `alasan_resign` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_resigned`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.resigned: ~0 rows (approximately)
INSERT INTO `resigned` (`id_resigned`, `emp_id`, `tgl_pengajuan`, `tgl_resign`, `alasan_resign`) VALUES
	(1, 108, '2023-11-01', '2023-11-30', 'Habis kontrak tidak mau diperpanjang');

-- Dumping structure for table hrapp_karyawan.status_emp
CREATE TABLE IF NOT EXISTS `status_emp` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.status_emp: ~7 rows (approximately)
INSERT INTO `status_emp` (`id_status`, `status_name`) VALUES
	(1, 'Karyawan Tetap'),
	(2, 'Kontrak'),
	(3, 'Harian'),
	(4, 'Out Sourcing'),
	(5, 'Magang/INTREN'),
	(6, 'Probation'),
	(7, 'Pensiun');

-- Dumping structure for table hrapp_karyawan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int NOT NULL AUTO_INCREMENT,
  `employee_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `roles` int DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `active` enum('true','false') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.users: ~16 rows (approximately)
INSERT INTO `users` (`id_users`, `employee_id`, `name`, `email`, `roles`, `password`, `active`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'admin', 'support@zekindo.co.id', 1, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'true', '2023-05-11 19:22:33', NULL),
	(2, 1, 'Sumantri Ishak', 'sumantri@zekindo.com', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'true', '2024-02-23 01:25:52', NULL),
	(3, 2, 'Hesti Indah Puspitasari', 'hesti@acmechem.co.id', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 01:26:17', NULL),
	(4, 3, 'Edi Junaedi', 'edi.junaedi@zekindo.com', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 01:28:03', NULL),
	(5, NULL, 'Asa Subagja', 'asasubagjasubagja@gmail.com', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 04:29:00', NULL),
	(6, NULL, 'Fany Kurniawan', 'Fany_Kurniawan@zekindo.com', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 04:29:55', NULL),
	(7, NULL, 'Rindu Wahono', 'rindu.wahono@zekindo.com', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 04:31:19', NULL),
	(8, NULL, 'Warin Nirwana', 'warinnirwana@gmail.com', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 04:33:18', NULL),
	(9, NULL, 'Saefudin', 'sairayulianti@gmail.com', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 04:34:28', NULL),
	(10, NULL, 'Adi Khafidh Persada', 'adi.khafidh@acmechem.co.id', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'false', '2024-02-23 04:35:27', NULL),
	(35, NULL, 'hr admin', 'hr.admin@acmechem.co.id', 2, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'true', '2023-10-03 00:39:09', NULL),
	(36, 95, 'dicky', 'dicky.hermawan@zekindo.co.id', 3, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', 'true', '2023-10-03 02:32:42', '2023-10-03 20:04:44'),
	(38, 20, 'sutrismiyanto', 'sutrismiyanto@zekindo.co.id', 3, '$2y$10$15x7pPsdq4e5LixYYVySdueXKfJkZmqUr1PADC2g2AaKUDsQcOdHG', 'true', '2023-10-03 20:25:46', NULL),
	(39, 43, 'ridho luthfi', 'ridho.luthfi@acmechem.co.id', 3, '$2y$10$qTb6tCYZuCgGiigYQ7kEM..TNyzePacPISS4JU74X0qRO67GmhIvq', 'true', '2023-10-03 20:27:12', NULL),
	(40, 113, 'Yana Marlianty', 'yana@zekindo.com', 2, '$2y$10$kSBUHYkL1GQHXwZhHKp/RuAgTxrd9rAIcsI4Y4ntrFpFETxj9VAE.', 'false', '2023-11-16 07:16:02', NULL),
	(41, 93, 'Gabriela Carissa', 'gabriela.carissa@zekindo.co.id', 2, '$2y$10$BhdZyes70uXmDOAZEzBev.WXTpapj.W0Vr8YoBmqNizp5UWNFrY3u', 'false', '2023-12-11 08:33:49', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
