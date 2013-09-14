-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2013 at 09:12 PM
-- Server version: 5.5.32-MariaDB
-- PHP Version: 5.5.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `c1_updb`
--

-- --------------------------------------------------------

--
-- Table structure for table `up_acl_groups`
--

CREATE TABLE IF NOT EXISTS `up_acl_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `group_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_status` enum('active','suspended') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `owner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_date_add` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `group_date_mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`),
  KEY `k_status` (`group_status`),
  KEY `k_level` (`group_level`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `up_acl_groups`
--

INSERT INTO `up_acl_groups` (`group_id`, `group_name`, `group_level`, `group_status`, `owner_id`, `group_date_add`, `group_date_mod`) VALUES
(1, 'visitors', 0, 'active', 1, '2013-07-05 18:43:43', '2013-07-05 14:43:43'),
(2, 'users', 1, 'active', 1, '2013-07-05 18:44:18', '2013-07-05 14:44:18'),
(3, 'admins', 2, 'active', 1, '2013-07-05 18:44:18', '2013-07-05 14:44:26');

--
-- Triggers `up_acl_groups`
--
DROP TRIGGER IF EXISTS `up_acl_groups_insert`;
DELIMITER //
CREATE TRIGGER `up_acl_groups_insert` BEFORE INSERT ON `up_acl_groups`
 FOR EACH ROW BEGIN
	IF NEW.group_date_add = '0000-00-00 00:00:00' THEN
		SET NEW.group_date_add = NOW();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `up_acl_logins`
--

CREATE TABLE IF NOT EXISTS `up_acl_logins` (
  `login_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `login_auto` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `user_email` varchar(90) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_ip` int(10) NOT NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `login_date_add` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `up_acl_logins`
--

INSERT INTO `up_acl_logins` (`login_id`, `user_id`, `login_auto`, `user_email`, `user_ip`, `user_agent`, `login_date_add`) VALUES
(1, 1, 'false', 'radu@webserv.co', 2147483647, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36', '2013-09-14 21:00:33');

--
-- Triggers `up_acl_logins`
--
DROP TRIGGER IF EXISTS `up_acl_logins_insert`;
DELIMITER //
CREATE TRIGGER `up_acl_logins_insert` BEFORE INSERT ON `up_acl_logins`
 FOR EACH ROW BEGIN
	IF NEW.login_date_add = '0000-00-00 00:00:00' THEN
		SET NEW.login_date_add = NOW();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `up_acl_object_relation`
--
CREATE TABLE IF NOT EXISTS `up_acl_object_relation` (
`relation_id` int(10) unsigned
,`user_id` int(10) unsigned
,`group_id` int(10) unsigned
,`group_name` varchar(45)
,`group_level` tinyint(1) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `up_acl_object_user`
--
CREATE TABLE IF NOT EXISTS `up_acl_object_user` (
`user_id` int(10) unsigned
,`user_email` varchar(90)
,`user_nickname` varchar(45)
,`user_auth` varchar(60)
,`user_status` enum('active','suspended')
,`owner_id` int(10) unsigned
,`user_date_add` datetime
,`user_date_mod` timestamp
,`custom_id` int(10) unsigned
,`user_id_key` int(10) unsigned
,`user_name_first` varchar(90)
,`user_name_last` varchar(90)
,`user_country` char(2)
);
-- --------------------------------------------------------

--
-- Table structure for table `up_acl_persistent`
--

CREATE TABLE IF NOT EXISTS `up_acl_persistent` (
  `persistent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `persistent_token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `persistent_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `persistent_date_add` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`persistent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Triggers `up_acl_persistent`
--
DROP TRIGGER IF EXISTS `up_acl_persistent_insert`;
DELIMITER //
CREATE TRIGGER `up_acl_persistent_insert` BEFORE INSERT ON `up_acl_persistent`
 FOR EACH ROW BEGIN
	IF NEW.persistent_date_add = '0000-00-00 00:00:00' THEN
		SET NEW.persistent_date_add = NOW();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `up_acl_relations`
--

CREATE TABLE IF NOT EXISTS `up_acl_relations` (
  `relation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_id` int(10) unsigned DEFAULT '0',
  `owner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `relation_date_add` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `relation_date_mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `up_acl_relations`
--

INSERT INTO `up_acl_relations` (`relation_id`, `user_id`, `group_id`, `owner_id`, `relation_date_add`, `relation_date_mod`) VALUES
(3, 1, 3, 0, '2013-09-14 21:09:02', '2013-09-14 19:09:02');

--
-- Triggers `up_acl_relations`
--
DROP TRIGGER IF EXISTS `up_acl_relations_insert`;
DELIMITER //
CREATE TRIGGER `up_acl_relations_insert` BEFORE INSERT ON `up_acl_relations`
 FOR EACH ROW BEGIN
	IF NEW.relation_date_add = '0000-00-00 00:00:00' THEN
		SET NEW.relation_date_add = NOW();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `up_acl_rules`
--

CREATE TABLE IF NOT EXISTS `up_acl_rules` (
  `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule_type` enum('user','group') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'group',
  `rule_value` int(10) unsigned NOT NULL DEFAULT '0',
  `rule_resource` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `rule_asset` int(10) unsigned NOT NULL DEFAULT '0',
  `rule_action` enum('ALLOW','DENY') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ALLOW',
  `owner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rule_date_add` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rule_date_mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rule_id`),
  KEY `k_rules` (`rule_type`,`rule_value`,`rule_resource`,`rule_asset`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `up_acl_rules`
--

INSERT INTO `up_acl_rules` (`rule_id`, `rule_type`, `rule_value`, `rule_resource`, `rule_asset`, `rule_action`, `owner_id`, `rule_date_add`, `rule_date_mod`) VALUES
(11, 'group', 3, 'Content/Admin/Home', 0, 'ALLOW', 0, '2013-09-14 21:09:34', '2013-09-14 19:09:34'),
(12, 'group', 3, 'Users/Admin/Users', 0, 'ALLOW', 0, '2013-09-14 21:10:06', '2013-09-14 19:10:06'),
(13, 'group', 3, 'Users/Admin/User', 0, 'ALLOW', 0, '2013-09-14 21:10:06', '2013-09-14 19:10:06');

--
-- Triggers `up_acl_rules`
--
DROP TRIGGER IF EXISTS `up_acl_rules_insert`;
DELIMITER //
CREATE TRIGGER `up_acl_rules_insert` BEFORE INSERT ON `up_acl_rules`
 FOR EACH ROW BEGIN
	IF NEW.rule_date_add = '0000-00-00 00:00:00' THEN
		SET NEW.rule_date_add = NOW();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `up_acl_users`
--

CREATE TABLE IF NOT EXISTS `up_acl_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `user_nickname` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `user_auth` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` enum('active','suspended') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `owner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_date_add` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_date_mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `k_email_unique` (`user_email`),
  KEY `k_status` (`user_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `up_acl_users`
--

INSERT INTO `up_acl_users` (`user_id`, `user_email`, `user_nickname`, `user_auth`, `user_status`, `owner_id`, `user_date_add`, `user_date_mod`) VALUES
(1, 'radu@webserv.co', '', '2c9a7571492cc28daf38828cae8a9197ed12a5fadeedce67f7229440b6dd', 'active', 1, '2013-09-14 21:00:33', '2013-09-14 19:00:33');

--
-- Triggers `up_acl_users`
--
DROP TRIGGER IF EXISTS `up_acl_users_insert`;
DELIMITER //
CREATE TRIGGER `up_acl_users_insert` BEFORE INSERT ON `up_acl_users`
 FOR EACH ROW BEGIN
	IF NEW.user_date_add = '0000-00-00 00:00:00' THEN
		SET NEW.user_date_add = NOW();
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `up_acl_users_custom`
--

CREATE TABLE IF NOT EXISTS `up_acl_users_custom` (
  `custom_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_key` int(10) unsigned NOT NULL,
  `user_name_first` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `user_name_last` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `user_country` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`custom_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `up_acl_users_custom`
--

INSERT INTO `up_acl_users_custom` (`custom_id`, `user_id_key`, `user_name_first`, `user_name_last`, `user_country`) VALUES
(1, 1, 'Radu', '', 'HU');

-- --------------------------------------------------------

--
-- Table structure for table `up_geo_countries`
--

CREATE TABLE IF NOT EXISTS `up_geo_countries` (
  `country_code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `k_countries` (`country_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `up_geo_countries`
--

INSERT INTO `up_geo_countries` (`country_code`, `country_name`) VALUES
('AF', 'Afghanistan'),
('AX', 'Åland Islands'),
('AL', 'Albania'),
('DZ', 'Algeria'),
('AS', 'American Samoa'),
('AD', 'Andorra'),
('AO', 'Angola'),
('AI', 'Anguilla'),
('AQ', 'Antarctica'),
('AG', 'Antigua and Barbuda'),
('AR', 'Argentina'),
('AM', 'Armenia'),
('AW', 'Aruba'),
('AU', 'Australia'),
('AT', 'Austria'),
('AZ', 'Azerbaijan'),
('BS', 'Bahamas'),
('BH', 'Bahrain'),
('BD', 'Bangladesh'),
('BB', 'Barbados'),
('BY', 'Belarus'),
('BE', 'Belgium'),
('BZ', 'Belize'),
('BJ', 'Benin'),
('BM', 'Bermuda'),
('BT', 'Bhutan'),
('BO', 'Bolivia, Plurinational State of'),
('BQ', 'Bonaire, Sint Eustatius and Saba'),
('BA', 'Bosnia and Herzegovina'),
('BW', 'Botswana'),
('BV', 'Bouvet Island'),
('BR', 'Brazil'),
('IO', 'British Indian Ocean Territory'),
('BN', 'Brunei Darussalam'),
('BG', 'Bulgaria'),
('BF', 'Burkina Faso'),
('BI', 'Burundi'),
('KH', 'Cambodia'),
('CM', 'Cameroon'),
('CA', 'Canada'),
('CV', 'Cape Verde'),
('KY', 'Cayman Islands'),
('CF', 'Central African Republic'),
('TD', 'Chad'),
('CL', 'Chile'),
('CN', 'China'),
('CX', 'Christmas Island'),
('CC', 'Cocos (Keeling) Islands'),
('CO', 'Colombia'),
('KM', 'Comoros'),
('CG', 'Congo'),
('CD', 'Congo, the Democratic Republic of the'),
('CK', 'Cook Islands'),
('CR', 'Costa Rica'),
('CI', 'Côte D''Ivoire'),
('HR', 'Croatia'),
('CU', 'Cuba'),
('CW', 'Curaçao'),
('CY', 'Cyprus'),
('CZ', 'Czech Republic'),
('DK', 'Denmark'),
('DJ', 'Djibouti'),
('DM', 'Dominica'),
('DO', 'Dominican Republic'),
('EC', 'Ecuador'),
('EG', 'Egypt'),
('SV', 'El Salvador'),
('GQ', 'Equatorial Guinea'),
('ER', 'Eritrea'),
('EE', 'Estonia'),
('ET', 'Ethiopia'),
('FK', 'Falkland Islands (Malvinas)'),
('FO', 'Faroe Islands'),
('FJ', 'Fiji'),
('FI', 'Finland'),
('FR', 'France'),
('GF', 'French Guiana'),
('PF', 'French Polynesia'),
('TF', 'French Southern Territories'),
('GA', 'Gabon'),
('GM', 'Gambia'),
('GE', 'Georgia'),
('DE', 'Germany'),
('GH', 'Ghana'),
('GI', 'Gibraltar'),
('GR', 'Greece'),
('GL', 'Greenland'),
('GD', 'Grenada'),
('GP', 'Guadeloupe'),
('GU', 'Guam'),
('GT', 'Guatemala'),
('GG', 'Guernsey'),
('GN', 'Guinea'),
('GW', 'Guinea-Bissau'),
('GY', 'Guyana'),
('HT', 'Haiti'),
('HM', 'Heard Island and McDonald Islands'),
('VA', 'Holy See (Vatican City State)'),
('HN', 'Honduras'),
('HK', 'Hong Kong'),
('HU', 'Hungary'),
('IS', 'Iceland'),
('IN', 'India'),
('ID', 'Indonesia'),
('IR', 'Iran, Islamic Republic of'),
('IQ', 'Iraq'),
('IE', 'Ireland'),
('IM', 'Isle of Man'),
('IL', 'Israel'),
('IT', 'Italy'),
('JM', 'Jamaica'),
('JP', 'Japan'),
('JE', 'Jersey'),
('JO', 'Jordan'),
('KZ', 'Kazakhstan'),
('KE', 'Kenya'),
('KI', 'Kiribati'),
('KP', 'Korea, Democratic People''s Republic of'),
('KR', 'Korea, Republic of'),
('KW', 'Kuwait'),
('KG', 'Kyrgyzstan'),
('LA', 'Lao People''s Democratic Republic'),
('LV', 'Latvia'),
('LB', 'Lebanon'),
('LS', 'Lesotho'),
('LR', 'Liberia'),
('LY', 'Libya'),
('LI', 'Liechtenstein'),
('LT', 'Lithuania'),
('LU', 'Luxembourg'),
('MO', 'Macao'),
('MK', 'Macedonia, the Former Yugoslav Republic of'),
('MG', 'Madagascar'),
('MW', 'Malawi'),
('MY', 'Malaysia'),
('MV', 'Maldives'),
('ML', 'Mali'),
('MT', 'Malta'),
('MH', 'Marshall Islands'),
('MQ', 'Martinique'),
('MR', 'Mauritania'),
('MU', 'Mauritius'),
('YT', 'Mayotte'),
('MX', 'Mexico'),
('FM', 'Micronesia, Federated States of'),
('MD', 'Moldova, Republic of'),
('MC', 'Monaco'),
('MN', 'Mongolia'),
('ME', 'Montenegro'),
('MS', 'Montserrat'),
('MA', 'Morocco'),
('MZ', 'Mozambique'),
('MM', 'Myanmar'),
('NA', 'Namibia'),
('NR', 'Nauru'),
('NP', 'Nepal'),
('NL', 'Netherlands'),
('NC', 'New Caledonia'),
('NZ', 'New Zealand'),
('NI', 'Nicaragua'),
('NE', 'Niger'),
('NG', 'Nigeria'),
('NU', 'Niue'),
('NF', 'Norfolk Island'),
('MP', 'Northern Mariana Islands'),
('NO', 'Norway'),
('OM', 'Oman'),
('PK', 'Pakistan'),
('PW', 'Palau'),
('PS', 'Palestine, State of'),
('PA', 'Panama'),
('PG', 'Papua New Guinea'),
('PY', 'Paraguay'),
('PE', 'Peru'),
('PH', 'Philippines'),
('PN', 'Pitcairn'),
('PL', 'Poland'),
('PT', 'Portugal'),
('PR', 'Puerto Rico'),
('QA', 'Qatar'),
('RE', 'Réunion'),
('RO', 'Romania'),
('RU', 'Russian Federation'),
('RW', 'Rwanda'),
('BL', 'Saint Barthélemy'),
('SH', 'Saint Helena, Ascension and Tristan Da Cunha'),
('KN', 'Saint Kitts and Nevis'),
('LC', 'Saint Lucia'),
('MF', 'Saint Martin (French Part)'),
('PM', 'Saint Pierre and Miquelon'),
('VC', 'Saint Vincent and the Grenadines'),
('WS', 'Samoa'),
('SM', 'San Marino'),
('ST', 'Sao Tome and Principe'),
('SA', 'Saudi Arabia'),
('SN', 'Senegal'),
('RS', 'Serbia'),
('SC', 'Seychelles'),
('SL', 'Sierra Leone'),
('SG', 'Singapore'),
('SX', 'Sint Maarten (Dutch Part)'),
('SK', 'Slovakia'),
('SI', 'Slovenia'),
('SB', 'Solomon Islands'),
('SO', 'Somalia'),
('ZA', 'South Africa'),
('GS', 'South Georgia and the South Sandwich Islands'),
('SS', 'South Sudan'),
('ES', 'Spain'),
('LK', 'Sri Lanka'),
('SD', 'Sudan'),
('SR', 'Suriname'),
('SJ', 'Svalbard and Jan Mayen'),
('SZ', 'Swaziland'),
('SE', 'Sweden'),
('CH', 'Switzerland'),
('SY', 'Syrian Arab Republic'),
('TW', 'Taiwan, Province of China'),
('TJ', 'Tajikistan'),
('TZ', 'Tanzania, United Republic of'),
('TH', 'Thailand'),
('TL', 'Timor-Leste'),
('TG', 'Togo'),
('TK', 'Tokelau'),
('TO', 'Tonga'),
('TT', 'Trinidad and Tobago'),
('TN', 'Tunisia'),
('TR', 'Turkey'),
('TM', 'Turkmenistan'),
('TC', 'Turks and Caicos Islands'),
('TV', 'Tuvalu'),
('UG', 'Uganda'),
('UA', 'Ukraine'),
('AE', 'United Arab Emirates'),
('GB', 'United Kingdom'),
('US', 'United States'),
('UM', 'United States Minor Outlying Islands'),
('UY', 'Uruguay'),
('UZ', 'Uzbekistan'),
('VU', 'Vanuatu'),
('VE', 'Venezuela, Bolivarian Republic of'),
('VN', 'Viet Nam'),
('VG', 'Virgin Islands, British'),
('VI', 'Virgin Islands, U.S.'),
('WF', 'Wallis and Futuna'),
('EH', 'Western Sahara'),
('YE', 'Yemen'),
('ZM', 'Zambia'),
('ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `up_pub_details`
--

CREATE TABLE IF NOT EXISTS `up_pub_details` (
  `details_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pub_id` int(10) unsigned NOT NULL DEFAULT '0',
  `i18n_locale` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en_US',
  `pub_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`details_id`),
  KEY `fk_up_pub_details_1_idx` (`pub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `up_pub_formats_main`
--

CREATE TABLE IF NOT EXISTS `up_pub_formats_main` (
  `pub_format_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pub_format_title` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`pub_format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `up_pub_formats_main`
--

INSERT INTO `up_pub_formats_main` (`pub_format_id`, `pub_format_title`) VALUES
(1, 'A5'),
(2, 'A4'),
(3, 'A3');

-- --------------------------------------------------------

--
-- Table structure for table `up_pub_issues_details`
--

CREATE TABLE IF NOT EXISTS `up_pub_issues_details` (
  `details_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pub_issue_id` int(10) unsigned NOT NULL DEFAULT '0',
  `i18n_locale` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en_US',
  `pub_issue_description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`details_id`),
  KEY `fk_up_pub_issues_details_id_idx` (`pub_issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `up_pub_issues_main`
--

CREATE TABLE IF NOT EXISTS `up_pub_issues_main` (
  `pub_issue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pub_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pub_format_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pub_issue_number` smallint(4) unsigned NOT NULL DEFAULT '0',
  `pub_issue_date` date NOT NULL DEFAULT '0000-00-00',
  `pub_issue_pages` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pub_issue_id`),
  KEY `fk_up_pub_issues_main_1_idx` (`pub_id`),
  KEY `fk_up_pub_issues_main_format_idx` (`pub_format_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `up_pub_main`
--

CREATE TABLE IF NOT EXISTS `up_pub_main` (
  `pub_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pub_title` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `pub_type_id` int(10) unsigned NOT NULL DEFAULT '1',
  `country_code` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pub_year_start` year(4) NOT NULL DEFAULT '0000',
  `pub_year_end` year(4) NOT NULL DEFAULT '0000',
  PRIMARY KEY (`pub_id`),
  KEY `fk_up_pub_main_1_idx` (`pub_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `up_pub_types_details`
--

CREATE TABLE IF NOT EXISTS `up_pub_types_details` (
  `details_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pub_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pub_type_title` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`details_id`),
  KEY `fk_up_pub_types_details_id_idx` (`pub_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `up_pub_types_details`
--

INSERT INTO `up_pub_types_details` (`details_id`, `pub_type_id`, `pub_type_title`) VALUES
(1, 1, 'fanzine'),
(2, 2, 'newsletter'),
(3, 3, 'book');

-- --------------------------------------------------------

--
-- Table structure for table `up_pub_types_main`
--

CREATE TABLE IF NOT EXISTS `up_pub_types_main` (
  `pub_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pub_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `up_pub_types_main`
--

INSERT INTO `up_pub_types_main` (`pub_type_id`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Structure for view `up_acl_object_relation`
--
DROP TABLE IF EXISTS `up_acl_object_relation`;

CREATE OR REPLACE VIEW `up_acl_object_relation` AS select `R`.`relation_id` AS `relation_id`,`U`.`user_id` AS `user_id`,`G`.`group_id` AS `group_id`,`G`.`group_name` AS `group_name`,`G`.`group_level` AS `group_level` from ((`up_acl_users` `U` left join `up_acl_relations` `R` on((`R`.`user_id` = `U`.`user_id`))) left join `up_acl_groups` `G` on((`G`.`group_id` = `R`.`group_id`))) where ((`U`.`user_status` = _utf8'active') and (`G`.`group_status` = _utf8'active')) order by `U`.`user_id`,`G`.`group_level` desc;

-- --------------------------------------------------------

--
-- Structure for view `up_acl_object_user`
--
DROP TABLE IF EXISTS `up_acl_object_user`;

CREATE OR REPLACE VIEW `up_acl_object_user` AS select `U`.`user_id` AS `user_id`,`U`.`user_email` AS `user_email`,`U`.`user_nickname` AS `user_nickname`,`U`.`user_auth` AS `user_auth`,`U`.`user_status` AS `user_status`,`U`.`owner_id` AS `owner_id`,`U`.`user_date_add` AS `user_date_add`,`U`.`user_date_mod` AS `user_date_mod`,`UC`.`custom_id` AS `custom_id`,`UC`.`user_id_key` AS `user_id_key`,`UC`.`user_name_first` AS `user_name_first`,`UC`.`user_name_last` AS `user_name_last`,`UC`.`user_country` AS `user_country` from (`up_acl_users` `U` left join `up_acl_users_custom` `UC` on((`UC`.`user_id_key` = `U`.`user_id`))) where (`U`.`user_status` = _utf8'active') order by `U`.`user_email`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `up_pub_details`
--
ALTER TABLE `up_pub_details`
  ADD CONSTRAINT `fk_up_pub_details_id` FOREIGN KEY (`pub_id`) REFERENCES `up_pub_main` (`pub_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `up_pub_issues_details`
--
ALTER TABLE `up_pub_issues_details`
  ADD CONSTRAINT `fk_up_pub_issues_details_id` FOREIGN KEY (`pub_issue_id`) REFERENCES `up_pub_issues_main` (`pub_issue_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `up_pub_issues_main`
--
ALTER TABLE `up_pub_issues_main`
  ADD CONSTRAINT `fk_up_pub_issues_main_id` FOREIGN KEY (`pub_id`) REFERENCES `up_pub_main` (`pub_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_up_pub_issues_main_format` FOREIGN KEY (`pub_format_id`) REFERENCES `up_pub_formats_main` (`pub_format_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `up_pub_main`
--
ALTER TABLE `up_pub_main`
  ADD CONSTRAINT `fk_up_pub_main_type` FOREIGN KEY (`pub_type_id`) REFERENCES `up_pub_types_main` (`pub_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `up_pub_types_details`
--
ALTER TABLE `up_pub_types_details`
  ADD CONSTRAINT `fk_up_pub_types_details_id` FOREIGN KEY (`pub_type_id`) REFERENCES `up_pub_types_main` (`pub_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
