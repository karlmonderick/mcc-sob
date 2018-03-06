-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2018 at 02:02 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sob`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ay_from` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ay_to` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `created_at`, `updated_at`, `ay_from`, `ay_to`) VALUES
(2, '2018-02-13 21:29:12', '2018-02-13 21:29:12', '2018', '2019'),
(3, '2018-02-13 23:33:19', '2018-02-13 23:33:19', '2019', '2020');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nature` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `endDate` date NOT NULL,
  `venue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participants` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expectedAttendees` int(11) NOT NULL,
  `personInCharge` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budgetDescription` text COLLATE utf8mb4_unicode_ci,
  `buggetTotal` double DEFAULT NULL,
  `requestedBy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_id` tinyint(11) NOT NULL,
  `approval` tinyint(1) NOT NULL,
  `organization_ay_id` int(10) UNSIGNED DEFAULT NULL,
  `notify` int(11) DEFAULT NULL,
  `notify2` int(11) DEFAULT NULL,
  `notify3` int(11) DEFAULT NULL,
  `released` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `created_at`, `updated_at`, `title`, `nature`, `date`, `endDate`, `venue`, `participants`, `expectedAttendees`, `personInCharge`, `budgetDescription`, `buggetTotal`, `requestedBy`, `review_id`, `approval`, `organization_ay_id`, `notify`, `notify2`, `notify3`, `released`) VALUES
(1, '2018-02-13 22:21:01', '2018-02-14 04:48:14', 'Puso Day', 'Non-Academic', '2018-02-21', '2018-02-21', 'School', 'student', 500, '{\"1\":\"Karl Cayanan\"}', '{\"Description\":{\"1\":null},\"Cost\":{\"1\":null},\"Quantity\":{\"1\":null}}', 0, '16', 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `budget` double NOT NULL,
  `remaining` double NOT NULL,
  `fund_id` int(10) UNSIGNED NOT NULL,
  `organization_ay_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`id`, `created_at`, `updated_at`, `budget`, `remaining`, `fund_id`, `organization_ay_id`) VALUES
(1, '2018-02-13 22:01:45', '2018-02-13 22:01:45', 7500, 7500, 1, 2),
(2, '2018-02-13 22:01:46', '2018-02-13 22:01:46', 15000, 15000, 1, 3),
(3, '2018-02-13 22:01:46', '2018-02-13 22:01:46', 30000, 30000, 1, 4),
(4, '2018-02-13 22:01:47', '2018-02-13 22:01:47', 75000, 75000, 2, 6),
(5, '2018-02-13 22:01:47', '2018-02-13 22:01:47', 75000, 75000, 2, 5),
(6, '2018-02-13 22:01:47', '2018-02-13 22:01:47', 75000, 75000, 3, 1),
(7, '2018-02-13 22:01:47', '2018-02-13 22:01:47', 7500, 7500, 3, 2),
(8, '2018-02-13 22:01:48', '2018-02-13 22:01:48', 15000, 15000, 3, 3),
(9, '2018-02-13 22:01:48', '2018-02-13 22:01:48', 30000, 30000, 3, 4),
(10, '2018-02-13 22:01:48', '2018-02-13 22:01:48', 7500, 7500, 5, 11),
(11, '2018-02-13 22:01:48', '2018-02-13 22:01:48', 6750, 6750, 5, 8),
(12, '2018-02-13 22:01:48', '2018-02-13 22:01:48', 6750, 6750, 5, 9),
(13, '2018-02-13 22:01:48', '2018-02-13 22:01:48', 6750, 6750, 5, 10),
(14, '2018-02-13 22:01:48', '2018-02-13 22:01:48', 27000, 27000, 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `calendar_activities`
--

CREATE TABLE `calendar_activities` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `nature` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `p_budget` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar_activities`
--

INSERT INTO `calendar_activities` (`id`, `created_at`, `updated_at`, `name`, `nature`, `date`, `p_budget`) VALUES
(4, '2018-02-14 03:25:55', '2018-02-14 03:41:01', 'pusu day', 'Non-Academic', '2018-02-14', 9000);

-- --------------------------------------------------------

--
-- Table structure for table `cash_requests`
--

CREATE TABLE `cash_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cash_amount` double NOT NULL,
  `organization_ay_id` double NOT NULL,
  `budget_id` double NOT NULL,
  `verification_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `released` int(11) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `notify_officer` int(11) DEFAULT NULL,
  `notify_igp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_requests`
--

INSERT INTO `cash_requests` (`id`, `created_at`, `updated_at`, `cash_amount`, `organization_ay_id`, `budget_id`, `verification_code`, `released`, `activity_id`, `notify_officer`, `notify_igp`) VALUES
(7, '2018-02-14 04:48:14', '2018-02-14 04:48:14', 0, 1, 6, '5a84300e4a4d4', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_academic_years`
--

CREATE TABLE `enrolled_academic_years` (
  `id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `no_of_students` double NOT NULL,
  `institute_id` int(10) UNSIGNED NOT NULL,
  `ay_id` int(10) UNSIGNED NOT NULL,
  `sem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrolled_academic_years`
--

INSERT INTO `enrolled_academic_years` (`id`, `created_at`, `updated_at`, `no_of_students`, `institute_id`, `ay_id`, `sem`) VALUES
(1, '2018-02-13 22:01:02', '2018-02-13 22:01:02', 100, 2, 2, 1),
(2, '2018-02-13 22:01:03', '2018-02-13 22:01:03', 200, 3, 2, 1),
(3, '2018-02-13 22:01:03', '2018-02-13 22:01:03', 400, 4, 2, 1),
(4, '2018-02-13 22:01:03', '2018-02-13 22:01:03', 200, 5, 2, 1),
(5, '2018-02-13 22:01:04', '2018-02-13 22:01:04', 100, 6, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `remaining` int(11) NOT NULL,
  `semester` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ay_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `created_at`, `updated_at`, `name`, `amount`, `remaining`, `semester`, `ay_id`, `user_id`) VALUES
(1, '2018-02-13 22:01:04', '2018-02-13 22:01:04', 'Academic', 75000, 75000, '1', 2, 15),
(2, '2018-02-13 22:01:04', '2018-02-13 22:01:04', 'Cultural', 150000, 150000, '1', 2, 15),
(3, '2018-02-13 22:01:04', '2018-02-13 22:01:04', 'Student Council', 150000, 150000, '1', 2, 15),
(4, '2018-02-13 22:01:04', '2018-02-13 22:01:04', 'Publication', 75000, 75000, '1', 2, 15),
(5, '2018-02-13 22:01:05', '2018-02-13 22:01:05', 'Student Activity', 75000, 75000, '1', 2, 15),
(6, '2018-02-13 22:01:05', '2018-02-13 22:01:05', 'Sports', 75000, 75000, '1', 2, 15);

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `created_at`, `updated_at`, `code`, `name`) VALUES
(2, '2018-02-13 21:29:53', '2018-02-13 21:30:07', 'IAS', 'Institutes of Arts and Sciences'),
(3, '2018-02-13 21:30:35', '2018-02-13 21:30:35', 'IBE', 'Institute of Business Education'),
(4, '2018-02-13 21:30:59', '2018-02-13 21:30:59', 'ICS', 'Institutes of Computing Studies'),
(5, '2018-02-13 21:31:12', '2018-02-13 21:31:12', 'IHM', 'Institute of Hospitality Management'),
(6, '2018-02-13 21:31:27', '2018-02-13 21:31:27', 'ITE', 'Institute of Teachers Education');

-- --------------------------------------------------------

--
-- Table structure for table `liquidations`
--

CREATE TABLE `liquidations` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `official_reciepts` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acitivity_id` int(10) UNSIGNED NOT NULL,
  `submitted_by_user_id` int(10) UNSIGNED NOT NULL,
  `approved_by_user_id` int(10) UNSIGNED NOT NULL,
  `approval` int(11) NOT NULL,
  `reviewed_sas` int(11) DEFAULT NULL,
  `reviewed_osca` int(11) DEFAULT NULL,
  `notify_sas` int(11) DEFAULT NULL,
  `notify_osca` int(11) DEFAULT NULL,
  `notify_officer` int(11) DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2017_10_03_033127_create_institutes_table', 1),
(3, '2017_10_05_071413_create_roles_table', 1),
(4, '2017_10_06_114849_create_academic_years_table', 1),
(5, '2017_10_07_043857_create_organizations_table', 1),
(6, '2017_10_07_043900_create_organization_academic_years_table', 1),
(7, '2017_10_07_044001_create_activities_table', 1),
(8, '2017_10_07_044040_create_budgets_table', 1),
(9, '2017_10_07_045506_create_users_table', 1),
(10, '2017_10_08_044241_create_funds_table', 1),
(11, '2017_10_26_101416_create_officers_table', 1),
(13, '2017_10_29_103019_create_budgets_table', 3),
(14, '2017_11_10_121934_create_enrolled_academic_years_table', 4),
(15, '2017_11_10_122600_create_savings_table', 5),
(16, '2017_11_22_114944_create_notification_table', 6),
(17, '2017_11_22_120337_create_notifications_table', 7),
(18, '2017_11_23_022841_create_voting_tbl', 8),
(19, '2017_11_23_192208_create_payment_amounts_table', 9),
(20, '2017_11_26_054927_officer_voting_table', 10),
(21, '2017_11_26_211726_create_cash_requests_table', 11),
(22, '2017_11_27_101144_create_liquidations_table', 12);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` double DEFAULT NULL,
  `activity_id` double DEFAULT NULL,
  `liquidation_id` int(11) DEFAULT NULL,
  `review_by_user_id` int(11) DEFAULT NULL,
  `reviewed_by_osca` int(11) DEFAULT NULL,
  `reviewed_by_sas` int(11) DEFAULT NULL,
  `notify_officers` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `created_at`, `updated_at`, `comment`, `user_id`, `activity_id`, `liquidation_id`, `review_by_user_id`, `reviewed_by_osca`, `reviewed_by_sas`, `notify_officers`) VALUES
(1, '2018-02-13 22:23:58', '2018-02-13 22:23:58', 'Ot ala yang budget', 1, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_ay_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `officers`
--

INSERT INTO `officers` (`id`, `created_at`, `updated_at`, `user_id`, `position`, `organization_ay_id`) VALUES
(1, '2018-02-13 22:12:22', '2018-02-13 22:12:22', 16, 'President', 1);

-- --------------------------------------------------------

--
-- Table structure for table `officer_votings`
--

CREATE TABLE `officer_votings` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `organization_ay_id` double NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institute_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `created_at`, `updated_at`, `code`, `name`, `institute_id`, `type`) VALUES
(4, '2018-02-13 21:33:48', '2018-02-13 21:33:48', 'SSC', 'Supreme Student Council', NULL, 'SSC'),
(5, '2018-02-13 21:34:41', '2018-02-13 21:34:41', 'ISC-IAS', 'ISC-IAS', 2, 'ISC'),
(6, '2018-02-13 21:35:11', '2018-02-13 21:35:11', 'ISC-IBE', 'ISC-IBE', 3, 'ISC'),
(7, '2018-02-13 21:35:31', '2018-02-13 21:35:31', 'ISC-ICS', 'ISC-ICS', 4, 'ISC'),
(8, '2018-02-13 21:36:09', '2018-02-13 21:36:09', 'MCCPC', 'cHORALE', NULL, 'CO'),
(9, '2018-02-13 21:36:38', '2018-02-13 21:36:38', 'FD', 'FOLTODANZATORE', NULL, 'CO'),
(10, '2018-02-13 21:37:13', '2018-02-13 21:37:13', 'SSITE', 'SSITE', 4, 'IO'),
(11, '2018-02-13 21:37:32', '2018-02-13 21:37:32', 'SS', 'Science Soc', 2, 'IO'),
(12, '2018-02-13 21:38:06', '2018-02-13 21:38:06', 'JPIA', 'JPIA', 3, 'IO'),
(13, '2018-02-13 21:38:37', '2018-02-13 21:38:37', 'PSCAS', 'PSCAS', 3, 'IO'),
(14, '2018-02-13 21:39:10', '2018-02-13 21:39:10', 'CYM', 'cYM', NULL, 'CW');

-- --------------------------------------------------------

--
-- Table structure for table `organization_academic_years`
--

CREATE TABLE `organization_academic_years` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `organization_id` int(10) UNSIGNED DEFAULT NULL,
  `ay_id` int(10) UNSIGNED NOT NULL,
  `accredited` int(1) NOT NULL,
  `notify` int(11) NOT NULL,
  `notify_sas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_academic_years`
--

INSERT INTO `organization_academic_years` (`id`, `created_at`, `updated_at`, `organization_id`, `ay_id`, `accredited`, `notify`, `notify_sas`) VALUES
(1, '2018-02-13 21:39:32', '2018-02-14 02:25:08', 4, 2, 1, 1, 1),
(2, '2018-02-13 21:39:32', '2018-02-14 02:23:27', 5, 2, 1, 1, 1),
(3, '2018-02-13 21:39:32', '2018-02-14 02:23:27', 6, 2, 1, 1, 1),
(4, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 7, 2, 1, 1, 1),
(5, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 8, 2, 1, 1, 1),
(6, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 9, 2, 1, 1, 1),
(7, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 10, 2, 1, 1, 1),
(8, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 11, 2, 1, 1, 1),
(9, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 12, 2, 1, 1, 1),
(10, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 13, 2, 1, 1, 1),
(11, '2018-02-13 21:39:33', '2018-02-14 02:23:27', 14, 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `organization_type`
--

CREATE TABLE `organization_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_amounts`
--

CREATE TABLE `payment_amounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_amounts`
--

INSERT INTO `payment_amounts` (`id`, `created_at`, `updated_at`, `name`, `amount`) VALUES
(1, NULL, NULL, 'Academic', 75),
(2, NULL, NULL, 'Cultural', 150),
(3, NULL, NULL, 'Student Council', 150),
(4, NULL, NULL, 'Publication', 75),
(5, NULL, NULL, 'Student Activity', 75),
(6, NULL, NULL, 'Sports', 75);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `created_at`, `updated_at`, `name`) VALUES
(1, NULL, '2017-10-26 16:00:00', 'OSCA Coordinator'),
(2, '2017-10-26 16:00:00', '2017-10-26 16:00:00', 'IGP'),
(3, '2017-10-26 16:00:00', '2017-10-26 16:00:00', 'SAS Director'),
(4, '2017-10-26 16:00:00', '2017-10-26 16:00:00', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `savings` double NOT NULL,
  `remaining` double NOT NULL,
  `semester` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_ay_id` int(10) UNSIGNED DEFAULT NULL,
  `budget_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `es_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `es_id`, `first_name`, `middle_name`, `last_name`, `contact`, `role_id`, `photo`) VALUES
(1, 'edward@gmail.com', '$2y$10$LfddGh512pEmh81vzzEYEuXw2jwnuN.iNdrNH1.nSxJ314/u4hTzu', 'kWOy6VIysPGuUwU58ayZw0BspmrdCwUsT3YLwXxP1WrVDuknHCkmelP7EWrC', '2017-11-05 16:00:00', '2018-02-13 08:06:18', '1001', 'Edward', 'DC', 'Ramos', '09156854191', 1, '24232521_1647814498610896_16330522654233116_n.jpg'),
(14, 'Susan@gmail.com', '$2y$10$LfddGh512pEmh81vzzEYEuXw2jwnuN.iNdrNH1.nSxJ314/u4hTzu', 'eSWswGPmstXzs9x8h1zIFvOwvmJHNM1E2goFQs0wybMT0Qa5X7evGMzOD98k', '2017-11-07 00:24:58', '2018-02-13 02:47:51', '1003', 'Amelia', 'Z', 'Macapagal', '09463518231', 3, 'no-image.jpg'),
(15, 'ems@gmail.com', '$2y$10$LfddGh512pEmh81vzzEYEuXw2jwnuN.iNdrNH1.nSxJ314/u4hTzu', '9NATcIKT7CjYid2flTAIRfiHQ8IT5wupbJwCqBnXn1sKwHQ23VDIzqs1TWan', '2017-11-07 00:27:31', '2018-02-13 05:57:45', '1002', 'Ems', '', 'Lagman', '09461353281', 2, '1522133_1558143984428974_9104941375157913824_n.jpg'),
(16, 'karl@gmail.com', '$2y$10$uJAMDwm8ygPaUx7qP5SqLOLBmLoQddTFuvkM9ylgWCW9nKUzyD0nq', 'JjGlNBFD4se5k8WszlbUZR7lmtFF5EsARljh936gyuUMB26zFHfpRJzQpaB1', '2018-02-13 22:12:22', '2018-02-13 22:19:11', '4484', 'Karl', 'Mangaya', 'Cayanan', '09751489888', 4, 'bus topology.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_organization_ay_id_foreign` (`organization_ay_id`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budgets_fund_id_foreign` (`fund_id`),
  ADD KEY `budgets_organization_ay_id_foreign` (`organization_ay_id`);

--
-- Indexes for table `calendar_activities`
--
ALTER TABLE `calendar_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_requests`
--
ALTER TABLE `cash_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrolled_academic_years`
--
ALTER TABLE `enrolled_academic_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrolled_academic_years_institute_id_foreign` (`institute_id`),
  ADD KEY `enrolled_academic_years_ay_id_foreign` (`ay_id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `funds_ay_id_foreign` (`ay_id`),
  ADD KEY `funds_user_id_foreign` (`user_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liquidations`
--
ALTER TABLE `liquidations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liquidations_acitivity_id_foreign` (`acitivity_id`),
  ADD KEY `liquidations_submitted_by_user_id_foreign` (`submitted_by_user_id`),
  ADD KEY `liquidations_approved_by_user_id_foreign` (`approved_by_user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `officers_user_id_foreign` (`user_id`),
  ADD KEY `officers_organization_ay_id_foreign` (`organization_ay_id`);

--
-- Indexes for table `officer_votings`
--
ALTER TABLE `officer_votings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizations_institute_id_foreign` (`institute_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `organization_academic_years`
--
ALTER TABLE `organization_academic_years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_academic_years_organization_id_foreign` (`organization_id`),
  ADD KEY `organization_academic_years_ay_id_foreign` (`ay_id`);

--
-- Indexes for table `organization_type`
--
ALTER TABLE `organization_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_amounts`
--
ALTER TABLE `payment_amounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_organization_ay_id_foreign` (`organization_ay_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `calendar_activities`
--
ALTER TABLE `calendar_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cash_requests`
--
ALTER TABLE `cash_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `enrolled_academic_years`
--
ALTER TABLE `enrolled_academic_years`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `liquidations`
--
ALTER TABLE `liquidations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `officer_votings`
--
ALTER TABLE `officer_votings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `organization_academic_years`
--
ALTER TABLE `organization_academic_years`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `organization_type`
--
ALTER TABLE `organization_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_amounts`
--
ALTER TABLE `payment_amounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_organization_ay_id_foreign` FOREIGN KEY (`organization_ay_id`) REFERENCES `organization_academic_years` (`id`);

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_fund_id_foreign` FOREIGN KEY (`fund_id`) REFERENCES `funds` (`id`),
  ADD CONSTRAINT `budgets_organization_ay_id_foreign` FOREIGN KEY (`organization_ay_id`) REFERENCES `organization_academic_years` (`id`);

--
-- Constraints for table `enrolled_academic_years`
--
ALTER TABLE `enrolled_academic_years`
  ADD CONSTRAINT `enrolled_academic_years_ay_id_foreign` FOREIGN KEY (`ay_id`) REFERENCES `academic_years` (`id`),
  ADD CONSTRAINT `enrolled_academic_years_institute_id_foreign` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`);

--
-- Constraints for table `funds`
--
ALTER TABLE `funds`
  ADD CONSTRAINT `funds_ay_id_foreign` FOREIGN KEY (`ay_id`) REFERENCES `academic_years` (`id`),
  ADD CONSTRAINT `funds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `liquidations`
--
ALTER TABLE `liquidations`
  ADD CONSTRAINT `liquidations_acitivity_id_foreign` FOREIGN KEY (`acitivity_id`) REFERENCES `activities` (`id`),
  ADD CONSTRAINT `liquidations_approved_by_user_id_foreign` FOREIGN KEY (`approved_by_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `liquidations_submitted_by_user_id_foreign` FOREIGN KEY (`submitted_by_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `officers`
--
ALTER TABLE `officers`
  ADD CONSTRAINT `officers_organization_ay_id_foreign` FOREIGN KEY (`organization_ay_id`) REFERENCES `organization_academic_years` (`id`),
  ADD CONSTRAINT `officers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_institute_id_foreign` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`);

--
-- Constraints for table `organization_academic_years`
--
ALTER TABLE `organization_academic_years`
  ADD CONSTRAINT `organization_academic_years_ay_id_foreign` FOREIGN KEY (`ay_id`) REFERENCES `academic_years` (`id`),
  ADD CONSTRAINT `organization_academic_years_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`);

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `savings_organization_ay_id_foreign` FOREIGN KEY (`organization_ay_id`) REFERENCES `organization_academic_years` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
