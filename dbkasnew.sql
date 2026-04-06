-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 10:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbkasnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_penghutang` varchar(100) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `status` enum('belum lunas','lunas') NOT NULL,
  `tanggal_lunas` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `isi_paket` text NOT NULL,
  `harga` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_paket`, `nama_paket`, `kategori`, `isi_paket`, `harga`, `stock`) VALUES
(1, 'Iphone 15 pro 128gb', 'IOS', 'Apple iPhone 15 Pro 128GB\r\n• Layar 6.1\" Super Retina XDR OLED 120Hz\r\n• Chipset Apple A17 Pro\r\n• Kamera 48MP + 12MP + 12MP\r\n• Kamera depan 12MP\r\n• Baterai 3274 mAh Fast Charging\r\n• USB-C Charging\r\n• Face ID\r\n• iOS 17\r\n• Warna: Natural Titanium', 9800000, 5),
(2, 'Google Pixel 9 pro 128gb', 'Android', 'Google Pixel 9 Pro 128GB\r\n\r\n• Layar 6.3\" LTPO OLED 120Hz\r\n• Chipset Google Tensor G4\r\n• RAM 16GB\r\n• Kamera 50MP + 48MP + 48MP\r\n• Kamera depan 42MP\r\n• Baterai 4700 mAh Fast Charging\r\n• Android 14\r\n• 5G + WiFi 6E\r\n• Fingerprint Under Display\r\n• Warna: Obsidian / Hazel / Porcelain / Rose Quartz', 10500000, 15),
(3, 'Huawei 70 ultra 512gb', 'Huawei', 'Huawei Pura 70 Ultra 512GB\r\n\r\n• Layar 6.8\" LTPO OLED 120Hz\r\n• Kamera 50MP + 40MP + 50MP\r\n• Kamera depan 13MP\r\n• RAM 16GB\r\n• Storage 512GB\r\n• Baterai 5200 mAh\r\n• Fast Charging 100W\r\n• Wireless Charging 80W\r\n• Fingerprint Under Display\r\n• 5G + WiFi 6\r\n• IP68 Water Resistant', 11000000, 10),
(4, 'Iphone 15 pro max 256gb', 'IOS', 'Apple iPhone 15 Pro Max 256GB\r\n\r\n• Layar 6.7\" Super Retina XDR OLED 120Hz\r\n• Chipset Apple A17 Pro\r\n• RAM 8GB\r\n• Kamera 48MP + 12MP + 12MP\r\n• Kamera depan 12MP\r\n• Baterai tahan hingga 29 jam video\r\n• USB-C Charging\r\n• Face ID\r\n• iOS 17\r\n• Warna: Black / White / Blue / Natural Titanium', 12000000, 5),
(5, 'Samsung Galaxy A55 256gb', 'Android', 'Samsung Galaxy A55 5G 256GB\r\n\r\n• Layar 6.6\" Super AMOLED 120Hz\r\n• Chipset Exynos 1480\r\n• RAM 8GB / 12GB\r\n• Kamera 50MP + 12MP + 5MP\r\n• Kamera depan 32MP\r\n• Baterai 5000 mAh Fast Charging\r\n• Android 14 One UI\r\n• 5G + WiFi 6\r\n• Fingerprint Under Display\r\n• IP67 Water Resistant', 4000000, 6),
(6, 'Asus Zenfone 9 256gb', 'Android', 'ASUS Zenfone 9 256GB\r\n\r\n• Layar 5.9\" AMOLED 120Hz\r\n• Chipset Snapdragon 8+ Gen 1\r\n• RAM 8GB / 16GB\r\n• Kamera 50MP + 12MP\r\n• Kamera depan 12MP\r\n• Baterai 4300 mAh Fast Charging\r\n• Android 12 ZenUI\r\n• 5G + WiFi 6\r\n• Fingerprint Side Mounted\r\n• Stereo Speaker + 3.5mm Jack', 3500000, 1),
(7, 'Samsung Galaxy S25 Ultra 256gb', 'Android', 'Samsung Galaxy S25 Ultra 256GB\r\n\r\n• Layar 6.9\" Dynamic AMOLED 120Hz\r\n• Chipset Snapdragon 8 Elite\r\n• RAM 12GB\r\n• Kamera 200MP + 50MP + 50MP + 10MP\r\n• Kamera depan 12MP\r\n• Baterai 5000 mAh Fast Charging\r\n• Android 15 One UI\r\n• 5G + WiFi 7\r\n• S Pen Support\r\n• IP68 Water Resistant', 15500000, 3),
(8, 'Red Magic 7 pro 512gb', 'Android', 'Red Magic 7 Pro 256GB\r\n\r\n• Layar 6.8\" AMOLED 120Hz\r\n• Chipset Snapdragon 8 Gen 1\r\n• RAM hingga 16GB\r\n• Kamera 64MP + 8MP + 2MP\r\n• Kamera depan 16MP Under Display\r\n• Baterai 5000 mAh Fast Charging\r\n• 5G + WiFi 6\r\n• Gaming Shoulder Trigger\r\n• Built-in Cooling Fan RGB\r\n• Stereo Speaker + 3.5mm Jack', 7000000, 8),
(9, 'Ipad Mini 4 128gb', 'IOS', 'Apple iPad Mini 4 128GB\r\n\r\n• Layar 7.9\" Retina Display\r\n• Chipset Apple A8\r\n• RAM 2GB\r\n• Kamera belakang 8MP\r\n• Kamera depan 1.2MP\r\n• Baterai sekitar 5124 mAh\r\n• Touch ID Fingerprint\r\n• WiFi + Bluetooth\r\n• iPadOS Support\r\n• Desain aluminium tipis', 4500000, 6),
(10, 'Iphone 11 64gb', 'IOS', 'iPhone 11 128GB\r\n\r\n• Layar 6.1\" Liquid Retina HD\r\n• Chipset Apple A13 Bionic\r\n• RAM 4GB\r\n• Kamera 12MP + 12MP Ultra Wide\r\n• Kamera depan 12MP\r\n• Baterai sekitar 3110 mAh\r\n• Face ID\r\n• 4G LTE + WiFi 6\r\n• IP68 Water Resistant\r\n• iOS Support', 3500000, 8),
(11, 'Iphone 14 128gb', 'IOS', 'iPhone 14 128GB\r\n\r\n• Layar 6.1\" Super Retina XDR OLED\r\n• Chipset Apple A15 Bionic\r\n• RAM 6GB\r\n• Kamera 12MP + 12MP Ultra Wide\r\n• Kamera depan 12MP\r\n• Baterai 3279 mAh\r\n• Face ID\r\n• 5G + WiFi 6\r\n• IP68 Water Resistant\r\n• iOS Support', 7000000, 8),
(12, 'Samsung Z Flip 5 256gb', 'Android', 'Samsung Galaxy Z Flip5 256GB\r\n\r\n• Layar 6.7\" Dynamic AMOLED 120Hz\r\n• Cover Screen 3.4\"\r\n• Chipset Snapdragon 8 Gen 2\r\n• RAM 8GB\r\n• Kamera 12MP + 12MP\r\n• Kamera depan 10MP\r\n• Baterai 3700 mAh Fast Charging\r\n• 5G + WiFi 6E\r\n• IPX8 Water Resistant\r\n• Fingerprint Side', 6000000, 3),
(13, 'Samsung Z Fold 6 512gb', 'Android', 'Samsung Galaxy Z Fold6 512GB\r\n\r\n• Layar utama 7.6\" Dynamic AMOLED 120Hz\r\n• Cover Screen 6.3\" AMOLED\r\n• Chipset Snapdragon 8 Gen 3\r\n• RAM 12GB\r\n• Kamera 50MP + 10MP + 12MP\r\n• Kamera depan 4MP Under Display\r\n• Baterai 4400 mAh Fast Charging\r\n• 5G + WiFi 6E\r\n• Galaxy AI + Samsung DeX\r\n• IP48 Water Resistant', 13000000, 2),
(14, 'Poco X3 Pro 256gb', 'Android', 'Poco X3 Pro 256GB\r\n\r\n• Layar 6.67\" FHD+ 120Hz\r\n• Chipset Snapdragon 860\r\n• RAM 8GB\r\n• Kamera 48MP + 8MP + 2MP + 2MP\r\n• Kamera depan 20MP\r\n• Baterai 5160 mAh Fast Charging\r\n• Stereo Speaker\r\n• 4G + WiFi + NFC\r\n• Fingerprint Side\r\n• Gorilla Glass 6', 1800000, 8),
(15, 'Iphone 12 128gb', 'IOS', 'iPhone 12 128GB\r\n\r\n• Layar 6.1\" Super Retina XDR OLED\r\n• Chipset Apple A14 Bionic\r\n• RAM 4GB\r\n• Kamera 12MP + 12MP Ultra Wide\r\n• Kamera depan 12MP\r\n• Baterai 2815 mAh Fast Charging\r\n• 5G + WiFi 6\r\n• Face ID\r\n• IP68 Water Resistant\r\n• MagSafe Wireless Charging', 4600000, 9),
(16, 'Iphone 12 mini 64gb', 'IOS', 'iPhone 12 mini 128GB\r\n\r\n• Layar 5.4\" Super Retina XDR OLED\r\n• Chipset Apple A14 Bionic\r\n• RAM 4GB\r\n• Kamera 12MP + 12MP Ultra Wide\r\n• Kamera depan 12MP\r\n• Baterai 2227 mAh Fast Charging\r\n• 5G + WiFi 6\r\n• Face ID\r\n• IP68 Water Resistant\r\n• MagSafe Wireless Charging', 4000000, 3),
(17, 'Iphone 14 128gb', 'IOS', 'iPhone 14 128GB\r\n\r\n• Layar 6.1\" Super Retina XDR OLED\r\n• Chipset Apple A15 Bionic\r\n• RAM 6GB\r\n• Kamera 12MP + 12MP Ultra Wide\r\n• Kamera depan 12MP\r\n• Baterai 3279 mAh Fast Charging\r\n• 5G + WiFi 6\r\n• Face ID\r\n• IP68 Water Resistant\r\n• MagSafe Wireless Charging', 7000000, 1),
(18, 'Asus ROG Phone 8 256gb', 'Android', 'ASUS ROG Phone 8 256GB\r\n\r\n• Layar 6.78\" AMOLED 165Hz\r\n• Chipset Snapdragon 8 Gen 3\r\n• RAM 12GB\r\n• Kamera 50MP + 13MP + 32MP\r\n• Kamera depan 32MP\r\n• Baterai 5500 mAh Fast Charging\r\n• 5G + WiFi 7\r\n• AirTrigger Gaming Button\r\n• IP68 Water Resistant\r\n• Android 14 ROG UI', 6500000, 2),
(19, 'Xiaomi 13 ultra 512gb', 'Android', 'Xiaomi 13 Ultra 256GB\r\n\r\n• Layar 6.73\" LTPO AMOLED 120Hz\r\n• Chipset Snapdragon 8 Gen 2\r\n• RAM 12GB\r\n• Kamera 50MP + 50MP + 50MP + 50MP (Leica)\r\n• Kamera depan 32MP\r\n• Baterai 5000 mAh Fast Charging 90W\r\n• Wireless Charging 50W\r\n• 5G + WiFi 6\r\n• Fingerprint Under Display\r\n• IP68 Water Resistant', 8500000, 5),
(20, 'Iqoo 15 512gb', 'Android', 'iQOO 15 256GB\r\n\r\n• Layar 6.85\" AMOLED 2K 144Hz\r\n• Chipset Snapdragon 8 Elite Gen 5\r\n• RAM 12GB\r\n• Kamera 50MP + 50MP Periscope\r\n• Kamera depan 32MP\r\n• Baterai 7000 mAh Fast Charging 100W\r\n• Wireless Charging 40W\r\n• 5G + WiFi 7\r\n• Fingerprint Ultrasonic\r\n• IP68 Water Resistant', 11500000, 7);

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan`
--

CREATE TABLE `pendapatan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text NOT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendapatan`
--

INSERT INTO `pendapatan` (`id`, `tanggal`, `jumlah`, `keterangan`, `total`) VALUES
(34, '2026-03-12', 11500000.00, 'Pembayaran cash', 11500000),
(35, '2026-03-13', 29000000.00, 'Pembayaran qr', 29000000),
(36, '2026-03-13', 24000000.00, 'Pembayaran cash', 24000000),
(37, '2026-03-13', 21000000.00, 'Pembayaran cash', 21000000),
(38, '2026-03-13', 21000000.00, 'Pembayaran cash', 21000000),
(39, '2026-03-13', 23000000.00, 'Pembayaran qr', 23000000),
(40, '2026-03-18', 16000000.00, 'Pembayaran qr', 16000000),
(41, '2026-04-06', 22000000.00, 'Pembayaran qr', 22000000);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text NOT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekap`
--

CREATE TABLE `rekap` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pendapatan` decimal(15,2) NOT NULL,
  `pengeluaran` decimal(15,2) NOT NULL,
  `hutang_masuk` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('pemilik','karyawan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'dimas', 'dim', '$2y$10$7k7V7cCQk6AHgwhZVpidOOSliNdwyC0mUpzaDLHR3BjC31dEEMdLi', 'pemilik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pendapatan`
--
ALTER TABLE `pendapatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekap`
--
ALTER TABLE `rekap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pendapatan`
--
ALTER TABLE `pendapatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rekap`
--
ALTER TABLE `rekap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
