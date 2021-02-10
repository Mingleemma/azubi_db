/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.7.26-log : Database - kmadb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kmadb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;


/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(90) DEFAULT NULL,
  `module` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`roleid`,`role`,`module`) values (1,'Create User','User Management'),(2,'Add User Roles','User Management'),(3,'Edit User','User Management'),(4,'Add Customer','Customer Manangement'),(5,'Edit Customer','Customer Manangement'),(6,'Approve Customer','Allocation'),(7,'Allocate Store','Allocation'),(8,'Re-allocate Store','Allocation'),(9,'Print Certificate','Allocation'),(10,'View Reports','Reports'),(11,'Asset Management ','Asset Management '),(12,'View Payments','Payments'),(14,'Customer Search','Customer Manangement'),(15,'Block Numbers','Store Configuration'),(16,'Activate Numbers','Store Configuration'),(17,'Add Rates','Rate Configuration'),(18,'Modify Rates','Rate Configuration'),(19,'View User List','User Management'),(20,'Print Tenancy Certificate','Allocation'),(21,'Delete Allocation','Allocation'),(22,'SMS','General'),(23,'Keys','General'),(24,'Add Payments','Payments'),(25,'Generate Reports','Reports'),(26,'Incident Reporting','Incident Reporting'),(27,'View Stores','Store Configuration');

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `uid` int(11) DEFAULT NULL,
  `role` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user_roles` */

insert  into `user_roles`(`uid`,`role`) values (46,'Approve Customer'),(46,'Re-allocate Store'),(46,'Print Certificate'),(46,'Asset Management'),(46,'Add Customer'),(46,'Edit Customer'),(46,'Add Rates'),(46,'Create User'),(46,'Edit User'),(46,'Customer Search'),(46,'View User List'),(46,'Add User Roles'),(46,'Block Numbers'),(46,'Activate Numbers'),(47,'Customer Search'),(48,'Approve Customer'),(48,'Allocate Store'),(48,'Re-allocate Store'),(48,'Print Certificate'),(48,'Asset Management'),(48,'Add Customer'),(48,'Edit Customer'),(48,'Customer Search'),(48,'Add Rates'),(48,'Modify Rates'),(48,'Reports'),(48,'Block Numbers'),(48,'Activate Numbers'),(48,'Create User'),(48,'Add User Roles'),(48,'Edit User'),(48,'View User List'),(49,'Allocate Store'),(49,'Re-allocate Store'),(49,'Print Certificate'),(49,'Asset Management'),(49,'Add Customer'),(49,'Edit Customer'),(49,'Customer Search'),(49,'Payment'),(49,'Add Rates'),(49,'Modify Rates'),(49,'Reports'),(49,'Block Numbers'),(49,'Activate Numbers'),(49,'Create User'),(49,'Add User Roles'),(49,'Edit User'),(49,'View User List'),(50,'Customer Search'),(51,'Customer Search'),(52,'Customer Search'),(53,'Approve Customer'),(53,'Allocate Store'),(53,'Add Customer'),(53,'Customer Search'),(53,'View User List'),(54,'Approve Customer'),(54,'Allocate Store'),(54,'Re-allocate Store'),(54,'Print Certificate'),(54,'Add Customer'),(54,'Edit Customer'),(54,'Customer Search'),(54,'View User List'),(55,'Approve Customer'),(55,'Allocate Store'),(55,'Re-allocate Store'),(55,'Print Certificate'),(55,'Add Customer'),(55,'Edit Customer'),(55,'Customer Search'),(55,'Payment'),(55,'View User List'),(56,'Customer Search'),(49,'Approve Customer'),(46,'Allocate Store'),(57,'Customer Search'),(60,'Payment'),(46,'Print Tenancy Certificate'),(59,'Approve Customer'),(59,'Allocate Store'),(59,'Re-allocate Store'),(59,'Print Certificate'),(59,'Print Tenancy Certificate'),(59,'Asset Management'),(59,'Add Customer'),(59,'Edit Customer'),(59,'Customer Search'),(59,'Add Rates'),(59,'Modify Rates'),(59,'Block Numbers'),(59,'Activate Numbers'),(59,'Create User'),(59,'Add User Roles'),(59,'Edit User'),(59,'View User List'),(46,'Delete Allocation'),(59,'Delete Allocation'),(57,'Approve Customer'),(57,'Allocate Store'),(57,'Re-allocate Store'),(57,'Print Certificate'),(57,'Print Tenancy Certificate'),(57,'Delete Allocation'),(57,'Add Customer'),(57,'Edit Customer'),(57,'Payment'),(57,'Add Rates'),(57,'Modify Rates'),(57,'Reports'),(57,'Block Numbers'),(57,'Activate Numbers'),(57,'Create User'),(57,'Add User Roles'),(57,'Edit User'),(57,'View User List'),(63,'Approve Customer'),(63,'Allocate Store'),(63,'Re-allocate Store'),(63,'Customer Search'),(63,'Reports'),(64,'Approve Customer'),(64,'Allocate Store'),(64,'Re-allocate Store'),(64,'Print Certificate'),(64,'Print Tenancy Certificate'),(64,'Add Customer'),(64,'Edit Customer'),(64,'Customer Search'),(64,'Payment'),(64,'Add Rates'),(64,'Modify Rates'),(64,'Delete Allocation'),(48,'Delete Allocation'),(49,'Print Tenancy Certificate'),(49,'Delete Allocation'),(65,'Customer Search'),(66,'Customer Search'),(46,'Keys'),(46,'SMS'),(67,'Customer Search'),(67,'Keys'),(59,'Keys'),(59,'SMS'),(75,'Payment'),(86,'Payment'),(50,'Allocate Store'),(51,'Allocate Store'),(52,'Allocate Store'),(50,'Keys'),(51,'Keys'),(68,'Customer Search'),(68,'Keys'),(52,'Keys'),(89,'Print Certificate'),(89,'Print Tenancy Certificate'),(52,'Approve Customer'),(50,'Approve Customer'),(66,'Approve Customer'),(66,'Allocate Store'),(65,'Approve Customer'),(65,'Allocate Store'),(89,'Approve Customer'),(89,'Customer Search'),(51,'Approve Customer'),(91,'Asset Management'),(91,'Customer Search'),(91,'Payment'),(46,'View Payments'),(46,'Add Payments'),(46,'View Reports'),(46,'Generate Reports'),(59,'View Payments'),(59,'Add Payments'),(59,'View Reports'),(59,'Generate Reports'),(68,'View Payments'),(48,'View Payments'),(48,'Add Payments'),(50,'Block Numbers'),(84,'Approve Customer'),(84,'Customer Search'),(84,'View Payments'),(92,'Approve Customer'),(92,'Customer Search'),(92,'View Payments'),(93,'Approve Customer'),(93,'Customer Search'),(93,'View Payments'),(94,'Add Payments'),(94,'View Payments'),(89,'View Payments'),(89,'View Reports'),(89,'Generate Reports'),(95,'Add Payments'),(96,'Add Payments'),(67,'View Payments'),(67,'View Reports'),(97,'Add Payments'),(98,'Add Payments'),(99,'Add Payments'),(100,'Add Payments'),(101,'Asset Management'),(101,'View Reports'),(101,'Generate Reports'),(101,'Create User'),(101,'Add User Roles'),(101,'Edit User'),(101,'View User List'),(101,'Customer Search'),(101,'View Payments'),(91,'Keys'),(61,'SMS'),(61,'Keys'),(61,'View Payments'),(49,'SMS'),(49,'Keys'),(48,'View Reports'),(48,'Generate Reports'),(49,'View Reports'),(49,'Generate Reports'),(49,'View Payments'),(49,'Add Payments'),(50,'Delete Allocation'),(46,'Incident Reporting'),(48,'Incident Reporting'),(52,'Block Numbers'),(47,'View Stores');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
