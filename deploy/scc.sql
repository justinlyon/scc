-- MySQL dump 10.11
--
-- Host: localhost    Database: scc
-- ------------------------------------------------------
-- Server version	5.0.67

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
-- Table structure for table `g2_AccessMap`
--

DROP TABLE IF EXISTS `g2_AccessMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_AccessMap` (
  `g_accessListId` int(11) NOT NULL,
  `g_userOrGroupId` int(11) NOT NULL,
  `g_permission` int(11) NOT NULL,
  PRIMARY KEY  (`g_accessListId`,`g_userOrGroupId`),
  KEY `g2_AccessMap_83732` (`g_accessListId`),
  KEY `g2_AccessMap_48775` (`g_userOrGroupId`),
  KEY `g2_AccessMap_18058` (`g_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_AccessMap`
--

LOCK TABLES `g2_AccessMap` WRITE;
/*!40000 ALTER TABLE `g2_AccessMap` DISABLE KEYS */;
INSERT INTO `g2_AccessMap` VALUES (9,4,7),(10,4,7),(12,4,12295),(14,4,28679),(8,6,2147483647),(9,6,2147483647),(10,3,2147483647),(10,6,2147483647),(12,3,2147483647),(12,6,2147483647),(14,3,2147483647),(14,6,2147483647);
/*!40000 ALTER TABLE `g2_AccessMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_AccessSubscriberMap`
--

DROP TABLE IF EXISTS `g2_AccessSubscriberMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_AccessSubscriberMap` (
  `g_itemId` int(11) NOT NULL,
  `g_accessListId` int(11) NOT NULL,
  PRIMARY KEY  (`g_itemId`),
  KEY `g2_AccessSubscriberMap_83732` (`g_accessListId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_AccessSubscriberMap`
--

LOCK TABLES `g2_AccessSubscriberMap` WRITE;
/*!40000 ALTER TABLE `g2_AccessSubscriberMap` DISABLE KEYS */;
INSERT INTO `g2_AccessSubscriberMap` VALUES (7,14);
/*!40000 ALTER TABLE `g2_AccessSubscriberMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_AlbumItem`
--

DROP TABLE IF EXISTS `g2_AlbumItem`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_AlbumItem` (
  `g_id` int(11) NOT NULL,
  `g_theme` varchar(32) default NULL,
  `g_orderBy` varchar(128) default NULL,
  `g_orderDirection` varchar(32) default NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_AlbumItem`
--

LOCK TABLES `g2_AlbumItem` WRITE;
/*!40000 ALTER TABLE `g2_AlbumItem` DISABLE KEYS */;
INSERT INTO `g2_AlbumItem` VALUES (7,'','','asc');
/*!40000 ALTER TABLE `g2_AlbumItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_AnimationItem`
--

DROP TABLE IF EXISTS `g2_AnimationItem`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_AnimationItem` (
  `g_id` int(11) NOT NULL,
  `g_width` int(11) default NULL,
  `g_height` int(11) default NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_AnimationItem`
--

LOCK TABLES `g2_AnimationItem` WRITE;
/*!40000 ALTER TABLE `g2_AnimationItem` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_AnimationItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_CacheMap`
--

DROP TABLE IF EXISTS `g2_CacheMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_CacheMap` (
  `g_key` varchar(32) NOT NULL,
  `g_value` longtext,
  `g_userId` int(11) NOT NULL,
  `g_itemId` int(11) NOT NULL,
  `g_type` varchar(32) NOT NULL,
  `g_timestamp` int(11) NOT NULL,
  `g_isEmpty` int(1) default NULL,
  PRIMARY KEY  (`g_key`,`g_userId`,`g_itemId`,`g_type`),
  KEY `g2_CacheMap_75985` (`g_itemId`),
  KEY `g2_CacheMap_21979` (`g_userId`,`g_timestamp`,`g_isEmpty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_CacheMap`
--

LOCK TABLES `g2_CacheMap` WRITE;
/*!40000 ALTER TABLE `g2_CacheMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_CacheMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_ChildEntity`
--

DROP TABLE IF EXISTS `g2_ChildEntity`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_ChildEntity` (
  `g_id` int(11) NOT NULL,
  `g_parentId` int(11) NOT NULL,
  PRIMARY KEY  (`g_id`),
  KEY `g2_ChildEntity_52718` (`g_parentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_ChildEntity`
--

LOCK TABLES `g2_ChildEntity` WRITE;
/*!40000 ALTER TABLE `g2_ChildEntity` DISABLE KEYS */;
INSERT INTO `g2_ChildEntity` VALUES (7,0);
/*!40000 ALTER TABLE `g2_ChildEntity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_Comment`
--

DROP TABLE IF EXISTS `g2_Comment`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_Comment` (
  `g_id` int(11) NOT NULL,
  `g_commenterId` int(11) NOT NULL,
  `g_host` varchar(128) NOT NULL,
  `g_subject` varchar(128) default NULL,
  `g_comment` text,
  `g_date` int(11) NOT NULL,
  `g_author` varchar(128) default NULL,
  `g_publishStatus` int(11) NOT NULL default '0',
  PRIMARY KEY  (`g_id`),
  KEY `g2_Comment_95610` (`g_date`),
  KEY `g2_Comment_70722` (`g_publishStatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_Comment`
--

LOCK TABLES `g2_Comment` WRITE;
/*!40000 ALTER TABLE `g2_Comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_Comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_DataItem`
--

DROP TABLE IF EXISTS `g2_DataItem`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_DataItem` (
  `g_id` int(11) NOT NULL,
  `g_mimeType` varchar(128) default NULL,
  `g_size` int(11) default NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_DataItem`
--

LOCK TABLES `g2_DataItem` WRITE;
/*!40000 ALTER TABLE `g2_DataItem` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_DataItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_Derivative`
--

DROP TABLE IF EXISTS `g2_Derivative`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_Derivative` (
  `g_id` int(11) NOT NULL,
  `g_derivativeSourceId` int(11) NOT NULL,
  `g_derivativeOperations` varchar(255) default NULL,
  `g_derivativeOrder` int(11) NOT NULL,
  `g_derivativeSize` int(11) default NULL,
  `g_derivativeType` int(11) NOT NULL,
  `g_mimeType` varchar(128) NOT NULL,
  `g_postFilterOperations` varchar(255) default NULL,
  `g_isBroken` int(1) default NULL,
  PRIMARY KEY  (`g_id`),
  KEY `g2_Derivative_85338` (`g_derivativeSourceId`),
  KEY `g2_Derivative_25243` (`g_derivativeOrder`),
  KEY `g2_Derivative_97216` (`g_derivativeType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_Derivative`
--

LOCK TABLES `g2_Derivative` WRITE;
/*!40000 ALTER TABLE `g2_Derivative` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_Derivative` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_DerivativeImage`
--

DROP TABLE IF EXISTS `g2_DerivativeImage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_DerivativeImage` (
  `g_id` int(11) NOT NULL,
  `g_width` int(11) default NULL,
  `g_height` int(11) default NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_DerivativeImage`
--

LOCK TABLES `g2_DerivativeImage` WRITE;
/*!40000 ALTER TABLE `g2_DerivativeImage` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_DerivativeImage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_DerivativePrefsMap`
--

DROP TABLE IF EXISTS `g2_DerivativePrefsMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_DerivativePrefsMap` (
  `g_itemId` int(11) default NULL,
  `g_order` int(11) default NULL,
  `g_derivativeType` int(11) default NULL,
  `g_derivativeOperations` varchar(255) default NULL,
  KEY `g2_DerivativePrefsMap_75985` (`g_itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_DerivativePrefsMap`
--

LOCK TABLES `g2_DerivativePrefsMap` WRITE;
/*!40000 ALTER TABLE `g2_DerivativePrefsMap` DISABLE KEYS */;
INSERT INTO `g2_DerivativePrefsMap` VALUES (7,0,1,'thumbnail|150'),(7,0,2,'scale|640');
/*!40000 ALTER TABLE `g2_DerivativePrefsMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_DescendentCountsMap`
--

DROP TABLE IF EXISTS `g2_DescendentCountsMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_DescendentCountsMap` (
  `g_userId` int(11) NOT NULL,
  `g_itemId` int(11) NOT NULL,
  `g_descendentCount` int(11) NOT NULL,
  PRIMARY KEY  (`g_userId`,`g_itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_DescendentCountsMap`
--

LOCK TABLES `g2_DescendentCountsMap` WRITE;
/*!40000 ALTER TABLE `g2_DescendentCountsMap` DISABLE KEYS */;
INSERT INTO `g2_DescendentCountsMap` VALUES (5,7,0);
/*!40000 ALTER TABLE `g2_DescendentCountsMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_Entity`
--

DROP TABLE IF EXISTS `g2_Entity`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_Entity` (
  `g_id` int(11) NOT NULL,
  `g_creationTimestamp` int(11) NOT NULL,
  `g_isLinkable` int(1) NOT NULL,
  `g_linkId` int(11) default NULL,
  `g_modificationTimestamp` int(11) NOT NULL,
  `g_serialNumber` int(11) NOT NULL,
  `g_entityType` varchar(32) NOT NULL,
  `g_onLoadHandlers` varchar(128) default NULL,
  PRIMARY KEY  (`g_id`),
  KEY `g2_Entity_76255` (`g_creationTimestamp`),
  KEY `g2_Entity_35978` (`g_isLinkable`),
  KEY `g2_Entity_44738` (`g_linkId`),
  KEY `g2_Entity_63025` (`g_modificationTimestamp`),
  KEY `g2_Entity_60702` (`g_serialNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_Entity`
--

LOCK TABLES `g2_Entity` WRITE;
/*!40000 ALTER TABLE `g2_Entity` DISABLE KEYS */;
INSERT INTO `g2_Entity` VALUES (1,1281495322,0,NULL,1281495322,1,'GalleryEntity',NULL),(2,1281495322,0,NULL,1281495322,1,'GalleryGroup',NULL),(3,1281495322,0,NULL,1281495322,1,'GalleryGroup',NULL),(4,1281495322,0,NULL,1281495322,1,'GalleryGroup',NULL),(5,1281495322,0,NULL,1281495322,1,'GalleryUser',NULL),(6,1281495322,0,NULL,1281495322,1,'GalleryUser',NULL),(7,1281495322,0,NULL,1281495322,1,'GalleryAlbumItem',NULL),(11,1281495352,0,NULL,1281495352,1,'GalleryEntity',NULL),(13,1281495353,0,NULL,1281495353,1,'GalleryEntity',NULL);
/*!40000 ALTER TABLE `g2_Entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_EventLogMap`
--

DROP TABLE IF EXISTS `g2_EventLogMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_EventLogMap` (
  `g_id` int(11) NOT NULL,
  `g_userId` int(11) default NULL,
  `g_type` varchar(32) default NULL,
  `g_summary` varchar(255) default NULL,
  `g_details` text,
  `g_location` varchar(255) default NULL,
  `g_client` varchar(128) default NULL,
  `g_timestamp` int(11) NOT NULL,
  `g_referer` varchar(128) default NULL,
  PRIMARY KEY  (`g_id`),
  KEY `g2_EventLogMap_24286` (`g_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_EventLogMap`
--

LOCK TABLES `g2_EventLogMap` WRITE;
/*!40000 ALTER TABLE `g2_EventLogMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_EventLogMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_ExifPropertiesMap`
--

DROP TABLE IF EXISTS `g2_ExifPropertiesMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_ExifPropertiesMap` (
  `g_property` varchar(128) default NULL,
  `g_viewMode` int(11) default NULL,
  `g_sequence` int(11) default NULL,
  UNIQUE KEY `g_property` (`g_property`,`g_viewMode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_ExifPropertiesMap`
--

LOCK TABLES `g2_ExifPropertiesMap` WRITE;
/*!40000 ALTER TABLE `g2_ExifPropertiesMap` DISABLE KEYS */;
INSERT INTO `g2_ExifPropertiesMap` VALUES ('Make',1,0),('Model',1,1),('ApertureValue',1,2),('ColorSpace',1,3),('ExposureBiasValue',1,4),('ExposureProgram',1,5),('Flash',1,6),('FocalLength',1,7),('ISO',1,8),('MeteringMode',1,9),('ShutterSpeedValue',1,10),('DateTime',1,11),('IPTC/Caption',1,12),('IPTC/CopyrightNotice',1,13),('Make',2,0),('Model',2,1),('ApertureValue',2,2),('ColorSpace',2,3),('ExposureBiasValue',2,4),('ExposureProgram',2,5),('Flash',2,6),('FocalLength',2,7),('ISO',2,8),('MeteringMode',2,9),('ShutterSpeedValue',2,10),('DateTime',2,11),('IPTC/Caption',2,12),('IPTC/CopyrightNotice',2,13),('IPTC/Keywords',2,14),('ImageType',2,15),('Orientation',2,16),('PhotoshopSettings',2,17),('ResolutionUnit',2,18),('xResolution',2,19),('yResolution',2,20),('Compression',2,21),('BrightnessValue',2,22),('Contrast',2,23),('ExposureMode',2,24),('FlashEnergy',2,25),('Saturation',2,26),('SceneType',2,27),('Sharpness',2,28),('SubjectDistance',2,29);
/*!40000 ALTER TABLE `g2_ExifPropertiesMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_ExternalIdMap`
--

DROP TABLE IF EXISTS `g2_ExternalIdMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_ExternalIdMap` (
  `g_externalId` varchar(128) NOT NULL,
  `g_entityType` varchar(32) NOT NULL,
  `g_entityId` int(11) NOT NULL,
  PRIMARY KEY  (`g_externalId`,`g_entityType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_ExternalIdMap`
--

LOCK TABLES `g2_ExternalIdMap` WRITE;
/*!40000 ALTER TABLE `g2_ExternalIdMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_ExternalIdMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_FactoryMap`
--

DROP TABLE IF EXISTS `g2_FactoryMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_FactoryMap` (
  `g_classType` varchar(128) default NULL,
  `g_className` varchar(128) default NULL,
  `g_implId` varchar(128) default NULL,
  `g_implPath` varchar(128) default NULL,
  `g_implModuleId` varchar(128) default NULL,
  `g_hints` varchar(255) default NULL,
  `g_orderWeight` varchar(255) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_FactoryMap`
--

LOCK TABLES `g2_FactoryMap` WRITE;
/*!40000 ALTER TABLE `g2_FactoryMap` DISABLE KEYS */;
INSERT INTO `g2_FactoryMap` VALUES ('GalleryEntity','GalleryEntity','GalleryEntity','modules/core/classes/GalleryEntity.class','core','N;','4'),('GalleryEntity','GalleryChildEntity','GalleryChildEntity','modules/core/classes/GalleryChildEntity.class','core','N;','4'),('GalleryEntity','GalleryAlbumItem','GalleryAlbumItem','modules/core/classes/GalleryAlbumItem.class','core','N;','4'),('GalleryEntity','GalleryUser','GalleryUser','modules/core/classes/GalleryUser.class','core','N;','4'),('GalleryEntity','GalleryGroup','GalleryGroup','modules/core/classes/GalleryGroup.class','core','N;','4'),('GalleryEntity','GalleryDerivative','GalleryDerivative','modules/core/classes/GalleryDerivative.class','core','N;','4'),('GalleryEntity','GalleryDerivativeImage','GalleryDerivativeImage','modules/core/classes/GalleryDerivativeImage.class','core','N;','4'),('GalleryDerivative','GalleryDerivativeImage','GalleryDerivativeImage','modules/core/classes/GalleryDerivativeImage.class','core','a:1:{i:0;s:1:\"*\";}','4'),('GalleryEntity','GalleryMovieItem','GalleryMovieItem','modules/core/classes/GalleryMovieItem.class','core','N;','4'),('GalleryEntity','GalleryAnimationItem','GalleryAnimationItem','modules/core/classes/GalleryAnimationItem.class','core','N;','4'),('GalleryEntity','GalleryPhotoItem','GalleryPhotoItem','modules/core/classes/GalleryPhotoItem.class','core','N;','4'),('GalleryEntity','GalleryUnknownItem','GalleryUnknownItem','modules/core/classes/GalleryUnknownItem.class','core','N;','4'),('GalleryItem','GalleryPhotoItem','GalleryPhotoItem','modules/core/classes/GalleryPhotoItem.class','core','a:2:{i:0;s:7:\"image/*\";i:1;s:21:\"application/photoshop\";}','4'),('GalleryItem','GalleryMovieItem','GalleryMovieItem','modules/core/classes/GalleryMovieItem.class','core','a:1:{i:0;s:7:\"video/*\";}','4'),('GalleryItem','GalleryAnimationItem','GalleryAnimationItem','modules/core/classes/GalleryAnimationItem.class','core','a:2:{i:0;s:22:\"application/x-director\";i:1;s:29:\"application/x-shockwave-flash\";}','4'),('GalleryItem','GalleryUnknownItem','GalleryUnknownItem','modules/core/classes/GalleryUnknownItem.class','core','a:1:{i:0;s:1:\"*\";}','4'),('GalleryDynamicAlbum','GalleryDynamicAlbum','GalleryDynamicAlbum','modules/core/classes/GalleryDynamicAlbum.class','core','N;','4'),('GallerySearchInterface_1_0','GalleryCoreSearch','GalleryCoreSearch','modules/core/classes/GalleryCoreSearch.class','core','N;','4'),('ItemEditPlugin','ItemEditItem','ItemEditItem','modules/core/ItemEditItem.inc','core','N;','1'),('ItemEditPlugin','ItemEditAnimation','ItemEditAnimation','modules/core/ItemEditAnimation.inc','core','N;','2'),('ItemEditPlugin','ItemEditMovie','ItemEditMovie','modules/core/ItemEditMovie.inc','core','N;','2'),('ItemEditPlugin','ItemEditAlbum','ItemEditAlbum','modules/core/ItemEditAlbum.inc','core','N;','2'),('ItemEditPlugin','ItemEditTheme','ItemEditTheme','modules/core/ItemEditTheme.inc','core','N;','3'),('ItemEditPlugin','ItemEditPhoto','ItemEditPhoto','modules/core/ItemEditPhoto.inc','core','N;','2'),('ItemEditPlugin','ItemEditRotateAndScalePhoto','ItemEditRotateAndScalePhoto','modules/core/ItemEditRotateAndScalePhoto.inc','core','N;','3'),('ItemEditPlugin','ItemEditPhotoThumbnail','ItemEditPhotoThumbnail','modules/core/ItemEditPhotoThumbnail.inc','core','N;','4'),('ItemAddPlugin','ItemAddFromBrowser','ItemAddFromBrowser','modules/core/ItemAddFromBrowser.inc','core','N;','2'),('ItemAddOption','CreateThumbnailOption','CreateThumbnailOption','modules/core/CreateThumbnailOption.inc','core','N;','8'),('MaintenanceTask','OptimizeDatabaseTask','OptimizeDatabaseTask','modules/core/classes/OptimizeDatabaseTask.class','core','N;','4'),('MaintenanceTask','DatabaseBackupTask','DatabaseBackupTask','modules/core/classes/DatabaseBackupTask.class','core','N;','4'),('MaintenanceTask','FlushTemplatesTask','FlushTemplatesTask','modules/core/classes/FlushTemplatesTask.class','core','N;','4'),('MaintenanceTask','FlushDatabaseCacheTask','FlushDatabaseCacheTask','modules/core/classes/FlushDatabaseCacheTask.class','core','N;','4'),('MaintenanceTask','BuildDerivativesTask','BuildDerivativesTask','modules/core/classes/BuildDerivativesTask.class','core','N;','4'),('MaintenanceTask','ResetViewCountsTask','ResetViewCountsTask','modules/core/classes/ResetViewCountsTask.class','core','N;','4'),('MaintenanceTask','SystemInfoTask','SystemInfoTask','modules/core/classes/SystemInfoTask.class','core','N;','4'),('MaintenanceTask','SetOriginationTimestampTask','SetOriginationTimestampTask','modules/core/classes/SetOriginationTimestampTask.class','core','N;','4'),('MaintenanceTask','DeleteSessionsTask','DeleteSessionsTask','modules/core/classes/DeleteSessionsTask.class','core','N;','4'),('MaintenanceTask','ConvertDatabaseToUtf8Task','ConvertDatabaseToUtf8Task','modules/core/classes/ConvertDatabaseToUtf8Task.class','core','N;','4'),('CaptchaAdminOption','CoreCaptchaAdminOption','CoreCaptchaAdminOption','modules/core/classes/CoreCaptchaAdminOption.class','core','N;','4'),('GalleryAuthPlugin','SessionAuthPlugin','SessionAuthPlugin','modules/core/classes/GallerySession.class','core','N;','4'),('GalleryEventListener','GalleryItemHelper_medium','GalleryItemHelper_medium','modules/core/classes/helpers/GalleryItemHelper_medium.class','core','a:4:{i:0;s:27:\"gallery::viewabletreechange\";i:1;s:25:\"gallery::removepermission\";i:2;s:19:\"galleryentity::save\";i:3;s:21:\"galleryentity::delete\";}','4'),('GalleryEventListener','GalleryUserHelper_medium','GalleryUserHelper_medium','modules/core/classes/helpers/GalleryUserHelper_medium.class','core','a:2:{i:0;s:20:\"gallery::failedlogin\";i:1;s:14:\"gallery::login\";}','4'),('GalleryToolkit','ArchiveExtractToolkit','ArchiveUpload','modules/archiveupload/classes/ArchiveExtractToolkit.class','archiveupload','N;','5'),('GalleryEventListener','GalleryCommentHelper','GalleryCommentHelper','modules/comment/classes/GalleryCommentHelper.class','comment','a:2:{i:0;s:21:\"galleryentity::delete\";i:1;s:19:\"galleryentity::save\";}','5'),('GalleryEntity','GalleryComment','GalleryComment','modules/comment/classes/GalleryComment.class','comment','N;','5'),('GallerySearchInterface_1_0','GalleryCommentSearch','comment','modules/comment/classes/GalleryCommentSearch.class','comment','N;','5'),('CaptchaAdminOption','CommentCaptchaAdminOption','CommentCaptchaAdminOption','modules/comment/classes/CommentCaptchaAdminOption.class','comment','N;','5'),('NotificationEvent_1_0','CommentAddNotification','CommentAddNotification','modules/comment/classes/CommentAddNotification.class','comment','a:1:{i:0;s:19:\"galleryentity::save\";}','5'),('ExifInterface_1_0','ExifExtractor','Exif','modules/exif/classes/ExifExtractor.class','exif','N;','5'),('GalleryToolkit','ExifToolkit','Exif','modules/exif/classes/ExifToolkit.class','exif','N;','5'),('ItemAddOption','ExifDescriptionOption','ExifDescriptionOption','modules/exif/ExifDescriptionOption.inc','exif','N;','5'),('IconsInterface_1_0','IconsImpl','Icons','modules/icons/classes/IconsImpl.class','icons','N;','5'),('GalleryToolkit','ImageMagickToolkit','ImageMagick','modules/imagemagick/classes/ImageMagickToolkit.class','imagemagick','N;','5'),('GalleryToolkit','NetPbmToolkit','NetPBM','modules/netpbm/classes/NetPbmToolkit.class','netpbm','N;','5'),('GalleryEventListener','RatingModule','RatingModule','modules/rating/module.inc','rating','a:1:{i:0;s:21:\"galleryentity::delete\";}','5'),('ItemEditOption','RatingItemEdit','RatingItemEdit','modules/rating/RatingItemEdit.inc','rating','a:1:{i:0;s:13:\"itemeditalbum\";}','5'),('GallerySortInterface_1_2','RatingSortOrder','RatingSortOrder','modules/rating/classes/RatingSortOrder.class','rating','N;','5'),('CartPluginInterface_1_0','ShutterflyCartPlugin','shutterfly','modules/shutterfly/classes/ShutterflyCartPlugin.class','shutterfly','N;','5'),('CartPluginInterface_1_1','ShutterflyCartPlugin','shutterfly','modules/shutterfly/classes/ShutterflyCartPlugin.class','shutterfly','N;','5'),('SlideshowInterface_1_0','SlideshowImpl','Slideshow','modules/slideshow/classes/SlideshowImpl.class','slideshow','N;','5'),('GalleryEventListener','SlideshowModule','SlideshowModule','modules/slideshow/module.inc','slideshow','a:1:{i:0;s:22:\"gallery::beforedisplay\";}','5'),('GalleryToolkit','GdToolkit','Gd','modules/gd/classes/GdToolkit.class','gd','N;','5');
/*!40000 ALTER TABLE `g2_FactoryMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_FailedLoginsMap`
--

DROP TABLE IF EXISTS `g2_FailedLoginsMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_FailedLoginsMap` (
  `g_userName` varchar(32) NOT NULL,
  `g_count` int(11) NOT NULL,
  `g_lastAttempt` int(11) NOT NULL,
  PRIMARY KEY  (`g_userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_FailedLoginsMap`
--

LOCK TABLES `g2_FailedLoginsMap` WRITE;
/*!40000 ALTER TABLE `g2_FailedLoginsMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_FailedLoginsMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_FileSystemEntity`
--

DROP TABLE IF EXISTS `g2_FileSystemEntity`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_FileSystemEntity` (
  `g_id` int(11) NOT NULL,
  `g_pathComponent` varchar(128) default NULL,
  PRIMARY KEY  (`g_id`),
  KEY `g2_FileSystemEntity_3406` (`g_pathComponent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_FileSystemEntity`
--

LOCK TABLES `g2_FileSystemEntity` WRITE;
/*!40000 ALTER TABLE `g2_FileSystemEntity` DISABLE KEYS */;
INSERT INTO `g2_FileSystemEntity` VALUES (7,NULL);
/*!40000 ALTER TABLE `g2_FileSystemEntity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_Group`
--

DROP TABLE IF EXISTS `g2_Group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_Group` (
  `g_id` int(11) NOT NULL,
  `g_groupType` int(11) NOT NULL,
  `g_groupName` varchar(128) default NULL,
  PRIMARY KEY  (`g_id`),
  UNIQUE KEY `g_groupName` (`g_groupName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_Group`
--

LOCK TABLES `g2_Group` WRITE;
/*!40000 ALTER TABLE `g2_Group` DISABLE KEYS */;
INSERT INTO `g2_Group` VALUES (2,2,'Registered Users'),(3,3,'Site Admins'),(4,4,'Everybody');
/*!40000 ALTER TABLE `g2_Group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_Item`
--

DROP TABLE IF EXISTS `g2_Item`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_Item` (
  `g_id` int(11) NOT NULL,
  `g_canContainChildren` int(1) NOT NULL,
  `g_description` text,
  `g_keywords` varchar(255) default NULL,
  `g_ownerId` int(11) NOT NULL,
  `g_renderer` varchar(128) default NULL,
  `g_summary` varchar(255) default NULL,
  `g_title` varchar(128) default NULL,
  `g_viewedSinceTimestamp` int(11) NOT NULL,
  `g_originationTimestamp` int(11) NOT NULL,
  PRIMARY KEY  (`g_id`),
  KEY `g2_Item_99070` (`g_keywords`),
  KEY `g2_Item_21573` (`g_ownerId`),
  KEY `g2_Item_54147` (`g_summary`),
  KEY `g2_Item_90059` (`g_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_Item`
--

LOCK TABLES `g2_Item` WRITE;
/*!40000 ALTER TABLE `g2_Item` DISABLE KEYS */;
INSERT INTO `g2_Item` VALUES (7,1,'This is the main page of your Gallery',NULL,6,NULL,NULL,'Gallery',1281495322,1281495322);
/*!40000 ALTER TABLE `g2_Item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_ItemAttributesMap`
--

DROP TABLE IF EXISTS `g2_ItemAttributesMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_ItemAttributesMap` (
  `g_itemId` int(11) NOT NULL,
  `g_viewCount` int(11) default NULL,
  `g_orderWeight` int(11) default NULL,
  `g_parentSequence` varchar(255) NOT NULL,
  PRIMARY KEY  (`g_itemId`),
  KEY `g2_ItemAttributesMap_95270` (`g_parentSequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_ItemAttributesMap`
--

LOCK TABLES `g2_ItemAttributesMap` WRITE;
/*!40000 ALTER TABLE `g2_ItemAttributesMap` DISABLE KEYS */;
INSERT INTO `g2_ItemAttributesMap` VALUES (7,1,0,'');
/*!40000 ALTER TABLE `g2_ItemAttributesMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_Lock`
--

DROP TABLE IF EXISTS `g2_Lock`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_Lock` (
  `g_lockId` int(11) default NULL,
  `g_readEntityId` int(11) default NULL,
  `g_writeEntityId` int(11) default NULL,
  `g_freshUntil` int(11) default NULL,
  `g_request` int(11) default NULL,
  KEY `g2_Lock_11039` (`g_lockId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_Lock`
--

LOCK TABLES `g2_Lock` WRITE;
/*!40000 ALTER TABLE `g2_Lock` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_Lock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_MaintenanceMap`
--

DROP TABLE IF EXISTS `g2_MaintenanceMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_MaintenanceMap` (
  `g_runId` int(11) NOT NULL,
  `g_taskId` varchar(128) NOT NULL,
  `g_timestamp` int(11) default NULL,
  `g_success` int(1) default NULL,
  `g_details` text,
  PRIMARY KEY  (`g_runId`),
  KEY `g2_MaintenanceMap_21687` (`g_taskId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_MaintenanceMap`
--

LOCK TABLES `g2_MaintenanceMap` WRITE;
/*!40000 ALTER TABLE `g2_MaintenanceMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_MaintenanceMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_MimeTypeMap`
--

DROP TABLE IF EXISTS `g2_MimeTypeMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_MimeTypeMap` (
  `g_extension` varchar(32) NOT NULL,
  `g_mimeType` varchar(128) NOT NULL,
  `g_viewable` int(1) default NULL,
  PRIMARY KEY  (`g_extension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_MimeTypeMap`
--

LOCK TABLES `g2_MimeTypeMap` WRITE;
/*!40000 ALTER TABLE `g2_MimeTypeMap` DISABLE KEYS */;
INSERT INTO `g2_MimeTypeMap` VALUES ('ai','application/postscript',0),('aif','audio/x-aiff',0),('aifc','audio/x-aiff',0),('aiff','audio/x-aiff',0),('asc','text/plain',0),('asf','video/x-ms-asf',0),('asx','video/x-ms-asx',0),('au','audio/basic',0),('avi','video/x-msvideo',0),('bcpio','application/x-bcpio',0),('bin','application/octet-stream',0),('bmp','image/bmp',0),('cdf','application/x-netcdf',0),('class','application/octet-stream',0),('cpio','application/x-cpio',0),('cpt','application/mac-compactpro',0),('csh','application/x-csh',0),('css','text/css',0),('dcr','application/x-director',0),('dir','application/x-director',0),('djv','image/vnd.djvu',0),('djvu','image/vnd.djvu',0),('dll','application/octet-stream',0),('dms','application/octet-stream',0),('doc','application/msword',0),('dvi','application/x-dvi',0),('dxr','application/x-director',0),('eps','application/postscript',0),('etx','text/x-setext',0),('exe','application/octet-stream',0),('ez','application/andrew-inset',0),('flv','video/x-flv',0),('gif','image/gif',1),('gtar','application/x-gtar',0),('gz','application/x-gzip',0),('hdf','application/x-hdf',0),('hqx','application/mac-binhex40',0),('ice','x-conference/x-cooltalk',0),('ief','image/ief',0),('iges','model/iges',0),('igs','model/iges',0),('jp2','image/jp2',0),('jpe','image/jpeg',1),('jpeg','image/jpeg',1),('jpf','image/jpx',0),('jpg','image/jpeg',1),('jpg2','image/jp2',0),('jpgcmyk','image/jpeg-cmyk',0),('jpgm','image/jpgm',0),('jpm','image/jpm',0),('jpx','image/jpx',0),('js','application/x-javascript',0),('kar','audio/midi',0),('latex','application/x-latex',0),('lha','application/octet-stream',0),('lzh','application/octet-stream',0),('m3u','audio/x-mpegurl',0),('man','application/x-troff-man',0),('me','application/x-troff-me',0),('mesh','model/mesh',0),('mid','audio/midi',0),('midi','audio/midi',0),('mif','application/vnd.mif',0),('mj2','video/mj2',0),('mjp2','video/mj2',0),('mov','video/quicktime',0),('movie','video/x-sgi-movie',0),('mp2','audio/mpeg',0),('mp3','audio/mpeg',0),('mp4','video/mp4',0),('mpe','video/mpeg',0),('mpeg','video/mpeg',0),('mpg','video/mpeg',0),('mpga','audio/mpeg',0),('ms','application/x-troff-ms',0),('msh','model/mesh',0),('mxu','video/vnd.mpegurl',0),('nc','application/x-netcdf',0),('oda','application/oda',0),('pbm','image/x-portable-bitmap',0),('pcd','image/x-photo-cd',0),('pdb','chemical/x-pdb',0),('pdf','application/pdf',0),('pgm','image/x-portable-graymap',0),('pgn','application/x-chess-pgn',0),('png','image/png',1),('pnm','image/x-portable-anymap',0),('ppm','image/x-portable-pixmap',0),('ppt','application/vnd.ms-powerpoint',0),('ps','application/postscript',0),('psd','application/photoshop',0),('qt','video/quicktime',0),('ra','audio/x-realaudio',0),('ram','audio/x-pn-realaudio',0),('ras','image/x-cmu-raster',0),('rgb','image/x-rgb',0),('rm','audio/x-pn-realaudio',0),('roff','application/x-troff',0),('rpm','audio/x-pn-realaudio-plugin',0),('rtf','text/rtf',0),('rtx','text/richtext',0),('sgm','text/sgml',0),('sgml','text/sgml',0),('sh','application/x-sh',0),('shar','application/x-shar',0),('silo','model/mesh',0),('sit','application/x-stuffit',0),('skd','application/x-koan',0),('skm','application/x-koan',0),('skp','application/x-koan',0),('skt','application/x-koan',0),('smi','application/smil',0),('smil','application/smil',0),('snd','audio/basic',0),('so','application/octet-stream',0),('spl','application/x-futuresplash',0),('src','application/x-wais-source',0),('sv4cpio','application/x-sv4cpio',0),('sv4crc','application/x-sv4crc',0),('svg','image/svg+xml',0),('swf','application/x-shockwave-flash',0),('t','application/x-troff',0),('tar','application/x-tar',0),('tcl','application/x-tcl',0),('tex','application/x-tex',0),('texi','application/x-texinfo',0),('texinfo','application/x-texinfo',0),('tga','image/tga',0),('tif','image/tiff',0),('tifcmyk','image/tiff-cmyk',0),('tiff','image/tiff',0),('tr','application/x-troff',0),('tsv','text/tab-separated-values',0),('txt','text/plain',0),('ustar','application/x-ustar',0),('vcd','application/x-cdlink',0),('vrml','model/vrml',0),('vsd','application/vnd.visio',0),('wav','audio/x-wav',0),('wbmp','image/vnd.wap.wbmp',0),('wbxml','application/vnd.wap.wbxml',0),('wma','audio/x-ms-wma',0),('wmf','image/wmf',0),('wml','text/vnd.wap.wml',0),('wmlc','application/vnd.wap.wmlc',0),('wmls','text/vnd.wap.wmlscript',0),('wmlsc','application/vnd.wap.wmlscriptc',0),('wmv','video/x-ms-wmv',0),('wrl','model/vrml',0),('xbm','image/x-xbitmap',0),('xls','application/vnd.ms-excel',0),('xpm','image/x-xpixmap',0),('xsl','text/xml',0),('xwd','image/x-xwindowdump',0),('xyz','chemical/x-xyz',0),('z','application/x-compress',0),('zip','application/zip',0);
/*!40000 ALTER TABLE `g2_MimeTypeMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_MovieItem`
--

DROP TABLE IF EXISTS `g2_MovieItem`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_MovieItem` (
  `g_id` int(11) NOT NULL,
  `g_width` int(11) default NULL,
  `g_height` int(11) default NULL,
  `g_duration` int(11) default NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_MovieItem`
--

LOCK TABLES `g2_MovieItem` WRITE;
/*!40000 ALTER TABLE `g2_MovieItem` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_MovieItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_PermissionSetMap`
--

DROP TABLE IF EXISTS `g2_PermissionSetMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_PermissionSetMap` (
  `g_module` varchar(128) NOT NULL,
  `g_permission` varchar(128) NOT NULL,
  `g_description` varchar(255) default NULL,
  `g_bits` int(11) NOT NULL,
  `g_flags` int(11) NOT NULL,
  UNIQUE KEY `g_permission` (`g_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_PermissionSetMap`
--

LOCK TABLES `g2_PermissionSetMap` WRITE;
/*!40000 ALTER TABLE `g2_PermissionSetMap` DISABLE KEYS */;
INSERT INTO `g2_PermissionSetMap` VALUES ('comment','comment.add','[comment] Add comments',256,0),('comment','comment.all','[comment] All access',3840,2),('comment','comment.delete','[comment] Delete comments',1024,0),('comment','comment.edit','[comment] Edit comments',512,0),('comment','comment.view','[comment] View comments',2048,0),('core','core.addAlbumItem','[core] Add sub-album',8,0),('core','core.addDataItem','[core] Add sub-item',16,0),('core','core.all','All access',2147483647,3),('core','core.changePermissions','[core] Change item permissions',64,0),('core','core.delete','[core] Delete item',128,0),('core','core.edit','[core] Edit item',32,0),('core','core.view','[core] View item',1,0),('core','core.viewAll','[core] View all versions',7,2),('core','core.viewResizes','[core] View resized version(s)',2,0),('core','core.viewSource','[core] View original version',4,0),('rating','rating.add','[rating] Add ratings',4096,0),('rating','rating.all','[rating] All access',12288,2),('rating','rating.view','[rating] View ratings',8192,0),('shutterfly','shutterfly.print','[shutterfly] Print',16384,0);
/*!40000 ALTER TABLE `g2_PermissionSetMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_PhotoItem`
--

DROP TABLE IF EXISTS `g2_PhotoItem`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_PhotoItem` (
  `g_id` int(11) NOT NULL,
  `g_width` int(11) default NULL,
  `g_height` int(11) default NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_PhotoItem`
--

LOCK TABLES `g2_PhotoItem` WRITE;
/*!40000 ALTER TABLE `g2_PhotoItem` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_PhotoItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_PluginMap`
--

DROP TABLE IF EXISTS `g2_PluginMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_PluginMap` (
  `g_pluginType` varchar(32) NOT NULL,
  `g_pluginId` varchar(32) NOT NULL,
  `g_active` int(1) NOT NULL,
  PRIMARY KEY  (`g_pluginType`,`g_pluginId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_PluginMap`
--

LOCK TABLES `g2_PluginMap` WRITE;
/*!40000 ALTER TABLE `g2_PluginMap` DISABLE KEYS */;
INSERT INTO `g2_PluginMap` VALUES ('module','archiveupload',1),('module','comment',1),('module','core',1),('module','exif',1),('module','ffmpeg',0),('module','gd',1),('module','icons',1),('module','imagemagick',1),('module','keyalbum',1),('module','netpbm',1),('module','rating',1),('module','rearrange',1),('module','rewrite',0),('module','search',1),('module','shutterfly',1),('module','slideshow',1),('theme','matrix',1);
/*!40000 ALTER TABLE `g2_PluginMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_PluginPackageMap`
--

DROP TABLE IF EXISTS `g2_PluginPackageMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_PluginPackageMap` (
  `g_pluginType` varchar(32) NOT NULL,
  `g_pluginId` varchar(32) NOT NULL,
  `g_packageName` varchar(32) NOT NULL,
  `g_packageVersion` varchar(32) NOT NULL,
  `g_packageBuild` varchar(32) NOT NULL,
  `g_locked` int(1) NOT NULL,
  KEY `g2_PluginPackageMap_80596` (`g_pluginType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_PluginPackageMap`
--

LOCK TABLES `g2_PluginPackageMap` WRITE;
/*!40000 ALTER TABLE `g2_PluginPackageMap` DISABLE KEYS */;
INSERT INTO `g2_PluginPackageMap` VALUES ('theme','matrix','base','1.1.6','20955',0),('module','core','base','1.3.0.1','20961',0),('module','archiveupload','base','1.0.10','20955',0),('module','comment','base','1.1.14','20955',0),('module','exif','base','1.2.6','20961',0),('module','ffmpeg','base','1.0.14','20955',0),('module','icons','base','1.1.5','20955',0),('module','imagemagick','base','1.1.6','20961',0),('module','keyalbum','base','1.0.6','20955',0),('module','netpbm','base','1.1.5','20955',0),('module','rating','base','1.0.13','20955',0),('module','rearrange','base','1.0.9','20955',0),('module','rewrite','base','1.1.19','20955',0),('module','search','base','1.0.8','20955',0),('module','shutterfly','base','1.0.14','20955',0),('module','slideshow','base','2.0.0','20955',0),('module','gd','base','1.1.6','20961',0);
/*!40000 ALTER TABLE `g2_PluginPackageMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_PluginParameterMap`
--

DROP TABLE IF EXISTS `g2_PluginParameterMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_PluginParameterMap` (
  `g_pluginType` varchar(32) NOT NULL,
  `g_pluginId` varchar(32) NOT NULL,
  `g_itemId` int(11) NOT NULL,
  `g_parameterName` varchar(128) NOT NULL,
  `g_parameterValue` text NOT NULL,
  UNIQUE KEY `g_pluginType` (`g_pluginType`,`g_pluginId`,`g_itemId`,`g_parameterName`),
  KEY `g2_PluginParameterMap_80596` (`g_pluginType`),
  KEY `g2_PluginParameterMap_12808` (`g_pluginType`,`g_pluginId`,`g_itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_PluginParameterMap`
--

LOCK TABLES `g2_PluginParameterMap` WRITE;
/*!40000 ALTER TABLE `g2_PluginParameterMap` DISABLE KEYS */;
INSERT INTO `g2_PluginParameterMap` VALUES ('module','archiveupload',0,'removeMeta','1'),('module','archiveupload',0,'unzipPath','/usr/bin/unzip'),('module','archiveupload',0,'_callbacks','getSiteAdminViews'),('module','archiveupload',0,'_requiredCoreApi','7,20'),('module','archiveupload',0,'_requiredModuleApi','3,6'),('module','archiveupload',0,'_templateVersion','1'),('module','archiveupload',0,'_version','1.0.10'),('module','comment',0,'comments.latest','1'),('module','comment',0,'comments.moderate','0'),('module','comment',0,'comments.show','10'),('module','comment',0,'validation.level','HIGH'),('module','comment',0,'_callbacks','getItemLinks|getItemSummaries|getSiteAdminViews|getItemAdminViews'),('module','comment',0,'_requiredCoreApi','7,41'),('module','comment',0,'_requiredModuleApi','3,9'),('module','comment',0,'_templateVersion','1'),('module','comment',0,'_version','1.1.14'),('module','core',0,'acceleration','a:2:{s:5:\"guest\";a:1:{s:4:\"type\";s:4:\"none\";}s:4:\"user\";a:1:{s:4:\"type\";s:4:\"none\";}}'),('module','core',0,'core.repositories','a:1:{s:8:\"released\";i:1;}'),('module','core',0,'default.language','en_US'),('module','core',0,'default.newAlbumsUseDefaults','false'),('module','core',0,'default.orderBy','orderWeight'),('module','core',0,'default.orderDirection','1'),('module','core',0,'default.theme','matrix'),('module','core',0,'exec.beNice','0'),('module','core',0,'exec.expectedStatus','0'),('module','core',0,'format.date','%x'),('module','core',0,'format.datetime','%c'),('module','core',0,'format.time','%X'),('module','core',0,'id.accessListCompacterLock','1'),('module','core',0,'id.adminGroup','3'),('module','core',0,'id.allUserGroup','2'),('module','core',0,'id.anonymousUser','5'),('module','core',0,'id.everybodyGroup','4'),('module','core',0,'id.rootAlbum','7'),('module','core',0,'language.useBrowserPref','0'),('module','core',0,'lock.system','flock'),('module','core',0,'misc.markup','bbcode'),('module','core',0,'permissions.directory','0755'),('module','core',0,'permissions.file','0644'),('module','core',0,'repository.updateTime','0'),('module','core',0,'session.inactivityTimeout','604800'),('module','core',0,'session.lifetime','1814400'),('module','core',0,'session.siteAdministrationTimeout','1800'),('module','core',0,'smarty.compile_check','0'),('module','core',0,'validation.level','MEDIUM'),('module','core',0,'_callbacks','getItemLinks|getSystemLinks|getItemAdminViews|getSiteAdminViews|getUserAdminViews'),('module','core',0,'_requiredCoreApi','7,53'),('module','core',0,'_requiredModuleApi','3,8'),('module','core',0,'_templateVersion','1'),('module','core',0,'_version','1.3.0.1'),('module','exif',0,'addOption','4'),('module','exif',0,'_callbacks','getSiteAdminViews'),('module','exif',0,'_requiredCoreApi','7,41'),('module','exif',0,'_requiredModuleApi','3,9'),('module','exif',0,'_templateVersion','1'),('module','exif',0,'_version','1.2.6'),('module','ffmpeg',0,'path',''),('module','ffmpeg',0,'useWatermark','0'),('module','ffmpeg',0,'_callbacks','getSiteAdminViews'),('module','ffmpeg',0,'_requiredCoreApi','7,27'),('module','ffmpeg',0,'_requiredModuleApi','3,6'),('module','ffmpeg',0,'_templateVersion','1'),('module','ffmpeg',0,'_version','1.0.14'),('module','gd',0,'jpegQuality','75'),('module','gd',0,'_callbacks','getSiteAdminViews'),('module','gd',0,'_requiredCoreApi','7,20'),('module','gd',0,'_requiredModuleApi','3,6'),('module','gd',0,'_templateVersion','1'),('module','gd',0,'_version','1.1.6'),('module','icons',0,'iconpack','silk'),('module','icons',0,'_callbacks','getSiteAdminViews'),('module','icons',0,'_requiredCoreApi','7,20'),('module','icons',0,'_requiredModuleApi','3,6'),('module','icons',0,'_templateVersion','1'),('module','icons',0,'_version','1.1.5'),('module','imagemagick',0,'binary',''),('module','imagemagick',0,'cmykSupport','off'),('module','imagemagick',0,'compositeCmd','composite'),('module','imagemagick',0,'jpegQuality','75'),('module','imagemagick',0,'path','/usr/bin/'),('module','imagemagick',0,'removeMetaDataSwitch','-strip'),('module','imagemagick',0,'useNewCoalesceOptions','1'),('module','imagemagick',0,'versionOk','1'),('module','imagemagick',0,'_callbacks','getSiteAdminViews'),('module','imagemagick',0,'_requiredCoreApi','7,20'),('module','imagemagick',0,'_requiredModuleApi','3,6'),('module','imagemagick',0,'_templateVersion','1'),('module','imagemagick',0,'_version','1.1.6'),('module','keyalbum',0,'description',''),('module','keyalbum',0,'orderBy',''),('module','keyalbum',0,'orderDirection',''),('module','keyalbum',0,'split',';,'),('module','keyalbum',0,'summaryLinks','all'),('module','keyalbum',0,'themeId',''),('module','keyalbum',0,'themeSettingsId','11'),('module','keyalbum',0,'_callbacks','getSiteAdminViews|getItemSummaries'),('module','keyalbum',0,'_requiredCoreApi','7,27'),('module','keyalbum',0,'_requiredModuleApi','3,6'),('module','keyalbum',0,'_templateVersion','1'),('module','keyalbum',0,'_version','1.0.6'),('module','netpbm',0,'bmptopnm','bmptopnm'),('module','netpbm',0,'jpegQuality','75'),('module','netpbm',0,'path','/usr/bin/'),('module','netpbm',0,'pnmcomp','pnmcomp'),('module','netpbm',0,'pnmtojpeg','pnmtojpeg'),('module','netpbm',0,'_callbacks','getSiteAdminViews'),('module','netpbm',0,'_requiredCoreApi','7,20'),('module','netpbm',0,'_requiredModuleApi','3,6'),('module','netpbm',0,'_templateVersion','1'),('module','netpbm',0,'_version','1.1.5'),('module','rating',0,'allowAlbumRating','0'),('module','rating',0,'description',''),('module','rating',0,'minLimit','2'),('module','rating',0,'orderBy','RatingSortOrder'),('module','rating',0,'orderDirection','desc'),('module','rating',0,'themeId',''),('module','rating',0,'themeSettingsId','13'),('module','rating',0,'_callbacks','getSiteAdminViews|getItemSummaries'),('module','rating',0,'_requiredCoreApi','7,41'),('module','rating',0,'_requiredModuleApi','3,6'),('module','rating',0,'_templateVersion','1'),('module','rating',0,'_version','1.0.13'),('module','rearrange',0,'_callbacks','getItemLinks|getItemAdminViews'),('module','rearrange',0,'_requiredCoreApi','7,27'),('module','rearrange',0,'_requiredModuleApi','3,9'),('module','rearrange',0,'_templateVersion','1'),('module','rearrange',0,'_version','1.0.9'),('module','rewrite',0,'accessList','a:0:{}'),('module','rewrite',0,'activeRules','a:0:{}'),('module','rewrite',0,'allowEmptyReferer','1'),('module','rewrite',0,'isapirewrite.embeddedLocation',''),('module','rewrite',0,'isapirewrite.forced','0'),('module','rewrite',0,'isapirewrite.galleryLocation',''),('module','rewrite',0,'isapirewrite.httpdini',''),('module','rewrite',0,'modrewrite.embeddedHtaccess',''),('module','rewrite',0,'modrewrite.embeddedLocation',''),('module','rewrite',0,'modrewrite.galleryLocation',''),('module','rewrite',0,'modrewrite.status','a:0:{}'),('module','rewrite',0,'parserId',''),('module','rewrite',0,'pathinfo.forced','0'),('module','rewrite',0,'pathinfo.parser','a:0:{}'),('module','rewrite',0,'shortUrls','a:0:{}'),('module','rewrite',0,'_callbacks','getSiteAdminViews'),('module','rewrite',0,'_requiredCoreApi','7,34'),('module','rewrite',0,'_requiredModuleApi','3,6'),('module','rewrite',0,'_templateVersion','1'),('module','rewrite',0,'_version','1.1.19'),('module','search',0,'_callbacks',''),('module','search',0,'_requiredCoreApi','7,27'),('module','search',0,'_requiredModuleApi','3,6'),('module','search',0,'_templateVersion','1'),('module','search',0,'_version','1.0.8'),('module','shutterfly',0,'_callbacks','getItemLinks'),('module','shutterfly',0,'_requiredCoreApi','7,43'),('module','shutterfly',0,'_requiredModuleApi','3,9'),('module','shutterfly',0,'_templateVersion','1'),('module','shutterfly',0,'_version','1.0.14'),('module','slideshow',0,'piclens.version','1.3.1.14221'),('module','slideshow',0,'_callbacks','getItemLinks|getSiteAdminViews'),('module','slideshow',0,'_requiredCoreApi','7,49'),('module','slideshow',0,'_requiredModuleApi','3,9'),('module','slideshow',0,'_templateVersion','1'),('module','slideshow',0,'_version','2.0.0'),('theme','matrix',0,'albumBlocks','a:1:{i:0;a:2:{i:0;s:20:\"comment.ViewComments\";i:1;a:0:{}}}'),('theme','matrix',0,'columns','3'),('theme','matrix',0,'dynamicLinks','browse'),('theme','matrix',0,'photoBlocks','a:2:{i:0;a:2:{i:0;s:13:\"exif.ExifInfo\";i:1;a:0:{}}i:1;a:2:{i:0;s:20:\"comment.ViewComments\";i:1;a:0:{}}}'),('theme','matrix',0,'rows','3'),('theme','matrix',0,'showAlbumOwner','1'),('theme','matrix',0,'showImageOwner','0'),('theme','matrix',0,'showMicroThumbs','0'),('theme','matrix',0,'sidebarBlocks','a:4:{i:0;a:2:{i:0;s:18:\"search.SearchBlock\";i:1;a:1:{s:16:\"showAdvancedLink\";b:1;}}i:1;a:2:{i:0;s:14:\"core.ItemLinks\";i:1;a:1:{s:11:\"useDropdown\";b:0;}}i:2;a:2:{i:0;s:13:\"core.PeerList\";i:1;a:0:{}}i:3;a:2:{i:0;s:21:\"imageblock.ImageBlock\";i:1;a:0:{}}}'),('theme','matrix',0,'_requiredCoreApi','7,20'),('theme','matrix',0,'_requiredThemeApi','2,4'),('theme','matrix',0,'_version','1.1.6');
/*!40000 ALTER TABLE `g2_PluginParameterMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_RatingCacheMap`
--

DROP TABLE IF EXISTS `g2_RatingCacheMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_RatingCacheMap` (
  `g_itemId` int(11) NOT NULL,
  `g_averageRating` int(11) NOT NULL,
  `g_voteCount` int(11) NOT NULL,
  PRIMARY KEY  (`g_itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_RatingCacheMap`
--

LOCK TABLES `g2_RatingCacheMap` WRITE;
/*!40000 ALTER TABLE `g2_RatingCacheMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_RatingCacheMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_RatingMap`
--

DROP TABLE IF EXISTS `g2_RatingMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_RatingMap` (
  `g_ratingId` int(11) NOT NULL,
  `g_itemId` int(11) NOT NULL,
  `g_userId` int(11) NOT NULL,
  `g_rating` int(11) NOT NULL,
  `g_sessionId` varchar(128) default NULL,
  `g_remoteIdentifier` varchar(255) default NULL,
  PRIMARY KEY  (`g_ratingId`),
  KEY `g2_RatingMap_75985` (`g_itemId`),
  KEY `g2_RatingMap_80383` (`g_itemId`,`g_userId`),
  KEY `g2_RatingMap_2369` (`g_itemId`,`g_remoteIdentifier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_RatingMap`
--

LOCK TABLES `g2_RatingMap` WRITE;
/*!40000 ALTER TABLE `g2_RatingMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_RatingMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_RecoverPasswordMap`
--

DROP TABLE IF EXISTS `g2_RecoverPasswordMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_RecoverPasswordMap` (
  `g_userName` varchar(32) NOT NULL,
  `g_authString` varchar(32) NOT NULL,
  `g_requestExpires` int(11) NOT NULL,
  PRIMARY KEY  (`g_userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_RecoverPasswordMap`
--

LOCK TABLES `g2_RecoverPasswordMap` WRITE;
/*!40000 ALTER TABLE `g2_RecoverPasswordMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_RecoverPasswordMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_Schema`
--

DROP TABLE IF EXISTS `g2_Schema`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_Schema` (
  `g_name` varchar(128) NOT NULL,
  `g_major` int(11) NOT NULL,
  `g_minor` int(11) NOT NULL,
  `g_createSql` text,
  `g_pluginId` varchar(32) default NULL,
  `g_type` varchar(32) default NULL,
  `g_info` text,
  PRIMARY KEY  (`g_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_Schema`
--

LOCK TABLES `g2_Schema` WRITE;
/*!40000 ALTER TABLE `g2_Schema` DISABLE KEYS */;
INSERT INTO `g2_Schema` VALUES ('AccessMap',1,3,'CREATE TABLE DB_TABLE_PREFIXAccessMap(\n DB_COLUMN_PREFIXaccessListId int(11) NOT NULL,\n DB_COLUMN_PREFIXuserOrGroupId int(11) NOT NULL,\n DB_COLUMN_PREFIXpermission int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXaccessListId, DB_COLUMN_PREFIXuserOrGroupId),\n INDEX DB_TABLE_PREFIXAccessMap_83732(DB_COLUMN_PREFIXaccessListId),\n INDEX DB_TABLE_PREFIXAccessMap_48775(DB_COLUMN_PREFIXuserOrGroupId),\n INDEX DB_TABLE_PREFIXAccessMap_18058(DB_COLUMN_PREFIXpermission)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'AccessMap\', 1, 3);\n\n','core','map','a:1:{s:16:\"GalleryAccessMap\";a:3:{s:12:\"accessListId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:13:\"userOrGroupId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:10:\"permission\";a:3:{s:4:\"type\";i:64;s:4:\"size\";i:4;s:7:\"notNull\";b:1;}}}'),('AccessSubscriberMap',1,0,'CREATE TABLE DB_TABLE_PREFIXAccessSubscriberMap(\n DB_COLUMN_PREFIXitemId int(11) NOT NULL,\n DB_COLUMN_PREFIXaccessListId int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXitemId),\n INDEX DB_TABLE_PREFIXAccessSubscriberMap_83732(DB_COLUMN_PREFIXaccessListId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'AccessSubscriberMap\', 1, 0);\n\n','core','map','a:1:{s:26:\"GalleryAccessSubscriberMap\";a:2:{s:6:\"itemId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:12:\"accessListId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('AlbumItem',1,1,'CREATE TABLE DB_TABLE_PREFIXAlbumItem(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXtheme varchar(32),\n DB_COLUMN_PREFIXorderBy varchar(128),\n DB_COLUMN_PREFIXorderDirection varchar(32),\n PRIMARY KEY(DB_COLUMN_PREFIXid)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'AlbumItem\', 1, 1);\n\n','core','entity','a:1:{s:16:\"GalleryAlbumItem\";a:4:{s:7:\"members\";a:3:{s:5:\"theme\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:1;}s:7:\"orderBy\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:14:\"orderDirection\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:1;}}s:6:\"parent\";s:11:\"GalleryItem\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('AnimationItem',1,0,'CREATE TABLE DB_TABLE_PREFIXAnimationItem(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXwidth int(11),\n DB_COLUMN_PREFIXheight int(11),\n PRIMARY KEY(DB_COLUMN_PREFIXid)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'AnimationItem\', 1, 0);\n\n','core','entity','a:1:{s:20:\"GalleryAnimationItem\";a:4:{s:7:\"members\";a:2:{s:5:\"width\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:3;}s:6:\"height\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:3;}}s:6:\"parent\";s:15:\"GalleryDataItem\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:2:{i:0;s:5:\"width\";i:1;s:6:\"height\";}}}'),('CacheMap',1,1,'CREATE TABLE DB_TABLE_PREFIXCacheMap(\n DB_COLUMN_PREFIXkey varchar(32) NOT NULL,\n DB_COLUMN_PREFIXvalue longtext,\n DB_COLUMN_PREFIXuserId int(11) NOT NULL,\n DB_COLUMN_PREFIXitemId int(11) NOT NULL,\n DB_COLUMN_PREFIXtype varchar(32) NOT NULL,\n DB_COLUMN_PREFIXtimestamp int(11) NOT NULL,\n DB_COLUMN_PREFIXisEmpty int(1),\n PRIMARY KEY(DB_COLUMN_PREFIXkey, DB_COLUMN_PREFIXuserId, DB_COLUMN_PREFIXitemId, DB_COLUMN_PREFIXtype),\n INDEX DB_TABLE_PREFIXCacheMap_75985(DB_COLUMN_PREFIXitemId),\n INDEX DB_TABLE_PREFIXCacheMap_21979(DB_COLUMN_PREFIXuserId, DB_COLUMN_PREFIXtimestamp, DB_COLUMN_PREFIXisEmpty)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'CacheMap\', 1, 1);\n\n','core','map','a:1:{s:15:\"GalleryCacheMap\";a:7:{s:3:\"key\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:5:\"value\";a:2:{s:4:\"type\";i:4;s:4:\"size\";i:4;}s:6:\"userId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:6:\"itemId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:4:\"type\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:9:\"timestamp\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:7:\"isEmpty\";a:2:{s:4:\"type\";i:8;s:4:\"size\";i:2;}}}'),('ChildEntity',1,0,'CREATE TABLE DB_TABLE_PREFIXChildEntity(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXparentId int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXChildEntity_52718(DB_COLUMN_PREFIXparentId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'ChildEntity\', 1, 0);\n\n','core','entity','a:1:{s:18:\"GalleryChildEntity\";a:4:{s:7:\"members\";a:1:{s:8:\"parentId\";a:2:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;}}s:6:\"parent\";s:13:\"GalleryEntity\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('Comment',1,3,'CREATE TABLE DB_TABLE_PREFIXComment(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXcommenterId int(11) NOT NULL,\n DB_COLUMN_PREFIXhost varchar(128) NOT NULL,\n DB_COLUMN_PREFIXsubject varchar(128),\n DB_COLUMN_PREFIXcomment text,\n DB_COLUMN_PREFIXdate int(11) NOT NULL,\n DB_COLUMN_PREFIXauthor varchar(128),\n DB_COLUMN_PREFIXpublishStatus int(11) NOT NULL DEFAULT \'0\',\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXComment_95610(DB_COLUMN_PREFIXdate),\n INDEX DB_TABLE_PREFIXComment_70722(DB_COLUMN_PREFIXpublishStatus)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'Comment\', 1, 3);\n\n','comment','entity','a:1:{s:14:\"GalleryComment\";a:4:{s:7:\"members\";a:7:{s:11:\"commenterId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:4;s:7:\"notNull\";i:1;}s:4:\"host\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";i:1;}s:7:\"subject\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:3;}s:7:\"comment\";a:3:{s:4:\"type\";i:4;s:4:\"size\";i:1;s:15:\"external-access\";i:3;}s:4:\"date\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:6:\"author\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:3;}s:13:\"publishStatus\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:3;}}s:6:\"parent\";s:18:\"GalleryChildEntity\";s:6:\"module\";s:7:\"comment\";s:6:\"linked\";a:0:{}}}'),('DataItem',1,0,'CREATE TABLE DB_TABLE_PREFIXDataItem(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXmimeType varchar(128),\n DB_COLUMN_PREFIXsize int(11),\n PRIMARY KEY(DB_COLUMN_PREFIXid)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'DataItem\', 1, 0);\n\n','core','entity','a:1:{s:15:\"GalleryDataItem\";a:4:{s:7:\"members\";a:2:{s:8:\"mimeType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:1;}s:4:\"size\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:1;}}s:6:\"parent\";s:11:\"GalleryItem\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:2:{i:0;s:8:\"mimeType\";i:1;s:4:\"size\";}}}'),('Derivative',1,1,'CREATE TABLE DB_TABLE_PREFIXDerivative(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXderivativeSourceId int(11) NOT NULL,\n DB_COLUMN_PREFIXderivativeOperations varchar(255),\n DB_COLUMN_PREFIXderivativeOrder int(11) NOT NULL,\n DB_COLUMN_PREFIXderivativeSize int(11),\n DB_COLUMN_PREFIXderivativeType int(11) NOT NULL,\n DB_COLUMN_PREFIXmimeType varchar(128) NOT NULL,\n DB_COLUMN_PREFIXpostFilterOperations varchar(255),\n DB_COLUMN_PREFIXisBroken int(1),\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXDerivative_85338(DB_COLUMN_PREFIXderivativeSourceId),\n INDEX DB_TABLE_PREFIXDerivative_25243(DB_COLUMN_PREFIXderivativeOrder),\n INDEX DB_TABLE_PREFIXDerivative_97216(DB_COLUMN_PREFIXderivativeType)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'Derivative\', 1, 1);\n\n','core','entity','a:1:{s:17:\"GalleryDerivative\";a:4:{s:7:\"members\";a:8:{s:18:\"derivativeSourceId\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:20:\"derivativeOperations\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}s:15:\"derivativeOrder\";a:2:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;}s:14:\"derivativeSize\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:1;}s:14:\"derivativeType\";a:2:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;}s:8:\"mimeType\";a:4:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";i:1;s:15:\"external-access\";i:3;}s:20:\"postFilterOperations\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}s:8:\"isBroken\";a:1:{s:4:\"type\";i:8;}}s:6:\"parent\";s:18:\"GalleryChildEntity\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('DerivativeImage',1,0,'CREATE TABLE DB_TABLE_PREFIXDerivativeImage(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXwidth int(11),\n DB_COLUMN_PREFIXheight int(11),\n PRIMARY KEY(DB_COLUMN_PREFIXid)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'DerivativeImage\', 1, 0);\n\n','core','entity','a:1:{s:22:\"GalleryDerivativeImage\";a:4:{s:7:\"members\";a:2:{s:5:\"width\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:1;}s:6:\"height\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:1;}}s:6:\"parent\";s:17:\"GalleryDerivative\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('DerivativePrefsMap',1,0,'CREATE TABLE DB_TABLE_PREFIXDerivativePrefsMap(\n DB_COLUMN_PREFIXitemId int(11),\n DB_COLUMN_PREFIXorder int(11),\n DB_COLUMN_PREFIXderivativeType int(11),\n DB_COLUMN_PREFIXderivativeOperations varchar(255),\n INDEX DB_TABLE_PREFIXDerivativePrefsMap_75985(DB_COLUMN_PREFIXitemId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'DerivativePrefsMap\', 1, 0);\n\n','core','map','a:1:{s:31:\"GalleryDerivativePreferencesMap\";a:4:{s:6:\"itemId\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:2;}s:5:\"order\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:2;}s:14:\"derivativeType\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:2;}s:20:\"derivativeOperations\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}}}'),('DescendentCountsMap',1,0,'CREATE TABLE DB_TABLE_PREFIXDescendentCountsMap(\n DB_COLUMN_PREFIXuserId int(11) NOT NULL,\n DB_COLUMN_PREFIXitemId int(11) NOT NULL,\n DB_COLUMN_PREFIXdescendentCount int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXuserId, DB_COLUMN_PREFIXitemId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'DescendentCountsMap\', 1, 0);\n\n','core','map','a:1:{s:26:\"GalleryDescendentCountsMap\";a:3:{s:6:\"userId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:6:\"itemId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:15:\"descendentCount\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('Entity',1,2,'CREATE TABLE DB_TABLE_PREFIXEntity(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXcreationTimestamp int(11) NOT NULL,\n DB_COLUMN_PREFIXisLinkable int(1) NOT NULL,\n DB_COLUMN_PREFIXlinkId int(11),\n DB_COLUMN_PREFIXmodificationTimestamp int(11) NOT NULL,\n DB_COLUMN_PREFIXserialNumber int(11) NOT NULL,\n DB_COLUMN_PREFIXentityType varchar(32) NOT NULL,\n DB_COLUMN_PREFIXonLoadHandlers varchar(128),\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXEntity_76255(DB_COLUMN_PREFIXcreationTimestamp),\n INDEX DB_TABLE_PREFIXEntity_35978(DB_COLUMN_PREFIXisLinkable),\n INDEX DB_TABLE_PREFIXEntity_44738(DB_COLUMN_PREFIXlinkId),\n INDEX DB_TABLE_PREFIXEntity_63025(DB_COLUMN_PREFIXmodificationTimestamp),\n INDEX DB_TABLE_PREFIXEntity_60702(DB_COLUMN_PREFIXserialNumber)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'Entity\', 1, 2);\n\n','core','entity','a:1:{s:13:\"GalleryEntity\";a:4:{s:7:\"members\";a:8:{s:2:\"id\";a:3:{s:4:\"type\";i:33;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:17:\"creationTimestamp\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:3;}s:10:\"isLinkable\";a:2:{s:4:\"type\";i:8;s:7:\"notNull\";i:1;}s:6:\"linkId\";a:1:{s:4:\"type\";i:1;}s:21:\"modificationTimestamp\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:12:\"serialNumber\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:10:\"entityType\";a:4:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:14:\"onLoadHandlers\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}}s:6:\"parent\";N;s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('EventLogMap',1,0,'CREATE TABLE DB_TABLE_PREFIXEventLogMap(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXuserId int(11),\n DB_COLUMN_PREFIXtype varchar(32),\n DB_COLUMN_PREFIXsummary varchar(255),\n DB_COLUMN_PREFIXdetails text,\n DB_COLUMN_PREFIXlocation varchar(255),\n DB_COLUMN_PREFIXclient varchar(128),\n DB_COLUMN_PREFIXtimestamp int(11) NOT NULL,\n DB_COLUMN_PREFIXreferer varchar(128),\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXEventLogMap_24286(DB_COLUMN_PREFIXtimestamp)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'EventLogMap\', 1, 0);\n\n','core','map','a:1:{s:11:\"EventLogMap\";a:9:{s:2:\"id\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:6:\"userId\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:2;}s:4:\"type\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:1;}s:7:\"summary\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}s:7:\"details\";a:2:{s:4:\"type\";i:4;s:4:\"size\";i:2;}s:8:\"location\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}s:6:\"client\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:9:\"timestamp\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:7:\"referer\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}}}'),('ExifPropertiesMap',1,0,'CREATE TABLE DB_TABLE_PREFIXExifPropertiesMap(\n DB_COLUMN_PREFIXproperty varchar(128),\n DB_COLUMN_PREFIXviewMode int(11),\n DB_COLUMN_PREFIXsequence int(11),\n UNIQUE (DB_COLUMN_PREFIXproperty, DB_COLUMN_PREFIXviewMode)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'ExifPropertiesMap\', 1, 0);\n\n','exif','map','a:1:{s:17:\"ExifPropertiesMap\";a:3:{s:8:\"property\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:8:\"viewMode\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:4;}s:8:\"sequence\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:4;}}}'),('ExternalIdMap',1,0,'CREATE TABLE DB_TABLE_PREFIXExternalIdMap(\n DB_COLUMN_PREFIXexternalId varchar(128) NOT NULL,\n DB_COLUMN_PREFIXentityType varchar(32) NOT NULL,\n DB_COLUMN_PREFIXentityId int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXexternalId, DB_COLUMN_PREFIXentityType)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'ExternalIdMap\', 1, 0);\n\n','core','map','a:1:{s:13:\"ExternalIdMap\";a:3:{s:10:\"externalId\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:10:\"entityType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:8:\"entityId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('FactoryMap',1,0,'CREATE TABLE DB_TABLE_PREFIXFactoryMap(\n DB_COLUMN_PREFIXclassType varchar(128),\n DB_COLUMN_PREFIXclassName varchar(128),\n DB_COLUMN_PREFIXimplId varchar(128),\n DB_COLUMN_PREFIXimplPath varchar(128),\n DB_COLUMN_PREFIXimplModuleId varchar(128),\n DB_COLUMN_PREFIXhints varchar(255),\n DB_COLUMN_PREFIXorderWeight varchar(255)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'FactoryMap\', 1, 0);\n\n','core','map','a:1:{s:17:\"GalleryFactoryMap\";a:7:{s:9:\"classType\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:9:\"className\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:6:\"implId\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:8:\"implPath\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:12:\"implModuleId\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:5:\"hints\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}s:11:\"orderWeight\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}}}'),('FailedLoginsMap',1,0,'CREATE TABLE DB_TABLE_PREFIXFailedLoginsMap(\n DB_COLUMN_PREFIXuserName varchar(32) NOT NULL,\n DB_COLUMN_PREFIXcount int(11) NOT NULL,\n DB_COLUMN_PREFIXlastAttempt int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXuserName)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'FailedLoginsMap\', 1, 0);\n\n','core','map','a:1:{s:15:\"FailedLoginsMap\";a:3:{s:8:\"userName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:5:\"count\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:11:\"lastAttempt\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('FileSystemEntity',1,0,'CREATE TABLE DB_TABLE_PREFIXFileSystemEntity(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXpathComponent varchar(128),\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXFileSystemEntity_3406(DB_COLUMN_PREFIXpathComponent)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'FileSystemEntity\', 1, 0);\n\n','core','entity','a:1:{s:23:\"GalleryFileSystemEntity\";a:4:{s:7:\"members\";a:1:{s:13:\"pathComponent\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:1;}}s:6:\"parent\";s:18:\"GalleryChildEntity\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('Group',1,1,'CREATE TABLE DB_TABLE_PREFIXGroup(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXgroupType int(11) NOT NULL,\n DB_COLUMN_PREFIXgroupName varchar(128),\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n UNIQUE (DB_COLUMN_PREFIXgroupName)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'Group\', 1, 1);\n\n','core','entity','a:1:{s:12:\"GalleryGroup\";a:4:{s:7:\"members\";a:2:{s:9:\"groupType\";a:2:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;}s:9:\"groupName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:1;}}s:6:\"parent\";s:13:\"GalleryEntity\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('Item',1,2,'CREATE TABLE DB_TABLE_PREFIXItem(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXcanContainChildren int(1) NOT NULL,\n DB_COLUMN_PREFIXdescription text,\n DB_COLUMN_PREFIXkeywords varchar(255),\n DB_COLUMN_PREFIXownerId int(11) NOT NULL,\n DB_COLUMN_PREFIXrenderer varchar(128),\n DB_COLUMN_PREFIXsummary varchar(255),\n DB_COLUMN_PREFIXtitle varchar(128),\n DB_COLUMN_PREFIXviewedSinceTimestamp int(11) NOT NULL,\n DB_COLUMN_PREFIXoriginationTimestamp int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXItem_99070(DB_COLUMN_PREFIXkeywords),\n INDEX DB_TABLE_PREFIXItem_21573(DB_COLUMN_PREFIXownerId),\n INDEX DB_TABLE_PREFIXItem_54147(DB_COLUMN_PREFIXsummary),\n INDEX DB_TABLE_PREFIXItem_90059(DB_COLUMN_PREFIXtitle)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'Item\', 1, 2);\n\n','core','entity','a:1:{s:11:\"GalleryItem\";a:4:{s:7:\"members\";a:9:{s:18:\"canContainChildren\";a:3:{s:4:\"type\";i:8;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:11:\"description\";a:3:{s:4:\"type\";i:4;s:4:\"size\";i:1;s:15:\"external-access\";i:3;}s:8:\"keywords\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:4;s:15:\"external-access\";i:3;}s:7:\"ownerId\";a:2:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;}s:8:\"renderer\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:7:\"summary\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:4;s:15:\"external-access\";i:3;}s:5:\"title\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:3;}s:20:\"viewedSinceTimestamp\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:20:\"originationTimestamp\";a:3:{s:4:\"type\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:3;}}s:6:\"parent\";s:23:\"GalleryFileSystemEntity\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('ItemAttributesMap',1,0,'CREATE TABLE DB_TABLE_PREFIXItemAttributesMap(\n DB_COLUMN_PREFIXitemId int(11) NOT NULL,\n DB_COLUMN_PREFIXviewCount int(11),\n DB_COLUMN_PREFIXorderWeight int(11),\n DB_COLUMN_PREFIXparentSequence varchar(255) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXitemId),\n INDEX DB_TABLE_PREFIXItemAttributesMap_95270(DB_COLUMN_PREFIXparentSequence)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'ItemAttributesMap\', 1, 0);\n\n','core','map','a:1:{s:24:\"GalleryItemAttributesMap\";a:4:{s:6:\"itemId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:9:\"viewCount\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:2;}s:11:\"orderWeight\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:2;}s:14:\"parentSequence\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:4;s:19:\"notNullEmptyAllowed\";b:1;}}}'),('Lock',1,0,'CREATE TABLE DB_TABLE_PREFIXLock(\n DB_COLUMN_PREFIXlockId int(11),\n DB_COLUMN_PREFIXreadEntityId int(11),\n DB_COLUMN_PREFIXwriteEntityId int(11),\n DB_COLUMN_PREFIXfreshUntil int(11),\n DB_COLUMN_PREFIXrequest int(11),\n INDEX DB_TABLE_PREFIXLock_11039(DB_COLUMN_PREFIXlockId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'Lock\', 1, 0);\n\n','core',NULL,NULL),('MaintenanceMap',1,0,'CREATE TABLE DB_TABLE_PREFIXMaintenanceMap(\n DB_COLUMN_PREFIXrunId int(11) NOT NULL,\n DB_COLUMN_PREFIXtaskId varchar(128) NOT NULL,\n DB_COLUMN_PREFIXtimestamp int(11),\n DB_COLUMN_PREFIXsuccess int(1),\n DB_COLUMN_PREFIXdetails text,\n PRIMARY KEY(DB_COLUMN_PREFIXrunId),\n INDEX DB_TABLE_PREFIXMaintenanceMap_21687(DB_COLUMN_PREFIXtaskId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'MaintenanceMap\', 1, 0);\n\n','core','map','a:1:{s:21:\"GalleryMaintenanceMap\";a:5:{s:5:\"runId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:6:\"taskId\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:9:\"timestamp\";a:2:{s:4:\"type\";i:1;s:4:\"size\";i:2;}s:7:\"success\";a:2:{s:4:\"type\";i:8;s:4:\"size\";i:2;}s:7:\"details\";a:2:{s:4:\"type\";i:4;s:4:\"size\";i:1;}}}'),('MimeTypeMap',1,1,'CREATE TABLE DB_TABLE_PREFIXMimeTypeMap(\n DB_COLUMN_PREFIXextension varchar(32) NOT NULL,\n DB_COLUMN_PREFIXmimeType varchar(128) NOT NULL,\n DB_COLUMN_PREFIXviewable int(1),\n PRIMARY KEY(DB_COLUMN_PREFIXextension)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'MimeTypeMap\', 1, 1);\n\n','core','map','a:1:{s:18:\"GalleryMimeTypeMap\";a:3:{s:9:\"extension\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:8:\"mimeType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:8:\"viewable\";a:2:{s:4:\"type\";i:8;s:4:\"size\";i:2;}}}'),('MovieItem',1,0,'CREATE TABLE DB_TABLE_PREFIXMovieItem(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXwidth int(11),\n DB_COLUMN_PREFIXheight int(11),\n DB_COLUMN_PREFIXduration int(11),\n PRIMARY KEY(DB_COLUMN_PREFIXid)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'MovieItem\', 1, 0);\n\n','core','entity','a:1:{s:16:\"GalleryMovieItem\";a:4:{s:7:\"members\";a:3:{s:5:\"width\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:3;}s:6:\"height\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:3;}s:8:\"duration\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:3;}}s:6:\"parent\";s:15:\"GalleryDataItem\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:3:{i:0;s:5:\"width\";i:1;s:6:\"height\";i:2;s:8:\"duration\";}}}'),('PermissionSetMap',1,0,'CREATE TABLE DB_TABLE_PREFIXPermissionSetMap(\n DB_COLUMN_PREFIXmodule varchar(128) NOT NULL,\n DB_COLUMN_PREFIXpermission varchar(128) NOT NULL,\n DB_COLUMN_PREFIXdescription varchar(255),\n DB_COLUMN_PREFIXbits int(11) NOT NULL,\n DB_COLUMN_PREFIXflags int(11) NOT NULL,\n UNIQUE (DB_COLUMN_PREFIXpermission)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'PermissionSetMap\', 1, 0);\n\n','core','map','a:1:{s:23:\"GalleryPermissionSetMap\";a:5:{s:6:\"module\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:10:\"permission\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:11:\"description\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}s:4:\"bits\";a:3:{s:4:\"type\";i:64;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:5:\"flags\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('PhotoItem',1,0,'CREATE TABLE DB_TABLE_PREFIXPhotoItem(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXwidth int(11),\n DB_COLUMN_PREFIXheight int(11),\n PRIMARY KEY(DB_COLUMN_PREFIXid)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'PhotoItem\', 1, 0);\n\n','core','entity','a:1:{s:16:\"GalleryPhotoItem\";a:4:{s:7:\"members\";a:2:{s:5:\"width\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:1;}s:6:\"height\";a:2:{s:4:\"type\";i:1;s:15:\"external-access\";i:1;}}s:6:\"parent\";s:15:\"GalleryDataItem\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:2:{i:0;s:5:\"width\";i:1;s:6:\"height\";}}}'),('PluginMap',1,1,'CREATE TABLE DB_TABLE_PREFIXPluginMap(\n DB_COLUMN_PREFIXpluginType varchar(32) NOT NULL,\n DB_COLUMN_PREFIXpluginId varchar(32) NOT NULL,\n DB_COLUMN_PREFIXactive int(1) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXpluginType, DB_COLUMN_PREFIXpluginId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'PluginMap\', 1, 1);\n\n','core','map','a:1:{s:16:\"GalleryPluginMap\";a:3:{s:10:\"pluginType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:8:\"pluginId\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:6:\"active\";a:3:{s:4:\"type\";i:8;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('PluginPackageMap',1,1,'CREATE TABLE DB_TABLE_PREFIXPluginPackageMap(\n DB_COLUMN_PREFIXpluginType varchar(32) NOT NULL,\n DB_COLUMN_PREFIXpluginId varchar(32) NOT NULL,\n DB_COLUMN_PREFIXpackageName varchar(32) NOT NULL,\n DB_COLUMN_PREFIXpackageVersion varchar(32) NOT NULL,\n DB_COLUMN_PREFIXpackageBuild varchar(32) NOT NULL,\n DB_COLUMN_PREFIXlocked int(1) NOT NULL,\n INDEX DB_TABLE_PREFIXPluginPackageMap_80596(DB_COLUMN_PREFIXpluginType)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'PluginPackageMap\', 1, 1);\n\n','core','map','a:1:{s:23:\"GalleryPluginPackageMap\";a:6:{s:10:\"pluginType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:8:\"pluginId\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:11:\"packageName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:14:\"packageVersion\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:12:\"packageBuild\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:6:\"locked\";a:3:{s:4:\"type\";i:8;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('PluginParameterMap',1,3,'CREATE TABLE DB_TABLE_PREFIXPluginParameterMap(\n DB_COLUMN_PREFIXpluginType varchar(32) NOT NULL,\n DB_COLUMN_PREFIXpluginId varchar(32) NOT NULL,\n DB_COLUMN_PREFIXitemId int(11) NOT NULL,\n DB_COLUMN_PREFIXparameterName varchar(128) NOT NULL,\n DB_COLUMN_PREFIXparameterValue text NOT NULL,\n UNIQUE (DB_COLUMN_PREFIXpluginType, DB_COLUMN_PREFIXpluginId, DB_COLUMN_PREFIXitemId, DB_COLUMN_PREFIXparameterName),\n INDEX DB_TABLE_PREFIXPluginParameterMap_80596(DB_COLUMN_PREFIXpluginType),\n INDEX DB_TABLE_PREFIXPluginParameterMap_12808(DB_COLUMN_PREFIXpluginType, DB_COLUMN_PREFIXpluginId, DB_COLUMN_PREFIXitemId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'PluginParameterMap\', 1, 3);\n\n','core','map','a:1:{s:25:\"GalleryPluginParameterMap\";a:5:{s:10:\"pluginType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:8:\"pluginId\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:6:\"itemId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:13:\"parameterName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:14:\"parameterValue\";a:3:{s:4:\"type\";i:4;s:4:\"size\";i:1;s:19:\"notNullEmptyAllowed\";b:1;}}}'),('RatingCacheMap',1,0,'CREATE TABLE DB_TABLE_PREFIXRatingCacheMap(\n DB_COLUMN_PREFIXitemId int(11) NOT NULL,\n DB_COLUMN_PREFIXaverageRating int(11) NOT NULL,\n DB_COLUMN_PREFIXvoteCount int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXitemId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'RatingCacheMap\', 1, 0);\n\n','rating','map','a:1:{s:14:\"RatingCacheMap\";a:3:{s:6:\"itemId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:13:\"averageRating\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:9:\"voteCount\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('RatingMap',1,0,'CREATE TABLE DB_TABLE_PREFIXRatingMap(\n DB_COLUMN_PREFIXratingId int(11) NOT NULL,\n DB_COLUMN_PREFIXitemId int(11) NOT NULL,\n DB_COLUMN_PREFIXuserId int(11) NOT NULL,\n DB_COLUMN_PREFIXrating int(11) NOT NULL,\n DB_COLUMN_PREFIXsessionId varchar(128),\n DB_COLUMN_PREFIXremoteIdentifier varchar(255),\n PRIMARY KEY(DB_COLUMN_PREFIXratingId),\n INDEX DB_TABLE_PREFIXRatingMap_75985(DB_COLUMN_PREFIXitemId),\n INDEX DB_TABLE_PREFIXRatingMap_80383(DB_COLUMN_PREFIXitemId, DB_COLUMN_PREFIXuserId),\n INDEX DB_TABLE_PREFIXRatingMap_2369(DB_COLUMN_PREFIXitemId, DB_COLUMN_PREFIXremoteIdentifier)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'RatingMap\', 1, 0);\n\n','rating','map','a:1:{s:9:\"RatingMap\";a:6:{s:8:\"ratingId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:6:\"itemId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:6:\"userId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:6:\"rating\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:9:\"sessionId\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:16:\"remoteIdentifier\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}}}'),('RecoverPasswordMap',1,1,'CREATE TABLE DB_TABLE_PREFIXRecoverPasswordMap(\n DB_COLUMN_PREFIXuserName varchar(32) NOT NULL,\n DB_COLUMN_PREFIXauthString varchar(32) NOT NULL,\n DB_COLUMN_PREFIXrequestExpires int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXuserName)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'RecoverPasswordMap\', 1, 1);\n\n','core','map','a:1:{s:25:\"GalleryRecoverPasswordMap\";a:3:{s:8:\"userName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:10:\"authString\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:14:\"requestExpires\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('Schema',1,2,'CREATE TABLE DB_TABLE_PREFIXSchema(\n DB_COLUMN_PREFIXname varchar(128) NOT NULL,\n DB_COLUMN_PREFIXmajor int(11) NOT NULL,\n DB_COLUMN_PREFIXminor int(11) NOT NULL,\n DB_COLUMN_PREFIXcreateSql text,\n DB_COLUMN_PREFIXpluginId varchar(32),\n DB_COLUMN_PREFIXtype varchar(32),\n DB_COLUMN_PREFIXinfo text,\n PRIMARY KEY(DB_COLUMN_PREFIXname)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'Schema\', 1, 2);\n\n','core',NULL,NULL),('SessionMap',1,1,'CREATE TABLE DB_TABLE_PREFIXSessionMap(\n DB_COLUMN_PREFIXid varchar(32) NOT NULL,\n DB_COLUMN_PREFIXuserId int(11) NOT NULL,\n DB_COLUMN_PREFIXremoteIdentifier varchar(128) NOT NULL,\n DB_COLUMN_PREFIXcreationTimestamp int(11) NOT NULL,\n DB_COLUMN_PREFIXmodificationTimestamp int(11) NOT NULL,\n DB_COLUMN_PREFIXdata longtext,\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n INDEX DB_TABLE_PREFIXSessionMap_53500(DB_COLUMN_PREFIXuserId, DB_COLUMN_PREFIXcreationTimestamp, DB_COLUMN_PREFIXmodificationTimestamp)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'SessionMap\', 1, 1);\n\n','core','map','a:1:{s:17:\"GallerySessionMap\";a:6:{s:2:\"id\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:6:\"userId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:16:\"remoteIdentifier\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:17:\"creationTimestamp\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:21:\"modificationTimestamp\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:4:\"data\";a:2:{s:4:\"type\";i:4;s:4:\"size\";i:4;}}}'),('TkOperatnMap',1,0,'CREATE TABLE DB_TABLE_PREFIXTkOperatnMap(\n DB_COLUMN_PREFIXname varchar(128) NOT NULL,\n DB_COLUMN_PREFIXparametersCrc varchar(32) NOT NULL,\n DB_COLUMN_PREFIXoutputMimeType varchar(128),\n DB_COLUMN_PREFIXdescription varchar(255),\n PRIMARY KEY(DB_COLUMN_PREFIXname)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'TkOperatnMap\', 1, 0);\n\n','core','map','a:1:{s:26:\"GalleryToolkitOperationMap\";a:4:{s:4:\"name\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:13:\"parametersCrc\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";b:1;}s:14:\"outputMimeType\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:11:\"description\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}}}'),('TkOperatnMimeTypeMap',1,0,'CREATE TABLE DB_TABLE_PREFIXTkOperatnMimeTypeMap(\n DB_COLUMN_PREFIXoperationName varchar(128) NOT NULL,\n DB_COLUMN_PREFIXtoolkitId varchar(128) NOT NULL,\n DB_COLUMN_PREFIXmimeType varchar(128) NOT NULL,\n DB_COLUMN_PREFIXpriority int(11) NOT NULL,\n INDEX DB_TABLE_PREFIXTkOperatnMimeTypeMap_2014(DB_COLUMN_PREFIXoperationName),\n INDEX DB_TABLE_PREFIXTkOperatnMimeTypeMap_79463(DB_COLUMN_PREFIXmimeType)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'TkOperatnMimeTypeMap\', 1, 0);\n\n','core','map','a:1:{s:34:\"GalleryToolkitOperationMimeTypeMap\";a:4:{s:13:\"operationName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:9:\"toolkitId\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:8:\"mimeType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:8:\"priority\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('TkOperatnParameterMap',1,0,'CREATE TABLE DB_TABLE_PREFIXTkOperatnParameterMap(\n DB_COLUMN_PREFIXoperationName varchar(128) NOT NULL,\n DB_COLUMN_PREFIXposition int(11) NOT NULL,\n DB_COLUMN_PREFIXtype varchar(128) NOT NULL,\n DB_COLUMN_PREFIXdescription varchar(255),\n INDEX DB_TABLE_PREFIXTkOperatnParameterMap_2014(DB_COLUMN_PREFIXoperationName)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'TkOperatnParameterMap\', 1, 0);\n\n','core','map','a:1:{s:35:\"GalleryToolkitOperationParameterMap\";a:4:{s:13:\"operationName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:8:\"position\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:4:\"type\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:11:\"description\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}}}'),('TkPropertyMap',1,0,'CREATE TABLE DB_TABLE_PREFIXTkPropertyMap(\n DB_COLUMN_PREFIXname varchar(128) NOT NULL,\n DB_COLUMN_PREFIXtype varchar(128) NOT NULL,\n DB_COLUMN_PREFIXdescription varchar(128) NOT NULL\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'TkPropertyMap\', 1, 0);\n\n','core','map','a:1:{s:25:\"GalleryToolkitPropertyMap\";a:3:{s:4:\"name\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:4:\"type\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:11:\"description\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('TkPropertyMimeTypeMap',1,0,'CREATE TABLE DB_TABLE_PREFIXTkPropertyMimeTypeMap(\n DB_COLUMN_PREFIXpropertyName varchar(128) NOT NULL,\n DB_COLUMN_PREFIXtoolkitId varchar(128) NOT NULL,\n DB_COLUMN_PREFIXmimeType varchar(128) NOT NULL,\n INDEX DB_TABLE_PREFIXTkPropertyMimeTypeMap_52881(DB_COLUMN_PREFIXpropertyName),\n INDEX DB_TABLE_PREFIXTkPropertyMimeTypeMap_79463(DB_COLUMN_PREFIXmimeType)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'TkPropertyMimeTypeMap\', 1, 0);\n\n','core','map','a:1:{s:33:\"GalleryToolkitPropertyMimeTypeMap\";a:3:{s:12:\"propertyName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:9:\"toolkitId\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:8:\"mimeType\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}'),('UnknownItem',1,0,'CREATE TABLE DB_TABLE_PREFIXUnknownItem(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n PRIMARY KEY(DB_COLUMN_PREFIXid)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'UnknownItem\', 1, 0);\n\n','core','entity','a:1:{s:18:\"GalleryUnknownItem\";a:4:{s:7:\"members\";a:0:{}s:6:\"parent\";s:15:\"GalleryDataItem\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('User',1,2,'CREATE TABLE DB_TABLE_PREFIXUser(\n DB_COLUMN_PREFIXid int(11) NOT NULL,\n DB_COLUMN_PREFIXuserName varchar(32) NOT NULL,\n DB_COLUMN_PREFIXfullName varchar(128),\n DB_COLUMN_PREFIXhashedPassword varchar(128),\n DB_COLUMN_PREFIXemail varchar(255),\n DB_COLUMN_PREFIXlanguage varchar(128),\n DB_COLUMN_PREFIXlocked int(1) DEFAULT \'0\',\n PRIMARY KEY(DB_COLUMN_PREFIXid),\n UNIQUE (DB_COLUMN_PREFIXuserName)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'User\', 1, 2);\n\n','core','entity','a:1:{s:11:\"GalleryUser\";a:4:{s:7:\"members\";a:6:{s:8:\"userName\";a:4:{s:4:\"type\";i:2;s:4:\"size\";i:1;s:7:\"notNull\";i:1;s:15:\"external-access\";i:1;}s:8:\"fullName\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:3;}s:14:\"hashedPassword\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:2;}s:5:\"email\";a:2:{s:4:\"type\";i:2;s:4:\"size\";i:4;}s:8:\"language\";a:3:{s:4:\"type\";i:2;s:4:\"size\";i:2;s:15:\"external-access\";i:1;}s:6:\"locked\";a:1:{s:4:\"type\";i:8;}}s:6:\"parent\";s:13:\"GalleryEntity\";s:6:\"module\";s:4:\"core\";s:6:\"linked\";a:0:{}}}'),('UserGroupMap',1,0,'CREATE TABLE DB_TABLE_PREFIXUserGroupMap(\n DB_COLUMN_PREFIXuserId int(11) NOT NULL,\n DB_COLUMN_PREFIXgroupId int(11) NOT NULL,\n INDEX DB_TABLE_PREFIXUserGroupMap_69068(DB_COLUMN_PREFIXuserId),\n INDEX DB_TABLE_PREFIXUserGroupMap_89328(DB_COLUMN_PREFIXgroupId)\n) DB_TABLE_TYPE\n/*!40100 DEFAULT CHARACTER SET utf8 */;\n\nINSERT INTO DB_TABLE_PREFIXSchema (\n DB_COLUMN_PREFIXname,\n DB_COLUMN_PREFIXmajor,\n DB_COLUMN_PREFIXminor\n) VALUES(\'UserGroupMap\', 1, 0);\n\n','core','map','a:1:{s:19:\"GalleryUserGroupMap\";a:2:{s:6:\"userId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}s:7:\"groupId\";a:3:{s:4:\"type\";i:1;s:4:\"size\";i:2;s:7:\"notNull\";b:1;}}}');
/*!40000 ALTER TABLE `g2_Schema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_SequenceEventLog`
--

DROP TABLE IF EXISTS `g2_SequenceEventLog`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_SequenceEventLog` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_SequenceEventLog`
--

LOCK TABLES `g2_SequenceEventLog` WRITE;
/*!40000 ALTER TABLE `g2_SequenceEventLog` DISABLE KEYS */;
INSERT INTO `g2_SequenceEventLog` VALUES (0);
/*!40000 ALTER TABLE `g2_SequenceEventLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_SequenceId`
--

DROP TABLE IF EXISTS `g2_SequenceId`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_SequenceId` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_SequenceId`
--

LOCK TABLES `g2_SequenceId` WRITE;
/*!40000 ALTER TABLE `g2_SequenceId` DISABLE KEYS */;
INSERT INTO `g2_SequenceId` VALUES (14);
/*!40000 ALTER TABLE `g2_SequenceId` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_SequenceLock`
--

DROP TABLE IF EXISTS `g2_SequenceLock`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_SequenceLock` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_SequenceLock`
--

LOCK TABLES `g2_SequenceLock` WRITE;
/*!40000 ALTER TABLE `g2_SequenceLock` DISABLE KEYS */;
INSERT INTO `g2_SequenceLock` VALUES (0);
/*!40000 ALTER TABLE `g2_SequenceLock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_SessionMap`
--

DROP TABLE IF EXISTS `g2_SessionMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_SessionMap` (
  `g_id` varchar(32) NOT NULL,
  `g_userId` int(11) NOT NULL,
  `g_remoteIdentifier` varchar(128) NOT NULL,
  `g_creationTimestamp` int(11) NOT NULL,
  `g_modificationTimestamp` int(11) NOT NULL,
  `g_data` longtext,
  PRIMARY KEY  (`g_id`),
  KEY `g2_SessionMap_53500` (`g_userId`,`g_creationTimestamp`,`g_modificationTimestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_SessionMap`
--

LOCK TABLES `g2_SessionMap` WRITE;
/*!40000 ALTER TABLE `g2_SessionMap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_SessionMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_TkOperatnMap`
--

DROP TABLE IF EXISTS `g2_TkOperatnMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_TkOperatnMap` (
  `g_name` varchar(128) NOT NULL,
  `g_parametersCrc` varchar(32) NOT NULL,
  `g_outputMimeType` varchar(128) default NULL,
  `g_description` varchar(255) default NULL,
  PRIMARY KEY  (`g_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_TkOperatnMap`
--

LOCK TABLES `g2_TkOperatnMap` WRITE;
/*!40000 ALTER TABLE `g2_TkOperatnMap` DISABLE KEYS */;
INSERT INTO `g2_TkOperatnMap` VALUES ('composite','1204337430','','Overlay source image with a second one'),('compress','340908721','','Reduce image quality to reach target file size'),('convert-to-image/gif','0','image/gif','Convert to image/gif'),('convert-to-image/jp2','0','image/jp2','Convert to image/jp2'),('convert-to-image/jpeg','0','image/jpeg','Convert to image/jpeg'),('convert-to-image/png','0','image/png','Convert to image/png'),('convert-to-image/tiff','0','image/tiff','Convert to image/tiff'),('crop','729751051','','Crop the image'),('extract','0','','extract files from an archive'),('resize','3155881288','','Resize the image to the target dimensions'),('rotate','340908721','','Rotate the image'),('scale','3155881288','','Scale the image to the target size, maintain aspect ratio'),('select-page','340908721','','Select a single page from a multi-page file'),('thumbnail','3155881288','','Scale the image to the target size, maintain aspect ratio');
/*!40000 ALTER TABLE `g2_TkOperatnMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_TkOperatnMimeTypeMap`
--

DROP TABLE IF EXISTS `g2_TkOperatnMimeTypeMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_TkOperatnMimeTypeMap` (
  `g_operationName` varchar(128) NOT NULL,
  `g_toolkitId` varchar(128) NOT NULL,
  `g_mimeType` varchar(128) NOT NULL,
  `g_priority` int(11) NOT NULL,
  KEY `g2_TkOperatnMimeTypeMap_2014` (`g_operationName`),
  KEY `g2_TkOperatnMimeTypeMap_79463` (`g_mimeType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_TkOperatnMimeTypeMap`
--

LOCK TABLES `g2_TkOperatnMimeTypeMap` WRITE;
/*!40000 ALTER TABLE `g2_TkOperatnMimeTypeMap` DISABLE KEYS */;
INSERT INTO `g2_TkOperatnMimeTypeMap` VALUES ('extract','ArchiveUpload','application/zip',5),('convert-to-image/jpeg','ImageMagick','image/gif',21),('convert-to-image/jpeg','ImageMagick','image/pjpeg',21),('convert-to-image/jpeg','ImageMagick','image/jp2',21),('convert-to-image/jpeg','ImageMagick','image/jpg2',21),('convert-to-image/jpeg','ImageMagick','image/jpx',21),('convert-to-image/jpeg','ImageMagick','image/png',21),('convert-to-image/jpeg','ImageMagick','image/tiff',21),('convert-to-image/jpeg','ImageMagick','image/svg+xml',21),('convert-to-image/jpeg','ImageMagick','image/bmp',21),('convert-to-image/jpeg','ImageMagick','application/pdf',21),('convert-to-image/jpeg','ImageMagick','application/postscript',21),('convert-to-image/jpeg','ImageMagick','application/photoshop',21),('convert-to-image/jpeg','ImageMagick','image/x-photo-cd',21),('convert-to-image/jpeg','ImageMagick','image/tga',21),('convert-to-image/jpeg','ImageMagick','image/jpeg-cmyk',21),('convert-to-image/jpeg','ImageMagick','image/tiff-cmyk',21),('convert-to-image/jpeg','ImageMagick','application/photoshop-cmyk',21),('convert-to-image/jpeg','ImageMagick','image/x-portable-pixmap',21),('convert-to-image/png','ImageMagick','image/gif',21),('convert-to-image/png','ImageMagick','image/jpeg',21),('convert-to-image/png','ImageMagick','image/pjpeg',21),('convert-to-image/png','ImageMagick','image/jp2',21),('convert-to-image/png','ImageMagick','image/jpg2',21),('convert-to-image/png','ImageMagick','image/jpx',21),('convert-to-image/png','ImageMagick','image/tiff',21),('convert-to-image/png','ImageMagick','image/svg+xml',21),('convert-to-image/png','ImageMagick','image/bmp',21),('convert-to-image/png','ImageMagick','application/pdf',21),('convert-to-image/png','ImageMagick','application/postscript',21),('convert-to-image/png','ImageMagick','application/photoshop',21),('convert-to-image/png','ImageMagick','image/x-photo-cd',21),('convert-to-image/png','ImageMagick','image/tga',21),('convert-to-image/png','ImageMagick','image/jpeg-cmyk',21),('convert-to-image/png','ImageMagick','image/tiff-cmyk',21),('convert-to-image/png','ImageMagick','application/photoshop-cmyk',21),('convert-to-image/png','ImageMagick','image/x-portable-pixmap',21),('convert-to-image/gif','ImageMagick','image/jpeg',21),('convert-to-image/gif','ImageMagick','image/pjpeg',21),('convert-to-image/gif','ImageMagick','image/jp2',21),('convert-to-image/gif','ImageMagick','image/jpg2',21),('convert-to-image/gif','ImageMagick','image/jpx',21),('convert-to-image/gif','ImageMagick','image/png',21),('convert-to-image/gif','ImageMagick','image/tiff',21),('convert-to-image/gif','ImageMagick','image/svg+xml',21),('convert-to-image/gif','ImageMagick','image/bmp',21),('convert-to-image/gif','ImageMagick','application/pdf',21),('convert-to-image/gif','ImageMagick','application/postscript',21),('convert-to-image/gif','ImageMagick','application/photoshop',21),('convert-to-image/gif','ImageMagick','image/x-photo-cd',21),('convert-to-image/gif','ImageMagick','image/tga',21),('convert-to-image/gif','ImageMagick','image/jpeg-cmyk',21),('convert-to-image/gif','ImageMagick','image/tiff-cmyk',21),('convert-to-image/gif','ImageMagick','application/photoshop-cmyk',21),('convert-to-image/gif','ImageMagick','image/x-portable-pixmap',21),('convert-to-image/tiff','ImageMagick','image/gif',21),('convert-to-image/tiff','ImageMagick','image/jpeg',21),('convert-to-image/tiff','ImageMagick','image/pjpeg',21),('convert-to-image/tiff','ImageMagick','image/jp2',21),('convert-to-image/tiff','ImageMagick','image/jpg2',21),('convert-to-image/tiff','ImageMagick','image/jpx',21),('convert-to-image/tiff','ImageMagick','image/png',21),('convert-to-image/tiff','ImageMagick','image/svg+xml',21),('convert-to-image/tiff','ImageMagick','image/bmp',21),('convert-to-image/tiff','ImageMagick','application/pdf',21),('convert-to-image/tiff','ImageMagick','application/postscript',21),('convert-to-image/tiff','ImageMagick','application/photoshop',21),('convert-to-image/tiff','ImageMagick','image/x-photo-cd',21),('convert-to-image/tiff','ImageMagick','image/tga',21),('convert-to-image/tiff','ImageMagick','image/jpeg-cmyk',21),('convert-to-image/tiff','ImageMagick','image/tiff-cmyk',21),('convert-to-image/tiff','ImageMagick','application/photoshop-cmyk',21),('convert-to-image/tiff','ImageMagick','image/x-portable-pixmap',21),('convert-to-image/jp2','ImageMagick','image/gif',21),('convert-to-image/jp2','ImageMagick','image/jpeg',21),('convert-to-image/jp2','ImageMagick','image/pjpeg',21),('convert-to-image/jp2','ImageMagick','image/jpg2',21),('convert-to-image/jp2','ImageMagick','image/jpx',21),('convert-to-image/jp2','ImageMagick','image/png',21),('convert-to-image/jp2','ImageMagick','image/tiff',21),('convert-to-image/jp2','ImageMagick','image/svg+xml',21),('convert-to-image/jp2','ImageMagick','image/bmp',21),('convert-to-image/jp2','ImageMagick','application/pdf',21),('convert-to-image/jp2','ImageMagick','application/postscript',21),('convert-to-image/jp2','ImageMagick','application/photoshop',21),('convert-to-image/jp2','ImageMagick','image/x-photo-cd',21),('convert-to-image/jp2','ImageMagick','image/tga',21),('convert-to-image/jp2','ImageMagick','image/jpeg-cmyk',21),('convert-to-image/jp2','ImageMagick','image/tiff-cmyk',21),('convert-to-image/jp2','ImageMagick','application/photoshop-cmyk',21),('convert-to-image/jp2','ImageMagick','image/x-portable-pixmap',21),('scale','ImageMagick','image/gif',21),('scale','ImageMagick','image/jpeg',21),('scale','ImageMagick','image/pjpeg',21),('scale','ImageMagick','image/jp2',21),('scale','ImageMagick','image/jpg2',21),('scale','ImageMagick','image/jpx',21),('scale','ImageMagick','image/png',21),('scale','ImageMagick','image/tiff',21),('scale','ImageMagick','image/svg+xml',21),('scale','ImageMagick','image/bmp',21),('scale','ImageMagick','application/pdf',21),('scale','ImageMagick','application/postscript',21),('scale','ImageMagick','application/photoshop',21),('scale','ImageMagick','image/x-photo-cd',21),('scale','ImageMagick','image/tga',21),('scale','ImageMagick','image/jpeg-cmyk',21),('scale','ImageMagick','image/tiff-cmyk',21),('scale','ImageMagick','application/photoshop-cmyk',21),('thumbnail','ImageMagick','image/gif',21),('thumbnail','ImageMagick','image/jpeg',21),('thumbnail','ImageMagick','image/pjpeg',21),('thumbnail','ImageMagick','image/jp2',21),('thumbnail','ImageMagick','image/jpg2',21),('thumbnail','ImageMagick','image/jpx',21),('thumbnail','ImageMagick','image/png',21),('thumbnail','ImageMagick','image/tiff',21),('thumbnail','ImageMagick','image/svg+xml',21),('thumbnail','ImageMagick','image/bmp',21),('thumbnail','ImageMagick','application/pdf',21),('thumbnail','ImageMagick','application/postscript',21),('thumbnail','ImageMagick','application/photoshop',21),('thumbnail','ImageMagick','image/x-photo-cd',21),('thumbnail','ImageMagick','image/tga',21),('thumbnail','ImageMagick','image/jpeg-cmyk',21),('thumbnail','ImageMagick','image/tiff-cmyk',21),('thumbnail','ImageMagick','application/photoshop-cmyk',21),('resize','ImageMagick','image/gif',21),('resize','ImageMagick','image/jpeg',21),('resize','ImageMagick','image/pjpeg',21),('resize','ImageMagick','image/jp2',21),('resize','ImageMagick','image/jpg2',21),('resize','ImageMagick','image/jpx',21),('resize','ImageMagick','image/png',21),('resize','ImageMagick','image/tiff',21),('resize','ImageMagick','image/svg+xml',21),('resize','ImageMagick','image/bmp',21),('resize','ImageMagick','application/pdf',21),('resize','ImageMagick','application/postscript',21),('resize','ImageMagick','application/photoshop',21),('resize','ImageMagick','image/x-photo-cd',21),('resize','ImageMagick','image/tga',21),('resize','ImageMagick','image/jpeg-cmyk',21),('resize','ImageMagick','image/tiff-cmyk',21),('resize','ImageMagick','application/photoshop-cmyk',21),('rotate','ImageMagick','image/gif',21),('rotate','ImageMagick','image/jpeg',21),('rotate','ImageMagick','image/pjpeg',21),('rotate','ImageMagick','image/jp2',21),('rotate','ImageMagick','image/jpg2',21),('rotate','ImageMagick','image/jpx',21),('rotate','ImageMagick','image/png',21),('rotate','ImageMagick','image/tiff',21),('rotate','ImageMagick','image/svg+xml',21),('rotate','ImageMagick','image/bmp',21),('rotate','ImageMagick','application/pdf',21),('rotate','ImageMagick','application/postscript',21),('rotate','ImageMagick','application/photoshop',21),('rotate','ImageMagick','image/x-photo-cd',21),('rotate','ImageMagick','image/tga',21),('rotate','ImageMagick','image/jpeg-cmyk',21),('rotate','ImageMagick','image/tiff-cmyk',21),('rotate','ImageMagick','application/photoshop-cmyk',21),('crop','ImageMagick','image/gif',21),('crop','ImageMagick','image/jpeg',21),('crop','ImageMagick','image/pjpeg',21),('crop','ImageMagick','image/jp2',21),('crop','ImageMagick','image/jpg2',21),('crop','ImageMagick','image/jpx',21),('crop','ImageMagick','image/png',21),('crop','ImageMagick','image/tiff',21),('crop','ImageMagick','image/svg+xml',21),('crop','ImageMagick','image/bmp',21),('crop','ImageMagick','application/pdf',21),('crop','ImageMagick','application/postscript',21),('crop','ImageMagick','application/photoshop',21),('crop','ImageMagick','image/x-photo-cd',21),('crop','ImageMagick','image/tga',21),('crop','ImageMagick','image/jpeg-cmyk',21),('crop','ImageMagick','image/tiff-cmyk',21),('crop','ImageMagick','application/photoshop-cmyk',21),('composite','ImageMagick','image/gif',21),('composite','ImageMagick','image/jpeg',21),('composite','ImageMagick','image/pjpeg',21),('composite','ImageMagick','image/jp2',21),('composite','ImageMagick','image/jpg2',21),('composite','ImageMagick','image/jpx',21),('composite','ImageMagick','image/png',21),('composite','ImageMagick','image/tiff',21),('composite','ImageMagick','image/svg+xml',21),('composite','ImageMagick','image/bmp',21),('composite','ImageMagick','application/pdf',21),('composite','ImageMagick','application/postscript',21),('composite','ImageMagick','application/photoshop',21),('composite','ImageMagick','image/x-photo-cd',21),('composite','ImageMagick','image/tga',21),('composite','ImageMagick','image/jpeg-cmyk',21),('composite','ImageMagick','image/tiff-cmyk',21),('composite','ImageMagick','application/photoshop-cmyk',21),('select-page','ImageMagick','image/tiff',21),('select-page','ImageMagick','application/pdf',21),('select-page','ImageMagick','application/postscript',21),('select-page','ImageMagick','application/photoshop',21),('compress','ImageMagick','image/jpeg',21),('compress','ImageMagick','image/png',21),('convert-to-image/jpeg','NetPBM','image/x-portable-pixmap',22),('convert-to-image/jpeg','NetPBM','image/tiff',22),('scale','NetPBM','image/jpeg',22),('scale','NetPBM','image/pjpeg',22),('scale','NetPBM','image/gif',22),('scale','NetPBM','image/png',22),('scale','NetPBM','image/tiff',22),('scale','NetPBM','image/bmp',22),('thumbnail','NetPBM','image/jpeg',22),('thumbnail','NetPBM','image/pjpeg',22),('thumbnail','NetPBM','image/gif',22),('thumbnail','NetPBM','image/png',22),('thumbnail','NetPBM','image/tiff',22),('thumbnail','NetPBM','image/bmp',22),('resize','NetPBM','image/jpeg',22),('resize','NetPBM','image/pjpeg',22),('resize','NetPBM','image/gif',22),('resize','NetPBM','image/png',22),('resize','NetPBM','image/tiff',22),('resize','NetPBM','image/bmp',22),('rotate','NetPBM','image/jpeg',22),('rotate','NetPBM','image/pjpeg',22),('rotate','NetPBM','image/gif',22),('rotate','NetPBM','image/png',22),('rotate','NetPBM','image/tiff',22),('rotate','NetPBM','image/bmp',22),('crop','NetPBM','image/jpeg',22),('crop','NetPBM','image/pjpeg',22),('crop','NetPBM','image/gif',22),('crop','NetPBM','image/png',22),('crop','NetPBM','image/tiff',22),('crop','NetPBM','image/bmp',22),('composite','NetPBM','image/jpeg',22),('composite','NetPBM','image/pjpeg',22),('composite','NetPBM','image/gif',22),('composite','NetPBM','image/png',22),('composite','NetPBM','image/tiff',22),('composite','NetPBM','image/bmp',22),('compress','NetPBM','image/jpeg',22),('compress','NetPBM','image/pjpeg',22),('convert-to-image/jpeg','Gd','image/gif',23),('convert-to-image/jpeg','Gd','image/jpeg',23),('convert-to-image/jpeg','Gd','image/png',23),('convert-to-image/jpeg','Gd','image/vnd.wap.wbmp',23),('convert-to-image/jpeg','Gd','image/x-xbitmap',23),('scale','Gd','image/gif',23),('scale','Gd','image/jpeg',23),('scale','Gd','image/png',23),('scale','Gd','image/vnd.wap.wbmp',23),('scale','Gd','image/x-xbitmap',23),('thumbnail','Gd','image/gif',23),('thumbnail','Gd','image/jpeg',23),('thumbnail','Gd','image/png',23),('thumbnail','Gd','image/vnd.wap.wbmp',23),('thumbnail','Gd','image/x-xbitmap',23),('resize','Gd','image/gif',23),('resize','Gd','image/jpeg',23),('resize','Gd','image/png',23),('resize','Gd','image/vnd.wap.wbmp',23),('resize','Gd','image/x-xbitmap',23),('rotate','Gd','image/gif',23),('rotate','Gd','image/jpeg',23),('rotate','Gd','image/png',23),('rotate','Gd','image/vnd.wap.wbmp',23),('rotate','Gd','image/x-xbitmap',23),('crop','Gd','image/gif',23),('crop','Gd','image/jpeg',23),('crop','Gd','image/png',23),('crop','Gd','image/vnd.wap.wbmp',23),('crop','Gd','image/x-xbitmap',23),('composite','Gd','image/gif',23),('composite','Gd','image/jpeg',23),('composite','Gd','image/png',23),('composite','Gd','image/vnd.wap.wbmp',23),('composite','Gd','image/x-xbitmap',23),('compress','Gd','image/jpeg',23);
/*!40000 ALTER TABLE `g2_TkOperatnMimeTypeMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_TkOperatnParameterMap`
--

DROP TABLE IF EXISTS `g2_TkOperatnParameterMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_TkOperatnParameterMap` (
  `g_operationName` varchar(128) NOT NULL,
  `g_position` int(11) NOT NULL,
  `g_type` varchar(128) NOT NULL,
  `g_description` varchar(255) default NULL,
  KEY `g2_TkOperatnParameterMap_2014` (`g_operationName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_TkOperatnParameterMap`
--

LOCK TABLES `g2_TkOperatnParameterMap` WRITE;
/*!40000 ALTER TABLE `g2_TkOperatnParameterMap` DISABLE KEYS */;
INSERT INTO `g2_TkOperatnParameterMap` VALUES ('scale',0,'int','target width (# pixels or #% of full size)'),('scale',1,'int','(optional) target height, defaults to same as width'),('thumbnail',0,'int','target width (# pixels or #% of full size)'),('thumbnail',1,'int','(optional) target height, defaults to same as width'),('resize',0,'int','target width (# pixels or #% of full size)'),('resize',1,'int','target height (# pixels or #% of full size)'),('rotate',0,'int','rotation degrees'),('crop',0,'float','left edge %'),('crop',1,'float','top edge %'),('crop',2,'float','width %'),('crop',3,'float','height %'),('composite',0,'string','overlay path'),('composite',1,'string','overlay mime type'),('composite',2,'int','overlay width'),('composite',3,'int','overlay height'),('composite',4,'string','alignment type'),('composite',5,'int','alignment x %'),('composite',6,'int','alignment y %'),('select-page',0,'int','page number'),('compress',0,'int','target size in kb');
/*!40000 ALTER TABLE `g2_TkOperatnParameterMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_TkPropertyMap`
--

DROP TABLE IF EXISTS `g2_TkPropertyMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_TkPropertyMap` (
  `g_name` varchar(128) NOT NULL,
  `g_type` varchar(128) NOT NULL,
  `g_description` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_TkPropertyMap`
--

LOCK TABLES `g2_TkPropertyMap` WRITE;
/*!40000 ALTER TABLE `g2_TkPropertyMap` DISABLE KEYS */;
INSERT INTO `g2_TkPropertyMap` VALUES ('originationTimestamp','int','Get the origination timestamp'),('dimensions','int,int','Get the width and height of the image'),('page-count','int','Get the number of pages');
/*!40000 ALTER TABLE `g2_TkPropertyMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_TkPropertyMimeTypeMap`
--

DROP TABLE IF EXISTS `g2_TkPropertyMimeTypeMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_TkPropertyMimeTypeMap` (
  `g_propertyName` varchar(128) NOT NULL,
  `g_toolkitId` varchar(128) NOT NULL,
  `g_mimeType` varchar(128) NOT NULL,
  KEY `g2_TkPropertyMimeTypeMap_52881` (`g_propertyName`),
  KEY `g2_TkPropertyMimeTypeMap_79463` (`g_mimeType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_TkPropertyMimeTypeMap`
--

LOCK TABLES `g2_TkPropertyMimeTypeMap` WRITE;
/*!40000 ALTER TABLE `g2_TkPropertyMimeTypeMap` DISABLE KEYS */;
INSERT INTO `g2_TkPropertyMimeTypeMap` VALUES ('originationTimestamp','Exif','image/jpeg'),('originationTimestamp','Exif','image/pjpeg'),('originationTimestamp','Exif','image/jpeg-cmyk'),('originationTimestamp','Exif','image/pjpeg-cmyk'),('originationTimestamp','Exif','image/x-dcraw'),('dimensions','ImageMagick','image/gif'),('dimensions','ImageMagick','image/jpeg'),('dimensions','ImageMagick','image/pjpeg'),('dimensions','ImageMagick','image/jp2'),('dimensions','ImageMagick','image/jpg2'),('dimensions','ImageMagick','image/jpx'),('dimensions','ImageMagick','image/png'),('dimensions','ImageMagick','image/tiff'),('dimensions','ImageMagick','image/svg+xml'),('dimensions','ImageMagick','image/bmp'),('dimensions','ImageMagick','application/pdf'),('dimensions','ImageMagick','application/postscript'),('dimensions','ImageMagick','application/photoshop'),('dimensions','ImageMagick','image/x-photo-cd'),('dimensions','ImageMagick','image/tga'),('dimensions','ImageMagick','image/jpeg-cmyk'),('dimensions','ImageMagick','image/tiff-cmyk'),('dimensions','ImageMagick','application/photoshop-cmyk'),('dimensions','ImageMagick','image/x-portable-pixmap'),('dimensions','ImageMagick','application/x-shockwave-flash'),('page-count','ImageMagick','image/tiff'),('page-count','ImageMagick','application/pdf'),('page-count','ImageMagick','application/postscript'),('page-count','ImageMagick','application/photoshop'),('dimensions','NetPBM','image/jpeg'),('dimensions','NetPBM','image/pjpeg'),('dimensions','NetPBM','image/gif'),('dimensions','NetPBM','image/png'),('dimensions','NetPBM','image/tiff'),('dimensions','NetPBM','image/bmp'),('dimensions','NetPBM','image/x-portable-pixmap'),('dimensions','NetPBM','application/x-shockwave-flash'),('dimensions','Gd','image/gif'),('dimensions','Gd','image/jpeg'),('dimensions','Gd','image/png'),('dimensions','Gd','image/vnd.wap.wbmp'),('dimensions','Gd','image/x-xbitmap'),('dimensions','Gd','application/x-shockwave-flash');
/*!40000 ALTER TABLE `g2_TkPropertyMimeTypeMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_UnknownItem`
--

DROP TABLE IF EXISTS `g2_UnknownItem`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_UnknownItem` (
  `g_id` int(11) NOT NULL,
  PRIMARY KEY  (`g_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_UnknownItem`
--

LOCK TABLES `g2_UnknownItem` WRITE;
/*!40000 ALTER TABLE `g2_UnknownItem` DISABLE KEYS */;
/*!40000 ALTER TABLE `g2_UnknownItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_User`
--

DROP TABLE IF EXISTS `g2_User`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_User` (
  `g_id` int(11) NOT NULL,
  `g_userName` varchar(32) NOT NULL,
  `g_fullName` varchar(128) default NULL,
  `g_hashedPassword` varchar(128) default NULL,
  `g_email` varchar(255) default NULL,
  `g_language` varchar(128) default NULL,
  `g_locked` int(1) default '0',
  PRIMARY KEY  (`g_id`),
  UNIQUE KEY `g_userName` (`g_userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_User`
--

LOCK TABLES `g2_User` WRITE;
/*!40000 ALTER TABLE `g2_User` DISABLE KEYS */;
INSERT INTO `g2_User` VALUES (5,'guest','Guest','MsV_c30f02c5a59a1c62a7355f57164f0fb5',NULL,NULL,0),(6,'admin','Gallery Administrator','8S]oe1c3f075ac068a44adce656dfe96eeea','justin.lyon@gmail.com',NULL,0);
/*!40000 ALTER TABLE `g2_User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g2_UserGroupMap`
--

DROP TABLE IF EXISTS `g2_UserGroupMap`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `g2_UserGroupMap` (
  `g_userId` int(11) NOT NULL,
  `g_groupId` int(11) NOT NULL,
  KEY `g2_UserGroupMap_69068` (`g_userId`),
  KEY `g2_UserGroupMap_89328` (`g_groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `g2_UserGroupMap`
--

LOCK TABLES `g2_UserGroupMap` WRITE;
/*!40000 ALTER TABLE `g2_UserGroupMap` DISABLE KEYS */;
INSERT INTO `g2_UserGroupMap` VALUES (5,4),(6,2),(6,4),(6,3);
/*!40000 ALTER TABLE `g2_UserGroupMap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gtst0Schema`
--

DROP TABLE IF EXISTS `gtst0Schema`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `gtst0Schema` (
  `g_name` varchar(128) NOT NULL,
  `g_major` int(11) NOT NULL,
  `g_minor` int(11) NOT NULL,
  `g_testCol` varchar(128) default NULL,
  PRIMARY KEY  (`g_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `gtst0Schema`
--

LOCK TABLES `gtst0Schema` WRITE;
/*!40000 ALTER TABLE `gtst0Schema` DISABLE KEYS */;
INSERT INTO `gtst0Schema` VALUES ('Schema',1,2,NULL);
/*!40000 ALTER TABLE `gtst0Schema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_assets`
--

DROP TABLE IF EXISTS `jos_assets`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_assets` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL default '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_assets`
--

LOCK TABLES `jos_assets` WRITE;
/*!40000 ALTER TABLE `jos_assets` DISABLE KEYS */;
INSERT INTO `jos_assets` VALUES (1,0,0,61,0,'root.1','Root Asset','{\"core.login.site\":{\"6\":1,\"2\":1},\"core.login.admin\":{\"6\":1},\"core.admin\":{\"8\":1},\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1}}'),(2,1,1,2,1,'com_admin','com_admin','{}'),(3,1,3,6,1,'com_banners','com_banners','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(4,1,7,8,1,'com_cache','com_cache','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(5,1,9,10,1,'com_checkin','com_checkin','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(6,1,11,12,1,'com_config','com_config','{}'),(7,1,13,16,1,'com_contact','com_contact','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(8,1,17,20,1,'com_content','com_content','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1}}'),(9,1,21,22,1,'com_cpanel','com_cpanel','{}'),(10,1,23,24,1,'com_installer','com_installer','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1},\"core.create\":[],\"core.delete\":[],\"core.edit.state\":[]}'),(11,1,25,26,1,'com_languages','com_languages','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(12,1,27,28,1,'com_login','com_login','{}'),(13,1,29,30,1,'com_mailto','com_mailto','{}'),(14,1,31,32,1,'com_massmail','com_massmail','{}'),(15,1,33,34,1,'com_media','com_media','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":{\"5\":1},\"core.edit\":[],\"core.edit.state\":[]}'),(16,1,35,36,1,'com_menus','com_menus','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(17,1,37,38,1,'com_messages','com_messages','{}'),(18,1,39,40,1,'com_modules','com_modules','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(19,1,41,44,1,'com_newsfeeds','com_newsfeeds','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(20,1,45,46,1,'com_plugins','com_plugins','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(21,1,47,48,1,'com_redirect','com_redirect','{\"core.admin\":{\"7\":1},\"core.manage\":[]}'),(22,1,49,50,1,'com_search','com_search','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(23,1,51,52,1,'com_templates','com_templates','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(24,1,53,54,1,'com_users','com_users','{\"core.admin\":{\"7\":1},\"core.manage\":[],\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(25,1,55,58,1,'com_weblinks','com_weblinks','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":[],\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1}}'),(26,1,59,60,1,'com_wrapper','com_wrapper','{}'),(27,8,18,19,2,'com_content.category.2','Uncategorized','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(28,3,4,5,2,'com_banners.category.3','Uncategorized','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(29,7,14,15,2,'com_contact.category.4','Uncategorized','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(30,19,42,43,2,'com_newsfeeds.category.5','Uncategorized','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}'),(31,25,56,57,2,'com_weblinks.category.6','Uncategorized','{\"core.create\":[],\"core.delete\":[],\"core.edit\":[],\"core.edit.state\":[]}');
/*!40000 ALTER TABLE `jos_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_banner_clients`
--

DROP TABLE IF EXISTS `jos_banner_clients`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_banner_clients` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `metakey` text NOT NULL,
  `own_prefix` tinyint(4) NOT NULL default '0',
  `metakey_prefix` varchar(255) NOT NULL default '',
  `purchase_type` tinyint(4) NOT NULL default '-1',
  `track_clicks` tinyint(4) NOT NULL default '-1',
  `track_impressions` tinyint(4) NOT NULL default '-1',
  PRIMARY KEY  (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_banner_clients`
--

LOCK TABLES `jos_banner_clients` WRITE;
/*!40000 ALTER TABLE `jos_banner_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_banner_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_banner_tracks`
--

DROP TABLE IF EXISTS `jos_banner_tracks`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_banner_tracks` (
  `track_date` date NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_banner_tracks`
--

LOCK TABLES `jos_banner_tracks` WRITE;
/*!40000 ALTER TABLE `jos_banner_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_banner_tracks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_banners`
--

DROP TABLE IF EXISTS `jos_banners`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_banners` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `clickurl` varchar(200) NOT NULL default '',
  `state` tinyint(3) NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `custombannercode` varchar(2048) NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `params` text NOT NULL,
  `own_prefix` tinyint(1) NOT NULL default '0',
  `metakey_prefix` varchar(255) NOT NULL default '',
  `purchase_type` tinyint(4) NOT NULL default '-1',
  `track_clicks` tinyint(4) NOT NULL default '-1',
  `track_impressions` tinyint(4) NOT NULL default '-1',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `reset` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `language` char(7) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_banners`
--

LOCK TABLES `jos_banners` WRITE;
/*!40000 ALTER TABLE `jos_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_categories`
--

DROP TABLE IF EXISTS `jos_categories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_categories` (
  `id` int(11) NOT NULL auto_increment,
  `asset_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `level` int(10) unsigned NOT NULL default '0',
  `path` varchar(255) NOT NULL default '',
  `extension` varchar(50) NOT NULL default '',
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `description` varchar(5120) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `params` varchar(2048) NOT NULL default '',
  `metadesc` varchar(1024) NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL default '0',
  `created_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL default '0',
  `modified_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL default '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_categories`
--

LOCK TABLES `jos_categories` WRITE;
/*!40000 ALTER TABLE `jos_categories` DISABLE KEYS */;
INSERT INTO `jos_categories` VALUES (1,0,0,0,11,0,'','system','ROOT','root','','',1,0,'0000-00-00 00:00:00',1,'{}','','','',0,'2009-10-18 16:07:09',0,'0000-00-00 00:00:00',0,'*'),(2,27,1,1,2,1,'uncategorized','com_content','Uncategorized','uncategorized','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:26:37',0,'0000-00-00 00:00:00',0,'*'),(3,28,1,3,4,1,'uncategorized','com_banners','Uncategorized','uncategorized','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\",\"foobar\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:27:35',0,'0000-00-00 00:00:00',0,'*'),(4,29,1,5,6,1,'uncategorized','com_contact','Uncategorized','uncategorized','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:27:57',0,'0000-00-00 00:00:00',0,'*'),(5,30,1,7,8,1,'uncategorized','com_newsfeeds','Uncategorized','uncategorized','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:28:15',0,'0000-00-00 00:00:00',0,'*'),(6,31,1,9,10,1,'uncategorized','com_weblinks','Uncategorized','uncategorized','','',1,0,'0000-00-00 00:00:00',1,'{\"target\":\"\",\"image\":\"\"}','','','{\"page_title\":\"\",\"author\":\"\",\"robots\":\"\"}',42,'2010-06-28 13:28:33',0,'0000-00-00 00:00:00',0,'*');
/*!40000 ALTER TABLE `jos_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_contact_details`
--

DROP TABLE IF EXISTS `jos_contact_details`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `con_position` varchar(255) default NULL,
  `address` text,
  `suburb` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) default NULL,
  `postcode` varchar(100) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  `sortname1` varchar(255) NOT NULL,
  `sortname2` varchar(255) NOT NULL,
  `sortname3` varchar(255) NOT NULL,
  `language` char(7) NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_contact_details`
--

LOCK TABLES `jos_contact_details` WRITE;
/*!40000 ALTER TABLE `jos_contact_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_contact_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_content`
--

DROP TABLE IF EXISTS `jos_content`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `asset_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `title_alias` varchar(255) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(10) unsigned NOT NULL default '0',
  `mask` int(10) unsigned NOT NULL default '0',
  `catid` int(10) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` varchar(5120) NOT NULL,
  `version` int(10) unsigned NOT NULL default '1',
  `parentid` int(10) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if article is featured.',
  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_content`
--

LOCK TABLES `jos_content` WRITE;
/*!40000 ALTER TABLE `jos_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_content_frontpage`
--

DROP TABLE IF EXISTS `jos_content_frontpage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_content_frontpage`
--

LOCK TABLES `jos_content_frontpage` WRITE;
/*!40000 ALTER TABLE `jos_content_frontpage` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_content_frontpage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_content_rating`
--

DROP TABLE IF EXISTS `jos_content_rating`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(10) unsigned NOT NULL default '0',
  `rating_count` int(10) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_content_rating`
--

LOCK TABLES `jos_content_rating` WRITE;
/*!40000 ALTER TABLE `jos_content_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_content_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_core_log_searches`
--

DROP TABLE IF EXISTS `jos_core_log_searches`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_core_log_searches`
--

LOCK TABLES `jos_core_log_searches` WRITE;
/*!40000 ALTER TABLE `jos_core_log_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_core_log_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_extensions`
--

DROP TABLE IF EXISTS `jos_extensions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_extensions` (
  `extension_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `element` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL default '1',
  `access` tinyint(3) unsigned NOT NULL default '1',
  `protected` tinyint(3) NOT NULL default '0',
  `manifest_cache` text NOT NULL,
  `params` text NOT NULL,
  `custom_data` text NOT NULL,
  `system_data` text NOT NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) default '0',
  `state` int(11) default '0',
  PRIMARY KEY  (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_extensions`
--

LOCK TABLES `jos_extensions` WRITE;
/*!40000 ALTER TABLE `jos_extensions` DISABLE KEYS */;
INSERT INTO `jos_extensions` VALUES (1,'com_mailto','component','com_mailto','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(2,'com_wrapper','component','com_wrapper','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(3,'com_admin','component','com_admin','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(4,'com_banners','component','com_banners','',1,1,1,0,'','{\"purchase_type\":\"3\",\"track_impressions\":\"0\",\"track_clicks\":\"0\",\"metakey_prefix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(5,'com_cache','component','com_cache','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(6,'com_categories','component','com_categories','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(7,'com_checkin','component','com_checkin','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(8,'com_contact','component','com_contact','',1,1,1,0,'','{\"show_contact_category\":\"hide\",\"show_contact_list\":\"0\",\"presentation_style\":\"sliders\",\"show_name\":\"1\",\"show_position\":\"1\",\"show_email\":\"0\",\"show_street_address\":\"1\",\"show_suburb\":\"1\",\"show_state\":\"1\",\"show_postcode\":\"1\",\"show_country\":\"1\",\"show_telephone\":\"1\",\"show_mobile\":\"1\",\"show_fax\":\"1\",\"show_webpage\":\"1\",\"show_misc\":\"1\",\"show_image\":\"1\",\"image\":\"\",\"allow_vcard\":\"0\",\"show_articles\":\"0\",\"show_profile\":\"0\",\"show_links\":\"0\",\"linka_name\":\"\",\"linkb_name\":\"\",\"linkc_name\":\"\",\"linkd_name\":\"\",\"linke_name\":\"\",\"contact_icons\":\"0\",\"icon_address\":\"\",\"icon_email\":\"\",\"icon_telephone\":\"\",\"icon_mobile\":\"\",\"icon_fax\":\"\",\"icon_misc\":\"\",\"show_headings\":\"1\",\"show_position_headings\":\"1\",\"show_email_headings\":\"0\",\"show_telephone_headings\":\"1\",\"show_mobile_headings\":\"0\",\"show_fax_headings\":\"0\",\"allow_vcard_headings\":\"0\",\"show_suburb_headings\":\"1\",\"show_state_headings\":\"1\",\"show_country_headings\":\"1\",\"show_email_form\":\"1\",\"show_email_copy\":\"1\",\"banned_email\":\"\",\"banned_subject\":\"\",\"banned_text\":\"\",\"validate_session\":\"1\",\"custom_reply\":\"0\",\"redirect\":\"\",\"show_category_crumb\":\"0\",\"metakey\":\"\",\"metadesc\":\"\",\"robots\":\"\",\"author\":\"\",\"rights\":\"\",\"xreference\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(9,'com_cpanel','component','com_cpanel','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(10,'com_installer','component','com_installer','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(11,'com_languages','component','com_languages','',1,1,1,1,'','{\"administrator\":\"en-GB\",\"site\":\"en-GB\"}','','',0,'0000-00-00 00:00:00',0,0),(12,'com_login','component','com_login','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(13,'com_media','component','com_media','',1,1,0,1,'','{\"upload_extensions\":\"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\",\"upload_maxsize\":\"10485760\",\"file_path\":\"images\",\"image_path\":\"images\",\"restrict_uploads\":\"1\",\"allowed_media_usergroup\":\"3\",\"check_mime\":\"1\",\"image_extensions\":\"bmp,gif,jpg,png\",\"ignore_extensions\":\"\",\"upload_mime\":\"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/x-shockwave-flash,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip\",\"upload_mime_illegal\":\"text\\/html\",\"enable_flash\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(14,'com_menus','component','com_menus','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(15,'com_messages','component','com_messages','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(16,'com_modules','component','com_modules','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(17,'com_newsfeeds','component','com_newsfeeds','',1,1,1,0,'','{\"show_feed_image\":\"1\",\"show_feed_description\":\"1\",\"show_item_description\":\"1\",\"feed_word_count\":\"0\",\"show_headings\":\"1\",\"show_name\":\"1\",\"show_articles\":\"0\",\"show_link\":\"1\",\"show_description\":\"1\",\"show_description_image\":\"1\",\"display_num\":\"\",\"show_pagination_limit\":\"1\",\"show_pagination\":\"1\",\"show_pagination_results\":\"1\",\"show_cat_items\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(18,'com_plugins','component','com_plugins','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(19,'com_search','component','com_search','',1,1,1,1,'','{\"enabled\":\"0\",\"show_date\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(20,'com_templates','component','com_templates','',1,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(21,'com_weblinks','component','com_weblinks','',1,1,1,0,'','{\"show_comp_description\":\"1\",\"comp_description\":\"\",\"show_link_hits\":\"1\",\"show_link_description\":\"1\",\"show_other_cats\":\"0\",\"show_headings\":\"0\",\"show_numbers\":\"0\",\"show_report\":\"1\",\"count_clicks\":\"1\",\"target\":\"0\",\"link_icons\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(22,'com_content','component','com_content','',1,1,0,1,'','{\"show_title\":\"1\",\"link_titles\":\"1\",\"show_intro\":\"1\",\"show_category\":\"1\",\"link_category\":\"1\",\"show_parent_category\":\"0\",\"link_parent_category\":\"0\",\"show_author\":\"1\",\"link_author\":\"0\",\"show_create_date\":\"0\",\"show_modify_date\":\"0\",\"show_publish_date\":\"1\",\"show_item_navigation\":\"1\",\"show_readmore\":\"1\",\"show_icons\":\"1\",\"show_print_icon\":\"1\",\"show_email_icon\":\"1\",\"show_hits\":\"1\",\"num_leading_articles\":\"1\",\"num_intro_articles\":\"4\",\"num_columns\":\"2\",\"num_links\":\"4\",\"multi_column_order\":\"0\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"display_num\":\"10\",\"show_headings\":\"1\",\"list_show_title\":\"0\",\"show_date\":\"hide\",\"date_format\":\"\",\"list_hits\":\"1\",\"list_author\":\"1\",\"filter_field\":\"hide\",\"show_pagination_limit\":\"1\",\"maxLevel\":\"1\",\"show_category_title\":\"0\",\"show_empty_categories\":\"0\",\"show_description\":\"0\",\"show_description_image\":\"0\",\"show_cat_num_articles\":\"0\",\"drill_down_layout\":\"0\",\"orderby_pri\":\"order\",\"orderby_sec\":\"rdate\",\"show_noauth\":\"0\",\"show_feed_link\":\"1\",\"feed_summary\":\"0\",\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attritbutes\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(23,'com_config','component','com_config','',1,1,0,1,'','','','',0,'0000-00-00 00:00:00',0,0),(24,'com_redirect','component','com_redirect','',1,1,0,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(25,'com_users','component','com_users','',1,1,0,1,'','{\"allowUserRegistration\":\"1\",\"new_usertype\":\"2\",\"useractivation\":\"1\",\"frontend_userparams\":\"1\",\"mailSubjectPrefix\":\"\",\"mailBodySuffix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(100,'Joomla! Web Application Framework','library','joomla','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(101,'PHPMailer','library','phpmailer','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(102,'SimplePie','library','simplepie','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(103,'Bitfolge','library','simplepie','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(104,'phputf8','library','simplepie','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(200,'mod_articles_archive','module','mod_articles_archive','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(201,'mod_articles_latest','module','mod_articles_latest','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(202,'mod_articles_popular','module','mod_articles_popular','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(203,'mod_banners','module','mod_banners','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(204,'mod_breadcrumbs','module','mod_breadcrumbs','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(205,'mod_custom','module','mod_custom','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(206,'mod_feed','module','mod_feed','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(207,'mod_footer','module','mod_footer','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(208,'mod_login','module','mod_login','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(209,'mod_menu','module','mod_menu','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(210,'mod_articles_news','module','mod_articles_news','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(211,'mod_random_image','module','mod_random_image','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(212,'mod_related_items','module','mod_related_items','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(213,'mod_search','module','mod_search','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(214,'mod_stats','module','mod_stats','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(215,'mod_syndicate','module','mod_syndicate','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(216,'mod_users_latest','module','mod_users_latest','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(217,'mod_weblinks','module','mod_weblinks','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(218,'mod_whosonline','module','mod_whosonline','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(219,'mod_wrapper','module','mod_wrapper','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(220,'mod_articles_category','module','mod_articles_category','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(221,'mod_articles_categories','module','mod_articles_categories','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(222,'mod_languages','module','mod_languages','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(300,'mod_custom','module','mod_custom','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(301,'mod_feed','module','mod_feed','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(302,'mod_latest','module','mod_latest','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(303,'mod_logged','module','mod_logged','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(304,'mod_login','module','mod_login','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(305,'mod_menu','module','mod_menu','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(306,'mod_online','module','mod_online','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(307,'mod_popular','module','mod_popular','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(308,'mod_quickicon','module','mod_quickicon','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(309,'mod_status','module','mod_status','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(310,'mod_submenu','module','mod_submenu','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(311,'mod_title','module','mod_title','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(312,'mod_toolbar','module','mod_toolbar','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(313,'mod_unread','module','mod_unread','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(400,'plg_authentication_gmail','plugin','gmail','authentication',0,0,1,0,'','{\"applysuffix\":\"0\",\"suffix\":\"\",\"verifypeer\":\"1\",\"user_blacklist\":\"\"}','','',0,'0000-00-00 00:00:00',1,0),(401,'plg_authentication_joomla','plugin','joomla','authentication',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(402,'plg_authentication_ldap','plugin','ldap','authentication',0,0,1,0,'','{\"host\":\"\",\"port\":\"389\",\"use_ldapV3\":\"0\",\"negotiate_tls\":\"0\",\"no_referrals\":\"0\",\"auth_method\":\"bind\",\"base_dn\":\"\",\"search_string\":\"\",\"users_dn\":\"\",\"username\":\"admin\",\"password\":\"bobby7\",\"ldap_fullname\":\"fullName\",\"ldap_email\":\"mail\",\"ldap_uid\":\"uid\"}','','',0,'0000-00-00 00:00:00',3,0),(403,'plg_authentication_openid','plugin','openid','authentication',0,0,1,0,'','{\"usermode\":\"2\",\"phishing-resistant\":\"0\",\"multi-factor\":\"0\",\"multi-factor-physical\":\"0\"}','','',0,'0000-00-00 00:00:00',4,0),(404,'plg_content_emailcloak','plugin','emailcloak','content',0,1,1,0,'','{\"mode\":\"1\"}','','',0,'0000-00-00 00:00:00',1,0),(405,'plg_content_geshi','plugin','geshi','content',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',2,0),(406,'plg_content_loadmodule','plugin','loadmodule','content',0,1,1,0,'','{\"style\":\"table\"}','','',0,'0000-00-00 00:00:00',3,0),(407,'plg_content_pagebreak','plugin','pagebreak','content',0,1,1,1,'','{\"title\":\"1\",\"multipage_toc\":\"1\",\"showall\":\"1\"}','','',0,'0000-00-00 00:00:00',4,0),(408,'plg_content_pagenavigation','plugin','pagenavigation','content',0,1,1,1,'','{\"position\":\"1\"}','','',0,'0000-00-00 00:00:00',5,0),(409,'plg_content_vote','plugin','vote','content',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',6,0),(410,'plg_editors_codemirror','plugin','codemirror','editors',0,1,1,1,'','{\"linenumbers\":\"0\",\"tabmode\":\"indent\"}','','',0,'0000-00-00 00:00:00',1,0),(411,'plg_editors_none','plugin','none','editors',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',2,0),(412,'plg_editors_tinymce','plugin','tinymce','editors',0,1,1,1,'','{\"mode\":\"1\",\"skin\":\"0\",\"compressed\":\"0\",\"cleanup_startup\":\"0\",\"cleanup_save\":\"2\",\"entity_encoding\":\"raw\",\"lang_mode\":\"0\",\"lang_code\":\"en\",\"text_direction\":\"ltr\",\"content_css\":\"1\",\"content_css_custom\":\"\",\"relative_urls\":\"1\",\"newlines\":\"0\",\"invalid_elements\":\"script,applet,iframe\",\"extended_elements\":\"\",\"toolbar\":\"top\",\"toolbar_align\":\"left\",\"html_height\":\"550\",\"html_width\":\"750\",\"element_path\":\"1\",\"fonts\":\"1\",\"paste\":\"1\",\"searchreplace\":\"1\",\"insertdate\":\"1\",\"format_date\":\"%Y-%m-%d\",\"inserttime\":\"1\",\"format_time\":\"%H:%M:%S\",\"colors\":\"1\",\"table\":\"1\",\"smilies\":\"1\",\"media\":\"1\",\"hr\":\"1\",\"directionality\":\"1\",\"fullscreen\":\"1\",\"style\":\"1\",\"layer\":\"1\",\"xhtmlxtras\":\"1\",\"visualchars\":\"1\",\"nonbreaking\":\"1\",\"template\":\"1\",\"blockquote\":\"1\",\"wordcount\":\"1\",\"advimage\":\"1\",\"advlink\":\"1\",\"autosave\":\"1\",\"contextmenu\":\"1\",\"inlinepopups\":\"1\",\"safari\":\"0\",\"custom_plugin\":\"\",\"custom_button\":\"\"}','','',0,'0000-00-00 00:00:00',3,0),(413,'plg_editors-xtd_article','plugin','article','editors-xtd',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',1,0),(414,'plg_editors-xtd_image','plugin','image','editors-xtd',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',2,0),(415,'plg_editors-xtd_pagebreak','plugin','pagebreak','editors-xtd',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',3,0),(416,'plg_editors-xtd_readmore','plugin','readmore','editors-xtd',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',4,0),(417,'plg_search_categories','plugin','categories','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(418,'plg_search_contacts','plugin','contacts','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(419,'plg_search_content','plugin','content','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(420,'plg_search_newsfeeds','plugin','newsfeeds','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(421,'plg_search_weblinks','plugin','weblinks','search',0,1,1,0,'','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(422,'plg_system_cache','plugin','cache','system',0,0,1,1,'','{\"browsercache\":\"0\",\"cachetime\":\"15\"}','','',0,'0000-00-00 00:00:00',1,0),(423,'plg_system_debug','plugin','debug','system',0,1,1,0,'','{\"profile\":\"1\",\"queries\":\"1\",\"memory\":\"1\",\"language_files\":\"1\",\"language_strings\":\"1\",\"strip-first\":\"1\",\"strip-prefix\":\"\",\"strip-suffix\":\"\"}','','',0,'0000-00-00 00:00:00',2,0),(424,'plg_system_log','plugin','log','system',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',3,0),(425,'plg_system_redirect','plugin','redirect','system',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',4,0),(426,'plg_system_remember','plugin','remember','system',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',5,0),(427,'plg_system_sef','plugin','sef','system',0,1,1,0,'','{}','','',0,'0000-00-00 00:00:00',6,0),(428,'plg_user_contactcreator','plugin','contactcreator','user',0,0,1,1,'','{\"autowebpage\":\"\",\"category\":\"26\",\"autopublish\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(429,'plg_user_joomla','plugin','joomla','user',0,1,1,0,'','{\"autoregister\":\"1\"}','','',0,'0000-00-00 00:00:00',2,0),(430,'plg_user_profile','plugin','profile','user',0,0,1,1,'','{\"register-require_address1\":\"0\",\"register-require_address2\":\"0\",\"register-require_city\":\"0\",\"register-require_region\":\"0\",\"register-require_country\":\"0\",\"register-require_postal_code\":\"0\",\"register-require_phone\":\"0\",\"register-require_website\":\"0\",\"profile-require_address1\":\"1\",\"profile-require_address2\":\"1\",\"profile-require_city\":\"1\",\"profile-require_region\":\"1\",\"profile-require_country\":\"1\",\"profile-require_postal_code\":\"1\",\"profile-require_phone\":\"1\",\"profile-require_website\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(431,'plg_extension_joomla','plugin','joomla','extension',0,1,1,1,'','{}','','',0,'0000-00-00 00:00:00',1,0),(432,'plg_system_languagefilter','plugin','languagefilter','system',0,0,1,1,'','{}','','',0,'0000-00-00 00:00:00',0,0),(500,'atomic','template','atomic','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(501,'rhuk_milkyway','template','rhuk_milkyway','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(502,'bluestork','template','bluestork','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(503,'beez_20','template','beez_20','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(504,'hathor','template','hathor','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(505,'Beez5','template','beez5','',0,1,1,0,'a:11:{s:6:\"legacy\";b:1;s:4:\"name\";s:5:\"Beez5\";s:4:\"type\";s:8:\"template\";s:12:\"creationDate\";s:11:\"21 May 2010\";s:6:\"author\";s:12:\"Angie Radtke\";s:9:\"copyright\";s:72:\"Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.\";s:11:\"authorEmail\";s:23:\"a.radtke@derauftritt.de\";s:9:\"authorUrl\";s:26:\"http://www.der-auftritt.de\";s:7:\"version\";s:5:\"1.6.0\";s:11:\"description\";s:22:\"A Easy Version of Beez\";s:5:\"group\";s:0:\"\";}','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"sitetitle\":\"BEEZ 2.0\",\"sitedescription\":\"Your site name\",\"navposition\":\"center\",\"html5\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(600,'English (United Kingdom)','language','en-GB','',0,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(601,'English (United Kingdom)','language','en-GB','',1,1,1,1,'','','','',0,'0000-00-00 00:00:00',0,0),(604,'XXTestLang','language','xx-XX','',1,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(605,'XXTestLang','language','xx-XX','',0,1,1,0,'','','','',0,'0000-00-00 00:00:00',0,0),(10000,'Editor - JoomlaCK','plugin','jckeditor','editors',0,1,1,0,'a:11:{s:6:\"legacy\";b:1;s:4:\"name\";s:17:\"Editor - JoomlaCK\";s:4:\"type\";s:6:\"plugin\";s:12:\"creationDate\";s:10:\"July 2010 \";s:6:\"author\";s:16:\"WebxSolution Ltd\";s:9:\"copyright\";s:0:\"\";s:11:\"authorEmail\";s:0:\"\";s:9:\"authorUrl\";s:0:\"\";s:7:\"version\";s:5:\"3.3.1\";s:11:\"description\";s:91:\"JoomlaCK  3.3.1 is a platform independent web based JavaScript HTML WYSIWYG Editor control.\";s:5:\"group\";s:0:\"\";}','{}','','',0,'0000-00-00 00:00:00',0,0),(10001,'extplorer','component','com_extplorer','',0,1,0,0,'a:11:{s:6:\"legacy\";b:1;s:4:\"name\";s:9:\"eXtplorer\";s:4:\"type\";s:9:\"component\";s:12:\"creationDate\";s:10:\"15.01.2008\";s:6:\"author\";s:20:\"soeren, QuiX Project\";s:9:\"copyright\";s:39:\"Soeren Eberhardt-Biermann, QuiX Project\";s:11:\"authorEmail\";s:24:\"soeren|at|virtuemart.net\";s:9:\"authorUrl\";s:47:\"http://joomlacode.org/gf/project/joomlaxplorer/\";s:7:\"version\";s:5:\"2.0.1\";s:11:\"description\";s:663:\"\n	<div align=\"left\"><img src=\"components/com_extplorer/images/eXtplorer.gif\" alt=\"eXtplorer Logo\" /></div>\n	<h2>Successfully installed eXtplorer&nbsp;</h2>\n	eXtplorer is a powerful File- and FTP/WebDAV Manager script. \n	<br/>It allows \n	  <ul><li>Browsing Directories & Files,</li>\n	  <li>Editing, Copying, Moving and Deleting files,</li>\n	  <li>Searching, Uploading and Downloading files,</li>\n	  <li>Creating new Files and Directories,</li>\n	  <li>Creating and Extracting Archives with Files and Directories,</li>\n	  <li>Changing file permissions (chmod)</li></ul><br/>and much more.<br/><br/>\n	  <strong>By default restricted to Superadministrators!</strong>\n	\";s:5:\"group\";s:0:\"\";}','{}','','',0,'0000-00-00 00:00:00',0,0);
/*!40000 ALTER TABLE `jos_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_languages`
--

DROP TABLE IF EXISTS `jos_languages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_languages` (
  `lang_id` int(11) unsigned NOT NULL auto_increment,
  `lang_code` char(7) NOT NULL,
  `title` varchar(50) NOT NULL,
  `title_native` varchar(50) NOT NULL,
  `sef` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(512) NOT NULL,
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `published` int(11) NOT NULL default '0',
  PRIMARY KEY  (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_languages`
--

LOCK TABLES `jos_languages` WRITE;
/*!40000 ALTER TABLE `jos_languages` DISABLE KEYS */;
INSERT INTO `jos_languages` VALUES (1,'en-GB','English (UK)','English (UK)','en','en','','','',1),(3,'xx-XX','xx (Test)','xx (Test)','xx','br','','','',1);
/*!40000 ALTER TABLE `jos_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_menu`
--

DROP TABLE IF EXISTS `jos_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(24) NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(255) NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) NOT NULL default '',
  `path` varchar(1024) NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL default '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL default '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL default '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL default '0' COMMENT 'FK to #__extensions.id',
  `ordering` int(11) NOT NULL default '0' COMMENT 'The relative ordering of the menu item in the tree.',
  `checked_out` int(10) unsigned NOT NULL default '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL default '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL default '0' COMMENT 'The click behaviour of the link.',
  `access` tinyint(3) unsigned NOT NULL default '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL default '0',
  `params` varchar(10240) NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_alias_parent_id` (`alias`,`parent_id`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`),
  KEY `idx_path` (`path`(333)),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_menu`
--

LOCK TABLES `jos_menu` WRITE;
/*!40000 ALTER TABLE `jos_menu` DISABLE KEYS */;
INSERT INTO `jos_menu` VALUES (1,'','Menu_Item_Root','root','','','','',1,0,0,0,0,0,'0000-00-00 00:00:00',0,0,'',0,'',0,219,0,'*'),(2,'_adminmenu','com_banners','Banners','','Banners','index.php?option=com_banners','component',0,1,1,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',1,10,0,'*'),(3,'_adminmenu','com_banners','Banners','','Banners/Banners','index.php?option=com_banners','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',2,3,0,'*'),(4,'_adminmenu','com_banners_clients','Clients','','Banners/Clients','index.php?option=com_banners&view=clients','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners-clients',0,'',4,5,0,'*'),(5,'_adminmenu','com_banners_tracks','Tracks','','Banners/Tracks','index.php?option=com_banners&view=tracks','component',0,2,2,4,0,0,'0000-00-00 00:00:00',0,0,'class:banners-tracks',0,'',6,7,0,'*'),(6,'_adminmenu','com_banners_categories','Categories','','Banners/Categories','index.php?option=com_categories&extension=com_banners','component',0,2,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:banners-cat',0,'',8,9,0,'*'),(7,'_adminmenu','com_contact','Contacts','','Contacts','index.php?option=com_contact','component',0,1,1,8,0,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',11,16,0,'*'),(8,'_adminmenu','com_contact','Contacts','','Contacts/Contacts','index.php?option=com_contact','component',0,7,2,8,0,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',12,13,0,'*'),(9,'_adminmenu','com_contact_categories','Categories','','Contacts/Categories','index.php?option=com_categories&extension=com_contact','component',0,7,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:contact-cat',0,'',14,15,0,'*'),(10,'_adminmenu','com_messages','Messaging','','Messaging','index.php?option=com_messages','component',0,1,1,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages',0,'',17,22,0,'*'),(11,'_adminmenu','com_messages_add','New Private Message','','Messaging/New Private Message','index.php?option=com_messages&task=message.add','component',0,10,2,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages-add',0,'',18,19,0,'*'),(12,'_adminmenu','com_messages_read','Read Private Message','','Messaging/Read Private Message','index.php?option=com_messages','component',0,10,2,15,0,0,'0000-00-00 00:00:00',0,0,'class:messages-read',0,'',20,21,0,'*'),(13,'_adminmenu','com_newsfeeds','News Feeds','','News Feeds','index.php?option=com_newsfeeds','component',0,1,1,17,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',23,28,0,'*'),(14,'_adminmenu','com_newsfeeds_feeds','Feeds','','News Feeds/Feeds','index.php?option=com_newsfeeds','component',0,13,2,17,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',24,25,0,'*'),(15,'_adminmenu','com_newsfeeds_categories','Categories','','News Feeds/Categories','index.php?option=com_categories&extension=com_newsfeeds','component',0,13,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds-cat',0,'',26,27,0,'*'),(16,'_adminmenu','com_redirect','Redirect','','Redirect','index.php?option=com_redirect','component',0,1,1,24,0,0,'0000-00-00 00:00:00',0,0,'class:redirect',0,'',37,38,0,'*'),(17,'_adminmenu','com_search','Search','','Search','index.php?option=com_search','component',0,1,1,19,0,0,'0000-00-00 00:00:00',0,0,'class:search',0,'',29,30,0,'*'),(18,'_adminmenu','com_weblinks','Weblinks','','Weblinks','index.php?option=com_weblinks','component',0,1,1,21,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',31,36,0,'*'),(19,'_adminmenu','com_weblinks_links','Links','','Weblinks/Links','index.php?option=com_weblinks','component',0,18,2,21,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks',0,'',32,33,0,'*'),(20,'_adminmenu','com_weblinks_categories','Categories','','Weblinks/Categories','index.php?option=com_categories&extension=com_weblinks','component',0,18,2,6,0,0,'0000-00-00 00:00:00',0,0,'class:weblinks-cat',0,'',34,35,0,'*'),(101,'mainmenu','Home','home','','home','index.php?option=com_content&view=featured','component',1,1,1,22,0,0,'0000-00-00 00:00:00',0,1,'',0,'{\"num_leading_articles\":\"1\",\"num_intro_articles\":\"3\",\"num_columns\":\"3\",\"num_links\":\"0\",\"orderby_pri\":\"\",\"orderby_sec\":\"front\",\"order_date\":\"\",\"multi_column_order\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_noauth\":\"\",\"article-allow_ratings\":\"\",\"article-allow_comments\":\"\",\"show_feed_link\":\"1\",\"feed_summary\":\"\",\"show_title\":\"\",\"link_titles\":\"\",\"show_intro\":\"\",\"show_category\":\"\",\"link_category\":\"\",\"show_parent_category\":\"\",\"link_parent_category\":\"\",\"show_author\":\"\",\"show_create_date\":\"\",\"show_modify_date\":\"\",\"show_publish_date\":\"\",\"show_item_navigation\":\"\",\"show_readmore\":\"\",\"show_icons\":\"\",\"show_print_icon\":\"\",\"show_email_icon\":\"\",\"show_hits\":\"\",\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"show_page_heading\":1,\"page_title\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',233,234,1,'*'),(102,'_adminmenu','com_extplorer','extplorer','','','index.php?option=com_extplorer','component',0,1,1,10001,0,0,'0000-00-00 00:00:00',0,1,'class:component',0,'',217,218,0,'');
/*!40000 ALTER TABLE `jos_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_menu_types`
--

DROP TABLE IF EXISTS `jos_menu_types`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(24) NOT NULL,
  `title` varchar(48) NOT NULL,
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_menu_types`
--

LOCK TABLES `jos_menu_types` WRITE;
/*!40000 ALTER TABLE `jos_menu_types` DISABLE KEYS */;
INSERT INTO `jos_menu_types` VALUES (1,'mainmenu','Main Menu','The main menu for the site');
/*!40000 ALTER TABLE `jos_menu_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_messages`
--

DROP TABLE IF EXISTS `jos_messages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` tinyint(3) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL default '0',
  `priority` tinyint(1) unsigned NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_messages`
--

LOCK TABLES `jos_messages` WRITE;
/*!40000 ALTER TABLE `jos_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_messages_cfg`
--

DROP TABLE IF EXISTS `jos_messages_cfg`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_messages_cfg`
--

LOCK TABLES `jos_messages_cfg` WRITE;
/*!40000 ALTER TABLE `jos_messages_cfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_messages_cfg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_modules`
--

DROP TABLE IF EXISTS `jos_modules`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `note` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(50) default NULL,
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` varchar(5120) NOT NULL default '',
  `client_id` tinyint(4) NOT NULL default '0',
  `language` char(7) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_modules`
--

LOCK TABLES `jos_modules` WRITE;
/*!40000 ALTER TABLE `jos_modules` DISABLE KEYS */;
INSERT INTO `jos_modules` VALUES (1,'Main Menu','','',1,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',1,1,'{\"menutype\":\"mainmenu\",\"startLevel\":\"0\",\"endLevel\":\"0\",\"showAllChildren\":\"0\",\"tag_id\":\"\",\"class_sfx\":\"\",\"window_open\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"_menu\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(2,'Login','','',1,'login',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'',1,'*'),(3,'Popular Articles','','',3,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_popular',3,1,'{\"count\":\"5\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(4,'Recently Added Articles','','',4,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_latest',3,1,'{\"count\":\"5\",\"ordering\":\"c_dsc\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(6,'Unread Messages','','',1,'header',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_unread',3,1,'',1,'*'),(7,'Online Users','','',2,'header',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_online',3,1,'',1,'*'),(8,'Toolbar','','',1,'toolbar',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_toolbar',3,1,'',1,'*'),(9,'Quick Icons','','',1,'icon',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_quickicon',3,1,'',1,'*'),(10,'Logged-in Users','','',2,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_logged',3,1,'',1,'*'),(12,'Admin Menu','','',1,'menu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',3,1,'',1,'*'),(13,'Admin Submenu','','',1,'submenu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_submenu',3,1,'',1,'*'),(14,'User Status','','',1,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_status',3,1,'',1,'*'),(15,'Title','','',1,'title',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_title',3,1,'',1,'*'),(16,'User Menu','','',2,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',2,1,'{\"menutype\":\"usermenu\",\"startLevel\":\"0\",\"endLevel\":\"0\",\"showAllChildren\":\"0\",\"tag_id\":\"\",\"class_sfx\":\"\",\"window_open\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"_menu\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(17,'Login Form','','',8,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'{\"greeting\":\"1\",\"name\":\"0\"}',0,'*'),(18,'Breadcrumbs','','',1,'position-2',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_breadcrumbs',1,1,'{\"moduleclass_sfx\":\"\",\"showHome\":\"1\",\"homeText\":\"Home\",\"showComponent\":\"1\",\"separator\":\"\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(19,'Banners','','',1,'position-5',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_banners',1,1,'{\"target\":\"1\",\"count\":\"1\",\"cid\":\"1\",\"catid\":[\"27\"],\"tag_search\":\"0\",\"ordering\":\"0\",\"header_text\":\"\",\"footer_text\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\"}',0,'*');
/*!40000 ALTER TABLE `jos_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_modules_menu`
--

DROP TABLE IF EXISTS `jos_modules_menu`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_modules_menu`
--

LOCK TABLES `jos_modules_menu` WRITE;
/*!40000 ALTER TABLE `jos_modules_menu` DISABLE KEYS */;
INSERT INTO `jos_modules_menu` VALUES (1,0),(2,0),(3,0),(4,0),(5,0),(6,0),(7,0),(8,0),(9,0),(10,0),(11,0),(12,0),(13,0),(14,0),(15,0),(16,0),(17,0),(18,0),(19,0);
/*!40000 ALTER TABLE `jos_modules_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_newsfeeds`
--

DROP TABLE IF EXISTS `jos_newsfeeds`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `alias` varchar(100) NOT NULL default '',
  `link` varchar(200) NOT NULL default '',
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(10) unsigned NOT NULL default '1',
  `cache_time` int(10) unsigned NOT NULL default '3600',
  `checked_out` int(10) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `language` char(7) NOT NULL default '',
  `params` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_newsfeeds`
--

LOCK TABLES `jos_newsfeeds` WRITE;
/*!40000 ALTER TABLE `jos_newsfeeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_newsfeeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_redirect_links`
--

DROP TABLE IF EXISTS `jos_redirect_links`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_redirect_links` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `old_url` varchar(150) NOT NULL,
  `new_url` varchar(150) NOT NULL,
  `referer` varchar(150) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_link_old` (`old_url`),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_redirect_links`
--

LOCK TABLES `jos_redirect_links` WRITE;
/*!40000 ALTER TABLE `jos_redirect_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_redirect_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_schemas`
--

DROP TABLE IF EXISTS `jos_schemas`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`extension_id`,`version_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_schemas`
--

LOCK TABLES `jos_schemas` WRITE;
/*!40000 ALTER TABLE `jos_schemas` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_schemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_session`
--

DROP TABLE IF EXISTS `jos_session`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_session` (
  `session_id` varchar(32) NOT NULL default '',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `guest` tinyint(4) unsigned default '1',
  `time` varchar(14) default '',
  `data` varchar(20480) default NULL,
  `userid` int(11) default '0',
  `username` varchar(150) default '',
  `usertype` varchar(50) default '',
  PRIMARY KEY  (`session_id`),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_session`
--

LOCK TABLES `jos_session` WRITE;
/*!40000 ALTER TABLE `jos_session` DISABLE KEYS */;
INSERT INTO `jos_session` VALUES ('su5e67ppb8qjrclgd320i30bq0',1,0,'1282013121','__default|a:8:{s:15:\"session.counter\";i:4;s:19:\"session.timer.start\";i:1282013113;s:18:\"session.timer.last\";i:1282013120;s:17:\"session.timer.now\";i:1282013120;s:22:\"session.client.browser\";s:126:\"Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.126 Safari/533.4\";s:8:\"registry\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":1:{s:11:\"application\";O:8:\"stdClass\":1:{s:4:\"lang\";s:0:\"\";}}}s:4:\"user\";O:5:\"JUser\":21:{s:2:\"id\";s:2:\"43\";s:4:\"name\";s:11:\"Justin Lyon\";s:8:\"username\";s:5:\"jlyon\";s:5:\"email\";s:21:\"justin.lyon@gmail.com\";s:8:\"password\";s:65:\"6fc1405cb5fd9142f0eea727910b3791:zAJp2CI79uhdsDJ6MVi4q72RzCevlgnC\";s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";s:0:\"\";s:5:\"block\";s:1:\"0\";s:9:\"sendEmail\";s:1:\"0\";s:12:\"registerDate\";s:19:\"2010-07-31 18:58:42\";s:13:\"lastvisitDate\";s:19:\"2010-08-16 13:52:55\";s:10:\"activation\";s:0:\"\";s:6:\"params\";s:95:\"{\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"America\\/Los_Angeles\"}\";s:6:\"groups\";a:1:{i:8;s:11:\"Super Users\";}s:5:\"guest\";i:0;s:10:\"\0*\0_params\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":5:{s:14:\"admin_language\";s:0:\"\";s:8:\"language\";s:0:\"\";s:6:\"editor\";s:0:\"\";s:8:\"helpsite\";s:0:\"\";s:8:\"timezone\";s:19:\"America/Los_Angeles\";}}s:14:\"\0*\0_authLevels\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}s:15:\"\0*\0_authActions\";N;s:12:\"\0*\0_errorMsg\";N;s:10:\"\0*\0_errors\";a:0:{}s:3:\"aid\";i:0;}s:13:\"session.token\";s:32:\"e3ab6e2c26fb2cb0231dc22bceb0ba0f\";}',43,'jlyon',''),('g6tap256n29h3h4sm4gh09g546',0,1,'1282012940','__default|a:8:{s:15:\"session.counter\";i:14;s:19:\"session.timer.start\";i:1281966914;s:18:\"session.timer.last\";i:1282009400;s:17:\"session.timer.now\";i:1282012940;s:22:\"session.client.browser\";s:126:\"Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.126 Safari/533.4\";s:8:\"registry\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":0:{}}s:4:\"user\";O:5:\"JUser\":21:{s:2:\"id\";i:0;s:4:\"name\";N;s:8:\"username\";N;s:5:\"email\";N;s:8:\"password\";N;s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";N;s:5:\"block\";N;s:9:\"sendEmail\";i:0;s:12:\"registerDate\";N;s:13:\"lastvisitDate\";N;s:10:\"activation\";N;s:6:\"params\";N;s:6:\"groups\";a:0:{}s:5:\"guest\";i:1;s:10:\"\0*\0_params\";O:9:\"JRegistry\":1:{s:7:\"\0*\0data\";O:8:\"stdClass\":0:{}}s:14:\"\0*\0_authLevels\";a:1:{i:0;i:1;}s:15:\"\0*\0_authActions\";N;s:12:\"\0*\0_errorMsg\";N;s:10:\"\0*\0_errors\";a:0:{}s:3:\"aid\";i:0;}s:13:\"session.token\";s:32:\"9ef96f8603324883d062f15caf2dead0\";}',0,'','');
/*!40000 ALTER TABLE `jos_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_template_styles`
--

DROP TABLE IF EXISTS `jos_template_styles`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_template_styles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `template` varchar(50) NOT NULL default '',
  `client_id` tinyint(1) unsigned NOT NULL default '0',
  `home` tinyint(1) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `params` varchar(2048) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_template_styles`
--

LOCK TABLES `jos_template_styles` WRITE;
/*!40000 ALTER TABLE `jos_template_styles` DISABLE KEYS */;
INSERT INTO `jos_template_styles` VALUES (1,'rhuk_milkyway',0,0,'Milkyway - Default','{\"colorVariation\":\"blue\",\"backgroundVariation\":\"blue\",\"widthStyle\":\"fmax\"}'),(2,'bluestork',1,1,'Bluestork - Default','{\"useRoundedCorners\":\"1\",\"showSiteName\":\"0\"}'),(3,'atomic',0,0,'Atomic - Default','{}'),(4,'beez_20',0,1,'Beez2 - Default','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/joomla_black.gif\",\"sitetitle\":\"Joomla!\",\"sitedescription\":\"Open Source Content Management Beta\",\"navposition\":\"left\",\"templatecolor\":\"personal\",\"html5\":\"0\"}'),(5,'hathor',1,0,'Hathor - Default','{\"showSiteName\":\"0\",\"highContrast\":\"0\",\"boldText\":\"0\",\"altMenu\":\"0\"}'),(6,'beez5',0,0,'Beez5 - Default-Fruit Shop','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/sampledata\\/fruitshop\\/fruits.gif\",\"sitetitle\":\"Matuna Market \",\"sitedescription\":\"Fruit Shop Sample Site\",\"navposition\":\"left\",\"html5\":\"0\"}');
/*!40000 ALTER TABLE `jos_template_styles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_update_categories`
--

DROP TABLE IF EXISTS `jos_update_categories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_update_categories` (
  `categoryid` int(11) NOT NULL auto_increment,
  `name` varchar(20) default '',
  `description` text NOT NULL,
  `parent` int(11) default '0',
  `updatesite` int(11) default '0',
  PRIMARY KEY  (`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Update Categories';
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_update_categories`
--

LOCK TABLES `jos_update_categories` WRITE;
/*!40000 ALTER TABLE `jos_update_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_update_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_update_sites`
--

DROP TABLE IF EXISTS `jos_update_sites`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_update_sites` (
  `update_site_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default '',
  `type` varchar(20) default '',
  `location` text NOT NULL,
  `enabled` int(11) default '0',
  PRIMARY KEY  (`update_site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Update Sites';
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_update_sites`
--

LOCK TABLES `jos_update_sites` WRITE;
/*!40000 ALTER TABLE `jos_update_sites` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_update_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_update_sites_extensions`
--

DROP TABLE IF EXISTS `jos_update_sites_extensions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_update_sites_extensions` (
  `update_site_id` int(11) default '0',
  `extension_id` int(11) default '0',
  KEY `newindex` (`update_site_id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Links extensions to update sites';
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_update_sites_extensions`
--

LOCK TABLES `jos_update_sites_extensions` WRITE;
/*!40000 ALTER TABLE `jos_update_sites_extensions` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_update_sites_extensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_updates`
--

DROP TABLE IF EXISTS `jos_updates`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_updates` (
  `update_id` int(11) NOT NULL auto_increment,
  `update_site_id` int(11) default '0',
  `extension_id` int(11) default '0',
  `categoryid` int(11) default '0',
  `name` varchar(100) default '',
  `description` text NOT NULL,
  `element` varchar(100) default '',
  `type` varchar(20) default '',
  `folder` varchar(20) default '',
  `client_id` tinyint(3) default '0',
  `version` varchar(10) default '',
  `data` text NOT NULL,
  `detailsurl` text NOT NULL,
  PRIMARY KEY  (`update_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Available Updates';
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_updates`
--

LOCK TABLES `jos_updates` WRITE;
/*!40000 ALTER TABLE `jos_updates` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_user_profiles`
--

DROP TABLE IF EXISTS `jos_user_profiles`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) NOT NULL,
  `profile_value` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Simple user profile storage table';
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_user_profiles`
--

LOCK TABLES `jos_user_profiles` WRITE;
/*!40000 ALTER TABLE `jos_user_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_user_usergroup_map`
--

DROP TABLE IF EXISTS `jos_user_usergroup_map`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL default '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL default '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY  (`user_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_user_usergroup_map`
--

LOCK TABLES `jos_user_usergroup_map` WRITE;
/*!40000 ALTER TABLE `jos_user_usergroup_map` DISABLE KEYS */;
INSERT INTO `jos_user_usergroup_map` VALUES (42,8),(43,8);
/*!40000 ALTER TABLE `jos_user_usergroup_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_usergroups`
--

DROP TABLE IF EXISTS `jos_usergroups`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_usergroups` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL default '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL default '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL default '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` USING BTREE (`lft`,`rgt`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_usergroups`
--

LOCK TABLES `jos_usergroups` WRITE;
/*!40000 ALTER TABLE `jos_usergroups` DISABLE KEYS */;
INSERT INTO `jos_usergroups` VALUES (1,0,1,20,'Public'),(2,1,8,19,'Registered'),(3,2,9,16,'Author'),(4,3,10,13,'Editor'),(5,4,11,12,'Publisher'),(6,1,2,7,'Manager'),(7,6,3,6,'Administrator'),(8,7,4,5,'Super Users');
/*!40000 ALTER TABLE `jos_usergroups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_users`
--

DROP TABLE IF EXISTS `jos_users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_users`
--

LOCK TABLES `jos_users` WRITE;
/*!40000 ALTER TABLE `jos_users` DISABLE KEYS */;
INSERT INTO `jos_users` VALUES (42,'Super User','admin','support@tachometry.com','86fc5f9b13e44b0b1f44a8aa1b588845:umWTFizORlx2d2GBFMrBBwVUuyEizwVT','deprecated',0,1,'2010-07-31 18:53:22','2010-08-11 22:38:32','','{\"admin_language\":\"\",\"language\":\"\",\"editor\":\"none\",\"helpsite\":\"\",\"timezone\":\"\"}'),(43,'Justin Lyon','jlyon','justin.lyon@gmail.com','6fc1405cb5fd9142f0eea727910b3791:zAJp2CI79uhdsDJ6MVi4q72RzCevlgnC','',0,0,'2010-07-31 18:58:42','2010-08-17 02:45:20','','{\"admin_language\":\"\",\"language\":\"\",\"editor\":\"\",\"helpsite\":\"\",\"timezone\":\"America\\/Los_Angeles\"}');
/*!40000 ALTER TABLE `jos_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_viewlevels`
--

DROP TABLE IF EXISTS `jos_viewlevels`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_viewlevels` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'Primary Key',
  `title` varchar(100) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_viewlevels`
--

LOCK TABLES `jos_viewlevels` WRITE;
/*!40000 ALTER TABLE `jos_viewlevels` DISABLE KEYS */;
INSERT INTO `jos_viewlevels` VALUES (1,'Public',0,'[]'),(2,'Registered',1,'[6,2]'),(3,'Special',2,'[6,7,8]');
/*!40000 ALTER TABLE `jos_viewlevels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_weblinks`
--

DROP TABLE IF EXISTS `jos_weblinks`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_weblinks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `state` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `access` int(11) NOT NULL default '1',
  `params` text NOT NULL,
  `language` char(7) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL default '0' COMMENT 'Set if link is featured.',
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_weblinks`
--

LOCK TABLES `jos_weblinks` WRITE;
/*!40000 ALTER TABLE `jos_weblinks` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_weblinks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-08-17  4:15:02
