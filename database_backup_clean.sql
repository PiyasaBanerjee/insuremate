-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: insurance_management
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Super Admin','admin@insurance.com','$2y$12$m7bV5uRBfhNWdNA3f9Nq1e7iwvZN2fb.CxrwQXYjZ/XtD.AVxcV4K','mhexRlp4U9kS4UkSeTqcFpLcm6xw36tKEpVHvuEklNds7h8CLMpe5fDtzbYj','2026-02-12 08:21:31','2026-02-12 09:04:29');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chat_session_id` bigint(20) unsigned NOT NULL,
  `sender` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_chat_session_id_foreign` (`chat_session_id`),
  CONSTRAINT `chat_messages_chat_session_id_foreign` FOREIGN KEY (`chat_session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES (1,1,'user','hello','2026-02-25 11:59:57','2026-02-25 11:59:57'),(2,1,'ai','Hello Riya Seth! I am the InsureMate Assistant. How can I help you regarding your insurance coverage today?','2026-02-25 11:59:58','2026-02-25 11:59:58'),(3,1,'user','what are my policies','2026-02-25 12:00:15','2026-02-25 12:00:15'),(4,1,'ai','I\'m not exactly sure how to answer that right now, but our live human agents are available if you\'d like to open a support ticket. Can I assist you with claims or policies instead?','2026-02-25 12:00:16','2026-02-25 12:00:16'),(5,1,'user','yes','2026-02-25 12:00:25','2026-02-25 12:00:25'),(6,1,'ai','I\'m not exactly sure how to answer that right now, but our live human agents are available if you\'d like to open a support ticket. Can I assist you with claims or policies instead?','2026-02-25 12:00:26','2026-02-25 12:00:26'),(7,1,'user','hello','2026-02-25 12:10:10','2026-02-25 12:10:10'),(8,1,'ai','I\'m experiencing a temporary issue analyzing your request. Please try again in a moment.','2026-02-25 12:10:12','2026-02-25 12:10:12'),(9,1,'user','hello','2026-02-25 12:17:31','2026-02-25 12:17:31'),(10,1,'ai','Hello Riya Seth! I am the InsureMate Assistant. How can I help you regarding your insurance coverage today?','2026-02-25 12:17:33','2026-02-25 12:17:33'),(11,1,'user','what are my policies','2026-02-25 12:17:41','2026-02-25 12:17:41'),(12,1,'ai','Riya Seth, I can certainly help you with that!\n\nBased on our records, you currently have the following policies with InsureMate:\n\n1.  **Auto Insurance Policy:** Policy Number: IM-AUTO-2023-54321, effective from January 1, 2023.\n2.  **Homeowner\'s Insurance Policy:** Policy Number: IM-HOME-2022-98765, effective from July 15, 2022.\n\nWould you like more details on any of these policies, or is there anything else I can assist you with today?','2026-02-25 12:17:44','2026-02-25 12:17:44'),(13,1,'user','i am a 23 yr old mca student which plocies are best for me','2026-02-25 12:18:28','2026-02-25 12:18:28'),(14,1,'ai','That\'s a great question, Riya Seth! As an MCA student at 23, focusing on your future protection is very smart.\n\nWhile I can\'t provide specific financial advice or recommend exact policies without a full understanding of your individual circumstances, some common policies that younger adults and students often consider include:\n\n1.  **Health Insurance:** Essential for covering medical expenses.\n2.  **Renter\'s Insurance:** If you live in a rented apartment or dorm, this protects your personal belongings from theft or damage.\n3.  **Auto Insurance:** If','2026-02-25 12:18:32','2026-02-25 12:18:32'),(15,2,'user','Hello, what insurance do you offer?','2026-02-25 12:27:17','2026-02-25 12:27:17'),(16,2,'ai','Hello Test User! InsureMate offers a range of insurance products including **auto, home, and life insurance**.\n\nDo any of these categories particularly interest you, or would you like more details on a specific type?','2026-02-25 12:27:21','2026-02-25 12:27:21'),(17,1,'user','hello','2026-02-25 12:33:38','2026-02-25 12:33:38'),(18,1,'ai','Hello Riya Seth! I was in the middle of explaining common policies for someone in your situation.\n\nWould you like me to continue with the suggestions for policies, or is there something else I can help you with?','2026-02-25 12:33:41','2026-02-25 12:33:41');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_sessions`
--

DROP TABLE IF EXISTS `chat_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_sessions_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_sessions`
--

LOCK TABLES `chat_sessions` WRITE;
/*!40000 ALTER TABLE `chat_sessions` DISABLE KEYS */;
INSERT INTO `chat_sessions` VALUES (1,2,'active','2026-02-25 11:59:57','2026-02-25 11:59:57'),(2,4,'active','2026-02-25 12:27:17','2026-02-25 12:27:17');
/*!40000 ALTER TABLE `chat_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `claims`
--

DROP TABLE IF EXISTS `claims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `claims` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `policy_id` bigint(20) unsigned NOT NULL,
  `claim_number` varchar(255) NOT NULL,
  `claim_amount` decimal(15,2) NOT NULL,
  `description` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_remarks` text DEFAULT NULL,
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `claims_claim_number_unique` (`claim_number`),
  KEY `claims_user_id_foreign` (`user_id`),
  KEY `claims_policy_id_foreign` (`policy_id`),
  CONSTRAINT `claims_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `claims_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `claims`
--

LOCK TABLES `claims` WRITE;
/*!40000 ALTER TABLE `claims` DISABLE KEYS */;
/*!40000 ALTER TABLE `claims` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (1,'Ankit Ghosh','ankit2003ghosh@gmail.com','sds','sds','2026-02-25 10:15:38','2026-02-25 10:15:38'),(3,'prp','a@gmail.com','Expert Consultation Request','wdwsd','2026-02-25 10:15:49','2026-02-25 10:15:49');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance_categories`
--

DROP TABLE IF EXISTS `insurance_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insurance_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `benefits` longtext DEFAULT NULL,
  `premium_info` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `insurance_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance_categories`
--

LOCK TABLES `insurance_categories` WRITE;
/*!40000 ALTER TABLE `insurance_categories` DISABLE KEYS */;
INSERT INTO `insurance_categories` VALUES (1,'Life Insurance','life-insurance','Secure your family\'s future with our Life Insurance plans.',NULL,NULL,NULL,1,'2026-02-12 08:21:31','2026-02-12 08:21:31'),(2,'Health Insurance','health-insurance','Comprehensive health coverage for you and your loved ones.',NULL,NULL,NULL,1,'2026-02-12 08:21:31','2026-02-12 08:21:31'),(3,'Car Insurance','car-insurance','Protect your vehicle against damages and theft.',NULL,NULL,NULL,1,'2026-02-12 08:21:31','2026-02-12 08:21:31'),(4,'Term Life Insurance','term-life-insurance','Secure your family\'s future with our Term Life Insurance plans.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(5,'Investment Plans','investment-plans','Grow your wealth with our tailored investment plans.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(6,'Two Wheeler Insurance','two-wheeler-insurance','Comprehensive coverage for your bike or scooter.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(7,'Family Health Insurance','family-health-insurance','Health protection for your entire family under one plan.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(8,'Travel Insurance','travel-insurance','Travel the world worry-free with our travel insurance.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(10,'Employee Group Insurance','employee-group-insurance','Group health and life insurance for employees.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(11,'Home Insurance','home-insurance','Protect your home and belongings against risks.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(12,'Retirement Plans','retirement-plans','Plan for a secure and comfortable retirement.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16'),(13,'Guaranteed Return Plans','guaranteed-return-plans','Investments with guaranteed returns for peace of mind.',NULL,NULL,NULL,1,'2026-02-18 09:22:16','2026-02-18 09:22:16');
/*!40000 ALTER TABLE `insurance_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance_plans`
--

DROP TABLE IF EXISTS `insurance_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insurance_plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `base_premium` decimal(10,2) NOT NULL,
  `coverage_amount` decimal(15,2) NOT NULL,
  `duration_years` int(11) NOT NULL COMMENT 'Validity in years',
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`benefits`)),
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `insurance_plans_slug_unique` (`slug`),
  KEY `insurance_plans_category_id_foreign` (`category_id`),
  CONSTRAINT `insurance_plans_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `insurance_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance_plans`
--

LOCK TABLES `insurance_plans` WRITE;
/*!40000 ALTER TABLE `insurance_plans` DISABLE KEYS */;
INSERT INTO `insurance_plans` VALUES (2,1,'Smart Secure Life Plan','smart-secure-life-plan','Long-term financial protection with bonus benefits.',899.00,449500.00,1,'[\"High sum assured with loyalty bonus\",\"Suitable for: Working professionals aged 25-45\"]','[\"High sum assured with loyalty bonus\",\"Working professionals aged 25-45\"]','plans/7XXINijUIt9vYyn4AJ9zHd7X8dB6OvL1Gjy78MAn.png',1,'2026-02-25 00:17:51','2026-02-25 01:19:45'),(3,1,'Wealth Plus Endowment','wealth-plus-endowment','Combines savings and life cover for future milestones.',1200.00,600000.00,1,'[\"Guaranteed maturity benefits\",\"Suitable for: Families planning for children\'s education\"]','[{\"title\":\"Key Benefit\",\"description\":\"Guaranteed maturity benefits\"},{\"title\":\"Target Audience\",\"description\":\"Families planning for children\'s education\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(4,1,'Micro Bachat Protection','micro-bachat-protection','Affordable life cover designed for low-income brackets.',350.00,175000.00,1,'[\"Low premium with basic life cover\",\"Suitable for: Rural or low-income populations\"]','[{\"title\":\"Key Benefit\",\"description\":\"Low premium with basic life cover\"},{\"title\":\"Target Audience\",\"description\":\"Rural or low-income populations\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(5,1,'Golden Years Assure','golden-years-assure','Whole life policy offering coverage up to 99 years.',1500.00,750000.00,1,'[\"Lifelong coverage with premium waiver\",\"Suitable for: Middle-aged individuals planning a legacy\"]','[{\"title\":\"Key Benefit\",\"description\":\"Lifelong coverage with premium waiver\"},{\"title\":\"Target Audience\",\"description\":\"Middle-aged individuals planning a legacy\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(6,1,'Flexi Protect Life Plan','flexi-protect-life-plan','Customizable payout options with increasing life cover.',950.00,475000.00,1,'[\"Step-up sums assured to combat inflation\",\"Suitable for: Young earners expecting salary growth\"]','[{\"title\":\"Key Benefit\",\"description\":\"Step-up sums assured to combat inflation\"},{\"title\":\"Target Audience\",\"description\":\"Young earners expecting salary growth\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(7,2,'Arogya Sanjeevani Standard','arogya-sanjeevani-standard','Standardized health coverage for basic medical needs.',450.00,225000.00,1,'[\"Covers room rent, ICU, and day care\",\"Suitable for: General individuals & small families\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers room rent, ICU, and day care\"},{\"title\":\"Target Audience\",\"description\":\"General individuals & small families\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(8,2,'Optima Secure Health','optima-secure-health','Comprehensive coverage with automatic restore benefits.',850.00,425000.00,1,'[\"2X coverage from day one\",\"Suitable for: Professionals seeking high sum insured\"]','[{\"title\":\"Key Benefit\",\"description\":\"2X coverage from day one\"},{\"title\":\"Target Audience\",\"description\":\"Professionals seeking high sum insured\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(9,2,'Active Fit Health Plan','active-fit-health-plan','Rewards healthy lifestyle with premium discounts.',600.00,300000.00,1,'[\"Up to 30% discount for hitting fitness goals\",\"Suitable for: Young fitness enthusiasts aged 20-35\"]','[{\"title\":\"Key Benefit\",\"description\":\"Up to 30% discount for hitting fitness goals\"},{\"title\":\"Target Audience\",\"description\":\"Young fitness enthusiasts aged 20-35\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(10,2,'Senior Citizen Red Carpet','senior-citizen-red-carpet','Dedicated health plan for parents without pre-medical checks.',1800.00,900000.00,1,'[\"Covers pre-existing diseases from year 1\",\"Suitable for: Senior citizens above 60 years\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers pre-existing diseases from year 1\"},{\"title\":\"Target Audience\",\"description\":\"Senior citizens above 60 years\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(11,2,'Maternity Plus Shield','maternity-plus-shield','Health plan with robust maternity and newborn coverage.',1100.00,550000.00,1,'[\"Covers delivery and vaccination expenses\",\"Suitable for: Newlywed couples\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers delivery and vaccination expenses\"},{\"title\":\"Target Audience\",\"description\":\"Newlywed couples\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(12,3,'Bumper-to-Bumper Care','bumper-to-bumper-care','Zero depreciation cover for maximum claim settlement.',1200.00,600000.00,1,'[\"Covers plastic, glass, and fiber parts 100%\",\"Suitable for: New car owners\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers plastic, glass, and fiber parts 100%\"},{\"title\":\"Target Audience\",\"description\":\"New car owners\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(13,3,'Smart Drive Pay-As-You-Go','smart-drive-pay-as-you-go','Usage-based premium for low-mileage drivers.',500.00,250000.00,1,'[\"Premium calculated based on km driven\",\"Suitable for: Work-from-home professionals\"]','[{\"title\":\"Key Benefit\",\"description\":\"Premium calculated based on km driven\"},{\"title\":\"Target Audience\",\"description\":\"Work-from-home professionals\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(14,3,'Essential Third-Party Plus','essential-third-party-plus','Mandatory third-party cover with personal accident benefit.',300.00,150000.00,1,'[\"Meets legal requirements with owner protection\",\"Suitable for: Budget-conscious drivers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Meets legal requirements with owner protection\"},{\"title\":\"Target Audience\",\"description\":\"Budget-conscious drivers\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(15,3,'Engine Protect Shield','engine-protect-shield','Standalone add-on for engine and gearbox damage.',800.00,400000.00,1,'[\"Covers water ingression and oil leakage\",\"Suitable for: Cars in flood-prone areas\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers water ingression and oil leakage\"},{\"title\":\"Target Audience\",\"description\":\"Cars in flood-prone areas\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(16,3,'Comprehensive Assure','comprehensive-assure','Standard own-damage plus third-party with 24x7 roadside assist.',950.00,475000.00,1,'[\"Free towing and jump-start services\",\"Suitable for: Everyday city commuters\"]','[{\"title\":\"Key Benefit\",\"description\":\"Free towing and jump-start services\"},{\"title\":\"Target Audience\",\"description\":\"Everyday city commuters\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(17,4,'Click-to-Protect Elite','click-to-protect-elite','Pure term plan with high sum assured for minimal premium.',650.00,325000.00,1,'[\"\\u20b91 Crore cover at low rates\",\"Suitable for: Primary family breadwinners\"]','[{\"title\":\"Key Benefit\",\"description\":\"\\u20b91 Crore cover at low rates\"},{\"title\":\"Target Audience\",\"description\":\"Primary family breadwinners\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(18,4,'Income Return Term Plan','income-return-term-plan','Term cover providing monthly income payouts to dependents.',800.00,400000.00,1,'[\"Replaces monthly salary upon demise\",\"Suitable for: Families with single earners\"]','[{\"title\":\"Key Benefit\",\"description\":\"Replaces monthly salary upon demise\"},{\"title\":\"Target Audience\",\"description\":\"Families with single earners\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(19,4,'Premium Return Shield','premium-return-shield','Term plan with return of premium upon maturity.',1050.00,525000.00,1,'[\"Get 100% premiums back if you survive the term\",\"Suitable for: Risk-averse individuals\"]','[{\"title\":\"Key Benefit\",\"description\":\"Get 100% premiums back if you survive the term\"},{\"title\":\"Target Audience\",\"description\":\"Risk-averse individuals\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(20,4,'Insta-Cover Term','insta-cover-term','Instant term policy with no medical tests for moderate covers.',550.00,275000.00,1,'[\"Quick 5-minute issuance\",\"Suitable for: Busy working professionals\"]','[{\"title\":\"Key Benefit\",\"description\":\"Quick 5-minute issuance\"},{\"title\":\"Target Audience\",\"description\":\"Busy working professionals\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(21,4,'Joint Life Term Shield','joint-life-term-shield','Single term policy covering both husband and wife.',1100.00,550000.00,1,'[\"20% discount on joint premium\",\"Suitable for: Married couples\"]','[{\"title\":\"Key Benefit\",\"description\":\"20% discount on joint premium\"},{\"title\":\"Target Audience\",\"description\":\"Married couples\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(22,5,'Wealth Builder ULIP','wealth-builder-ulip','Market-linked plan for aggressive wealth creation.',2000.00,1000000.00,1,'[\"Choice of equity and debt funds\",\"Suitable for: Risk-tolerant investors\"]','[{\"title\":\"Key Benefit\",\"description\":\"Choice of equity and debt funds\"},{\"title\":\"Target Audience\",\"description\":\"Risk-tolerant investors\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(23,5,'Guaranteed Savings Plan','guaranteed-savings-plan','Safe investment with assured returns and life cover.',1500.00,750000.00,1,'[\"Guaranteed maturity payouts\",\"Suitable for: Conservative investors\"]','[{\"title\":\"Key Benefit\",\"description\":\"Guaranteed maturity payouts\"},{\"title\":\"Target Audience\",\"description\":\"Conservative investors\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(24,5,'Child Future Assure','child-future-assure','Investment plan dedicated to funding higher education.',1800.00,900000.00,1,'[\"Premium waiver upon parent\'s demise\",\"Suitable for: Parents with young children\"]','[{\"title\":\"Key Benefit\",\"description\":\"Premium waiver upon parent\'s demise\"},{\"title\":\"Target Audience\",\"description\":\"Parents with young children\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(25,5,'Tax Saver Plus','tax-saver-plus','ELSS alternative offering section 80C tax benefits.',1250.00,625000.00,1,'[\"Dual benefit of saving tax and growing wealth\",\"Suitable for: Salaried taxpayers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Dual benefit of saving tax and growing wealth\"},{\"title\":\"Target Audience\",\"description\":\"Salaried taxpayers\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(26,5,'Capital Guarantee Shield','capital-guarantee-shield','Invest in markets safely with capital protection.',2500.00,1250000.00,1,'[\"Zero downside risk on principal\",\"Suitable for: First-time market investors\"]','[{\"title\":\"Key Benefit\",\"description\":\"Zero downside risk on principal\"},{\"title\":\"Target Audience\",\"description\":\"First-time market investors\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(27,6,'Rider Protect Comp','rider-protect-comp','Comprehensive policy covering own damage and third-party.',150.00,75000.00,1,'[\"Includes helmet and accessory cover\",\"Suitable for: Daily scooter\\/bike commuters\"]','[{\"title\":\"Key Benefit\",\"description\":\"Includes helmet and accessory cover\"},{\"title\":\"Target Audience\",\"description\":\"Daily scooter\\/bike commuters\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(28,6,'Third-Party Basic','third-party-basic','Legally compliant cover for third-party liabilities only.',60.00,30000.00,1,'[\"Cheapest mandatory policy\",\"Suitable for: Old two-wheeler owners\"]','[{\"title\":\"Key Benefit\",\"description\":\"Cheapest mandatory policy\"},{\"title\":\"Target Audience\",\"description\":\"Old two-wheeler owners\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(29,6,'Zero-Dep Bike Shield','zero-dep-bike-shield','Complete bumper-to-bumper protection for bikes.',250.00,125000.00,1,'[\"Full reimbursement without depreciation\",\"Suitable for: New bike owners\"]','[{\"title\":\"Key Benefit\",\"description\":\"Full reimbursement without depreciation\"},{\"title\":\"Target Audience\",\"description\":\"New bike owners\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(30,6,'Long-Term Multi-Year','long-term-multi-year','Renew once every 3 or 5 years to lock in premiums.',120.00,60000.00,1,'[\"Protection from yearly tariff hikes\",\"Suitable for: Hassle-free vehicle owners\"]','[{\"title\":\"Key Benefit\",\"description\":\"Protection from yearly tariff hikes\"},{\"title\":\"Target Audience\",\"description\":\"Hassle-free vehicle owners\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(31,6,'EV Shield Scooter','ev-shield-scooter','Tailored insurance covering battery packs and chargers for EVs.',180.00,90000.00,1,'[\"Specialized EV breakdown assistance\",\"Suitable for: Electric scooter buyers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Specialized EV breakdown assistance\"},{\"title\":\"Target Audience\",\"description\":\"Electric scooter buyers\"}]',NULL,1,'2026-02-25 00:17:51','2026-02-25 00:17:51'),(32,7,'Family Floater Supreme','family-floater-supreme','Single policy covering up to 6 family members.',1100.00,550000.00,1,'[\"Shared sum insured with no individual limits\",\"Suitable for: Nuclear families\"]','[{\"title\":\"Key Benefit\",\"description\":\"Shared sum insured with no individual limits\"},{\"title\":\"Target Audience\",\"description\":\"Nuclear families\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(33,7,'Global Family Care','global-family-care','Health cover valid both in India and abroad.',2200.00,1100000.00,1,'[\"Cashless treatment at international hospitals\",\"Suitable for: Families traveling frequently\"]','[{\"title\":\"Key Benefit\",\"description\":\"Cashless treatment at international hospitals\"},{\"title\":\"Target Audience\",\"description\":\"Families traveling frequently\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(34,7,'Health Plus Super Top-up','health-plus-super-top-up','Affordable top-up to upgrade existing family cover.',450.00,225000.00,1,'[\"Extends coverage after deductible is exhausted\",\"Suitable for: Families with corporate covers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Extends coverage after deductible is exhausted\"},{\"title\":\"Target Audience\",\"description\":\"Families with corporate covers\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(35,7,'OPD Care Family','opd-care-family','Covers doctor consultations, pharmacy, and diagnostics.',950.00,475000.00,1,'[\"Eliminates out-of-pocket minor medical expenses\",\"Suitable for: Families with toddlers or elderly\"]','[{\"title\":\"Key Benefit\",\"description\":\"Eliminates out-of-pocket minor medical expenses\"},{\"title\":\"Target Audience\",\"description\":\"Families with toddlers or elderly\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(36,7,'Critical Illness Family Guard','critical-illness-family-guard','Lump-sum payout upon diagnosis of 36 critical illnesses.',700.00,350000.00,1,'[\"Immediate cash flow for major treatments\",\"Suitable for: Families with medical history\"]','[{\"title\":\"Key Benefit\",\"description\":\"Immediate cash flow for major treatments\"},{\"title\":\"Target Audience\",\"description\":\"Families with medical history\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(37,8,'Global Explorer Plan','global-explorer-plan','Complete international travel protection for medical and delays.',500.00,250000.00,1,'[\"Covers flight cancellations and lost baggage\",\"Suitable for: International tourists\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers flight cancellations and lost baggage\"},{\"title\":\"Target Audience\",\"description\":\"International tourists\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(38,8,'Domestic Travel Shield','domestic-travel-shield','Affordable cover for domestic flights and train journeys.',100.00,50000.00,1,'[\"Covers medical emergencies within India\",\"Suitable for: Domestic vacationers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers medical emergencies within India\"},{\"title\":\"Target Audience\",\"description\":\"Domestic vacationers\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(39,8,'Student Secure Travel','student-secure-travel','Tailored for students studying abroad.',800.00,400000.00,1,'[\"Covers tuition fees interruption and sponsor protection\",\"Suitable for: International students\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers tuition fees interruption and sponsor protection\"},{\"title\":\"Target Audience\",\"description\":\"International students\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(40,8,'Multi-Trip Annual Pass','multi-trip-annual-pass','One policy for unlimited trips throughout the year.',1200.00,600000.00,1,'[\"Avoid buying separate policies per trip\",\"Suitable for: Frequent business travelers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Avoid buying separate policies per trip\"},{\"title\":\"Target Audience\",\"description\":\"Frequent business travelers\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(41,8,'Schengen Visa Approved','schengen-visa-approved','Meets standard requirements for Schengen visa applications.',650.00,325000.00,1,'[\"Minimum \\u20ac30,000 medical coverage\",\"Suitable for: Europe travelers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Minimum \\u20ac30,000 medical coverage\"},{\"title\":\"Target Audience\",\"description\":\"Europe travelers\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(42,10,'CorpHealth Standard','corphealth-standard','Group medical cover for MSME employees.',300.00,150000.00,1,'[\"Cashless hospitalization in network hospitals\",\"Suitable for: Startups and MSMEs\"]','[{\"title\":\"Key Benefit\",\"description\":\"Cashless hospitalization in network hospitals\"},{\"title\":\"Target Audience\",\"description\":\"Startups and MSMEs\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(43,10,'Group Term Life Protect','group-term-life-protect','Flat term life cover provided to all employees.',150.00,75000.00,1,'[\"Financial security for employee families\",\"Suitable for: IT and Corporate firms\"]','[{\"title\":\"Key Benefit\",\"description\":\"Financial security for employee families\"},{\"title\":\"Target Audience\",\"description\":\"IT and Corporate firms\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(44,10,'Group Accident Shield','group-accident-shield','Coverage against workplace and off-duty accidents.',100.00,50000.00,1,'[\"Compensation for disability or death\",\"Suitable for: Manufacturing & construction workers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Compensation for disability or death\"},{\"title\":\"Target Audience\",\"description\":\"Manufacturing & construction workers\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(45,10,'Premium Flexi-Benefit Plan','premium-flexi-benefit-plan','Allows employees to customize their group health benefits.',500.00,250000.00,1,'[\"Top-up options for parents and maternity\",\"Suitable for: Large modern enterprises\"]','[{\"title\":\"Key Benefit\",\"description\":\"Top-up options for parents and maternity\"},{\"title\":\"Target Audience\",\"description\":\"Large modern enterprises\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(46,10,'Gratuity Funding Plan','gratuity-funding-plan','Helps employers meet their statutory gratuity obligations.',1000.00,500000.00,1,'[\"Seamless fund management and tax benefits\",\"Suitable for: Established companies\"]','[{\"title\":\"Key Benefit\",\"description\":\"Seamless fund management and tax benefits\"},{\"title\":\"Target Audience\",\"description\":\"Established companies\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(47,11,'Bharat Griha Raksha','bharat-griha-raksha','Standardized home structure and contents cover.',250.00,125000.00,1,'[\"Protection against fire, theft, and natural disasters\",\"Suitable for: Homeowners and tenants\"]','[{\"title\":\"Key Benefit\",\"description\":\"Protection against fire, theft, and natural disasters\"},{\"title\":\"Target Audience\",\"description\":\"Homeowners and tenants\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(48,11,'Tenant Protection Shield','tenant-protection-shield','Covers only household belongings and electronics.',150.00,75000.00,1,'[\"Protection from burglary and accidental damage\",\"Suitable for: People living in rented apartments\"]','[{\"title\":\"Key Benefit\",\"description\":\"Protection from burglary and accidental damage\"},{\"title\":\"Target Audience\",\"description\":\"People living in rented apartments\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(49,11,'Premium Villa Protect','premium-villa-protect','High-value coverage for luxury properties and jewelry.',850.00,425000.00,1,'[\"Covers precious items and alternate accommodation\",\"Suitable for: Owners of luxury homes\\/villas\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers precious items and alternate accommodation\"},{\"title\":\"Target Audience\",\"description\":\"Owners of luxury homes\\/villas\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(50,11,'Home Appliance Care','home-appliance-care','Specific coverage for breakdown of costly electronics.',200.00,100000.00,1,'[\"Replaces ACs, TVs, and fridges in case of voltage spikes\",\"Suitable for: Tech-heavy households\"]','[{\"title\":\"Key Benefit\",\"description\":\"Replaces ACs, TVs, and fridges in case of voltage spikes\"},{\"title\":\"Target Audience\",\"description\":\"Tech-heavy households\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(51,11,'Rent Loss Cover','rent-loss-cover','Compensates landlords if the property becomes uninhabitable.',300.00,150000.00,1,'[\"Covers lost rental income up to 6 months\",\"Suitable for: Property investors \\/ Landlords\"]','[{\"title\":\"Key Benefit\",\"description\":\"Covers lost rental income up to 6 months\"},{\"title\":\"Target Audience\",\"description\":\"Property investors \\/ Landlords\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(52,12,'Jeevan Shanti Pension','jeevan-shanti-pension','Immediate annuity plan for instant retirement income.',5000.00,2500000.00,1,'[\"Start receiving pension from next month\",\"Suitable for: Individuals retiring right now\"]','[{\"title\":\"Key Benefit\",\"description\":\"Start receiving pension from next month\"},{\"title\":\"Target Audience\",\"description\":\"Individuals retiring right now\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(53,12,'Deferred Wealth Builder','deferred-wealth-builder','Accumulate a corpus now, receive pension later.',2000.00,1000000.00,1,'[\"Tax-free maturity and market-linked growth\",\"Suitable for: Professionals in their 30s\"]','[{\"title\":\"Key Benefit\",\"description\":\"Tax-free maturity and market-linked growth\"},{\"title\":\"Target Audience\",\"description\":\"Professionals in their 30s\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(54,12,'Golden Age Assure','golden-age-assure','Traditional retirement plan with guaranteed additions.',3000.00,1500000.00,1,'[\"Capital protection with steady bonuses\",\"Suitable for: Risk-averse pre-retirees\"]','[{\"title\":\"Key Benefit\",\"description\":\"Capital protection with steady bonuses\"},{\"title\":\"Target Audience\",\"description\":\"Risk-averse pre-retirees\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(55,12,'Joint Pension Plus','joint-pension-plus','Annuity covering both spouses with return of purchase price.',4000.00,2000000.00,1,'[\"Pension continues for the surviving spouse\",\"Suitable for: Married couples nearing retirement\"]','[{\"title\":\"Key Benefit\",\"description\":\"Pension continues for the surviving spouse\"},{\"title\":\"Target Audience\",\"description\":\"Married couples nearing retirement\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(56,12,'NPS Tier-I Advantage','nps-tier-i-advantage','Market-linked government scheme for retirement.',1000.00,500000.00,1,'[\"Exclusive \\u20b950,000 extra tax benefit under 80CCD\",\"Suitable for: Salaried employees\"]','[{\"title\":\"Key Benefit\",\"description\":\"Exclusive \\u20b950,000 extra tax benefit under 80CCD\"},{\"title\":\"Target Audience\",\"description\":\"Salaried employees\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(57,13,'Assured Income Plan','assured-income-plan','Provides fixed monthly income for 10 years post-maturity.',1500.00,750000.00,1,'[\"Tax-free predictable cash flows\",\"Suitable for: Sole breadwinners planning for future\"]','[{\"title\":\"Key Benefit\",\"description\":\"Tax-free predictable cash flows\"},{\"title\":\"Target Audience\",\"description\":\"Sole breadwinners planning for future\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(58,13,'Wealth Guarantee 10x','wealth-guarantee-10x','Pay for 5 years, get 10 times the premium guaranteed.',2500.00,1250000.00,1,'[\"100% principal protection with high returns\",\"Suitable for: Medium-term investors\"]','[{\"title\":\"Key Benefit\",\"description\":\"100% principal protection with high returns\"},{\"title\":\"Target Audience\",\"description\":\"Medium-term investors\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(59,13,'Milestone Magic Plan','milestone-magic-plan','Pumps out lump-sum amounts at critical life stages.',2000.00,1000000.00,1,'[\"Guaranteed payouts at years 5, 10, and 15\",\"Suitable for: Parents planning for education\\/marriage\"]','[{\"title\":\"Key Benefit\",\"description\":\"Guaranteed payouts at years 5, 10, and 15\"},{\"title\":\"Target Audience\",\"description\":\"Parents planning for education\\/marriage\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(60,13,'FD Beater Plus','fd-beater-plus','Offers guaranteed returns higher than bank FDs.',1000.00,500000.00,1,'[\"Assured interest rate locked for 20 years\",\"Suitable for: Conservative savers\"]','[{\"title\":\"Key Benefit\",\"description\":\"Assured interest rate locked for 20 years\"},{\"title\":\"Target Audience\",\"description\":\"Conservative savers\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52'),(61,13,'Secure Future Plus','secure-future-plus','Combines life insurance with a guaranteed lump sum payout.',1200.00,600000.00,1,'[\"Get maturity amount even if premiums stop due to death\",\"Suitable for: Safety-focused individuals\"]','[{\"title\":\"Key Benefit\",\"description\":\"Get maturity amount even if premiums stop due to death\"},{\"title\":\"Target Audience\",\"description\":\"Safety-focused individuals\"}]',NULL,1,'2026-02-25 00:17:52','2026-02-25 00:17:52');
/*!40000 ALTER TABLE `insurance_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_02_13_000001_create_admins_table',1),(5,'2024_02_13_000002_create_insurance_categories_table',1),(6,'2024_02_13_000003_create_insurance_plans_table',1),(7,'2024_02_13_000004_create_policies_table',1),(8,'2024_02_13_000005_create_claims_table',1),(9,'2024_02_13_000006_create_payments_table',1),(10,'2024_02_13_000007_create_support_tickets_table',1),(11,'2024_02_13_000008_create_contact_messages_table',1),(12,'2024_02_13_000009_create_policy_renewals_table',1),(13,'2024_02_13_000010_add_fields_to_users_table',1),(14,'2026_02_18_145455_add_details_to_insurance_tables',2),(15,'2026_02_25_063332_add_image_path_to_insurance_plans_table',3),(16,'2026_02_25_154424_add_subject_to_contact_messages_table',4),(17,'2026_02_25_160146_add_profile_fields_to_users_table',5),(18,'2026_02_25_172222_create_chat_sessions_table',6),(19,'2026_02_25_172223_create_chat_messages_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `policy_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'card',
  `status` enum('success','failed','pending') NOT NULL DEFAULT 'success',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  KEY `payments_user_id_foreign` (`user_id`),
  KEY `payments_policy_id_foreign` (`policy_id`),
  CONSTRAINT `payments_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`),
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `policies`
--

DROP TABLE IF EXISTS `policies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `policies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `plan_id` bigint(20) unsigned NOT NULL,
  `policy_number` varchar(255) NOT NULL,
  `premium_amount` decimal(10,2) NOT NULL,
  `coverage_amount` decimal(15,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `next_renewal_date` date DEFAULT NULL,
  `status` enum('active','expired','cancelled') NOT NULL DEFAULT 'active',
  `policy_document` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policies_policy_number_unique` (`policy_number`),
  KEY `policies_user_id_foreign` (`user_id`),
  KEY `policies_plan_id_foreign` (`plan_id`),
  CONSTRAINT `policies_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `insurance_plans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `policies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `policies`
--

LOCK TABLES `policies` WRITE;
/*!40000 ALTER TABLE `policies` DISABLE KEYS */;
INSERT INTO `policies` VALUES (3,2,7,'POL-699E967BDD894',450.00,225000.00,'2026-02-25','2027-02-25','2027-02-25','active',NULL,'2026-02-25 00:58:11','2026-02-25 00:58:11');
/*!40000 ALTER TABLE `policies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `policy_renewals`
--

DROP TABLE IF EXISTS `policy_renewals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `policy_renewals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `policy_id` bigint(20) unsigned NOT NULL,
  `renewal_date` date NOT NULL,
  `new_end_date` date NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `policy_renewals_policy_id_foreign` (`policy_id`),
  CONSTRAINT `policy_renewals_policy_id_foreign` FOREIGN KEY (`policy_id`) REFERENCES `policies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `policy_renewals`
--

LOCK TABLES `policy_renewals` WRITE;
/*!40000 ALTER TABLE `policy_renewals` DISABLE KEYS */;
/*!40000 ALTER TABLE `policy_renewals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6CCv9O32nJSSgHeXRnOA8ymxOhMLszhbidaBURi0',NULL,'127.0.0.1','','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUxVc09Kdjd4VFRWNHBMQm9JREh5ZzRTRExPcTI1dXFsaTYwOHd4RyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Rlc3QtZ2VtaW5pIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZXN0LWdlbWluaSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772041137),('a3fpyFL431I80keBmXc7FSxx3USBwFGxtSotMqht',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjliREQzWnR1MzhvQmNOb2ZzOFBYSVNtY0RrTWFGMXNaWU5OYkpWVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9fQ==',1772042719),('eN1WlBpS2FEfcVaAXoBbv7nhiucLM5w5OZtOUajT',NULL,'127.0.0.1','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUhuZTlwdloxWXZGenVLd2lQSTA5cGJtS2pISGdKc1ZINUo4U1BWVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772041097),('GrkX6HNn2kmi78ffYsrY5ZDV9PoIKwp2yQQZ4yGF',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-IN) WindowsPowerShell/5.1.26100.7920','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmpQNGtROFFWblhuc2hXZmZIbmxDVVNPMm9pbFZSSjB6TFNTeEFZdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Rlc3QtZ2VtaW5pIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772041022),('MfHMrR6mZBpblXSCwt3EBljTAfCSLq6itFztvTfg',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTjRPWjVRd0RUZmNNcUZzSTdVekdpQjBPOFN2QWhsVWxjNkFGd0E2SyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NzIwNDA1ODQ7fX0=',1772042478),('NiW2vTdEJ2CaPs8OzzKxlk3Di6VbSHFrk2jNSWmS',NULL,'127.0.0.1','','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSmkwYUlObmdkSnV3V1poOTBaNGRxM3FiQnhHVEJRdGdoVGZVWnQ0RCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Rlc3QtZ2VtaW5pIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZXN0LWdlbWluaSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772041096),('oWB1d3LabiNDXUPtLqcFbKUbA6908IY4ip3v3vDo',NULL,'127.0.0.1','','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSTJ1dUpJOHBra0tpWkZFb1hrbXlWUUtTQjMzNDdUdkJCM2Q3OWlBUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772041137),('QKPAYxjcARAc2IbKZyzwd51OJQ986wJgBnSWgko4',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEZKTVJKWnFCY2xrYkl4R1J0SXZ6d1lUNU1uN0NwaHBsNEVSS1dEdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJsYW5kaW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772084599),('uXfKHvBxQXTlBz76ZIhNrBGSYqWRufG7dzng2hMe',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoid2JyejczY3d5WDc1RG1UUkZtYU16NG4xb25ZOFVLRGJXSGdDMk1BciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGF0L2hpc3RvcnkiO3M6NToicm91dGUiO3M6MTI6ImNoYXQuaGlzdG9yeSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==',1772042244);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('open','closed','resolved') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_tickets_user_id_foreign` (`user_id`),
  CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_tickets`
--

LOCK TABLES `support_tickets` WRITE;
/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;
INSERT INTO `support_tickets` VALUES (1,2,'Issue with policy renewal','I am unable to renew my policy #POL-123. Please assist.','closed','2026-02-12 09:37:36','2026-02-25 08:47:01');
/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,0,'ANKIT GHOSH','ankit.ghosh.24@aot.edu.in',NULL,NULL,NULL,'$2y$12$kXNWwTwtmFDEubmW2VgTl.qoGCnzWzSmc7U9Q03h.cMmYNQsudt2.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-12 08:28:19','2026-02-12 08:28:19',NULL,NULL,NULL),(2,0,'Riya Seth','a@gmail.com',NULL,NULL,NULL,'$2y$12$2Kl/hcPjcgfNmC8Gi4uzKuEqwt0nSFYAWH9Y2vN7Ti9vyXy3Ia1vW','Magra',NULL,NULL,NULL,NULL,'6GsWMmBhi48zgak5q8u1YTADFUhA3oQY1HzLlcFZSdRXBOF6BESsaPZ7XluW','2026-02-12 09:01:25','2026-02-25 10:44:26','avatars/MEa2do4gNzNEPZ4cSAZ5f3xmN9GNyE18gvI2JsZj.jpg','Riya Seth','9874563210'),(3,0,'Test User','test@example.com',NULL,NULL,'2026-02-19 11:01:22','$2y$12$M34cvhg4RMDzlNT9914fQuHFwHItHeE8jIa52szRL.H6X2EL6q14y',NULL,NULL,NULL,NULL,NULL,'iqKJOniaXJ','2026-02-19 11:01:23','2026-02-19 11:01:23',NULL,NULL,NULL),(4,0,'Test User','test2@example.com',NULL,NULL,NULL,'$2y$12$6oSPyoGfP9h1qovnlLo.6.gjoU4otebHSlBkRLDK0pO9YzBGd/yIO',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-25 12:25:56','2026-02-25 12:25:56',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-26 12:27:30
