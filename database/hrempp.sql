-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- membuang struktur untuk table hrapp_karyawan.company
CREATE TABLE IF NOT EXISTS `company` (
  `IdCompany` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdCompany`),
  KEY `company_name` (`company_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.company: ~4 rows (lebih kurang)
INSERT INTO `company` (`IdCompany`, `company_name`) VALUES
	(2, 'PT Acme Indonesia'),
	(4, 'PT Miltonia Warna Asia'),
	(3, 'PT Powerindo Kimia Mineral'),
	(1, 'PT Zeus Kimiatama Indonesia');

-- membuang struktur untuk table hrapp_karyawan.department
CREATE TABLE IF NOT EXISTS `department` (
  `id_dept` int NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) DEFAULT '',
  PRIMARY KEY (`id_dept`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.department: ~10 rows (lebih kurang)
INSERT INTO `department` (`id_dept`, `dept_name`) VALUES
	(1, 'Information Technology'),
	(2, 'Operation'),
	(3, 'Legal'),
	(4, 'Production'),
	(5, 'Supply Chain and Purchasing'),
	(6, 'Human Resource & GA'),
	(7, 'Finance'),
	(8, 'RnD'),
	(9, 'HSE'),
	(10, 'Accounting');

-- membuang struktur untuk table hrapp_karyawan.education
CREATE TABLE IF NOT EXISTS `education` (
  `id_edu` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `pendidikan_terakhir` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `asal_sekolah` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_edu`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.education: ~3 rows (lebih kurang)
INSERT INTO `education` (`id_edu`, `emp_id`, `pendidikan_terakhir`, `jurusan`, `asal_sekolah`) VALUES
	(4, 1, 'S1', 'kimia', 'itb'),
	(5, 2, 'S1', 'Bisnis dan Manajemen', 'Universitas Indonesia'),
	(6, 3, 'S1', 'Master Bisnis dan Manajemen', 'UNJ'),
	(7, 4, 'S2', 'Magister Ekonomi dan Bisnis', 'Universitas Indonesia'),
	(8, 5, 'S1', 'Accounting', 'Universitas Negeri Semarang');

-- membuang struktur untuk table hrapp_karyawan.emergency
CREATE TABLE IF NOT EXISTS `emergency` (
  `id_emergency` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(100) DEFAULT NULL,
  `hubungan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_emergency`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.emergency: ~3 rows (lebih kurang)
INSERT INTO `emergency` (`id_emergency`, `emp_id`, `nama`, `alamat`, `no_telp`, `hubungan`) VALUES
	(2, 1, 'istri', 'jakarta', '13', 'iestri'),
	(3, 2, 'istri', 'jakarta', '123', 'istri'),
	(4, 3, 'istri', 'bekasi', '123', 'istri'),
	(5, 4, 'joko suprapto', 'tambun utara bekasi', '0897765612345', 'suami'),
	(6, 5, 'Ibu', 'Desa Cicau Ciakarng Pusat Kabupaten Bekasi', '0877345', 'Ibu');

-- membuang struktur untuk table hrapp_karyawan.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `id_employee` int NOT NULL AUTO_INCREMENT,
  `nip` varchar(50) DEFAULT NULL,
  `status_emp` int DEFAULT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `comp_id` int DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tgl_kartap` date DEFAULT NULL,
  `email_kantor` varchar(255) DEFAULT NULL,
  `pangkat` varchar(255) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `bpjstk` varchar(50) DEFAULT NULL,
  `bpjskes` varchar(50) DEFAULT NULL,
  `dept_id` int DEFAULT NULL,
  `is_resigned` int DEFAULT '0',
  PRIMARY KEY (`id_employee`) USING BTREE,
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.employee: ~5 rows (lebih kurang)
INSERT INTO `employee` (`id_employee`, `nip`, `status_emp`, `lokasi`, `nama`, `comp_id`, `tgl_masuk`, `tgl_kartap`, `email_kantor`, `pangkat`, `jabatan`, `bpjstk`, `bpjskes`, `dept_id`, `is_resigned`) VALUES
	(1, '001', 1, 'The Prominence Office 12D', 'presdir', 1, '1998-12-12', '1998-12-12', 'presdir@zekindo.co.id', 'direktur', 'presiden direktur', '12345', '12345', 2, 0),
	(2, '002', 1, 'The Prominence Office Tower 12D', 'wakil presdir', 1, '2008-12-12', '2008-12-12', 'wakapresdir@zekindo.co.id', 'direktur', 'wakil presiden', '123', '123', 2, 1),
	(3, 'K001', 2, 'Sungkai', 'direktur operasional', 1, '2008-12-12', NULL, 'oprdir@zekindo.co.id', 'direktur', 'direktur operasional', '123', '123', 2, 0),
	(4, '004', 1, 'The Prominence Ofiice Tower 12D', 'direktur bisnis', 1, '2022-01-12', '2022-01-12', 'dirbisnis@zekindo.co.id', 'direktur', 'direktur pendukung bisnis', '345678', '34567897', 6, 0),
	(5, 'K002', 2, 'Sungkai', 'Staff', 1, '2023-06-02', NULL, 'staff_acc@zekindo.co.id', 'staff', 'staff', '123456', '123456', 10, 1);

-- membuang struktur untuk table hrapp_karyawan.emp_families
CREATE TABLE IF NOT EXISTS `emp_families` (
  `id_family` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `nama_suami_istri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `anak1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `anak2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `anak3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `anak4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_family`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.emp_families: ~3 rows (lebih kurang)
INSERT INTO `emp_families` (`id_family`, `emp_id`, `nama_suami_istri`, `anak1`, `anak2`, `anak3`, `anak4`) VALUES
	(1, 1, 'istri', 'anak1', 'anak2', 'anak3', ''),
	(2, 2, 'istri', 'anak 1', 'anak 2', 'anak 3', 'anak 4'),
	(3, 3, 'istri', 'anak 1', '', '', ''),
	(4, 4, 'mobilio', 'supri', 'supra', '', '');

-- membuang struktur untuk table hrapp_karyawan.emp_personal
CREATE TABLE IF NOT EXISTS `emp_personal` (
  `id_personal` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `status_pernikahan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `agama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `golongan_darah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(100) DEFAULT NULL,
  `domisili` text,
  PRIMARY KEY (`id_personal`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.emp_personal: ~4 rows (lebih kurang)
INSERT INTO `emp_personal` (`id_personal`, `emp_id`, `tempat_lahir`, `tanggal_lahir`, `status_pernikahan`, `agama`, `gender`, `nik`, `golongan_darah`, `email`, `no_hp`, `domisili`) VALUES
	(1, 1, 'jakarta', '1980-12-12', 'Menikah', 'islam', 'Laki-Laki', '123', 'O', 'presdier@gmail.com', '123', 'jakarta'),
	(2, 2, 'jakarta', '1980-02-19', 'Menikah', 'Islam', 'Laki-Laki', '123', 'A', 'wapresdir@gmail.com', '123', '123'),
	(3, 3, 'solo', '1980-07-20', 'Menikah', 'Islam', 'Laki-Laki', '123', 'A', 'oprdir@gmail.com', '123', 'bekasi'),
	(7, 4, 'Jakarta', '1985-12-12', 'Menikah', 'Islam', 'Perempuan', '345', 'O', 'dirbisnis@gmail.com', '345678', 'Jakarta Barat'),
	(8, 5, 'Bekasi', '2000-06-20', 'Belum Menikah', 'Islam', 'Perempuan', '33211114567', 'O', 'staff_acc@gmail.com', '0877654', 'Cicau');

-- membuang struktur untuk table hrapp_karyawan.emp_personal_address
CREATE TABLE IF NOT EXISTS `emp_personal_address` (
  `id_address` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `alamat_ktp` text,
  `rt` varchar(50) DEFAULT NULL,
  `rw` varchar(50) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `alamat_lengkap` text,
  `no_telp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_address`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.emp_personal_address: ~3 rows (lebih kurang)
INSERT INTO `emp_personal_address` (`id_address`, `emp_id`, `alamat_ktp`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kota`, `provinsi`, `alamat_lengkap`, `no_telp`) VALUES
	(1, 1, 'jakarta', '001', '001', 'jakarta', 'jakrata', 'jakarta', 'jakarta', 'jakarta', ''),
	(2, 2, 'jakarta', '002', '001', 'jakarta', 'jakarta', 'jakarta', 'jakarta', 'jakarta', ''),
	(3, 3, 'bekasi', '003', '002', 'bekasi', 'bekasi', 'bekasi', 'jabar', 'bekasi jabar', ''),
	(4, 4, 'tambun utara, kabupaten bekasi', '003', '001', 'tambun utara', 'tambun', 'bekasi', 'jawa barat', 'tambun bekasi jawa barat', '021 4568997'),
	(5, 5, 'Desa Cicau Kecamatan Cikarang Pusat Kabupaten Bekasi', '001', '002', 'Cicau', 'Cikarang Pusat', 'Bekasi', 'Jawa Barat', 'Jalan Desa Cicau No34, RT 001 RW 002, Desa Cicau, Cikarang Pusat, Kabupaten Bekasi ', '');

-- membuang struktur untuk table hrapp_karyawan.kontrak_kerja
CREATE TABLE IF NOT EXISTS `kontrak_kerja` (
  `id_kontrak` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `awal_kontrak` date DEFAULT NULL,
  `akhir_kontrak` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_kontrak`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.kontrak_kerja: ~3 rows (lebih kurang)
INSERT INTO `kontrak_kerja` (`id_kontrak`, `emp_id`, `awal_kontrak`, `akhir_kontrak`, `keterangan`) VALUES
	(1, 3, '2023-03-01', '2028-03-01', 'kontrak profesional 5 tahun'),
	(2, 5, '2023-06-02', '2023-09-02', 'Kontrak 3 bulan'),
	(3, 5, '2023-09-02', '2023-11-02', 'extended 2 bulan lagi');

-- membuang struktur untuk table hrapp_karyawan.payroll
CREATE TABLE IF NOT EXISTS `payroll` (
  `id_payrol` int NOT NULL AUTO_INCREMENT,
  `emp_id` int DEFAULT NULL,
  `account` varchar(50) DEFAULT NULL,
  `payroll_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_payrol`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.payroll: ~3 rows (lebih kurang)
INSERT INTO `payroll` (`id_payrol`, `emp_id`, `account`, `payroll_name`) VALUES
	(1, 1, '1234', 'test bank'),
	(2, 2, '123', 'UOB Indonesia'),
	(4, 3, '12345', 'UOB'),
	(8, 4, '3456578', 'UOB'),
	(9, 5, '70098765', 'UOB');

-- membuang struktur untuk table hrapp_karyawan.resigned
CREATE TABLE IF NOT EXISTS `resigned` (
  `id_resigned` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tgl_resign` date DEFAULT NULL,
  PRIMARY KEY (`id_resigned`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.resigned: ~1 rows (lebih kurang)
INSERT INTO `resigned` (`id_resigned`, `emp_id`, `tgl_pengajuan`, `tgl_resign`) VALUES
	(5, 5, '2023-07-27', NULL),
	(6, 2, '2023-07-28', '2023-08-01');

-- membuang struktur untuk table hrapp_karyawan.status_emp
CREATE TABLE IF NOT EXISTS `status_emp` (
  `id_status` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.status_emp: ~7 rows (lebih kurang)
INSERT INTO `status_emp` (`id_status`, `status_name`) VALUES
	(1, 'Karyawan Tetap'),
	(2, 'Kontrak'),
	(3, 'Harian'),
	(4, 'Out Sourcing'),
	(5, 'Magang/INTREN'),
	(6, 'Probation'),
	(7, 'Pensiun');

-- membuang struktur untuk table hrapp_karyawan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `roles` int DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel hrapp_karyawan.users: ~0 rows (lebih kurang)
INSERT INTO `users` (`id_users`, `name`, `email`, `roles`, `password`, `created_at`, `updated_at`) VALUES
	(33, 'admin', 'support@zekindo.co.id', 1, '$2y$10$EA.G9Kcm3bfrBZ3Iy8NuFe99/PM8BdescdO0eBNdL7.daLz9ctQs6', '2023-05-12 02:22:33', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
