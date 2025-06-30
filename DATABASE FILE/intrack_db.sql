-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 25 Jun 2024 pada 06.25
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `empattendanceci`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance`
--

CREATE TABLE `attendance` (
                              `id` int(11) NOT NULL,
                              `username` char(6) NOT NULL,
                              `intern_id` int(3) UNSIGNED ZEROFILL NOT NULL,
                              `division_id` char(3) NOT NULL,
                              `in_time` int(11) NOT NULL,
                              `notes` varchar(120) NOT NULL,
                              `image` varchar(50) NOT NULL,
                              `in_status` varchar(15) NOT NULL,
                              `out_time` int(11) NOT NULL,
                              `out_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `attendance`
-- --------------------------------------------------------

--
-- Struktur dari tabel `division`
--

CREATE TABLE `division` (
                            `id` char(3) NOT NULL,
                            `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `division`
--

INSERT INTO `division` (`id`, `name`) VALUES
                                          ('ACD', 'Accounting Division'),
                                          ('ADM', 'Admin Division'),
                                          ('HRD', 'Human Resource Division'),
                                          ('PCD', 'Production Controller Division'),
                                          ('PLD', 'Planner Division'),
                                          ('QCD', 'Quality Control Division'),
                                          ('SCD', 'Security Division'),
                                          ('STD', 'Store Division');

-- --------------------------------------------------------

--
-- Struktur dari tabel `intern`
--

CREATE TABLE `intern` (
                          `id` int(3) UNSIGNED ZEROFILL NOT NULL,
                          `name` varchar(50) NOT NULL,
                          `email` varchar(128) NOT NULL,
                          `gender` char(1) NOT NULL,
                          `image` varchar(128) NOT NULL,
                          `birth_date` date NOT NULL,
                          `hire_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `intern`
--

INSERT INTO `intern` (`id`, `name`, `email`, `gender`, `image`, `birth_date`, `hire_date`) VALUES
                                                                                               (001, 'Nizar', 'devi@gmail.com', 'M', 'default.png', '2001-09-11', '2020-03-01'),
                                                                                               (002, 'Razif', 'intan@gmail.com', 'M', 'default.png', '2001-11-01', '2020-03-01'),
                                                                                               (003, 'Faisal', 'herman@gmail.com', 'M', 'default.png', '2001-11-21', '2020-03-12'),
                                                                                               (004, 'Putri', 'andi@gmail.com', 'F', 'default.png', '2001-09-01', '2020-03-01'),
                                                                                               (025, 'Admin ', 'admin@admin.com', 'M', 'default.png', '0000-00-00', '0000-00-00'),
                                                                                               (026, 'Savira', 'christine@gmail.com', 'F', 'default.png', '2000-06-01', '2021-05-16'),
                                                                                               (028, 'Maulana', 'iqbaldwinulhakim04@gmail.com', 'M', 'default.png', '2002-01-01', '2024-06-25'),
                                                                                               (029, 'Rizki', 'rizki123@gmail.com', 'M', 'default.png', '2001-01-01', '2024-06-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `intern_division`
--

CREATE TABLE `intern_division` (
                                   `id` int(3) NOT NULL,
                                   `intern_id` int(3) UNSIGNED ZEROFILL NOT NULL,
                                   `division_id` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `intern_division`
--

INSERT INTO `intern_division` (`id`, `intern_id`, `division_id`) VALUES
                                                                     (1, 001, 'HRD'),
                                                                     (2, 002, 'ACD'),
                                                                     (3, 003, 'QCD'),
                                                                     (4, 004, 'SCD'),
                                                                     (5, 005, 'STD'),
                                                                     (6, 006, 'ACD'),
                                                                     (7, 007, 'PLD'),
                                                                     (8, 008, 'STD'),
                                                                     (9, 009, 'STD'),
                                                                     (10, 010, 'PCD'),
                                                                     (21, 011, 'ADM'),
                                                                     (25, 024, 'HRD'),
                                                                     (26, 026, 'STD'),
                                                                     (27, 027, 'QCD'),
                                                                     (28, 028, 'ADM'),
                                                                     (29, 029, 'WDT');

-- --------------------------------------------------------

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
                         `username` char(6) NOT NULL,
                         `password` varchar(128) NOT NULL,
                         `intern_id` int(3) UNSIGNED ZEROFILL NOT NULL,
                         `role_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `intern_id`, `role_id`) VALUES
                                                                         ('ACD002', '$2y$10$5nv5ehyMVdljfKJ6izsOqOimsbv.cbzU.XLB9ji9zbA.eICdSrNvO', 002, 2),
                                                                         ('ADM011', '$2y$10$BKpQcs4XKavCcYdFWujzx.Xqb7r9eNkDrOYss2VNXrMJUUpm1agUC', 011, 2),
                                                                         ('admin', '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6', 025, 1),
                                                                         ('HRD001', '$2y$10$fGPRpIO8GGvTjYJbSh5Gmu5MAhtKL/vWQnOfmuQZQub.UpvQsK47O', 001, 2),
                                                                         ('PCD010', '$2y$10$BKpQcs4XKavCcYdFWujzx.Xqb7r9eNkDrOYss2VNXrMJUUpm1agUC', 010, 2),
                                                                         ('QCD027', '$2y$10$peALJo.JKZyD6uMBd41UfuHGQSJe7ExOfDhPITvDbSRRXeWUGY9xy', 027, 2),
                                                                         ('STD005', '$2y$10$hr35h1fIySFYCSRVL2jRD.RuYa9WtJCEJkkqvQfPboYK7VwURpLim', 005, 2),
                                                                         ('STD008', '$2y$10$8PGnFaiZPYtcIGrwzMmVZuNKbUb/A88f0NZOA9QVgHaUIJ6ddg.Si', 008, 2),
                                                                         ('STD026', '$2y$10$8WNMvEEgNPWyRuSeeLDE1uXwnBkYNJE/heLT1zWbsUfYb/wKFyYIy', 026, 2),
                                                                         ('WDT029', '$2y$10$TWPWE1xKbHI5Aqoe8cVpuOsD6gqse0DQhaEl5W1elVJl80utRn6PG', 029, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access`
--

CREATE TABLE `user_access` (
                               `id` int(2) NOT NULL,
                               `role_id` int(1) NOT NULL,
                               `menu_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user_access`
--

INSERT INTO `user_access` (`id`, `role_id`, `menu_id`) VALUES
                                                           (1, 1, 1),
                                                           (2, 1, 2),
                                                           (3, 2, 3),
                                                           (4, 2, 4),
                                                           (5, 1, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
                             `id` int(2) NOT NULL,
                             `menu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
                                           (1, 'Admin'),
                                           (2, 'Master'),
                                           (3, 'Attendance'),
                                           (4, 'Profile'),
                                           (5, 'Report');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
                             `id` int(1) NOT NULL,
                             `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `name`) VALUES
                                           (1, 'Admin'),
                                           (2, 'Intern');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_submenu`
--

CREATE TABLE `user_submenu` (
                                `id` int(2) NOT NULL,
                                `menu_id` int(2) NOT NULL,
                                `title` varchar(20) NOT NULL,
                                `url` varchar(50) NOT NULL,
                                `icon` varchar(50) NOT NULL,
                                `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user_submenu`
--

INSERT INTO `user_submenu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
                                                                                      (1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
                                                                                      (2, 2, 'Division', 'master', 'fas fa-fw fa-building', 1),
                                                                                      (3, 2, 'Intern', 'master/intern', 'fas fa-fw fa-id-badge', 1),
                                                                                      (4, 3, 'Attendance Form', 'attendance', 'fas fa-fw fa-clipboard-list', 1),
                                                                                      (5, 3, 'Statistics', 'attendance/stats', 'fas fa-fw fa-chart-pie', 0),
                                                                                      (6, 4, 'My Profile', 'profile', 'fas fa-fw fa-id-card', 1),
                                                                                      (7, 2, 'Users', 'master/users', 'fas fa-fw fa-users', 1),
                                                                                      (8, 5, 'Print Report', 'report', 'fas fa-fw fa-paste', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `attendance`
--
ALTER TABLE `attendance`
    ADD PRIMARY KEY (`id`),
    ADD KEY `username` (`username`),
    ADD KEY `intern_id` (`intern_id`),
    ADD KEY `division_id` (`division_id`);

--
-- Indeks untuk tabel `division`
--
ALTER TABLE `division`
    ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `intern`
--
ALTER TABLE `intern`
    ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `intern_division`
--
ALTER TABLE `intern_division`
    ADD PRIMARY KEY (`id`),
    ADD KEY `intern_division_ibfk_1` (`intern_id`),
    ADD KEY `intern_division_ibfk_2` (`division_id`);



--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`username`),
    ADD KEY `intern_id` (`intern_id`),
    ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `user_access`
--
ALTER TABLE `user_access`
    ADD PRIMARY KEY (`id`),
    ADD KEY `menu_id` (`menu_id`),
    ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
    ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
    ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_submenu`
--
ALTER TABLE `user_submenu`
    ADD PRIMARY KEY (`id`),
    ADD KEY `menu_id` (`menu_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `attendance`
--
ALTER TABLE `attendance`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `intern`
--
ALTER TABLE `intern`
    MODIFY `id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `intern_division`
--
ALTER TABLE `intern_division`
    MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;



--
-- AUTO_INCREMENT untuk tabel `user_access`
--
ALTER TABLE `user_access`
    MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
    MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
    MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_submenu`
--
ALTER TABLE `user_submenu`
    MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
