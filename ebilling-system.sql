-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jul 2025 pada 18.01
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebilling-system`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pelanggan`
--

CREATE TABLE `data_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat_pelanggan` text NOT NULL,
  `telepon_pelanggan` varchar(50) NOT NULL,
  `email_pelanggan` varchar(100) DEFAULT '',
  `id_paket` int(11) DEFAULT NULL,
  `odp_id` int(11) DEFAULT NULL,
  `pop_id` int(11) DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif','isolir') NOT NULL DEFAULT 'aktif',
  `tgl_daftar` date NOT NULL,
  `tgl_expired` date DEFAULT NULL,
  `last_paid_date` date DEFAULT NULL,
  `mikrotik_username` varchar(100) DEFAULT '',
  `mikrotik_password` varchar(100) DEFAULT '',
  `mikrotik_profile` varchar(100) DEFAULT '',
  `mikrotik_service` varchar(20) DEFAULT 'pppoe',
  `mikrotik_caller_id` varchar(50) DEFAULT '',
  `mikrotik_routes` text DEFAULT '',
  `static_ip` varchar(20) DEFAULT '',
  `ip_pool` varchar(50) DEFAULT '',
  `mikrotik_comment` text DEFAULT '',
  `mikrotik_disabled` enum('yes','no') DEFAULT 'no',
  `sync_mikrotik` enum('yes','no') DEFAULT 'no',
  `last_sync` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status_pppoe` enum('active','isolated') DEFAULT 'active',
  `tanggal_isolasi` datetime DEFAULT NULL,
  `odp_port_id` int(11) DEFAULT NULL COMMENT 'ID Port ODP yang digunakan pelanggan',
  `onu_id` varchar(20) DEFAULT '',
  `signal_rx` varchar(20) DEFAULT '',
  `signal_tx` varchar(20) DEFAULT '',
  `ftth_status` enum('active','inactive','maintenance') DEFAULT 'active' COMMENT 'Status FTTH',
  `installation_date` date DEFAULT NULL COMMENT 'Tanggal instalasi',
  `technician` varchar(100) DEFAULT '',
  `ftth_notes` text DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `ftth_odc`
--

CREATE TABLE `ftth_odc` (
  `id` int(11) NOT NULL,
  `nama_odc` varchar(100) NOT NULL,
  `pon_port_id` int(11) NOT NULL COMMENT 'PON Port yang terhubung dari OLT',
  `lokasi` varchar(200) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL COMMENT 'Koordinat latitude',
  `longitude` decimal(11,8) DEFAULT NULL COMMENT 'Koordinat longitude',
  `jumlah_port` int(11) NOT NULL DEFAULT 8 COMMENT 'Total port ODC untuk ODP',
  `port_tersedia` int(11) NOT NULL DEFAULT 8 COMMENT 'Port yang masih tersedia untuk ODP',
  `kapasitas_fiber` int(11) DEFAULT 24 COMMENT 'Kapasitas fiber dalam core',
  `jumlah_splitter` int(11) NOT NULL DEFAULT 0,
  `status` enum('active','inactive','maintenance') NOT NULL DEFAULT 'active',
  `area_coverage` varchar(200) DEFAULT '',
  `keterangan` text DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `ftth_odc_ports`
--

CREATE TABLE `ftth_odc_ports` (
  `id` int(11) NOT NULL,
  `odc_id` int(11) NOT NULL,
  `port_number` int(11) NOT NULL,
  `port_name` varchar(50) NOT NULL,
  `status` enum('available','connected','maintenance') NOT NULL DEFAULT 'available',
  `connected_odp_id` int(11) DEFAULT NULL COMMENT 'ODP yang terhubung ke port ini',
  `fiber_core` varchar(20) DEFAULT '',
  `keterangan` text DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `ftth_odp`
--

CREATE TABLE `ftth_odp` (
  `id` int(11) NOT NULL,
  `nama_odp` varchar(100) NOT NULL,
  `odc_port_id` int(11) NOT NULL COMMENT 'Port ODC yang terhubung',
  `lokasi` varchar(200) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL COMMENT 'Koordinat latitude',
  `longitude` decimal(11,8) DEFAULT NULL COMMENT 'Koordinat longitude',
  `jumlah_port` int(11) NOT NULL DEFAULT 8 COMMENT 'Total port ODP untuk pelanggan',
  `port_tersedia` int(11) NOT NULL DEFAULT 8 COMMENT 'Port yang masih tersedia untuk pelanggan',
  `splitter_ratio` varchar(20) DEFAULT '1:8',
  `status` enum('active','inactive','maintenance') NOT NULL DEFAULT 'active',
  `jenis_odp` enum('aerial','underground') NOT NULL DEFAULT 'aerial',
  `area_coverage` varchar(200) DEFAULT '',
  `keterangan` text DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `ftth_odp_ports`
--

CREATE TABLE `ftth_odp_ports` (
  `id` int(11) NOT NULL,
  `odp_id` int(11) NOT NULL,
  `port_number` int(11) NOT NULL,
  `port_name` varchar(50) NOT NULL,
  `status` enum('available','connected','maintenance') NOT NULL DEFAULT 'available',
  `connected_customer_id` int(11) DEFAULT NULL COMMENT 'ID pelanggan yang terhubung',
  `onu_id` varchar(20) DEFAULT '',
  `signal_rx` varchar(20) DEFAULT '',
  `signal_tx` varchar(20) DEFAULT '',
  `installation_date` date DEFAULT NULL,
  `technician` varchar(100) DEFAULT '',
  `keterangan` text DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `ftth_olt`
--

CREATE TABLE `ftth_olt` (
  `id` int(11) NOT NULL,
  `pop_id` int(11) DEFAULT NULL COMMENT 'ID POP tempat OLT berada',
  `nama_olt` varchar(100) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL COMMENT 'Koordinat latitude',
  `longitude` decimal(11,8) DEFAULT NULL COMMENT 'Koordinat longitude',
  `merk` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `jumlah_port_pon` int(11) NOT NULL DEFAULT 16,
  `port_tersedia` int(11) NOT NULL DEFAULT 16 COMMENT 'Port PON yang masih tersedia untuk ODC',
  `status` enum('active','inactive','maintenance') NOT NULL DEFAULT 'active',
  `snmp_community` varchar(50) DEFAULT 'public',
  `snmp_version` varchar(10) DEFAULT 'v2c',
  `keterangan` text DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `ftth_pon`
--

CREATE TABLE `ftth_pon` (
  `id` int(11) NOT NULL,
  `olt_id` int(11) NOT NULL,
  `port_number` varchar(20) NOT NULL,
  `port_name` varchar(50) NOT NULL,
  `status` enum('available','connected','maintenance') NOT NULL DEFAULT 'available',
  `connected_odc_id` int(11) DEFAULT NULL COMMENT 'ODC yang terhubung ke port ini',
  `max_distance` int(11) DEFAULT 20000 COMMENT 'Jarak maksimal dalam meter',
  `splitter_ratio` varchar(20) DEFAULT '1:32',
  `keterangan` text DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `ftth_pop`
--

CREATE TABLE `ftth_pop` (
  `id` int(11) NOT NULL,
  `nama_pop` varchar(100) NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL COMMENT 'Koordinat latitude',
  `longitude` decimal(11,8) DEFAULT NULL COMMENT 'Koordinat longitude',
  `alamat_lengkap` text DEFAULT '',
  `kapasitas_olt` int(11) NOT NULL DEFAULT 5 COMMENT 'Maksimal OLT di POP ini',
  `jumlah_olt` int(11) DEFAULT 0 COMMENT 'Jumlah OLT yang sudah ada',
  `status` enum('active','inactive','maintenance') NOT NULL DEFAULT 'active',
  `pic_nama` varchar(100) DEFAULT '',
  `pic_telepon` varchar(50) DEFAULT '',
  `keterangan` text DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Struktur dari tabel `monitoring_pppoe`
--

CREATE TABLE `monitoring_pppoe` (
  `id_monitoring` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `mikrotik_username` varchar(100) NOT NULL,
  `session_id` varchar(50) DEFAULT '',
  `ip_address` varchar(20) DEFAULT '',
  `mac_address` varchar(20) DEFAULT '',
  `interface` varchar(50) DEFAULT '',
  `caller_id` varchar(50) DEFAULT '',
  `uptime` varchar(50) DEFAULT '',
  `bytes_in` bigint(20) DEFAULT 0,
  `bytes_out` bigint(20) DEFAULT 0,
  `packets_in` bigint(20) DEFAULT 0,
  `packets_out` bigint(20) DEFAULT 0,
  `session_start` timestamp NULL DEFAULT NULL,
  `session_end` timestamp NULL DEFAULT NULL,
  `disconnect_reason` varchar(100) DEFAULT '',
  `status` enum('active','disconnected') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_internet`
--

CREATE TABLE `paket_internet` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `profile_name` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT '',
  `local_address` varchar(20) DEFAULT '',
  `remote_address` varchar(50) DEFAULT '',
  `session_timeout` varchar(20) DEFAULT '',
  `idle_timeout` varchar(20) DEFAULT '',
  `keepalive_timeout` varchar(20) DEFAULT '30',
  `rate_limit_rx` varchar(20) DEFAULT '',
  `rate_limit_tx` varchar(20) DEFAULT '',
  `burst_limit_rx` varchar(20) DEFAULT '',
  `burst_limit_tx` varchar(20) DEFAULT '',
  `burst_threshold_rx` varchar(20) DEFAULT '',
  `burst_threshold_tx` varchar(20) DEFAULT '',
  `burst_time_rx` varchar(10) DEFAULT '',
  `burst_time_tx` varchar(10) DEFAULT '',
  `priority` tinyint(1) DEFAULT 8,
  `parent_queue` varchar(50) DEFAULT '',
  `dns_server` varchar(100) DEFAULT '',
  `wins_server` varchar(50) DEFAULT '',
  `only_one` enum('yes','no') DEFAULT 'yes',
  `shared_users` tinyint(4) DEFAULT 1,
  `address_list` varchar(100) DEFAULT '',
  `incoming_filter` varchar(100) DEFAULT '',
  `outgoing_filter` varchar(100) DEFAULT '',
  `on_up` text DEFAULT '',
  `on_down` text DEFAULT '',
  `status_paket` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `sync_mikrotik` enum('yes','no') DEFAULT 'no',
  `last_sync` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tagihan` varchar(20) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `metode_bayar` varchar(50) DEFAULT '',
  `keterangan` text DEFAULT '',
  `id_user_pencatat` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `pengaturan_perusahaan`
--

CREATE TABLE `pengaturan_perusahaan` (
  `id_pengaturan` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `alamat_perusahaan` text DEFAULT NULL,
  `telepon_perusahaan` varchar(50) DEFAULT NULL,
  `email_perusahaan` varchar(100) DEFAULT NULL,
  `bank_nama` varchar(100) DEFAULT NULL,
  `bank_atas_nama` varchar(100) DEFAULT NULL,
  `bank_no_rekening` varchar(50) DEFAULT NULL,
  `logo_perusahaan` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `keterangan_lain` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `radcheck`
--

CREATE TABLE `radcheck` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `attribute` varchar(64) NOT NULL,
  `op` char(2) NOT NULL DEFAULT '==',
  `value` varchar(253) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `mikrotik_ip` varchar(50) NOT NULL,
  `mikrotik_user` varchar(50) NOT NULL,
  `mikrotik_pass` varchar(100) NOT NULL,
  `mikrotik_port` int(11) NOT NULL DEFAULT 8728
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(20) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `bulan_tagihan` int(11) NOT NULL,
  `tahun_tagihan` int(11) NOT NULL,
  `jumlah_tagihan` decimal(10,2) NOT NULL,
  `tgl_jatuh_tempo` date NOT NULL,
  `status_tagihan` enum('belum_bayar','sudah_bayar','terlambat') NOT NULL DEFAULT 'belum_bayar',
  `deskripsi` text DEFAULT '',
  `auto_generated` enum('yes','no') DEFAULT 'no',
  `generated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `transaksi_lain`
--

CREATE TABLE `transaksi_lain` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('pemasukan','pengeluaran') NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level` enum('admin','operator') NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Struktur dari tabel `voucher_history`
--

CREATE TABLE `voucher_history` (
  `id` int(11) NOT NULL,
  `profile_name` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `total_nilai` decimal(15,2) NOT NULL,
  `batch_id` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `voucher_temp`
--

CREATE TABLE `voucher_temp` (
  `id` int(11) NOT NULL,
  `batch_id` varchar(10) NOT NULL,
  `encrypted_data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_dashboard_summary`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_dashboard_summary` (
`total_pelanggan_aktif` bigint(21)
,`total_pelanggan_nonaktif` bigint(21)
,`total_pelanggan_isolir` bigint(21)
,`tagihan_belum_bayar_bulan_ini` bigint(21)
,`tagihan_sudah_bayar_bulan_ini` bigint(21)
,`total_piutang` decimal(32,2)
,`pendapatan_bulan_ini` decimal(32,2)
,`total_online_sekarang` bigint(21)
,`pending_auto_invoices` bigint(21)
,`upcoming_auto_invoices` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_ftth_customer_connections`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_ftth_customer_connections` (
`id_pelanggan` int(11)
,`nama_pelanggan` varchar(100)
,`alamat_pelanggan` text
,`telepon_pelanggan` varchar(50)
,`ftth_status` enum('active','inactive','maintenance')
,`installation_date` date
,`technician` varchar(100)
,`nama_pop` varchar(100)
,`nama_olt` varchar(100)
,`ip_address` varchar(15)
,`pon_port` varchar(50)
,`nama_odc` varchar(100)
,`nama_odp` varchar(100)
,`customer_port` varchar(50)
,`onu_id` varchar(20)
,`signal_rx` varchar(20)
,`signal_tx` varchar(20)
,`nama_paket` varchar(100)
,`rate_limit_rx` varchar(20)
,`rate_limit_tx` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_ftth_infrastructure_summary`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_ftth_infrastructure_summary` (
`total_pop_aktif` bigint(21)
,`total_olt_aktif` bigint(21)
,`total_odc_aktif` bigint(21)
,`total_odp_aktif` bigint(21)
,`total_pon_ports` decimal(32,0)
,`pon_ports_tersedia` decimal(32,0)
,`odp_ports_tersedia` bigint(21)
,`odp_ports_terpakai` bigint(21)
,`pelanggan_ftth_aktif` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_ftth_topology`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_ftth_topology` (
`nama_pop` varchar(100)
,`pop_lokasi` varchar(200)
,`nama_olt` varchar(100)
,`ip_address` varchar(15)
,`olt_lokasi` varchar(200)
,`pon_port` varchar(50)
,`nama_odc` varchar(100)
,`odc_lokasi` varchar(200)
,`odc_ports_tersedia` int(11)
,`nama_odp` varchar(100)
,`odp_lokasi` varchar(200)
,`odp_ports_tersedia` int(11)
,`nama_pelanggan` varchar(100)
,`ftth_status` enum('active','inactive','maintenance')
,`customer_port` varchar(50)
,`onu_id` varchar(20)
,`signal_rx` varchar(20)
,`signal_tx` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_hotspot_sales_report`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_hotspot_sales_report` (
`id_sale` int(11)
,`tanggal_jual` date
,`harga_jual` decimal(10,2)
,`nama_pembeli` varchar(100)
,`telepon_pembeli` varchar(50)
,`keterangan_penjualan` text
,`voucher_username` varchar(100)
,`nama_voucher` varchar(100)
,`nama_profile` varchar(100)
,`harga_profile` decimal(10,2)
,`nama_penjual` varchar(100)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_hotspot_summary`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_hotspot_summary` (
`total_voucher_aktif` bigint(21)
,`total_voucher_terpakai` bigint(21)
,`total_voucher_expired` bigint(21)
,`total_voucher_nonaktif` bigint(21)
,`total_profile_aktif` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_invoice_auto_candidates`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_invoice_auto_candidates` (
`id_pelanggan` int(11)
,`nama_pelanggan` varchar(100)
,`telepon_pelanggan` varchar(50)
,`tgl_expired` date
,`invoice_due_date` date
,`harga_paket` decimal(10,2)
,`nama_paket` varchar(100)
,`days_until_invoice` int(7)
,`invoice_status` varchar(6)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_invoice_metrics`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_invoice_metrics` (
`total_tagihan` bigint(21)
,`belum_bayar` decimal(22,0)
,`sudah_bayar` decimal(22,0)
,`terlambat` decimal(22,0)
,`overdue` decimal(22,0)
,`due_today` decimal(22,0)
,`total_belum_bayar` decimal(32,2)
,`total_sudah_bayar` decimal(32,2)
,`total_overdue` decimal(32,2)
,`auto_generated_count` decimal(22,0)
,`manual_generated_count` decimal(22,0)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_laporan_pembayaran`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_laporan_pembayaran` (
`id_pembayaran` int(11)
,`id_pelanggan` int(11)
,`nama_pelanggan` varchar(100)
,`alamat_pelanggan` text
,`telepon_pelanggan` varchar(50)
,`bulan_tagihan` int(11)
,`tahun_tagihan` int(11)
,`tanggal_bayar` date
,`jumlah_bayar` decimal(10,2)
,`metode_bayar` varchar(50)
,`keterangan` text
,`pencatat` varchar(100)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_laporan_tagihan`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_laporan_tagihan` (
`id_tagihan` varchar(20)
,`id_pelanggan` int(11)
,`nama_pelanggan` varchar(100)
,`alamat_pelanggan` text
,`telepon_pelanggan` varchar(50)
,`nama_paket` varchar(100)
,`profile_name` varchar(100)
,`kecepatan` varchar(41)
,`bulan_tagihan` int(11)
,`tahun_tagihan` int(11)
,`jumlah_tagihan` decimal(10,2)
,`tgl_jatuh_tempo` date
,`status_tagihan` enum('belum_bayar','sudah_bayar','terlambat')
,`umur_tagihan` int(7)
,`created_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_monitoring_aktif`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_monitoring_aktif` (
`id_monitoring` int(11)
,`id_pelanggan` int(11)
,`nama_pelanggan` varchar(100)
,`alamat_pelanggan` text
,`nama_paket` varchar(100)
,`profile_name` varchar(100)
,`kecepatan` varchar(41)
,`mikrotik_username` varchar(100)
,`ip_address` varchar(20)
,`mac_address` varchar(20)
,`interface` varchar(50)
,`uptime` varchar(50)
,`bytes_in` bigint(20)
,`bytes_out` bigint(20)
,`session_start` timestamp
,`last_update` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_paket_internet_safe`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_paket_internet_safe` (
`id_paket` int(11)
,`nama_paket` varchar(100)
,`profile_name` varchar(100)
,`harga` decimal(10,2)
,`deskripsi` mediumtext
,`local_address` varchar(20)
,`remote_address` varchar(50)
,`session_timeout` varchar(20)
,`idle_timeout` varchar(20)
,`keepalive_timeout` varchar(20)
,`rate_limit_rx` varchar(20)
,`rate_limit_tx` varchar(20)
,`burst_limit_rx` varchar(20)
,`burst_limit_tx` varchar(20)
,`burst_threshold_rx` varchar(20)
,`burst_threshold_tx` varchar(20)
,`burst_time_rx` varchar(10)
,`burst_time_tx` varchar(10)
,`priority` tinyint(1)
,`parent_queue` varchar(50)
,`dns_server` varchar(100)
,`wins_server` varchar(50)
,`only_one` enum('yes','no')
,`shared_users` tinyint(4)
,`address_list` varchar(100)
,`incoming_filter` varchar(100)
,`outgoing_filter` varchar(100)
,`on_up` mediumtext
,`on_down` mediumtext
,`status_paket` enum('aktif','nonaktif')
,`sync_mikrotik` enum('yes','no')
,`last_sync` timestamp
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_dashboard_summary`
--
DROP TABLE IF EXISTS `v_dashboard_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_dashboard_summary`  AS SELECT (select count(0) from `data_pelanggan` where `data_pelanggan`.`status_aktif` = 'aktif') AS `total_pelanggan_aktif`, (select count(0) from `data_pelanggan` where `data_pelanggan`.`status_aktif` = 'nonaktif') AS `total_pelanggan_nonaktif`, (select count(0) from `data_pelanggan` where `data_pelanggan`.`status_aktif` = 'isolir') AS `total_pelanggan_isolir`, (select count(0) from `tagihan` where `tagihan`.`bulan_tagihan` = month(curdate()) and `tagihan`.`tahun_tagihan` = year(curdate()) and `tagihan`.`status_tagihan` in ('belum_bayar','terlambat')) AS `tagihan_belum_bayar_bulan_ini`, (select count(0) from `tagihan` where `tagihan`.`bulan_tagihan` = month(curdate()) and `tagihan`.`tahun_tagihan` = year(curdate()) and `tagihan`.`status_tagihan` = 'sudah_bayar') AS `tagihan_sudah_bayar_bulan_ini`, (select coalesce(sum(`tagihan`.`jumlah_tagihan`),0) from `tagihan` where `tagihan`.`status_tagihan` in ('belum_bayar','terlambat')) AS `total_piutang`, (select coalesce(sum(`pembayaran`.`jumlah_bayar`),0) from `pembayaran` where month(`pembayaran`.`tanggal_bayar`) = month(curdate()) and year(`pembayaran`.`tanggal_bayar`) = year(curdate())) AS `pendapatan_bulan_ini`, (select count(0) from `monitoring_pppoe` where `monitoring_pppoe`.`status` = 'active') AS `total_online_sekarang`, (select count(0) from `v_invoice_auto_candidates` where `v_invoice_auto_candidates`.`invoice_status` = 'READY') AS `pending_auto_invoices`, (select count(0) from `v_invoice_auto_candidates` where `v_invoice_auto_candidates`.`invoice_status` = 'SOON') AS `upcoming_auto_invoices` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_ftth_customer_connections`
--
DROP TABLE IF EXISTS `v_ftth_customer_connections`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ftth_customer_connections`  AS SELECT `dp`.`id_pelanggan` AS `id_pelanggan`, `dp`.`nama_pelanggan` AS `nama_pelanggan`, `dp`.`alamat_pelanggan` AS `alamat_pelanggan`, `dp`.`telepon_pelanggan` AS `telepon_pelanggan`, `dp`.`ftth_status` AS `ftth_status`, `dp`.`installation_date` AS `installation_date`, `dp`.`technician` AS `technician`, `pop`.`nama_pop` AS `nama_pop`, `olt`.`nama_olt` AS `nama_olt`, `olt`.`ip_address` AS `ip_address`, `pon`.`port_name` AS `pon_port`, `odc`.`nama_odc` AS `nama_odc`, `odp`.`nama_odp` AS `nama_odp`, `odpp`.`port_name` AS `customer_port`, `odpp`.`onu_id` AS `onu_id`, `odpp`.`signal_rx` AS `signal_rx`, `odpp`.`signal_tx` AS `signal_tx`, `pi`.`nama_paket` AS `nama_paket`, `pi`.`rate_limit_rx` AS `rate_limit_rx`, `pi`.`rate_limit_tx` AS `rate_limit_tx` FROM ((((((((`data_pelanggan` `dp` join `ftth_odp_ports` `odpp` on(`dp`.`odp_port_id` = `odpp`.`id`)) join `ftth_odp` `odp` on(`odpp`.`odp_id` = `odp`.`id`)) join `ftth_odc_ports` `odcp` on(`odp`.`odc_port_id` = `odcp`.`id`)) join `ftth_odc` `odc` on(`odcp`.`odc_id` = `odc`.`id`)) join `ftth_pon` `pon` on(`odc`.`pon_port_id` = `pon`.`id`)) join `ftth_olt` `olt` on(`pon`.`olt_id` = `olt`.`id`)) join `ftth_pop` `pop` on(`olt`.`pop_id` = `pop`.`id`)) left join `paket_internet` `pi` on(`dp`.`id_paket` = `pi`.`id_paket`)) WHERE `dp`.`odp_port_id` is not null ORDER BY `pop`.`nama_pop` ASC, `olt`.`nama_olt` ASC, `odc`.`nama_odc` ASC, `odp`.`nama_odp` ASC, `odpp`.`port_number` ASC ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_ftth_infrastructure_summary`
--
DROP TABLE IF EXISTS `v_ftth_infrastructure_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ftth_infrastructure_summary`  AS SELECT (select count(0) from `ftth_pop` where `ftth_pop`.`status` = 'active') AS `total_pop_aktif`, (select count(0) from `ftth_olt` where `ftth_olt`.`status` = 'active') AS `total_olt_aktif`, (select count(0) from `ftth_odc` where `ftth_odc`.`status` = 'active') AS `total_odc_aktif`, (select count(0) from `ftth_odp` where `ftth_odp`.`status` = 'active') AS `total_odp_aktif`, (select coalesce(sum(`ftth_olt`.`jumlah_port_pon`),0) from `ftth_olt`) AS `total_pon_ports`, (select coalesce(sum(`ftth_olt`.`port_tersedia`),0) from `ftth_olt`) AS `pon_ports_tersedia`, (select count(0) from `ftth_odp_ports` where `ftth_odp_ports`.`status` = 'available') AS `odp_ports_tersedia`, (select count(0) from `ftth_odp_ports` where `ftth_odp_ports`.`status` = 'connected') AS `odp_ports_terpakai`, (select count(0) from `data_pelanggan` where `data_pelanggan`.`ftth_status` = 'active') AS `pelanggan_ftth_aktif` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_ftth_topology`
--
DROP TABLE IF EXISTS `v_ftth_topology`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ftth_topology`  AS SELECT `pop`.`nama_pop` AS `nama_pop`, `pop`.`lokasi` AS `pop_lokasi`, `olt`.`nama_olt` AS `nama_olt`, `olt`.`ip_address` AS `ip_address`, `olt`.`lokasi` AS `olt_lokasi`, `pon`.`port_name` AS `pon_port`, `odc`.`nama_odc` AS `nama_odc`, `odc`.`lokasi` AS `odc_lokasi`, `odc`.`port_tersedia` AS `odc_ports_tersedia`, `odp`.`nama_odp` AS `nama_odp`, `odp`.`lokasi` AS `odp_lokasi`, `odp`.`port_tersedia` AS `odp_ports_tersedia`, `dp`.`nama_pelanggan` AS `nama_pelanggan`, `dp`.`ftth_status` AS `ftth_status`, `odpp`.`port_name` AS `customer_port`, `odpp`.`onu_id` AS `onu_id`, `odpp`.`signal_rx` AS `signal_rx`, `odpp`.`signal_tx` AS `signal_tx` FROM (((((((`ftth_pop` `pop` left join `ftth_olt` `olt` on(`pop`.`id` = `olt`.`pop_id`)) left join `ftth_pon` `pon` on(`olt`.`id` = `pon`.`olt_id`)) left join `ftth_odc` `odc` on(`pon`.`id` = `odc`.`pon_port_id`)) left join `ftth_odc_ports` `odcp` on(`odc`.`id` = `odcp`.`odc_id`)) left join `ftth_odp` `odp` on(`odcp`.`id` = `odp`.`odc_port_id`)) left join `ftth_odp_ports` `odpp` on(`odp`.`id` = `odpp`.`odp_id`)) left join `data_pelanggan` `dp` on(`odpp`.`connected_customer_id` = `dp`.`id_pelanggan`)) ORDER BY `pop`.`nama_pop` ASC, `olt`.`nama_olt` ASC, `pon`.`port_name` ASC, `odc`.`nama_odc` ASC, `odp`.`nama_odp` ASC ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_hotspot_sales_report`
--
DROP TABLE IF EXISTS `v_hotspot_sales_report`;


-- Struktur untuk view `v_invoice_auto_candidates`
--
DROP TABLE IF EXISTS `v_invoice_auto_candidates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_invoice_auto_candidates`  AS SELECT `dp`.`id_pelanggan` AS `id_pelanggan`, `dp`.`nama_pelanggan` AS `nama_pelanggan`, `dp`.`telepon_pelanggan` AS `telepon_pelanggan`, `dp`.`tgl_expired` AS `tgl_expired`, `dp`.`tgl_expired`- interval 10 day AS `invoice_due_date`, coalesce(`pi`.`harga`,0) AS `harga_paket`, coalesce(`pi`.`nama_paket`,'Tidak ada paket') AS `nama_paket`, to_days(`dp`.`tgl_expired` - interval 10 day) - to_days(curdate()) AS `days_until_invoice`, CASE WHEN `dp`.`tgl_expired` - interval 10 day <= curdate() THEN 'READY' WHEN `dp`.`tgl_expired` - interval 10 day <= curdate() + interval 3 day THEN 'SOON' ELSE 'FUTURE' END AS `invoice_status` FROM ((`data_pelanggan` `dp` left join `paket_internet` `pi` on(`dp`.`id_paket` = `pi`.`id_paket`)) left join `tagihan` `t` on(`t`.`id_pelanggan` = `dp`.`id_pelanggan` and `t`.`tgl_jatuh_tempo` = `dp`.`tgl_expired` - interval 10 day)) WHERE `dp`.`tgl_expired` is not null AND `dp`.`status_aktif` = 'aktif' AND `t`.`id_tagihan` is null ORDER BY `dp`.`tgl_expired` ASC ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_invoice_metrics`
--
DROP TABLE IF EXISTS `v_invoice_metrics`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_invoice_metrics`  AS SELECT count(0) AS `total_tagihan`, sum(case when `t`.`status_tagihan` = 'belum_bayar' then 1 else 0 end) AS `belum_bayar`, sum(case when `t`.`status_tagihan` = 'sudah_bayar' then 1 else 0 end) AS `sudah_bayar`, sum(case when `t`.`status_tagihan` = 'terlambat' then 1 else 0 end) AS `terlambat`, sum(case when `t`.`tgl_jatuh_tempo` < curdate() and `t`.`status_tagihan` <> 'sudah_bayar' then 1 else 0 end) AS `overdue`, sum(case when `t`.`tgl_jatuh_tempo` = curdate() and `t`.`status_tagihan` <> 'sudah_bayar' then 1 else 0 end) AS `due_today`, sum(case when `t`.`status_tagihan` = 'belum_bayar' then `t`.`jumlah_tagihan` else 0 end) AS `total_belum_bayar`, sum(case when `t`.`status_tagihan` = 'sudah_bayar' then `t`.`jumlah_tagihan` else 0 end) AS `total_sudah_bayar`, sum(case when `t`.`tgl_jatuh_tempo` < curdate() and `t`.`status_tagihan` <> 'sudah_bayar' then `t`.`jumlah_tagihan` else 0 end) AS `total_overdue`, sum(case when `t`.`auto_generated` = 'yes' then 1 else 0 end) AS `auto_generated_count`, sum(case when `t`.`auto_generated` = 'no' or `t`.`auto_generated` is null then 1 else 0 end) AS `manual_generated_count` FROM (`tagihan` `t` join `data_pelanggan` `dp` on(`t`.`id_pelanggan` = `dp`.`id_pelanggan`)) WHERE `dp`.`tgl_expired` is null OR `dp`.`tgl_expired` >= curdate() - interval 10 day ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_laporan_pembayaran`
--
DROP TABLE IF EXISTS `v_laporan_pembayaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_laporan_pembayaran`  AS SELECT `pb`.`id_pembayaran` AS `id_pembayaran`, `p`.`id_pelanggan` AS `id_pelanggan`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `p`.`alamat_pelanggan` AS `alamat_pelanggan`, `p`.`telepon_pelanggan` AS `telepon_pelanggan`, `t`.`bulan_tagihan` AS `bulan_tagihan`, `t`.`tahun_tagihan` AS `tahun_tagihan`, `pb`.`tanggal_bayar` AS `tanggal_bayar`, `pb`.`jumlah_bayar` AS `jumlah_bayar`, `pb`.`metode_bayar` AS `metode_bayar`, `pb`.`keterangan` AS `keterangan`, `u`.`nama_lengkap` AS `pencatat`, `pb`.`created_at` AS `created_at` FROM (((`pembayaran` `pb` join `data_pelanggan` `p` on(`pb`.`id_pelanggan` = `p`.`id_pelanggan`)) join `tagihan` `t` on(`pb`.`id_tagihan` = `t`.`id_tagihan`)) left join `users` `u` on(`pb`.`id_user_pencatat` = `u`.`id_user`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_laporan_tagihan`
--
DROP TABLE IF EXISTS `v_laporan_tagihan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_laporan_tagihan`  AS SELECT `t`.`id_tagihan` AS `id_tagihan`, `p`.`id_pelanggan` AS `id_pelanggan`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `p`.`alamat_pelanggan` AS `alamat_pelanggan`, `p`.`telepon_pelanggan` AS `telepon_pelanggan`, `pi`.`nama_paket` AS `nama_paket`, `pi`.`profile_name` AS `profile_name`, concat(`pi`.`rate_limit_rx`,'/',`pi`.`rate_limit_tx`) AS `kecepatan`, `t`.`bulan_tagihan` AS `bulan_tagihan`, `t`.`tahun_tagihan` AS `tahun_tagihan`, `t`.`jumlah_tagihan` AS `jumlah_tagihan`, `t`.`tgl_jatuh_tempo` AS `tgl_jatuh_tempo`, `t`.`status_tagihan` AS `status_tagihan`, to_days(curdate()) - to_days(`t`.`tgl_jatuh_tempo`) AS `umur_tagihan`, `t`.`created_at` AS `created_at` FROM ((`tagihan` `t` join `data_pelanggan` `p` on(`t`.`id_pelanggan` = `p`.`id_pelanggan`)) left join `paket_internet` `pi` on(`p`.`id_paket` = `pi`.`id_paket`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_monitoring_aktif`
--
DROP TABLE IF EXISTS `v_monitoring_aktif`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_monitoring_aktif`  AS SELECT `m`.`id_monitoring` AS `id_monitoring`, `p`.`id_pelanggan` AS `id_pelanggan`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `p`.`alamat_pelanggan` AS `alamat_pelanggan`, `pi`.`nama_paket` AS `nama_paket`, `pi`.`profile_name` AS `profile_name`, concat(`pi`.`rate_limit_rx`,'/',`pi`.`rate_limit_tx`) AS `kecepatan`, `m`.`mikrotik_username` AS `mikrotik_username`, `m`.`ip_address` AS `ip_address`, `m`.`mac_address` AS `mac_address`, `m`.`interface` AS `interface`, `m`.`uptime` AS `uptime`, `m`.`bytes_in` AS `bytes_in`, `m`.`bytes_out` AS `bytes_out`, `m`.`session_start` AS `session_start`, `m`.`updated_at` AS `last_update` FROM ((`monitoring_pppoe` `m` join `data_pelanggan` `p` on(`m`.`id_pelanggan` = `p`.`id_pelanggan`)) left join `paket_internet` `pi` on(`p`.`id_paket` = `pi`.`id_paket`)) WHERE `m`.`status` = 'active' ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_paket_internet_safe`
--
DROP TABLE IF EXISTS `v_paket_internet_safe`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_paket_internet_safe`  AS SELECT `paket_internet`.`id_paket` AS `id_paket`, `paket_internet`.`nama_paket` AS `nama_paket`, `paket_internet`.`profile_name` AS `profile_name`, `paket_internet`.`harga` AS `harga`, coalesce(`paket_internet`.`deskripsi`,'') AS `deskripsi`, coalesce(`paket_internet`.`local_address`,'') AS `local_address`, coalesce(`paket_internet`.`remote_address`,'') AS `remote_address`, coalesce(`paket_internet`.`session_timeout`,'') AS `session_timeout`, coalesce(`paket_internet`.`idle_timeout`,'') AS `idle_timeout`, `paket_internet`.`keepalive_timeout` AS `keepalive_timeout`, coalesce(`paket_internet`.`rate_limit_rx`,'') AS `rate_limit_rx`, coalesce(`paket_internet`.`rate_limit_tx`,'') AS `rate_limit_tx`, coalesce(`paket_internet`.`burst_limit_rx`,'') AS `burst_limit_rx`, coalesce(`paket_internet`.`burst_limit_tx`,'') AS `burst_limit_tx`, coalesce(`paket_internet`.`burst_threshold_rx`,'') AS `burst_threshold_rx`, coalesce(`paket_internet`.`burst_threshold_tx`,'') AS `burst_threshold_tx`, coalesce(`paket_internet`.`burst_time_rx`,'') AS `burst_time_rx`, coalesce(`paket_internet`.`burst_time_tx`,'') AS `burst_time_tx`, `paket_internet`.`priority` AS `priority`, coalesce(`paket_internet`.`parent_queue`,'') AS `parent_queue`, coalesce(`paket_internet`.`dns_server`,'') AS `dns_server`, coalesce(`paket_internet`.`wins_server`,'') AS `wins_server`, `paket_internet`.`only_one` AS `only_one`, `paket_internet`.`shared_users` AS `shared_users`, coalesce(`paket_internet`.`address_list`,'') AS `address_list`, coalesce(`paket_internet`.`incoming_filter`,'') AS `incoming_filter`, coalesce(`paket_internet`.`outgoing_filter`,'') AS `outgoing_filter`, coalesce(`paket_internet`.`on_up`,'') AS `on_up`, coalesce(`paket_internet`.`on_down`,'') AS `on_down`, `paket_internet`.`status_paket` AS `status_paket`, `paket_internet`.`sync_mikrotik` AS `sync_mikrotik`, `paket_internet`.`last_sync` AS `last_sync`, `paket_internet`.`created_at` AS `created_at`, `paket_internet`.`updated_at` AS `updated_at` FROM `paket_internet` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_timestamp` (`timestamp`);

--
-- Indeks untuk tabel `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `mikrotik_username` (`mikrotik_username`),
  ADD KEY `idx_paket` (`id_paket`),
  ADD KEY `idx_status` (`status_aktif`),
  ADD KEY `idx_nama` (`nama_pelanggan`),
  ADD KEY `idx_sync` (`sync_mikrotik`),
  ADD KEY `idx_odp_port` (`odp_port_id`),
  ADD KEY `fk_pelanggan_odp` (`odp_id`),
  ADD KEY `fk_pelanggan_pop` (`pop_id`);

--
-- Indeks untuk tabel `ftth_odc`
--
ALTER TABLE `ftth_odc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pon_port` (`pon_port_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `ftth_odc_ports`
--
ALTER TABLE `ftth_odc_ports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_odc` (`odc_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `ftth_odp`
--
ALTER TABLE `ftth_odp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_odc_port` (`odc_port_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `ftth_odp_ports`
--
ALTER TABLE `ftth_odp_ports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_odp` (`odp_id`),
  ADD KEY `idx_customer` (`connected_customer_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `ftth_olt`
--
ALTER TABLE `ftth_olt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_pop` (`pop_id`);

--
-- Indeks untuk tabel `ftth_pon`
--
ALTER TABLE `ftth_pon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_olt` (`olt_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `ftth_pop`
--
ALTER TABLE `ftth_pop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status` (`status`);


--
-- Indeks untuk tabel `monitoring_pppoe`
--
ALTER TABLE `monitoring_pppoe`
  ADD PRIMARY KEY (`id_monitoring`),
  ADD KEY `idx_pelanggan` (`id_pelanggan`),
  ADD KEY `idx_username` (`mikrotik_username`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_session_start` (`session_start`);

--
-- Indeks untuk tabel `paket_internet`
--
ALTER TABLE `paket_internet`
  ADD PRIMARY KEY (`id_paket`),
  ADD UNIQUE KEY `nama_paket` (`nama_paket`),
  ADD UNIQUE KEY `profile_name` (`profile_name`),
  ADD KEY `idx_status` (`status_paket`),
  ADD KEY `idx_sync` (`sync_mikrotik`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `idx_tagihan` (`id_tagihan`),
  ADD KEY `idx_pelanggan` (`id_pelanggan`),
  ADD KEY `idx_tanggal` (`tanggal_bayar`),
  ADD KEY `idx_user_pencatat` (`id_user_pencatat`);

--
-- Indeks untuk tabel `pengaturan_perusahaan`
--
ALTER TABLE `pengaturan_perusahaan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `radcheck`
--
ALTER TABLE `radcheck`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD UNIQUE KEY `uk_pelanggan_bulan_tahun` (`id_pelanggan`,`bulan_tagihan`,`tahun_tagihan`),
  ADD KEY `idx_status` (`status_tagihan`),
  ADD KEY `idx_jatuh_tempo` (`tgl_jatuh_tempo`),
  ADD KEY `idx_auto_generate` (`id_pelanggan`,`tgl_jatuh_tempo`),
  ADD KEY `idx_bulan_tahun` (`bulan_tagihan`,`tahun_tagihan`),
  ADD KEY `fk_tagihan_generated_by` (`generated_by`);

--
-- Indeks untuk tabel `transaksi_lain`
--
ALTER TABLE `transaksi_lain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tanggal` (`tanggal`),
  ADD KEY `idx_jenis` (`jenis`),
  ADD KEY `idx_kategori` (`kategori`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_status` (`status`);

--
-- Indeks untuk tabel `voucher_history`
--
ALTER TABLE `voucher_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_profile_name` (`profile_name`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_batch_id` (`batch_id`);

--
-- Indeks untuk tabel `voucher_temp`
--
ALTER TABLE `voucher_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_batch_id` (`batch_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `ftth_odc`
--
ALTER TABLE `ftth_odc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ftth_odc_ports`
--
ALTER TABLE `ftth_odc_ports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `ftth_odp`
--
ALTER TABLE `ftth_odp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `ftth_odp_ports`
--
ALTER TABLE `ftth_odp_ports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `ftth_olt`
--
ALTER TABLE `ftth_olt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ftth_pon`
--
ALTER TABLE `ftth_pon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `ftth_pop`
--
ALTER TABLE `ftth_pop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;



--
-- AUTO_INCREMENT untuk tabel `monitoring_pppoe`
--
ALTER TABLE `monitoring_pppoe`
  MODIFY `id_monitoring` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `paket_internet`
--
ALTER TABLE `paket_internet`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengaturan_perusahaan`
--
ALTER TABLE `pengaturan_perusahaan`
  MODIFY `id_pengaturan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `radcheck`
--
ALTER TABLE `radcheck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transaksi_lain`
--
ALTER TABLE `transaksi_lain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `voucher_history`
--
ALTER TABLE `voucher_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `voucher_temp`
--
ALTER TABLE `voucher_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD CONSTRAINT `fk_pelanggan_odp` FOREIGN KEY (`odp_id`) REFERENCES `ftth_odp` (`id`),
  ADD CONSTRAINT `fk_pelanggan_odp_port` FOREIGN KEY (`odp_port_id`) REFERENCES `ftth_odp_ports` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pelanggan_paket` FOREIGN KEY (`id_paket`) REFERENCES `paket_internet` (`id_paket`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pelanggan_pop` FOREIGN KEY (`pop_id`) REFERENCES `ftth_pop` (`id`);

--
-- Ketidakleluasaan untuk tabel `ftth_odc`
--
ALTER TABLE `ftth_odc`
  ADD CONSTRAINT `fk_odc_pon` FOREIGN KEY (`pon_port_id`) REFERENCES `ftth_pon` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ftth_odc_ports`
--
ALTER TABLE `ftth_odc_ports`
  ADD CONSTRAINT `fk_odc_port_odc` FOREIGN KEY (`odc_id`) REFERENCES `ftth_odc` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ftth_odp`
--
ALTER TABLE `ftth_odp`
  ADD CONSTRAINT `fk_odp_odc_port` FOREIGN KEY (`odc_port_id`) REFERENCES `ftth_odc_ports` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ftth_odp_ports`
--
ALTER TABLE `ftth_odp_ports`
  ADD CONSTRAINT `fk_odp_port_customer` FOREIGN KEY (`connected_customer_id`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_odp_port_odp` FOREIGN KEY (`odp_id`) REFERENCES `ftth_odp` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ftth_olt`
--
ALTER TABLE `ftth_olt`
  ADD CONSTRAINT `fk_olt_pop` FOREIGN KEY (`pop_id`) REFERENCES `ftth_pop` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `ftth_pon`
--
ALTER TABLE `ftth_pon`
  ADD CONSTRAINT `fk_pon_olt` FOREIGN KEY (`olt_id`) REFERENCES `ftth_olt` (`id`) ON DELETE CASCADE;


-- Ketidakleluasaan untuk tabel `monitoring_pppoe`
--
ALTER TABLE `monitoring_pppoe`
  ADD CONSTRAINT `fk_monitoring_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pembayaran_tagihan` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pembayaran_user` FOREIGN KEY (`id_user_pencatat`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `fk_tagihan_generated_by` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tagihan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
