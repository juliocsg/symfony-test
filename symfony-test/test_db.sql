/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 5.7.35-log : Database - test_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `test_db`;

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `company` */

insert  into `company`(`id`,`name`) values 
(2,'Inventiva');

/*Table structure for table `company_phone_number` */

DROP TABLE IF EXISTS `company_phone_number`;

CREATE TABLE `company_phone_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `phone_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_95CC76956B01BC5B` (`phone_number`),
  KEY `IDX_95CC7695979B1AD6` (`company_id`),
  CONSTRAINT `FK_95CC7695979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `company_phone_number` */

/*Table structure for table `doctrine_migration_versions` */

DROP TABLE IF EXISTS `doctrine_migration_versions`;

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `doctrine_migration_versions` */

insert  into `doctrine_migration_versions`(`version`,`executed_at`,`execution_time`) values 
('DoctrineMigrations\\Version20211020173534','2021-10-20 19:37:44',65),
('DoctrineMigrations\\Version20211020203632','2021-10-20 22:37:31',67),
('DoctrineMigrations\\Version20211020224625','2021-10-21 00:47:07',384),
('DoctrineMigrations\\Version20211020225753','2021-10-21 00:58:21',304),
('DoctrineMigrations\\Version20211021131541','2021-10-21 15:15:47',117),
('DoctrineMigrations\\Version20211021131731','2021-10-21 15:17:36',61),
('DoctrineMigrations\\Version20211021132000','2021-10-21 15:20:07',136),
('DoctrineMigrations\\Version20211021132158','2021-10-21 15:22:03',61);

/*Table structure for table `employee` */

DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5D9F75A1217BBB47` (`person_id`),
  KEY `IDX_5D9F75A1979B1AD6` (`company_id`),
  CONSTRAINT `FK_5D9F75A1217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`),
  CONSTRAINT `FK_5D9F75A1979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `employee` */

insert  into `employee`(`id`,`company_id`,`person_id`) values 
(2,2,1),
(6,2,3);

/*Table structure for table `person` */

DROP TABLE IF EXISTS `person`;

CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_34DCD17614F702F8` (`doc_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `person` */

insert  into `person`(`id`,`first_name`,`last_name`,`doc_number`) values 
(1,'Diego','Rodriguez',4546837),
(3,'Gustavo','Rodriguez',4546838);

/*Table structure for table `person_phone_number` */

DROP TABLE IF EXISTS `person_phone_number`;

CREATE TABLE `person_phone_number` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `phone_number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880F5C166B01BC5B` (`phone_number`),
  KEY `IDX_880F5C16217BBB47` (`person_id`),
  CONSTRAINT `FK_880F5C16217BBB47` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `person_phone_number` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
