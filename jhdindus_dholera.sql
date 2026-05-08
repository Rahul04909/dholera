/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.16-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: jhdindus_dholera
-- ------------------------------------------------------
-- Server version	10.11.16-MariaDB

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
-- Current Database: `jhdindus_dholera`
--

-- CREATE DATABASE /*!32312 IF NOT EXISTS*/ `jhdindus_dholera` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

-- USE `jhdindus_dholera`;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES
(1,'admin','$2y$12$L7UniSWxJ41QK5Vg7VEpdeu9ZM.NAvhmFyTK4PBxqubUbd4l9gtuy','info@dholerabyus.in','Dholera Admin','2026-02-27 16:00:41');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agent_leads`
--

DROP TABLE IF EXISTS `agent_leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `source_type` enum('enquiry','callback') NOT NULL,
  `source_id` int(11) NOT NULL,
  `admin_note` text DEFAULT NULL,
  `agent_feedback` text DEFAULT NULL,
  `status` enum('new','in-progress','junk','converted') DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `agent_id` (`agent_id`),
  CONSTRAINT `agent_leads_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_leads`
--

LOCK TABLES `agent_leads` WRITE;
/*!40000 ALTER TABLE `agent_leads` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agent_package_benefits`
--

DROP TABLE IF EXISTS `agent_package_benefits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent_package_benefits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `benefit_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  CONSTRAINT `agent_package_benefits_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `agent_packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_package_benefits`
--

LOCK TABLES `agent_package_benefits` WRITE;
/*!40000 ALTER TABLE `agent_package_benefits` DISABLE KEYS */;
INSERT INTO `agent_package_benefits` VALUES
(1,1,'Unlimited Lead Acess','2026-03-23 06:55:44'),
(2,1,'24x7 Passive Support','2026-03-23 06:55:44'),
(3,1,'Automatic Enquiries','2026-03-23 06:55:44');
/*!40000 ALTER TABLE `agent_package_benefits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agent_packages`
--

DROP TABLE IF EXISTS `agent_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration_months` enum('1','3','6','12') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_packages`
--

LOCK TABLES `agent_packages` WRITE;
/*!40000 ALTER TABLE `agent_packages` DISABLE KEYS */;
INSERT INTO `agent_packages` VALUES
(1,'Basic Plan',399.00,'1','active','2026-03-23 06:55:44','2026-03-23 06:55:44');
/*!40000 ALTER TABLE `agent_packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agent_projects`
--

DROP TABLE IF EXISTS `agent_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `assigned_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_assignment` (`agent_id`,`project_id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `agent_projects_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agent_projects_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_projects`
--

LOCK TABLES `agent_projects` WRITE;
/*!40000 ALTER TABLE `agent_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agent_site_visits`
--

DROP TABLE IF EXISTS `agent_site_visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent_site_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `site_visit_id` int(11) NOT NULL,
  `status` enum('pending','contacted','completed','cancelled') DEFAULT 'pending',
  `agent_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_agent_visit` (`agent_id`,`site_visit_id`),
  KEY `site_visit_id` (`site_visit_id`),
  CONSTRAINT `agent_site_visits_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agent_site_visits_ibfk_2` FOREIGN KEY (`site_visit_id`) REFERENCES `site_visits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_site_visits`
--

LOCK TABLES `agent_site_visits` WRITE;
/*!40000 ALTER TABLE `agent_site_visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_site_visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'India',
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `full_address` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `package_expiry` datetime DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `registration_status` enum('pending','active') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `mobile` (`mobile`),
  KEY `fk_agent_package` (`package_id`),
  CONSTRAINT `fk_agent_package` FOREIGN KEY (`package_id`) REFERENCES `agent_packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES
(3,'RITIKA','r49299174@gmail.com','8750705848','','India','HARYANA','FARIDABAD','121001','FARIDABAD','$2y$12$o2NdT1Ajuo/GiFyeDAxcDex1D6TRMR4fmq0ilcPASsYM8OqIpl2eu',NULL,NULL,'active','pending','2026-03-13 09:51:36','2026-03-13 09:52:21');
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `callbacks`
--

DROP TABLE IF EXISTS `callbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `callbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `preferred_time` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','closed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callbacks`
--

LOCK TABLES `callbacks` WRITE;
/*!40000 ALTER TABLE `callbacks` DISABLE KEYS */;
INSERT INTO `callbacks` VALUES
(1,'Rahul Dhiman','rahul.dhiman.mohanlal@gmail.com','8059982049','Morning (9 AM - 12 PM)','pending','2026-02-27 17:14:06'),
(2,'PRAM','pram.realtyrangers@gmail.com','9311053102','Morning (9 AM - 12 PM)','pending','2026-03-03 06:47:53');
/*!40000 ALTER TABLE `callbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enquiries`
--

DROP TABLE IF EXISTS `enquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `subject` varchar(255) DEFAULT 'General Enquiry',
  `message` text DEFAULT NULL,
  `status` enum('pending','closed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enquiries`
--

LOCK TABLES `enquiries` WRITE;
/*!40000 ALTER TABLE `enquiries` DISABLE KEYS */;
INSERT INTO `enquiries` VALUES
(1,'Rahul Dhiman','rahul.dhiman.mohanlal@gmail.com','8059982049','General Enquiry','Demo Enquiry','closed','2026-02-27 17:06:13'),
(2,'Pram','pram.realtyrangers@gmail.com','9311053102','General Enquiry','NA','closed','2026-03-03 06:48:32'),
(4,'Rahul','rahul.dhiman.mohanlal@gmail.com','8059982049','General Enquiry','hii','pending','2026-04-06 06:11:24');
/*!40000 ALTER TABLE `enquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `floor_plan_settings`
--

DROP TABLE IF EXISTS `floor_plan_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `floor_plan_settings` (
  `id` int(11) NOT NULL CHECK (`id` = 1),
  `sketch_title` varchar(255) NOT NULL DEFAULT 'Apartments Sketch',
  `main_title` varchar(255) NOT NULL DEFAULT 'Apartments Plan',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `floor_plan_settings`
--

LOCK TABLES `floor_plan_settings` WRITE;
/*!40000 ALTER TABLE `floor_plan_settings` DISABLE KEYS */;
INSERT INTO `floor_plan_settings` VALUES
(1,'Projects Sketch',' Explore Our Project Types ','2026-03-03 18:06:17');
/*!40000 ALTER TABLE `floor_plan_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `floor_plan_specs`
--

DROP TABLE IF EXISTS `floor_plan_specs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `floor_plan_specs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `plan_id` (`plan_id`),
  CONSTRAINT `floor_plan_specs_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `floor_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `floor_plan_specs`
--

LOCK TABLES `floor_plan_specs` WRITE;
/*!40000 ALTER TABLE `floor_plan_specs` DISABLE KEYS */;
INSERT INTO `floor_plan_specs` VALUES
(6,2,'Total Area','3500 Sq. Ft',1),
(7,2,'Bedroom','220 Sq. Ft',2),
(8,2,'Bathroom','60 Sq. Ft',3),
(9,2,'Balcony/Pets','Allowed',4),
(10,2,'Lounge','800 Sq. Ft',5),
(11,3,'Total Area','5200 Sq. Ft',1),
(12,3,'Bedroom','450 Sq. Ft',2),
(13,3,'Bathroom','120 Sq. Ft',3),
(14,3,'Terrace Area','1200 Sq. Ft',4),
(15,3,'Lounge','1200 Sq. Ft',5),
(16,4,'Total Area','4000 Sq. Ft',1),
(17,4,'Garden Space','500 Sq. Ft',2),
(18,4,'Bedroom','200 Sq. Ft',3),
(19,4,'Bathroom','55 Sq. Ft',4),
(20,4,'Lounge','750 Sq. Ft',5),
(21,5,'Total Area','4800 Sq. Ft',1),
(22,5,'Ceiling Height','22 Ft',2),
(23,5,'Bedroom','300 Sq. Ft',3),
(24,5,'Bathroom','90 Sq. Ft',4),
(25,5,'Lounge','1100 Sq. Ft',5),
(26,1,'Total Area','2800 Sq. Ft',0),
(27,1,'Bedroom','150 Sq. Ft',1),
(28,1,'Bathroom','45 Sq. Ft',2),
(29,1,'Balcony/Pets','Allowed',3),
(30,1,'Lounge','650 Sq. Ft',4),
(31,1,'Demo Test','Demo',5),
(32,1,'Demo Test 1 ','Demo Test 1',6);
/*!40000 ALTER TABLE `floor_plan_specs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `floor_plans`
--

DROP TABLE IF EXISTS `floor_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `floor_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tab_title` varchar(100) NOT NULL,
  `plan_title` varchar(255) NOT NULL,
  `plan_desc` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `floor_plans`
--

LOCK TABLES `floor_plans` WRITE;
/*!40000 ALTER TABLE `floor_plans` DISABLE KEYS */;
INSERT INTO `floor_plans` VALUES
(1,'The Dholera ','The Dholera','A modern, open-concept studio apartment designed for efficiency and style. Perfect for individuals or small families seeking a premium Smart City lifestyle with optimized space management.','https://images.unsplash.com/photo-1574362848149-11496d93a7c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',1,'2026-03-03 18:05:16'),
(2,'Deluxe Portion','Deluxe Portion','Spacious deluxe portions featuring enhanced privacy and larger living areas. These units offer high-end finishes and a perfect balance between luxury and functionality.','https://images.unsplash.com/photo-1628592102751-ba83b03a442a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',2,'2026-03-03 18:05:16'),
(3,'Penthouse','Penthouse','The pinnacle of luxury living. Our penthouses offer panoramic city views, expansive private terraces, and double-height ceilings for a truly majestic living experience.','https://images.unsplash.com/photo-1600607687989-ce8a6c72159c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',3,'2026-03-03 18:05:16'),
(4,'Top Garden','Top Garden Units','Unique garden-facing apartments that bring nature to your doorstep. Featuring dedicated green zones and large glass walls to integrate indoor and outdoor living.','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',4,'2026-03-03 18:05:16'),
(5,'Double Height','Double Height','Architectural masterpieces featuring double-volume living rooms. These units create an incredible sense of scale and allow for massive artistic installations or libraries.','https://images.unsplash.com/photo-1628592102173-b3a9920150d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',5,'2026-03-03 18:05:16');
/*!40000 ALTER TABLE `floor_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_info_settings`
--

DROP TABLE IF EXISTS `hero_info_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_info_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_info_settings`
--

LOCK TABLES `hero_info_settings` WRITE;
/*!40000 ALTER TABLE `hero_info_settings` DISABLE KEYS */;
INSERT INTO `hero_info_settings` VALUES
('brochure_file','uploads/docs/brochure_1772560228.pdf','2026-03-03 17:50:28'),
('brochure_icon','far fa-map','2026-03-03 17:50:28'),
('brochure_text','Download Profile','2026-03-03 17:50:28');
/*!40000 ALTER TABLE `hero_info_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_info_stats`
--

DROP TABLE IF EXISTS `hero_info_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_info_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(100) NOT NULL COMMENT 'FontAwesome class or image path',
  `label` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_info_stats`
--

LOCK TABLES `hero_info_stats` WRITE;
/*!40000 ALTER TABLE `hero_info_stats` DISABLE KEYS */;
INSERT INTO `hero_info_stats` VALUES
(1,'fas fa-home','Land Parcel','130 Sq.Yd.',1,'2026-03-03 17:49:01','2026-03-03 17:49:01'),
(2,'fas fa-th-large','Type','Plots',2,'2026-03-03 17:49:01','2026-03-03 17:49:01'),
(3,'fas fa-road','Amenities','Infrastructure & Connectivity',3,'2026-03-03 17:49:01','2026-03-03 17:49:01'),
(4,'fas fa-tag','Price','$ 12.5 Lacs*',4,'2026-03-03 17:49:01','2026-03-03 17:50:45');
/*!40000 ALTER TABLE `hero_info_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hero_slides`
--

DROP TABLE IF EXISTS `hero_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hero_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `order_index` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hero_slides`
--

LOCK TABLES `hero_slides` WRITE;
/*!40000 ALTER TABLE `hero_slides` DISABLE KEYS */;
INSERT INTO `hero_slides` VALUES
(4,'Residential Plots','ananta 2','assets/hero/uploads/hero_69a55bf183ca0.png',1,'active','2026-03-02 09:44:17');
/*!40000 ALTER TABLE `hero_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_amenities`
--

DROP TABLE IF EXISTS `project_amenities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon_path` varchar(255) DEFAULT NULL,
  `icon_type` enum('image','icon_class') DEFAULT 'icon_class',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_amenities_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_amenities`
--

LOCK TABLES `project_amenities` WRITE;
/*!40000 ALTER TABLE `project_amenities` DISABLE KEYS */;
INSERT INTO `project_amenities` VALUES
(24,3,'Entrance Gate','uploads/projects/amenities/1773315370_amenity_0.png','image'),
(25,3,'Boundary Wall','','icon_class'),
(26,3,'Water Supply','','icon_class'),
(27,3,'Tree Plantation','','icon_class'),
(28,3,' Plot Demarcation','','icon_class'),
(29,3,' Internal Roads','','icon_class'),
(30,3,'Security Cabin','','icon_class'),
(31,3,' Power Supply','','icon_class'),
(32,3,'Street Light','','icon_class'),
(33,3,' Garden Area','','icon_class'),
(34,3,'Parking Area ','','icon_class'),
(80,2,'Inside Roads','uploads/projects/amenities/1773391287_amenity_0.png','image'),
(81,2,'24x7 Security','uploads/projects/amenities/1773391607_amenity_1.png','image'),
(82,2,'Gated Community','uploads/projects/amenities/1773391726_amenity_2.png','image'),
(83,2,'Electricity Supply','uploads/projects/amenities/1773391867_amenity_3.png','image'),
(84,2,' Water Supply','uploads/projects/amenities/1773391944_amenity_4.png','image'),
(85,2,' Boundary Wall','uploads/projects/amenities/1773392156_amenity_5.png','image'),
(95,4,'Security Cabin','uploads/projects/amenities/1777458085_amenity_0.avif','image'),
(96,4,'Club House','uploads/projects/amenities/1777460809_amenity_1.png','image'),
(97,4,'Gated Entry','uploads/projects/amenities/1777460809_amenity_2.avif','image'),
(98,4,'Boundary Wall','uploads/projects/amenities/1777460871_amenity_3.avif','image');
/*!40000 ALTER TABLE `project_amenities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_nearbys`
--

DROP TABLE IF EXISTS `project_nearbys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_nearbys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `distance` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_nearbys_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_nearbys`
--

LOCK TABLES `project_nearbys` WRITE;
/*!40000 ALTER TABLE `project_nearbys` DISABLE KEYS */;
INSERT INTO `project_nearbys` VALUES
(23,3,'VASAD, DMIC','85 KM'),
(24,3,'ABCD Building','27KM'),
(25,3,'Dholera International Airport','15KM'),
(26,3,'Vataman Chokdi','7KM'),
(27,3,'Activation Area','25 KM'),
(28,3,'National Maritime Heritage Complex, Lothal','20 KM'),
(29,3,'Ahmedabad - Dholera Expressway','10 KM'),
(30,3,'State Highway','0 KM'),
(81,2,'Dholera International Airport','16 Km'),
(82,2,'Dholera SIR Boundary','0 Km'),
(83,2,'State Highway / BRTS','1.5 Km'),
(84,2,' ABCD Building / MRTS','13 Km'),
(85,2,'Ahmedabad - Dholera Expressway','13 Km'),
(110,4,'Dholera SIR','01 KM'),
(111,4,'State Highway / BRTS','00 KM'),
(112,4,'Ahmedabad - Dholera Expressway','12 KM'),
(113,4,'Activation Zone','13 KM'),
(114,4,'ABCD Building/ MRTS','12 KM'),
(115,4,'Dholera International Airport','20 KM');
/*!40000 ALTER TABLE `project_nearbys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_slides`
--

DROP TABLE IF EXISTS `project_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `order_index` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_slides_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_slides`
--

LOCK TABLES `project_slides` WRITE;
/*!40000 ALTER TABLE `project_slides` DISABLE KEYS */;
INSERT INTO `project_slides` VALUES
(2,3,'uploads/projects/slides/1772527177_slide_0.png',0),
(3,2,'uploads/projects/slides/1773393668_slide_0.jpeg',100),
(4,2,'uploads/projects/slides/1773393720_slide_0.jpeg',100),
(5,2,'uploads/projects/slides/1773393961_slide_0.jpeg',100),
(6,2,'uploads/projects/slides/1773393961_slide_1.jpeg',100),
(7,2,'uploads/projects/slides/1773393961_slide_2.jpeg',100);
/*!40000 ALTER TABLE `project_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `project_type` varchar(100) DEFAULT NULL,
  `legitimate` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `google_map_url` text DEFAULT NULL,
  `about_project` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `brochure_pdf` varchar(255) DEFAULT NULL,
  `site_plan_image` varchar(255) DEFAULT NULL,
  `plot_size_from` varchar(50) DEFAULT NULL,
  `plot_size_to` varchar(50) DEFAULT NULL,
  `total_units` varchar(50) DEFAULT NULL,
  `price_range` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `projects_slug_idx` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES
(2,'Mirrikh Mayur Ananta II','mirrikh-mayur-ananta-ii','1491 Plots','Residential  Plots','NA, NOC, Title Clear & Unit Plan Pass','Rojka, Dholera Smart City','https://maps.google.com/maps?q=22.24836,72.195112&z=15&output=embed','<p style=\"border: 0px; font-size: 15px; margin-bottom: 1.6em; outline: 0px; vertical-align: baseline; color: rgb(96, 96, 96); font-family: \"Plus Jakarta Sans\", sans-serif; text-align: justify; background-color: rgb(252, 252, 252);\">After the remarkable success of Mayur Ananta, we present Mayur Ananta II. The largest premium residential land project in its segment in the Dholera Smart City region. Developed by Mirrikh Infratech, Dholera’s leading land developer, this new phase sets a bigger benchmark for smart, future-ready living. Spread across 55 acres, it offers well-planned residential plots, a grand clubhouse, and a lawn for elevated community living.</p><p style=\"border: 0px; font-size: 15px; margin-bottom: 1.6em; outline: 0px; vertical-align: baseline; color: rgb(96, 96, 96); font-family: \"Plus Jakarta Sans\", sans-serif; text-align: justify; background-color: rgb(252, 252, 252);\">Strategically located with excellent connectivity to Dholera International Airport, the ABCD Building, industrial zones, and upcoming smart city infrastructure — ensuring unmatched growth potential.</p>','uploads/projects/1773393550_feat.png','uploads/projects/brochures/1772434923_brochure.pdf','uploads/projects/1772444881_plan.avif','130','755.63 Sq. Yards','1491','13 Lakhs - 45 Lakhs','active','2026-02-28 10:39:48','2026-04-08 16:04:45'),
(3,'Mayur Industrial Landmark','mayur-industrial-landmark','338 PLOTS','Industrial Plots Project','NA, NOC, Title Clear & Unit Plan Pass','Dholera SIR, Gujarat','https://maps.app.goo.gl/3K1zqQxTDjGyxmck6','<p><span style=\"color: rgb(96, 96, 96); font-family: \"Plus Jakarta Sans\", sans-serif; font-size: 16px; text-align: justify; background-color: rgb(252, 252, 252);\">Located in Dholera Smart City, India’s emerging modern manufacturing hub, this industrial plot project offers a strategic opportunity to invest at the core of the nation’s industrial transformation. Supported by world-class infrastructure, multimodal connectivity, and government-led development, the project is designed for scalable manufacturing and long-term growth.</span><br style=\"color: rgb(96, 96, 96); font-family: \"Plus Jakarta Sans\", sans-serif; font-size: 16px; text-align: justify; background-color: rgb(252, 252, 252);\"><br style=\"color: rgb(96, 96, 96); font-family: \"Plus Jakarta Sans\", sans-serif; font-size: 16px; text-align: justify; background-color: rgb(252, 252, 252);\"><span style=\"color: rgb(96, 96, 96); font-family: \"Plus Jakarta Sans\", sans-serif; font-size: 16px; text-align: justify; background-color: rgb(252, 252, 252);\">It aligns seamlessly with the Make in India and Atmanirbhar Bharat vision, ensuring strong future demand and value appreciation.</span></p>','uploads/projects/1772527177_feat.png','','uploads/projects/1772527177_plan.avif','331','5000 sq.yd.','338 ','28 Lakhs - 4.2 Cr','active','2026-03-03 08:39:37','2026-04-08 16:04:45'),
(4,'Mayur Greenz Courtyard',NULL,'3 BHK Luxury Villas','Lluxury Residential Villas ','NA, NOC, Title Clear Plot','Dholera - Dhandhuka State Highway','https://www.google.com/maps?ll=22.328247,72.083333&z=15&t=m&hl=en&gl=US&mapclient=embed&cid=13140972803463693448','<p><span style=\"color: rgb(96, 96, 96); font-family: \"Plus Jakarta Sans\", sans-serif; font-size: 16px; text-align: justify; background-color: rgb(252, 252, 252);\">Mayur Greenz Courtyard is a distinguished enclave of luxury villas inspired by the grace of Roman architecture, thoughtfully re-imagined for modern lifestyles. Designed for discerning homeowners who value exclusivity and refinement, every villa embodies architectural brilliance, meticulous detailing, and generous living spaces. Nestled nearby Dholera Smart City, the location ensures seamless connectivity while offering a peaceful, private environment with curated amenities, landscaped greens, and an atmosphere of understated grandeur. Mayur Greenz Courtyard is not merely a residence, it is a legacy address, built to inspire pride for years to come.</span></p>','uploads/projects/1777459037_feat.png','uploads/projects/brochures/1777458085_brochure.pdf','uploads/projects/1777458085_plan.avif','196 Sq. Yards','438 Sq. Yards','124','72 Lakhs - 80 Lakhs','active','2026-04-29 10:21:25','2026-04-29 11:09:43');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `razorpay_config`
--

DROP TABLE IF EXISTS `razorpay_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `razorpay_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_id` varchar(255) NOT NULL,
  `key_secret` varchar(255) NOT NULL,
  `mode` enum('test','live') DEFAULT 'test',
  `status` enum('active','inactive') DEFAULT 'active',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `razorpay_config`
--

LOCK TABLES `razorpay_config` WRITE;
/*!40000 ALTER TABLE `razorpay_config` DISABLE KEYS */;
INSERT INTO `razorpay_config` VALUES
(1,'','','test','inactive','2026-03-23 07:09:55');
/*!40000 ALTER TABLE `razorpay_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_highlights_items`
--

DROP TABLE IF EXISTS `site_highlights_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_highlights_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_highlights_items`
--

LOCK TABLES `site_highlights_items` WRITE;
/*!40000 ALTER TABLE `site_highlights_items` DISABLE KEYS */;
INSERT INTO `site_highlights_items` VALUES
(1,'World-class infrastructure & connectivity: within & outside.',1,'2026-03-03 18:00:01'),
(2,'Airport & Sea Port in the vicinity.',2,'2026-03-03 18:00:01'),
(3,'Benefit of the sea coast, nature park, and golf course.',3,'2026-03-03 18:00:01'),
(4,'Premium civic amenities.',4,'2026-03-03 18:00:01'),
(5,'Capable to cater to both the International & Domestic Markets.',5,'2026-03-03 18:00:01'),
(6,'Close to Gujarat International Finance TechCity (GIFT).',6,'2026-03-03 18:00:01'),
(7,'Logistic support of the Dedicated Freight Corridor (DMIC).',7,'2026-03-03 18:00:01'),
(8,'Public investment in core infrastructure.',8,'2026-03-03 18:00:01');
/*!40000 ALTER TABLE `site_highlights_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_highlights_settings`
--

DROP TABLE IF EXISTS `site_highlights_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_highlights_settings` (
  `id` int(11) NOT NULL CHECK (`id` = 1),
  `title` varchar(255) NOT NULL DEFAULT 'Highlights',
  `side_image` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_highlights_settings`
--

LOCK TABLES `site_highlights_settings` WRITE;
/*!40000 ALTER TABLE `site_highlights_settings` DISABLE KEYS */;
INSERT INTO `site_highlights_settings` VALUES
(1,'Highlights','https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80','2026-03-03 18:00:01');
/*!40000 ALTER TABLE `site_highlights_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_overview`
--

DROP TABLE IF EXISTS `site_overview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_overview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `content` longtext NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_overview`
--

LOCK TABLES `site_overview` WRITE;
/*!40000 ALTER TABLE `site_overview` DISABLE KEYS */;
INSERT INTO `site_overview` VALUES
(1,'DHOLERA SMART CITY','India\'s First Platinum Rated Greenfield Smart City ','<p><b>Dholera Specia</b>l Investment Regions (SIR) is a Greenfield Industrial City, planned developed and managed by a SPV named Dholera Industrial City Development Limited (DICDL), incorporated between the Government of India represented by NICDIT and the State Government represented by Dholera Special Investment Region Development Authority (DSIRDA). The greenfield city is planned to be developed over 920 sq.km. with access to other proximate major cities like Ahmedabad, Rajkot, Baroda. The city is envisioned as a self-sustaining integrated ecosystem of urban and industrial economy. Being located in Gujarat, Dholera SIR has inherent advantages for industrial development.</p><p>DSIR, under Town Planning Schemes 1 to 6 covers an area of 422 sq. km. Initially an area of 22.54 sq. km is being developed as activation zone for industrial & residential uses. The city plan includes mixed, recreational, tourism, knowledge & IT, city center and logistics land use that will chart the economic road map of Dholera.</p>','uploads/frontend/overview_1773399293.jpg','2026-03-13 10:54:53');
/*!40000 ALTER TABLE `site_overview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_visits`
--

DROP TABLE IF EXISTS `site_visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `visit_date` date NOT NULL,
  `visit_time` varchar(50) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_visits`
--

LOCK TABLES `site_visits` WRITE;
/*!40000 ALTER TABLE `site_visits` DISABLE KEYS */;
INSERT INTO `site_visits` VALUES
(5,2,'Mirrikh Mayur Ananta II','Dholera Admin','info@dholerabyus.in','8059982049','2000-09-12','Morning','ha sh a','pending','2026-03-07 07:29:26'),
(6,2,'Mirrikh Mayur Ananta II','Dholera Admin','info@dholerabyus.in','8059982049','2000-09-12','Morning','','pending','2026-03-07 07:33:21'),
(7,2,'Mirrikh Mayur Ananta II','Dholera Admin','info@dholerabyus.in','8059982049','2000-09-12','Morning','','pending','2026-03-07 07:38:52'),
(8,2,'Mirrikh Mayur Ananta II','Dholera Admin','info@dholerabyus.in','8059982049','2000-09-12','Morning','','pending','2026-03-07 07:42:37');
/*!40000 ALTER TABLE `site_visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smtp_config`
--

DROP TABLE IF EXISTS `smtp_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `smtp_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` varchar(10) NOT NULL,
  `smtp_user` varchar(255) NOT NULL,
  `smtp_pass` varchar(255) NOT NULL,
  `smtp_encryption` enum('none','ssl','tls') DEFAULT 'tls',
  `from_email` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smtp_config`
--

LOCK TABLES `smtp_config` WRITE;
/*!40000 ALTER TABLE `smtp_config` DISABLE KEYS */;
INSERT INTO `smtp_config` VALUES
(1,'','','','','tls','','Dholera Smart City','2026-03-23 08:07:12');
/*!40000 ALTER TABLE `smtp_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'jhdindus_dholera'
--

--
-- Dumping routines for database 'jhdindus_dholera'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-30  2:40:29
