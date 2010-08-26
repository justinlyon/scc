-- MySQL dump 10.9
--
-- Host: localhost    Database: cjmdev
-- ------------------------------------------------------
-- Server version	4.1.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Activity`
--

DROP TABLE IF EXISTS `Activity`;
CREATE TABLE `Activity` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `ticketCode` varchar(255) default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `activity_index` (`eoid`),
 KEY `ActivityIndex` (`eoid`,`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `Address`
--

DROP TABLE IF EXISTS `Address`;
CREATE TABLE `Address` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



--
-- Table structure for table `Announcement`
--

DROP TABLE IF EXISTS `Announcement`;
CREATE TABLE `Announcement` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `content` text,
 `published` tinyint(1) default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `announcement_index` (`eoid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `Category`
--

DROP TABLE IF EXISTS `Category`;
CREATE TABLE `Category` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `name` varchar(255) default NULL,
 `subtitle` varchar(255) default NULL,
 `description` text,
 `family` tinyint(4) default NULL,
 `school` tinyint(4) default NULL,
 `image` varchar(255) default NULL,
 `introduction` text,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `category_index` (`eoid`),
 KEY `CategoryIndex` (`eoid`,`scope`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `Course`
--

DROP TABLE IF EXISTS `Course`;
CREATE TABLE `Course` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `title` varchar(255) default NULL,
 `subtitle` varchar(255) default NULL,
 `summary` text,
 `description` text,
 `credit` text,
 `addtitle` varchar(255) default NULL,
 `addinfo` text,
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
 `audioClip` varchar(255) default NULL,
 `partnerName` varchar(255) default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `course_index` (`eoid`),
 KEY `CourseIndex` (`eoid`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `EnumeratedValue`
--

DROP TABLE IF EXISTS `EnumeratedValue`;
CREATE TABLE `EnumeratedValue` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `value` varchar(255) default NULL,
 `description` text,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `ev_index` (`eoid`),
 KEY `EnumeratedValueIndex` (`eoid`,`scope`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `EnumeratedValue`
--


/*!40000 ALTER TABLE `EnumeratedValue` DISABLE KEYS */;
LOCK TABLES `EnumeratedValue` WRITE;
INSERT INTO `EnumeratedValue` VALUES (1,'PublicationState','Published','Content has been approved and published to the live web site'),(2,'PublicationState','Unpublished','Content is not available via the live web site'),(3,'PublicationState','Archived','Content has been removed from the admin web site'),(4,'EventStatus','Active','Event is active (tickets are still available)'),(5,'EventStatus','Sold Out','Tickets are no longer availabe for this event'),(6,'EventStatus','Cancelled','Event has been cancelled'),(7,'ProgramType','School','Program content is intended for school/education use'),(8,'ProgramType','Family','Program content is family-oriented'),(9,'ProgramType','General','Program appeals to the general public'),(10,'ResourceType','CMS','Integrated content management component (Joomla)'),(11,'ResourceType','Hyperink','Linked web page (opened in a new window)');
UNLOCK TABLES;
/*!40000 ALTER TABLE `EnumeratedValue` ENABLE KEYS */;

--
-- Table structure for table `Event`
--

DROP TABLE IF EXISTS `Event`;
CREATE TABLE `Event` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) collate latin1_general_ci default NULL,
 `title` varchar(255) collate latin1_general_ci default NULL,
 `subtitle` varchar(255) collate latin1_general_ci default NULL,
 `summary` text collate latin1_general_ci,
 `description` text collate latin1_general_ci,
 `scheduleNote` text collate latin1_general_ci,
 `pricing` varchar(255) collate latin1_general_ci default NULL,
 `ticketDesc` text collate latin1_general_ci,
 `ticketUrl` varchar(255) collate latin1_general_ci default NULL,
 `gallery` int(11) default NULL,
 `displayOrder` int(5) default NULL,
 `audioClip` varchar(255) collate latin1_general_ci default NULL,
 `videoClip` varchar(255) collate latin1_general_ci default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `EventIndex` (`eoid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;



--
-- Table structure for table `Exhibition`
--

DROP TABLE IF EXISTS `Exhibition`;
CREATE TABLE `Exhibition` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `title` varchar(255) default NULL,
 `subtitle` varchar(255) default NULL,
 `summary` text,
 `description` text,
 `credit` text,
 `addtitle` varchar(255) default NULL,
 `addinfo` text,
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
 `artifacts` varchar(255) default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `exhibition_index` (`eoid`),
 KEY `ExhibitionIndex` (`eoid`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `HomePage`
--

DROP TABLE IF EXISTS `HomePage`;
CREATE TABLE `HomePage` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table structure for table `Person`
--

DROP TABLE IF EXISTS `Person`;
CREATE TABLE `Person` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `firstName` varchar(128) default NULL,
 `lastName` varchar(128) default NULL,
 `displayName` varchar(255) default NULL,
 `title` varchar(255) default NULL,
 `summary` text,
 `role` tinyint(1) default NULL,
 `gallery` int(11) default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `PersonIndex` (`eoid`,`scope`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table structure for table `Program`
--

DROP TABLE IF EXISTS `Program`;
CREATE TABLE `Program` (
 `eoid` int(12) NOT NULL auto_increment,
 `scope` varchar(255) default NULL,
 `title` varchar(255) default NULL,
 `subtitle` varchar(255) default NULL,
 `summary` text,
 `description` text,
 `credit` text,
 `addtitle` varchar(255) default NULL,
 `addinfo` text,
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
 PRIMARY KEY  (`eoid`),
 KEY `idx_ev_scope` (`scope`),
 KEY `program_index` (`eoid`),
 KEY `ProgramIndex` (`eoid`,`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `Schedule`
--

DROP TABLE IF EXISTS `Schedule`;
CREATE TABLE `Schedule` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `Venue`
--

DROP TABLE IF EXISTS `Venue`;
CREATE TABLE `Venue` (
 `eoid` int(12) NOT NULL auto_increment,
 `name` varchar(255) default NULL,
 `description` text,
 `gallery` int(11) default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `venue_index` (`eoid`),
 KEY `VenueIndex` (`eoid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `_ez_relation_`
--

DROP TABLE IF EXISTS `_ez_relation_`;
CREATE TABLE `_ez_relation_` (
 `eoid` int(12) NOT NULL auto_increment,
 `class_a` varchar(64) default NULL,
 `oid_a` int(11) default NULL,
 `var_a` varchar(64) default NULL,
 `base_b` varchar(64) default NULL,
 `class_b` varchar(64) default NULL,
 `oid_b` int(11) default NULL,
 PRIMARY KEY  (`eoid`),
 KEY `idx_class_oid_a` (`class_a`,`oid_a`),
 KEY `ez_oid_a` (`oid_a`),
 KEY `ez_oid_b` (`oid_b`),
 KEY `ez_class_b` (`class_b`),
 KEY `ez_class_a` (`class_a`),
 KEY `relation_index` (`eoid`),
 KEY `relation_class_a` (`class_a`),
 KEY `relation_class_b` (`class_b`),
 KEY `relation_oid_a` (`oid_a`),
 KEY `relation_oid_b` (`oid_b`),
 KEY `relation_var_a` (`var_a`),
 KEY `relation_base_b` (`base_b`),
 KEY `RelationIndex` (`eoid`,`class_a`,`oid_a`,`var_a`,`base_b`,`class_b`,`oid_b`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

