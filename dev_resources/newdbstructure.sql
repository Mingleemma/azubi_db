/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.5.58 : Database - fdaregistration
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `applications` */

DROP TABLE IF EXISTS `applications`;

CREATE TABLE `applications` (
  `appid` int(11) NOT NULL AUTO_INCREMENT,
  `appname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`appid`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

/*Data for the table `applications` */

insert  into `applications`(`appid`,`appname`,`category`,`alias`) values (1,'APPLICATION FOR FOOD HYGIENE PERMIT','food','foodhygiene'),(2,'APPLICATION FOR FOOD IMPORTER REGISTRATION ','food','foodimporter'),(3,'APPLICATION FOR LICENSING OF FOOD MAUFACTURING','food','foodmanufacturing'),(4,'APPLICATION FOR THE REGISTRATION OF FOOD PRODUCT','food',NULL),(5,'APPLICATION FOR THE REGISTRATION OF IMPORTED FOOD PRODUCT','food',NULL),(6,'APPLICATION FOR WAREHOUSE LICENSING','food',NULL),(7,'APPLICATION FOR COLD STORAGE FACILITY LICENSING','food',NULL),(8,'APPLICATION FOR LICENCE AS AN IMPORTER OF COSMETICS AND HOUSEHOLD CHEMICAL SUBSTANCES','drug',NULL),(9,'APPLICATION FOR VARIATION','drug',NULL),(10,'APPLICATION FORM FOR A LICENCE TO MANUFACTURE DRUGS, COMETICS, HOUSEHOLD CHEMICAL SUBSTANCES AND MEDICAL DEVICES','drug',NULL),(11,'APPLICATION FORM FOR ADVERTISEMENT OF DRUGS AND OTHER REGULATED PRODUCTS','drug',NULL),(12,'APPLICATION FORM FOR AUTHORIZED PERSONS IN  PHARMA & CHEMICAL INDUSTRY','drug',NULL),(13,'Application Form for Blood Facility Products Listing In Ghana','drug',NULL),(14,'APPLICATION FORM FOR HOMEOPATHIC MEDICINE','drug',NULL),(15,'APPLICATION FORM FOR LICENSE AS AN IMPORTER OF MEDICAL DEVICES','drug',NULL),(16,'Application Form for Licensing Blood Facilities In Ghana','drug',NULL),(17,'APPLICATION FORM FOR LICENSING OF STORAGE FACILITIES OF   IMPORTERS, EXPORTERS, WHOLESALERS AND DISTRIBUTORS OF PHARMACEUTICAL PRODUCTS, HERBALS PRODUCTS, FOOD SUPPLEMENTS AND PHARMACEUTICAL RAW MATERIALS','drug',NULL),(18,'APPLICATION FORM FOR REGISTRATION OF DIAPERS (BABY & ADULT), SANITARY PADS AND MOP UP TOWELS','drug',NULL),(19,'APPLICATION FORM FOR THE REGISTRATION OF ALLOPATHIC DRUG CTD FORMAT','drug',NULL),(20,'APPLICATION FORM FOR THE REGISTRATION OF CLASS I MEDICAL DEVICE','drug',NULL),(21,'APPLICATION FORM FOR THE REGISTRATION OF CLASSES II -IV','drug',NULL),(22,'APPLICATION FORM FOR VARIATIONS TO A BIOLOGICAL PRODUCT','drug',NULL),(23,'COSMETIC APPLICATION','drug',NULL),(24,'DISPOSAL OF EXPIRED,DETERIORATED DRUGS, COSMETICS, HOUSEHOLD CHEMICAL SUBSTANCES OR MEDICAL DEVICE','drug',NULL),(25,'HOUSEHOLD CHEMICALS','drug',NULL),(26,'Registration Application form for Biosimilar Products','drug',NULL),(27,'Registration Application form for Innovator Biological Products','drug',NULL),(28,'Registration Application form for Vaccines','drug',NULL),(29,'REGISTRATION OF A FOOD,DIETARY , NUTRITIONAL SUPPLEMENT','drug',NULL),(30,'RENEWAL OF LICENSE FOR THE MANUFACTURE OF DRUGS, COSMETICS, MEDICAL DEVICES AND HOUSEHOLD CHEMICAL SUBSTANCES','drug',NULL),(31,'REGISTRATION OF HERBAL MEDICINAL PRODUCT ','drug',NULL),(32,'TOBACCO PRODUCT REGISTRATION','drug',NULL),(33,'TOBACCO REGISTRATION FOR IMPORTERS','drug',NULL),(34,'VETERINARY DRUG APPLICATION FORM','drug',NULL),(35,'VETERINARY SUPPLEMENT APPLICATION FORM ','drug',NULL);

/*Table structure for table `business` */

DROP TABLE IF EXISTS `business`;

CREATE TABLE `business` (
  `busid` int(11) NOT NULL AUTO_INCREMENT,
  `businessname` varchar(255) DEFAULT NULL,
  `regnumber` varchar(90) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `dateofcommencement` date DEFAULT NULL,
  `fdbclassification` varchar(90) DEFAULT NULL,
  `gtbclassification` varchar(90) DEFAULT NULL,
  `businesstype` varchar(90) DEFAULT NULL,
  `numberofworkers` int(11) DEFAULT NULL,
  `numberofshifts` int(11) DEFAULT NULL,
  `numberofkitchenstaff` int(11) DEFAULT NULL,
  `averagenumberofmeals` int(11) DEFAULT NULL,
  `nameofmanager` varchar(90) DEFAULT NULL,
  `mailingaddress` varchar(90) DEFAULT NULL,
  `location` varchar(90) DEFAULT NULL,
  `city` varchar(90) DEFAULT NULL,
  `position` varchar(90) DEFAULT NULL,
  `contactperson` varchar(90) DEFAULT NULL,
  `managertelephone` varchar(90) DEFAULT NULL,
  `region` varchar(90) DEFAULT NULL,
  `digitaladdress` varchar(90) DEFAULT NULL,
  `fax` varchar(90) DEFAULT NULL,
  `dateapplied` timestamp NULL DEFAULT NULL,
  `contacttelephone` varchar(90) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`busid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Data for the table `business` */

insert  into `business`(`busid`,`businessname`,`regnumber`,`telephone`,`email`,`dateofcommencement`,`fdbclassification`,`gtbclassification`,`businesstype`,`numberofworkers`,`numberofshifts`,`numberofkitchenstaff`,`averagenumberofmeals`,`nameofmanager`,`mailingaddress`,`location`,`city`,`position`,`contactperson`,`managertelephone`,`region`,`digitaladdress`,`fax`,`dateapplied`,`contacttelephone`,`uid`) values (10,'Prince Online','','','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','',NULL,'','',NULL,'2018-12-30 08:05:51','',2);

/*Table structure for table `business_users` */

DROP TABLE IF EXISTS `business_users`;

CREATE TABLE `business_users` (
  `uid` int(11) DEFAULT NULL,
  `busid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `business_users` */

/*Table structure for table `countrylist` */

DROP TABLE IF EXISTS `countrylist`;

CREATE TABLE `countrylist` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`country_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=741 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

/*Data for the table `countrylist` */

insert  into `countrylist`(`country_id`,`country`,`country_code`) values (495,'Andorra','AD        '),(496,'United Arab Emirates','AE        '),(497,'Afghanistan','AF        '),(498,'Antigua and Barbuda','AG        '),(499,'Anguilla','AI        '),(500,'Albania','AL        '),(501,'Armenia','AM        '),(502,'Netherlands Antilles','AN        '),(503,'Angola','AO        '),(504,'Antarctica','AQ        '),(505,'Argentina','AR        '),(506,'American Samoa','AS        '),(507,'Austria','AT        '),(508,'Australia','AU        '),(509,'Aruba','AW        '),(510,'Aland Islands','AX        '),(511,'Azerbaijan','AZ        '),(512,'Bosnia and Herzegovina','BA        '),(513,'Barbados','BB        '),(514,'Bangladesh','BD        '),(515,'Belgium','BE        '),(516,'Burkina Faso','BF        '),(517,'Bulgaria','BG        '),(518,'Bahrain','BH        '),(519,'Burundi','BI        '),(520,'Benin','BJ        '),(521,'Saint Barthelemy','BL        '),(522,'Bermuda','BM        '),(523,'Brunei Darussalam','BN        '),(524,'Bolivia','BO        '),(525,'Brazil','BR        '),(526,'Bahamas','BS        '),(527,'Bhutan','BT        '),(528,'Bouvet Island','BV        '),(529,'Botswana','BW        '),(530,'Belarus','BY        '),(531,'Belize','BZ        '),(532,'Canada','CA        '),(533,'Cocos (Keeling) Islands','CC        '),(534,'Congo, The Democratic Republic of the','CD        '),(535,'Central African Republic','CF        '),(536,'Congo','CG        '),(537,'Switzerland','CH        '),(538,'Cote DIvoire','CI        '),(539,'Cook Islands','CK        '),(540,'Chile','CL        '),(541,'Cameroon','CM        '),(542,'China','CN        '),(543,'Colombia','CO        '),(544,'Costa Rica','CR        '),(545,'Cuba','CU        '),(546,'Cape Verde','CV        '),(547,'Christmas Island','CX        '),(548,'Cyprus','CY        '),(549,'Czech Republic','CZ        '),(550,'Germany','DE        '),(551,'Djibouti','DJ        '),(552,'Denmark','DK        '),(553,'Dominica','DM        '),(554,'Dominican Republic','DO        '),(555,'Algeria','DZ        '),(556,'Ecuador','EC        '),(557,'Estonia','EE        '),(558,'Egypt','EG        '),(559,'Western Sahara','EH        '),(560,'Eritrea','ER        '),(561,'Spain','ES        '),(562,'Ethiopia','ET        '),(563,'Finland','FI        '),(564,'Fiji','FJ        '),(565,'Falkland Islands (Malvinas)','FK        '),(566,'Micronesia, Federated States of','FM        '),(567,'Faroe Islands','FO        '),(568,'France','FR        '),(569,'Gabon','GA        '),(570,'United Kingdom','GB        '),(571,'Grenada','GD        '),(572,'Georgia','GE        '),(573,'French Guiana','GF        '),(574,'Guernsey','GG        '),(575,'Ghana','GH        '),(576,'Gibraltar','GI        '),(577,'Greenland','GL        '),(578,'Gambia','GM        '),(579,'Guinea','GN        '),(580,'Guadeloupe','GP        '),(581,'Equatorial Guinea','GQ        '),(582,'Greece','GR        '),(583,'South Georgia and the South Sandwich Islands','GS        '),(584,'Guatemala','GT        '),(585,'Guam','GU        '),(586,'Guinea-Bissau','GW        '),(587,'Guyana','GY        '),(588,'Hong Kong','HK        '),(589,'Heard Island and McDonald Islands','HM        '),(590,'Honduras','HN        '),(591,'Croatia','HR        '),(592,'Haiti','HT        '),(593,'Hungary','HU        '),(594,'Indonesia','ID        '),(595,'Ireland','IE        '),(596,'Israel','IL        '),(597,'Isle of Man','IM        '),(598,'India','IN        '),(599,'British Indian Ocean Territory','IO        '),(600,'Iraq','IQ        '),(601,'Iran, Islamic Republic of','IR        '),(602,'Iceland','IS        '),(603,'Italy','IT        '),(604,'Jersey','JE        '),(605,'Jamaica','JM        '),(606,'Jordan','JO        '),(607,'Japan','JP        '),(608,'Kenya','KE        '),(609,'Kyrgyzstan','KG        '),(610,'Cambodia','KH        '),(611,'Kiribati','KI        '),(612,'Comoros','KM        '),(613,'Saint Kitts and Nevis','KN        '),(614,'Korea, Democratic Peoples Republic of','KP        '),(615,'Korea, Republic of','KR        '),(616,'Kuwait','KW        '),(617,'Cayman Islands','KY        '),(618,'Kazakhstan','KZ        '),(619,'Lao Peoples Democratic Republic','LA        '),(620,'Lebanon','LB        '),(621,'Saint Lucia','LC        '),(622,'Liechtenstein','LI        '),(623,'Sri Lanka','LK        '),(624,'Liberia','LR        '),(625,'Lesotho','LS        '),(626,'Lithuania','LT        '),(627,'Luxembourg','LU        '),(628,'Latvia','LV        '),(629,'Libyan Arab Jamahiriya','LY        '),(630,'Morocco','MA        '),(631,'Monaco','MC        '),(632,'Moldova, Republic of','MD        '),(633,'Montenegro','ME        '),(634,'Saint Martin','MF        '),(635,'Madagascar','MG        '),(636,'Marshall Islands','MH        '),(637,'Macedonia, The Former Yugoslav Republic of','MK        '),(638,'Mali','ML        '),(639,'Myanmar','MM        '),(640,'Mongolia','MN        '),(641,'Macao','MO        '),(642,'Northern Mariana Islands','MP        '),(643,'Martinique','MQ        '),(644,'Mauritania','MR        '),(645,'Montserrat','MS        '),(646,'Malta','MT        '),(647,'Mauritius','MU        '),(648,'Maldives','MV        '),(649,'Malawi','MW        '),(650,'Mexico','MX        '),(651,'Malaysia','MY        '),(652,'Mozambique','MZ        '),(653,'Namibia','NA        '),(654,'New Caledonia','NC        '),(655,'Niger','NE        '),(656,'Norfolk Island','NF        '),(657,'Nigeria','NG        '),(658,'Nicaragua','NI        '),(659,'Netherlands','NL        '),(660,'Norway','NO        '),(661,'Nepal','NP        '),(662,'Nauru','NR        '),(663,'Niue','NU        '),(664,'New Zealand','NZ        '),(665,'Oman','OM        '),(666,'Panama','PA        '),(667,'Peru','PE        '),(668,'French Polynesia','PF        '),(669,'Papua New Guinea','PG        '),(670,'Philippines','PH        '),(671,'Pakistan','PK        '),(672,'Poland','PL        '),(673,'Saint Pierre and Miquelon','PM        '),(674,'Pitcairn','PN        '),(675,'Puerto Rico','PR        '),(676,'Palestinian Territory, Occupied','PS        '),(677,'Portugal','PT        '),(678,'Palau','PW        '),(679,'Paraguay','PY        '),(680,'Qatar','QA        '),(681,'Reunion','RE        '),(682,'Romania','RO        '),(683,'Serbia','RS        '),(684,'Russian Federation','RU        '),(685,'Rwanda','RW        '),(686,'Saudi Arabia','SA        '),(687,'Solomon Islands','SB        '),(688,'Seychelles','SC        '),(689,'Sudan','SD        '),(690,'Sweden','SE        '),(691,'Singapore','SG        '),(692,'Saint Helena','SH        '),(693,'Slovenia','SI        '),(694,'Svalbard and Jan Mayen','SJ        '),(695,'Slovakia','SK        '),(696,'Sierra Leone','SL        '),(697,'San Marino','SM        '),(698,'Senegal','SN        '),(699,'Somalia','SO        '),(700,'Suriname','SR        '),(701,'Sao Tome and Principe','ST        '),(702,'El Salvador','SV        '),(703,'Syrian Arab Republic','SY        '),(704,'Swaziland','SZ        '),(705,'Turks and Caicos Islands','TC        '),(706,'Chad','TD        '),(707,'French Southern Territories','TF        '),(708,'Togo','TG        '),(709,'Thailand','TH        '),(710,'Tajikistan','TJ        '),(711,'Tokelau','TK        '),(712,'Timor-Leste','TL        '),(713,'Turkmenistan','TM        '),(714,'Tunisia','TN        '),(715,'Tonga','TO        '),(716,'Turkey','TR        '),(717,'Trinidad and Tobago','TT        '),(718,'Tuvalu','TV        '),(719,'Taiwan, Province Of China','TW        '),(720,'Tanzania, United Republic of','TZ        '),(721,'Ukraine','UA        '),(722,'Uganda','UG        '),(723,'United States Minor Outlying Islands','UM        '),(724,'United States','US        '),(725,'Uruguay','UY        '),(726,'Uzbekistan','UZ        '),(727,'Holy See (Vatican City State)','VA        '),(728,'Saint Vincent and the Grenadines','VC        '),(729,'Venezuela','VE        '),(730,'Virgin Islands, British','VG        '),(731,'Virgin Islands, U.S.','VI        '),(732,'Viet Nam','VN        '),(733,'Vanuatu','VU        '),(734,'Wallis And Futuna','WF        '),(735,'Samoa','WS        '),(736,'Yemen','YE        '),(737,'Mayotte','YT        '),(738,'South Africa','ZA        '),(739,'Zambia','ZM        '),(740,'Zimbabwe','ZW        ');

/*Table structure for table `dishes` */

DROP TABLE IF EXISTS `dishes`;

CREATE TABLE `dishes` (
  `dishname` varchar(90) DEFAULT NULL,
  `busid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `dishes` */

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `newname` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `randomnumber` varchar(100) DEFAULT NULL,
  `docdate` varchar(50) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`did`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

/*Data for the table `documents` */

insert  into `documents`(`did`,`name`,`newname`,`size`,`type`,`randomnumber`,`docdate`,`uid`) values (7,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',36),(8,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',47),(9,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',48),(10,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',49),(11,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',50),(12,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',51),(13,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',52),(14,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',53),(15,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',54),(16,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',55),(17,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',56),(18,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',57),(19,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',58),(20,'Curriculum Vitae of Mr Amponsah Shadrach Yaw alt.docx','5bfe225dedeb0.docx','24677','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-11-28',59),(21,'carols outline.docx','5c1b5bfabe0f6.docx','13104','application/vnd.openxmlformats-officedocument.wordprocessingml.document',NULL,'2018-12-20',88);

/*Table structure for table `equipment` */

DROP TABLE IF EXISTS `equipment`;

CREATE TABLE `equipment` (
  `equipment` varchar(90) DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `busid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `equipment` */

/*Table structure for table `establishment` */

DROP TABLE IF EXISTS `establishment`;

CREATE TABLE `establishment` (
  `nameofestablishment` varchar(90) DEFAULT NULL,
  `location` varchar(90) DEFAULT NULL,
  `address` varchar(90) DEFAULT NULL,
  `city` varchar(90) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `region` varchar(90) DEFAULT NULL,
  `contactperson` varchar(90) DEFAULT NULL,
  `position` varchar(90) DEFAULT NULL,
  `busid` int(11) DEFAULT NULL,
  `esid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`esid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `establishment` */

/*Table structure for table `foodservices` */

DROP TABLE IF EXISTS `foodservices`;

CREATE TABLE `foodservices` (
  `foodservice` varchar(90) DEFAULT NULL,
  `busid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `foodservices` */

/*Table structure for table `hygiene` */

DROP TABLE IF EXISTS `hygiene`;

CREATE TABLE `hygiene` (
  `methodofpreparation` varchar(90) DEFAULT NULL,
  `styleofservice` varchar(90) DEFAULT NULL,
  `sourceofwater` varchar(90) DEFAULT NULL,
  `typeofwatertreatment` varchar(90) DEFAULT NULL,
  `transportation` varchar(255) DEFAULT NULL,
  `hotcold` varchar(255) DEFAULT NULL,
  `cateringdescription` varchar(255) DEFAULT NULL,
  `methodofsolidwaste` varchar(255) DEFAULT NULL,
  `methodofliquidwaste` varchar(255) DEFAULT NULL,
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `busid` int(11) DEFAULT NULL,
  PRIMARY KEY (`hid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `hygiene` */

/*Table structure for table `hygiene_personel` */

DROP TABLE IF EXISTS `hygiene_personel`;

CREATE TABLE `hygiene_personel` (
  `position` varchar(90) DEFAULT NULL,
  `qualification` varchar(90) DEFAULT NULL,
  `yearsofexperience` varchar(90) DEFAULT NULL,
  `busid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `hygiene_personel` */

/*Table structure for table `logcategories` */

DROP TABLE IF EXISTS `logcategories`;

CREATE TABLE `logcategories` (
  `logcategory` varchar(32) NOT NULL,
  PRIMARY KEY (`logcategory`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `logcategories` */

insert  into `logcategories`(`logcategory`) values ('administrator action'),('customer action'),('information'),('system - general'),('system - scheduled');

/*Table structure for table `rawmaterials` */

DROP TABLE IF EXISTS `rawmaterials`;

CREATE TABLE `rawmaterials` (
  `materialtype` varchar(90) DEFAULT NULL,
  `materialsource` varchar(90) DEFAULT NULL,
  `busid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `rawmaterials` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(24) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`roleid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `roles` */

insert  into `roles`(`roleid`,`role`,`description`) values (1,'Administrator',NULL),(2,'Food',NULL),(3,'Drug',NULL),(4,'Finance',NULL),(5,'Regular',NULL);

/*Table structure for table `systemlog` */

DROP TABLE IF EXISTS `systemlog`;

CREATE TABLE `systemlog` (
  `idsystemlog` int(11) NOT NULL AUTO_INCREMENT,
  `logcategory` varchar(32) DEFAULT 'information',
  `user` varchar(90) DEFAULT 'unspecified',
  `logmessage` varchar(2024) DEFAULT NULL,
  `diagnostic` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logtimestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idsystemlog`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Data for the table `systemlog` */

insert  into `systemlog`(`idsystemlog`,`logcategory`,`user`,`logmessage`,`diagnostic`,`timestamp`,`logtimestamp`) values (1,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-29 15:02:04','0000-00-00 00:00:00'),(2,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-29 15:07:54','0000-00-00 00:00:00'),(3,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 07:05:04','0000-00-00 00:00:00'),(4,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 07:54:02','0000-00-00 00:00:00'),(5,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 08:23:47','0000-00-00 00:00:00'),(6,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 08:25:41','0000-00-00 00:00:00'),(7,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 08:27:58','0000-00-00 00:00:00'),(8,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 08:28:32','0000-00-00 00:00:00'),(9,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 08:35:43','0000-00-00 00:00:00'),(10,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 08:52:06','0000-00-00 00:00:00'),(11,'information','odurusphp@gmail.com','User with roles Regular logged in.',NULL,'2018-12-30 08:52:29','0000-00-00 00:00:00');

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `users_uid` int(11) NOT NULL,
  `roles_roleid` int(11) NOT NULL,
  PRIMARY KEY (`users_uid`,`roles_roleid`) USING BTREE,
  KEY `fk_user_roles_roles1_idx` (`roles_roleid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `user_roles` */

insert  into `user_roles`(`users_uid`,`roles_roleid`) values (1,5),(2,5);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `firstname` varchar(24) DEFAULT NULL,
  `lastname` varchar(24) DEFAULT NULL,
  `randomnumber` bigint(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE KEY `uid_UNIQUE` (`uid`) USING BTREE,
  UNIQUE KEY `username_UNIQUE` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

/*Data for the table `users` */

insert  into `users`(`uid`,`email`,`password`,`status`,`fullname`,`firstname`,`lastname`,`randomnumber`,`telephone`) values (1,'yaw@yahoo.com','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,NULL,NULL),(2,'odurusphp@gmail.com','e10adc3949ba59abbe56e057f20f883e',NULL,'Prince Oduro',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
