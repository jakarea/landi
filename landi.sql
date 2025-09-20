-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 20, 2025 at 10:12 AM
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

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `instructor_id`, `course_id`, `certificate_clr`, `accent_clr`, `style`, `logo`, `signature`, `created_at`, `updated_at`) VALUES
(5, 23, 42, '#ffffff', '#ffffff', 1, NULL, NULL, '2025-08-20 03:07:23', '2025-08-20 03:07:23'),
(7, 23, 42, '#ffffff', '#ffffff', 1, NULL, NULL, '2025-08-20 03:22:56', '2025-08-20 03:22:56'),
(8, 23, 43, '#ffffff', '#ffffff', 1, NULL, NULL, '2025-08-26 04:28:17', '2025-08-26 04:28:17'),
(10, 23, 50, '#ffffff', '#ffffff', 1, NULL, NULL, '2025-09-14 01:05:31', '2025-09-14 01:05:31'),
(11, 23, 50, '#ffffff', '#ffffff', 1, NULL, NULL, '2025-09-14 01:06:32', '2025-09-14 01:06:32'),
(12, 23, 50, '#ffffff', '#ffffff', 1, NULL, NULL, '2025-09-14 02:22:30', '2025-09-14 02:22:30');

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

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `auto_complete`, `user_id`, `instructor_id`, `slug`, `promo_video`, `price`, `offer_price`, `categories`, `thumbnail`, `short_description`, `description`, `meta_keyword`, `meta_description`, `hascertificate`, `sample_certificates`, `numbershow`, `numbervalue`, `status`, `allow_review`, `language`, `platform`, `objective`, `who_should_join`, `curriculum`, `created_at`, `updated_at`) VALUES
(26, 'Bangla Typography and Logo Design in 30 days', 0, 23, 25, 'bangla-typography-and-logo-design-in-30-days', 'https://www.youtube.com/watch?v=x6cYIpM8Mzc', '1500.00', '299.00', 'AI', 'uploads/courses/cassady-jacobs-68a15a1a8ea3a.jpg', '<h2 class=\"ql-align-center\"><strong>আজ স্পেশাল অফারে নিজের ক্যারিয়ার আপগ্রেড করুন মাত্র ৪৯৯ টাকায়!</strong></h2><p><br></p><p>১৫ ঘণ্টার এই কোর্সটি করার মাধ্যমে আপনি কাস্টমাইজড লোগো ডিজাইন ও টাইপোগ্রাফি শিখতে পারবেন। কোর্সের ইন্সট্রাক্টটর আশিক মোহাম্মদ দীর্ঘদিন ধরে ক্রিয়েটিভ ইন্ডাস্ট্রিতে সফলতার সাথে কাজ করছেন, গড়ে তুলেছেন নিজের ক্রিয়েটিভ এজেন্সি।</p>', '<p><span style=\"color: rgb(90, 90, 90); background-color: rgb(250, 251, 253);\">“বর্তমানে বাংলা লোগো এবং টাইপোগ্রাফির বেশ একটা চল চলছে তার সাথে যুক্ত হয়েছে ব্র্যান্ডগুলোর নানান ক্যাম্পেইন এবং নাটক সিনেমার নামের টাইপোগ্রাফি। এ ক্যম্পেইনগুলো চলে ফিবছর এবং সোশ্যাল মিডিয়া থেকে প্রিন্ট মিডিয়া সর্বত্র বাংলা টাইপোগ্রাফির প্রচলন বেশ নজরে আসে। একইসাথে আছে ব্র্যান্ডসমূহের বাংলা নামকরন যা ইংরেজী নামের অনুরূপ বাংলা। এর বাইরে উৎসব আয়োজন বা ব্লগের জন্য নাম লোগো ছাড়াও বইয়ের প্রচ্ছদের বাংলা টাইপোগ্রাফিক নামলিপি সকল ক্ষেত্রেই এখন টাইপোগ্রাফির প্রচলন। দুঃখজনক হলেও সত্য যে অনেক প্রফেশনালও বাংলা টাইপোগ্রাফিতে ভয় পান বা সামান্য দিকনির্দেশনার অভাবে এগুতে পারেন না। আমরা এই কোর্সটিতে মূলত তুলে ধরবো টাইপোগ্রাফির গঠনগত দিক যাতে করে যে কেউ তাঁর নিজস্ব চিন্তা এবং সৃজনশীলতার মননে নব্য ধারায় টাইপোগ্রাফি করতে পারেন।” – </span><strong style=\"color: rgb(90, 90, 90); background-color: rgb(250, 251, 253);\">আশিক ম</strong><strong style=\"color: initial; background-color: rgb(250, 251, 253);\">, কোর্স ইন্সট্রাকটর, বাংলা টাইপোগ্রাফি ও লোগো ডিজাইন</strong><strong style=\"color: rgb(90, 90, 90); background-color: rgb(250, 251, 253);\">ুহাম্মাদ</strong><span class=\"ql-cursor\">﻿﻿﻿﻿﻿﻿</span></p>', NULL, NULL, 0, NULL, NULL, NULL, 'draft', 1, 'Bangla', NULL, 'বাঙলা টাইপোগ্রাফি[objective]প্রাচীন থেকে এর সৌন্দর্য[objective]প্রয়োগিক ক্ষেত্রসমূহ[objective]নির্দেশক পরিচিতি', NULL, '5', '2025-08-16 21:38:31', '2025-08-18 01:16:59'),
(39, 'গ্রাফিক ডিজাইন উইথ ফটোশপ', 1, 30, 30, 'grafik-dijain-uith-ftosp-1755598421', NULL, '2000.00', '1599.00', 'গ্রাফিক ডিজাইন,ফটোশপ,ক্রিয়েটিভ', 'latest/assets/images/courses/thumbnail.png', 'অ্যাডোবি ফটোশপ দিয়ে প্রফেশনাল গ্রাফিক ডিজাইন শিখুন।', 'অ্যাডোবি ফটোশপের সম্পূর্ণ টুলস এবং টেকনিক শিখে প্রফেশনাল মানের ডিজাইন তৈরি করুন। লোগো ডিজাইন, পোস্টার ডিজাইন, সোশ্যাল মিডিয়া ব্যানার এবং ওয়েব ডিজাইনের উপর হ্যান্ডস-অন প্র্যাক্টিস।', NULL, NULL, 0, NULL, NULL, NULL, 'published', 1, 'বাংলা', NULL, 'ফটোশপের বেসিক টুলস এবং ইন্টারফেস[objective]ইমেজ এডিটিং এবং রিটাচিং টেকনিক[objective]টাইপোগ্রাফি এবং টেক্সট ইফেক্ট[objective]কালার থিওরি এবং কম্পোজিশন[objective]প্রিন্ট এবং ওয়েব ডিজাইনের জন্য প্রস্তুতি', NULL, 'এই কোর্সে ধাপে ধাপে শিক্ষা পদ্ধতি অনুসরণ করা হয়েছে।', '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(41, 'Dolor esse rerum la', 1, 23, 23, 'qui-et-esse-anim-vo', 'https://www.youtube.com/watch?v=njHcl8wik9Q', '444.00', '22.00', 'Neque at exercitatio', 'uploads/courses/cassady-jacobs-68a4564a73e31.png', '<p>Ullamco eiusmod sed!</p>', '<p>Eiusmod dolore ab!</p>', NULL, NULL, 0, 'uploads/courses/sample_certificates.jpg', NULL, NULL, 'published', 1, 'Pariatur Voluptas v', NULL, 'Aut ullamco eveniet[objective]Sit vitae doloremque[objective]Dolores neque quam a[objective]Assumenda et quasi[objective]Ut irure aliqua Qua', NULL, 'Eum quisquam pariatu', '2025-08-19 04:42:28', '2025-08-19 04:51:50'),
(42, 'AI for Advertising Bootcamp-25', 1, 23, 23, 'ai-for-advertising-bootcamp-25', 'https://www.youtube.com/watch?v=RpnsBsvPMSw', '1500.00', '299.00', 'AI', 'uploads/courses/cassady-jacobs-68a5572a84775.png', '<p><strong>AI for Advertising Bootcamp-25</strong> হলো ৩ দিনব্যাপী অনলাইন লাইভ ওয়ার্কশপ, যেখানে শিখবেন কিভাবে এআই টুল ব্যবহার করে ছবি, ভিডিও, মিউজিক, ভয়েসওভার ও বিজ্ঞাপনী কনটেন্ট তৈরি করবেন। প্র্যাকটিক্যাল সেশন, হ্যান্ডস-অন ডেমো এবং প্রফেশনাল টিপসের মাধ্যমে অংশগ্রহণকারীরা বিজ্ঞাপনের ভবিষ্যৎ প্রযুক্তিকে কাজে লাগাতে পারবেন।</p>', '<p>আজকের বিজ্ঞাপন জগতে <strong>Artificial Intelligence (AI)</strong> হচ্ছে সবচেয়ে বড় পরিবর্তনের চালক। ডিজাইন, ভিডিও, সঙ্গীত, ভয়েসওভার – সব ক্ষেত্রেই এআই এনে দিচ্ছে নতুন সম্ভাবনা।</p><p><strong>AI for Advertising Bootcamp-25</strong> একটি বিশেষ ৩ দিনব্যাপী অনলাইন লাইভ প্রশিক্ষণ, যা পরিচালনা করবেন <strong>আব্দুর রউফ (রাজু)</strong> – বাংলাদেশের প্রথম স্বীকৃত এআই আর্টিস্ট এবং Creative Lead (AI), নগদ।</p><p><strong>কোর্স শেষে আপনি পারবেন</strong> –</p><p> ✔ এআই টুল ব্যবহার করে আকর্ষণীয় বিজ্ঞাপন কনটেন্ট তৈরি করতে</p><p> ✔ নিজস্ব প্রজেক্ট, ক্যাম্পেইন ও ব্র্যান্ডিংয়ে AI প্রয়োগ করতে</p><p> ✔ ফ্রিল্যান্স ও কর্পোরেট প্রোজেক্টে প্রতিযোগিতামূলক সুবিধা অর্জন করতে</p><p>🎁 কোর্সে থাকছে লাইভ ডেমো, সার্টিফিকেট, প্রশ্নোত্তর সেশন ও কমিউনিটি সাপোর্ট।</p>', NULL, NULL, 0, 'uploads/courses/sample_certificates_ai-for-advertising-bootcamp-25.png', NULL, NULL, 'published', 1, 'Bangla', NULL, 'এআই-এর সম্ভাবনা ও প্রয়োগ বোঝা[objective]প্রম্পট ইঞ্জিনিয়ারিংয়ে দক্ষতা অর্জন[objective]ভিজ্যুয়াল কনটেন্ট তৈরি[objective]অডিও ও মিউজিক প্রোডাকশন[objective]ব্র্যান্ডিং ও কমিউনিকেশনে এআই-এর ব্যবহার[objective]হ্যান্ডস-অন এক্সপেরিয়েন্স অর্জন[objective]পেশাগত উন্নতি', NULL, '3', '2025-08-19 23:01:01', '2025-08-20 04:41:09'),
(43, 'Complete Japanese Language for Beginners  Overview Certificate Lessons', 1, 23, 23, 'complete-japanese-language-for-beginners-overview-certificate-lessons', 'https://www.youtube.com/watch?v=27YKyQW3lmI', '200.00', '100.00', 'Dolore asperiores qu,AI', 'uploads/courses/cassady-jacobs-68ad87a029e93.png', '<p>Ad dicta et enim!</p>', '<p class=\"ql-align-justify\">In today\'s world, learning a new language can significantly boost your career prospects. If you\'re planning to study in Japan, knowing the Japanese language can make the process smoother and more rewarding.&nbsp;This course,&nbsp;<em>Complete Japanese Language for Beginners</em>, led by Iftakher Uddin, is designed to give you a strong foundation in one of the world’s most fascinating languages. Whether you\'re learning for travel, work, or just personal interest, this course will guide you through the essentials of Japanese, preparing you to speak and understand with confidence.</p><p class=\"ql-align-justify\">The curriculum covers all major areas, from grammar and vocabulary to speaking and listening, and it\'s structured around the popular&nbsp;<em>Minna No Nihongo</em>&nbsp;textbook, ensuring you\'re learning in a progressive, practical way. Each lesson is supported by diverse resources, including videos, audio, PDF materials, and practice exercises.&nbsp;In addition, you will build reading and writing skills through activities that introduce you to&nbsp;<em>hiragana</em>&nbsp;and&nbsp;<em>katakana</em>&nbsp;characters.</p><p class=\"ql-align-justify\">By the end of the course, you will have gained a solid understanding of basic Japanese, equivalent to JLPT N5&nbsp;level, making you ready to engage in everyday conversations.</p><p class=\"ql-align-justify\"><strong>What You’ll Learn:</strong></p><ul><li class=\"ql-align-justify\">Master essential grammar and vocabulary to communicate effectively in Japanese.</li><li class=\"ql-align-justify\">Develop listening and speaking skills through interactive audio and video content.</li><li class=\"ql-align-justify\">Build reading and writing abilities with clear, structured lessons.</li><li class=\"ql-align-justify\">Practice with exercises, quizzes, and downloadable resources to reinforce learning.</li><li class=\"ql-align-justify\">Learn at your own pace with flexible lesson formats, including PDFs and listening exercises.</li></ul><p class=\"ql-align-justify\"><strong>Who is This Course For?</strong></p><ul><li class=\"ql-align-justify\">Complete beginners with no prior knowledge of Japanese.</li><li class=\"ql-align-justify\">Travelers, students, or professionals looking to enhance their communication skills.</li><li class=\"ql-align-justify\">Individuals interested in Japanese culture, anime, or manga.</li><li class=\"ql-align-justify\">Learners preparing for the JLPT N5&nbsp;exams.</li></ul><p class=\"ql-align-justify\"><strong>Why This Course?</strong></p><p class=\"ql-align-justify\">Learning Japanese opens doors to new cultures, career opportunities, and personal growth. Whether you plan to travel to Japan, pursue a business career, or simply enjoy Japanese media, this course will equip you with the tools you need to succeed. With an engaging mix of videos, practice materials, and real-life applications, you will quickly see your language skills grow.</p><p><span style=\"color: rgb(0, 0, 0);\">So, what are you waiting for? Enroll now and smooth your path to Japan. Arigatou!</span>Irure aliquam porro!</p><p><br></p><p><strong>Complete This Course and Get Your certificate!</strong></p><p>Certify Your Skills</p><p>Lead Academy accredited certifies the skills you’ve learned</p><h6><strong>Stand Out From The Crowd</strong></h6><p>Add your Lead Certification to your resume and stay ahead of the competition</p><h6><strong>What Will I Learn?</strong></h6><ul><li>&nbsp;Hiragana and Katakana</li><li>&nbsp;Basic Vocabulary and Phrases</li><li>&nbsp;Grammar and Sentence Structure</li><li>&nbsp;Conversation and Listening Skills</li><li>&nbsp;Reading and Writing</li><li>&nbsp;Normal Conversations</li><li>&nbsp;Common Phrases</li><li>&nbsp;N5&nbsp;details</li><li>&nbsp;N4 basics</li></ul><p><br></p>', NULL, NULL, 0, 'uploads/courses/sample_certificates.jpg', NULL, NULL, 'published', 1, NULL, NULL, 'Quo laborum Quas en', 'Quia anim distinctio[who_should_join]designer', NULL, '2025-08-26 02:36:03', '2025-09-01 09:01:38'),
(50, 'Repellendus Amet', 1, 23, 23, 'repellendus-amet', 'https://www.youtube.com/watch?v=fxMh23YV2J0', '1900.00', '250.00', 'Qui vel corrupti cu', 'uploads/courses/zenia-griffith-68c6590230d9c.webp', '<p>Blanditiis natus!</p>', '<p>Voluptatem!</p>', NULL, NULL, 0, 'uploads/courses/sample_certificates.jpg', NULL, NULL, 'published', 1, NULL, NULL, 'Est aut velit dolor[objective]Tempora id possimus[objective]Quidem occaecat volu', 'Eius cum autem accus[who_should_join]Nemo perspiciatis u[who_should_join]Quo illo quis minim[who_should_join]Placeat et illo rer', NULL, '2025-09-13 23:53:32', '2025-09-14 01:06:15'),
(51, 'Nam saepe numquam at', 1, 23, 23, 'nam-saepe-numquam-at', 'https://www.youtube.com/watch?v=EEivIkJkkrM', '0.00', NULL, 'In aperiam consectet', 'uploads/courses/zenia-griffith-68c6d89a15a50.webp', '<p>Optio, sint, qui!</p>', '<p>Reprehenderit!</p>', NULL, NULL, 0, 'uploads/courses/sample_certificates.jpg', NULL, NULL, 'published', 1, NULL, NULL, 'Numquam molestiae mo', 'Ea aut dolore veniam', NULL, '2025-09-14 08:59:47', '2025-09-14 09:31:45'),
(52, 'Mollitia qui ut volu', 1, 23, 23, 'mollitia-qui-ut-volu', NULL, NULL, NULL, 'Ut eveniet suscipit', 'latest/assets/images/courses/thumbnail.png', '<p>Velit quae fugiat!</p>', '<p>Veniam, error!</p>', NULL, NULL, 0, NULL, NULL, NULL, 'draft', 1, NULL, NULL, NULL, NULL, NULL, '2025-09-15 03:06:12', '2025-09-15 03:06:12');

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

--
-- Dumping data for table `course_activities`
--

INSERT INTO `course_activities` (`id`, `course_id`, `instructor_id`, `module_id`, `lesson_id`, `user_id`, `is_completed`, `duration`, `created_at`, `updated_at`) VALUES
(29, 42, 23, 62, 82, 31, 1, 520, '2025-09-14 21:52:16', '2025-09-14 21:52:16'),
(30, 42, 23, 63, 90, 31, 1, 600, '2025-09-14 21:52:26', '2025-09-14 21:52:26');

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

--
-- Dumping data for table `course_likes`
--

INSERT INTO `course_likes` (`id`, `course_id`, `instructor_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(6, 42, 23, 31, '1', '2025-09-14 21:52:15', '2025-09-14 21:52:15');

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

--
-- Dumping data for table `course_logs`
--

INSERT INTO `course_logs` (`id`, `course_id`, `instructor_id`, `module_id`, `lesson_id`, `user_id`, `created_at`, `updated_at`) VALUES
(17, 42, 23, 63, 90, 31, '2025-09-14 21:52:13', '2025-09-14 21:52:23');

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

--
-- Dumping data for table `course_user`
--

INSERT INTO `course_user` (`id`, `course_id`, `user_id`, `instructor_id`, `payment_method`, `transaction_id`, `amount`, `original_amount`, `promo_code`, `promo_discount`, `paid`, `status`, `payment_screenshot`, `admin_notes`, `rejection_reason`, `start_at`, `end_at`, `created_at`, `updated_at`) VALUES
(9, 41, 31, 23, 'rocket', 'Alias animi eius la', '22.00', '22.00', NULL, '0.00', 1, 'approved', 'uploads/enrollments/1756477230_68b1b72eddd33.png', NULL, NULL, '2025-08-29 08:20:48', '2026-08-29 08:20:48', '2025-08-29 08:20:30', '2025-08-29 08:20:48'),
(11, 42, 31, 23, 'nogod', '23432', '299.00', '299.00', NULL, '0.00', 1, 'approved', NULL, 'Yes', NULL, '2025-09-02 22:16:27', '2026-09-02 22:16:27', '2025-09-02 22:13:38', '2025-09-02 22:16:27'),
(12, 43, 31, 23, 'rocket', '345', '100.00', '100.00', NULL, '0.00', 1, 'approved', 'uploads/enrollments/1757321411_68be98c30174e.jpeg', 'r/courses/nam-saepe-numquam-at', NULL, '2025-09-14 09:12:32', '2026-09-14 09:12:32', '2025-09-08 02:50:11', '2025-09-14 09:12:32'),
(13, 51, 31, 23, 'nogod', 'Expedita et quasi al', '0.00', '0.00', NULL, '0.00', 1, 'approved', 'uploads/enrollments/1757863387_68c6dddb03101.png', NULL, NULL, '2025-09-14 09:23:30', '2026-09-14 09:23:30', '2025-09-14 09:23:07', '2025-09-14 09:23:30');

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

--
-- Dumping data for table `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `profession`, `company_name`, `job_type`, `experience`, `join_date`, `retire_date`, `short_description`, `created_at`, `updated_at`) VALUES
(3, 23, 'Eos consequatur vol 3', 'Wheeler Evans Trading 3', 'Part-time', 'Ex cumque placeat l', '2025-09-02', NULL, 'Exercitation praesen 3', '2025-09-01 21:32:41', '2025-09-02 04:31:15');

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

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `user_id`, `course_id`, `instructor_id`, `duration`, `module_id`, `title`, `slug`, `video_link`, `video_type`, `thumbnail`, `short_description`, `status`, `is_public`, `type`, `live_start_time`, `live_duration_minutes`, `zoom_meeting_id`, `zoom_join_url`, `zoom_password`, `audio`, `text`, `lesson_file`, `reorder`, `created_at`, `updated_at`) VALUES
(14, NULL, 26, 23, 100, 22, 'বাঙলা টাইপোগ্রাফি', 'bangla-taipografi', 'https://www.youtube.com/watch?v=0-O6UyskeUA', 'youtube', NULL, 'https://www.youtube.com/watch?v=Q_mXg5GlIIMhttps://www.youtube.com/watch?v=Q_mXg5GlIIMhttps://www.youtube.com/watch?v=Q_mXg5GlIIM', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-16 22:29:53', '2025-08-18 01:16:55'),
(18, NULL, 36, 29, 0, 39, 'কোর্সের পরিচিতি', 'korser-priciti-39-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(19, NULL, 36, 29, 0, 39, 'প্রয়োজনীয় সফটওয়্যার ইনস্টলেশন', 'przojneez-sftoozzar-instlesn-39-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(20, NULL, 36, 29, 0, 39, 'প্রজেক্ট সেটআপ', 'prjekt-setap-39-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(21, NULL, 36, 29, 0, 40, 'বেসিক কনসেপ্ট', 'besik-knsept-40-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(22, NULL, 36, 29, 0, 40, 'টুলস পরিচিতি', 'tuls-priciti-40-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(23, NULL, 36, 29, 0, 40, 'প্রথম প্রজেক্ট', 'prthm-prjekt-40-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(24, NULL, 36, 29, 0, 41, 'অ্যাডভান্স টেকনিক', 'ozadvans-teknik-41-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(25, NULL, 36, 29, 0, 41, 'বেস্ট প্র্যাকটিস', 'best-przaktis-41-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(26, NULL, 36, 29, 0, 41, 'ট্রাবলশুটিং', 'trablsuting-41-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(27, NULL, 36, 29, 0, 42, 'হ্যান্ডস-অন প্রজেক্ট', 'hzands-on-prjekt-42-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(28, NULL, 36, 29, 0, 42, 'পরীক্ষা এবং মূল্যায়ন', 'preeksha-ebng-muulzazn-42-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(29, NULL, 36, 29, 0, 42, 'চূড়ান্ত প্রজেক্ট', 'cuudant-prjekt-42-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(30, NULL, 37, 30, 0, 43, 'কোর্সের পরিচিতি', 'korser-priciti-43-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(31, NULL, 37, 30, 0, 43, 'প্রয়োজনীয় সফটওয়্যার ইনস্টলেশন', 'przojneez-sftoozzar-instlesn-43-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(32, NULL, 37, 30, 0, 43, 'প্রজেক্ট সেটআপ', 'prjekt-setap-43-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(33, NULL, 37, 30, 0, 44, 'বেসিক কনসেপ্ট', 'besik-knsept-44-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(34, NULL, 37, 30, 0, 44, 'টুলস পরিচিতি', 'tuls-priciti-44-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(35, NULL, 37, 30, 0, 44, 'প্রথম প্রজেক্ট', 'prthm-prjekt-44-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(36, NULL, 37, 30, 0, 45, 'অ্যাডভান্স টেকনিক', 'ozadvans-teknik-45-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(37, NULL, 37, 30, 0, 45, 'বেস্ট প্র্যাকটিস', 'best-przaktis-45-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(38, NULL, 37, 30, 0, 45, 'ট্রাবলশুটিং', 'trablsuting-45-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(39, NULL, 37, 30, 0, 46, 'হ্যান্ডস-অন প্রজেক্ট', 'hzands-on-prjekt-46-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(40, NULL, 37, 30, 0, 46, 'পরীক্ষা এবং মূল্যায়ন', 'preeksha-ebng-muulzazn-46-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(41, NULL, 37, 30, 0, 46, 'চূড়ান্ত প্রজেক্ট', 'cuudant-prjekt-46-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(42, NULL, 38, 29, 0, 47, 'কোর্সের পরিচিতি', 'korser-priciti-47-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(43, NULL, 38, 29, 0, 47, 'প্রয়োজনীয় সফটওয়্যার ইনস্টলেশন', 'przojneez-sftoozzar-instlesn-47-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(44, NULL, 38, 29, 0, 47, 'প্রজেক্ট সেটআপ', 'prjekt-setap-47-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(45, NULL, 38, 29, 0, 48, 'বেসিক কনসেপ্ট', 'besik-knsept-48-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(46, NULL, 38, 29, 0, 48, 'টুলস পরিচিতি', 'tuls-priciti-48-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(47, NULL, 38, 29, 0, 48, 'প্রথম প্রজেক্ট', 'prthm-prjekt-48-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(48, NULL, 38, 29, 0, 49, 'অ্যাডভান্স টেকনিক', 'ozadvans-teknik-49-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(49, NULL, 38, 29, 0, 49, 'বেস্ট প্র্যাকটিস', 'best-przaktis-49-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(50, NULL, 38, 29, 0, 49, 'ট্রাবলশুটিং', 'trablsuting-49-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(51, NULL, 38, 29, 0, 50, 'হ্যান্ডস-অন প্রজেক্ট', 'hzands-on-prjekt-50-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(52, NULL, 38, 29, 0, 50, 'পরীক্ষা এবং মূল্যায়ন', 'preeksha-ebng-muulzazn-50-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(53, NULL, 38, 29, 0, 50, 'চূড়ান্ত প্রজেক্ট', 'cuudant-prjekt-50-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(54, NULL, 39, 30, 0, 51, 'কোর্সের পরিচিতি', 'korser-priciti-51-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(55, NULL, 39, 30, 0, 51, 'প্রয়োজনীয় সফটওয়্যার ইনস্টলেশন', 'przojneez-sftoozzar-instlesn-51-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(56, NULL, 39, 30, 0, 51, 'প্রজেক্ট সেটআপ', 'prjekt-setap-51-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(57, NULL, 39, 30, 0, 52, 'বেসিক কনসেপ্ট', 'besik-knsept-52-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(58, NULL, 39, 30, 0, 52, 'টুলস পরিচিতি', 'tuls-priciti-52-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(59, NULL, 39, 30, 0, 52, 'প্রথম প্রজেক্ট', 'prthm-prjekt-52-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(60, NULL, 39, 30, 0, 53, 'অ্যাডভান্স টেকনিক', 'ozadvans-teknik-53-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(61, NULL, 39, 30, 0, 53, 'বেস্ট প্র্যাকটিস', 'best-przaktis-53-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(62, NULL, 39, 30, 0, 53, 'ট্রাবলশুটিং', 'trablsuting-53-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(63, NULL, 39, 30, 0, 54, 'হ্যান্ডস-অন প্রজেক্ট', 'hzands-on-prjekt-54-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(64, NULL, 39, 30, 0, 54, 'পরীক্ষা এবং মূল্যায়ন', 'preeksha-ebng-muulzazn-54-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(65, NULL, 39, 30, 0, 54, 'চূড়ান্ত প্রজেক্ট', 'cuudant-prjekt-54-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(66, NULL, 40, 29, 0, 55, 'কোর্সের পরিচিতি', 'korser-priciti-55-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(67, NULL, 40, 29, 0, 55, 'প্রয়োজনীয় সফটওয়্যার ইনস্টলেশন', 'przojneez-sftoozzar-instlesn-55-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(68, NULL, 40, 29, 0, 55, 'প্রজেক্ট সেটআপ', 'prjekt-setap-55-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(69, NULL, 40, 29, 0, 56, 'বেসিক কনসেপ্ট', 'besik-knsept-56-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(70, NULL, 40, 29, 0, 56, 'টুলস পরিচিতি', 'tuls-priciti-56-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(71, NULL, 40, 29, 0, 56, 'প্রথম প্রজেক্ট', 'prthm-prjekt-56-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(72, NULL, 40, 29, 0, 57, 'অ্যাডভান্স টেকনিক', 'ozadvans-teknik-57-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(73, NULL, 40, 29, 0, 57, 'বেস্ট প্র্যাকটিস', 'best-przaktis-57-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(74, NULL, 40, 29, 0, 57, 'ট্রাবলশুটিং', 'trablsuting-57-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(75, NULL, 40, 29, 0, 58, 'হ্যান্ডস-অন প্রজেক্ট', 'hzands-on-prjekt-58-0', NULL, 'vimeo', NULL, NULL, 'published', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(76, NULL, 40, 29, 0, 58, 'পরীক্ষা এবং মূল্যায়ন', 'preeksha-ebng-muulzazn-58-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(77, NULL, 40, 29, 0, 58, 'চূড়ান্ত প্রজেক্ট', 'cuudant-prjekt-58-2', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(78, NULL, 41, 23, 600, 59, 'Rebecca Cherry', 'rebecca-cherry', 'https://www.youtube.com/watch?v=c-NEppjZu-Y', 'youtube', NULL, 'htt ps://wvww.yout https://ww w.you vtube. com/wa tch?v=c-NEp pjvZu-Yubh ttvps://www.https://ww w.yvoutube .com/watch?v=c-vNEppjZvu- https://ww w.youtu be.com/w atc h?v=c-NEppjZ  u-YYyout ub e.com/ watch?v=c- NEppjZu-Yhttps:// www.youtub e.com/wat ch?v=c-NEppjZ u-Ye.com/w atch?v=c- NEppjZu-Y', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 04:49:04', '2025-08-19 04:50:02'),
(79, NULL, 41, 23, 0, 59, 'Anjolie Mckee', 'anjolie-mckee', NULL, 'vimeo', NULL, NULL, 'published', 0, 'text', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/lessons/files/68a457252af6a.pdf', 0, '2025-08-19 04:50:40', '2025-08-19 04:51:17'),
(80, NULL, 42, 23, 240, 62, 'বিজ্ঞাপনে এআই-এর সম্ভাবনা ও ট্রেন্ডস', 'bijngapne-eai-er-smvabna-oo-trends', 'https://www.youtube.com/watch?v=D24Oo0B5AN8', 'youtube', NULL, 'Jack Ma, the founder and CEO of Alibaba gives his advice to the young people. In this talk he focuses on why successful people like Bill Gates, Mark Zuckerberg, Larry Page etc. succeeded and how our young people can follow their path and be successful.', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:04:43', '2025-08-20 03:25:54'),
(81, NULL, 42, 23, 600, 62, 'ইমেজের জন্য প্রম্পট ইঞ্জিনিয়ারিং (Prompt Writing)', 'imejer-jnz-prmpt-injinizaring-prompt-writing', 'https://www.youtube.com/watch?v=V-UsGuZHAMA', 'youtube', NULL, 'Don\'t worry about the future - Jack ma Motivation video.\r\n\r\nJack ma\'s tell here the future of youngsters, what their obligation is.\r\n\r\n  Youngsters are all future of the life, they want to be brave.\r\n\r\nBest books for financial growth:\r\n\r\nThe Psychology Of Money.\r\n      https://amzn.to/3ZlUkUx\r\n\r\nRich Dad Poor Dad: What the Rich Teach Their Kids About Money That the Poor and Middle Class                   \r\n     Do It!\r\n      https://amzn.to/3LzDT1d\r\n\r\nThe Power of Your Subconscious Mind.\r\n      https://amzn.to/3r2chKV.', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:05:08', '2025-08-20 03:26:37'),
(82, NULL, 42, 23, 520, 62, 'সেরা এআই টুলস ফর ইমেজ জেনারেশন', 'sera-eai-tuls-fr-imej-jenaresn', 'https://www.youtube.com/watch?v=1KzuVaPL1h8', 'youtube', NULL, 'What is the secret to success? Is it intelligence, luck, or hard work? In this powerful and inspiring speech, Jack Ma shares one simple rule that can transform your life—Never Give Up.\r\n\r\nThrough personal stories, real-life lessons, and a touch of humor, Jack Ma reveals the struggles he faced, from repeated rejections to building Alibaba into a global empire. This speech is packed with motivation, wisdom, and practical insights that will push you to chase your dreams, overcome failure, and never stop believing in yourself.\r\n\r\nIf you’ve ever felt like giving up, this is the message you need to hear. Success is not about where you start—it’s about how determined you are to keep going.\r\n\r\n🔥 Key Takeaways:\r\n✔ The beginning is always hard, but persistence is key.\r\n✔ The world won’t believe in you until you prove yourself.\r\n✔ Success is a journey, not an overnight event.\r\n✔ Rejection is just part of the process—keep moving forward.\r\n✔ If you never give up, success is inevitable.\r\n\r\n💡 Subscribe for more motivational content!\r\n📢 Like, Comment & Share this video to inspire others!', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:05:28', '2025-08-20 03:27:27'),
(83, NULL, 42, 23, 220, 62, 'পারফেক্ট ইমেজ তৈরির কৌশল (কম্পোজিশন, লাইটিং, স্টাইলিং)', 'parfekt-imej-toirir-kousl-kmpojisn-laiting-stailing', 'https://www.youtube.com/watch?v=sDy07cIYrdg', 'youtube', NULL, '\"I don’t want people in China to have deep pockets but shallow minds\" — Jack Ma / 馬雲\r\n\r\nYou can support the channel and my mission by subscribing → https://www.youtube.com/savanteum?sub... 🙏\r\n\r\nOr sponsor our mission through membership:    / @savanteum  \r\n\r\n_____________________________________________________________\r\n▼ SUPPORT THE CHANNEL ▼\r\n\r\n👉 My Music: (30 Day Free Trial on Epidemic Sound)\r\nhttps://share.epidemicsound.com/j6uiog\r\n\r\n👉 My Editing Gear: \r\nMicrophone: https://amzn.to/3rgJPVo (amazon) \r\nMonitor: https://amzn.to/3O67DnT (amazon) \r\nComputer: https://amzn.to/44AqhK6 (amazon) \r\nHeadphones: https://amzn.to/43jn9Bf (amazon) \r\nWireless Mouse: https://amzn.to/3JR98nc (amazon)\r\n\r\n👉 TubeBuddy: (Free to install, for YT Analytics)\r\nhttps://www.tubebuddy.com/savanteum', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:05:59', '2025-08-20 03:28:15'),
(84, NULL, 42, 23, 600, 62, 'ক্যারেক্টার ট্রেইনিং ও কনসিস্টেন্সি', 'kzarektar-treining-oo-knsistensi', 'https://www.youtube.com/watch?v=1O3ghiyirvU', 'youtube', NULL, 'A conversation with Jack Ma, Founder and Executive Chairman of Alibaba Group, on leadership, entrepreneurship and the future of commerce\r\n\r\nThis session is on the record and webcast live.\r\n\r\nhttp://www.weforum.org/\r\n\r\nAs the session is only 45 minutes long, please be seated early; the doors will be closed at the scheduled time and no latecomers admitted.\r\n• Jack Ma, Executive Chairman, Alibaba Group, People\'s Republic of China; World Economic Forum Foundation Board Member\r\n\r\nInterviewed by\r\n• Charlie Rose, Anchor, CBS News, USA\r\n\r\nThe World Economic Forum is the International Organization for Public-Private Cooperation. The Forum engages the foremost political, business, cultural and other leaders of society to shape global, regional and industry agendas. We believe that progress happens by bringing together people from all walks of life who have the drive and the influence to make positive change.', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:06:13', '2025-08-20 03:28:57'),
(85, NULL, 42, 23, 234, 62, 'ফেইস সুইচ ও রিপ্লেস টেকনিকস', 'feis-suic-oo-riples-tekniks', 'https://www.youtube.com/watch?v=S7Q_ytaeUpY', 'youtube', NULL, 'Jack Ma gives Advice to the Young People and Shares his Biggest Regret!\r\n\r\nJack Ma is one of the Richest Man of China and the Founder of Alibaba Group.\r\n\r\nBuy us a coffee: https://www.buymeacoffee.com/goalquest\r\n\r\n► Subscribe to our channel for inspirational videos:\r\nhttps://bit.ly/2OZ2wF6\r\n\r\nShare this video.', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:06:31', '2025-08-20 03:29:39'),
(86, NULL, 42, 23, 600, 62, 'এআই টুল দিয়ে ইমেজ এডিটিং', 'eai-tul-dize-imej-editing', 'https://www.youtube.com/watch?v=f3lUEnMaiAU', 'youtube', NULL, '5,340,727 views  Streamed live on Aug 29, 2019  #AI\r\nAlibaba co-founder and executive chairman Jack Ma and Tesla CEO Elon Musk hold a debate in Shanghai over artificial intelligence.\r\n#AI', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:06:46', '2025-08-20 03:31:17'),
(87, NULL, 42, 23, 600, 63, 'ভিডিওর জন্য প্রম্পট তৈরির নিয়ম', 'vidioor-jnz-prmpt-toirir-nizm', 'https://www.youtube.com/watch?v=CZfp0ZUsBdM', 'youtube', NULL, 'Learn English with Jack Ma. Chinese billionaire Jack Ma made an on-stage appearance at the World Economic Forum in Davos in 2017. The life of Jack Ma has been one of highs and lows. In the past he has been rejected by Harvard, ten times, and once, while teaching English, he earned as little as twelve dollars a month. Today, however, he is the founder and chairman of the e-commerce giant Alibaba, the single largest retailer in the world. Ma is a strong proponent of an open and market-driven economy. In this Speech, he also quotes: \"Believe in what you\'re doing. Love it. Whether people like it, don\'t like it, be simple.\" - Watch with big English subtitles.\r\n\r\n✅ Get the full transcript and audio of this speech FREE on our website:\r\nhttps://www.englishspeecheschannel.co...', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:07:00', '2025-08-20 03:32:02'),
(88, NULL, 42, 23, 520, 63, 'প্রম্পট থেকে ভিডিও বানানো', 'prmpt-theke-vidioo-banano', 'https://www.youtube.com/watch?v=r2kP2Pqdx6w', 'youtube', NULL, 'Learn English with Elon Musk & Jack Ma. The billionaires, Jack Ma and Elon Musk discussed artificial intelligence and space travel at WAIC 2019 (World Artificial Intelligence Conference). The founder of Alibaba and Tesla CEO Elon Musk have a free-wheeling debate at the WAIC 2019 in Shanghai. They discuss people\'s relationship with machines, artificial intelligence, employment, how artificial intelligence will determine the future of education and health care - and even how humans will travel to other planets.', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:07:13', '2025-08-20 03:32:44'),
(89, NULL, 42, 23, 600, 63, 'ইমেজ থেকে ভিডিও তৈরি', 'imej-theke-vidioo-toiri', 'https://www.youtube.com/watch?v=lYGGpc2mMno', 'youtube', NULL, 'If you are struggling or having a hard time, consider taking an online therapy session with our partner BetterHelp!\r\nhttp://tryonlinetherapy.com/motivatio...\r\n\r\n*The above is a paid referral link for BetterHelp. We have experience using their product, and whole-heartedly recommend their services.\r\n\r\nSubscribe for Motivational Videos Every Weekday, Helping You Get Through The Week! http://bit.ly/MotivationVideos\r\n\r\nFollow us on:\r\nInstagram: http://bit.ly/2rhGNMY\r\nFacebook: http://bit.ly/2r85DC3\r\nTwitter: http://bit.ly/2qir5TO\r\n\r\n---------------------------------------­­------------------------\r\n\r\nVideo Licensed from Clinton Global Initiative (press[at]clintonfoundation.org)\r\n\r\nFootage licensed through Videoblocks and Videohive.', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:07:27', '2025-08-20 03:33:41'),
(90, NULL, 42, 23, 600, 63, 'অডিওসহ ভিডিও জেনারেশন (Veo 3)', 'odioosh-vidioo-jenaresn-veo-3', 'https://www.youtube.com/watch?v=TfHgBldlnR4', 'youtube', NULL, 'Time is the most valuable resource we all share equally—everyone gets 24 hours a day. But what separates successful people from the rest is how they use that time. In this video, we dive deep into how to use your 24 hours effectively, drawing powerful lessons from Jack Ma, the founder of Alibaba and one of the most influential entrepreneurs in the world.\r\n\r\nJack Ma believes that smart time management is key to personal and professional success. Whether you’re a student, entrepreneur, employee, or dreamer, the way you spend your day defines your future. Jack Ma once said, \"If you don’t give up, you still have a chance. Giving up is the greatest failure.\" So how do you make the most of every hour, every minute?\r\n\r\nIn this motivational breakdown, we explore:\r\n🔹 The 6-6-6 rule: What Jack Ma says about managing time at different stages of life.\r\n🔹 Morning routines that boost productivity\r\n🔹 Why working hard isn’t enough—work smart\r\n🔹 How to avoid time-wasters and distractions\r\n🔹 Evening habits to reflect, reset, and grow\r\n\r\n📌 Whether you have big dreams or are just trying to stay consistent, this guide will help you turn each 24 hours into a step toward your goals. Inspired by Jack Ma\'s mindset, this video will change how you look at your daily routine and show you how small decisions create big changes over time.\r\n\r\n📅 Remember, your 24 hours are your secret weapon—use them wisely.\r\n\r\n🎥 Credits and References This video draws inspiration from the motivational teachings of Mr. Jack Ma and is meant solely for educational and inspirational purposes. The voiceover used in this video is an AI-generated voice, not that of any human being, although it closely resembles the voice of Mr. Jack Ma. As admirers of this legendary figure, we channel our passion into creating these motivational \r\nspeeches, inspired by his timeless words and virtues. Through our dedicated efforts, we aim to inspire and motivate everyone to achieve success and inner peace.\r\n\r\n👉 Share This Message: Know someone who needs a boost? Share this video and spread the motivation! {    • 7 Things You Should Never Share With Other...  }', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:07:41', '2025-08-20 03:34:29'),
(91, NULL, 42, 23, 600, 63, 'ভয়েসওভারের সাথে লিপ সিঙ্ক ও ভয়েস অ্যানিমেশন', 'vzesoovarer-sathe-lip-sink-oo-vzes-ozanimesn', 'https://www.youtube.com/watch?v=U5HvuKEjH6g', 'youtube', NULL, '🧠 JACK MA’S POWERFUL ADVICE ON TIME MANAGEMENT FOR SUCCESS\r\n\r\n\"If you don\'t spend time improving yourself, you will always work for someone who did.\" — Jack Ma\r\n\r\nIn this motivational video, Jack Ma shares life-changing advice on how to spend your time wisely. Whether you\'re a student, entrepreneur, content creator, or dreamer, this video will inspire you to take control of your time and level up your life.\r\n\r\n🎯 Learn:\r\nHow Jack Ma thinks about time\r\nThe importance of self-discipline and personal growth\r\nWhy time is your most valuable asset\r\nHow successful people spend their time\r\n\r\n⚡ Watch this daily to stay focused and motivated on your goals.', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:07:55', '2025-08-20 03:38:48'),
(92, NULL, 42, 23, 600, 64, 'এআই দিয়ে মিউজিক প্রম্পট লেখা', 'eai-dize-miujik-prmpt-lekha', 'https://www.youtube.com/watch?v=ytt2pmIj0zs', 'youtube', NULL, 'MAKE YOUR OWN FUTURE | JACK MA | SPEECHES\r\n\r\nJack Ma, the visionary founder of Alibaba, shares life-changing lessons about building your future, overcoming challenges, and never giving up. This motivational speech will inspire you to create your own path and achieve success through discipline, courage, and determination.\r\n\r\nIn this video, you will discover:\r\n✅ How to take control of your own destiny\r\n✅ The mindset that leads to success\r\n✅ Jack Ma’s advice for students, entrepreneurs, and dreamers\r\n✅ Powerful life lessons to inspire your journey\r\n\r\nIf you’re looking for daily motivation, business inspiration, or guidance to achieve your dreams – this speech is for you!\r\n\r\n🔔 Subscribe for more motivational speeches, success stories, and inspirational content.', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:08:16', '2025-08-20 03:39:49'),
(93, NULL, 42, 23, 123, 64, 'লিরিক/গানের কথা লেখায় এআই-এর ব্যবহার', 'lirikganer-ktha-lekhaz-eai-er-bzbhar', 'https://www.youtube.com/watch?v=Qx-zU9S5oOw', 'youtube', NULL, 'China\'s richest man Jack Ma has lived a life full of rejection. From primary school to Harvard, KFC to the police force, Ma faced disappointment time and time again. So how did his company, Alibaba, become the biggest online marketing company in the world? He tells you his secret.\r\n\r\n► Watch all our inspirational videos: \r\nhttps://www.goalcast.com/epic-inspira...\r\n\r\n► Subscribe Here:\r\nhttps://goo.gl/wTKGC4\r\n\r\nShare this video. Spread the motivation.\r\n\r\n========================================­­­­­­­========\r\n\r\nFOLLOW US: \r\nFacebook: https://goo.gl/cjShXM\r\nInstagram: https://goo.gl/XaukHK\r\nTwitter: https://goo.gl/WBe30b\r\n\r\nWebsite: https://www.goalcast.com', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:09:25', '2025-08-20 03:40:32'),
(94, NULL, 42, 23, 629, 64, 'এআই দিয়ে মিউজিক কম্পোজিশন', 'eai-dize-miujik-kmpojisn', 'https://www.youtube.com/watch?v=0bCKKlbFA_Q', 'youtube', NULL, 'Are you struggling to learn English? Do grammar rules make your head spin? Do you feel embarrassed when speaking or worry about making mistakes? This video is for YOU!\r\n\r\nIn this inspiring, educational, and hilarious motivational speech titled \"How To Learn English Fast\", we reveal powerful tips, funny truths, and practical techniques to help you learn English with confidence, joy, and speed — no matter your age, background, or level.\r\n\r\n🧠 What you’ll learn in this video:\r\n\r\nWhy motivation is your most powerful tool\r\n\r\nHow to practice English like a baby (and why it works!)\r\n\r\nSimple ways to speak English every day — even if you\'re alone\r\n\r\nWhy mistakes are your best teachers\r\n\r\nThe secret to learning English faster than traditional schools teach\r\n\r\nHow to stop comparing yourself and start celebrating your progress\r\n\r\nAnd so much more!\r\n\r\nWhether you’re learning English to improve your career, pass an exam, connect with new people, or just feel confident in conversation — this speech will lift your spirit, make you laugh, and get you moving in the right direction.\r\n\r\n💥 Don’t just learn English — LIVE IT.\r\n\r\n👍 Like, Comment, and Subscribe for more motivational content!\r\n🔔 Hit the bell icon so you never miss a new video!\r\n📢 Share this video with a friend who wants to learn English faster and better!', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:09:37', '2025-08-20 03:41:13'),
(95, NULL, 42, 23, 480, 64, 'ভয়েসওভার স্ক্রিপ্ট রাইটিং উইথ এআই', 'vzesoovar-skript-raiting-uith-eai', 'https://www.youtube.com/watch?v=JotORde_RmI', 'youtube', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:09:50', '2025-08-20 03:41:58'),
(96, NULL, 42, 23, 550, 64, 'এআই টুল দিয়ে ভয়েসওভার জেনারেশন', 'eai-tul-dize-vzesoovar-jenaresn', 'https://www.youtube.com/watch?v=IBRa-qAgjzE', 'youtube', NULL, NULL, 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:10:08', '2025-08-20 03:42:34'),
(97, NULL, 42, 23, 0, 64, 'সাউন্ড ইফেক্ট (SFX) জেনারেশন', 'saund-ifekt-sfx-jenaresn', NULL, 'vimeo', NULL, NULL, 'pending', 0, 'audio', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-19 23:10:21', '2025-08-20 03:42:59'),
(98, NULL, 43, 23, 600, 65, 'Ciaran Rasmussen', 'ciaran-rasmussen', 'https://www.youtube.com/watch?v=k1b_4IhLJu4', 'youtube', NULL, 'Enter a valid YouTube URL (supports youtube.com/watch and youtu.be formats) Vimeo account not connected. Connect Vimeo Account or use YouTube option.', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-08-21 02:29:40', '2025-08-26 04:25:49'),
(99, NULL, 43, 23, 340, 65, 'Lesson 3', 'lesson-3', 'https://www.youtube.com/watch?v=peGwJ6T4ASw', 'youtube', NULL, 'Contents\r\n\r\nInstitutions\r\n\r\nVideo Type\r\nVimeo Upload (Not Connected)\r\nYouTube Video Link\r\nVimeo account not connected. Connect Vimeo Account or use YouTube option.\r\nYouTube Video URL\r\nhttps://www.youtube.com/watch?v=peGwJ6T4ASw\r\nEnter a valid YouTube URL (supports youtube.com/watch and youtu.be formats)\r\nVideo Duration (seconds)\r\n340\r\nEnter the video duration in seconds (e.g., 300 for a 5-minute video)\r\nA Short description for this video', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2025-08-21 02:31:22', '2025-08-26 04:26:46'),
(100, NULL, 43, 23, 79, 65, 'Lesson 1', 'lesson-1', 'https://www.youtube.com/watch?v=6oRVP9SGJtU', 'youtube', NULL, 'শাকিব কে নিয়ে লাফা লাফি বন্ধ কর !! \"নিশো\" এই ভিডিওতে এই বিষয় নিয়ে বলা হলো 👍\r\n\r\nশাকিব খানের নতুন সিনেমা \r\nআবু হায়াত নতুন সিনেমা \r\nআফরান নিশো\r\nশাকিব নতুন মুভি\r\nশাকিব খানের বই\r\nশাকিব খান \r\nShakib khan upcoming movie \r\nshakib Khan new movie \r\nonce upon atime in dhaka movie viral video \r\nDhallywood upcoming movie', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-08-21 03:08:01', '2025-08-26 05:18:27'),
(101, NULL, 43, 23, 48, 66, 'Danielle Holcomb', 'danielle-holcomb', 'https://www.youtube.com/watch?v=Xlm7pxRjUro', 'youtube', NULL, 'Aut commodi maiores', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-08-27 07:10:31', '2025-08-27 07:10:59'),
(103, NULL, 50, 23, 243, 70, 'https://www.youtube.com/watch?v=Ib_L3vuUX5k', 'httpswwwyoutubecomwatchvib-l3vuux5k', 'https://www.youtube.com/watch?v=Ib_L3vuUX5k', 'youtube', NULL, 'The song “Gulbahar” is an enchanting symphony originated from the timeless alleys of Puran Dhaka.\r\n\r\nIt\'s a journey of an unfinished love where the melody sings about a hopeless romantic who fell in love with Gulbahar; A girl whose beauty eclipsed the stars. The girl whose beauty couldn\'t be bounded by words.\r\nLike every fantasy, this one had the amazement of that first glance to some unfortunate twists.\r\n\r\nGulbahar | গুলবাহার', 'published', 1, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-14 00:51:05', '2025-09-14 00:52:08'),
(104, NULL, 50, 23, 1300, 70, 'মন্ত্রীর জুতোর দোকান | Maha Mantri Open A Shoe Shop In Krishna Nagar - Is It a Scam ?', 'mntreer-jutor-dokan-maha-mantri-open-a-shoe-shop-in-krishna-nagar-is-it-a-scam', 'https://www.youtube.com/watch?v=aKbELbcX_2c', 'youtube', NULL, 'In this funny episode of Gopal Bhand, the Maha Mantri opens a new shoe shop in Krishnanagar and takes blessings from Raja Krishna Chandra Roy. But soon something strange happens—everyone’s shoes start disappearing! Villagers are forced to buy new shoes from Mantri’s shop. Even the Raja orders his soldiers to guard the shoes at night, but the robberies continue. This time, even Gopal’s shoes are stolen! Will Gopal catch the real thief and solve the mystery? Watch the full story to find ou\r\n\r\nShow Name: Gopal Bhar - গোপালভাঁড়\r\nDirected By: Sourav Mondal, Hansa Mondal\r\nWritten By: Hansa Mondal\r\nOriginal language: Bengali', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-14 02:20:28', '2025-09-14 02:22:04'),
(105, NULL, 71, 23, 0, 71, 'Live class 1', 'live-class-1', NULL, 'vimeo', NULL, NULL, 'published', 0, 'live', '2025-09-16 21:01:00', 30, '2345687654', 'http://localhost:8000/instructor/courses/create/51/live/71/content/105', '2345', NULL, NULL, NULL, 0, '2025-09-14 09:01:09', '2025-09-14 09:24:13'),
(106, NULL, 71, 23, 0, 71, 'কোর্স কন্টেন্ট ম্যানেজমেন্ট', 'kors-kntent-mzanejment', NULL, 'vimeo', NULL, NULL, 'published', 1, 'live', '2025-10-16 05:52:00', 90, 'Qui adipisicing saep', 'https://www.kacaxoliwutyta.net', 'Consequatur voluptat', NULL, NULL, NULL, 0, '2025-09-14 09:11:01', '2025-09-14 09:24:22'),
(107, NULL, 51, 23, 0, 72, 'নতুন লেসন যোগ করুন', 'ntun-lesn-zog-krun', NULL, 'vimeo', NULL, NULL, 'published', 0, 'live', '2025-10-14 10:21:00', 120, 'Quia ut quae rerum a', 'https://www.rafoq.me', 'Fugiat sunt et dolo', NULL, NULL, NULL, 0, '2025-09-14 09:30:28', '2025-09-14 09:30:48'),
(108, NULL, 51, 23, 350, 72, 'Florence Mcguire', 'florence-mcguire', 'https://www.youtube.com/watch?v=EEivIkJkkrM', 'youtube', NULL, 'https://www.youtube.com/watch?v=EEivIkJkkrM', 'published', 0, 'video', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-09-14 09:32:03', '2025-09-14 09:32:15'),
(109, NULL, 51, 23, 0, 73, 'Yesterday Whitney Oneil', 'yesterday-whitney-oneil', NULL, 'vimeo', NULL, NULL, 'published', 0, 'live', '2025-09-13 04:30:00', 90, 'Ut magna aliquam rer', 'https://www.tipamojo.org.uk', 'Quibusdam ex incidun', NULL, NULL, NULL, 0, '2025-09-14 20:23:02', '2025-09-14 20:23:25');

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

--
-- Dumping data for table `live_classes`
--

INSERT INTO `live_classes` (`id`, `title`, `description`, `instructor_id`, `course_id`, `course_name`, `start_time`, `duration_minutes`, `zoom_meeting_id`, `zoom_start_url`, `zoom_join_url`, `zoom_password`, `status`, `zoom_response`, `created_at`, `updated_at`) VALUES
(1, 'Nisi reprehenderit', 'Illo asperiores fuga', 23, NULL, 'Adrian Gilmore', '2026-04-13 19:16:00', 45, 'demo_158252221', 'https://zoom.us/demo/start/415261148', 'https://zoom.us/demo/join/299535223', '9121', 'live', '{\"id\": \"demo_158252221\", \"topic\": \"Nisi reprehenderit\", \"status\": \"demo_mode\", \"duration\": \"45\", \"join_url\": \"https://zoom.us/demo/join/299535223\", \"password\": 9121, \"start_url\": \"https://zoom.us/demo/start/415261148\", \"start_time\": \"2026-04-13T19:16:00.000000Z\"}', '2025-09-14 03:01:32', '2025-09-14 03:03:56'),
(2, 'Commodo sit culpa', 'Et minima quis perfe', 23, NULL, 'Ezekiel Blanchard', '2025-10-03 19:53:00', 180, 'Ea eos distinctio', 'https://www.his.me.uk', 'https://www.his.me.uk', 'Consequatu', 'scheduled', NULL, '2025-09-14 04:08:08', '2025-09-14 04:08:08');

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

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(29, '2014_10_12_000000_create_users_table', 1),
(30, '2014_10_12_100000_create_password_resets_table', 1),
(31, '2019_08_19_000000_create_failed_jobs_table', 1),
(32, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(33, '2021_08_01_211701_create_groups_table', 1),
(34, '2021_08_01_221612_create_group_participants_table', 1),
(35, '2021_08_01_230018_create_chats_table', 1),
(36, '2023_05_17_073812_create_courses_table', 1),
(37, '2023_05_18_054308_create_modules_table', 1),
(38, '2023_05_18_070744_create_lessons_table', 1),
(39, '2023_06_03_085108_create_checkouts_table', 1),
(40, '2023_06_03_144920_create_course_user_table', 1),
(41, '2023_06_06_045002_create_subscriptions_table', 1),
(42, '2023_06_06_045020_create_stripe_subscriptions_table', 1),
(43, '2023_06_06_053441_create_subscription_packages_table', 1),
(44, '2023_06_06_182323_create_course_reviews_table', 1),
(45, '2023_06_10_041946_create_vimeo_data_table', 1),
(46, '2023_06_11_184240_create_courselogs', 1),
(47, '2023_06_11_185552_create_course_activities', 1),
(48, '2023_08_28_070528_create_experiences_table', 1),
(49, '2023_09_14_100215_create_course_likes_table', 1),
(50, '2023_09_18_191615_create_carts_table', 1),
(51, '2023_09_19_113342_create_notifications_table', 1),
(52, '2023_10_08_044145_create_manage_pages_table', 1),
(53, '2023_10_11_043505_create_bundle_selects_table', 1),
(54, '2023_10_11_075528_create_bundle_courses_table', 1),
(55, '2023_10_16_200031_create_certificates_table', 1),
(56, '2023_12_09_093651_create_d_n_s_settings_table', 1),
(57, '2025_08_11_071834_create_cache_table', 2),
(58, '2025_08_17_065714_add_video_type_to_lessons_table', 3),
(59, '2025_08_18_123614_add_publish_at_to_modules_table', 4),
(60, '2025_08_19_101044_add_manual_payment_fields_to_checkouts_table', 5),
(61, '2025_08_21_084001_add_who_should_join_to_courses_table', 6),
(62, '2025_08_21_084007_add_is_public_to_lessons_table', 6),
(63, '2025_08_22_064322_add_manual_enrollment_columns_to_course_user_table', 7),
(64, '2025_08_22_114831_add_promo_fields_to_course_user_table', 8),
(65, '2025_08_23_070437_create_landing_pages_table', 9),
(66, '2025_08_23_121325_add_payment_columns_to_users_table', 10),
(67, '2025_08_27_051852_create_coupons_table', 11),
(68, '2025_08_27_052347_create_coupon_usages_table', 11),
(69, '2025_08_27_061617_update_course_user_status_enum_add_payment_pending', 12),
(70, '2025_08_27_071927_add_free_access_payment_method_to_course_user_table', 13),
(71, '2025_09_13_071158_create_user_sessions_table', 14),
(72, '2025_09_14_083116_create_live_classes_table', 15),
(73, '2025_09_14_085745_add_course_name_to_live_classes_table', 16),
(74, '2025_09_14_090045_make_course_id_nullable_in_live_classes_table', 17),
(75, '2025_09_14_104100_add_live_lesson_fields_to_lessons_table', 18);

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

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `instructor_id`, `title`, `slug`, `status`, `publish_at`, `reorder`, `created_at`, `updated_at`) VALUES
(39, 36, 29, 'পরিচিতি এবং সেটআপ', 'priciti-ebng-setap-36-0', 'published', NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(40, 36, 29, 'মৌলিক বিষয়সমূহ', 'moulik-bishzsmuuh-36-1', 'published', NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(41, 36, 29, 'অ্যাডভান্স টপিকস', 'ozadvans-tpiks-36-2', 'published', NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(42, 36, 29, 'প্রজেক্ট এবং অনুশীলন', 'prjekt-ebng-onuseeln-36-3', 'published', NULL, 4, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(43, 37, 30, 'পরিচিতি এবং সেটআপ', 'priciti-ebng-setap-37-0', 'published', NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(44, 37, 30, 'মৌলিক বিষয়সমূহ', 'moulik-bishzsmuuh-37-1', 'published', NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(45, 37, 30, 'অ্যাডভান্স টপিকস', 'ozadvans-tpiks-37-2', 'published', NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(46, 37, 30, 'প্রজেক্ট এবং অনুশীলন', 'prjekt-ebng-onuseeln-37-3', 'published', NULL, 4, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(47, 38, 29, 'পরিচিতি এবং সেটআপ', 'priciti-ebng-setap-38-0', 'published', NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(48, 38, 29, 'মৌলিক বিষয়সমূহ', 'moulik-bishzsmuuh-38-1', 'published', NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(49, 38, 29, 'অ্যাডভান্স টপিকস', 'ozadvans-tpiks-38-2', 'published', NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(50, 38, 29, 'প্রজেক্ট এবং অনুশীলন', 'prjekt-ebng-onuseeln-38-3', 'published', NULL, 4, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(51, 39, 30, 'পরিচিতি এবং সেটআপ', 'priciti-ebng-setap-39-0', 'published', NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(52, 39, 30, 'মৌলিক বিষয়সমূহ', 'moulik-bishzsmuuh-39-1', 'published', NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(53, 39, 30, 'অ্যাডভান্স টপিকস', 'ozadvans-tpiks-39-2', 'published', NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(54, 39, 30, 'প্রজেক্ট এবং অনুশীলন', 'prjekt-ebng-onuseeln-39-3', 'published', NULL, 4, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(55, 40, 29, 'পরিচিতি এবং সেটআপ', 'priciti-ebng-setap-40-0', 'published', NULL, 1, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(56, 40, 29, 'মৌলিক বিষয়সমূহ', 'moulik-bishzsmuuh-40-1', 'published', NULL, 2, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(57, 40, 29, 'অ্যাডভান্স টপিকস', 'ozadvans-tpiks-40-2', 'published', NULL, 3, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(58, 40, 29, 'প্রজেক্ট এবং অনুশীলন', 'prjekt-ebng-onuseeln-40-3', 'published', NULL, 4, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(59, 41, 23, 'Peter Mcdonald', 'peter-mcdonald', 'published', '2025-06-04 07:32:00', 0, '2025-08-19 04:48:27', '2025-08-19 04:48:27'),
(60, 41, 23, 'Ashton Ferguson', 'ashton-ferguson', 'published', '2025-01-24 17:46:00', 0, '2025-08-19 04:48:37', '2025-08-19 04:48:37'),
(61, 41, 23, 'Tamekah Beasley', 'tamekah-beasley', 'published', NULL, 0, '2025-08-19 04:48:53', '2025-08-19 04:48:53'),
(62, 42, 23, 'এআই ইমেজ জেনারেশন ও প্রম্পটিং', 'eai-imej-jenaresn-oo-prmpting', 'published', NULL, 0, '2025-08-19 23:04:00', '2025-08-19 23:04:00'),
(63, 42, 23, 'এআই ভিডিও জেনারেশন', 'eai-vidioo-jenaresn', 'published', NULL, 0, '2025-08-19 23:04:08', '2025-08-19 23:04:08'),
(64, 42, 23, 'এআই সঙ্গীত, জিঙ্গল, ভয়েসওভার ও সাউন্ড এফেক্টস', 'eai-sngoeet-jingol-vzesoovar-oo-saund-efekts', 'published', NULL, 0, '2025-08-19 23:04:17', '2025-08-19 23:04:17'),
(65, 43, 23, 'Module 1', 'module-1', 'published', '1999-12-18 04:47:00', 0, '2025-08-21 02:29:03', '2025-08-26 04:11:47'),
(66, 43, 23, 'Britanney Taylor', 'britanney-taylor', 'draft', '1971-08-18 22:42:00', 0, '2025-08-26 06:25:49', '2025-08-26 06:25:49'),
(70, 50, 23, 'Donna Fuller', 'donna-fuller-2', 'draft', NULL, 0, '2025-09-14 00:49:53', '2025-09-14 00:50:27'),
(71, 71, 23, 'Avram Griffith', 'avram-griffith', 'draft', NULL, 0, '2025-09-14 09:00:54', '2025-09-14 09:24:00'),
(72, 51, 23, 'মডিউলের নাম', 'mdiuler-nam', 'draft', NULL, 0, '2025-09-14 09:30:17', '2025-09-14 09:30:17'),
(73, 51, 23, 'Live module already finished', 'live-module-already-finished', 'draft', NULL, 0, '2025-09-14 20:22:48', '2025-09-14 20:22:48');

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

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `instructor_id`, `course_id`, `user_id`, `type`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 23, 42, 31, 'instructor', 'review', 'seen', '2025-08-22 06:19:38', '2025-08-27 00:10:45'),
(2, 23, 42, 32, 'instructor', 'review', 'seen', '2025-08-23 02:30:15', '2025-09-09 03:10:13'),
(3, 23, 42, 31, 'instructor', 'review', 'seen', '2025-09-02 22:33:20', '2025-09-09 02:50:43');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2kLO0jKg6Th5pQaXWrSqzAqMOyDspsuePGEaSRqK', 23, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoialJxQnU5c0dqWUFESU9GYXBJVG5Ed1dPM2tLcURhMXpVeG1mVUhDZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9pbnN0cnVjdG9yL2NvdXJzZXMvY3JlYXRlLzUyL29iamVjdGl2ZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQwOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvaW5zdHJ1Y3Rvci9jb3Vyc2VzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjM7czo5OiJjb3Vyc2VfaWQiO2k6NTI7fQ==', 1757927172),
('ASL1RkaCoXpKOH9kpJ2DlprwIfNidGLQO5vbzKTN', 23, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWmZoZExnaHRJQVZaRU5OaTJmSmJRRTdaa1g4UG4xS0I2VGtRQlBNciI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2MToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2luc3RydWN0b3IvY291cnNlcy9jcmVhdGUvNTIvb2JqZWN0aXZlcyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvaW5zdHJ1Y3Rvci9jb3Vyc2VzL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIzO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1757998134),
('VAc5q64PEuKyaD8myTC0P0VwNqxW81dOsDJCThEu', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibnIwQnY0ZDNrOUVoZWtZRm1FZ3ZsQXN4YjVrWXRTQzN4UDk4Rm4zTiI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb3Vyc2VzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1758363107);

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_role`, `company_name`, `short_bio`, `phone`, `avatar`, `cover_photo`, `social_links`, `description`, `recivingMessage`, `email_verified_at`, `password`, `vimeo_data`, `stripe_secret_key`, `bkash_number`, `nogod_number`, `rocket_number`, `stripe_public_key`, `session_id`, `status`, `last_activity_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mr Admin', 'admin1@yopmail.com', 'admin', 'Eichmann LLC', 'Laudantium cupiditate et praesentium rerum.', '+1-978-486-5557', 'assets/images/avatar.png', NULL, NULL, 'Sequi eos atque repudiandae ut. Reiciendis reiciendis ullam non laudantium velit exercitationem laudantium. Corporis molestiae quas omnis iste.', '1', '2025-08-11 00:36:52', '$2y$12$weBg2Ew4XOsO/GXhFuVdcOt.KrtlJ0bmRvqMvqywZ258XQAanNjwi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2024-09-22 06:31:30', '2025-08-11 00:36:52'),
(2, 'Adella Bartoletti', 'instructor1@yopmail.com', 'instructor', 'Dicki and Sons', 'Voluptatem blanditiis impedit mollitia atque quia id.', '(408) 724-9630', 'uploads/users/5.jpeg', NULL, NULL, 'Molestiae modi vel quis et repellendus. Enim enim qui qui autem debitis consequatur ut.', '1', '2025-08-11 00:36:52', '$2y$12$3/8JSHui/uYKM0OqsGaEX.GE5SE8MIO4yTTSfUEPTcC0xEFQi7aum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-03-01 13:31:16', '2025-08-11 00:36:52'),
(3, 'Mrs. Berneice Heller', 'instructor2@yopmail.com', 'instructor', 'Yundt, Mertz and Hackett', 'Error velit a repellendus voluptas.', '1-551-642-6768', 'uploads/users/14.jpeg', NULL, NULL, 'A voluptas libero non sunt vel repudiandae beatae. Ab placeat reiciendis modi qui consectetur. Magni vero ratione sint esse quidem labore molestiae fugit.', '1', '2025-08-11 00:36:52', '$2y$12$jXoexXIqUFBvWRoJTIegT.8f9dIYgLdRQ2R8oNfbtg59adcxdV.cy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-02-19 16:43:18', '2025-08-11 00:36:52'),
(4, 'Mr. Blair Keeling', 'instructor3@yopmail.com', 'instructor', 'Sipes-Runolfsdottir', 'Quo consequatur soluta et nihil repudiandae cumque voluptatibus.', '1-325-247-5037', 'uploads/users/10.jpeg', NULL, NULL, 'Sed est provident ipsa dolorem dolores. Deserunt sint possimus nam odio non eveniet ducimus blanditiis. Ipsa excepturi cupiditate et. Quibusdam tenetur vel non officiis quod quisquam et. Possimus qui omnis exercitationem ipsam eos architecto et.', '1', '2025-08-11 00:36:52', '$2y$12$J18NNyO3yBzr3DQTaM73KOeOg9MI1q4sQJWNDlNs2lTdUnvfK9NGi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-04-21 10:25:09', '2025-08-11 00:36:53'),
(5, 'Jonas Toy', 'instructor4@yopmail.com', 'instructor', 'Mosciski Inc', 'Deleniti corporis temporibus quia eum et aut vel.', '(678) 797-2546', 'uploads/users/17.jpeg', NULL, NULL, 'Illo itaque reprehenderit nostrum ut sunt. Magni ad quis aut labore hic quas. Expedita repellendus non quia earum. Enim incidunt molestiae nemo saepe dolorum.', '1', '2025-08-11 00:36:53', '$2y$12$CBKNTe/Fg9t/uzQP.wP5H.Jm0/UkJ7dKzto1GfF1T9J7oA3nZddda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-05-20 01:02:03', '2025-08-11 00:36:53'),
(6, 'Maureen Medhurst', 'instructor5@yopmail.com', 'instructor', 'Hyatt-Farrell', 'Qui ipsam nulla nulla.', '341.817.6585', 'uploads/users/1.jpeg', NULL, NULL, 'Occaecati maiores sapiente enim saepe iusto magni assumenda. Et similique omnis omnis necessitatibus reiciendis.', '1', '2025-08-11 00:36:53', '$2y$12$K2OHnloIq5JpqsC4ZodOOOM1pJxh7drY4CYy0SRcsV3pcbT0PNw3i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2024-10-23 21:23:58', '2025-08-11 00:36:53'),
(7, 'Sally Jacobs', 'student1@yopmail.com', 'student', 'Graham Ltd', 'Repellendus magnam inventore est est enim.', '+1.352.804.0377', 'uploads/users/11.jpeg', NULL, 'https://facebook.com/sporer.favian,https://twitter.com/danyka40,https://instagram.com/madelynn76', 'Recusandae esse voluptatum qui itaque velit sit odio illum. Est reprehenderit laudantium nisi cum tenetur perspiciatis. Voluptatum et autem voluptatem eius quia minus porro.', '1', '2025-08-11 00:36:53', '$2y$12$fmLoJgd6BbvzG.wZj2RvZ.wM7RRLOspeH9aVRMEbz0lXFASN2tgD6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-05-24 14:59:49', '2025-08-29 06:05:29'),
(8, 'Ebba Robel', 'student2@yopmail.com', 'student', 'Beahan and Sons', 'Soluta corrupti voluptatem accusantium cum delectus.', '+1-551-454-9822', 'uploads/users/8.jpeg', NULL, 'https://facebook.com/reinger.dale,https://twitter.com/aufderhar.faye,https://instagram.com/emile.herman', 'Porro voluptas soluta sed officia tenetur. Molestias occaecati expedita veniam unde vel. Dolores dicta rerum reiciendis qui numquam perspiciatis. Ut quo quia molestiae ut enim.', '1', '2025-08-11 00:36:53', '$2y$12$IGiJk4YKJIE46yE7L5.Nf.eG9qpFIcF3V90IifbrebOhfs8.rSHBS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-01-02 04:29:34', '2025-08-11 00:36:54'),
(9, 'Aliya Ryan', 'student3@yopmail.com', 'student', 'Gerhold-Wiza', 'Consequatur omnis quod architecto nihil ipsum ipsa eos.', '626-602-3587', 'uploads/users/15.jpeg', NULL, 'https://facebook.com/pfeffer.zion,https://twitter.com/aurelie03,https://instagram.com/emard.minnie', 'Numquam est similique sed. Voluptatem ut odio consectetur dignissimos qui aperiam harum. Fugiat consequatur ut eius expedita doloremque et quis ipsum. Minima nobis omnis et autem enim quis nulla.', '1', '2025-08-11 00:36:54', '$2y$12$JSjxpH7ADmqQYJQX8XeqBers9y8NlT0Dogwwpo9i0ha/w3SHsU8T6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2024-10-12 16:50:17', '2025-08-11 00:36:54'),
(10, 'Fannie Heller Sr.', 'student4@yopmail.com', 'student', 'Hodkiewicz-Roberts', 'Nostrum aspernatur cumque consequatur qui.', '+1.214.236.6389', 'uploads/users/19.jpeg', NULL, 'https://facebook.com/francesco.bradtke,https://twitter.com/america.jacobs,https://instagram.com/leland.schulist', 'Sint error temporibus laudantium impedit velit et necessitatibus. Sunt exercitationem atque optio blanditiis cumque. At quia aut similique velit aut atque. Quod facilis voluptatum placeat officia aut est.', '1', '2025-08-11 00:36:54', '$2y$12$xJwU6OmM69XRHk69M9ScBehTgtsp9MQXJZdGYRI3yXkZfetn0LtGy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2024-10-04 02:06:28', '2025-08-11 00:36:54'),
(11, 'Valentin Sauer', 'student5@yopmail.com', 'student', 'Howell PLC', 'Totam quaerat rem aliquam enim voluptatibus ipsa aspernatur.', '+13365805719', 'uploads/users/10.jpeg', NULL, 'https://facebook.com/estelle.ullrich,https://twitter.com/minnie95,https://instagram.com/nova22', 'Et atque ut vero nam. Voluptas magni corrupti eligendi. Eum nemo vero voluptatem et eligendi dolorum necessitatibus. Repudiandae quas voluptatem voluptate accusantium.', '1', '2025-08-11 00:36:54', '$2y$12$cEjUWoNbvcqgZ0R.SWRwmu2NArejc1pdwwWtEGzXlMUJt2uQYQDje', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-06-18 09:03:45', '2025-08-11 00:36:54'),
(12, 'Antonina Quitzon', 'student6@yopmail.com', 'student', 'Legros, Nader and Weimann', 'Nisi labore aliquid sunt soluta odit nulla at.', '+1.630.867.3586', 'uploads/users/17.jpeg', NULL, 'https://facebook.com/cristina92,https://twitter.com/electa.huels,https://instagram.com/beahan.anna', 'Quia a velit eos aut. Pariatur ut ipsum rerum veniam quas nobis itaque. Sed sit reiciendis corrupti excepturi doloremque aut ut.', '1', '2025-08-11 00:36:54', '$2y$12$RlH4yQrQxg2arepkHSfVkOSct1liFLvMxFwbLXxJVr78jawTdq73K', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2024-11-22 08:47:01', '2025-08-11 00:36:54'),
(13, 'Johnathan Feil', 'student7@yopmail.com', 'student', 'Kiehn-O\'Conner', 'Doloremque quia autem natus iure.', '+1-337-462-1783', 'uploads/users/1.jpeg', NULL, 'https://facebook.com/else03,https://twitter.com/adaline84,https://instagram.com/leuschke.tad', 'Pariatur neque voluptatem voluptatem illo. Ipsa iste occaecati assumenda dolor. Quis animi distinctio beatae. Et voluptatem maxime dolore suscipit vel temporibus.', '1', '2025-08-11 00:36:54', '$2y$12$hSrX62yZUjL1LM0fy7AFaeclOQsCDK.0iqXzYCkVZHWzbURzDVFLK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-03-29 10:18:30', '2025-08-11 00:36:55'),
(14, 'Torrey Veum', 'student8@yopmail.com', 'student', 'Auer-Corkery', 'Aspernatur quae velit nisi possimus quibusdam maiores.', '1-425-779-8889', 'uploads/users/6.jpeg', NULL, 'https://facebook.com/norwood.hagenes,https://twitter.com/gideon.lowe,https://instagram.com/kamille.gleichner', 'Quo delectus necessitatibus excepturi dolores qui quia recusandae. Voluptatem et culpa nihil provident. Et doloremque harum consectetur omnis magni voluptatem. Aliquid aspernatur quam fugiat incidunt reiciendis.', '1', '2025-08-11 00:36:55', '$2y$12$SEWfzDzMHRbj.Jie4t9lM.9leWNNWRIb0Wroyl4oCd9Mqi/wE1ndi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2024-10-29 08:25:32', '2025-08-11 00:36:55'),
(15, 'Anabel Rempel MD', 'student9@yopmail.com', 'student', 'Wolff-Wilkinson', 'Quis nam hic amet voluptate.', '734.568.5013', 'uploads/users/11.jpeg', NULL, 'https://facebook.com/kaia64,https://twitter.com/xmoore,https://instagram.com/kaylin.pacocha', 'Ad dolores dignissimos provident eum harum fuga. Recusandae iure error sapiente architecto ut. Possimus qui hic dolorem ipsum omnis. Nobis atque id ducimus ut.', '1', '2025-08-11 00:36:55', '$2y$12$4JDJmSmt/zwbSBvimyY4n.5MXcjM4PiA/Dm2x3.gr4uJtPc24EjHC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-06-23 07:54:12', '2025-08-11 00:36:55'),
(16, 'Prof. Jeffery O\'Connell I', 'student10@yopmail.com', 'student', 'Dietrich-Jones', 'Tempora cupiditate sit totam vel.', '(620) 352-2940', 'uploads/users/19.jpeg', NULL, 'https://facebook.com/arianna37,https://twitter.com/trevion.gerhold,https://instagram.com/medhurst.lewis', 'Fugit amet iste ducimus sint non eum a. Omnis eveniet consectetur provident qui. Iure quas aliquid consequatur similique ut.', '1', '2025-08-11 00:36:55', '$2y$12$rYir0pUd0xFezTrOt/Len.zrJj.nAbzlBfcOSNCKtRFcFAsE0DPYW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-01-05 11:37:13', '2025-08-11 00:36:55'),
(17, 'Uriah Abbott', 'uriah.abbott@yopmail.com', 'instructor', 'Larson and Bell Associates', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '$2y$12$EpYY2.UBGAXmErMBwo0Mf.wrkzR0qYcTRspFmUFSqfN40GheBzLsO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-11 00:47:22', '2025-08-11 00:47:22'),
(18, 'Desiree Conley', 'desiree.conley@yopmail.com', 'instructor', 'Guthrie and Fernandez LLC', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '$2y$12$GQ6FNPEYaCXrMN.lvbQ/Ze/oGUhSpC2jvkMvPguVpFvuyB0rNWyGS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-11 01:04:19', '2025-08-11 01:04:19'),
(19, 'Richard Savage', 'richard.savage@yopmail.com', 'instructor', 'Caldwell Burton Plc', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '$2y$12$W6eMCQJ3VrU2Q22TKN87yOmnlPlxbVmrfNHvPgSKf7fmSYIDiZ19q', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-11 01:10:15', '2025-08-11 01:10:15'),
(20, 'Winter Bradshaw', 'winter.bradshaw@yopmail.com', 'instructor', 'Russell Hardy Traders', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '$2y$12$/tTzMSwyqDJa2nOJnnBgve6KT29cksQOjp2ufffNieqNeVG5Hc.hC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-11 01:13:48', '2025-08-11 01:13:48'),
(21, 'Stacy Clements', 'stacy.clements@yopmail.com', 'instructor', 'Nolan Woodard LLC', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '$2y$12$CFg5H.iwuEm7G4eSmqFjPOdRRnDp7Uahnsg9ThD7iH84Sl01eDJ1C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-11 01:16:25', '2025-08-11 01:16:25'),
(22, 'Blythe Robinson', 'blythe.robinson@yopmail.com', 'instructor', 'Cleveland and Juarez Associates', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '$2y$12$U2T/FeppcAU9ZBkzXf6ZfeRTq5MD49XDmznwZzY76R3EyK.tDnlyW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-11 01:17:45', '2025-08-11 01:17:45'),
(23, 'Zenia Griffith', 'jacob@yopmail.com', 'instructor', 'Bryan Haynes Traders', NULL, '754536869214', 'uploads/users/zenia-griffith-68b6d94e0e1ae.png', 'uploads/users/-cover-68be8ca6a6b16.png', '', 'Nihil sed ut sed eu', '1', '2025-08-11 10:03:39', '$2y$12$Cvr.UMuCo02uDf40juztDuvST8yzsos6vLABl2tM./p2JpQF5nEhe', NULL, NULL, '01728247397', '01728247398', '017282473982', NULL, NULL, 'active', NULL, 'VZWuezBEbC24JGNmc2sRGcnt7ctEAkEurZolXozi8pPrC8aDX8KOjaEXSSeH', '2025-08-11 03:18:58', '2025-09-15 22:48:50'),
(24, 'রহিম উদ্দিন', 'rahim@example.com', 'student', NULL, 'প্রযুক্তিপ্রেমী শিক্ষার্থী', '01712345678', NULL, NULL, NULL, 'একজন উৎসাহী শিক্ষার্থী যিনি প্রযুক্তি শিখতে আগ্রহী।', '0', '2025-08-19 04:13:39', '$2y$12$SpRnS3K4IQvPZwn4HlYjdOd.nkQP0V.xVwwUpmzjTEzyzSp3zi/CO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-19 04:13:39', '2025-08-19 04:13:39'),
(25, 'ফাতেমা খাতুন', 'fatema@example.com', 'student', NULL, 'ওয়েব ডিজাইনার', '01798765432', NULL, NULL, NULL, 'ওয়েব ডিজাইনে আগ্রহী একজন মেধাবী ছাত্রী।', '0', '2025-08-19 04:13:40', '$2y$12$9gCjlHs7ygyUDo.Ax7VJMu27Snff3UgdGYdfpjYixBbSok9E7Y3ca', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-19 04:13:40', '2025-08-19 04:13:40'),
(26, 'করিম আহমেদ', 'karim@example.com', 'student', NULL, 'ডিজিটাল মার্কেটার', '01856789012', NULL, NULL, NULL, 'ডিজিটাল মার্কেটিং শিখতে আগ্রহী একজন উদ্যোক্তা।', '0', '2025-08-19 04:13:40', '$2y$12$xfeD8RZsKIe1SHjT.suTwuQ8i60FpwgU2T0wS3/4rSTkvJ0wgxN.u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-19 04:13:40', '2025-08-19 04:13:40'),
(27, 'সালমা বেগম', 'salma@example.com', 'student', NULL, 'প্রোগ্রামিং শিক্ষার্থী', '01634567890', NULL, NULL, NULL, 'প্রোগ্রামিং শিখতে আগ্রহী একজন কলেজ ছাত্রী।', '0', '2025-08-19 04:13:40', '$2y$12$2B00FGHQmZYuClnudEhlb.W/AxjMkEDyAKrN5j.O1Z.oh8HsEv1by', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-19 04:13:40', '2025-08-19 04:13:40'),
(28, 'নাসির হোসেন', 'nasir@example.com', 'student', NULL, 'গ্রাফিক ডিজাইনার', '01723456789', NULL, NULL, NULL, 'গ্রাফিক ডিজাইনে দক্ষতা অর্জনের জন্য অধ্যয়নরত।', '0', '2025-08-19 04:13:40', '$2y$12$EUMU5RKlL4NSdB.IE7OeJug3jYWvVjDbcln9EoEdk2MzkrqsLAHaC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-19 04:13:40', '2025-08-19 04:13:40'),
(29, 'ড. আব্দুল করিম', 'instructor1@example.com', 'instructor', 'টেক একাডেমি বাংলাদেশ', 'সিনিয়র সফটওয়্যার ইঞ্জিনিয়ার ও প্রশিক্ষক', '01987654321', NULL, NULL, NULL, 'কম্পিউটার সায়েন্সে পিএইচডি। ১৫ বছরের শিক্ষকতার অভিজ্ঞতা রয়েছে। ওয়েব ডেভেলপমেন্ট এবং প্রোগ্রামিং ভাষায় বিশেষজ্ঞ।', '0', '2025-08-19 04:13:41', '$2y$12$Uq8GcXImwpoxjiauwynZCeHCghaFziOmrEETXIjouwTfgycuTkP6i', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(30, 'সাবিনা আক্তার', 'instructor2@example.com', 'instructor', 'ক্রিয়েটিভ সলিউশন', 'UI/UX ডিজাইনার ও ডিজিটাল মার্কেটিং এক্সপার্ট', '01845678901', NULL, NULL, NULL, 'ডিজিটাল মার্কেটিং এবং UI/UX ডিজাইনে বিশেষজ্ঞ। ১০ বছরের ইন্ডাস্ট্রি এক্সপেরিয়েন্স এবং ৫ বছরের শিক্ষকতার অভিজ্ঞতা।', '0', '2025-08-19 04:13:41', '$2y$12$fSvb8/zHQpkG1kFXVX0OqO1RpEWlZVQ7XadyHwCHSjoWPsqa54KrS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-19 04:13:41', '2025-08-19 04:13:41'),
(31, 'Reese Kirk', 'kir@yopmail.com', 'student', 'Merritt and Wilkerson Inc', 'https://www.youtube.com', '234567890', 'uploads/users/reese-kirk-68c63a61ce402.webp', 'uploads/users/reese-kirk-68beae2693ced.png', 'https://www.youtube.com/watch?v=vPJIMdMrgiE&t=367s,https://www.youtube.com/watch?v=vPJIMdMrgiE&t=367s', 'https://www.yo utube.com/watch ?v=vPJIMdMrgiE&t =367shttps://w ww.youtube. com/watch?v=vPJIMdMrgiE  &t=367shttps://www.yo utub e.com/watc h?v=vPJIMdMrgi E&t=367shtt ps://www.youtu be.com/watch?v=vPJIM  dMrgiE&t=367shtt ps://www.youtub e.com/watch?v=vPJIMdMrgiE&t= 367shttps://www.yo utube.com/watch?v=vPJIMd MrgiE&t=367s', '0', '2025-08-21 07:38:04', '$2y$12$lrN5z8jDrm.tP387ehPt..BJ1MpykAU.7WFO0zZB0ry0tCF49Px7S', NULL, NULL, NULL, NULL, NULL, NULL, '4ZFYs0A8hIhkDkPUupCkBEsKGtHFN1089aS2HIRs', 'active', NULL, NULL, '2025-08-21 07:38:04', '2025-09-14 20:09:05'),
(32, 'Candice Moon', 'moon@yopmail.com', 'student', 'Britt and Barrera Inc', NULL, NULL, NULL, NULL, NULL, NULL, '0', '2025-08-23 02:27:36', '$2y$12$/WbQIa8SybZHZrlEN8HNEebZG0pAl9471Zy8oU8bl4XzVyj6VrCbm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-23 02:27:37', '2025-08-23 02:27:37'),
(33, 'Ulysses David', 'david@yopmail.com', 'student', 'Mccoy Burris Inc', NULL, NULL, NULL, NULL, NULL, NULL, '0', '2025-08-29 06:06:02', '$2y$12$H3rPz3cGwa7S0Uv6A9GoteXpK0gx9ohuGofxQphLIeiRaHs1p.i3y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2025-08-29 06:06:02', '2025-08-29 06:59:20');

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

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `session_id`, `device_name`, `device_type`, `browser`, `os`, `ip_address`, `country`, `city`, `latitude`, `longitude`, `user_agent`, `last_activity`, `is_current`, `created_at`, `updated_at`) VALUES
(1, 23, 'd8YbDPMeUbecgUiNmRo9hTPsM0TXWN3dHCjmgajn', 'Desktop Computer', 'desktop', 'Google Chrome', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-16 04:48:54', 0, '2025-09-13 01:16:44', '2025-09-15 22:48:54'),
(3, 31, 'ebFZzIXFDjLssUkQM5jvyrxGNN8FBZAgtZLxCrLC', 'Desktop Computer', 'desktop', 'Safari', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.6 Safari/605.1.15', '2025-09-15 04:18:51', 0, '2025-09-13 01:18:25', '2025-09-14 22:18:51'),
(4, 31, 'TeMPVFbrF6MLP8v1xYZVtROfHKNBYb23S1G46KAd', 'Desktop Computer', 'desktop', 'Google Chrome', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-14 22:18:51', 1, '2025-09-13 01:18:55', '2025-09-14 22:18:51'),
(5, 31, 'SaWk6tOD4Qm1ya7lqxHdidGgy16MkG8t4W78Gb27', 'Desktop Computer', 'desktop', 'Google Chrome', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-15 04:18:51', 0, '2025-09-13 03:42:03', '2025-09-14 22:18:51'),
(6, 31, '2oxsdEEPyHvgv2vIZttVS5cLlvAOMkk5ZjRZe9XQ', 'Desktop Computer', 'desktop', 'Google Chrome', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-15 04:18:51', 0, '2025-09-13 03:46:36', '2025-09-14 22:18:51'),
(7, 31, 'Tr13Dudh8JUMsGaYtggEGhDZkRjzMf1wjVeJXgOU', 'Desktop Computer', 'desktop', 'Google Chrome', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-15 04:18:51', 0, '2025-09-13 05:58:07', '2025-09-14 22:18:51'),
(8, 31, '51PFF6AvuXfD3joFyV39ticT2q3GhcYczQr4DluQ', 'Desktop Computer', 'desktop', 'Google Chrome', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '2025-09-15 04:18:51', 0, '2025-09-13 21:26:43', '2025-09-14 22:18:51'),
(9, 23, 'ASL1RkaCoXpKOH9kpJ2DlprwIfNidGLQO5vbzKTN', 'Desktop Computer', 'desktop', 'Google Chrome', 'macOS', '127.0.0.1', 'Bangladesh', 'Dhaka', '23.81030000', '90.41250000', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-15 22:48:54', 1, '2025-09-15 01:58:42', '2025-09-15 22:48:54');

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
-- Dumping data for table `vimeo_data`
--

INSERT INTO `vimeo_data` (`id`, `client_id`, `client_secret`, `access_key`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '9b9327a8ad7087c1026d89a0e44dc86dee9fa385', 'VuARaezQdBxBpxeFs4esXAvX8EEZ/FzTcAxVnxsUzb92QY8UVJNhXFpZaFcxwAntc6BrkcKTrXhQsLZpCouhvWQWTf3JQT2DW6FWtd8RvSTTwUj/GtixFoczkr4N81j7', '4324498bedca1cbf865b359196f066a0', 6, NULL, NULL),
(2, '9b9327a8ad7087c1026d89a0e44dc86dee9fa385', 'VuARaezQdBxBpxeFs4esXAvX8EEZ/FzTcAxVnxsUzb92QY8UVJNhXFpZaFcxwAntc6BrkcKTrXhQsLZpCouhvWQWTf3JQT2DW6FWtd8RvSTTwUj/GtixFoczkr4N81j7', '4324498bedca1cbf865b359196f066a0', 3, NULL, NULL),
(3, '9b9327a8ad7087c1026d89a0e44dc86dee9fa385', 'VuARaezQdBxBpxeFs4esXAvX8EEZ/FzTcAxVnxsUzb92QY8UVJNhXFpZaFcxwAntc6BrkcKTrXhQsLZpCouhvWQWTf3JQT2DW6FWtd8RvSTTwUj/GtixFoczkr4N81j7', '4324498bedca1cbf865b359196f066a0', 5, NULL, NULL),
(6, '9b9327a8ad7087c1026d89a0e44dc86dee9fa385', 'VuARaezQdBxBpxeFs4esXAvX8EEZ/FzTcAxVnxsUzb92QY8UVJNhXFpZaFcxwAntc6BrkcKTrXhQsLZpCouhvWQWTf3JQT2DW6FWtd8RvSTTwUj/GtixFoczkr4N81j7', '4324498bedca1cbf865b359196f066a0', 4, NULL, NULL);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `course_activities`
--
ALTER TABLE `course_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `course_likes`
--
ALTER TABLE `course_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_logs`
--
ALTER TABLE `course_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `course_reviews`
--
ALTER TABLE `course_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `d_n_s_settings`
--
ALTER TABLE `d_n_s_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `live_classes`
--
ALTER TABLE `live_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `manage_pages`
--
ALTER TABLE `manage_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vimeo_data`
--
ALTER TABLE `vimeo_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
