-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: laravel-shop
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (1,0,1,'后台首页','fa-tachometer','/',NULL,NULL,'2020-03-16 17:05:39'),(2,0,6,'系统管理','fa-cogs',NULL,NULL,NULL,'2020-03-16 16:54:48'),(3,2,7,'用户管理','fa-users','auth/users',NULL,NULL,'2020-03-16 16:53:30'),(4,2,8,'角色管理','fa-user','auth/roles',NULL,NULL,'2020-03-16 16:53:30'),(5,2,9,'权限管理','fa-ban','auth/permissions',NULL,NULL,'2020-03-16 16:53:30'),(6,2,10,'菜单管理','fa-bars','auth/menu',NULL,NULL,'2020-03-16 16:53:30'),(7,2,11,'操作日志','fa-history','auth/logs',NULL,NULL,'2020-03-16 16:53:30'),(8,0,2,'用户管理','fa-user','/users',NULL,'2020-03-16 16:46:14','2020-03-16 16:55:39'),(9,0,3,'商品管理','fa-cube','/products',NULL,'2020-03-16 16:47:01','2020-03-16 16:55:11'),(10,0,5,'优惠券管理','fa-percent','/coupon_codes',NULL,'2020-03-16 16:49:57','2020-03-16 16:53:30'),(11,0,4,'订单管理','fa-building','/orders',NULL,'2020-03-16 16:53:22','2020-03-16 16:53:30');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'All permission','*','','*',NULL,NULL),(2,'Dashboard','dashboard','GET','/',NULL,NULL),(3,'Login','auth.login','','/auth/login\r\n/auth/logout',NULL,NULL),(4,'User setting','auth.setting','GET,PUT','/auth/setting',NULL,NULL),(5,'Auth management','auth.management','','/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs',NULL,NULL),(6,'用户管理','用户管理','','/users*','2020-03-16 17:00:28','2020-03-16 17:00:28'),(7,'商品管理','商品管理','','/products*','2020-03-16 17:01:00','2020-03-16 17:01:00'),(8,'优惠券管理','优惠券管理','','/coupon_codes*','2020-03-16 17:01:48','2020-03-16 17:01:48'),(9,'订单管理','订单管理','','/orders*','2020-03-16 17:02:09','2020-03-16 17:02:09');
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_menu`
--

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` VALUES (1,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_permissions`
--

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
INSERT INTO `admin_role_permissions` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL),(2,3,NULL,NULL),(2,4,NULL,NULL),(2,6,NULL,NULL),(2,7,NULL,NULL),(2,8,NULL,NULL),(2,9,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_users`
--

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'Administrator','administrator','2020-03-16 16:42:25','2020-03-16 16:42:25'),(2,'运营','operator','2020-03-16 16:58:08','2020-03-16 16:58:08');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_user_permissions`
--

LOCK TABLES `admin_user_permissions` WRITE;
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$VkPeJbVCr7zfo9E01YJn7.Jm7x7Khv3zAGydB9kTbyF/brOcijyZq','Administrator',NULL,'4yRt93p1NM0J0MZmEJcowDDCN8Yc6i4jJH8sNWb3zQbBuiTGorfFWnfCEo18','2020-03-16 16:42:25','2020-03-16 16:42:25'),(2,'operator','$2y$10$STTHNyjulRd3t4kAjocp6eyeInRbnSKvkyi/urvYjHFGY3CWBGLb6','operator','images/佐助.jpg','XbsHhddNZsdyLURvWlyzzeohhNaUwBt0hpZ6a1Z9e1oRqCdg979hYcRewHpb','2020-03-16 16:57:04','2020-03-16 16:57:04');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-16  9:10:11
