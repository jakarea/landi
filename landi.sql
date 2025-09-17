-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 16, 2025 at 05:45 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `landi`
--

-- --------------------------------------------------------

--
-- Table structure for table `bundle_courses`
--

CREATE TABLE `bundle_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_title` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `selected_course` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `regular_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bundle_selects`
--

CREATE TABLE `bundle_selects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `instructor_id` int(11) DEFAULT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) DEFAULT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public/assets/images/courses/thumbnail.png',
  `short_description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_identifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `bundle_course_id` int(11) DEFAULT NULL,
  `instructor_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `certificate_clr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accent_clr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style` int(11) NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_extension` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Message, 2:File',
  `message_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:Personal message, 2:Group message',
  `is_read` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

CREATE TABLE `checkouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `payment_date` timestamp NULL DEFAULT NULL,
  `is_manual` tinyint(1) NOT NULL DEFAULT '0',
  `payment_details` json DEFAULT NULL,
  `status` enum('pending','processing','completed','decline','canceled','refunded','failed','deleted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount` int(11) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `applicable_courses` json DEFAULT NULL,
  `usage_limit` int(11) NOT NULL DEFAULT '1',
  `used_count` int(11) NOT NULL DEFAULT '0',
  `valid_from` datetime NOT NULL,
  `valid_until` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `original_amount` decimal(8,2) NOT NULL,
  `discount_amount` decimal(8,2) NOT NULL,
  `final_amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `auto_complete` tinyint(4) NOT NULL DEFAULT '1',
  `user_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `promo_video` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `categories` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'latest/assets/images/courses/thumbnail.png',
  `short_description` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `meta_keyword` text COLLATE utf8mb4_unicode_ci,
  `meta_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hascertificate` tinyint(4) NOT NULL DEFAULT '0',
  `sample_certificates` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numbershow` tinyint(4) DEFAULT NULL,
  `numbervalue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `allow_review` tinyint(4) NOT NULL DEFAULT '1',
  `language` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objective` longtext COLLATE utf8mb4_unicode_ci,
  `who_should_join` longtext COLLATE utf8mb4_unicode_ci,
  `curriculum` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_activities`
--

CREATE TABLE `course_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_completed` tinyint(4) NOT NULL DEFAULT '0',
  `duration` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_likes`
--

CREATE TABLE `course_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_logs`
--

CREATE TABLE `course_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `module_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_reviews`
--

CREATE TABLE `course_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `star` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_user`
--

CREATE TABLE `course_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` enum('bkash','nogod','rocket','cash','free_access') COLLATE utf8mb4_unicode_ci DEFAULT 'cash',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `original_amount` decimal(10,2) DEFAULT NULL,
  `promo_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promo_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('payment_pending','pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'payment_pending',
  `payment_screenshot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `rejection_reason` text COLLATE utf8mb4_unicode_ci,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `d_n_s_settings`
--

CREATE TABLE `d_n_s_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` text COLLATE utf8mb4_unicode_ci,
  `join_date` date NOT NULL,
  `retire_date` date DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Creator of group',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_participants`
--

CREATE TABLE `group_participants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_json` longtext COLLATE utf8mb4_unicode_ci,
  `rendered_html` longtext COLLATE utf8mb4_unicode_ci,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_meta_description` text COLLATE utf8mb4_unicode_ci,
  `seo_keywords` text COLLATE utf8mb4_unicode_ci,
  `og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `duration` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `module_id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vimeo',
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('video','audio','text','live') COLLATE utf8mb4_unicode_ci NOT NULL,
  `live_start_time` datetime DEFAULT NULL,
  `live_duration_minutes` int(11) DEFAULT NULL,
  `zoom_meeting_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zoom_join_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zoom_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lesson_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reorder` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_classes`
--

CREATE TABLE `live_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `zoom_meeting_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zoom_start_url` text COLLATE utf8mb4_unicode_ci,
  `zoom_join_url` text COLLATE utf8mb4_unicode_ci,
  `zoom_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('scheduled','live','ended','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `zoom_response` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manage_pages`
--

CREATE TABLE `manage_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pagePermissions` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `publish_at` datetime DEFAULT NULL,
  `reorder` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unseen',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stripe_subscriptions`
--

CREATE TABLE `stripe_subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_packages_id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `end_at` timestamp NULL DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_packages`
--

CREATE TABLE `subscription_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regular_price` decimal(10,2) DEFAULT NULL,
  `sales_price` decimal(10,2) DEFAULT NULL,
  `features` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('monthly','yearly') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `company_name` text COLLATE utf8mb4_unicode_ci,
  `short_bio` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `recivingMessage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_secret_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bkash_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nogod_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rocket_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_public_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `last_activity_at` timestamp NULL DEFAULT NULL COMMENT 'User last activity',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_current` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vimeo_data`
--

CREATE TABLE `vimeo_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bundle_courses`
--
ALTER TABLE `bundle_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bundle_selects`
--
ALTER TABLE `bundle_selects`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_group_id_foreign` (`group_id`),
  ADD KEY `chats_sender_id_foreign` (`sender_id`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_code_is_active_index` (`code`,`is_active`),
  ADD KEY `coupons_instructor_id_is_active_index` (`instructor_id`,`is_active`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_usages_coupon_id_user_id_course_id_unique` (`coupon_id`,`user_id`,`course_id`),
  ADD KEY `coupon_usages_user_id_foreign` (`user_id`),
  ADD KEY `coupon_usages_course_id_foreign` (`course_id`),
  ADD KEY `coupon_usages_coupon_id_created_at_index` (`coupon_id`,`created_at`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_activities`
--
ALTER TABLE `course_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_likes`
--
ALTER TABLE `course_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_logs`
--
ALTER TABLE `course_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_reviews`
--
ALTER TABLE `course_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `d_n_s_settings`
--
ALTER TABLE `d_n_s_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_code_unique` (`code`),
  ADD KEY `groups_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `group_participants`
--
ALTER TABLE `group_participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_participants_group_id_foreign` (`group_id`),
  ADD KEY `group_participants_user_id_foreign` (`user_id`);

--
-- Indexes for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `landing_pages_slug_unique` (`slug`),
  ADD KEY `landing_pages_course_id_foreign` (`course_id`),
  ADD KEY `landing_pages_user_id_foreign` (`user_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_classes_course_id_foreign` (`course_id`),
  ADD KEY `live_classes_instructor_id_course_id_index` (`instructor_id`,`course_id`),
  ADD KEY `live_classes_start_time_index` (`start_time`);

--
-- Indexes for table `manage_pages`
--
ALTER TABLE `manage_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stripe_subscriptions`
--
ALTER TABLE `stripe_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_packages_name_unique` (`name`),
  ADD UNIQUE KEY `subscription_packages_slug_unique` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_sessions_session_id_unique` (`session_id`),
  ADD KEY `user_sessions_user_id_last_activity_index` (`user_id`,`last_activity`),
  ADD KEY `user_sessions_session_id_index` (`session_id`);

--
-- Indexes for table `vimeo_data`
--
ALTER TABLE `vimeo_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bundle_courses`
--
ALTER TABLE `bundle_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bundle_selects`
--
ALTER TABLE `bundle_selects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_activities`
--
ALTER TABLE `course_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_likes`
--
ALTER TABLE `course_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_logs`
--
ALTER TABLE `course_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_reviews`
--
ALTER TABLE `course_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `d_n_s_settings`
--
ALTER TABLE `d_n_s_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_participants`
--
ALTER TABLE `group_participants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_classes`
--
ALTER TABLE `live_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manage_pages`
--
ALTER TABLE `manage_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stripe_subscriptions`
--
ALTER TABLE `stripe_subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vimeo_data`
--
ALTER TABLE `vimeo_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_participants`
--
ALTER TABLE `group_participants`
  ADD CONSTRAINT `group_participants_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD CONSTRAINT `landing_pages_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `landing_pages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `live_classes`
--
ALTER TABLE `live_classes`
  ADD CONSTRAINT `live_classes_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `live_classes_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
