-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251012.af5879ac98
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2025 at 07:05 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dupak_v1.2.1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nidn` int NOT NULL,
  `prodi` enum('Rekayasa Perangkat Lunak','Informatika','Bisnis Digital','Sains Data','Teknologi Informasi','Teknik Logistik') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jfa_saat_ini` tinyint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nama`, `nidn`, `prodi`, `jfa_saat_ini`) VALUES
(101, 'Budi Santoso', 412345601, 'Rekayasa Perangkat Lunak', 2),
(102, 'Citra Dewi', 498765402, 'Informatika', 1),
(103, 'Dimas Prasetya', 131412312, 'Teknologi Informasi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dosens`
--

CREATE TABLE `dosens` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nidn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nuptk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_fakultas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formations`
--

CREATE TABLE `formations` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_formasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atasan_formasi_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bagian` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fakultas` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kuota` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `input_detil_penelitian`
--

CREATE TABLE `input_detil_penelitian` (
  `id` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tanggalPublikasi` date NOT NULL,
  `idDetiInputan` int NOT NULL,
  `penulis` int NOT NULL,
  `judul` int NOT NULL,
  `jenisPublikasi` int NOT NULL,
  `namaJurnal` int NOT NULL,
  `penerbitpenyelenggara` int NOT NULL,
  `akre` int NOT NULL,
  `vol` int NOT NULL,
  `no` int NOT NULL,
  `tahun` int NOT NULL,
  `halaman` int NOT NULL,
  `issn` int NOT NULL,
  `Link1` int NOT NULL,
  `Link2` int NOT NULL,
  `Link3` int NOT NULL,
  `similarityInclude` int NOT NULL,
  `similarityExclude` int NOT NULL,
  `similarityAI` int NOT NULL,
  `rincian` int NOT NULL,
  `LinksimilarityInclude` int NOT NULL,
  `LinksimilarityExclude` int NOT NULL,
  `LinksimilarityAI` int NOT NULL,
  `LinkKorespondensi` int NOT NULL,
  `statusSyaratUtama` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='subdetilinputan3';

-- --------------------------------------------------------

--
-- Table structure for table `input_detil_umum`
--

CREATE TABLE `input_detil_umum` (
  `id` int NOT NULL,
  `uraianKegiatanValue` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `idInputDetilUmum` int NOT NULL,
  `idJenisInput` int NOT NULL,
  `idNilaiKumBaku` int NOT NULL,
  `valueJenisInput` int NOT NULL,
  `nilaiKriteria` int NOT NULL,
  `angkaKredit` int NOT NULL,
  `lampiran` varchar(200) NOT NULL,
  `pengecualian` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='detilinputan1245';

--
-- Dumping data for table `input_detil_umum`
--

INSERT INTO `input_detil_umum` (`id`, `uraianKegiatanValue`, `idInputDetilUmum`, `idJenisInput`, `idNilaiKumBaku`, `valueJenisInput`, `nilaiKriteria`, `angkaKredit`, `lampiran`, `pengecualian`) VALUES
(1, '', 1, 11, 141, 1, 12, 1, 'bitly/dokumen1', 0),
(2, '', 1, 11, 142, 50, 50, 50, 'bitly/ijazahs1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `input_rekapitulasi_komponen`
--

CREATE TABLE `input_rekapitulasi_komponen` (
  `id` int NOT NULL,
  `idPengajuan` int NOT NULL,
  `uraianKegiatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `volume` int NOT NULL,
  `NilaiTotal` int NOT NULL,
  `NilaiDiakui` int NOT NULL,
  `idKegiatanKomponen` int NOT NULL,
  `tahunAjaran` int NOT NULL,
  `semester` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='hasil penjumlah dari seluruh detail yang diinputkan';

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_hasil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angka_kredit` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `kategori`, `sub_kategori`, `nama`, `satuan_hasil`, `angka_kredit`, `created_at`, `updated_at`) VALUES
(1, 'Pendidikan', 'Pendidikan Formal', 'Doktor (S3)', 'Ijazah', 200.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(2, 'Pendidikan', 'Pendidikan Formal', 'Magister (S2)', 'Ijazah', 150.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(3, 'Pengajaran', 'Melaksanakan Perkuliahan', 'Mengajar 1 SKS', 'SKS', 1.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(4, 'Pengajaran', 'Membimbing Seminar', 'Membimbing mahasiswa seminar', 'Semester', 1.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(5, 'Penelitian', 'Publikasi Ilmiah', 'Jurnal internasional bereputasi', 'Artikel', 40.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(6, 'Penelitian', 'Publikasi Ilmiah', 'Jurnal internasional', 'Artikel', 30.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(7, 'Penelitian', 'Publikasi Ilmiah', 'Jurnal nasional terakreditasi', 'Artikel', 25.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(8, 'Pengabdian', 'Pengabdian Masyarakat', 'Menduduki jabatan pimpinan pada lembaga pemerintahan', 'Semester', 5.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(9, 'Pengabdian', 'Pengabdian Masyarakat', 'Melaksanakan pengembangan hasil pendidikan dan penelitian', 'Program', 3.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(10, 'Penunjang', 'Organisasi Profesi', 'Menjadi anggota dalam organisasi profesi', 'Tahun', 1.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(11, 'Penunjang', 'Penghargaan', 'Memperoleh penghargaan', 'Penghargaan', 3.00, '2025-11-03 04:45:22', '2025-11-03 04:45:22'),
(12, 'Pendidikan', 'Pendidikan Formal', 'Doktor (S3)', 'Ijazah', 200.00, '2025-11-11 10:51:45', '2025-11-11 10:51:45'),
(13, 'Pendidikan', 'Pendidikan Formal', 'Magister (S2)', 'Ijazah', 150.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(14, 'Pengajaran', 'Melaksanakan Perkuliahan', 'Mengajar 1 SKS', 'SKS', 1.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(15, 'Pengajaran', 'Membimbing Seminar', 'Membimbing mahasiswa seminar', 'Semester', 1.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(16, 'Penelitian', 'Publikasi Ilmiah', 'Jurnal internasional bereputasi', 'Artikel', 40.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(17, 'Penelitian', 'Publikasi Ilmiah', 'Jurnal internasional', 'Artikel', 30.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(18, 'Penelitian', 'Publikasi Ilmiah', 'Jurnal nasional terakreditasi', 'Artikel', 25.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(19, 'Pengabdian', 'Pengabdian Masyarakat', 'Menduduki jabatan pimpinan pada lembaga pemerintahan', 'Semester', 5.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(20, 'Pengabdian', 'Pengabdian Masyarakat', 'Melaksanakan pengembangan hasil pendidikan dan penelitian', 'Program', 3.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(21, 'Penunjang', 'Organisasi Profesi', 'Menjadi anggota dalam organisasi profesi', 'Tahun', 1.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46'),
(22, 'Penunjang', 'Penghargaan', 'Memperoleh penghargaan', 'Penghargaan', 3.00, '2025-11-11 10:51:46', '2025-11-11 10:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_level` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan_level` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atasan_level` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_16_000000_create_dupak_tables', 2),
(5, '2024_03_21_000000_create_sessions_table', 3),
(6, '2025_01_05_075652_create_ref_jabatan_fungsional_akademiks_table', 3),
(7, '2025_01_05_075700_create_ref_jabatan_fungsional_keahlians_table', 3),
(8, '2025_01_27_122730_create_ref_status_pegawais_table', 3),
(9, '2025_01_27_131051_create_ref_pangkat_golongans_table', 3),
(10, '2025_01_27_132859_create_ref_jenjang_pendidikans_table', 3),
(11, '2025_10_01_113504_create_faculties_table', 3),
(12, '2025_10_01_121899_create_prodis_table', 3),
(13, '2025_10_12_155756_create_levels_table', 3),
(14, '2025_10_15_140835_create_ref_bagians_table', 3),
(15, '2025_10_15_150555_create_formations_table', 3),
(16, '2025_10_15_165658_create_s_k_s_table', 3),
(17, '2025_10_15_165659_create_pengawakans_table', 3),
(18, '2025_10_26_130000_rename_password_column', 3),
(19, '2025_10_27_121900_create_dosens_table', 3),
(20, '2025_10_27_123204_create_riwayat_nips_table', 3),
(21, '2025_10_27_132914_create_riwayat_jenjang_pendidikans_table', 3),
(22, '2025_10_27_133222_create_riwayat_pangkat_golongans_table', 3),
(23, '2025_10_27_140836_create_tpas_table', 3),
(24, '2025_11_04_093120_create_pengajuan_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` int NOT NULL,
  `idDosen` int NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `TahunAjaranAjuanAwal` year NOT NULL,
  `TahunAjaranAjuanAkhir` year NOT NULL,
  `semesterAjuan` tinyint NOT NULL,
  `jfaAsal` tinyint UNSIGNED NOT NULL,
  `jfaTujuan` tinyint UNSIGNED NOT NULL,
  `nip` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengawakans`
--

CREATE TABLE `pengawakans` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formasi_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmt_mulai` date NOT NULL,
  `tmt_selesai` date DEFAULT NULL,
  `sk_ypt_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodis`
--

CREATE TABLE `prodis` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fakultas_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_prodi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_bagians`
--

CREATE TABLE `ref_bagians` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_bagian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_jabatan_fungsional_akademik`
--

CREATE TABLE `ref_jabatan_fungsional_akademik` (
  `id` tinyint UNSIGNED NOT NULL,
  `nama` varchar(20) NOT NULL,
  `namaPanjang` varchar(20) NOT NULL,
  `kum` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='JFA';

--
-- Dumping data for table `ref_jabatan_fungsional_akademik`
--

INSERT INTO `ref_jabatan_fungsional_akademik` (`id`, `nama`, `namaPanjang`, `kum`) VALUES
(1, 'NJAD', 'Non JAD', 0),
(2, 'AA', 'Asisten Ahli', 150),
(3, 'L', 'Lektor', 200),
(4, 'LK', 'Lektor Kepala', 450),
(5, 'GB', 'Guru Besar', 850);

-- --------------------------------------------------------

--
-- Table structure for table `ref_jabatan_fungsional_akademiks`
--

CREATE TABLE `ref_jabatan_fungsional_akademiks` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minimal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maximal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_jabatan_fungsional_keahlians`
--

CREATE TABLE `ref_jabatan_fungsional_keahlians` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jfk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_jenis_input`
--

CREATE TABLE `ref_jenis_input` (
  `id` int NOT NULL,
  `idKomponen` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `value` int NOT NULL,
  `jenisInput` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='klasifikasi';

--
-- Dumping data for table `ref_jenis_input`
--

INSERT INTO `ref_jenis_input` (`id`, `idKomponen`, `nama`, `value`, `jenisInput`) VALUES
(11, 6, 'Jurnal Internasional Bereputasi', 100, 1),
(12, 2, 'Prosiding Nasional', 50, 1),
(13, 3, 'Mengajar Mata Kuliah (Per SKS)', 1, 2),
(14, 6, 'Membimbing Skripsi/Tesis (Per Mahasiswa)', 1, 2),
(21, 2, 'Jurnal Nasional Terakreditasi', 25, 1),
(31, 3, 'Melaksanakan Program Pengabdian (1 Tahun)', 3, 1),
(41, 4, 'Menjadi Anggota Senat Universitas', 5, 1),
(61, 6, 'Bimbingan Disertasi', 12, 2),
(62, 6, 'Bimbingan Tesis', 8, 2),
(63, 6, 'Bimbingan Skripsi/Laporan Akhir Studi', 5, 2),
(101, 1, 'Sarjana (S1)', 100, 2),
(104, 1, 'Magister (S2) linier', 50, 2),
(105, 1, 'Magister (S2) non linier', 15, 2),
(106, 1, 'Doktor (S3) linier', 50, 2),
(107, 1, 'Doktor (S3) non linier', 15, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ref_jenjang_pendidikans`
--

CREATE TABLE `ref_jenjang_pendidikans` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenjang_pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_kegiatan_komponen`
--

CREATE TABLE `ref_kegiatan_komponen` (
  `id` int NOT NULL,
  `nama` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idKegiatanUtama` int NOT NULL,
  `status` int NOT NULL,
  `satuanHasil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='sub level dari lampiran utama';

--
-- Dumping data for table `ref_kegiatan_komponen`
--

INSERT INTO `ref_kegiatan_komponen` (`id`, `nama`, `idKegiatanUtama`, `status`, `satuanHasil`) VALUES
(1, 'I. A. Pendidikan Formal', 1, 1, 'Ijazah'),
(2, 'I. B. Pendidikan & Pelatihan Prajabatan', 1, 1, ''),
(3, 'II. A. Melaksanakan perkuliahan', 2, 1, 'SKS'),
(4, 'II. B. Membimbing seminar', 2, 1, 'Kegiatan'),
(5, 'II. C. Membimbing Kuliah Kerja Nyata (KKN), Praktek Kerja Nyata (PKN), Praktek Kerja Lapangan (PKL)', 2, 1, 'Kegiatan'),
(6, 'II. D. Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi', 2, 1, 'Lulusan'),
(7, 'II. E. Bertugas sebagai penguji pada Ujian Akhir', 2, 1, 'Lulusan'),
(8, 'II. F. Membina kegiatan mahasiswa', 2, 1, 'Semester'),
(9, 'II. G. Mengembangkan program kuliah', 2, 1, 'Semester'),
(10, 'II. H. Mengembangkan bahan pengajaran', 2, 1, 'Eksampelar\r\n'),
(11, 'II. I. Menyampaikan Orasi Ilmiah', 2, 1, 'Orasi\r\n'),
(12, 'II. J. Menduduki jabatan pimpinan perguruan tinggi', 2, 1, 'Semester'),
(13, 'II. K. Membimbing dosen yang lebih rendah setiap semester (bagi dosen Lektor Kepala ke atas)', 2, 1, 'Kegiatan'),
(14, 'II. L. Melaksanakan kegiatan datasering dan pencangkokan di luar institusi tempat bekerja setiap semester (bagi dosen Lektor kepala ke atas)', 2, 1, 'Kegiatan'),
(15, 'II. M. Melakukan kegiatan pengembangan diri untuk meningkatkan kompetensi', 2, 1, 'Sertifikat'),
(16, 'III. A. Menghasilkan Karya Ilmiah', 3, 1, 'Jurnal Nasional Bereputasi'),
(17, 'III. B. Menerjemahkan / Menyadur Buku Ilmiah', 3, 1, ''),
(18, 'III. C. Mengedit/menyunting karya ilmiah', 3, 1, ''),
(19, 'III. D. Membuat rancangan dan karya teknologi yang dipatenkan terdaftar HaKi', 3, 1, ''),
(20, 'III. E. Membuat rancangan dan karya teknologi yang Tidak dipatenkan atau Tidak terdaftar HKI tetapi telah dipresentasikan pada Forum Teragenda', 3, 1, ''),
(21, 'IV. A. Menduduki jabatan pimpinan', 4, 1, ''),
(22, 'IV. B. Melaksanakan pengembangan hasil pendidikan & penelitian', 4, 1, ''),
(23, 'IV. C. Memberi latihan/peyuluhan/penataran/ceramah pada masyarakat', 4, 1, ''),
(24, 'IV. D. Memberi pelayanan kepada masyarakat atau kegiatan lain menunjang pelaksanaan tugas umum pemerintah dan pembangunan', 4, 1, ''),
(25, 'IV. E. Membuat/menulis karya pengabdian', 4, 1, ''),
(26, 'V. A. Menjadi anggota dalam suatu Panitia/Badan pada Perguruan Tinggi', 5, 1, ''),
(27, 'V. B. \"Menjadi anggota Panitia/Badan pada Lembaga Pemerintah', 5, 1, ''),
(28, 'V. C. \"Menjadi Anggota Organisasi Profesi Dosen', 5, 1, ''),
(29, 'V. D. Mewakili Perguruan Tinggi/Lembaga Pemerintah', 5, 1, ''),
(30, 'V. E. \"Menjadi Anggota Delegasi Nasional ke pertemuan Internasional', 5, 1, ''),
(31, 'V. F. Berperan serta aktif dalam pengelolaan jurnal ilmiah (pertahun)', 5, 1, ''),
(32, 'V. G. Berperan serta aktif dalam pertemuan ilmiah', 5, 1, ''),
(33, 'V. H. Mendapat penghargaan/tanda jasa', 5, 1, ''),
(34, 'V. I. Menulis buku pelajaran SLTA, kebawah yang diterbitkan dan diedarkan secara nasional', 5, 1, ''),
(35, 'V. J. Mempunyai prestasi dibidang olah raga/humaniora', 5, 1, ''),
(36, 'V. K. Keanggotaan dalam tim penilai', 5, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `ref_kegiatan_utama`
--

CREATE TABLE `ref_kegiatan_utama` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Lampiran utama dalam pengisian DUPAK';

--
-- Dumping data for table `ref_kegiatan_utama`
--

INSERT INTO `ref_kegiatan_utama` (`id`, `nama`, `status`) VALUES
(1, 'I. Pendidikan', 1),
(2, 'II. Pelaksanaan Pendidikan', 1),
(3, 'III. Pelaksanaan Penelitian', 1),
(4, 'IV. Pelaksanaan Pengabdian Kepada Masyarakat', 1),
(5, 'V. Penunjang Kegiatan Akademik Dosen', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_nilai_kum_baku`
--

CREATE TABLE `ref_nilai_kum_baku` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `idKegiatanKomponen` int NOT NULL,
  `value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='nilaikriteria';

--
-- Dumping data for table `ref_nilai_kum_baku`
--

INSERT INTO `ref_nilai_kum_baku` (`id`, `nama`, `idKegiatanKomponen`, `value`) VALUES
(111, 'Penulis Pertama', 11, 1),
(112, 'Penulis Kedua/Anggota', 11, 0),
(131, 'Mata Kuliah Dasar (SKS)', 13, 1),
(132, 'Mata Kuliah Lanjut (SKS)', 13, 1),
(141, 'Ketua Pembimbing (Mahasiswa)', 14, 1),
(142, 'Anggota Pembimbing (Mahasiswa)', 14, 1),
(601, 'Ketua Pembimbing', 6, 1),
(602, 'Anggota Pembimbing', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_pangkat_golongans`
--

CREATE TABLE `ref_pangkat_golongans` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_regulasi_batas_komponen`
--

CREATE TABLE `ref_regulasi_batas_komponen` (
  `id` int NOT NULL,
  `idLevelAjuan` int NOT NULL,
  `idKomponen` int NOT NULL,
  `nilaiMax` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='batasmaksimalnilaikomponenperlevelajuan';

-- --------------------------------------------------------

--
-- Table structure for table `ref_regulasi_kum_komponen`
--

CREATE TABLE `ref_regulasi_kum_komponen` (
  `id` int NOT NULL,
  `idKegiatanUtama` int NOT NULL,
  `idLevelAjuan` int NOT NULL,
  `maxmin` int NOT NULL,
  `persentase` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='maxminajuangolongan';

--
-- Dumping data for table `ref_regulasi_kum_komponen`
--

INSERT INTO `ref_regulasi_kum_komponen` (`id`, `idKegiatanUtama`, `idLevelAjuan`, `maxmin`, `persentase`) VALUES
(9101, 3, 3, 0, 80),
(9102, 4, 4, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_pegawais`
--

CREATE TABLE `ref_status_pegawais` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_target_jabatan_pengajuan`
--

CREATE TABLE `ref_target_jabatan_pengajuan` (
  `id` int NOT NULL,
  `jfaAsal` tinyint UNSIGNED NOT NULL,
  `jfaTujuan` tinyint UNSIGNED NOT NULL,
  `kumTarget` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='level_ajuan';

--
-- Dumping data for table `ref_target_jabatan_pengajuan`
--

INSERT INTO `ref_target_jabatan_pengajuan` (`id`, `jfaAsal`, `jfaTujuan`, `kumTarget`) VALUES
(1, 1, 2, 150),
(2, 1, 3, 200),
(3, 2, 3, 50),
(4, 3, 4, 250),
(5, 4, 5, 400);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_jenjang_pendidikans`
--

CREATE TABLE `riwayat_jenjang_pendidikans` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenjang_pendidikan_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bidang_pendidikan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kampus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kampus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_lulus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gelar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `singkatan_gelar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ijazah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_nips`
--

CREATE TABLE `riwayat_nips` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pegawai_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `users_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmt_mulai` date NOT NULL,
  `tmt_selesai` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pangkat_golongans`
--

CREATE TABLE `riwayat_pangkat_golongans` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat_golongan_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dosen_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sk_llkdikti_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmt_pangkat` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sks`
--

CREATE TABLE `sks` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmt_mulai` date DEFAULT NULL,
  `file_sk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_sk` enum('LLDIKTI','Pengakuan YPT') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tpas`
--

CREATE TABLE `tpas` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `users_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nitk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bagian_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_institusi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Perempuan','Laki-laki') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tgl_bergabung` date NOT NULL,
  `email_pribadi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jfa_saat_ini` (`jfa_saat_ini`);

--
-- Indexes for table `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dosens_nidn_unique` (`nidn`),
  ADD UNIQUE KEY `dosens_nuptk_unique` (`nuptk`),
  ADD KEY `dosens_users_id_foreign` (`users_id`),
  ADD KEY `dosens_prodi_id_foreign` (`prodi_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_kode_unique` (`kode`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formations_level_id_foreign` (`level_id`),
  ADD KEY `formations_atasan_formasi_id_foreign` (`atasan_formasi_id`),
  ADD KEY `formations_bagian_foreign` (`bagian`),
  ADD KEY `formations_prodi_foreign` (`prodi`),
  ADD KEY `formations_fakultas_foreign` (`fakultas`);

--
-- Indexes for table `input_detil_penelitian`
--
ALTER TABLE `input_detil_penelitian`
  ADD KEY `idDetiInputan` (`idDetiInputan`);

--
-- Indexes for table `input_detil_umum`
--
ALTER TABLE `input_detil_umum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKlasifikasi` (`idJenisInput`),
  ADD KEY `idNilaiKriteria` (`idNilaiKumBaku`),
  ADD KEY `idInputanData` (`idInputDetilUmum`);

--
-- Indexes for table `input_rekapitulasi_komponen`
--
ALTER TABLE `input_rekapitulasi_komponen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPengajuan` (`idPengajuan`),
  ADD KEY `idKomponen` (`idKegiatanKomponen`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `levels_atasan_level_foreign` (`atasan_level`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDosen` (`idDosen`),
  ADD KEY `jfaAsal` (`jfaAsal`),
  ADD KEY `jfaTujuan` (`jfaTujuan`);

--
-- Indexes for table `pengawakans`
--
ALTER TABLE `pengawakans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengawakans_sk_ypt_id_foreign` (`sk_ypt_id`),
  ADD KEY `pengawakans_users_id_foreign` (`users_id`),
  ADD KEY `pengawakans_formasi_id_foreign` (`formasi_id`);

--
-- Indexes for table `prodis`
--
ALTER TABLE `prodis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodis_fakultas_id_foreign` (`fakultas_id`);

--
-- Indexes for table `ref_bagians`
--
ALTER TABLE `ref_bagians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_jabatan_fungsional_akademik`
--
ALTER TABLE `ref_jabatan_fungsional_akademik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_jabatan_fungsional_akademiks`
--
ALTER TABLE `ref_jabatan_fungsional_akademiks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_jabatan_fungsional_keahlians`
--
ALTER TABLE `ref_jabatan_fungsional_keahlians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_jenis_input`
--
ALTER TABLE `ref_jenis_input`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKomponen` (`idKomponen`);

--
-- Indexes for table `ref_jenjang_pendidikans`
--
ALTER TABLE `ref_jenjang_pendidikans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_kegiatan_komponen`
--
ALTER TABLE `ref_kegiatan_komponen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idGolongan` (`idKegiatanUtama`);

--
-- Indexes for table `ref_kegiatan_utama`
--
ALTER TABLE `ref_kegiatan_utama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_nilai_kum_baku`
--
ALTER TABLE `ref_nilai_kum_baku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKlasifikasi` (`idKegiatanKomponen`);

--
-- Indexes for table `ref_pangkat_golongans`
--
ALTER TABLE `ref_pangkat_golongans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_regulasi_batas_komponen`
--
ALTER TABLE `ref_regulasi_batas_komponen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idKomponen` (`idKomponen`),
  ADD KEY `idLevelAjuan` (`idLevelAjuan`);

--
-- Indexes for table `ref_regulasi_kum_komponen`
--
ALTER TABLE `ref_regulasi_kum_komponen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idGolongan` (`idKegiatanUtama`),
  ADD KEY `idLevelAjuan` (`idLevelAjuan`);

--
-- Indexes for table `ref_status_pegawais`
--
ALTER TABLE `ref_status_pegawais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ref_target_jabatan_pengajuan`
--
ALTER TABLE `ref_target_jabatan_pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asal` (`jfaAsal`),
  ADD KEY `tujuan` (`jfaTujuan`);

--
-- Indexes for table `riwayat_jenjang_pendidikans`
--
ALTER TABLE `riwayat_jenjang_pendidikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_jenjang_pendidikans_users_id_foreign` (`users_id`),
  ADD KEY `riwayat_jenjang_pendidikans_jenjang_pendidikan_id_foreign` (`jenjang_pendidikan_id`);

--
-- Indexes for table `riwayat_nips`
--
ALTER TABLE `riwayat_nips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_nips_users_id_foreign` (`users_id`),
  ADD KEY `riwayat_nips_status_pegawai_id_foreign` (`status_pegawai_id`);

--
-- Indexes for table `riwayat_pangkat_golongans`
--
ALTER TABLE `riwayat_pangkat_golongans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_pangkat_golongans_pangkat_golongan_id_foreign` (`pangkat_golongan_id`),
  ADD KEY `riwayat_pangkat_golongans_dosen_id_foreign` (`dosen_id`),
  ADD KEY `riwayat_pangkat_golongans_sk_llkdikti_id_foreign` (`sk_llkdikti_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sks`
--
ALTER TABLE `sks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sks_users_id_foreign` (`users_id`);

--
-- Indexes for table `tpas`
--
ALTER TABLE `tpas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tpas_nitk_unique` (`nitk`),
  ADD KEY `tpas_users_id_foreign` (`users_id`),
  ADD KEY `tpas_bagian_id_foreign` (`bagian_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_telepon_unique` (`telepon`),
  ADD UNIQUE KEY `users_email_institusi_unique` (`email_institusi`),
  ADD UNIQUE KEY `users_email_pribadi_unique` (`email_pribadi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `input_detil_umum`
--
ALTER TABLE `input_detil_umum`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `input_rekapitulasi_komponen`
--
ALTER TABLE `input_rekapitulasi_komponen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_jabatan_fungsional_akademik`
--
ALTER TABLE `ref_jabatan_fungsional_akademik`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_jenis_input`
--
ALTER TABLE `ref_jenis_input`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `ref_kegiatan_komponen`
--
ALTER TABLE `ref_kegiatan_komponen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `ref_kegiatan_utama`
--
ALTER TABLE `ref_kegiatan_utama`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_nilai_kum_baku`
--
ALTER TABLE `ref_nilai_kum_baku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=603;

--
-- AUTO_INCREMENT for table `ref_regulasi_batas_komponen`
--
ALTER TABLE `ref_regulasi_batas_komponen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_regulasi_kum_komponen`
--
ALTER TABLE `ref_regulasi_kum_komponen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9103;

--
-- AUTO_INCREMENT for table `ref_target_jabatan_pengajuan`
--
ALTER TABLE `ref_target_jabatan_pengajuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`jfa_saat_ini`) REFERENCES `ref_jabatan_fungsional_akademik` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `dosens`
--
ALTER TABLE `dosens`
  ADD CONSTRAINT `dosens_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dosens_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `formations_atasan_formasi_id_foreign` FOREIGN KEY (`atasan_formasi_id`) REFERENCES `formations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `formations_bagian_foreign` FOREIGN KEY (`bagian`) REFERENCES `ref_bagians` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `formations_fakultas_foreign` FOREIGN KEY (`fakultas`) REFERENCES `faculties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `formations_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `formations_prodi_foreign` FOREIGN KEY (`prodi`) REFERENCES `prodis` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `input_detil_penelitian`
--
ALTER TABLE `input_detil_penelitian`
  ADD CONSTRAINT `input_detil_penelitian_ibfk_1` FOREIGN KEY (`idDetiInputan`) REFERENCES `input_detil_umum` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `input_detil_umum`
--
ALTER TABLE `input_detil_umum`
  ADD CONSTRAINT `input_detil_umum_ibfk_3` FOREIGN KEY (`idJenisInput`) REFERENCES `ref_jenis_input` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `input_detil_umum_ibfk_4` FOREIGN KEY (`idNilaiKumBaku`) REFERENCES `ref_nilai_kum_baku` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `input_detil_umum_ibfk_5` FOREIGN KEY (`idInputDetilUmum`) REFERENCES `input_rekapitulasi_komponen` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `input_rekapitulasi_komponen`
--
ALTER TABLE `input_rekapitulasi_komponen`
  ADD CONSTRAINT `input_rekapitulasi_komponen_ibfk_4` FOREIGN KEY (`idPengajuan`) REFERENCES `pengajuan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `input_rekapitulasi_komponen_ibfk_5` FOREIGN KEY (`idKegiatanKomponen`) REFERENCES `ref_kegiatan_komponen` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `levels`
--
ALTER TABLE `levels`
  ADD CONSTRAINT `levels_atasan_level_foreign` FOREIGN KEY (`atasan_level`) REFERENCES `levels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_ibfk_1` FOREIGN KEY (`idDosen`) REFERENCES `dosen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengajuan_ibfk_2` FOREIGN KEY (`jfaAsal`) REFERENCES `ref_jabatan_fungsional_akademik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengajuan_ibfk_3` FOREIGN KEY (`jfaTujuan`) REFERENCES `ref_jabatan_fungsional_akademik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengawakans`
--
ALTER TABLE `pengawakans`
  ADD CONSTRAINT `pengawakans_formasi_id_foreign` FOREIGN KEY (`formasi_id`) REFERENCES `formations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengawakans_sk_ypt_id_foreign` FOREIGN KEY (`sk_ypt_id`) REFERENCES `sks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengawakans_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `prodis`
--
ALTER TABLE `prodis`
  ADD CONSTRAINT `prodis_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `faculties` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ref_jenis_input`
--
ALTER TABLE `ref_jenis_input`
  ADD CONSTRAINT `ref_jenis_input_ibfk_1` FOREIGN KEY (`idKomponen`) REFERENCES `ref_kegiatan_komponen` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ref_kegiatan_komponen`
--
ALTER TABLE `ref_kegiatan_komponen`
  ADD CONSTRAINT `ref_kegiatan_komponen_ibfk_1` FOREIGN KEY (`idKegiatanUtama`) REFERENCES `ref_kegiatan_utama` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ref_nilai_kum_baku`
--
ALTER TABLE `ref_nilai_kum_baku`
  ADD CONSTRAINT `ref_nilai_kum_baku_ibfk_1` FOREIGN KEY (`idKegiatanKomponen`) REFERENCES `ref_kegiatan_komponen` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ref_regulasi_batas_komponen`
--
ALTER TABLE `ref_regulasi_batas_komponen`
  ADD CONSTRAINT `ref_regulasi_batas_komponen_ibfk_1` FOREIGN KEY (`idKomponen`) REFERENCES `ref_target_jabatan_pengajuan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ref_regulasi_batas_komponen_ibfk_2` FOREIGN KEY (`idLevelAjuan`) REFERENCES `ref_kegiatan_komponen` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ref_regulasi_kum_komponen`
--
ALTER TABLE `ref_regulasi_kum_komponen`
  ADD CONSTRAINT `ref_regulasi_kum_komponen_ibfk_1` FOREIGN KEY (`idKegiatanUtama`) REFERENCES `ref_kegiatan_utama` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ref_regulasi_kum_komponen_ibfk_2` FOREIGN KEY (`idLevelAjuan`) REFERENCES `ref_target_jabatan_pengajuan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ref_target_jabatan_pengajuan`
--
ALTER TABLE `ref_target_jabatan_pengajuan`
  ADD CONSTRAINT `levelajuan_jfa_asal` FOREIGN KEY (`jfaAsal`) REFERENCES `ref_jabatan_fungsional_akademik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `levelajuan_jfa_tujuan` FOREIGN KEY (`jfaTujuan`) REFERENCES `ref_jabatan_fungsional_akademik` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_jenjang_pendidikans`
--
ALTER TABLE `riwayat_jenjang_pendidikans`
  ADD CONSTRAINT `riwayat_jenjang_pendidikans_jenjang_pendidikan_id_foreign` FOREIGN KEY (`jenjang_pendidikan_id`) REFERENCES `ref_jenjang_pendidikans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_jenjang_pendidikans_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `riwayat_nips`
--
ALTER TABLE `riwayat_nips`
  ADD CONSTRAINT `riwayat_nips_status_pegawai_id_foreign` FOREIGN KEY (`status_pegawai_id`) REFERENCES `ref_status_pegawais` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_nips_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `riwayat_pangkat_golongans`
--
ALTER TABLE `riwayat_pangkat_golongans`
  ADD CONSTRAINT `riwayat_pangkat_golongans_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_pangkat_golongans_pangkat_golongan_id_foreign` FOREIGN KEY (`pangkat_golongan_id`) REFERENCES `ref_pangkat_golongans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_pangkat_golongans_sk_llkdikti_id_foreign` FOREIGN KEY (`sk_llkdikti_id`) REFERENCES `sks` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sks`
--
ALTER TABLE `sks`
  ADD CONSTRAINT `sks_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tpas`
--
ALTER TABLE `tpas`
  ADD CONSTRAINT `tpas_bagian_id_foreign` FOREIGN KEY (`bagian_id`) REFERENCES `ref_bagians` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tpas_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
