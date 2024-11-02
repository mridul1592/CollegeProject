-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2014 at 12:15 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `talentwiz`
--
CREATE DATABASE IF NOT EXISTS `talentwiz` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `talentwiz`;

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidate`
--

CREATE TABLE IF NOT EXISTS `tblcandidate` (
  `cndId` varchar(10) NOT NULL,
  `cndFirstName` varchar(50) DEFAULT NULL,
  `cndLastName` varchar(50) DEFAULT NULL,
  `cndDOB` date DEFAULT NULL,
  `cndGender` varchar(10) NOT NULL,
  `cndEmailOfficial` varchar(100) DEFAULT NULL,
  `cndEmailPersonal` varchar(100) DEFAULT NULL,
  `cndStreetPermanent` varchar(100) DEFAULT NULL,
  `cndCountryPermanent` int(11) DEFAULT NULL,
  `cndStatePermanent` int(11) DEFAULT NULL,
  `cndCityPermanent` int(11) DEFAULT NULL,
  `cndPinPermanent` varchar(10) DEFAULT NULL,
  `cndStreetTemporary` varchar(100) DEFAULT NULL,
  `cndCountryTemporary` int(11) DEFAULT NULL,
  `cndStateTemporary` int(11) DEFAULT NULL,
  `cndCityTemporary` int(11) DEFAULT NULL,
  `cndPinTemporary` varchar(10) DEFAULT NULL,
  `cndMobilePrimary` varchar(10) DEFAULT NULL,
  `cndMobileSecondary` varchar(10) DEFAULT NULL,
  `cndBatch` decimal(4,0) DEFAULT NULL,
  `cndCollege` int(11) DEFAULT NULL,
  `cndRegDisId` varchar(100) DEFAULT NULL,
  `cndMajorProject` text,
  `cndMinorProject` text,
  `cndExpertiseInLanguages` text,
  `cndExpertiseInTechnologies` text,
  `cndResumePath` text,
  `cndAcademicQualification` varchar(100) DEFAULT NULL,
  `cndAcademicPercentage` int(11) DEFAULT NULL,
  PRIMARY KEY (`cndId`),
  KEY `FK_tblCandidate_cndCollege` (`cndCollege`),
  KEY `FK_tblCandidate_cndCountryPermanent` (`cndCountryPermanent`),
  KEY `FK_tblCandidate_cndStatePermanent` (`cndStatePermanent`),
  KEY `FK_tblCandidate_cndCityTemporary` (`cndCityTemporary`),
  KEY `FK_tblCandidate_cndStateTemporary` (`cndStateTemporary`),
  KEY `FK_tblCandidate_cndCityPermanent` (`cndCityPermanent`),
  KEY `FK_tblCandidate_cndCountryTemporary` (`cndCountryTemporary`),
  KEY `FK_tblCandidate_cndRegDisId` (`cndRegDisId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcandidate`
--

INSERT INTO `tblcandidate` (`cndId`, `cndFirstName`, `cndLastName`, `cndDOB`, `cndGender`, `cndEmailOfficial`, `cndEmailPersonal`, `cndStreetPermanent`, `cndCountryPermanent`, `cndStatePermanent`, `cndCityPermanent`, `cndPinPermanent`, `cndStreetTemporary`, `cndCountryTemporary`, `cndStateTemporary`, `cndCityTemporary`, `cndPinTemporary`, `cndMobilePrimary`, `cndMobileSecondary`, `cndBatch`, `cndCollege`, `cndRegDisId`, `cndMajorProject`, `cndMinorProject`, `cndExpertiseInLanguages`, `cndExpertiseInTechnologies`, `cndResumePath`, `cndAcademicQualification`, `cndAcademicPercentage`) VALUES
('cnd1', 'Harry', 'Potter', '1992-01-01', 'male', 'email@official.com', 'email@personal.com', 'streetpermanent', 1, 1, 1, '12244', 'streettemp', 1, 1, 1, '12244', '9876543210', '', '2014', 2, 'B.Tech/BE', 'major project', 'Minor project', 'language', 'technology', NULL, 'B.Tech', 88),
('cnd2', 'Martin', 'Luther', '2014-04-01', 'male', NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, '9876543213', NULL, NULL, 2, 'B.Tech/BE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cnd3', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9876123459', NULL, NULL, 1, 'B.Tech/BE', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('cnd6', 'martin', 'green', '2000-12-01', 'male', 'email@official.com', 'email@personal.com', 'asdfasdfasdf', 1, 1, 1, '12342322', 'asdfasdfasdf', 1, 1, 1, '12342322', '9876543210', '9876543210', '2014', 2, NULL, '', '', '', '', NULL, NULL, 88),
('cnd7', 'Bruce', 'Wills', '1992-12-15', 'male', 'email@official.com', 'email@personal.com', 'asdfasdfasdf', 1, 1, 1, '12342322', 'asdfasdfasdf', 1, 1, 1, '12342322', '9876543210', '9876543210', '2014', 2, NULL, '', '', '', '', NULL, NULL, 88),
('cnd8', 'willian', 'white', '2000-04-03', 'male', 'email@official.com', 'email@personal.com', 'asdfasdfasdf', 1, 1, 1, '12342322', 'asdfasdfasdf', 1, 1, 1, '12342322', '9876543210', '9876543210', '2014', 2, NULL, '', '', '', '', NULL, NULL, 88),
('cnd9', 'martin', 'Wills', '2001-04-03', 'male', 'email@official.com', 'email@personal.com', 'streetpermanent', 1, 1, 1, '12342322', 'streetpermanent', 1, 1, 1, '12342322', '9876543210', '9876543210', '2014', 1, NULL, '', '', '', '', NULL, NULL, 88);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE IF NOT EXISTS `tblcategory` (
  `catId` int(11) NOT NULL AUTO_INCREMENT,
  `catTitle` varchar(100) DEFAULT NULL,
  `catStatus` bit(1) DEFAULT NULL,
  `catParentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`catId`),
  KEY `FK_tblCategory_catParentId` (`catParentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`catId`, `catTitle`, `catStatus`, `catParentId`) VALUES
(4, 'Aptitude', b'1', NULL),
(5, 'Number System', b'1', 4),
(6, 'Technical', b'1', NULL),
(11, 'Framework', b'1', 6),
(12, 'PHP', b'1', 6),
(13, 'CMS', b'1', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tblcollege`
--

CREATE TABLE IF NOT EXISTS `tblcollege` (
  `clgId` int(11) NOT NULL AUTO_INCREMENT,
  `clgName` varchar(100) DEFAULT NULL,
  `clgShortName` varchar(50) DEFAULT NULL,
  `clgStreet` varchar(100) DEFAULT NULL,
  `clgCountry` int(11) DEFAULT NULL,
  `clgState` int(11) DEFAULT NULL,
  `clgCity` int(11) DEFAULT NULL,
  `clgPIN` varchar(10) DEFAULT NULL,
  `clgPhoneNos` varchar(50) DEFAULT NULL,
  `clgWebsiteUrl` varchar(100) DEFAULT NULL,
  `clgHRName` varchar(100) DEFAULT NULL,
  `clgHREmail` varchar(100) DEFAULT NULL,
  `clgHRPhoneNos` varchar(50) DEFAULT NULL,
  `clgTPOName` varchar(100) DEFAULT NULL,
  `clgTPOEmail` varchar(100) DEFAULT NULL,
  `clgTPOPhoneNos` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`clgId`),
  KEY `FK_tblGICountry_countryId` (`clgCountry`),
  KEY `FK_tblGIState_stateId` (`clgState`),
  KEY `FK_tblGICity_cityId` (`clgCity`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblcollege`
--

INSERT INTO `tblcollege` (`clgId`, `clgName`, `clgShortName`, `clgStreet`, `clgCountry`, `clgState`, `clgCity`, `clgPIN`, `clgPhoneNos`, `clgWebsiteUrl`, `clgHRName`, `clgHREmail`, `clgHRPhoneNos`, `clgTPOName`, `clgTPOEmail`, `clgTPOPhoneNos`) VALUES
(1, 'University Institute of Engineering and Technology', 'UIET', 'sector 25', 1, 1, 1, '160014', '9876543210', 'www.uiet.puchd.com', 'HR name', 'email@email.com', '9876543210', 'TPO Name', 'email@email.com', '9876543210'),
(2, 'Punjab Engineering College', 'PEC', 'sector 12', 1, 1, 1, '160012', '9876543210', 'www.pec.com', 'harish', 'harish@gmail.com', '9876543210', 'harry', 'harry@gmail.com', '9876543239');

-- --------------------------------------------------------

--
-- Table structure for table `tblfaq`
--

CREATE TABLE IF NOT EXISTS `tblfaq` (
  `faqId` int(11) NOT NULL AUTO_INCREMENT,
  `faq` varchar(500) DEFAULT NULL,
  `faqAns` text,
  `faqPostOn` date DEFAULT NULL,
  `faqStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`faqId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tblfaq`
--

INSERT INTO `tblfaq` (`faqId`, `faq`, `faqAns`, `faqPostOn`, `faqStatus`) VALUES
(1, 'What is faq?', 'Frequently Asked Questions.', '2014-04-27', b'1'),
(2, 'Test FAQ', 'test 12', '2014-04-24', b'1'),
(3, 'new FAQ', 'al;sjdkf;laskjf', '2014-04-20', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblfeedback`
--

CREATE TABLE IF NOT EXISTS `tblfeedback` (
  `feedbackId` int(11) NOT NULL AUTO_INCREMENT,
  `feedbackTitle` varchar(100) DEFAULT NULL,
  `feedbackDesc` text,
  `feedbackDate` datetime DEFAULT NULL,
  `feedbackSendBy` varchar(10) DEFAULT NULL,
  `feedbackStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`feedbackId`),
  KEY `FK_tblFeedback_feedbackSendBy` (`feedbackSendBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tblfeedback`
--

INSERT INTO `tblfeedback` (`feedbackId`, `feedbackTitle`, `feedbackDesc`, `feedbackDate`, `feedbackSendBy`, `feedbackStatus`) VALUES
(2, 'feedback', 'feedbackkasd;j', '2014-04-02 15:50:45', 'cnd1', b'1'),
(3, 'feedback2', 'asdfasf', '2014-04-02 15:58:24', 'cnd1', b'1'),
(4, 'asdfasfda', 'asdfasdf', '2014-04-02 16:11:46', 'cnd1', b'1'),
(5, 'request', 'send request!!!', '2014-04-16 11:42:39', 'admin', b'1'),
(6, 'admin feedback', ';lakjsdf;lj', '2014-04-16 11:43:09', 'admin', b'1'),
(7, 'feedl;asjkfd', 'as;ldfja;lskdjf', '2014-04-20 14:58:10', 'cnd1', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblgicity`
--

CREATE TABLE IF NOT EXISTS `tblgicity` (
  `cityId` int(11) NOT NULL AUTO_INCREMENT,
  `cityName` varchar(100) DEFAULT NULL,
  `stateId` int(11) DEFAULT NULL,
  `cityStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`cityId`),
  KEY `FK_tblGICity_stateId` (`stateId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tblgicity`
--

INSERT INTO `tblgicity` (`cityId`, `cityName`, `stateId`, `cityStatus`) VALUES
(1, 'Chandigarh', 1, b'1'),
(2, 'Mohali', 1, b'1'),
(3, 'Moga', 1, b'1'),
(4, 'Patiala', 1, b'1'),
(5, 'Amritsar', 1, b'0'),
(6, 'Ropar', 1, b'1'),
(7, 'Panchkula', 2, b'1'),
(8, 'Kurukshetra', 2, b'1'),
(9, 'Barwala', 2, b'1'),
(10, 'Rohtak', 2, b'1'),
(11, 'Shimla', 3, b'1'),
(12, 'Solan', 3, b'1'),
(13, 'Dharampur', 3, b'1'),
(14, 'Parwanoo', 3, b'1'),
(15, 'Kinnor', 3, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblgicountry`
--

CREATE TABLE IF NOT EXISTS `tblgicountry` (
  `countryId` int(11) NOT NULL AUTO_INCREMENT,
  `countryName` varchar(100) DEFAULT NULL,
  `countryStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`countryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tblgicountry`
--

INSERT INTO `tblgicountry` (`countryId`, `countryName`, `countryStatus`) VALUES
(1, 'India', b'1'),
(2, 'Pakistan', b'1'),
(3, 'Afganistan', b'1'),
(4, 'Bangladesh', b'1'),
(5, 'Sri Lanka', b'1'),
(6, 'Australia', b'1'),
(7, 'Canada', b'1'),
(8, 'South Africa', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblgistate`
--

CREATE TABLE IF NOT EXISTS `tblgistate` (
  `stateId` int(11) NOT NULL AUTO_INCREMENT,
  `stateName` varchar(100) DEFAULT NULL,
  `countryId` int(11) DEFAULT NULL,
  `stateStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`stateId`),
  KEY `FK_tblGIState_countryId` (`countryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tblgistate`
--

INSERT INTO `tblgistate` (`stateId`, `stateName`, `countryId`, `stateStatus`) VALUES
(1, 'Punjab ', 1, b'1'),
(2, 'Haryana', 1, b'1'),
(3, 'Himachal Pradesh', 1, b'1'),
(4, 'Uttar Pradesh', 1, b'1'),
(5, 'Jammu and Kashmir', 1, b'1'),
(6, 'Rajasthan', 1, b'1'),
(7, 'Orrisa', 1, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tbljobcategory`
--

CREATE TABLE IF NOT EXISTS `tbljobcategory` (
  `jobId` int(11) NOT NULL,
  `catId` int(11) NOT NULL,
  PRIMARY KEY (`jobId`,`catId`),
  KEY `FK_tblJobCategory_catId` (`catId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbljobcategory`
--

INSERT INTO `tbljobcategory` (`jobId`, `catId`) VALUES
(25, 4),
(25, 5),
(17, 6),
(24, 6),
(17, 11),
(24, 11),
(17, 12),
(24, 12),
(17, 13),
(24, 13);

-- --------------------------------------------------------

--
-- Table structure for table `tbljobopening`
--

CREATE TABLE IF NOT EXISTS `tbljobopening` (
  `jobId` int(11) NOT NULL AUTO_INCREMENT,
  `jobTitle` varchar(100) DEFAULT NULL,
  `jobDesignation` varchar(100) DEFAULT NULL,
  `jobDesc` text,
  `jobQualification` text,
  `jobTechnology` text,
  `jobPositionCount` int(11) DEFAULT NULL,
  `jobStatus` varchar(10) DEFAULT NULL COMMENT 'It may be \\''Open\\'' or \\''Close\\''.',
  `jobTestRules` text,
  PRIMARY KEY (`jobId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbljobopening`
--

INSERT INTO `tbljobopening` (`jobId`, `jobTitle`, `jobDesignation`, `jobDesc`, `jobQualification`, `jobTechnology`, `jobPositionCount`, `jobStatus`, `jobTestRules`) VALUES
(17, 'XYZ', 'a;slkdjf', 'a;lksdjf', ';lkasjdf;l', 'kj;alskdjf;l', 12, '1', 'as;ldkfj'),
(24, 'asdf', 'asfd', 'asdf', 'asdf', 'asdf', 12, '1', 'asdf'),
(25, 'Teacher', 'assistant proffessor', 'a;lskjd\r\nasdfa\r\nsdf', 'ljas;ldfkj;alsdf\r\nasdf\r\nasga\r\nsdf', 'asdf\r\nasdflkasd;fljasdf\r\nasdfa;lsdjf;asf', 78, '1', 'asoidjf;aks;');

-- --------------------------------------------------------

--
-- Table structure for table `tbljobtest`
--

CREATE TABLE IF NOT EXISTS `tbljobtest` (
  `jobTestId` int(11) NOT NULL AUTO_INCREMENT,
  `cndId` varchar(10) DEFAULT NULL,
  `jobId` int(11) DEFAULT NULL,
  `jobTestOn` datetime DEFAULT NULL,
  `jobTestCorrectAns` int(11) DEFAULT NULL,
  `jobTestWrongAns` int(11) DEFAULT NULL,
  `jobTestTotalQuestions` int(11) NOT NULL,
  `jobIsSelected` bit(1) DEFAULT NULL,
  PRIMARY KEY (`jobTestId`),
  KEY `FK_tblJobTest_cndId` (`cndId`),
  KEY `FK_tblJobTest_jobId` (`jobId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `tbljobtest`
--

INSERT INTO `tbljobtest` (`jobTestId`, `cndId`, `jobId`, `jobTestOn`, `jobTestCorrectAns`, `jobTestWrongAns`, `jobTestTotalQuestions`, `jobIsSelected`) VALUES
(3, 'cnd1', 17, '2014-04-16 16:48:29', NULL, NULL, 0, b'1'),
(5, 'cnd1', 17, '2014-04-17 11:26:48', NULL, NULL, 0, b'1'),
(9, 'cnd2', 17, '2014-04-17 17:26:05', 4, 1, 0, NULL),
(16, 'cnd1', 17, '2014-04-20 14:36:31', 5, 0, 5, b'1'),
(31, 'cnd7', 17, '2014-04-25 13:27:27', NULL, NULL, 0, NULL),
(34, 'cnd8', 17, '2014-04-25 13:56:21', NULL, NULL, 0, NULL),
(40, 'cnd2', 25, '2014-04-29 17:43:53', 5, 0, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpostdiscussion`
--

CREATE TABLE IF NOT EXISTS `tblpostdiscussion` (
  `postId` int(11) NOT NULL AUTO_INCREMENT,
  `postTopic` varchar(200) DEFAULT NULL,
  `postDesc` text,
  `postBy` varchar(10) DEFAULT NULL,
  `postDate` datetime DEFAULT NULL,
  `postStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`postId`),
  KEY `FK_tblPostDiscussion_postBy` (`postBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tblpostdiscussion`
--

INSERT INTO `tblpostdiscussion` (`postId`, `postTopic`, `postDesc`, `postBy`, `postDate`, `postStatus`) VALUES
(1, 'discussion', 'aslkdfal;skjfd', 'admin', '2014-04-02 17:08:32', b'1'),
(2, 'discussion 2', '`asjdf;la\r\nasfdljasfd''asfdas\r\n\\a\r\nsdf\r\nasdfa\r\nsfas\r\nfd', 'admin', '2014-04-02 17:09:31', b'1'),
(3, 'topic 3', 'discussion', 'admin', '2014-04-03 14:20:32', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblquestion`
--

CREATE TABLE IF NOT EXISTS `tblquestion` (
  `qusId` int(11) NOT NULL AUTO_INCREMENT,
  `qusTitle` text,
  `qusCategory` int(11) DEFAULT NULL,
  `qusIQLevel` varchar(10) DEFAULT NULL COMMENT 'Question IQ level may be Basic, Fresher and Experienced.',
  `qusType` varchar(10) DEFAULT NULL COMMENT 'Question type may be True/False, or having four options.',
  `qusImagePath` text,
  `qusOption1` text,
  `qusOption2` text,
  `qusOption3` text,
  `qusOption4` text,
  `qusCorrectAns` int(11) DEFAULT NULL,
  `qusStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`qusId`),
  KEY `FK_tblQuestion_qusCategory` (`qusCategory`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tblquestion`
--

INSERT INTO `tblquestion` (`qusId`, `qusTitle`, `qusCategory`, `qusIQLevel`, `qusType`, `qusImagePath`, `qusOption1`, `qusOption2`, `qusOption3`, `qusOption4`, `qusCorrectAns`, `qusStatus`) VALUES
(7, 'question', 11, 'easy', 'obj', '', 'asfd', 'asdf', 'asd', 'asd', 1, b'1'),
(9, 'new question', 11, 'easy', 'tf', '', NULL, NULL, NULL, NULL, 1, b'1'),
(11, ';lkajsdf;lkj', 11, 'difficult', 'tf', '', NULL, NULL, NULL, NULL, 1, b'1'),
(14, 'new question', 11, 'difficult', 'tf', '', NULL, NULL, NULL, NULL, 1, b'1'),
(15, 'new question 2', 11, 'difficult', 'tf', '', NULL, NULL, NULL, NULL, 1, b'1'),
(23, 'new 5', 11, 'difficult', 'tf', '', NULL, NULL, NULL, NULL, 1, b'1'),
(24, 'new 5', 11, 'difficult', 'tf', NULL, NULL, NULL, NULL, NULL, 1, b'1'),
(26, 'new question', 5, 'easy', 'tf', NULL, NULL, NULL, NULL, NULL, 1, b'1'),
(27, 'new 5', 5, 'easy', 'tf', NULL, NULL, NULL, NULL, NULL, 1, b'1'),
(28, 'new 5', 5, 'easy', 'tf', NULL, NULL, NULL, NULL, NULL, 1, b'1'),
(29, 'new 5', 5, 'easy', 'tf', NULL, NULL, NULL, NULL, NULL, 1, b'1'),
(30, 'new 5', 5, 'easy', 'tf', NULL, NULL, NULL, NULL, NULL, 1, b'1'),
(31, 'new 5', 5, 'easy', 'tf', NULL, NULL, NULL, NULL, NULL, 1, b'1'),
(32, 'new 5', 5, 'easy', 'tf', 'documents/qusImages/Penguins__32.jpg', NULL, NULL, NULL, NULL, 1, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblreplydiscussion`
--

CREATE TABLE IF NOT EXISTS `tblreplydiscussion` (
  `replyId` int(11) NOT NULL AUTO_INCREMENT,
  `postId` int(11) DEFAULT NULL,
  `replyDesc` text,
  `replyBy` varchar(10) DEFAULT NULL,
  `replyDate` datetime DEFAULT NULL,
  `replyStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`replyId`),
  KEY `FK_tblReplyDiscussion_postId` (`postId`),
  KEY `FK_tblReplyDiscussion_replyBy` (`replyBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tblreplydiscussion`
--

INSERT INTO `tblreplydiscussion` (`replyId`, `postId`, `replyDesc`, `replyBy`, `replyDate`, `replyStatus`) VALUES
(10, 2, 'asfasdfasdf\r\nasf\r\na\r\nsdf\r\nas\r\ndf\r\nasdf', 'admin', '2014-04-07 17:25:38', b'1'),
(14, 3, ';lasalkdjf;asf', 'admin', '2014-04-27 12:32:01', b'1'),
(15, 3, ';lajsdf;lkasjdf;', 'admin', '2014-04-27 12:32:05', b'1'),
(17, 1, 'jhgfkhilj', 'admin', '2014-04-27 15:20:55', b'1'),
(18, 1, 'ajdfkajsdfasdf', 'cnd1', '2014-04-29 17:30:53', b'1'),
(19, 1, ';laksdjfa;lsjdf;laksdjf', 'cnd1', '2014-04-29 17:31:09', b'1'),
(20, 2, 'lkjSD;FLKJadf', 'cnd1', '2014-04-29 17:31:26', b'1'),
(21, 3, 'lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.\r\nlorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.lorem ipsum dummy data.', 'cnd1', '2014-04-29 17:32:20', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tblrequest`
--

CREATE TABLE IF NOT EXISTS `tblrequest` (
  `requestId` int(11) NOT NULL AUTO_INCREMENT,
  `requestTitle` varchar(200) DEFAULT NULL,
  `requestDesc` text,
  `requestDate` datetime DEFAULT NULL,
  `requestBy` varchar(10) DEFAULT NULL,
  `responseDesc` text,
  `responseDate` datetime DEFAULT NULL,
  `requestStatus` bit(1) DEFAULT NULL,
  PRIMARY KEY (`requestId`),
  KEY `FK_tblRequest_requestBy` (`requestBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tblrequest`
--

INSERT INTO `tblrequest` (`requestId`, `requestTitle`, `requestDesc`, `requestDate`, `requestBy`, `responseDesc`, `responseDate`, `requestStatus`) VALUES
(3, 'request', 'request11', '2014-04-08 14:52:29', 'cnd1', 'admin response', '2014-04-29 17:26:02', b'1'),
(4, 'request', 'request1kjl', '2014-04-08 14:54:17', 'cnd1', NULL, NULL, b'1'),
(5, 'request 1', 'asfl;kasfdlkj;as\r\nasdf\r\n\r\nasdf\r\na\r\nsdf\r\nas\r\nfasf', '2014-04-08 15:02:45', 'cnd1', NULL, NULL, b'1'),
(6, 'request 12', 'description', '2014-04-14 11:30:10', 'cnd1', NULL, NULL, b'1'),
(7, 'admin request', 'a;lsdjf;l', '2014-04-16 11:42:58', 'admin', NULL, NULL, b'1'),
(8, 'a;lsdkjf', ';laskjdf;laskjdf', '2014-04-20 14:59:05', 'cnd1', NULL, NULL, b'1'),
(10, ';oajw;fasdkj', 'as;ldkjfa;lsdjkf', '2014-04-29 16:39:06', 'cnd1', NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE IF NOT EXISTS `tbluser` (
  `usrId` varchar(10) NOT NULL,
  `usrPwd` varchar(10) DEFAULT NULL,
  `usrSQ` varchar(200) DEFAULT NULL,
  `usrSA` varchar(50) DEFAULT NULL,
  `usrType` varchar(10) DEFAULT NULL,
  `usrStatus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`usrId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`usrId`, `usrPwd`, `usrSQ`, `usrSA`, `usrType`, `usrStatus`) VALUES
('', NULL, 'What is your mother''s maiden name?', 'asdf', 'admin', 'active'),
('admin', 'admin', 'Who is your childhood hero?', 'superman', 'admin', 'active'),
('cnd1', 'cnd1', 'What is your pets name?', 'pet', 'candidate', 'active'),
('cnd2', 'cnd2', 'What is your mother''s maiden name?', 'mother', 'candidate', 'active'),
('cnd3', 'cnd3', 'Who is your childhood hero?', 'batman', 'candidate', 'inactive'),
('cnd6', 'cnd6', 'Who is your childhood hero?', 'ROBIN', 'candidate', 'active'),
('cnd7', 'cnd7', 'Who is your childhood hero?', 'batman', 'candidate', 'active'),
('cnd8', 'cnd8', 'Who is your childhood hero?', 'superman', 'candidate', 'active'),
('cnd9', 'cnd9', 'Who is your childhood hero?', 'superman', 'candidate', 'active'),
('user', 'user', 'Who is your childhood hero?', 'heman', 'operator', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserdetail`
--

CREATE TABLE IF NOT EXISTS `tbluserdetail` (
  `usrId` varchar(10) NOT NULL,
  `usrName` varchar(100) DEFAULT NULL,
  `usrDOB` date DEFAULT NULL,
  `usrGender` varchar(10) DEFAULT NULL,
  `usrEmail` varchar(100) DEFAULT NULL,
  `usrStreet` varchar(100) DEFAULT NULL,
  `usrCountry` int(11) DEFAULT NULL,
  `usrState` int(11) DEFAULT NULL,
  `usrCity` int(11) DEFAULT NULL,
  `usrPIN` varchar(10) DEFAULT NULL,
  `usrMobile` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`usrId`),
  KEY `FK_tblUserDetail_usrCountry` (`usrCountry`),
  KEY `FK_tblUserDetail_usrState` (`usrState`),
  KEY `FK_tblUserDetail_cityId` (`usrCity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluserdetail`
--

INSERT INTO `tbluserdetail` (`usrId`, `usrName`, `usrDOB`, `usrGender`, `usrEmail`, `usrStreet`, `usrCountry`, `usrState`, `usrCity`, `usrPIN`, `usrMobile`) VALUES
('', 'asdf', '2014-04-01', 'male', 'abc@yahoo.com', 'asdfasdfasdf', 1, 1, 1, '1234556', '1234567890'),
('admin', 'Martins', '2013-01-01', 'male', 'martin@yahoo.com', '#145 Sector 90A', 1, 1, 1, '160023', '9876543210'),
('user', 'Harry', '2012-08-05', 'male', 'harry@operator.com', '#25 Sector 10A', 1, 1, 1, '160090', '8745874589');

-- --------------------------------------------------------

--
-- Table structure for table `tblusersq`
--

CREATE TABLE IF NOT EXISTS `tblusersq` (
  `usrSQ` varchar(200) NOT NULL,
  PRIMARY KEY (`usrSQ`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblusersq`
--

INSERT INTO `tblusersq` (`usrSQ`) VALUES
('What is your favorite song?'),
('What is your mother''s maiden name?'),
('What is your pets name?'),
('What is your place of birth?'),
('Who is your childhood hero?');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  ADD CONSTRAINT `FK_tblCandidate_cndCityPermanent` FOREIGN KEY (`cndCityPermanent`) REFERENCES `tblgicity` (`cityId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblCandidate_cndCityTemporary` FOREIGN KEY (`cndCityTemporary`) REFERENCES `tblgicity` (`cityId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblCandidate_cndCollege` FOREIGN KEY (`cndCollege`) REFERENCES `tblcollege` (`clgId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblCandidate_cndCountryPermanent` FOREIGN KEY (`cndCountryPermanent`) REFERENCES `tblgicountry` (`countryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblCandidate_cndCountryTemporary` FOREIGN KEY (`cndCountryTemporary`) REFERENCES `tblgicountry` (`countryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblCandidate_cndId` FOREIGN KEY (`cndId`) REFERENCES `tbluser` (`usrId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblCandidate_cndStatePermanent` FOREIGN KEY (`cndStatePermanent`) REFERENCES `tblgistate` (`stateId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblCandidate_cndStateTemporary` FOREIGN KEY (`cndStateTemporary`) REFERENCES `tblgistate` (`stateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD CONSTRAINT `FK_tblCategory_catParentId` FOREIGN KEY (`catParentId`) REFERENCES `tblcategory` (`catId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblcollege`
--
ALTER TABLE `tblcollege`
  ADD CONSTRAINT `FK_tblGICity_cityId` FOREIGN KEY (`clgCity`) REFERENCES `tblgicity` (`cityId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblGICountry_countryId` FOREIGN KEY (`clgCountry`) REFERENCES `tblgicountry` (`countryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblGIState_stateId` FOREIGN KEY (`clgState`) REFERENCES `tblgistate` (`stateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD CONSTRAINT `FK_tblFeedback_feedbackSendBy` FOREIGN KEY (`feedbackSendBy`) REFERENCES `tbluser` (`usrId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblgicity`
--
ALTER TABLE `tblgicity`
  ADD CONSTRAINT `FK_tblGICity_stateId` FOREIGN KEY (`stateId`) REFERENCES `tblgistate` (`stateId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblgistate`
--
ALTER TABLE `tblgistate`
  ADD CONSTRAINT `FK_tblGIState_countryId` FOREIGN KEY (`countryId`) REFERENCES `tblgicountry` (`countryId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbljobcategory`
--
ALTER TABLE `tbljobcategory`
  ADD CONSTRAINT `FK_tblJobCategory_catId` FOREIGN KEY (`catId`) REFERENCES `tblcategory` (`catId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblJobCategory_jobId` FOREIGN KEY (`jobId`) REFERENCES `tbljobopening` (`jobId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbljobtest`
--
ALTER TABLE `tbljobtest`
  ADD CONSTRAINT `FK_tblJobTest_cndId` FOREIGN KEY (`cndId`) REFERENCES `tblcandidate` (`cndId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblJobTest_jobId` FOREIGN KEY (`jobId`) REFERENCES `tbljobopening` (`jobId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblpostdiscussion`
--
ALTER TABLE `tblpostdiscussion`
  ADD CONSTRAINT `FK_tblPostDiscussion_postBy` FOREIGN KEY (`postBy`) REFERENCES `tbluser` (`usrId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblquestion`
--
ALTER TABLE `tblquestion`
  ADD CONSTRAINT `FK_tblQuestion_qusCategory` FOREIGN KEY (`qusCategory`) REFERENCES `tblcategory` (`catId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblreplydiscussion`
--
ALTER TABLE `tblreplydiscussion`
  ADD CONSTRAINT `FK_tblReplyDiscussion_postId` FOREIGN KEY (`postId`) REFERENCES `tblpostdiscussion` (`postId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblReplyDiscussion_replyBy` FOREIGN KEY (`replyBy`) REFERENCES `tbluser` (`usrId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblrequest`
--
ALTER TABLE `tblrequest`
  ADD CONSTRAINT `FK_tblRequest_requestBy` FOREIGN KEY (`requestBy`) REFERENCES `tbluser` (`usrId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbluserdetail`
--
ALTER TABLE `tbluserdetail`
  ADD CONSTRAINT `FK_tblUserDetail_cityId` FOREIGN KEY (`usrCity`) REFERENCES `tblgicity` (`cityId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblUserDetail_usrCountry` FOREIGN KEY (`usrCountry`) REFERENCES `tblgicountry` (`countryId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblUserDetail_usrId` FOREIGN KEY (`usrId`) REFERENCES `tbluser` (`usrId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tblUserDetail_usrState` FOREIGN KEY (`usrState`) REFERENCES `tblgistate` (`stateId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
