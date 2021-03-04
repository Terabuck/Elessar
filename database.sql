-- phpMiniAdmin dump 1.9.170730
-- Datetime: 2021-03-04 09:16:39
-- Host: 
-- Database: dicom_login

/*!40030 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dbemail` varchar(123) DEFAULT NULL,
  `dbuser` char(50) DEFAULT NULL,
  `dbpwd` varchar(200) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES ('7','sample@sample.com','Orthanc','32a4932c31be785fe8539786b3b1dd3c7d2aa23566823f2cf0699377527c769bcf009d664cf6836c78d306ccd08ec70f9acbfc566e9ec4f222c29126919f0db2');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


-- phpMiniAdmin dump end
