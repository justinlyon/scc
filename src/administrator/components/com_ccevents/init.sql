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
-- Table structure for table `jos_cce_activity`
--

DROP TABLE IF EXISTS `jos_cce_activity`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_activity` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `ticketCode` varchar(255) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `activity_index` (`eoid`),
  KEY `ActivityIndex` (`eoid`,`scope`)
) ENGINE=MyISAM AUTO_INCREMENT=1082 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_activity`
--

LOCK TABLES `jos_cce_activity` WRITE;
/*!40000 ALTER TABLE `jos_cce_activity` DISABLE KEYS */;
INSERT INTO `jos_cce_activity` VALUES (1,'Performance','/test');
/*!40000 ALTER TABLE `jos_cce_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_address`
--

DROP TABLE IF EXISTS `jos_cce_address`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_address` (
  `eoid` int(12) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` text,
  `target` varchar(255) default NULL,
  `street` varchar(255) default NULL,
  `unit` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` char(2) default NULL,
  `postalCode` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `address_index` (`eoid`),
  KEY `AddressIndex` (`eoid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_address`
--

LOCK TABLES `jos_cce_address` WRITE;
/*!40000 ALTER TABLE `jos_cce_address` DISABLE KEYS */;
INSERT INTO `jos_cce_address` VALUES (1,'','','','1972 Oak Grove Rd','','Walnut Creek','CA','94598','(925) 456-4215');
/*!40000 ALTER TABLE `jos_cce_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_announcement`
--

DROP TABLE IF EXISTS `jos_cce_announcement`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_announcement` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `content` text,
  `published` tinyint(1) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `announcement_index` (`eoid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_announcement`
--

LOCK TABLES `jos_cce_announcement` WRITE;
/*!40000 ALTER TABLE `jos_cce_announcement` DISABLE KEYS */;
INSERT INTO `jos_cce_announcement` VALUES (1,'Global','',0),(2,'Exhibition','',0),(3,'Program','',1),(4,'Course','',0),(5,'Venue','',0);
/*!40000 ALTER TABLE `jos_cce_announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_category`
--

DROP TABLE IF EXISTS `jos_cce_category`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_category` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `name` varchar(255) default NULL,
  `subtitle` varchar(255) default NULL,
  `alias` varchar(255) default NULL,
  `description` text,
  `family` tinyint(4) default NULL,
  `school` tinyint(4) default NULL,
  `image` varchar(255) default NULL,
  `introduction` text,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `category_index` (`eoid`),
  KEY `CategoryIndex` (`eoid`,`scope`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_category`
--

LOCK TABLES `jos_cce_category` WRITE;
/*!40000 ALTER TABLE `jos_cce_category` DISABLE KEYS */;
INSERT INTO `jos_cce_category` VALUES (1,'Genre','Theater','','theater','A genre to seed the database',0,0,'',''),(2,'Audience','Default Audience','',NULL,'A default audience to seed the database',0,0,'',''),(3,'Series','This is a Series','','first-series','<p>Series Description</p>',0,0,'','');
/*!40000 ALTER TABLE `jos_cce_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_course`
--

DROP TABLE IF EXISTS `jos_cce_course`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_course` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `subtitle` varchar(255) default NULL,
  `alias` varchar(255) default NULL,
  `style` varchar(255) default NULL,
  `summary` text,
  `description` text,
  `credit` text,
  `addtitle` varchar(255) default NULL,
  `addinfo` text,
  `addtitle2` char(255) default NULL,
  `addinfo2` text,
  `scheduleNote` text,
  `pricing` varchar(255) default NULL,
  `contact` varchar(255) default NULL,
  `featured` tinyint(4) default NULL,
  `ticketDesc` text,
  `ticketUrl` varchar(255) default NULL,
  `gallery` int(11) default NULL,
  `displayOrder` int(5) default NULL,
  `partnerCode` varchar(255) default NULL,
  `instructor` varchar(128) default NULL,
  `instructorBio` text,
  `videoClip` varchar(255) default NULL,
  `relatedArticles` int(11) default NULL,
  `pressRelease` int(11) default NULL,
  `commentArticle` int(11) default NULL,
  `audioClip` varchar(255) default NULL,
  `partnerName` varchar(255) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `course_index` (`eoid`),
  KEY `CourseIndex` (`eoid`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_course`
--

LOCK TABLES `jos_cce_course` WRITE;
/*!40000 ALTER TABLE `jos_cce_course` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_cce_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_enumerated_value`
--

DROP TABLE IF EXISTS `jos_cce_enumerated_value`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_enumerated_value` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `value` varchar(255) default NULL,
  `description` text,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `ev_index` (`eoid`),
  KEY `jos_cce_enumerated_value` (`eoid`,`scope`,`value`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_enumerated_value`
--

LOCK TABLES `jos_cce_enumerated_value` WRITE;
/*!40000 ALTER TABLE `jos_cce_enumerated_value` DISABLE KEYS */;
INSERT INTO `jos_cce_enumerated_value` VALUES (1,'PublicationState','Published','Content has been approved and published to the live web site'),(2,'PublicationState','Unpublished','Content is not available via the live web site'),(3,'PublicationState','Archived','Content has been removed from the admin web site'),(4,'EventStatus','Active','Event is active (tickets are still available)'),(5,'EventStatus','Sold Out','Tickets are no longer availabe for this event'),(6,'EventStatus','Cancelled','Event has been cancelled'),(7,'ProgramType','School','Program content is intended for school/education use'),(8,'ProgramType','Family','Program content is family-oriented'),(9,'ProgramType','General','Program appeals to the general public'),(10,'ResourceType','CMS','Integrated content management component (Joomla)'),(11,'ResourceType','Hyperink','Linked web page (opened in a new window)');
/*!40000 ALTER TABLE `jos_cce_enumerated_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_event`
--

DROP TABLE IF EXISTS `jos_cce_event`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_event` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `subtitle` varchar(255) default NULL,
  `summary` text,
  `description` text,
  `scheduleNote` text,
  `pricing` varchar(255) default NULL,
  `ticketDesc` text,
  `ticketUrl` varchar(255) default NULL,
  `gallery` int(11) default NULL,
  `displayOrder` int(5) default NULL,
  `audioClip` varchar(255) default NULL,
  `videoClip` varchar(255) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `EventIndex` (`eoid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_event`
--

LOCK TABLES `jos_cce_event` WRITE;
/*!40000 ALTER TABLE `jos_cce_event` DISABLE KEYS */;
INSERT INTO `jos_cce_event` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `jos_cce_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_exhibition`
--

DROP TABLE IF EXISTS `jos_cce_exhibition`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_exhibition` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `subtitle` varchar(255) default NULL,
  `alias` varchar(255) default NULL,
  `style` varchar(255) default NULL,
  `summary` text,
  `description` text,
  `credit` text,
  `addtitle` varchar(255) default NULL,
  `addinfo` text,
  `addtitle2` char(255) default NULL,
  `addinfo2` text,
  `scheduleNote` text,
  `pricing` varchar(255) default NULL,
  `contact` varchar(255) default NULL,
  `featured` tinyint(4) default NULL,
  `ticketDesc` text,
  `ticketUrl` varchar(255) default NULL,
  `gallery` int(11) default NULL,
  `displayOrder` int(5) default NULL,
  `audioClip` varchar(255) default NULL,
  `videoClip` varchar(255) default NULL,
  `relatedArticles` int(11) default NULL,
  `pressRelease` int(11) default NULL,
  `commentArticle` int(11) default NULL,
  `artifacts` varchar(255) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `exhibition_index` (`eoid`),
  KEY `ExhibitionIndex` (`eoid`,`title`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_exhibition`
--

LOCK TABLES `jos_cce_exhibition` WRITE;
/*!40000 ALTER TABLE `jos_cce_exhibition` DISABLE KEYS */;
INSERT INTO `jos_cce_exhibition` VALUES (1,'Exhibition','Gallery Exhibition','A test of all of the data','gallery-exhibition','','<p>summary</p>','<p>details</p>','<p>sponsor</p>','More Information Main','<p>more information copy</p>','sidebar info title','<p>sidebar information</p>','','pricing','',0,'ticket description','ticket code',0,1,'','',2,0,0,'');
/*!40000 ALTER TABLE `jos_cce_exhibition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_homepage`
--

DROP TABLE IF EXISTS `jos_cce_homepage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_homepage` (
  `eoid` int(12) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `startTime` int(16) default NULL,
  `event1` varchar(255) default NULL,
  `event2` varchar(255) default NULL,
  `event3` varchar(255) default NULL,
  `event4` varchar(255) default NULL,
  `event5` varchar(255) default NULL,
  `event6` varchar(255) default NULL,
  `event7` varchar(255) default NULL,
  `event8` varchar(255) default NULL,
  `event9` varchar(255) default NULL,
  `event10` varchar(255) default NULL,
  `event11` varchar(255) default NULL,
  `event12` varchar(255) default NULL,
  `event13` varchar(255) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `HomepageIndex` (`eoid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_homepage`
--

LOCK TABLES `jos_cce_homepage` WRITE;
/*!40000 ALTER TABLE `jos_cce_homepage` DISABLE KEYS */;
INSERT INTO `jos_cce_homepage` VALUES (1,'First Homepage',1251950400,'Exhibition.2','Exhibition.5','0','Program.3','Genre.26','Program.12','Program.13','0','0','0','0','0','0');
/*!40000 ALTER TABLE `jos_cce_homepage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_person`
--

DROP TABLE IF EXISTS `jos_cce_person`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_person` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `firstName` varchar(128) default NULL,
  `lastName` varchar(128) default NULL,
  `displayName` varchar(255) default NULL,
  `alias` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `summary` text,
  `role` tinyint(1) default NULL,
  `gallery` int(11) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `PersonIndex` (`eoid`,`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_person`
--

LOCK TABLES `jos_cce_person` WRITE;
/*!40000 ALTER TABLE `jos_cce_person` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_cce_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_program`
--

DROP TABLE IF EXISTS `jos_cce_program`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_program` (
  `eoid` int(12) NOT NULL auto_increment,
  `scope` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `subtitle` varchar(255) default NULL,
  `alias` varchar(255) default NULL,
  `style` varchar(255) default NULL,
  `summary` text,
  `description` text,
  `credit` text,
  `addtitle` varchar(255) default NULL,
  `addinfo` text,
  `addtitle2` char(255) default NULL,
  `addinfo2` text,
  `scheduleNote` text,
  `pricing` varchar(255) default NULL,
  `contact` varchar(255) default NULL,
  `featured` tinyint(4) default NULL,
  `ticketDesc` text,
  `ticketUrl` varchar(255) default NULL,
  `gallery` int(11) default NULL,
  `displayOrder` int(5) default NULL,
  `audioClip` varchar(255) default NULL,
  `videoClip` varchar(255) default NULL,
  `relatedArticles` int(11) default NULL,
  `pressRelease` int(11) default NULL,
  `commentArticle` int(11) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `idx_ev_scope` (`scope`),
  KEY `program_index` (`eoid`),
  KEY `ProgramIndex` (`eoid`,`title`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_program`
--

LOCK TABLES `jos_cce_program` WRITE;
/*!40000 ALTER TABLE `jos_cce_program` DISABLE KEYS */;
INSERT INTO `jos_cce_program` VALUES (1,'Program','Hands-On History Workshops for Kids','Subtitle','history-workshops','','<p>Test summary</p>','<p>Test description</p>','<p><img border=\"0\" src=\"plugins/editors/jce/tiny_mce/plugins/emotions/img/smiley-cool.gif\" alt=\"Cool\" title=\"Cool\" /> Justin</p>','','','Sidebar Additional Info','<p>Duis, velit vulputate eu dolore sit dignissim velit. Ad blandit dolor molestie, nulla dolore qui ex dolore luptatum tation sed consequat suscipit minim consequat. Ad facilisi consequatvel delenit, facilisis delenit dignissim augue nostrud elit.<br />\r\n<br />\r\nDolore accumsan erat eu feugait in qui suscipit enim dolore praesent feugiat, euismod wisi magna eu dolore.</p>','Saturdays in October','Free for Members--RSVP required; $15.00 Adults, $7.00 Children. Advance tickets available through online purchase (click TICKETS/RSVP)','',0,'Ticket Description','',0,0,'','',0,0,0);
/*!40000 ALTER TABLE `jos_cce_program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_schedule`
--

DROP TABLE IF EXISTS `jos_cce_schedule`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_schedule` (
  `eoid` int(12) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` text,
  `target` varchar(255) default NULL,
  `startTime` int(16) default NULL,
  `endTime` int(16) default NULL,
  `scope` varchar(255) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `schedule_index` (`eoid`),
  KEY `ScheduleIndex` (`eoid`,`scope`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_schedule`
--

LOCK TABLES `jos_cce_schedule` WRITE;
/*!40000 ALTER TABLE `jos_cce_schedule` DISABLE KEYS */;
INSERT INTO `jos_cce_schedule` VALUES (1,'','','',1251345600,1285560000,'Exhibition');
/*!40000 ALTER TABLE `jos_cce_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jos_cce_venue`
--

DROP TABLE IF EXISTS `jos_cce_venue`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `jos_cce_venue` (
  `eoid` int(12) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `alias` varchar(255) default NULL,
  `description` text,
  `gallery` int(11) default NULL,
  PRIMARY KEY  (`eoid`),
  KEY `venue_index` (`eoid`),
  KEY `VenueIndex` (`eoid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `jos_cce_venue`
--

LOCK TABLES `jos_cce_venue` WRITE;
/*!40000 ALTER TABLE `jos_cce_venue` DISABLE KEYS */;
INSERT INTO `jos_cce_venue` VALUES (1,'Default Venue',NULL,'',0);
/*!40000 ALTER TABLE `jos_cce_venue` ENABLE KEYS */;
UNLOCK TABLES;

