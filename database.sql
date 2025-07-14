-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 21 jan. 2024 à 06:53
-- Version du serveur : 8.0.31
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `school_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `account_employee_salaries`
--

DROP TABLE IF EXISTS `account_employee_salaries`;
CREATE TABLE IF NOT EXISTS `account_employee_salaries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL COMMENT 'employee_id=user_id',
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `account_student_fees`
--

DROP TABLE IF EXISTS `account_student_fees`;
CREATE TABLE IF NOT EXISTS `account_student_fees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `year_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `student_id` int DEFAULT NULL,
  `fee_category_id` int DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `account_student_fees`
--

INSERT INTO `account_student_fees` (`id`, `year_id`, `class_id`, `student_id`, `fee_category_id`, `date`, `amount`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 32, 2, '2003-12', 1425, '2023-12-22 23:52:13', '2023-12-22 23:52:13'),
(2, 3, 2, 21, 2, '2023-01', 1350, '2023-12-26 08:40:47', '2023-12-26 08:40:47'),
(3, 3, 1, 33, 2, '2023-01', 1350, '2023-12-26 08:42:08', '2023-12-26 08:42:08'),
(5, 3, 3, 30, 1, '2023-01', 90, '2023-12-30 09:44:38', '2023-12-30 09:44:38'),
(6, 3, 2, 21, 1, '1970-01', 90, '2023-12-30 10:00:37', '2023-12-30 10:00:37');

-- --------------------------------------------------------

--
-- Structure de la table `assign_students`
--

DROP TABLE IF EXISTS `assign_students`;
CREATE TABLE IF NOT EXISTS `assign_students` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL COMMENT 'user_id=student_id',
  `roll` int DEFAULT NULL,
  `class_id` int NOT NULL,
  `year_id` int NOT NULL,
  `group_id` int DEFAULT NULL,
  `shift_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `assign_students`
--

INSERT INTO `assign_students` (`id`, `student_id`, `roll`, `class_id`, `year_id`, `group_id`, `shift_id`, `created_at`, `updated_at`) VALUES
(28, 54, NULL, 7, 3, 2, NULL, '2024-01-11 21:10:16', '2024-01-11 21:10:16'),
(3, 21, NULL, 2, 3, 1, NULL, '2023-12-09 08:58:23', '2023-12-09 08:58:23'),
(5, 30, NULL, 3, 3, 1, NULL, '2023-12-20 13:53:21', '2023-12-20 13:53:21'),
(6, 32, NULL, 1, 3, 1, NULL, '2023-12-22 10:24:56', '2023-12-22 10:24:56'),
(7, 33, NULL, 1, 3, 1, NULL, '2023-12-22 10:27:05', '2023-12-22 10:27:05'),
(8, 34, NULL, 1, 3, 2, NULL, '2023-12-22 10:29:17', '2023-12-22 10:29:17'),
(9, 35, NULL, 2, 3, 2, NULL, '2023-12-22 10:35:58', '2023-12-22 10:35:58'),
(10, 36, NULL, 2, 3, 1, NULL, '2023-12-22 10:39:11', '2023-12-22 10:39:11'),
(11, 37, NULL, 3, 3, 1, NULL, '2023-12-22 10:41:05', '2023-12-22 10:41:05'),
(12, 38, NULL, 9, 3, 1, NULL, '2023-12-22 10:43:43', '2023-12-22 10:43:43'),
(13, 39, NULL, 9, 3, 1, NULL, '2023-12-22 10:45:36', '2023-12-22 10:45:36'),
(14, 40, NULL, 9, 3, 2, NULL, '2023-12-22 10:48:03', '2023-12-22 10:48:03'),
(15, 41, NULL, 7, 3, 1, NULL, '2023-12-22 10:50:43', '2023-12-22 10:50:43'),
(16, 42, NULL, 8, 3, 1, NULL, '2023-12-22 10:53:38', '2023-12-22 10:53:38');

-- --------------------------------------------------------

--
-- Structure de la table `assign_teacher`
--

DROP TABLE IF EXISTS `assign_teacher`;
CREATE TABLE IF NOT EXISTS `assign_teacher` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `teacher_id` int NOT NULL COMMENT 'user_id=teacher_id',
  `class_id` json NOT NULL,
  `subject_id` json NOT NULL,
  `year_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `assign_teacher`
--

INSERT INTO `assign_teacher` (`id`, `teacher_id`, `class_id`, `subject_id`, `year_id`, `created_at`, `updated_at`) VALUES
(4, 24, '[\"1\", \"4\", \"7\", \"8\"]', '[\"4\", \"9\"]', 3, '2023-12-10 13:41:25', '2024-01-18 08:14:58'),
(7, 27, '[\"1\", \"2\", \"3\", \"4\", \"7\", \"8\"]', '[\"3\", \"5\", \"6\"]', 3, '2023-12-20 12:54:14', '2023-12-25 07:46:41'),
(6, 26, '[\"1\", \"2\", \"3\"]', '[\"2\", \"10\", \"12\"]', 3, '2023-12-10 13:47:21', '2024-01-18 08:15:48'),
(8, 28, '[\"2\", \"7\", \"8\"]', '[\"1\", \"7\", \"11\"]', 3, '2023-12-20 13:06:05', '2023-12-30 13:32:26'),
(9, 29, '[\"1\", \"2\", \"3\", \"4\", \"5\", \"6\"]', '[\"8\"]', 3, '2023-12-20 13:07:55', '2023-12-20 13:07:55');

-- --------------------------------------------------------

--
-- Structure de la table `classroom`
--

DROP TABLE IF EXISTS `classroom`;
CREATE TABLE IF NOT EXISTS `classroom` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `classroom_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classroom`
--

INSERT INTO `classroom` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Salle A1', '2023-12-30 08:53:38', '2023-12-30 08:53:38'),
(2, 'Salle A2', '2023-12-30 08:53:53', '2023-12-30 08:53:53'),
(3, 'Salle A3', '2023-12-30 08:54:06', '2023-12-30 08:54:06'),
(4, 'Salle Info1', '2023-12-30 08:54:36', '2023-12-30 08:54:36'),
(5, 'Salle Info2', '2023-12-30 08:54:56', '2023-12-30 08:54:56'),
(6, 'Salle Info3', '2023-12-30 08:55:19', '2023-12-30 08:55:19'),
(7, 'Salle Info4', '2023-12-30 08:55:33', '2023-12-30 08:55:33'),
(8, 'Salle B', '2023-12-30 08:56:13', '2023-12-30 08:56:13'),
(9, 'Salle C', '2023-12-30 08:56:40', '2023-12-30 09:00:54');

-- --------------------------------------------------------

--
-- Structure de la table `class_schedules`
--

DROP TABLE IF EXISTS `class_schedules`;
CREATE TABLE IF NOT EXISTS `class_schedules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `classroom_id` bigint UNSIGNED DEFAULT NULL,
  `day_of_week` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_schedules_class_id_foreign` (`class_id`),
  KEY `class_schedules_teacher_id_foreign` (`teacher_id`),
  KEY `class_schedules_subject_id_foreign` (`subject_id`),
  KEY `class_schedules_classroom_id_foreign` (`classroom_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `class_schedules`
--

INSERT INTO `class_schedules` (`id`, `class_id`, `teacher_id`, `subject_id`, `classroom_id`, `day_of_week`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(27, 1, 29, 8, 8, 'Lundi', '11:00:00', '12:00:00', '2024-01-10 08:44:47', '2024-01-18 08:55:53'),
(36, 7, 29, 8, 1, 'Lundi', '08:00:00', '09:00:00', '2024-01-11 17:56:03', '2024-01-18 09:16:14'),
(33, 5, 24, 9, 5, 'Lundi', '07:00:00', '08:00:00', '2024-01-11 10:51:15', '2024-01-18 09:16:00'),
(37, 7, 28, 1, 9, 'Lundi', '09:00:00', '10:00:00', '2024-01-11 17:57:16', '2024-01-18 09:16:30'),
(6, 2, 24, 4, 5, 'Lundi', '13:00:00', '15:00:00', '2023-12-12 01:32:36', '2024-01-18 08:56:48'),
(9, 3, 28, 11, 3, 'Samedi', '09:00:00', '11:00:00', '2023-12-20 13:02:31', '2024-01-18 09:14:13'),
(39, 1, 26, 12, 1, 'Mardi', '09:00:00', '10:00:00', '2024-01-18 09:21:46', '2024-01-18 09:27:28'),
(29, 1, 26, 2, 5, 'Lundi', '08:00:00', '09:00:00', '2024-01-10 14:05:40', '2024-01-18 08:56:00'),
(28, 1, 27, 6, 4, 'Lundi', '07:00:00', '08:00:00', '2024-01-10 14:03:28', '2024-01-18 08:55:43'),
(13, 2, 24, 4, 4, 'Lundi', '10:00:00', '12:00:00', '2023-12-20 13:16:34', '2024-01-18 08:57:20'),
(14, 2, 29, 8, 8, 'Vendredi', '16:00:00', '18:00:00', '2023-12-20 13:18:42', '2024-01-18 09:01:13'),
(15, 2, 24, 9, 5, 'Vendredi', '09:00:00', '11:00:00', '2023-12-20 13:19:32', '2024-01-18 09:04:18'),
(17, 3, 29, 8, 4, 'Jeudi', '07:00:00', '08:00:00', '2023-12-25 08:07:54', '2024-01-18 09:14:27'),
(46, 3, 26, 12, 3, 'Lundi', '10:00:00', '11:00:00', '2024-01-18 12:05:57', '2024-01-18 12:05:57'),
(35, 7, 28, 11, 9, 'Lundi', '10:00:00', '11:00:00', '2024-01-11 17:41:09', '2024-01-18 09:16:38'),
(21, 9, 26, 2, 2, 'Mardi', '10:00:00', '12:00:00', '2023-12-29 08:48:26', '2024-01-18 09:16:54'),
(38, 1, 28, 7, 5, 'Lundi', '14:00:00', '17:00:00', '2024-01-18 09:19:05', '2024-01-18 09:19:41'),
(30, 3, 28, 1, 4, 'Lundi', '15:00:00', '17:00:00', '2024-01-10 14:26:22', '2024-01-18 09:15:19'),
(22, 4, 29, 8, 8, 'Lundi', '12:00:00', '13:00:00', '2024-01-09 13:00:40', '2024-01-18 09:15:36'),
(40, 1, 24, 4, 4, 'Mardi', '11:00:00', '12:00:00', '2024-01-18 09:23:34', '2024-01-18 09:23:34'),
(41, 1, 27, 5, 4, 'Mardi', '14:00:00', '17:00:00', '2024-01-18 09:25:12', '2024-01-18 09:25:12'),
(42, 1, 24, 9, 7, 'Jeudi', '10:00:00', '13:00:00', '2024-01-18 09:29:25', '2024-01-18 09:29:25'),
(43, 1, 26, 10, 1, 'Vendredi', '15:00:00', '18:00:00', '2024-01-18 09:30:52', '2024-01-18 09:30:52'),
(44, 1, 29, 8, 9, 'Samedi', '10:00:00', '13:00:00', '2024-01-18 09:31:46', '2024-01-18 09:31:46');

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `class_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_teacher_id_foreign` (`teacher_id`),
  KEY `courses_class_id_foreign` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `courses`
--

INSERT INTO `courses` (`id`, `class_id`, `name`, `file_path`, `created_at`, `updated_at`, `teacher_id`) VALUES
(8, 1, 'Ressources Humaine', 'upload/course_files/202312201050_cours MRH 2023.pdf', '2023-12-17 14:00:05', '2023-12-20 09:50:23', 26),
(10, 3, 'communication', 'upload/course_files/202312241520_presentation_assamoi.pdf', '2023-12-24 14:20:49', '2023-12-24 14:20:49', 26),
(6, 2, 'Gestion de Projet', 'upload/course_files/202312171311_TD Rappels et révision (1).pdf', '2023-12-17 12:11:43', '2023-12-24 13:39:39', 26),
(11, 8, 'Administration Système', 'upload/course_files/202312241523_Projet DevOps.pdf', '2023-12-24 14:23:31', '2023-12-24 14:23:31', 24),
(12, 1, 'Administration Système', 'upload/course_files/202312241556_TD Unix.pdf', '2023-12-24 14:56:10', '2023-12-24 14:56:10', 24);

-- --------------------------------------------------------

--
-- Structure de la table `discount_students`
--

DROP TABLE IF EXISTS `discount_students`;
CREATE TABLE IF NOT EXISTS `discount_students` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `assign_student_id` int NOT NULL,
  `fee_category_id` int DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `final_fees` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `discount_students`
--

INSERT INTO `discount_students` (`id`, `assign_student_id`, `fee_category_id`, `discount`, `final_fees`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 10, NULL, '2023-12-09 08:53:39', '2023-12-09 08:53:39'),
(3, 3, 1, 10, NULL, '2023-12-09 08:58:23', '2023-12-09 08:58:23'),
(5, 5, 1, 5, NULL, '2023-12-20 13:53:21', '2023-12-20 13:53:21'),
(6, 6, 1, 5, NULL, '2023-12-22 10:24:56', '2023-12-22 10:24:56'),
(7, 7, 1, 10, NULL, '2023-12-22 10:27:05', '2023-12-22 10:27:05'),
(8, 8, 1, 5, NULL, '2023-12-22 10:29:17', '2023-12-22 10:29:17'),
(9, 9, 1, 10, NULL, '2023-12-22 10:35:58', '2023-12-22 10:35:58'),
(10, 10, 1, 5, NULL, '2023-12-22 10:39:11', '2023-12-22 10:39:11'),
(11, 11, 1, 10, NULL, '2023-12-22 10:41:05', '2023-12-22 10:41:05'),
(12, 12, 1, 10, NULL, '2023-12-22 10:43:43', '2023-12-22 10:43:43'),
(13, 13, 1, 10, NULL, '2023-12-22 10:45:36', '2023-12-22 10:45:36'),
(14, 14, 1, 5, NULL, '2023-12-22 10:48:03', '2023-12-22 10:48:03'),
(15, 15, 1, 10, NULL, '2023-12-22 10:50:43', '2023-12-22 10:50:43'),
(16, 16, 1, 5, NULL, '2023-12-22 10:53:38', '2023-12-22 10:53:38'),
(22, 28, 1, 15, 1530, '2024-01-11 21:10:16', '2024-01-11 21:10:16');

-- --------------------------------------------------------

--
-- Structure de la table `employee_sallary_logs`
--

DROP TABLE IF EXISTS `employee_sallary_logs`;
CREATE TABLE IF NOT EXISTS `employee_sallary_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL COMMENT 'employee_id=User_id',
  `previous_salary` int DEFAULT NULL,
  `present_salary` int DEFAULT NULL,
  `increment_salary` int DEFAULT NULL,
  `effected_salary` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employee_sallary_logs`
--

INSERT INTO `employee_sallary_logs` (`id`, `employee_id`, `previous_salary`, `present_salary`, `increment_salary`, `effected_salary`, `created_at`, `updated_at`) VALUES
(1, 26, NULL, 5000, 5000, '2023-12-16', '2023-12-16 00:46:49', '2023-12-16 00:46:49'),
(2, 24, NULL, 7000, 7000, '2023-12-16', '2023-12-16 00:47:37', '2023-12-16 00:47:37'),
(3, 26, 5000, 10500, 5500, '1970-01-01', '2023-12-16 00:48:17', '2023-12-16 00:48:17'),
(4, 27, NULL, 5000, 5000, '2023-12-21', '2023-12-21 11:44:53', '2023-12-21 11:44:53'),
(5, 27, 5000, 10000, 5000, '2023-12-21', '2023-12-21 11:53:58', '2023-12-21 11:53:58'),
(6, 28, NULL, 5500, 5500, '2023-12-21', '2023-12-21 12:20:14', '2023-12-21 12:20:14'),
(7, 29, NULL, 5000, 5000, '1970-01-01', '2023-12-30 12:21:55', '2023-12-30 12:21:55');

-- --------------------------------------------------------

--
-- Structure de la table `exam_types`
--

DROP TABLE IF EXISTS `exam_types`;
CREATE TABLE IF NOT EXISTS `exam_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exam_types_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `exam_types`
--

INSERT INTO `exam_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'examen partiel', '2023-12-21 12:22:59', '2023-12-21 12:22:59'),
(2, 'examen final', '2023-12-21 12:23:19', '2023-12-21 12:23:19');

-- --------------------------------------------------------

--
-- Structure de la table `fee_categories`
--

DROP TABLE IF EXISTS `fee_categories`;
CREATE TABLE IF NOT EXISTS `fee_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fee_categories_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fee_categories`
--

INSERT INTO `fee_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admission', '2023-12-21 13:21:36', '2023-12-21 13:21:36'),
(2, 'inscription', '2023-12-21 13:21:57', '2023-12-21 13:21:57');

-- --------------------------------------------------------

--
-- Structure de la table `fee_category_amounts`
--

DROP TABLE IF EXISTS `fee_category_amounts`;
CREATE TABLE IF NOT EXISTS `fee_category_amounts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `fee_category_id` int NOT NULL,
  `class_id` int NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fee_category_amounts`
--

INSERT INTO `fee_category_amounts` (`id`, `fee_category_id`, `class_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, '2023-12-21 13:24:21', '2023-12-21 13:24:21'),
(2, 1, 2, 100, '2023-12-21 13:24:21', '2023-12-21 13:24:21'),
(3, 1, 3, 100, '2023-12-21 13:24:21', '2023-12-21 13:24:21'),
(4, 1, 7, 150, '2023-12-21 13:24:21', '2023-12-21 13:24:21'),
(5, 1, 8, 150, '2023-12-21 13:24:21', '2023-12-21 13:24:21'),
(6, 1, 9, 150, '2023-12-21 13:24:21', '2023-12-21 13:24:21'),
(27, 2, 9, 1800, '2023-12-21 13:27:28', '2023-12-21 13:27:28'),
(26, 2, 8, 1800, '2023-12-21 13:27:28', '2023-12-21 13:27:28'),
(25, 2, 7, 1800, '2023-12-21 13:27:27', '2023-12-21 13:27:27'),
(24, 2, 6, 1500, '2023-12-21 13:27:27', '2023-12-21 13:27:27'),
(23, 2, 5, 1500, '2023-12-21 13:27:27', '2023-12-21 13:27:27'),
(22, 2, 4, 1500, '2023-12-21 13:27:27', '2023-12-21 13:27:27'),
(21, 2, 3, 1500, '2023-12-21 13:27:27', '2023-12-21 13:27:27'),
(20, 2, 2, 1500, '2023-12-21 13:27:27', '2023-12-21 13:27:27'),
(19, 2, 1, 1500, '2023-12-21 13:27:27', '2023-12-21 13:27:27');

-- --------------------------------------------------------

--
-- Structure de la table `marks_grades`
--

DROP TABLE IF EXISTS `marks_grades`;
CREATE TABLE IF NOT EXISTS `marks_grades` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_point` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_marks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_marks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_point` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_point` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marks_grades`
--

INSERT INTO `marks_grades` (`id`, `grade_name`, `grade_point`, `start_marks`, `end_marks`, `start_point`, `end_point`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'A', '4', '90', '100', '95', '100', 'Excellente Performance académique', '2024-01-16 19:56:51', '2024-01-16 19:56:51'),
(2, 'B', '3', '80', '89', '85', '89', 'Bonne Performance academique', '2024-01-16 19:59:04', '2024-01-16 19:59:04'),
(3, 'D', '1', '60', '69', '60', '64', 'Performance académique Minimale', '2024-01-16 20:00:10', '2024-01-16 20:00:10');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2020_11_23_192918_create_sessions_table', 1),
(7, '2020_11_27_191622_create_student_classes_table', 1),
(8, '2020_11_27_201955_create_student_years_table', 1),
(9, '2020_11_27_205317_create_student_groups_table', 1),
(10, '2020_11_27_212648_create_student_shifts_table', 1),
(11, '2020_11_28_184513_create_fee_categories_table', 1),
(12, '2020_11_28_193421_create_fee_category_amounts_table', 1),
(13, '2020_11_29_190907_create_exam_types_table', 1),
(14, '2020_11_29_193820_create_school_subjects_table', 1),
(15, '2020_11_30_192807_create_assign_subjects_table', 1),
(16, '2020_11_30_211919_create_designations_table', 1),
(17, '2020_12_02_191137_create_assign_students_table', 1),
(18, '2020_12_02_191735_create_discount_students_table', 1),
(19, '2020_12_09_192120_create_employee_sallary_logs_table', 1),
(20, '2020_12_11_205416_create_leave_purposes_table', 1),
(21, '2020_12_11_210033_create_employee_leaves_table', 1),
(22, '2020_12_13_192045_create_employee_attendances_table', 1),
(23, '2020_12_15_214223_create_student_marks_table', 1),
(24, '2020_12_16_202402_create_marks_grades_table', 1),
(25, '2020_12_18_191232_create_account_student_fees_table', 1),
(26, '2020_12_18_212912_create_account_employee_salaries_table', 1),
(27, '2020_12_20_192742_create_account_other_costs_table', 1),
(28, '2023_12_05_115939_create_teachers_table', 2),
(29, '2023_12_06_120754_create_assign_teacher_table', 3),
(30, '2023_12_11_073436_create_class_schedules_table', 4),
(32, '2023_12_16_113242_create_courses_table', 5),
(34, '2023_12_16_120753_add_teacher_id_to_courses_table', 6),
(35, '2023_12_18_020335_add_class_id_to_courses_table', 7),
(36, '2023_12_30_011221_create_classroom_table', 8),
(37, '2023_12_30_012254_add_classroom_id_to_class_schedules_table', 9),
(38, '2024_01_11_203207_add_final_fees_to_discount_students_table', 10),
(39, '2024_01_11_213135_add_final_fees_to_discount_students_table', 11),
(41, '2024_01_11_235320_create_student_payments_table', 12);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `school_subjects`
--

DROP TABLE IF EXISTS `school_subjects`;
CREATE TABLE IF NOT EXISTS `school_subjects` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `school_subjects_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `school_subjects`
--

INSERT INTO `school_subjects` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Base de données', '2023-11-29 21:36:08', '2023-11-29 21:36:08'),
(2, 'RH', '2023-11-29 21:36:30', '2023-11-29 21:36:30'),
(3, 'sécurité informatique', '2023-11-29 21:36:53', '2023-11-29 21:36:53'),
(4, 'Développent web', '2023-12-20 12:55:11', '2023-12-20 12:55:11'),
(5, 'Administration réseau', '2023-12-20 12:55:40', '2023-12-20 12:55:40'),
(6, 'Administration Système', '2023-12-20 12:56:05', '2023-12-20 12:56:05'),
(7, 'DevOps', '2023-12-20 12:57:12', '2023-12-20 12:57:12'),
(8, 'Anglais', '2023-12-20 12:57:24', '2023-12-20 12:57:24'),
(9, 'Programmation', '2023-12-20 12:57:44', '2023-12-20 12:57:44'),
(10, 'Marketing Digital', '2023-12-20 12:58:16', '2023-12-20 12:58:16'),
(11, 'Gestion de Projet', '2023-12-20 12:58:35', '2023-12-20 12:58:35'),
(12, 'Management Opérationnel', '2023-12-20 12:59:26', '2023-12-20 12:59:26');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Ea14VyO4nktP7OPv0Zys7yTfDh8SGnBzS75kvbTX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiWUhpUTVUQWg2V1JWbzhKQzBMMEtZd1NHVDk2YjlrdklyZlBCa3JiRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1705800346),
('zGxFscRNPpf59eBhEatojj2WLURyVPuYBHjTucrV', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU21BTVhwYXVKQVg5Y0lqT0lIUExlVG1HVFdzeGdsZE9aa09DZ3NxSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRHL3J2ZmRDckxTdkZMZUo2eUg5RldPMkEwbVZsYk5EbnhXWndVZkw4RTlkNjhlVS9sbDk4NiI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkRy9ydmZkQ3JMU3ZGTGVKNnlIOUZXTzJBMG1WbGJORG54V1p3VWZMOEU5ZDY4ZVUvbGw5ODYiO30=', 1705803051);

-- --------------------------------------------------------

--
-- Structure de la table `student_classes`
--

DROP TABLE IF EXISTS `student_classes`;
CREATE TABLE IF NOT EXISTS `student_classes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_classes_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_classes`
--

INSERT INTO `student_classes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'BTS1_Informatique', '2023-11-29 21:28:16', '2023-11-29 21:28:16'),
(2, 'BTS1_Reaseau', '2023-11-29 21:29:13', '2023-11-29 21:29:13'),
(3, 'BTS1_Management', '2023-11-29 21:29:34', '2023-11-29 21:29:34'),
(4, 'BTS2_Informatique', '2023-11-29 21:30:47', '2023-11-29 21:30:47'),
(5, 'BTS2_Reseau', '2023-11-29 21:31:20', '2023-11-29 21:31:20'),
(6, 'BTS2_Management', '2023-11-29 21:31:38', '2023-11-29 21:31:38'),
(7, 'Bachelor3 développement web', '2023-11-29 21:33:00', '2023-11-29 21:33:00'),
(8, 'Bachelor3 Réseaux', '2023-11-29 21:33:31', '2023-11-29 21:33:31'),
(9, 'Bachelor3 Management', '2023-11-29 21:33:54', '2023-11-29 21:33:54');

-- --------------------------------------------------------

--
-- Structure de la table `student_groups`
--

DROP TABLE IF EXISTS `student_groups`;
CREATE TABLE IF NOT EXISTS `student_groups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_groups_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_groups`
--

INSERT INTO `student_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'GroupA', '2023-12-06 07:30:26', '2023-12-06 07:30:26'),
(2, 'GroupB', '2023-12-06 07:30:44', '2023-12-06 07:30:44'),
(3, 'GroupC', '2023-12-06 07:30:56', '2023-12-06 07:30:56');

-- --------------------------------------------------------

--
-- Structure de la table `student_marks`
--

DROP TABLE IF EXISTS `student_marks`;
CREATE TABLE IF NOT EXISTS `student_marks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL COMMENT 'student_id=user_id',
  `id_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `exam_type_id` int DEFAULT NULL,
  `marks` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_marks`
--

INSERT INTO `student_marks` (`id`, `student_id`, `id_no`, `year_id`, `class_id`, `subject_id`, `exam_type_id`, `marks`, `created_at`, `updated_at`) VALUES
(11, 33, '20230033', 3, 1, 8, 1, 9, '2024-01-16 19:39:57', '2024-01-16 19:39:57'),
(10, 32, '20230031', 3, 1, 8, 1, 7, '2024-01-16 19:39:57', '2024-01-16 19:39:57'),
(9, 34, '20230034', 3, 1, 4, 1, 8, '2024-01-16 19:33:15', '2024-01-16 19:33:15'),
(8, 33, '20230033', 3, 1, 4, 1, 10, '2024-01-16 19:33:15', '2024-01-16 19:33:15'),
(7, 32, '20230031', 3, 1, 4, 1, 14, '2024-01-16 19:33:15', '2024-01-16 19:33:15'),
(12, 34, '20230034', 3, 1, 8, 1, 11, '2024-01-16 19:39:57', '2024-01-16 19:39:57'),
(13, 32, '20230031', 3, 1, 2, 1, 17, '2024-01-16 19:40:31', '2024-01-16 19:40:31'),
(14, 33, '20230033', 3, 1, 2, 1, 15, '2024-01-16 19:40:31', '2024-01-16 19:40:31'),
(15, 34, '20230034', 3, 1, 2, 1, 12, '2024-01-16 19:40:31', '2024-01-16 19:40:31'),
(16, 32, '20230031', 3, 1, 4, 2, 18, '2024-01-16 19:41:05', '2024-01-16 19:41:05'),
(17, 33, '20230033', 3, 1, 4, 2, 13, '2024-01-16 19:41:05', '2024-01-16 19:41:05'),
(18, 34, '20230034', 3, 1, 4, 2, 16, '2024-01-16 19:41:05', '2024-01-16 19:41:05'),
(19, 32, '20230031', 3, 1, 2, 2, 17, '2024-01-16 19:41:33', '2024-01-16 19:41:33'),
(20, 33, '20230033', 3, 1, 2, 2, 19, '2024-01-16 19:41:33', '2024-01-16 19:41:33'),
(21, 34, '20230034', 3, 1, 2, 2, 11, '2024-01-16 19:41:33', '2024-01-16 19:41:33'),
(22, 32, '20230031', 3, 1, 9, 1, 15, '2024-01-17 01:01:23', '2024-01-17 01:01:23'),
(23, 33, '20230033', 3, 1, 9, 1, 10, '2024-01-17 01:01:23', '2024-01-17 01:01:23'),
(24, 34, '20230034', 3, 1, 9, 1, 13, '2024-01-17 01:01:23', '2024-01-17 01:01:23'),
(25, 32, '20230031', 3, 1, 9, 2, 16, '2024-01-17 01:01:58', '2024-01-17 01:01:58'),
(26, 33, '20230033', 3, 1, 9, 2, 15, '2024-01-17 01:01:58', '2024-01-17 01:01:58'),
(27, 34, '20230034', 3, 1, 9, 2, 17, '2024-01-17 01:01:58', '2024-01-17 01:01:58'),
(28, 32, '20230031', 3, 1, 6, 1, 8, '2024-01-17 01:06:04', '2024-01-17 01:06:04'),
(29, 33, '20230033', 3, 1, 6, 1, 12, '2024-01-17 01:06:04', '2024-01-17 01:06:04'),
(30, 34, '20230034', 3, 1, 6, 1, 17, '2024-01-17 01:06:04', '2024-01-17 01:06:04'),
(31, 32, '20230031', 3, 1, 6, 2, 15, '2024-01-17 01:06:35', '2024-01-17 01:06:35'),
(32, 33, '20230033', 3, 1, 6, 2, 12, '2024-01-17 01:06:35', '2024-01-17 01:06:35'),
(33, 34, '20230034', 3, 1, 6, 2, 16, '2024-01-17 01:06:35', '2024-01-17 01:06:35');

-- --------------------------------------------------------

--
-- Structure de la table `student_payments`
--

DROP TABLE IF EXISTS `student_payments`;
CREATE TABLE IF NOT EXISTS `student_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED NOT NULL,
  `amount` float NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_payments_student_id_foreign` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_payments`
--

INSERT INTO `student_payments` (`id`, `student_id`, `class_id`, `amount`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 35, 2, 500, 'credit_card', '2024-01-12 03:09:12', '2024-01-12 03:09:12'),
(2, 32, 1, 200, 'cash', '2024-01-12 03:10:40', '2024-01-12 03:10:40'),
(3, 33, 1, 800, 'bank_transfer', '2024-01-12 03:14:45', '2024-01-12 03:14:45'),
(4, 30, 3, 1000, 'cash', '2024-01-12 09:32:50', '2024-01-12 09:32:50'),
(5, 32, 1, 300, 'cash', '2024-01-12 09:57:42', '2024-01-12 09:57:42'),
(6, 33, 1, 550, 'cash', '2024-01-12 14:02:04', '2024-01-12 14:02:04');

-- --------------------------------------------------------

--
-- Structure de la table `student_years`
--

DROP TABLE IF EXISTS `student_years`;
CREATE TABLE IF NOT EXISTS `student_years` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_years_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_years`
--

INSERT INTO `student_years` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '2021', '2023-11-29 21:25:44', '2023-11-29 21:25:44'),
(2, '2022', '2023-11-29 21:25:57', '2023-11-29 21:25:57'),
(3, '2023', '2023-11-29 21:26:11', '2023-11-29 21:26:11');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `usertype` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Student,Teacher\r\n,Admin',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'admin=head of sotware,operator=computer operator,user=employee',
  `join_date` date DEFAULT NULL,
  `designation_id` int DEFAULT NULL,
  `salary` double DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=inactive,1=active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `usertype`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `mobile`, `address`, `gender`, `image`, `fname`, `mname`, `religion`, `id_no`, `dob`, `code`, `role`, `join_date`, `designation_id`, `salary`, `status`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'felix Jersohn Assamoi', 'assamoifelixjersohn92@gmail.com', NULL, '$2y$10$G/rvfdCrLSvFLeJ6yH9FWO2A0mVlbNDnxWZwUfL8E9d68eU/ll986', NULL, NULL, '20439548', 'tunisie', 'Male', '202311251517felix.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 'Admin', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-11-25 14:06:13', '2023-11-25 14:17:12'),
(2, 'Admin', 'felix', 'felix@test.com', NULL, '$2y$10$V/D4ytmbaiENctfF67jdW.78GWkVqRjPAbnAGtkOXoRPeOqSkcQPu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8232', 'Admin', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-05 13:23:44', '2023-12-05 13:23:44'),
(3, 'Admin', 'john', 'john@test.com', NULL, '$2y$10$tRVZq8/M8KYsweK9FO8BQehWzwFdHzW4lO1hTW35NvkmdbTVEGmp2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3550', 'Operator', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-05 13:24:37', '2023-12-05 13:24:37'),
(37, 'Student', 'Angui sylvanus', 'angui@sylvanus.com', NULL, '$2y$10$LAGRpNdvDIEUNZXY4z4OFOxkFv4Lt/Uzo4rYXy5X1SFPU9uw/tWEe', NULL, NULL, '+225 45 954 78 36', 'Abidjan', 'Male', NULL, 'Angui Etienne', 'Chantal Alladé', 'Hindu', '20230037', '1989-12-12', '3427', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:41:05', '2023-12-22 10:41:05'),
(36, 'Student', 'Ghofran Zghal', 'ghofran@zghal.com', NULL, '$2y$10$Sy6cDmt.QtZfirXVf55ViOMszrEWJUxQwVaq1Lasw1u4pFq1fD3/i', NULL, NULL, '+216 126 548 88', 'souka', 'Female', NULL, 'Mondher Zghal', 'Cherif Koff', 'Islam', '20230036', '2003-08-11', '4901', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:39:11', '2023-12-22 10:39:11'),
(35, 'Student', 'Lotfi allagui', 'lotfi@allagui.com', NULL, '$2y$10$FaW7RvMrIfwEQlk5O63ci.7Z2sL3GpdqJBXA14diLEsbRoEGyEIl2', NULL, NULL, '+216 25 658 941', 'Ezzahara', 'Male', NULL, 'Faozi allagui', 'imen ben amor', 'Islam', '20230035', '2000-04-06', '8555', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:35:58', '2023-12-22 10:35:58'),
(34, 'Student', 'Bleu Toure', 'bleu@xn--tour-epa.com', NULL, '$2y$10$V8vAz.96yYOvsvWV/LcOROoyNukGUJeRr.oKZk8Ky4guhsCz0kJZi', NULL, NULL, '+2512498345628', 'Man', 'Male', '202401180814Rameur.jpg', 'Bleu Mathias', 'Gondo ruthe', 'Islam', '20230034', '1989-08-15', '8954', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:29:17', '2024-01-18 07:14:09'),
(33, 'Student', 'Sara Otaleba', 'sara@otaleba.com', NULL, '$2y$10$.qRG5mO9R3LxhdmXvQJk9uhMCS3QxHKDvyjrQlHskICzoFBHti8rK', NULL, NULL, '+225 784 96 45 32', 'Daloa', 'Female', NULL, 'Otaleba Mexan', 'Pauline Damir', 'Christan', '20230033', '1999-05-07', '152', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:27:05', '2023-12-22 10:27:05'),
(32, 'Student', 'John Doe', 'John@doe.com', NULL, '$2y$10$/rbL1LQ9BbtL/TUcaXr6KeDXoCB/THcKAE6K/xiP.A8OdQmhbO08q', NULL, NULL, '+192662515', 'California', 'Male', '202401180812product-13.jpg', 'Jack Doe', 'Nathalie Further', 'Christan', '20230031', '1990-12-10', '1448', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:24:56', '2024-01-18 07:12:27'),
(30, 'Student', 'Amadou  Sacko', 'amadou@sacko.com', NULL, '$2y$10$HFrAvYyWNrU2XyePQgzHKuzNAvZcF8KGWRDaI/rA8mivE57Vgl0Wq', NULL, NULL, '+224 20456987', 'guinea', 'Male', '202312201453art-2578353_640.jpg', 'sacko issa', 'Traoré Binta', 'Islam', '20230022', '1998-06-15', '9719', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-20 13:53:21', '2024-01-09 09:52:34'),
(29, 'Teacher', 'jersohn', 'jersohn@test.com', NULL, '$2y$10$BfR2LtgEtxwbKpuYUQwc7.HaB1CFGDWTfxIO4MbPR4IIHpk/AJMgS', NULL, NULL, '20439548', 'cote d\'ivoire/abidjan', 'Male', '202312201407WhatsApp Image 2023-10-23 at 11.47.30-removebg-preview.jpg', NULL, NULL, NULL, '20230029', NULL, '1959', NULL, NULL, NULL, 5000, 1, NULL, NULL, NULL, '2023-12-20 13:07:55', '2023-12-30 12:21:55'),
(28, 'Teacher', 'Mark Zacharie', 'mark@zack.com', NULL, '$2y$10$xbXUPr/Xxpp7Srpqmtsu6eH6UpZhTr3jni5KCp6nbowhtXhDzU0bi', NULL, NULL, '+338549756', 'France', NULL, '202312201406product-detail-01.jpg', NULL, NULL, NULL, '20230028', NULL, '968', NULL, NULL, NULL, 5500, 1, NULL, NULL, NULL, '2023-12-20 13:06:05', '2023-12-25 07:50:34'),
(54, 'Student', 'enoc dieu merci', 'enoc@gmail.com', NULL, '$2y$10$a024t3dV9L6EtsvD6jE8QOjUlo.L4PNUW7sDMrXY6//5o5HcAxCmO', NULL, NULL, '20439548', 'R23tunis', 'Female', NULL, 'Mohamed Massamba', 'besma souad', 'Christan', '20230043', '1929-07-12', '4969', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2024-01-11 21:10:16', '2024-01-11 21:10:16'),
(27, 'Teacher', 'Gate Ariana', 'gate@ariana.com', NULL, '$2y$10$7S/Abjy3fy0ArHx4GINtZugzQRWePxXpDjdY6OSo4c9flwHU/NQFe', NULL, NULL, '+1 45 569 521', 'luxemburg', NULL, '202312201354tapis_roulant.png', NULL, NULL, NULL, '20230027', NULL, '6291', NULL, NULL, NULL, 10000, 1, NULL, NULL, NULL, '2023-12-20 12:54:14', '2023-12-25 07:46:41'),
(26, 'Teacher', 'Alpha Oumar', 'alpha@test.com', NULL, '$2y$10$.fvFOtOi2Ym5xOe0CkDFpuZNpF5sKP0W6XibcI.fHjp/s1Mr5WP.y', NULL, NULL, '21065489', 'USA', NULL, '202401180915WhatsApp Image 2023-11-06 at 22.32.26.jpeg', NULL, NULL, NULL, '20230026', NULL, '3399', NULL, NULL, NULL, 10500, 1, NULL, NULL, NULL, '2023-12-10 13:47:21', '2024-01-18 08:15:48'),
(21, 'Student', 'iyadh', 'iyadh@test.com', NULL, '$2y$10$GlUL833NkueJMmgc6vZN8ueGwIuEdtYdE.kLmvKfsmBD3HdSB4gXG', NULL, NULL, '25838536', 'hammam lif', 'Male', '202312151509product-detail-01.jpg', 'guenichi khalil', 'besma souad', 'Islam', '20230021', '1995-12-12', '8671', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-09 08:58:23', '2023-12-15 14:09:07'),
(24, 'Teacher', 'kouadio christian', 'kouadio@christian', NULL, '$2y$10$pny/bnBpQVQ8LoUsKl/MPeG/sKJG.VUiQpgKX5brBa9wBgts8tKra', NULL, NULL, '+3315451457', 'bordeaux , rue lavoisier', NULL, '202401180914product-detail-01.jpg', NULL, NULL, NULL, '20230001', NULL, '3706', NULL, NULL, NULL, 7000, 1, NULL, NULL, NULL, '2023-12-10 13:41:25', '2024-01-18 08:14:58'),
(38, 'Student', 'Droh Chantal', 'droh@chantal.com', NULL, '$2y$10$s.mPatht4RN62WKdO7Bf4.r5OX8yOK1tgv2QcQOsGVhFawvvzGe5.', NULL, NULL, '+255 84 695 4856', 'haiti', 'Female', '202401180815zara.jpg', 'Droh Damien', 'Keita awa', 'Christan', '20230038', '1989-09-04', '8213', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:43:43', '2024-01-18 07:15:16'),
(39, 'Student', 'Yapo richard', 'yapo@richard.com', NULL, '$2y$10$AKY7aA8Qsw4S87qJZceg9.vjyFxM2HnaZ3q1yFwyiksmqtk9hpTu2', NULL, NULL, '+225 84 96 75 86', 'Divo', 'Male', '202401180816gilet.jpg', 'Adou Richard', 'Anon Yao', 'Christan', '20230039', '1896-12-05', '1281', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:45:36', '2024-01-18 07:16:03'),
(40, 'Student', 'jeff bezos', 'jeff@bezos.com', NULL, '$2y$10$R7PXmBJ1Xx5y9cDqCuEac.crCaFtpqsBj9IRx/EsnBfpCr5KHd4sy', NULL, NULL, '+1 78 95 62 13 45', 'Chicago', 'Male', '202401180817product-detail-01.jpg', 'Richard bezos', 'carine curthine', 'Christan', '20230040', '1980-05-20', '1405', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:48:03', '2024-01-18 07:17:04'),
(41, 'Student', 'Mamadou Doumbia', 'mamadou@doumbia.com', NULL, '$2y$10$IfJcGzzjydGF99SUoNwUNeNeo3DtWh662mp9rHLkZkpfjuKtJJh1u', NULL, NULL, '+212 21 69 8 75', 'rabat', 'Male', NULL, 'Doumia Karim', 'Ky Awa', 'Islam', '20230041', '1986-11-21', '8192', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:50:43', '2023-12-22 10:50:43'),
(42, 'Student', 'Ghassen Hamda', 'ghassen@hamda.com', NULL, '$2y$10$bnYQiubl2hr3u/8mTZ/iUO96Bqw4ihNA5PDiy9XZm967vnEsclgCy', NULL, NULL, '+212 94 87 56 45', 'bardo rue du cavalier 2000 tunis', 'Male', NULL, 'hamba ben salem', 'laila Souissi', 'Hindu', '20230042', '1970-02-07', '3454', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, '2023-12-22 10:53:38', '2023-12-22 10:53:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;