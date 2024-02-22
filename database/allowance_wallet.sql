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

-- Dumping structure for table hrapp_karyawan.allowance_wallet
CREATE TABLE IF NOT EXISTS `allowance_wallet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `saldo_awal` double DEFAULT NULL,
  `saldo_transaksi` int DEFAULT NULL,
  `saldo_sisa` double DEFAULT NULL,
  `periode_saldo` year DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table hrapp_karyawan.allowance_wallet: ~5 rows (approximately)
INSERT INTO `allowance_wallet` (`id`, `users_id`, `saldo_awal`, `saldo_transaksi`, `saldo_sisa`, `periode_saldo`, `created_at`, `updated_at`) VALUES
	(1, 38, 4000000, NULL, 4000000, '2024', '2024-02-20 07:46:03', '2024-02-20 07:46:03'),
	(2, 36, 4000000, NULL, 4000000, '2024', '2024-02-20 08:08:28', '2024-02-20 08:08:28'),
	(3, 39, 4000000, NULL, 4000000, '2024', '2024-02-20 08:09:32', '2024-02-20 08:09:32'),
	(4, 41, 4000000, NULL, 4000000, '2024', '2024-02-20 08:09:54', '2024-02-20 08:09:54'),
	(5, 40, 5000000, NULL, 5000000, '2024', '2024-02-20 08:11:32', '2024-02-20 08:11:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
