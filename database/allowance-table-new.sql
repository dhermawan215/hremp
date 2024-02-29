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

-- Dumping structure for table hrapp_karyawan.allowance
CREATE TABLE IF NOT EXISTS `allowance` (
  `id_allowance` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `nomer` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `transaction_date` date DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `departemen` int DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `period` year DEFAULT NULL,
  `total` double DEFAULT '0',
  `hr_approve` int DEFAULT '0',
  `hr_notes` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `manager_approve` int DEFAULT '0',
  `manager_note` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_allowance`),
  UNIQUE KEY `nomer` (`nomer`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.allowance: ~2 rows (approximately)
INSERT INTO `allowance` (`id_allowance`, `users_id`, `nomer`, `transaction_date`, `nama`, `departemen`, `company`, `period`, `total`, `hr_approve`, `hr_notes`, `manager_approve`, `manager_note`, `created_at`, `updated_at`) VALUES
	(1, 36, 'ARF-022800001', NULL, 'Klaim pembelian kacanmata dan alat kesehatan', 12, NULL, NULL, 2500000, 0, NULL, 0, NULL, '2024-02-28 08:56:48', '2024-02-28 08:56:48'),
	(2, 36, 'ARF-022900002', NULL, 'Pendidikan', 12, NULL, NULL, 3000000, 0, NULL, 0, NULL, '2024-02-29 06:57:05', '2024-02-29 06:57:05');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
