-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 20, 2019 at 08:26 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhlsy`
--

-- --------------------------------------------------------

--
-- Table structure for table `cpy_block`
--

DROP TABLE IF EXISTS `cpy_block`;
CREATE TABLE IF NOT EXISTS `cpy_block` (
  `blk_id` int(11) NOT NULL AUTO_INCREMENT,
  `blk_name` varchar(200) NOT NULL,
  `blk_status` smallint(6) NOT NULL DEFAULT '1',
  `blk_type` smallint(6) NOT NULL DEFAULT '1',
  `blk_stext` text,
  PRIMARY KEY (`blk_id`),
  UNIQUE KEY `blk_name` (`blk_name`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_block`
--

INSERT INTO `cpy_block` (`blk_id`, `blk_name`, `blk_status`, `blk_type`, `blk_stext`) VALUES
(1, 'Home Welcome', 1, 1, NULL),
(2, 'Home About', 1, 1, NULL),
(4, 'Home Wide Image', 1, 4, NULL),
(5, 'News', 1, 5, NULL),
(7, 'Air Freight 01', 1, 1, 'Air freight Export and Airfreight Import are products that predominately use air mode and offers a choice in delivery speeds to best suit customer requirements.\r\nWorking together with carefully selected carriers, we operate with schedules on all the world’s major routes so you can plan with certainty for greater efficiency.\r\nOur Air freight service is also highly flexible to meet specific customer requirements. Including \r\n1.	Airport to airport\r\n2.	Door to door\r\n3.	Door to airport \r\n4.	Airport to door \r\n\r\nadded value services \r\n•	AIR CHARTER - Specialist Cargo Handling\r\n•	AIR THERMONET - Standard Temperature Controlled Air Freight\r\n•	Cross Trade – moving shipments between two countries regardless of customer location'),
(8, 'Ocean Freight 0', 1, 1, 'Ocean Freight'),
(9, 'Road Freight 01', 1, 1, 'Road Freight'),
(10, 'Multimodal Transport 01', 1, 1, 'Multimodal Transport'),
(11, 'Customs Clearance 01', 1, 1, 'Customs Clearance'),
(12, 'Warehousing 03', 1, 1, 'Warehousing'),
(13, 'Packing & Removal 01', 1, 1, 'Packing & Removal'),
(14, 'Projects 01', 1, 1, 'Projects'),
(15, 'Fairs & Events 01', 1, 1, 'Fairs & Events'),
(16, 'Aid & Relief Services 01', 1, 1, 'Aid & Relief Services'),
(17, 'Corporate Social Responsibility', 1, 1, 'Corporate Social Responsibility'),
(18, 'Nazha Logistics 03', 1, 1, 'Nazha Logistics'),
(19, 'Quality Assurance 01', 1, 1, 'Quality Assurance'),
(20, 'Insurance 01', 1, 1, 'Insurance'),
(21, 'Contact Us', 1, 1, 'Contact Us'),
(22, 'Air Freight 03', 1, 1, 'added value services\r\n\r\n    AIR CHARTER - Specialist Cargo Handling\r\n    AIR THERMONET - Standard Temperature Controlled Air Freight\r\n\r\nCross Trade – moving shipments between two countries regardless of customer location'),
(23, 'Air Freight 02', 1, 3, NULL),
(24, 'Air Freight 04', 1, 2, NULL),
(25, 'SYDI 01', 1, 1, NULL),
(26, 'SYDI 06', 1, 1, NULL),
(27, 'SYDI 07', 1, 3, NULL),
(28, 'SYDI 04', 1, 1, NULL),
(29, 'SYDI 05', 1, 2, NULL),
(30, 'Ocean Freight 1', 1, 1, 'Ocean Freight'),
(31, 'Ocean Freight 2', 1, 2, NULL),
(32, 'Ocean Freight 3', 1, 1, NULL),
(33, 'Road Freight 03', 1, 1, NULL),
(35, 'Warehousing 02', 1, 3, 'Warehousing'),
(36, 'Warehousing 01', 1, 1, NULL),
(37, 'Warehousing 04', 1, 2, NULL),
(38, 'Packing & Removal 03', 1, 1, 'Packing & Removal'),
(39, 'Packing & Removal 02', 1, 2, 'Packing & Removal'),
(40, 'Projects 02', 1, 2, 'Projects'),
(41, 'Projects 03', 1, 1, 'Projects'),
(42, 'Road Freight 02', 1, 2, NULL),
(43, 'Culture Support 01', 1, 1, NULL),
(44, 'Culture Support 02', 1, 2, NULL),
(45, 'Environment protection 01', 1, 1, NULL),
(46, 'Environment protection 02', 1, 2, NULL),
(47, 'Fairs & Events 02', 1, 3, NULL),
(48, 'Fairs & Events 03', 1, 1, NULL),
(49, 'Fairs & Events 04', 1, 2, NULL),
(50, 'Insurance 02', 1, 3, NULL),
(51, 'Multimodal Transport 02', 1, 3, NULL),
(52, 'Multimodal Transport 03', 1, 1, NULL),
(53, 'Nazha Logistics 02', 1, 3, NULL),
(54, 'Nazha Logistics 01', 1, 1, NULL),
(55, 'Nazha Logistics 04', 1, 2, NULL),
(56, 'Nazha Logistics 05', 1, 1, NULL),
(57, 'Quality Assurance 02', 1, 2, 'Quality Assurance'),
(58, 'Customs Clearance 02', 1, 3, NULL),
(59, 'Customs Clearance 03', 1, 1, NULL),
(60, 'Customs Clearance 04', 1, 3, NULL),
(61, 'Aid & Relief Services 03', 1, 1, NULL),
(62, 'Aid & Relief Services 02', 1, 3, NULL),
(63, 'Aid & Relief Services 04', 1, 2, NULL),
(64, 'SYDI 02', 1, 1, NULL),
(65, 'SYDI 03', 1, 3, NULL),
(66, 'Environment protection 03', 1, 1, NULL),
(67, 'Fairs & Events 05', 1, 1, NULL),
(68, 'Contact BTNs', 1, 1, NULL),
(69, 'Complete Logistics Services Brochure', 1, 1, NULL),
(70, 'Code & Vision', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_block_detail`
--

DROP TABLE IF EXISTS `cpy_block_detail`;
CREATE TABLE IF NOT EXISTS `cpy_block_detail` (
  `dblk_id` int(11) NOT NULL AUTO_INCREMENT,
  `blk_id` int(11) NOT NULL,
  `dblk_order` smallint(6) NOT NULL DEFAULT '1',
  `dblk_status` smallint(6) NOT NULL DEFAULT '1',
  `dblk_type` smallint(6) NOT NULL DEFAULT '1',
  `dblk_name` varchar(200) NOT NULL,
  `dblk_image` varchar(200) DEFAULT NULL,
  `dblk_text` text,
  `dblk_stext` text,
  PRIMARY KEY (`dblk_id`),
  UNIQUE KEY `dblk_name` (`blk_id`,`dblk_name`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_block_detail`
--

INSERT INTO `cpy_block_detail` (`dblk_id`, `blk_id`, `dblk_order`, `dblk_status`, `dblk_type`, `dblk_name`, `dblk_image`, `dblk_text`, `dblk_stext`) VALUES
(1, 1, 2, 1, 10, 'Home Welcome 02', NULL, '<p>\r\n  <span style=\"font-size:17px;\">\r\n    As Exclusive Agent of DHL Global Forwarding / DHL Freight in Syria, Nazha Logistics is acting as a logistics market leader locally. Nazha Logistics signifies the &ldquo;One Stop Shopping&rdquo; concept with the full range of logistics products starting from the basic conventional freight services including Airfreight, Ocean Freight and Road Fright to the most sophisticated services including &ldquo;Customer Program Management&rdquo; systems which we provide to our international customers according to the Quality Management System ISO 9001:2015 acquired through SGS.\r\n  </span>\r\n</p>\r\n', NULL),
(2, 2, 1, 1, 12, 'OUR MISSION 11-2018', NULL, '<h1 style=\"text-align:center\"><span style=\"color:#c0392b\">OUR MISSION</span></h1>\r\n\r\n<div>\r\n<p style=\"text-align:center\"><span style=\"font-size:16px\"><strong>Excellence. Simply Delivered.</strong> This mean that we provide the best, smartest, and integrated logistic services<br />\r\nwith full transparency, flexibility and reliability to create sustainable growth to our business and society.</span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n</div>', NULL),
(3, 2, 2, 1, 12, 'OUR VALUES 11-2018', NULL, '<h1><span style=\"color:#c0392b\">OUR VALUES</span></h1>', NULL),
(4, 2, 3, 1, 3, 'Quality 11-2018', NULL, '<h3 style=\"text-align:center\">Quality</h3>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:16px\">What we do, we do very well</span></p>', NULL),
(5, 2, 4, 1, 3, 'Excellence 11-2018', NULL, '<h3 style=\"text-align:center\">Excellence</h3>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:16px\">We exceed our customers&rsquo; expectations by delivering superior added values</span></p>', NULL),
(6, 2, 5, 1, 3, 'Confidence 11-2018', NULL, '<h3 style=\"text-align:center\">Confidence</h3>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:16px\">What we do, we do always right</span></p>', NULL),
(7, 2, 6, 1, 3, 'Responsibility 11-2018', NULL, '<h3 style=\"text-align:center\">Responsibility</h3>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:16px\">Laws &amp; Ethical Responsibility Social Responsibility Environmental Responsibility</span></p>', NULL),
(8, 4, 1, 1, 12, 'home-wide-11-2018', '02-Main page wide photo.jpg', NULL, NULL),
(16, 6, 1, 1, 12, '1', '02b814765c80add12980b28c8d67bd9e(1).jpg', NULL, NULL),
(17, 6, 2, 1, 12, '2', '2019-bugatti-veyron-speed-test(1).jpg', NULL, NULL),
(18, 6, 3, 1, 12, '3', 'BugattiDivo_02(1).jpg', NULL, NULL),
(19, 7, 1, 1, 12, 'Air Freight', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; color:#d40511; font-size:20px\">\r\n  AIR FREIGHT\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  <strong>\r\n    Airfreight Export\r\n  </strong>\r\n  and <strong>Airfreight Import</strong>\r\n  are products that predominately use air mode\r\n  <br />\r\n  and offers a choice in delivery speeds to best suit customer requirements.\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  Working together with carefully selected carriers, we operate with schedules on all\r\n  <br />\r\n  the world&rsquo;s major routes so you can plan with certainty for greater efficiency.\r\n  <br />\r\n  <br />\r\n  Our Airfreight service is also highly flexible to meet specific customer requirements. Including\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  <strong>\r\n    Airport to airport\r\n    <br />\r\n    Door to door\r\n    <br />\r\n    Door to airport\r\n    <br />\r\n    Airport to door\r\n  </strong>\r\n</p>\r\n', 'Airfreight Export and Airfreight Import are products that predominately use air mode and offers a choice in delivery speeds to best suit customer requirements.\r\nWorking together with carefully selected carriers, we operate with schedules on all the world’s major routes so you can plan with certainty for greater efficiency.\r\nOur Airfreight service is also highly flexible to meet specific customer requirements. Including'),
(20, 8, 1, 1, 12, 'Ocean Freight', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; color:#d40511; font-size:20px\">\r\n  OCEAN FREIGHT\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  <strong>\r\n    Ocean Freight Export and Ocean Freight Import\r\n  </strong>\r\n  ; with our broad range of Ocean Freight products covering different equipment types\r\n  <br />\r\n  and consolidation services, we ensure your cargo reaches the right place, at the right time in a cost-efficient way. We work with a spread of ocean\r\n  <br />\r\n  carriers covering major carrier alliances with planned space protection from every major container port in the world to deliver reliability.\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  Naturally, our expertise also includes focused and professional handling of all conventional cargo transportation.\r\n  <br />\r\n  DHL Global Forwarding currently handle in excess of 2.8 million TEU&rsquo;s and more than 2 million cubic meters of LCL freight annually, across all continents, with the following services\r\n</p>\r\n<p style=\"text-align:center; font-size:14px\">\r\n  <strong>\r\n    OCEAN DIRECT FCL - Full container load\r\n  </strong>\r\n  <br />\r\n  <strong>\r\n    OCEAN CONNECT LCL - Less than container load\r\n  </strong>\r\n  <br />\r\n  <strong>\r\n    OCEAN CONTAINER MANAGEMENT - FCL inland service\r\n  </strong>\r\n  <br />\r\n  <strong>\r\n    OCEAN SPECIAL - Conventional load services\r\n  </strong>\r\n</p>\r\n', 'Ocean Freight Export and Ocean Freight Import; with our broad range of Ocean Freight products covering different equipment types and consolidation services, we ensure your cargo reaches the right place, at the right time in a cost-efficient way. We work with a spread of ocean carriers covering major carrier alliances with planned space protection from every major container port in the world to deliver reliability.\r\n\r\nNaturally, our expertise also includes focused and professional handling of all conventional cargo transportation.\r\n\r\nDHL Global Forwarding currently handle in excess of 2.8 million TEU’s and more than 2 million cubic meters of LCL freight annually, across all continents, with the following services \r\n\r\n•	OCEAN DIRECT FCL - Full container load\r\n•	OCEAN CONNECT LCL - Less than container load\r\n•	OCEAN CONTAINER MANAGEMENT - FCL inland services\r\n•	OCEAN SPECIAL - Conventional load services\r\n\r\nadded value services \r\n•	OCEAN ASSEMBLY - Single & multi country consolidation\r\n•	OCEAN CHARTER - Cargo vessel charter\r\n•	FLEXITANKS - Transportation of bulk-liquids\r\n•	OCEAN THERMONET - Temperature Controlled Ocean Freight\r\n•	Cross Trade – moving shipments between two countries regardless of customer location'),
(21, 9, 1, 1, 12, 'Road Freight', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  ROAD FREIGHT\r\n</p>\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  We provide Road Freight Import, Export and within the country regular transportation (with a range of additional services), giving you truly extensive coverage at domestic and international level. With our dispatch flexibility and long term co-operation with trucking specialists, DHL Freight handles regular part loads, as well as full loads, safely and punctually in all directions.\r\n  <br />\r\n  <br />\r\n  Our wide range of transportation equipment &ndash; road-trains, swap-bodies and semi-trailers &ndash; guarantees flexible loading conditions. With DHL Freight you also benefit from seamless communication via the EDI interface, which transmits your order entries and offers reporting and statistics.\r\n  <br />\r\n  Core Services:\r\n  <br />\r\n  <strong>\r\n    FTL Full Truck Load service\r\n  </strong>\r\n  <br />\r\n  <strong>\r\n    PTL Part Truck Load service\r\n  </strong>\r\n  <br />\r\n  <strong>\r\n    LTL Less than Truck Load service\r\n  </strong>\r\n  <br />\r\n  <strong>\r\n    Transshipping services\r\n  </strong>\r\n</p>\r\n', 'We provide Road Freight Import, Export and within the country regular transportation (with a range of additional services), giving you truly extensive coverage at domestic and international level. With our dispatch flexibility and long term co-operation with trucking specialists, DHL Freight handles regular part loads, as well as full loads, safely and punctually in all directions.\r\n\r\nOur wide range of transportation equipment – road-trains, swap-bodies and semi-trailers – guarantees flexible loading conditions. With DHL Freight you also benefit from seamless communication via the EDI interface, which transmits your order entries and offers reporting and statistics. \r\n\r\nCore Services:\r\n•	Full Truck Loads \r\n•	Part Truck Loads \r\n\r\nValue Added Services:\r\n•	Direct pick-up and delivery service using one vehicle, dedicated to your shipment\r\n•	DHL Freight managed and quality-measured transport fleet\r\n•	Service embedded in DHL Freight’s international network, with 208 terminals across Europe\r\n•	Defined lead times based on origin/destination\r\n•	Support provided via direct contact with local DHL Freight experts\r\n•	Proof of delivery (POD)\r\n•	Transportation of dangerous goods\r\n•	Additional insurance\r\n•	Individual performance reports'),
(22, 10, 1, 1, 12, 'Multimodal Transport 01', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  MULTIMODAL TRANSPORT\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  Road-Air and Ocean-Air Combing the speed of air freight with the economy of ocean freight / road freight\r\n  <br />\r\n  we offer faster transit times at a considerably lower cost and lower carbon footprint than pure air freight.\r\n  <br />\r\n  Ensuring cargo remains in DHL&rsquo;s control at all times, this product offers a multi-modal service.\r\n</p>\r\n', 'Road-Air and Ocean-Air Combing the speed of air freight with the economy of ocean freight / road freight we offer faster transit times at a considerably lower cost and lower carbon footprint than pure air freight.\r\nEnsuring cargo remains in DHL’s control at all times, this product offers a multi-modal service. \r\n•	Import/export customs brokerage – we take control of all customs formalities and delivery documentation\r\n•	An alternative modal option during peak season congestion\r\n•	End-to-end real time visibility\r\n•	Green transport'),
(23, 11, 1, 1, 12, 'Customs Clearance 0101', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  CUSTOMS CLEARANCE\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  Nazha Logistics - DHL Global Forwarding / DHL Freight Syria has profound understanding of customs clearance which we offer at\r\n  <br />\r\n\r\n  <strong>\r\n    Airports\r\n  </strong>\r\n  <br />\r\n\r\n  <strong>\r\n    Ports\r\n  </strong>\r\n  <br />\r\n\r\n  <strong>\r\n    Cross borders\r\n  </strong>\r\n  <br />\r\n\r\n  <strong>\r\n    Customs secretariats\r\n  </strong>\r\n  <br />\r\n\r\n  <strong>\r\n    Free Zones\r\n  </strong>\r\n</p>\r\n', 'We have long experience in customs clearance we handle clearance at \r\nAirports\r\nPorts\r\nCross borders\r\nCustoms secretariats \r\nFree Zones. \r\nClearing Services offered are :\r\nImport Customs Clearance \r\nExport Clearance \r\nTransit Customs Clearance \r\nCustoms Approval follow up \r\nImport License follow up \r\nAnalysis follow up \r\nRange of additional clearance services based on shipment purpose'),
(24, 12, 1, 1, 12, 'Warehousing 0101', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px;\">\r\n  DHL Global Forwarding Damascus Logistics Facility\r\n  <br />\r\n  Located 7 KM from Damascus Airport and 23 KM from Damascus city center.\r\n  <br />\r\n  Total Land area: 110,000 sqm, out of which 40,000 sqm are encircled by a 3.5 m high fence; this part contains the present warehouses and offices.\r\n  <br />\r\n  Total Warehouses Space:&nbsp; 5,000 sqm of fully equipped warehouses that will be extended to 14,000 sqm in phase two.\r\n  <br />\r\n  <br />\r\n  <strong>\r\n    Facility specifications and equipment\r\n  </strong>\r\n</p>\r\n', 'We offer warehouse management at any location in the country based on customer requirements.\r\nDHL Global Forwarding Damascus Logistics Facility:\r\nLocated 7 KM from Damascus Airport and 23 KM from Damascus city center.\r\nTotal Land area: 110,000 sqm, out of which 40,000 sqm are encircled by a 3.5 m high fence; this part contains the present warehouses and offices. \r\nTotal Warehouses Space:  5,000 sqm of fully equipped warehouses that will be extended to 14,000 sqm in phase two.\r\nFacility specifications and equipment:\r\n•	Fire alerts, protection and escape routes\r\n•	Security guards \r\n•	Material Handling Equipment\r\n•	Racking & Shelving\r\n•	HSE needs\r\n•	Warehouse Management System (WMS)\r\n•	Insurance coverage\r\n\r\nOur Warehousing Solutions improve inventory efficiency and accelerate your response to changing customer demand. Our experts design, implement, and operate flexible warehousing and distribution solutions tailored to your business needs. They analyze every point in your supply chain to determine the optimal solution.\r\n•	Dedicated Warehouses \r\n•	Multi Customer Warehousing \r\n•	Ambient and temperature-controlled facilities\r\n•	Storage, pick, pack and dispatch\r\n•	Delivery and returns management\r\n\r\nInventory Optimization\r\nThrough effective inventory management, inefficiencies can be driven out of the supply chain, overall costs reduced and high service levels achieved. We optimize inventory at a line-item level at every stage of the supply chain.\r\n\r\nMulti-Customer Warehousing\r\nOur shared-user facilities are designed to meet the needs of any customer for consumer products, industrial equipment, chemicals and technology.\r\nThrough sharing of DHL\'s resources, such as space, labor, equipment and transportation, customers benefit from synergies that considerably reduce supply chain costs.\r\nThis environment returns significant value to a small business requiring distribution operations without long term lease or capital commitments, or a large enterprise handling a new acquisition, product launches or seasonal overflow'),
(25, 13, 1, 1, 12, 'Packing & Removal', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  PACKING &amp; REMOVAL\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  Our mission is turning your Packing &amp; Removal experience into an exciting, enjoyable and Stress Free task.\r\n  <br />\r\n  One stop shopping point as follows\r\n  <br />\r\n  <strong>\r\n    Packing\r\n    <br />\r\n    Storage\r\n    <br />\r\n    Customs Clearance\r\n    <br />\r\n    Shipping Services\r\n    <br />\r\n    Destination Services\r\n    <br />\r\n    Unpacking and removal of debris.\r\n  </strong>\r\n</p>\r\n', 'Our mission is turning your Packing & Removal experience into an exciting, enjoyable and Stress Free task.\r\nOne stop shopping point as follows:\r\n•	Packing\r\n•	Storage \r\n•	Customs Clearance\r\n•	Shipping Services: Airfreight, Ocean Freight and Road Freight\r\n•	Destination Services \r\n•	Unpacking and removal of debris.\r\n\r\nPacking Steps:\r\nOur packing process has a defined outline, solid to ensure our customers trust and peace of mind, flexible enough to adjust according to needed requirements. Don’t wait until you have a moving day. Contact us at least one month before you intend to move, we will then work with you to help you through the process.\r\n 1.  Assessment: Our Experts will undertake an assessment survey to estimate our customers’ requirements and needs.\r\n  2. Offer: will be submitted promptly after thorough study.\r\n 3. Plan: a plan will be developed tailor made to fit each customer’s requirements and commodities.'),
(26, 14, 1, 1, 12, 'Projects', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  PROJECTS\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  DHL understands the unique logistics challenges related to projects shipments.\r\n  <br />\r\n  We provide a range of services that help align logistics operations with your business strategies.\r\n  <br />\r\n  Our processes, technology and people drive cost and capital out of your operations, whilst ensuring consistent and predictable service.\r\n  <br />\r\n  We let you focus on what you do best: design, engineer, install, construct and manufacture products the world depends on.\r\n  <br />\r\n  With DHL as a partner, your goods will be delivered as safely and efficiently as possible.\r\n</p>\r\n', 'DHL understands the unique logistics challenges related to projects shipments. We provide a range of services that help align logistics operations with your business strategies. Our processes, technology and people drive cost and capital out of your operations, whilst ensuring consistent and predictable service.\r\n\r\nWe let you focus on what you do best: design, engineer, install, construct and manufacture products the world depends on. With DHL as a partner, your goods will be delivered as safely and efficiently as possible.\r\n\r\nCore Services\r\n•	Warehousing and Order Fulfillment\r\n•	Sub-assembly and Kitting\r\n•	Transportation Management\r\n•	Lead Logistics Provider (LLP)\r\n•	Industrial Projects Transportation\r\n\r\nWe address\r\n•	Transport and Logistics Design\r\n•	Logistics Management\r\n•	Project Cargo Logistics \r\n•	Heavy Loads \r\n•	Outsized Loads'),
(27, 15, 1, 1, 12, 'Fairs & Events', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  FAIRS &amp; EVENTS\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  <strong>\r\n    We offer complete logistics services for both Fairs &amp; Events Organizers and Clients.\r\n  </strong>\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  <strong>\r\n    Infrastructure\r\n  </strong>\r\n  <br />\r\n  We accompany you! Wherever your customers and suppliers need us - we are already there\r\n  <br />\r\n  Our <strong>specialists</strong> are located around the globe and support you at <strong>every location worldwide</strong>\r\n  <br />\r\n  Organizers and venues worldwide <strong>trust</strong> in us and appoint DHL as <strong>official forwarder</strong>\r\n  <br />\r\n  <strong>Dedicated network </strong>of experienced operations personnel\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  <strong>\r\n    Reliability and Quality of Service\r\n  </strong>\r\n  <br />\r\n  We help you preserve and deliver the highest quality to your customers\r\n  <br />\r\n  One partner with the ability to provide the <strong>most extensive product offering</strong>\r\n  <br />\r\n  Experience in handling and shipping of <strong>exceptional shipments</strong>\r\n  <br />\r\n  <strong>Full service </strong>approach before, during and after the show or event\r\n</p>\r\n', 'We offer complete logistics services for both Fairs & Events Organizers and Clients.\r\nInfrastructure\r\nWe accompany you! Wherever your customers and suppliers need us - we are already there \r\n•	Our specialists are located around the globe and support you at every location worldwide\r\n•	Organizers and venues worldwide trust in us and appoint DHL as official forwarder\r\n•	Dedicated network of experienced operations personnel\r\n\r\nReliability and Quality of Service\r\nWe help you preserve and deliver the highest quality to your customers\r\n•	One partner with the ability to provide the most extensive product offering \r\n•	Experience in handling and shipping of exceptional shipments\r\n•	Full service approach before, during and after the show or event\r\n\r\nInnovation and Tailor-made Solutions\r\nWe anticipate your needs while setting standards for the industry\r\n1.	Customized relationship management programs that mirror clients’ organizational needs\r\n2.	Providing specialized services, e.g. Project management, document support, customs clearance, on-site handling, delivery, storage concepts, packing\r\n\r\nIndustry expertise and Know-How\r\nOur experts are at your service to provide you with state-of-the-art service\r\n•	Global expertise teamed with local knowledge – we deliver the right integrated solution\r\n•	Unique understanding of customer requirements \r\n•	One personal and  dedicated point of contact for all your needs'),
(28, 16, 1, 1, 12, 'Aid & Relief Services 0101', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; color:#d40511; font-size:20px\">\r\n  AID &amp; RELIEF SERVICES\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  Due to the need of logistics services for the humanitarian aid across the country, DHL Global Forwarding -Syria\r\n  <br />\r\n  set up a department under the name of Aid &amp; Relief Services responsible for the Humanitarian Aid Logistics\r\n  <br />\r\n  within Syria through the following services\r\n</p>\r\n', 'Due to the need of logistics services for the humanitarian aid across the country, DHL Global Forwarding -Syria set up a department under the name of Aid & Relief Services responsible for the Humanitarian Aid Logistics within Syria through the following services:\r\n1.	Transportation  \r\n•	Primary Transportation, from Syrian Ports (Lattakia & Tartous) or from Lebanon and Jordan borders to our warehouses.\r\n•	Secondary Transportation, from local warehouses or directly from Ports to all Cities in Syria, according to a pre-defined monthly cycle.\r\n2.	Charters\r\nCargo Charters to difficult-to-access and faraway areas within Syria\r\n\r\n3.	Customs Clearance\r\nDone at Ports and Borders as a supporting service to the transportation operations and for urgent Aid & Relief shipments, we arrange direct withdrawal (when required) to speed up the delivery process and settle the declarations later on.\r\n\r\n\r\n4.	Warehousing\r\n•	Dedicated warehouses with full warehousing management services for UN Agencies and NGOs which have huge operations in any location in Syria \r\n•	Multi-Customer warehousing services for UN Agencies and NGOs which need temporary services for small operations at our DHL Facility in Damascus \r\n5.	Packaging\r\nAid & Relief Packaging Department was established to provide re-packing and re-bagging services of a monthly pre-defined content of Aid & Relief Family Food and Non-Food Rations. These services are done through:\r\n•	Well trained staff with high productivity performance\r\n•	Ability to work 24 hours on shifts basis\r\n•	Ability to supply all kinds of packing equipment and packing materials\r\n•	Safety & Hygiene standards are strictly implemented\r\n\r\n6.	Supply\r\nDHL Global Forwarding can supply raw materials, re-pack them into kits and deliver them to the service requester as per the standards required by any UN Agency or Humanitarian Organization, giving priority to the local market in order to support the local Syrian families as per DHL Global Forwarding Aid & Relief policies which are in line with UN agencies and other humanitarian organizations. However, when the raw materials must be imported, DHL Global Forwarding is the most eligible company in Syria to arrange the import of such material through its worldwide network.  Kits types may include (but not limited to) the following types.\r\n•	Hygiene Kits\r\n•	Clothing Kits\r\n•	Food Kits\r\n•	Baby Kits\r\n•	Plastic Sheets\r\n•	School Kits\r\n•	Mosquito Nets'),
(29, 17, 1, 1, 12, 'Corporate Social Responsibility', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:16px\">\r\n  Corporate Social Responsibility\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  We follow Deutsche Post DHL Corporate Responsibility and mostly we focus on\r\n</p>\r\n<ol>\r\n  <li style=\"text-align:left\">\r\n    <strong>\r\n      Environment protection\r\n    </strong>\r\n  </li>\r\n</ol>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  Committed to sustainable development, we create innovative, effective, environmentally friendly logistics services that fulfill customer\'s needs, while minimizing undesirable impacts. (Policy Enclosed)\r\n</p>\r\n<ol start=\"2\">\r\n  <li style=\"text-align:left\">\r\n    <strong>\r\n      Culture Support\r\n    </strong>\r\n  </li>\r\n</ol>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  DHL Global Forwarding Syria has launched its project of sponsoring, encouraging and spreading Culture in all its aspects in Syria.\r\n</p>\r\n<ul style=\"list-style-type:square\">\r\n  <li style=\"text-align:left\">\r\n    Sponsorship of photo Exhibition &ldquo;Dervish Rituals&rdquo; by a Syrian artist. The exhibition was held in the historical hall of Khan As&rsquo;ad Pasha under the high auspices of the Syrian Minister of Culture in&nbsp;2007.\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Sponsorship of a Jazz concert performed by a specialized Russian Band in Damascus in 2007\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Sponsorship of the shielding cover when Salahuddin Ayyubi statue was under restoration in 2007.\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Partnership in the International Violin Competition with Solhi Al Wadi Institute of Music in 2008\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Sponsoring Yes Academy &quot;Youth Excellence on Stage&quot; in 2010\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Sponsoring Jazz Lives in 2010\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Sponsoring the Visual arts festival in Damascus in 2010\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Sponsoring &ldquo; The Mirror&rdquo; play performed by the university team  of the &ldquo;Lady of Damascus&rdquo; Church in 2015.\r\n  </li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n</p>\r\n\r\n<ol start=\"3\">\r\n  <li style=\"text-align:left\">\r\n    <strong>\r\n      Syrian Youth Development Initiative\r\n    </strong>\r\n  </li>\r\n</ol>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  Due to the impacts caused by the Syrian crisis, there was a clear need to switch CSR into this phase priorities, Syrian youth need tools to enable them enhance their knowledge and skills, which will prepare them for better future and empower them to be part of the reconstruction of Syria; thus we launched the &ldquo;\r\n  <strong>\r\n    Syrian Youth Development Initiative&rdquo;\r\n  </strong>\r\n</p>\r\n\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  &nbsp;\r\n</p>\r\n\r\n<ul style=\"list-style-type:square\">\r\n  <li style=\"text-align:left\">\r\n    AKDN - Aga Khan Development Network\r\n  </li>\r\n</ul>\r\n\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  In 2017 we signed MoU with AKDN to donate books to a prototype library established recently by AKDN in an elementary school in Damascus old city that has 425 students. The 408 donated books varied among encyclopedias, cultural books, educational books, and purposeful stories.\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  &nbsp;\r\n</p>\r\n\r\n<ul style=\"list-style-type:square\">\r\n  <li style=\"text-align:left\">\r\n    SOS - SOS Children&rsquo;s Villages\r\n  </li>\r\n</ul>\r\n\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  As part of Deutsche Post DHL Group-wide program &ldquo;GoTeach&rdquo;, we work together with international partners to improve educational opportunity and employability for young people, especially those from disadvantaged socio-economic backgrounds.\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  Deutsche Post DHL Group and&nbsp;\r\n  <a href=\"http://www.dpdhl.com/en/sitemap/disclaimer.html?ref=URJ+gUERGT0ryrNE5eQGEzDaNPeknX6PBvkHO7SNl3ATnJd6gWkb9w==\">\r\n    SOS Children\'s Villages\r\n  </a>\r\n  &nbsp;International have been partners in the GoTeach program since 2011.&nbsp;\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  The partnership covers a wide variety of activities; these can be clustered into the following categories:\r\n</p>\r\n\r\n<ul>\r\n  <li style=\"text-align:left\">\r\n    Job orientation &ndash; to educate teens about the job market\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Soft and basic skills training &ndash; to enable access to the job market\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Exposure to professional working environment &ndash; to gain initial work experience\r\n  </li>\r\n  <li style=\"text-align:left\">\r\n    Training and support for establishing own businesses\r\n  </li>\r\n</ul>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  The program started in four countries in 2011 and expanded rapidly to 26 countries worldwide by 2015 and in 2017 it was launched in Syria.\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left; font-size:14px\">\r\n  In Syria DGF support SOS by training a group of SOS youths on the above categories by specialized DHL trainers. The project started in 2017 and is still ongoing\r\n</p>\r\n', 'We follow Deutsche Post DHL Corporate Responsibility and mostly we focus on \r\n1.	Environment protection \r\nCommitted to sustainable development, we create innovative, effective, environmentally friendly logistics services that fulfill customer\'s needs, while minimizing undesirable impacts. (Policy Enclosed)\r\n2.	Culture Support   \r\nDHL Global Forwarding Syria has launched its project of sponsoring, encouraging and spreading Culture in all its aspects in Syria. \r\n	Sponsorship of photo Exhibition “Dervish Rituals” by a Syrian artist. The exhibition was held in the historical hall of Khan As’ad Pasha under the high auspices of the Syrian Minister of Culture in 2007. \r\n	Sponsorship of a Jazz concert performed by a specialized Russian Band in Damascus in 2007\r\n	Sponsorship of the shielding cover when Salahuddin Ayyubi statue was under restoration in 2007.\r\n	Partnership in the International Violin Competition with Solhi Al Wadi Institute of Music in 2008\r\n	Sponsoring Yes Academy \"Youth Excellence on Stage\" in 2010\r\n	Sponsoring Jazz Lives in 2010 \r\n	Sponsoring the Visual arts festival in Damascus in 2010\r\n	Sponsoring “The Mirror” play performed by the university team of the “Lady of Damascus” Church in 2015.\r\n\r\n3.	Syrian Youth Development Initiative \r\nDue to the impacts caused by the Syrian crisis, there was a clear need to switch CSR into this phase priorities, Syrian youth need tools to enable them enhance their knowledge and skills, which will prepare them for better future and empower them to be part of the reconstruction of Syria; thus we launched the “Syrian Youth Development Initiative” \r\n\r\n	AKDN - Aga Khan Development Network\r\nIn 2017 we signed MoU with AKDN to donate books to a prototype library established recently by AKDN in an elementary school in Damascus old city that has 425 students. The 408 donated books varied among encyclopedias, cultural books, educational books, and purposeful stories.\r\n\r\n\r\n	SOS - SOS Children’s Villages\r\nAs part of Deutsche Post DHL Group-wide program “GoTeach”, we work together with international partners to improve educational opportunity and employability for young people, especially those from disadvantaged socio-economic backgrounds.\r\nDeutsche Post DHL Group and SOS Children\'s Villages International have been partners in the GoTeach program since 2011. \r\nThe partnership covers a wide variety of activities; these can be clustered into the following categories:\r\n•	Job orientation – to educate teens about the job market\r\n•	Soft and basic skills training – to enable access to the job market\r\n•	Exposure to professional working environment – to gain initial work experience\r\n•	Training and support for establishing own businesses\r\nThe program started in four countries in 2011 and expanded rapidly to 26 countries worldwide by 2015 and in 2017 it was launched in Syria.\r\nIn Syria DGF support SOS by training a group of SOS youths on the above categories by specialized DHL trainers. The project started in 2017 and is still ongoing'),
(30, 18, 2, 1, 12, 'Nazha Logistics 0102', NULL, '<p style=\"text-align:center\"><span style=\"font-size:14px\">Nazha Logistics is the Exclusive Agent of DHL Global Forwarding / DHL Freight in Syria and the logistics market leader locally.<br />\r\nDHL is present in over 220 countries and territories across the globe, making it the most international company in the world.<br />\r\nWith a workforce exceeding 350,000 employees, DHL provides solutions for an almost infinite number of logistics needs.</span></p>', 'Nazha Logistics is the Exclusive Agent of DHL Global Forwarding / DHL Freight in Syria and the logistics market leader locally.\r\nDHL is present in over 220 countries and territories across the globe, making it the most international company in the world.\r\nWith a workforce exceeding 350,000 employees, DHL provides solutions for an almost infinite number of logistics needs.\r\n\r\nWe signify the “One Stop Shopping” concept with the full range of logistic products we provide starting from\r\nthe basic conventional freight services fulfilling the small customers demand up to the most complicated\r\n“Customer Program Management” systems which we provide to our Multi National Customers.'),
(31, 19, 1, 1, 12, 'Quality Assurance', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  QUALITY&nbsp;ASSURANCE\r\n</p>\r\n', 'Nazha Logistics the Exclusive Agent of DHL Global Forwarding in Syria believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations. \r\nThe Quality Policy of Nazha Logistics indicates the basic principles that control our business and the commitment that the logistic services we provide to our customers shall be the best possible available in the market.\r\n(full quality policy is enclosed)'),
(32, 20, 1, 1, 12, 'Insurance', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  INSURANCE\r\n</p>\r\n\r\n<p style=\"text-align:center; font-size:14px\">\r\n  Insurance services that offer our customers financial protection against all risks of physical loss or damage\r\n  <br />\r\n  from any external cause such as fire, storms, thunderbolts and other standard insured risks for the\r\n  <br />\r\n  total amount of the stored materials (our policy covers the accurate exact amount on daily basis). Thus,\r\n  <br />\r\n  our customers can significantly reduce the financial impact associated with these unfortunate events.\r\n</p>\r\n', 'Insurance services that offer our customers financial protection against all risks of physical loss or damage from any external cause such as fire, storms, thunderbolts and other standard insured risks for the total amount of the stored materials (our policy covers the accurate exact amount on daily basis). Thus, our customers can significantly reduce the financial impact associated with these unfortunate events.'),
(33, 21, 1, 1, 6, 'Contact Us', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px\">\r\n  Contact Us\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:justify; font-size:14px\">\r\n  Nazha Logistics LLC - Exclusive Agent of DHL Global Forwarding in Syria.\r\n  <br />\r\n  Sabbagh Building, Victoria Bridge.\r\n  <br />\r\n  Damascus &ndash; Syria.\r\n  <br />\r\n  P.O.Box: 2170\r\n  <br />\r\n  Tel.: +963 11 2221857 &ndash; 2200235\r\n  <br />\r\n  Fax: +963 11 2243933\r\n  <br />\r\n  Mobile: +963 944 673 303\r\n  <br />\r\n  E-mail:\r\n  <u>\r\n    <a href=\"mailto:dhl.gf@nazhaco.com\" style=\"color:blue; text-decoration:underline\">\r\n      dhl.gf@nazhaco.com\r\n    </a>\r\n  </u>\r\n</p>\r\n', 'Nazha Logistics LLC - Exclusive Agent of DHL Global Forwarding in Syria.\r\nSabbagh Building, Victoria Bridge. \r\nDamascus – Syria. \r\nP.O.Box: 2170\r\nTel.: +963 11 2221857 – 2200235 / Fax: +963 11 2243933\r\nMobile: +963 944 673 303\r\nE-mail: dhl.gf@nazhaco.com'),
(34, 22, 1, 1, 12, 'Air Freight 0301', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:16px\">\r\n  <strong>\r\n    Added value services\r\n  </strong>\r\n</p>\r\n\r\n<p style=\"text-align:center; font-size:14px\">\r\n  <span style=\"font-size:16px; color:#cc0033\">\r\n    AIR CHARTER\r\n  </span>\r\n  <br />\r\n  Specialist Cargo Handling\r\n  <br />\r\n  <span style=\"font-size:16px; color:#cc0033\">\r\n    AIR THERMONET\r\n  </span>\r\n  <br />\r\n  Standard Temperature Controlled Air Freight\r\n  <br />\r\n  <span style=\"font-size:16px; color:#cc0033\">\r\n    CROSS TRADE\r\n  </span>\r\n  <br />\r\n  moving shipments between two countries regardless of customer location\r\n</p>\r\n', 'added value services\r\n\r\n    AIR CHARTER - Specialist Cargo Handling\r\n    AIR THERMONET - Standard Temperature Controlled Air Freight\r\n\r\nCross Trade – moving shipments between two countries regardless of customer location'),
(35, 23, 1, 1, 6, 'Air Freight 0201', 'Middle 1 - 600 x 400.jpg', NULL, NULL),
(36, 23, 2, 1, 6, 'Air Freight 0202', 'Middle 2.jpg', NULL, NULL),
(37, 24, 1, 1, 12, 'Air Freight 0401', 'Slider 1.jpg', NULL, NULL),
(38, 24, 2, 1, 12, 'Air Freight 0402', 'Slider 2.jpg', NULL, NULL),
(39, 24, 1, 1, 12, 'Air Freight 0403', 'Slider 3.jpg', NULL, NULL),
(40, 24, 1, 1, 12, 'Air Freight 0404', 'Slider 4.jpg', NULL, NULL),
(41, 24, 1, 1, 12, 'Air Freight 0405', 'Slider 5.jpg', NULL, NULL),
(42, 24, 1, 1, 12, 'Air Freight 0406', 'Slider 6.jpg', NULL, NULL),
(43, 24, 1, 1, 12, 'Air Freight 0407', 'Slider 7.jpg', NULL, NULL),
(44, 24, 1, 1, 12, 'Air Freight 0408', 'Slider 8.jpg', NULL, NULL),
(45, 25, 1, 1, 2, 'SYDI 0101', NULL, '<p></p>', NULL),
(46, 26, 1, 1, 12, 'SYDI 0201', NULL, '<p style=\"text-align:center\"><span style=\"font-size:16px\"><strong>AKDN - Aga Khan Development Network</strong></span></p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:14px\">In 2017 we signed MoU with AKDN to donate books to a prototype library</span><br />\r\n<span style=\"font-size:14px\">established recently by AKDN in an elementary school in Damascus old city that has 425 students. The 408 donated</span><br />\r\nbooks varied among encyclopedias, cultural books, educational books, and purposeful stories.</p>', NULL),
(47, 27, 1, 1, 6, 'SYDI 0301', 'Middle 1.jpg', NULL, NULL),
(48, 27, 2, 1, 6, 'SYDI 0302', 'Middle 2(1).jpg', NULL, NULL),
(49, 28, 1, 1, 12, 'SYDI 0401', NULL, '<p style=\"text-align:center\"><strong><span style=\"font-size:16px\">SOS - SOS Children&rsquo;s Villages</span></strong></p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:14px\">As part of Deutsche Post DHL Group-wide program &ldquo;GoTeach&rdquo;, we work together with international partners to improve educational opportunity and employability for young people, especially those from disadvantaged socio-economic backgrounds.<br />\r\nDeutsche Post DHL Group and SOS Children\'s Villages International have been partners in the GoTeach program since 2011.<br />\r\nThe partnership covers a wide variety of activities; these can be clustered into the following categories:</span></p>', NULL),
(51, 29, 2, 1, 12, 'SYDI 0502', 'Slider 2(1).jpg', NULL, NULL),
(52, 29, 3, 1, 12, 'SYDI 0503', 'Slider 3(1).jpg', NULL, NULL),
(53, 29, 4, 1, 12, 'SYDI 0504', 'Slider 4(1).jpg', NULL, NULL),
(54, 29, 5, 1, 12, 'SYDI 0505', 'Slider 5(1).jpg', NULL, NULL),
(55, 29, 6, 1, 12, 'SYDI 0506', 'Slider 6(1).jpg', NULL, NULL),
(56, 29, 7, 1, 12, 'SYDI 0507', 'Slider 7(1).jpg', NULL, NULL),
(57, 29, 8, 1, 12, 'SYDI 0508', 'Slider 8(1).jpg', NULL, NULL),
(58, 29, 9, 1, 12, 'SYDI 0509', 'Slider 9.jpg', NULL, NULL),
(59, 28, 2, 1, 3, 'SYDI 0402', NULL, NULL, NULL),
(60, 28, 3, 1, 6, 'SYDI 0403', NULL, '<p style=\"text-align:justify\"><span style=\"font-size:14px\"><span style=\"color:#d40511\">&bull; Job orientation &ndash; to educate teens about the job market</span><br />\r\n<span style=\"color:#d40511\">&bull; Soft and basic skills training &ndash; to enable access to the job market</span><br />\r\n<span style=\"color:#d40511\">&bull; Exposure to professional working environment &ndash; to gain initial work experience</span><br />\r\n<span style=\"color:#d40511\">&bull; Training and support for establishing own businesses</span></span></p>', NULL),
(61, 28, 4, 1, 3, 'SYDI 0404', NULL, NULL, NULL),
(62, 28, 5, 1, 12, 'SYDI 0405', NULL, '<p style=\"text-align:center\"><span style=\"font-size:14px\">The program started in four countries in 2011 and expanded rapidly to 26 countries worldwide by 2015 and in 2017 it was launched in Syria.</span><br/><span style=\"font-size:14px\">In Syria DGF support SOS by training a group of SOS youths on the above categories by specialized DHL trainers. The project started in 2017 and is still ongoing</span></p>', NULL),
(63, 30, 1, 1, 4, 'Left 01', NULL, NULL, NULL),
(64, 30, 2, 1, 5, 'Center 01', NULL, '<ul>\r\n	<li style=\"text-align:justify\"><span style=\"font-size:14px\"><strong>OCEAN DIRECT FCL - Full container load</strong></span></li>\r\n	<li style=\"text-align:justify\"><span style=\"font-size:14px\"><strong>OCEAN CONNECT LCL - Less than container load</strong></span></li>\r\n	<li style=\"text-align:justify\"><span style=\"font-size:14px\"><strong>OCEAN CONTAINER MANAGEMENT - FCL inland service</strong></span></li>\r\n	<li style=\"text-align:justify\"><span style=\"font-size:14px\"><strong>OCEAN SPECIAL - Conventional load services</strong></span></li>\r\n</ul>', 'OCEAN DIRECT FCL - Full container load\r\nOCEAN CONNECT LCL - Less than container load\r\nOCEAN CONTAINER MANAGEMENT - FCL inland services\r\nOCEAN SPECIAL - Conventional load services'),
(65, 30, 3, 1, 3, 'Right 01', NULL, NULL, NULL),
(66, 31, 1, 1, 12, 'oc01', 'Slider 2(2).jpg', NULL, NULL),
(67, 31, 2, 1, 12, 'oc02', 'Slider 3(2).jpg', NULL, NULL),
(68, 31, 3, 1, 12, 'oc03', 'Slider 4(2).jpg', NULL, NULL),
(69, 31, 4, 1, 12, 'oc4', 'Slider 5(2).jpg', NULL, NULL),
(70, 32, 1, 1, 12, 'Ocean Freight 0301', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:16px\">\r\n  <strong>\r\n    Added value services\r\n  </strong>\r\n</p>\r\n\r\n<p style=\"text-align:center; font-size:14px\">\r\n  <span style=\"font-size:16px; color:#d40511\">\r\n    OCEAN ASSEMBLY\r\n  </span>\r\n  <br />\r\n  Single &amp; multi country consolidation\r\n  <br />\r\n  <span style=\"font-size:16px; color:#d40511\">\r\n    OCEAN CHARTER\r\n  </span>\r\n  <br />\r\n  Cargo vessel charter\r\n  <br />\r\n  <span style=\"font-size:16px; color:#d40511\">\r\n    FLEXITANKS\r\n  </span>\r\n  <br />\r\n  Transportation of bulk-liquids\r\n  <br />\r\n  <span style=\"font-size:16px; color:#d40511\">\r\n    OCEAN THERMONET\r\n  </span>\r\n  <br />\r\n  Temperature Controlled Ocean Freight\r\n  <br />\r\n  <span style=\"font-size:16px; color:#d40511\">\r\n    CROSS TRADE\r\n  </span>\r\n  <br />\r\n  Moving shipments between two countries regardless of customer location\r\n</p>\r\n', 'added value services \r\n•	OCEAN ASSEMBLY - Single & multi country consolidation\r\n•	OCEAN CHARTER - Cargo vessel charter\r\n•	FLEXITANKS - Transportation of bulk-liquids\r\n•	OCEAN THERMONET - Temperature Controlled Ocean Freight\r\n•	Cross Trade – moving shipments between two countries regardless of customer location'),
(78, 33, 3, 1, 10, 'Road03', NULL, '<ul>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Direct pick-up and delivery service using one vehicle, dedicated to your shipment\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    DHL Freight managed and quality-measured transport fleet\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Service embedded in DHL Freight&rsquo;s international network, with 208 terminals across Europe\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Defined lead times based on origin/destination\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Support provided via direct contact with local DHL Freight experts\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Proof of delivery (POD)\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Transportation of dangerous goods\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Additional insurance\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px; color:#cc0033\">\r\n    Individual performance reports\r\n  </li>\r\n</ul>\r\n', 'Value Added Services:\r\n•	Direct pick-up and delivery service using one vehicle, dedicated to your shipment\r\n•	DHL Freight managed and quality-measured transport fleet\r\n•	Service embedded in DHL Freight’s international network, with 208 terminals across Europe\r\n•	Defined lead times based on origin/destination\r\n•	Support provided via direct contact with local DHL Freight experts\r\n•	Proof of delivery (POD)\r\n•	Transportation of dangerous goods\r\n•	Additional insurance\r\n•	Individual performance reports'),
(79, 33, 2, 1, 2, 'Road left0', NULL, NULL, NULL),
(81, 21, 0, 1, 3, 'Empty 3 Cols', NULL, NULL, NULL),
(83, 12, 3, 1, 4, 'Warehousing 010202', NULL, '<ul>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Fire alerts, protection and escape routes\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Security guards\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Material Handling Equipment\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Racking &amp; Shelving\r\n  </li>\r\n</ul>\r\n', 'We offer warehouse management at any location in the country based on customer requirements.\r\nDHL Global Forwarding Damascus Logistics Facility:\r\nLocated 7 KM from Damascus Airport and 23 KM from Damascus city center.\r\nTotal Land area: 110,000 sqm, out of which 40,000 sqm are encircled by a 3.5 m high fence; this part contains the present warehouses and offices. \r\nTotal Warehouses Space:  5,000 sqm of fully equipped warehouses that will be extended to 14,000 sqm in phase two.\r\nFacility specifications and equipment:\r\n•	Fire alerts, protection and escape routes\r\n•	Security guards \r\n•	Material Handling Equipment\r\n•	Racking & Shelving\r\n•	HSE needs\r\n•	Warehouse Management System (WMS)\r\n•	Insurance coverage\r\n\r\nOur Warehousing Solutions improve inventory efficiency and accelerate your response to changing customer demand. Our experts design, implement, and operate flexible warehousing and distribution solutions tailored to your business needs. They analyze every point in your supply chain to determine the optimal solution.\r\n•	Dedicated Warehouses \r\n•	Multi Customer Warehousing \r\n•	Ambient and temperature-controlled facilities\r\n•	Storage, pick, pack and dispatch\r\n•	Delivery and returns management\r\n\r\nInventory Optimization\r\nThrough effective inventory management, inefficiencies can be driven out of the supply chain, overall costs reduced and high service levels achieved. We optimize inventory at a line-item level at every stage of the supply chain.\r\n\r\nMulti-Customer Warehousing\r\nOur shared-user facilities are designed to meet the needs of any customer for consumer products, industrial equipment, chemicals and technology.\r\nThrough sharing of DHL\'s resources, such as space, labor, equipment and transportation, customers benefit from synergies that considerably reduce supply chain costs.\r\nThis environment returns significant value to a small business requiring distribution operations without long term lease or capital commitments, or a large enterprise handling a new acquisition, product launches or seasonal overflow'),
(84, 12, 2, 1, 2, 'Warehousing 010201', NULL, NULL, NULL),
(86, 12, 5, 1, 2, 'Warehousing 010204', NULL, NULL, NULL),
(87, 35, 1, 1, 6, 'Warehousing 0201', 'Twin Photos 1.jpg', NULL, NULL),
(88, 35, 2, 1, 6, 'Warehousing 0202', 'Twin Photos 2.jpg', NULL, NULL),
(89, 37, 1, 1, 12, 'Warehousing 0401', 'Slider 1(1).jpg', NULL, NULL),
(91, 37, 2, 1, 12, 'Warehousing 0403', 'Slider 3(3).jpg', NULL, NULL),
(92, 37, 3, 1, 12, 'Warehousing 0404', 'Slider 4(3).jpg', NULL, NULL),
(93, 37, 4, 1, 12, 'Warehousing 0405', 'Slider 5(3).jpg', NULL, NULL),
(94, 37, 5, 1, 12, 'Warehousing 0406', 'Slider 6(2).jpg', NULL, NULL);
INSERT INTO `cpy_block_detail` (`dblk_id`, `blk_id`, `dblk_order`, `dblk_status`, `dblk_type`, `dblk_name`, `dblk_image`, `dblk_text`, `dblk_stext`) VALUES
(95, 36, 1, 1, 12, 'Warehousing 0101', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  WAREHOUSING\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  We offer warehouse management at any location in the country based on customer requirements.\r\n  <br />\r\n  <strong>Our Warehousing Solutions</strong>\r\n  improve inventory efficiency and accelerate your response to changing customer demand. Our experts design, implement, and operate flexible warehousing and distribution solutions tailored to your business needs. They analyze every point in your supply chain to determine the optimal solution.\r\n  <br />\r\n  <br />\r\n  <span style=\"font-size:16px\">\r\n    <strong>\r\n      Warehousing Services\r\n    </strong>\r\n  </span>\r\n  <br />\r\n  Dedicated Warehouses\r\n  <br />\r\n  Multi Customer Warehousing\r\n  <br />\r\n  Ambient and temperature-controlled facilities\r\n  <br />\r\n  Storage, pick, pack and dispatch\r\n  <br />\r\n  Delivery and returns management\r\n</p>\r\n', NULL),
(100, 38, 1, 1, 12, 'Packing & Removal 0301', NULL, '<p style=\"text-align:center; font-size:14px;\">\r\n  <strong style=\"font-size:16px; color:#d40511;\">\r\n    Packing Steps\r\n  </strong>\r\n  <br/>\r\n  Our packing process has a defined outline, solid to ensure our customers trust and peace of mind, flexible enough to adjust according to needed requirements. Don&rsquo;t wait until you have a moving day. Contact us at least one month before you intend to move, we will then work with you to help you through the process.\r\n  <br/>\r\n  <strong style=\"font-size:16px; color:#d40511;\">\r\n    Assessment\r\n  </strong>\r\n  <br/>\r\n  Our Experts will undertake an assessment survey to estimate our customers&rsquo; requirements and needs.\r\n  <br/>\r\n  <strong style=\"font-size:16px; color:#d40511;\">\r\n    Offer\r\n  </strong>\r\n  <br/>\r\n  will be submitted promptly after thorough study.\r\n  <br/>\r\n  <strong style=\"font-size:16px; color:#d40511;\">\r\n    Plan\r\n  </strong>\r\n  <br/>\r\n  a plan will be developed tailor made to fit each customer&rsquo;s requirements and commodities.\r\n</p>\r\n', NULL),
(101, 39, 1, 1, 12, 'Packing & Removal 0201', 'Slider 1(2).jpg', NULL, NULL),
(102, 39, 2, 1, 12, 'Packing & Removal 0202', 'Slider 2(4).jpg', NULL, NULL),
(103, 39, 3, 1, 12, 'Packing & Removal 0203', 'Slider 3(4).jpg', NULL, NULL),
(104, 39, 4, 1, 12, 'Packing & Removal 0204', 'Slider 4(4).jpg', NULL, NULL),
(105, 39, 5, 1, 12, 'Packing & Removal 0205', 'Slider 5(4).jpg', NULL, NULL),
(106, 39, 6, 1, 12, 'Packing & Removal 0206', 'Slider 6(3).jpg', NULL, NULL),
(107, 40, 1, 1, 12, 'Projects 0201', 'Slider 1(3).jpg', NULL, NULL),
(108, 40, 2, 1, 12, 'Projects 0202', 'Slider 2(5).jpg', NULL, NULL),
(109, 40, 3, 1, 12, 'Projects 0203', 'Slider 3(5).jpg', NULL, NULL),
(110, 40, 4, 1, 12, 'Projects 0204', 'Slider 4(5).jpg', NULL, NULL),
(111, 40, 5, 1, 12, 'Projects 0205', 'Slider 5(5).jpg', NULL, NULL),
(112, 41, 2, 1, 3, 'Projects 0302', NULL, '<p style=\"text-align:center\">\r\n  <strong style=\"font-size:18px; color:#cc0033\">\r\n    Core Services\r\n  </strong>\r\n</p>\r\n\r\n<ul>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Warehousing and Order Fulfillment\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Sub-assembly and Kitting\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Transportation Management\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Lead Logistics Provider (LLP)\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Industrial Projects Transportation\r\n  </li>\r\n</ul>\r\n', NULL),
(113, 41, 3, 1, 3, 'Projects 0303', NULL, '<p style=\"text-align:center\">\r\n  <strong style=\"font-size:18px; color:#cc0033\">\r\n    We address\r\n  </strong>\r\n</p>\r\n\r\n<ul>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Transport and Logistics Design\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Logistics Management\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Project Cargo Logistics\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Heavy Loads\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Outsized Loads\r\n  </li>\r\n</ul>\r\n', NULL),
(114, 41, 1, 1, 3, 'Projects 0301', NULL, '<span></span>', NULL),
(115, 41, 4, 1, 3, 'Projects 0304', NULL, NULL, NULL),
(116, 42, 1, 1, 12, 'Road Freight 0201', 'Slider 1(4).jpg', NULL, NULL),
(117, 42, 2, 1, 12, 'Road Freight 0202', 'Slider 2(6).jpg', NULL, NULL),
(118, 42, 3, 1, 12, 'Road Freight 0203', 'Slider 3(6).jpg', NULL, NULL),
(119, 42, 4, 1, 12, 'Road Freight 0204', 'Slider 4(6).jpg', NULL, NULL),
(121, 33, 1, 1, 12, 'Road Freight 0301', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:18px\">\r\n  <strong>\r\n    Value Added Services\r\n  </strong>\r\n</p>\r\n', 'Value Added Services:\r\n•	Direct pick-up and delivery service using one vehicle, dedicated to your shipment\r\n•	DHL Freight managed and quality-measured transport fleet\r\n•	Service embedded in DHL Freight’s international network, with 208 terminals across Europe\r\n•	Defined lead times based on origin/destination\r\n•	Support provided via direct contact with local DHL Freight experts\r\n•	Proof of delivery (POD)\r\n•	Transportation of dangerous goods\r\n•	Additional insurance\r\n•	Individual performance reports'),
(122, 44, 1, 1, 12, 'Culture Support 0201', 'Slider 1(5).jpg', NULL, NULL),
(123, 44, 2, 1, 12, 'Culture Support 0202', 'Slider 2(7).jpg', NULL, NULL),
(124, 44, 3, 1, 12, 'Culture Support 0203', 'Slider 3(7).jpg', NULL, NULL),
(125, 44, 4, 1, 12, 'Culture Support 0204', 'Slider 4(7).jpg', NULL, NULL),
(126, 44, 5, 1, 12, 'Culture Support 0205', 'Slider 5(6).jpg', NULL, NULL),
(127, 44, 6, 1, 12, 'Culture Support 0206', 'Slider 6(4).jpg', NULL, NULL),
(130, 43, 1, 1, 12, 'Culture Support 0101', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  CULTURE SUPPORT\r\n</p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:14px\">\r\n  Cultural projects are of vital importance to enlarge the youth prospects in different aspects.\r\n  <br />\r\n  Thus we sponsored many youth cultural events that varied among Music and Visual Arts.\r\n  <br />\r\n  <br />\r\n  <strong style=\"font-size:16px\">\r\n    Sponsorships\r\n  </strong>\r\n</p>\r\n', NULL),
(131, 43, 2, 1, 2, 'Culture Support 0102', NULL, '<span></span>', NULL),
(132, 43, 3, 1, 10, 'Culture Support 0103', NULL, '<p style=\"text-align:justify\"><span style=\"font-size:14px\"><span style=\"color:#d40511\">&bull; Photo Exhibition &ldquo;Dervish Rituals&rdquo; by a Syrian artist. The exhibition was held in the historical hall of<br />\r\n&nbsp;&nbsp;&nbsp;Khan As&rsquo;ad Pasha under the high auspices of the Syrian Minister of Culture in 2007.<br />\r\n&bull; Jazz concert performed by a specialized Russian Band in Damascus in 2007<br />\r\n&bull; The shielding cover when Salahuddin Ayyubi statue was under restoration in 2007<br />\r\n&bull; Partnership in the International Violin Competition with Solhi Al Wadi Institute of Music in 2008<br />\r\n&bull; Yes Academy &quot;Youth Excellence on Stage&quot; in 2010<br />\r\n&bull; Jazz Lives in 2010<br />\r\n&bull; The Visual arts festival in Damascus in 2010</span></span></p>', NULL),
(133, 46, 1, 1, 12, 'Environment protection 0201', 'Slider1.jpg', NULL, NULL),
(134, 46, 2, 1, 12, 'Environment protection 0202', 'Slider2.jpg', NULL, NULL),
(135, 46, 3, 1, 12, 'Environment protection 0203', 'Slider3.jpg', NULL, NULL),
(136, 46, 4, 1, 12, 'Environment protection 0204', 'Slider4.jpg', NULL, NULL),
(137, 45, 1, 1, 12, 'Environment protection 0101', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  ENVIRONMENT PROTECTION\r\n</p>\r\n\r\n<p style=\"text-align:center; font-size:14px\">\r\n  Committed to sustainable development, we create innovative, effective, environmentally friendly logistics,\r\n  <br />\r\n  services that fulfill customer\'s needs, while minimizing undesirable impacts.\r\n  <br />\r\n  We endeavor to prevent pollution in our business activities by means such as saving resources and energy, reduction of waste and the promotion of recycling.\r\n  <br />\r\n  We also strive to maintain a healthy environment and to spread products and services for improving the environment while working on environmentally-friendly activities.\r\n  <br />\r\n  Among the environmental impacts caused by our business activities, we will address the improvement of the following subjects<br />\r\n  as priority issues, and will review them periodically and revise when necessary.\r\n  <br />\r\n  Positive sales of environment-friendly products\r\n  <br />\r\n  Promotion of waste reduction and recycling activities\r\n  <br />\r\n  Promotion of energy conservation and resources conservation\r\n  <br />\r\n  Promotion of green purchasing\r\n</p>\r\n', NULL),
(138, 48, 1, 1, 12, 'Fairs & Events 03', NULL, '<p style=\"text-align:center\"><span style=\"font-size:16px\"><strong>Innovation and Tailor-made Solutions</strong></span></p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:14px\">We anticipate your needs while setting standards for the industry<br />\r\n<strong>Customized relationship management </strong>programs that mirror clients&rsquo; organizational needs<br />\r\nProviding <strong>specialized services</strong>, e.g. Project management, document support, customs clearance, on-site handling, delivery, storage concepts, packing</span></p>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:16px\"><strong>Industry expertise and Know-How</strong></span></p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:14px\">Our experts are at your service to provide you with state-of-the-art service<br />\r\n<strong>Global expertise teamed </strong>with local knowledge &ndash; we deliver the right integrated solution<br />\r\n<strong>Unique understanding </strong>of customer requirements<br />\r\n<strong>One personal and&nbsp; dedicated point of contact for all your needs</strong></span></p>', 'We offer complete logistics services for both Fairs & Events Organizers and Clients.\r\n\r\nInfrastructure\r\n\r\nWe accompany you! Wherever your customers and suppliers need us - we are already there\r\n\r\nOur specialists are located around the globe and support you at every location worldwide\r\nOrganizers and venues worldwide trust in us and appoint DHL as official forwarder\r\nDedicated network of experienced operations personnel\r\n\r\n\r\nReliability and Quality of Service\r\n\r\nWe help you preserve and deliver the highest quality to your customers\r\n\r\nOne partner with the ability to provide the most extensive product offering\r\nExperience in handling and shipping of exceptional shipments\r\nFull service approach before, during and after the show or event\r\n\r\n\r\nInnovation and Tailor-made Solutions\r\n\r\nWe anticipate your needs while setting standards for the industry\r\n\r\nCustomized relationship management programs that mirror clients’ organizational needs\r\nProviding specialized services, e.g. Project management, document support, customs clearance, on-site handling, delivery, storage concepts, packing\r\n\r\n\r\nIndustry expertise and Know-How\r\n\r\nOur experts are at your service to provide you with state-of-the-art service\r\n\r\nGlobal expertise teamed with local knowledge – we deliver the right integrated solution\r\nUnique understanding of customer requirements\r\nOne personal and  dedicated point of contact for all your needs'),
(139, 47, 1, 1, 6, 'Fairs & Events 0201', '01-Twin 600x 400.jpg', NULL, NULL),
(140, 47, 2, 1, 6, 'Fairs & Events 0202', '02-Twin 600x 400.jpg', NULL, NULL),
(141, 49, 1, 1, 12, 'Fairs & Events 0401', '03-Slider 1.jpg', NULL, NULL),
(142, 49, 2, 1, 12, 'Fairs & Events 0402', '04-Slider 2.jpg', NULL, NULL),
(143, 49, 3, 1, 12, 'Fairs & Events 0403', '06-Slider 3.jpg', NULL, NULL),
(144, 49, 4, 1, 12, 'Fairs & Events 0404', '07-Slider 4.jpg', NULL, NULL),
(145, 49, 5, 1, 12, 'Fairs & Events 0405', '08-Slider 5.jpg', NULL, NULL),
(146, 49, 6, 1, 12, 'Fairs & Events 0406', '09-Slider 6.jpg', NULL, NULL),
(147, 50, 1, 1, 6, 'Insurance 0201', 'Twin Photos 1(1).jpg', NULL, NULL),
(148, 50, 2, 1, 6, 'Insurance 0202', 'Twin Photos 2(1).jpg', NULL, NULL),
(149, 51, 1, 1, 6, 'Multimodal Transport 0201', 'Twin Photos 1(2).jpg', NULL, NULL),
(150, 51, 2, 1, 6, 'Multimodal Transport 0202', 'Twin Photos 2(2).jpg', NULL, NULL),
(151, 52, 1, 1, 12, 'Multimodal Transport 0301', NULL, '<p style=\"text-align:center\"><span style=\"font-size:16px\"><span style=\"color:#cc0033\">Import/export customs brokerage</span></span><br />\r\n<span style=\"font-size:14px\">we take control of all customs formalities and delivery documentation</span></p>\r\n\r\n<p style=\"text-align:center\"><br />\r\n<span style=\"font-size:14px\"><span style=\"color:#cc0033\">An alternative modal option during peak season congestion<br />\r\nEnd-to-end real time visibility<br />\r\nGreen transport</span></span></p>', NULL),
(152, 53, 1, 1, 6, 'Nazha Logistics 0201', 'Twin Photos 1(3).jpg', NULL, NULL),
(153, 53, 2, 1, 6, 'Nazha Logistics 0202', 'Twin Photos 2(3).jpg', NULL, NULL),
(154, 54, 1, 1, 12, 'Nazha Logistics 03', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  NAZHA LOGISTICS\r\n</p>\r\n\r\n<p style=\"text-align:center; font-size:14px\">\r\n  <strong style=\"font-size:16px\">\r\n    Company History\r\n  </strong>\r\n  <br />\r\n  NAZHA Travel, Tourism &amp; Freight was established in 1972. Based in Damascus, it was the first company in Syria specialized in airfreight, and progressively it has expanded its services scope to include Ocean Freight and Road Freight, thus it has become a Logistics leader in Syria, serving local and international customers.\r\n  <br />\r\n  <br />\r\n  In 2002 NAZHA became the exclusive agent of Danzas AEI intercontinental in Syria, a part of Deutsche Post World Net which acquired DHL Express in the same year. In 2003 Deutsche Post World Net has consolidated all of its express and logistics activities into one single brand: DHL. Consequently, NAZHA became the exclusive agent for DHL Global Forwarding in Syria.\r\n  <br />\r\n  <br />\r\n  &ldquo;NAZHA Travel, Tourism &amp; Freight&rdquo; name has been re-branded to be &ldquo;NAZHA Logistics&rdquo; in 2014.\r\n</p>\r\n', 'NAZHA Travel, Tourism & Freight was established in 1972. Based in Damascus, it was the first company in Syria specialized in airfreight, and progressively it has expanded its services scope to include Ocean Freight and Road Freight, thus it has become a Logistics leader in Syria, serving local and international customers.  In 2002 NAZHA became the exclusive agent of Danzas AEI intercontinental in Syria, a part of Deutsche Post World Net which acquired DHL Express in the same year. In 2003 Deutsche Post World Net has consolidated all of its express and logistics activities into one single brand: DHL. Consequently, NAZHA became the exclusive agent for DHL Global Forwarding in Syria.   “NAZHA Travel, Tourism & Freight” name has been re-branded to be “NAZHA Logistics” in 2014.'),
(155, 55, 1, 1, 12, 'Nazha Logistics 0401', 'Slider 1(6).jpg', NULL, NULL),
(156, 55, 2, 1, 12, 'Nazha Logistics 0402', 'Slider 2(8).jpg', NULL, NULL),
(157, 55, 3, 1, 12, 'Nazha Logistics 0403', 'Slider 3(8).jpg', NULL, NULL),
(158, 55, 4, 1, 12, 'Nazha Logistics 0404', 'Slider 4(8).jpg', NULL, NULL),
(159, 55, 5, 1, 12, 'Nazha Logistics 0405', 'Slider 5(7).jpg', NULL, NULL),
(160, 56, 1, 1, 12, 'Nazha Logistics 05', NULL, '<p style=\"text-align:center\"><span style=\"font-size:16px\"><span style=\"color:#cc0033\">Offices</span></span><br />\r\n<span style=\"font-size:14px\">Damascus Head Office<br />\r\nTartous Port office<br />\r\nLattakia Port office</span><br />\r\n<br />\r\n<span style=\"font-size:16px\"><span style=\"color:#cc0033\">Employees</span></span><br />\r\n<span style=\"font-size:14px\">150</span><br />\r\n<br />\r\n<span style=\"font-size:16px\"><span style=\"color:#cc0033\">Opening hours</span></span><br />\r\n<span style=\"font-size:14px\"><strong>Offices</strong>: SAT &ndash; THU 08h30 &ndash; 16h30<br />\r\n<strong>Warehouses, Airport, Ports, Terminals services</strong>: 24/24 hours, 7 days a week</span></p>', 'Offices\r\nDamascus Head Office\r\nTartous Port office\r\nLattakia Port office\r\n\r\nEmployees\r\n150\r\n\r\nOpening hours\r\nOffices: SAT – THU 08h30 – 16h30\r\nWarehouses, Airport, Ports, Terminals services: 24/24 hours, 7 days a week'),
(161, 57, 1, 1, 12, 'Quality Assurance 0201', 'Slider 1(7).jpg', NULL, NULL),
(162, 57, 2, 1, 12, 'Quality Assurance 0202', 'Slider 2(9).jpg', NULL, NULL),
(163, 57, 3, 1, 12, 'Quality Assurance 0203', 'Slider 3(9).jpg', NULL, NULL),
(164, 57, 4, 1, 12, 'Quality Assurance 0204', 'Slider 4(9).jpg', NULL, NULL),
(165, 57, 5, 1, 12, 'Quality Assurance 0205', 'Slider 5(8).jpg', NULL, NULL),
(174, 58, 1, 1, 6, 'Customs Clearance 0201', 'Twin photos 1.jpg', NULL, NULL),
(175, 58, 2, 1, 6, 'Customs Clearance 0202', 'Twin photos 2.jpg', NULL, NULL),
(176, 60, 1, 1, 6, 'Customs Clearance 0401', 'Twin photos 3.jpg', NULL, NULL),
(177, 60, 2, 1, 6, 'Customs Clearance 0402', 'Twin photos 4.jpg', NULL, NULL),
(178, 59, 1, 1, 6, 'Customs Clearance 0301', NULL, '<p style=\"text-align:center; font-size:18px\">\r\n  <strong>\r\n    Clearing Services offered are\r\n  </strong>\r\n</p>\r\n', 'Clearing Services offered are :\r\n\r\n    Import Customs Clearance\r\n    Export Clearance\r\n    Transit Customs Clearance\r\n    Customs Approval follow up\r\n    Import License follow up\r\n    Analysis follow up\r\n    Range of additional clearance services based on shipment purpose'),
(180, 59, 3, 1, 6, 'Customs Clearance 0303', NULL, '<ul>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Import Customs Clearance\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Export Clearance\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Transit Customs Clearance\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Customs Approval follow up\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Import License follow up\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Analysis follow up\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Range of additional clearance services based on shipment purpose\r\n  </li>\r\n</ul>\r\n', 'Clearing Services offered are :\r\n\r\n    Import Customs Clearance\r\n    Export Clearance\r\n    Transit Customs Clearance\r\n    Customs Approval follow up\r\n    Import License follow up\r\n    Analysis follow up\r\n    Range of additional clearance services based on shipment purpose'),
(181, 61, 1, 1, 12, 'Aid & Relief Services 0301', NULL, '<p style=\"text-align:center; font-size:14px\">\r\n  <strong style=\"font-size:16px\">\r\n    Transportation\r\n  </strong>\r\n  <br/>\r\n  Primary Transportation, from Syrian Ports (Lattakia &amp; Tartous) or from Lebanon and Jordan borders to our warehouses.\r\n  <br />\r\n  Secondary Transportation, from local warehouses or directly from Ports to all Cities in Syria, according to a pre-defined monthly cycle.\r\n  <br />\r\n  <br />\r\n  <strong style=\"font-size:16px\">\r\n    Charters\r\n  </strong>\r\n  <br />\r\n  Cargo Charters to difficult-to-access and faraway areas within Syria\r\n  <br />\r\n  <br />\r\n  <strong style=\"font-size:16px\">\r\n    Customs Clearance\r\n  </strong>\r\n  <br />\r\n  Done at Ports and Borders as a supporting service to the transportation operations and for urgent Aid &amp; Relief shipments, we\r\n  <br />\r\n  arrange direct withdrawal (when required) to speed up the delivery process and settle the declarations later on.\r\n  <br />\r\n  <br />\r\n  <strong style=\"font-size:16px\">\r\n    Warehousing\r\n  </strong>\r\n  <br/>\r\n  Dedicated warehouses with full warehousing management services for UN Agencies and NGOs which have huge operations in any location in Syria\r\n  <br />\r\n  Multi-Customer warehousing services for UN Agencies and NGOs which need temporary services for small operations at our DHL Facility in Damascus\r\n  <br />\r\n  <br />\r\n  <strong style=\"font-size:16px\">\r\n    Packaging\r\n  </strong>\r\n  <br/>\r\n  Aid &amp; Relief Packaging Department was established to provide re-packing and re-bagging services of a monthly pre-defined content\r\n  <br />\r\n  of Aid &amp; Relief Family Food and Non-Food Rations. These services are done through:\r\n  <br />\r\n  Well trained staff with high productivity performance\r\n  <br />\r\n  Ability to work 24 hours on shifts basis\r\n  <br />\r\n  Ability to supply all kinds of packing equipment and packing materials\r\n  <br />\r\n  Safety &amp; Hygiene standards are strictly implemented\r\n  <br />\r\n  <br />\r\n  <strong style=\"font-size:16px\">\r\n    Supply\r\n  </strong>\r\n  <br/>\r\n  DHL Global Forwarding can supply raw materials, re-pack them into kits and deliver them to the service requester as per the standards required by any UN Agency or Humanitarian Organization, giving priority to the local market in order to support the local Syrian families as per DHL Global Forwarding Aid &amp; Relief policies which are in line with UN agencies and other humanitarian organizations. However, when the raw materials must be imported, DHL Global Forwarding is the most eligible company in Syria to arrange the import of such material through its worldwide network.&nbsp; Kits types may include (but not limited to) the following types.\r\n  <br />\r\n  Hygiene Kits\r\n  <br />\r\n  Clothing Kits\r\n  <br />\r\n  Food Kits\r\n  <br />\r\n  Baby Kits\r\n  <br />\r\n  Plastic Sheets\r\n  <br />\r\n  School Kits\r\n  <br />\r\n  Mosquito Nets\r\n</p>\r\n', 'AID & RELIEF SERVICES\r\n\r\nDue to the need of logistics services for the humanitarian aid across the country, DHL Global Forwarding -Syria set up a department under the name of Aid & Relief Services responsible for the Humanitarian Aid Logistics within Syria through the following services\r\n\r\n    Transportation \r\n        Primary Transportation, from Syrian Ports (Lattakia & Tartous) or from Lebanon and Jordan borders to our warehouses.\r\n        Secondary Transportation, from local warehouses or directly from Ports to all Cities in Syria, according to a pre-defined monthly cycle.\r\n    Charters\r\n    Cargo Charters to difficult-to-access and faraway areas within Syria\r\n\r\n\r\n    Customs Clearance\r\n    Done at Ports and Borders as a supporting service to the transportation operations and for urgent Aid & Relief shipments, we arrange direct withdrawal (when required) to speed up the delivery process and settle the declarations later on.\r\n\r\n    Warehousing\r\n        Dedicated warehouses with full warehousing management services for UN Agencies and NGOs which have huge operations in any location in Syria\r\n        Multi-Customer warehousing services for UN Agencies and NGOs which need temporary services for small operations at our DHL Facility in Damascus \r\n    Packaging\r\n\r\nAid & Relief Packaging Department was established to provide re-packing and re-bagging services of a monthly pre-defined content of Aid & Relief Family Food and Non-Food Rations. These services are done through:\r\n\r\n        Well trained staff with high productivity performance\r\n        Ability to work 24 hours on shifts basis\r\n        Ability to supply all kinds of packing equipment and packing materials\r\n        Safety & Hygiene standards are strictly implemented\r\n\r\n\r\n    Supply\r\n\r\nDHL Global Forwarding can supply raw materials, re-pack them into kits and deliver them to the service requester as per the standards required by any UN Agency or Humanitarian Organization, giving priority to the local market in order to support the local Syrian families as per DHL Global Forwarding Aid & Relief policies which are in line with UN agencies and other humanitarian organizations. However, when the raw materials must be imported, DHL Global Forwarding is the most eligible company in Syria to arrange the import of such material through its worldwide network.  Kits types may include (but not limited to) the following types.\r\n\r\n        Hygiene Kits\r\n        Clothing Kits\r\n        Food Kits\r\n        Baby Kits\r\n        Plastic Sheets\r\n        School Kits\r\n\r\nMosquito Nets'),
(182, 62, 1, 1, 6, 'Aid & Relief Services 0201', 'Twin 1(1).jpg', NULL, NULL),
(183, 62, 1, 1, 6, 'Aid & Relief Services 0202', 'Twin 2(1).jpg', NULL, NULL),
(184, 63, 1, 1, 12, 'Aid & Relief Services 0401', 'Slider 1(8).jpg', NULL, NULL),
(185, 63, 2, 1, 12, 'Aid & Relief Services 0402', 'Slider 2(10).jpg', NULL, NULL),
(186, 63, 3, 1, 12, 'Aid & Relief Services 0403', 'Slider 3(10).jpg', NULL, NULL),
(187, 63, 4, 1, 12, 'Aid & Relief Services 0404', 'Slider 4(10).jpg', NULL, NULL),
(188, 63, 5, 1, 12, 'Aid & Relief Services 0405', 'Slider 5(9).jpg', NULL, NULL),
(190, 59, 2, 1, 6, 'Customs Clearance 0302', NULL, '<p style=\"text-align:center; font-size:16px\">\r\n  <strong>\r\n    Added Value Services\r\n  </strong>\r\n</p>\r\n', 'Clearing Services offered are :\r\n\r\n    Import Customs Clearance\r\n    Export Clearance\r\n    Transit Customs Clearance\r\n    Customs Approval follow up\r\n    Import License follow up\r\n    Analysis follow up\r\n    Range of additional clearance services based on shipment purpose'),
(191, 59, 4, 1, 6, 'Customs Clearance 0304', NULL, '<ul>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n   Global network of experienced customs consultants\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Established methodologies and project management skills to ensure that projects are on time, on scope and on budget\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Solutions delivered to achieve three core benefits: customs &nbsp;compliance, cost efficiency &amp; time savings\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Proven solutions based on DHL&rsquo;s experience of processing more than 7 million customs entries per year\r\n  </li>\r\n</ul>', 'Clearing Services offered are :\r\n\r\n    Import Customs Clearance\r\n    Export Clearance\r\n    Transit Customs Clearance\r\n    Customs Approval follow up\r\n    Import License follow up\r\n    Analysis follow up\r\n    Range of additional clearance services based on shipment purpose'),
(195, 25, 2, 1, 8, 'SYDI 0102', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center; font-size:20px; color:#d40511\">\r\n  SYRIAN YOUTH DEVELOPMENT INITIATIVE\r\n</p>\r\n\r\n<p style=\"text-align:center; font-size:14px\">\r\n  Due to the impacts caused by the Syrian crisis, there was a clear need to switch CSR into this phase priorities,\r\n  <br />\r\n  Syrian youth need tools to enable them enhance their knowledge and skills, which will prepare them for better future\r\n  <br />\r\n  and empower them to be part of the reconstruction of Syria; thus we launched the &ldquo;Syrian Youth Development Initiative&rdquo; in 2015.\r\n</p>\r\n', NULL),
(196, 25, 3, 1, 2, 'SYDI 0103', NULL, '<p><img alt=\"\" src=\"assets/img/icons/mi_SYDI(1).png\" style=\"max-width:100px; width:100%\" /></p>', NULL),
(197, 65, 1, 1, 6, 'SYDI 0301', 'Twin 1.jpg', NULL, NULL),
(198, 65, 2, 1, 6, 'SYDI 0302', 'Twin 2.jpg', NULL, NULL),
(199, 64, 1, 1, 12, 'SYDI 0201', NULL, '<p style=\"text-align:center\"><span style=\"font-size:16px\"><strong>The Family of University Parish</strong></span><br />\r\n<span style=\"font-size:14px\">The Family of University Parish was founded in 1968 by Father Elias Zahlawi at the Lady of Damascus Church.<br />\r\nThe Parish has adopted the theatrical works to enhance self-knowledge, ability to express and strengthen self-confidence of its members.<br />\r\nObjectives: Social discussions of life topics which university youth interested in &amp; Cultural<br />\r\nawareness of the youth and the expansion of their horizons and knowledge.<br />\r\nIn 2015 we sponsored &ldquo;The Mirror&rdquo;, a theatre play performed by &ldquo;The Lady Of Damascus Church&rdquo; Youth Team.<br />\r\nIn 2018, the 50-year-old parish family presented their new play &ldquo;Shu Shu&rdquo; to deliver their message and we were one of main sponsors.</span></p>', NULL),
(200, 19, 3, 1, 10, 'Quality Assurance 0103', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center\"><span style=\"font-size:14px\">DHL Global Forwarding Syria pushed by its faith of customer focus and customer satisfaction has established Quality Assurance Department since 2012; to ensure that the products and services provided by the company meet high quality standards and ensure the continuous improvement process of the company to exceed customer expectations.<br />\r\n<br />\r\nWe acquired the quality management system certification ISO 9001:2015 by SGS on November 2018. This certificate enforces our vision as leading logistics services provider in Syria.<br />\r\n<br />\r\nWe created internal quality audit team composed of qualified employees from different departments who are trained by SGS to perform audit based on ISO 9001:2015. The internal quality audits are conducted every quarter for all departments to ensure their total compliance to the set standards.<br />\r\n<br />\r\nWe outlined our vision, mission, and values; which explains how we strive to become and remain the first choice to our customers and what are our values in dealing our business.</span></p>', 'Nazha Logistics the Exclusive Agent of DHL Global Forwarding in Syria believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations. \r\nThe Quality Policy of Nazha Logistics indicates the basic principles that control our business and the commitment that the logistic services we provide to our customers shall be the best possible available in the market.\r\n(full quality policy is enclosed)'),
(201, 19, 4, 1, 1, 'Quality Assurance 0104', NULL, '<p></p>', 'Nazha Logistics the Exclusive Agent of DHL Global Forwarding in Syria believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations. \r\nThe Quality Policy of Nazha Logistics indicates the basic principles that control our business and the commitment that the logistic services we provide to our customers shall be the best possible available in the market.\r\n(full quality policy is enclosed)'),
(202, 19, 2, 1, 1, 'Quality Assurance 0102', NULL, NULL, 'Nazha Logistics the Exclusive Agent of DHL Global Forwarding in Syria believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations. \r\nThe Quality Policy of Nazha Logistics indicates the basic principles that control our business and the commitment that the logistic services we provide to our customers shall be the best possible available in the market.\r\n(full quality policy is enclosed)'),
(204, 63, 6, 1, 12, 'Aid & Relief Services 0406', '06 - Slider.jpg', NULL, NULL),
(205, 63, 7, 1, 12, 'Aid & Relief Services 0407', '07 - Slider.jpg', NULL, NULL),
(206, 63, 8, 1, 12, 'Aid & Relief Services 0408', '08 - Slider.jpg', NULL, NULL),
(207, 63, 9, 1, 12, 'Aid & Relief Services 0409', '09 - Slider.jpg', NULL, NULL),
(208, 63, 10, 1, 12, 'Aid & Relief Services 0410', '10 - Slider.jpg', NULL, NULL),
(209, 66, 1, 1, 12, 'Environment protection 0301', NULL, '<p style=\"text-align:center\"><span style=\"font-size:14px\">We abide by applicable environment-related laws and regulations, while responding to other social demands with which our organization agrees.<br />\r\nWe familiarize our organization and all those who work for our organization with our environmental policy and provide necessary education.<br />\r\nIn our business activities, we will prevent environmental pollution, and will make continual improvements.<br />\r\nWe aim to become a company that is open to the community and society, and we publicize this environmental policy inside and outside the company.</span></p>', NULL),
(216, 67, 1, 1, 12, 'Fairs & Events 0501', NULL, '<p style=\"text-align:center; font-size:16px\">\r\n  <strong>\r\n    Our services outside and within the exhibition site:\r\n  </strong>\r\n</p>\r\n', NULL),
(217, 67, 2, 1, 3, 'Fairs & Events 0502', NULL, '<p></p>', NULL),
(218, 67, 3, 1, 9, 'Fairs & Events 0503', NULL, '<p style=\"text-align:justify\"><span style=\"font-size:14px\">&bull; Professional transport services to and from the exhibition, for all kinds of goods by road, air and sea.<br />\r\n&bull; Customs clearance (transit, temporary entry, re-export or final entry).<br />\r\n&bull; Delivery on time to exhibition site.<br />\r\n&bull; Unpack boxes / packages and deliver them to display stands<br />\r\n&bull; Storage of packaging materials as necessary<br />\r\n&bull; Re-packaging of goods<br />\r\n&bull; All customs procedures for re-export (documents - data)<br />\r\n&bull; Return shipment to the country of origin<br />\r\n&bull; Assistance in the preparation of documents<br />\r\n&bull; Tracking throughout all stages of transport<br />\r\n&bull; Cargo insurance</span></p>', NULL),
(219, 68, 1, 1, 12, 'Contact BTNs', NULL, '<a class=\"btn ph-menu-link\" data-mid=\"203\" data-mode=\"0\" data-page=\"17\" style=\"width: 20%;background-color: #d40511; border-color: #d40511; color: #ffffff;\">Contact Us</a>\r\n&nbsp;&nbsp;&nbsp;\r\n<a class=\"btn btn-light ph-menu-link\" data-mid=\"203\" data-mode=\"0\" data-page=\"17\" style=\"width: 20%;\">Get a Quote</a>', '<a class=\"btn ph-menu-link\" data-mid=\"203\" data-mode=\"0\" data-page=\"17\" style=\"width: 20%;background-color: #d40511; border-color: #d40511; color: #ffffff;\">Contact Us</a>\r\n&nbsp;&nbsp;&nbsp;\r\n<a class=\"btn btn-light ph-menu-link\" data-mid=\"203\" data-mode=\"0\" data-page=\"17\" style=\"width: 20%;\">Get a Quote</a>'),
(220, 1, 1, 1, 1, 'Home Welcome 01', NULL, NULL, NULL),
(221, 1, 3, 1, 1, 'Home Welcome 03', NULL, '<p><img alt=\"\" src=\"assets/img/SGS_ISO-9001_TCL_HR.jpg\" style=\"width:100%; max-width: 80px;\" /></p>', '<p><img alt=\"\" src=\"assets/img/SGS_ISO-9001_TCL_HR.jpg\" style=\"width:100%; max-width: 80px;\" /></p>'),
(223, 69, 1, 1, 12, 'Complete Logistics Services Brochure', NULL, '<a href=\"http://www.dhl-sy.com/downloads/DHL Complete Logistics Services Brochure - V2.pdf\" target=\"_blank\"><img alt=\"Complete Logistics Services Brochure\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" /> Complete Logistics Services Brochure</a>', '<p><a href=\"http://www.dhl-sy.com/downloads/DHL Complete Logistics Services Brochure - V2.pdf\" target=\"_blank\"><img alt=\"Complete Logistics Services Brochure\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" /> Complete Logistics Services Brochure</a></p>'),
(229, 70, 1, 1, 12, 'Code & Vision', NULL, '<a href=\"http://www.dhl-sy.com/downloads/Nazha Logistics Code of Conduct.pdf\" target=\"_blank\"><img alt=\"Code of Conduct\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />Code of Conduct</a>&nbsp;&nbsp;&nbsp;\r\n<a href=\"http://www.dhl-sy.com/downloads/Our Vision, Mission and Values.pdf\" target=\"_blank\" style=\"padding-left:5em\"><img alt=\"Our Vision, Mission and Values\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />Our Vision, Mission and Values</a>', '<a href=\"http://www.dhl-sy.com/downloads/Nazha Logistics Code of Conduct.pdf\" target=\"_blank\"><img alt=\"Code of Conduct\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />Code of Conduct</a>&nbsp;&nbsp;&nbsp;\r\n<a href=\"http://www.dhl-sy.com/downloads/Our Vision, Mission and Values.pdf\" target=\"_blank\" style=\"padding-left:5em\"><img alt=\"Our Vision, Mission and Values\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />Our Vision, Mission and Values</a>'),
(231, 18, 4, 1, 1, 'Nazha Logistics 0104', NULL, '<p>&nbsp;</p>', NULL),
(232, 18, 6, 1, 1, 'Nazha Logistics 0106', NULL, '<p><img alt=\"\" src=\"assets/img/SGS_ISO-9001_TCL_HR.jpg\" style=\"width:100%; max-width: 150px;\" /></p>', NULL),
(235, 18, 5, 1, 10, 'Nazha Logistics 0105', NULL, '<p style=\"text-align:center\"><span style=\"font-size:14px\">We signify the &ldquo;One Stop Shopping&rdquo; concept with the full range of logistic products we provide starting from<br />\r\nthe basic conventional freight services fulfilling the small customers demand up to the most complicated<br />\r\n&ldquo;Customer Program Management&rdquo; systems which we provide to our Multi National Customers.</span></p>', 'Nazha Logistics is the Exclusive Agent of DHL Global Forwarding / DHL Freight in Syria and the logistics market leader locally.\r\nDHL is present in over 220 countries and territories across the globe, making it the most international company in the world.\r\nWith a workforce exceeding 350,000 employees, DHL provides solutions for an almost infinite number of logistics needs.\r\n\r\nWe signify the “One Stop Shopping” concept with the full range of logistic products we provide starting from\r\nthe basic conventional freight services fulfilling the small customers demand up to the most complicated\r\n“Customer Program Management” systems which we provide to our Multi National Customers.'),
(236, 12, 6, 1, 12, 'Warehousing 0305', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center\"><span style=\"font-size:16px\"><span><strong>Inventory Optimization</strong></span></span><br />\r\n<span style=\"font-size:14px\"><span>Through effective inventory management, inefficiencies can be driven out of the supply chain, overall costs reduced and high service levels achieved. We optimize inventory at a line-item level at every stage of the supply chain.</span></span><br />\r\n&nbsp;</p>\r\n\r\n<p style=\"text-align:center\"><span style=\"font-size:16px\"><strong><span >Multi-Customer Warehousing</span></strong></span><br />\r\n<span style=\"font-size:14px\"><span>Our shared-user facilities are designed to meet the needs of any customer for consumer products, industrial equipment, chemicals and technology.<br />\r\nThrough sharing of DHL\'s resources, such as space, labor, equipment and transportation, customers benefit from synergies that considerably reduce supply chain costs.<br />\r\nThis environment returns significant value to a small business requiring distribution operations without long term lease or capital commitments, or a large enterprise handling a new acquisition, product launches or seasonal overflow</span></span></p>', NULL),
(237, 12, 4, 1, 4, 'Warehousing 010203', NULL, '<ul>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    HSE needs\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Warehouse Management System (WMS)\r\n  </li>\r\n  <li style=\"text-align:left; font-size:14px\">\r\n    Insurance coverage\r\n  </li>\r\n</ul>\r\n', 'We offer warehouse management at any location in the country based on customer requirements.\r\nDHL Global Forwarding Damascus Logistics Facility:\r\nLocated 7 KM from Damascus Airport and 23 KM from Damascus city center.\r\nTotal Land area: 110,000 sqm, out of which 40,000 sqm are encircled by a 3.5 m high fence; this part contains the present warehouses and offices. \r\nTotal Warehouses Space:  5,000 sqm of fully equipped warehouses that will be extended to 14,000 sqm in phase two.\r\nFacility specifications and equipment:\r\n•	Fire alerts, protection and escape routes\r\n•	Security guards \r\n•	Material Handling Equipment\r\n•	Racking & Shelving\r\n•	HSE needs\r\n•	Warehouse Management System (WMS)\r\n•	Insurance coverage\r\n\r\nOur Warehousing Solutions improve inventory efficiency and accelerate your response to changing customer demand. Our experts design, implement, and operate flexible warehousing and distribution solutions tailored to your business needs. They analyze every point in your supply chain to determine the optimal solution.\r\n•	Dedicated Warehouses \r\n•	Multi Customer Warehousing \r\n•	Ambient and temperature-controlled facilities\r\n•	Storage, pick, pack and dispatch\r\n•	Delivery and returns management\r\n\r\nInventory Optimization\r\nThrough effective inventory management, inefficiencies can be driven out of the supply chain, overall costs reduced and high service levels achieved. We optimize inventory at a line-item level at every stage of the supply chain.\r\n\r\nMulti-Customer Warehousing\r\nOur shared-user facilities are designed to meet the needs of any customer for consumer products, industrial equipment, chemicals and technology.\r\nThrough sharing of DHL\'s resources, such as space, labor, equipment and transportation, customers benefit from synergies that considerably reduce supply chain costs.\r\nThis environment returns significant value to a small business requiring distribution operations without long term lease or capital commitments, or a large enterprise handling a new acquisition, product launches or seasonal overflow'),
(240, 19, 7, 1, 1, 'Quality Assurance 0107', NULL, '<p><img alt=\"\" src=\"assets/img/SGS_ISO-9001_TCL_HR.jpg\" style=\"width:100%; max-width: 80px;\" /></p>', 'Nazha Logistics the Exclusive Agent of DHL Global Forwarding in Syria believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations. \r\nThe Quality Policy of Nazha Logistics indicates the basic principles that control our business and the commitment that the logistic services we provide to our customers shall be the best possible available in the market.\r\n(full quality policy is enclosed)'),
(241, 19, 5, 1, 1, 'Quality Assurance 0105', NULL, '<p></p>', 'Nazha Logistics the Exclusive Agent of DHL Global Forwarding in Syria believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations. \r\nThe Quality Policy of Nazha Logistics indicates the basic principles that control our business and the commitment that the logistic services we provide to our customers shall be the best possible available in the market.\r\n(full quality policy is enclosed)'),
(243, 19, 6, 1, 10, 'Quality Assurance 0106', NULL, '<p style=\"margin-left:0cm; margin-right:0cm; text-align:center\"><span style=\"font-size:14px\">Quality, Environmental, and Occupational Health &amp; Safety Policies are established, implemented, and monitored for providing best services to our customers without neglecting environmental, health, and safety aspects.</span></p>', 'Nazha Logistics the Exclusive Agent of DHL Global Forwarding in Syria believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations. \r\nThe Quality Policy of Nazha Logistics indicates the basic principles that control our business and the commitment that the logistic services we provide to our customers shall be the best possible available in the market.\r\n(full quality policy is enclosed)'),
(244, 19, 8, 1, 12, 'Quality Assurance 0108', NULL, '<a href=\"http://www.dhl-sy.com/downloads/ISO Certificate.pdf\" target=\"_blank\"><img alt=\"ISO Certificate\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;ISO 9001:2015 Certificate</a>', '<a href=\"http://www.dhl-sy.com/downloads/ISO Certificate.pdf\" target=\"_blank\"><img alt=\"ISO Certificate\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;ISO 9001:2015 Certificate</a>'),
(245, 19, 9, 1, 12, 'Quality Assurance 0109', NULL, '<div class=\"row p-5\">\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Nazha Logistics Code of Conduct.pdf\" target=\"_blank\">\r\n<img alt=\"Code of Conduct\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Code of Conduct\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Our Vision, Mission and Values.pdf\" target=\"_blank\">\r\n<img alt=\"Our Vision, Mission and Values\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Our Vision, Mission and Values\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Quality Policy.pdf\" target=\"_blank\">\r\n<img alt=\"Quality Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Quality Policy\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Environmental Policy.pdf\" target=\"_blank\">\r\n<img alt=\"Environmental Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Environmental Policy\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Occupational Health and Safety Policy.pdf\" target=\"_blank\">\r\n<img alt=\"Occupational Health and Safety Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Occupational Health and Safety Policy\r\n</a>\r\n</div>\r\n\r\n</div>', '<div class=\"row p-5\">\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Nazha Logistics Code of Conduct.pdf\" target=\"_blank\">\r\n<img alt=\"Code of Conduct\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Code of Conduct\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Our Vision, Mission and Values.pdf\" target=\"_blank\">\r\n<img alt=\"Our Vision, Mission and Values\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Our Vision, Mission and Values\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Quality Policy.pdf\" target=\"_blank\">\r\n<img alt=\"Quality Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Quality Policy\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Environmental Policy.pdf\" target=\"_blank\">\r\n<img alt=\"Environmental Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Environmental Policy\r\n</a>\r\n</div>\r\n\r\n<div class=\"col-4 text-center p-3\">\r\n<a href=\"http://www.dhl-sy.com/downloads/Occupational Health and Safety Policy.pdf\" target=\"_blank\">\r\n<img alt=\"Occupational Health and Safety Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Occupational Health and Safety Policy\r\n</a>\r\n</div>\r\n\r\n</div>'),
(246, 66, 2, 1, 12, 'Environment protection 0302', NULL, '<a href=\"http://www.dhl-sy.com/downloads/Environmental Policy.pdf\" target=\"_blank\"><img alt=\"Environmental Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Environmental Policy</a>', '<a href=\"http://www.dhl-sy.com/downloads/Environmental Policy.pdf\" target=\"_blank\"><img alt=\"Environmental Policy\" src=\"assets/img/PDF Icon.png\" style=\"width:25px\" />&nbsp;&nbsp;Environmental Policy</a>'),
(247, 1, 0, 1, 12, 'Home Welcome 00', NULL, '<p><br/></p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_menu`
--

DROP TABLE IF EXISTS `cpy_menu`;
CREATE TABLE IF NOT EXISTS `cpy_menu` (
  `menu_id` int(11) NOT NULL,
  `menu_pid` int(11) NOT NULL,
  `menu_rid` int(11) NOT NULL,
  `mode_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT '0',
  `srch_id` int(11) NOT NULL DEFAULT '1',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `menu_status` smallint(6) NOT NULL DEFAULT '1',
  `menu_name` varchar(200) NOT NULL,
  `menu_icon` varchar(50) DEFAULT NULL,
  `page_id` int(11) NOT NULL DEFAULT '0',
  `menu_href` varchar(200) NOT NULL DEFAULT '#',
  PRIMARY KEY (`menu_id`),
  KEY `page_id` (`page_id`),
  KEY `menu_pid` (`menu_pid`),
  KEY `mode_id` (`mode_id`),
  KEY `type_id` (`type_id`),
  KEY `srch_id` (`srch_id`),
  KEY `menu_rid` (`menu_rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_menu`
--

INSERT INTO `cpy_menu` (`menu_id`, `menu_pid`, `menu_rid`, `mode_id`, `type_id`, `srch_id`, `menu_order`, `menu_status`, `menu_name`, `menu_icon`, `page_id`, `menu_href`) VALUES
(0, 0, 0, 0, 0, 1, 0, 1, 'Menu', '', 0, '#'),
(100, 0, 0, 0, 0, 1, 0, 1, 'Main Menu - Left', '', 0, '#'),
(101, 100, 0, 0, 11, 1, 1, 1, 'Products & Solutions', '', 0, '#'),
(102, 100, 0, 0, 11, 1, 2, 1, 'Social Responsibility', '', 0, '#'),
(103, 100, 0, 0, 11, 1, 3, 1, 'About Us', '', 0, '#'),
(200, 0, 0, 0, 0, 1, 0, 1, 'Main Menu - Right', '', 0, '#'),
(201, 200, 0, 0, 1, 1, 1, 0, 'Arabic / العربية', '', 0, '#'),
(202, 200, 0, 0, 13, 1, 2, 1, 'Services A-Z', '', 0, '#'),
(203, 200, 0, 0, 1, 1, 3, 1, 'Contact Us', '', 17, '#'),
(10101, 101, 0, 0, 1, 1, 1, 1, 'Air Freight', 'mi_Air.png', 1, '#'),
(10102, 101, 0, 0, 1, 1, 2, 1, 'Ocean Freight', 'mi_Ocean.png', 2, '#'),
(10103, 101, 0, 0, 1, 1, 3, 1, 'Road Freight', 'mi_Road.png', 3, '#'),
(10104, 101, 0, 0, 1, 1, 4, 1, 'Custom Clearance', 'mi_Custom.png', 5, '#'),
(10105, 101, 0, 0, 1, 1, 5, 1, 'Warehousing', 'mi_Wherehouse.png', 6, '#'),
(10106, 101, 0, 0, 1, 1, 6, 1, 'Projects', 'mi_Projects.png', 8, '#'),
(10107, 101, 0, 0, 1, 1, 7, 1, 'Fairs & Events', 'mi_FaE.png', 9, '#'),
(10108, 101, 0, 0, 1, 1, 8, 1, 'Packing & Removal', 'mi_PaR.png', 7, '#'),
(10109, 101, 0, 0, 1, 1, 9, 1, 'Aid & Relief Services', 'mi_Aid.png', 10, '#'),
(10110, 101, 0, 0, 1, 1, 10, 1, 'Multimodal Transport', 'mi_Multimodal.png', 4, '#'),
(10111, 101, 0, 0, 1, 1, 11, 1, 'Insurance', 'mi_Insurance.png', 16, '#'),
(10201, 102, 0, 0, 1, 1, 1, 1, 'Environment protection', 'mi_Leaves.png', 11, '#'),
(10202, 102, 0, 0, 1, 1, 2, 1, 'Culture Support', 'mi_Culture.png', 12, '#'),
(10203, 102, 0, 0, 1, 1, 3, 1, 'Syrian Youth Development initiative', 'mi_SYDI(1).png', 13, '#'),
(10301, 103, 0, 0, 1, 1, 1, 1, 'Nazha Logistics', 'mi_Nazha_Logistics.png', 14, '#'),
(10302, 103, 0, 0, 1, 1, 2, 1, 'Quality Assurance', 'mi_Quality.png', 15, '#'),
(202011, 202, 0, 0, 0, 2, 1, 1, 'A-L', '', 0, '#'),
(202013, 202, 0, 0, 0, 2, 3, 1, 'M-Z', '', 0, '#'),
(20201101, 202011, 10109, 0, 1, 2, 1, 1, 'Aid & Relief Services', '', 10, '#'),
(20201102, 202011, 10101, 0, 1, 2, 2, 1, 'Air Freight Export', '', 1, '#'),
(20201103, 202011, 10101, 0, 1, 2, 3, 1, 'Air Freight Import', '', 1, '#'),
(20201104, 202011, 10104, 0, 1, 2, 4, 1, 'Customs Clearance - Transit', '', 5, '#'),
(20201105, 202011, 10104, 0, 1, 2, 5, 1, 'Customs Clearace  - Final', '', 5, '#'),
(20201106, 202011, 10107, 0, 1, 2, 6, 1, 'Fairs & Events - Local', '', 9, '#'),
(20201107, 202011, 10107, 0, 1, 2, 7, 1, 'Fairs & Events - International', '', 9, '#'),
(20201201, 202011, 10111, 0, 1, 2, 8, 1, 'Insurance', '', 16, '#'),
(20201301, 202013, 10102, 0, 1, 2, 1, 1, 'Ocean Freight Export', '', 2, '#'),
(20201302, 202013, 10102, 0, 1, 2, 2, 1, 'Ocean Freight Import', '', 2, '#'),
(20201303, 202013, 10108, 0, 1, 2, 3, 1, 'Packing & Removal - Local', '', 7, '#'),
(20201304, 202013, 10108, 0, 1, 2, 4, 1, 'Packing & Removal - International', '', 7, '#'),
(20201305, 202013, 10106, 0, 1, 2, 5, 1, 'Projects', '', 8, '#'),
(20201306, 202013, 10103, 0, 1, 2, 6, 1, 'Raod Freight - Import', '', 3, '#'),
(20201307, 202013, 10103, 0, 1, 2, 7, 1, 'Raod Freight - Export', '', 3, '#'),
(20201308, 202013, 10103, 0, 1, 2, 8, 1, 'Road Freight - Local', '', 3, '#'),
(20201309, 202013, 10103, 0, 1, 2, 9, 1, 'Raod-Air', '', 3, '#'),
(20201310, 202013, 10102, 0, 1, 2, 10, 1, 'Sea-Air', '', 2, '#'),
(20201401, 202013, 10105, 0, 1, 2, 11, 1, 'Warehousing - Dedicated', '', 6, '#'),
(20201402, 202013, 10105, 0, 1, 2, 12, 1, 'Warehousing - Multi Customer', '', 6, '#');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_menu_mode`
--

DROP TABLE IF EXISTS `cpy_menu_mode`;
CREATE TABLE IF NOT EXISTS `cpy_menu_mode` (
  `mode_id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_name` varchar(200) NOT NULL,
  PRIMARY KEY (`mode_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_menu_mode`
--

INSERT INTO `cpy_menu_mode` (`mode_id`, `mode_name`) VALUES
(0, 'Page');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_menu_search`
--

DROP TABLE IF EXISTS `cpy_menu_search`;
CREATE TABLE IF NOT EXISTS `cpy_menu_search` (
  `srch_id` int(11) NOT NULL AUTO_INCREMENT,
  `srch_name` varchar(200) NOT NULL,
  PRIMARY KEY (`srch_id`),
  UNIQUE KEY `srch_name` (`srch_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_menu_search`
--

INSERT INTO `cpy_menu_search` (`srch_id`, `srch_name`) VALUES
(2, 'No'),
(1, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_menu_type`
--

DROP TABLE IF EXISTS `cpy_menu_type`;
CREATE TABLE IF NOT EXISTS `cpy_menu_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(200) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_menu_type`
--

INSERT INTO `cpy_menu_type` (`type_id`, `type_name`) VALUES
(0, 'Menu'),
(1, 'Page'),
(11, 'Page with Icons'),
(12, 'Classic'),
(13, 'Page Columns');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_news`
--

DROP TABLE IF EXISTS `cpy_news`;
CREATE TABLE IF NOT EXISTS `cpy_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_status` smallint(6) NOT NULL DEFAULT '1',
  `type_id` int(11) NOT NULL,
  `news_date` date NOT NULL,
  `news_title` varchar(200) NOT NULL,
  `news_stext` text,
  `news_image` varchar(200) NOT NULL,
  `news_text` text NOT NULL,
  PRIMARY KEY (`news_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_news`
--

INSERT INTO `cpy_news` (`news_id`, `news_status`, `type_id`, `news_date`, `news_title`, `news_stext`, `news_image`, `news_text`) VALUES
(2, 1, 2, '2018-05-10', 'Participation at \"Techno Build” Exhibition 2018', NULL, 'img2.jpg', '<p style=\"text-align:justify; padding: 25px;\">DHL Global Forwarding Syria participated in &quot;Techno Build&rdquo; Exhibition that was organized by Tayara Establishment for Exhibitions and Conferences at Damascus Fairgrounds from 10 to 14 May 2018. The exhibition included more than 80 Syrian and International Exhibitors from several construction and re-building companies. Represented by its exclusive agent in Syria, Nazha Logistics, DHL Global Forwarding participation in this exhibition came as it is one of the biggest international companies that support and develop construction by providing comprehensive, smart and flexible logistics solutions through its dedicated team of specialized experts and worldwide network</p>\r\n\r\n<p style=\"text-align:center\">May 2018</p>'),
(3, 1, 1, '2018-11-01', 'DHL Global Forwarding Syria acquiring the ISO 9001:2015', NULL, 'News - ISO Slider Cover.jpg', '<p style=\"margin-left:0cm; margin-right:0cm; padding: 25px; text-align:justify\"><span style=\"font-size:16px\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Nazha Logistics - DHL Global Forwarding Exclusive Agent in Syria, has acquired the quality management system certification ISO 9001:2015 by SGS. This certificate enforces our vision as leading logistics services provider in Syria. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:9.0pt\">November 2018</span></span></span></p>'),
(4, 1, 1, '2019-02-05', 'DHL Global Forwarding Syria winning the “Best Agency Award', NULL, 'News - Best Agency Slider Cover.jpg', '<p style=\"margin-left:0cm; margin-right:0cm; padding: 25px; text-align:justify\"><span style=\"font-size:16px\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">We attended the DHL Global Forwarding MEA Annual Conference held in Dubai from 3 &ndash; 5 February 2019. During the conference, we were awarded as the &ldquo;Best Agent&rdquo; in Middle East and Africa Division. This award has opened for us new horizons and more responsibilities.&nbsp; </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:9.0pt\">February 2019</span></span></span></p>'),
(5, 1, 2, '2019-02-20', 'Company’s Awards Ceremony 2018', NULL, 'News - Awards Ceremony Slider Cover.jpg', '<p style=\"margin-left:0cm; margin-right:0cm; padding: 25px; text-align:justify\"><span style=\"font-size:16px\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">The Company held its annual Award Ceremony for the outstanding employees in 2018 and for the employees who achieved 10 and 15 years of service. During the ceremony, 2019 work plan was reviewed, and thereafter, the certificates of appreciation and prizes were distributed to the honored staff. </span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:center\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:9.0pt\">February 2019</span></span></span></p>'),
(6, 1, 2, '2019-04-23', 'Participation at “ME Build Show” 2019', 'Participation at “ME Build Show” 2019\r\n\r\n \r\n\r\nThe Company participated at the ME Build Show held from 23-27 April 2019 as the exclusive forwarder and logistic services provider. Organized by Tayara for International Exhibitions & Conferences, this trade show was part of 3 additional shows related to re-building. Our participation in this edition was huge, split into 4 vital locations over the venue.  \r\n\r\n \r\n\r\nApril 2019', 'Activities - ME Build Show Slider Cover.jpg', '<p style=\"text-align:justify\"><span style=\"color:#222222; font-family:Arial,Helvetica,sans-serif; font-size:small\">The Company participated at the ME Build Show held from 23-27 April 2019 as the exclusive forwarder and logistic services provider. Organized by Tayara for International Exhibitions &amp; Conferences, this trade show was part of 3 additional shows related to re-building. Our participation in this edition was huge, split into 4 vital locations over the venue. &nbsp;</span></p>'),
(7, 1, 2, '2019-05-01', 'Participation at “Syria Health 2019”', 'Participation at “Syria Health 2019”\r\n\r\n \r\n\r\nThe “Syria Health Exhibition”, organized by Expo Cham was successful as a first edition with promising foreign participations. DHL Global Forwarding Syria’s team presented on site all our logistic services to exhibitors and visitors.', 'Activities - Syria Health Slider Cover.jpg', '<p style=\"text-align:justify\"><span style=\"color:#222222; font-family:Arial,Helvetica,sans-serif; font-size:small\">The &ldquo;Syria Health Exhibition&rdquo;, organized by Expo Cham was successful as a first edition with promising foreign participations. DHL Global Forwarding Syria&rsquo;s team presented on site all our logistic services to exhibitors and visitors.</span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_news_images`
--

DROP TABLE IF EXISTS `cpy_news_images`;
CREATE TABLE IF NOT EXISTS `cpy_news_images` (
  `nimg_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `nimg_order` smallint(6) NOT NULL DEFAULT '0',
  `nimg_photo` varchar(200) NOT NULL,
  PRIMARY KEY (`nimg_id`),
  KEY `news_id` (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_news_images`
--

INSERT INTO `cpy_news_images` (`nimg_id`, `news_id`, `nimg_order`, `nimg_photo`) VALUES
(3, 3, 1, 'News - ISO Slider 01.jpg'),
(4, 3, 2, 'News - ISO Slider 02.jpg'),
(5, 5, 1, 'News - Awards Ceremony Slider 01.jpg'),
(6, 5, 2, 'News - Awards Ceremony Slider 02.jpg'),
(7, 5, 3, 'News - Awards Ceremony Slider 03.jpg'),
(8, 6, 1, 'Activities - ME Build Show popup Slider 01.jpg'),
(9, 6, 2, 'Activities - ME Build Show popup Slider 02.jpg'),
(10, 6, 3, 'Activities - ME Build Show popup Slider 03.jpg'),
(11, 6, 5, 'Activities - ME Build Show popup Slider 05.jpg'),
(12, 6, 4, 'Activities - ME Build Show popup Slider 04.jpg'),
(13, 6, 6, 'Activities - ME Build Show popup Slider 06.jpg'),
(14, 6, 7, 'Activities - ME Build Show popup Slider 07.jpg'),
(15, 7, 1, 'Activities - Syria Health popup Slider 01.jpg'),
(16, 7, 2, 'Activities - Syria Health popup Slider 02.jpg'),
(17, 7, 3, 'Activities - Syria Health popup Slider 03.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_news_type`
--

DROP TABLE IF EXISTS `cpy_news_type`;
CREATE TABLE IF NOT EXISTS `cpy_news_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_news_type`
--

INSERT INTO `cpy_news_type` (`type_id`, `type_name`) VALUES
(2, 'Activity'),
(1, 'News');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_page`
--

DROP TABLE IF EXISTS `cpy_page`;
CREATE TABLE IF NOT EXISTS `cpy_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(200) NOT NULL,
  `page_status` smallint(6) NOT NULL DEFAULT '1',
  `slid_id` int(11) NOT NULL DEFAULT '1',
  `page_stext` text,
  `page_desc` text,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_name` (`page_name`),
  KEY `slid_id` (`slid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_page`
--

INSERT INTO `cpy_page` (`page_id`, `page_name`, `page_status`, `slid_id`, `page_stext`, `page_desc`) VALUES
(0, 'Home Page', 1, 1, 'Home Page', 'Home Page'),
(1, 'Air Freight', 1, 2, 'Air Freight', 'Airfreight Export and Airfreight Import are products that predominately use air mode and offers a choice in delivery speeds to best suit customer requirements....'),
(2, 'Ocean Freight', 1, 4, 'Ocean Freight', '<p><strong><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Ocean Freight Export and Ocean Freight Import</span></span></strong><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">; with our broad range of Ocean Freight products covering different equipment types and consolidation services, we ensure your cargo reaches the right place, at the right time in a cost-efficient way. We work with a spread of ocean carriers covering major carrier alliances with planned space protection from every major container port in the world to deliver reliability...</span></span></p>'),
(3, 'Road Freight', 1, 6, 'Road Freight', '<p><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">We provide Road Freight Import, Export and within the country regular transportation (with a range of additional services), giving you truly extensive coverage at domestic and international level. With our dispatch flexibility and long term co-operation with trucking specialists, DHL Freight handles regular part loads, as well as full loads, safely and punctually in all directions...</span></span></p>'),
(4, 'Multimodal Transport', 1, 13, 'Multimodal Transport', '<p><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Road-Air and Ocean-Air Combing the speed of air freight with the economy of ocean freight / road freight we offer faster transit times at a considerably lower cost and lower carbon footprint than pure air freight.<br />\r\nEnsuring cargo remains in DHL&rsquo;s control at all times, this product offers a multi-modal service...</span></span></p>'),
(5, 'Customs Clearance', 1, 16, 'Customs Clearance', '<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:12pt\"><span style=\"font-family:&quot;Times New Roman&quot;,serif\"><strong><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">We have long experience in customs clearance we handle clearance at </span></strong></span></span></p>\r\n\r\n<ul style=\"list-style-type:square\">\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"background-color:white\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Airports</span></span></span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"background-color:white\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Ports</span></span></span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"background-color:white\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Cross borders</span></span></span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"background-color:white\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Customs secretariats </span></span></span></span></span></li>\r\n</ul>\r\n\r\n<p><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Free Zones.</span></span></p>'),
(6, 'Warehousing', 1, 5, 'Warehousing', '<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:12pt\"><span style=\"font-family:&quot;Times New Roman&quot;,serif\"><strong><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">We offer warehouse management at any location in the country based on customer requirements.</span></strong></span></span></p>\r\n\r\n<p><span style=\"font-size:11.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">DHL Global Forwarding Damascus Logistics Facility:<br />\r\nLocated 7 KM from Damascus Airport and 23 KM from Damascus city center.<br />\r\nTotal Land area: 110,000 sqm, out of which 40,000 sqm are encircled by a 3.5 m high fence; this part contains the present warehouses and offices...</span></span></p>'),
(7, 'Packing & Removal', 1, 8, 'Packing & Removal', '<p style=\"margin-left:0cm; margin-right:36pt; text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Our mission is turning your Packing &amp; Removal experience into an exciting, enjoyable and Stress Free task.<br />\r\nOne stop shopping point as follows:</span></span></span></p>\r\n\r\n<ul>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Packing</span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Storage </span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Customs Clearance</span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Shipping Services: Airfreight, Ocean Freight and Road Freight</span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Destination Services </span></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Unpacking and removal of debris....</span></span></span></li>\r\n</ul>'),
(8, 'Projects', 1, 7, 'Projects', '<p><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">DHL understands the unique logistics challenges related to projects shipments. We provide a range of services that help align logistics operations with your business strategies. Our processes, technology and people drive cost and capital out of your operations, whilst ensuring consistent and predictable service...</span></span></p>'),
(9, 'Fairs & Events', 1, 11, 'Fairs & Events', '<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:12pt\"><span style=\"font-family:&quot;Times New Roman&quot;,serif\"><strong><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">We offer complete logistics services for both Fairs &amp; Events Organizers and Clients.</span></strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><strong>Infrastructure</strong></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm; text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">We accompany you! Wherever your customers and suppliers need us - we are already there </span></span></p>\r\n\r\n<ul>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Our <strong>specialists</strong> are located around the globe and support you at <strong>every location worldwide</strong></span></span></li>\r\n	<li style=\"text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Organizers and venues worldwide <strong>trust</strong> in us and appoint DHL as <strong>official forwarder</strong></span></span></li>\r\n	<li style=\"text-align:left\"><strong><span style=\"font-size:11.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Dedicated network </span></span></strong><span style=\"font-size:11.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">of experienced operations personnel</span></span></li>\r\n</ul>'),
(10, 'Aid & Relief Services', 1, 17, 'Aid & Relief Services', '<p><strong><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Due to the need of logistics services for the humanitarian aid across the country, DHL Global Forwarding -Syria set up a department under the name of Aid &amp; Relief Services responsible for the Humanitarian Aid Logistics within Syria through the following services...</span></span></strong></p>'),
(11, 'Environment protection', 1, 10, 'Environment protection', '<p><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Committed to sustainable development, we create innovative, effective, environmentally friendly logistics services that fulfill customer\'s needs, while minimizing undesirable impacts</span></span></p>'),
(12, 'Culture Support', 1, 9, 'Culture Support', '<p><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">DHL Global Forwarding Syria has launched its project of sponsoring, encouraging and spreading Culture in all its aspects in Syria</span></span></p>'),
(13, 'Syrian Youth Development Initiative', 1, 3, 'Syrian Youth Development Initiative', '<p><span style=\"font-size:11.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Due to the impacts caused by the Syrian crisis, there was a clear need to switch CSR into this phase priorities, Syrian youth need tools to enable them enhance their knowledge and skills, which will prepare them for better future and empower them to be part of the reconstruction of Syria; thus we launched the &ldquo;<strong>Syrian Youth Development Initiative&rdquo;...</strong></span></span></p>'),
(14, 'Nazha Logistics', 1, 14, 'Nazha Logistics', '<p style=\"margin-left:0cm; margin-right:36pt; text-align:left\"><span style=\"font-size:11pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\"><span style=\"font-size:12.0pt\">Nazha Logistics is the Exclusive Agent of DHL Global Forwarding / DHL Freight in Syria and the logistics market leader locally. </span></span></span></p>\r\n\r\n<p><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">DHL is present in over 220 countries and territories across the globe, making it the most international company in the world. With a workforce exceeding 350,000 employees, DHL provides solutions for an almost infinite number of logistics needs...</span></span></p>'),
(15, 'Quality Assurance', 1, 15, 'Quality Assurance', '<p><span style=\"font-size:12.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Nazha Logistics the Exclusive Agent of DHL Global Forwarding<span style=\"background-color:white\"> in Syria </span>believes that success depends on the supply of high quality logistic services that meet or exceed customer expectations...</span></span></p>'),
(16, 'Insurance', 1, 12, 'Insurance', '<p><span style=\"font-size:10.0pt\"><span style=\"font-family:&quot;Arial&quot;,sans-serif\">Insurance services that offer our customers financial protection against all risks of physical loss or damage from any external cause such as fire, storms, thunderbolts and other standard insured risks for the total amount of the stored materials...</span></span></p>'),
(17, 'Contact Us', 1, 1, 'Contact Us', '<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:12pt\"><span style=\"font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-size:9.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Nazha Logistics LLC - Exclusive Agent of DHL Global Forwarding in Syria.</span></span></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:12pt\"><span style=\"font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-size:9.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Sabbagh Building, Victoria Bridge. </span></span></span></span></p>\r\n\r\n<p style=\"margin-left:0cm; margin-right:0cm\"><span style=\"font-size:12pt\"><span style=\"font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-size:9.0pt\"><span style=\"font-family:&quot;Calibri&quot;,sans-serif\">Damascus &ndash; Syria. </span></span></span></span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `cpy_page_block`
--

DROP TABLE IF EXISTS `cpy_page_block`;
CREATE TABLE IF NOT EXISTS `cpy_page_block` (
  `pblk_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `blk_id` int(11) NOT NULL,
  `pblk_status` smallint(6) NOT NULL DEFAULT '1',
  `pblk_order` smallint(6) NOT NULL DEFAULT '0',
  `pblk_name` varchar(200) NOT NULL,
  `pblk_bgcolor` varchar(50) DEFAULT NULL,
  `pblk_stext` text,
  PRIMARY KEY (`pblk_id`),
  UNIQUE KEY `pblk_name` (`page_id`,`pblk_name`),
  KEY `blk_id` (`blk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_page_block`
--

INSERT INTO `cpy_page_block` (`pblk_id`, `page_id`, `blk_id`, `pblk_status`, `pblk_order`, `pblk_name`, `pblk_bgcolor`, `pblk_stext`) VALUES
(1, 0, 1, 1, 1, 'Welcome Message', '0', NULL),
(2, 0, 4, 1, 2, 'Home Wide Image 11-2018', '0', NULL),
(4, 0, 2, 1, 3, 'About', '0', NULL),
(5, 0, 5, 1, 4, 'News', '#CECECE', NULL),
(8, 1, 7, 1, 1, 'Air Freight 01', '0', NULL),
(9, 2, 8, 1, 1, 'Ocean Freight 01', '0', NULL),
(10, 3, 9, 1, 1, 'Road Freight 01', '0', NULL),
(11, 4, 10, 1, 1, 'Multimodal Transport 01', '0', NULL),
(12, 5, 11, 1, 1, 'Customs Clearance', '0', NULL),
(13, 6, 12, 1, 4, 'Warehousing 03', '#CECECE', NULL),
(14, 7, 13, 1, 1, 'Packing & Removal 01', '0', 'Packing & Removal'),
(15, 8, 14, 1, 1, 'Projects 01', '0', NULL),
(16, 9, 15, 1, 1, 'Fairs & Events 01', '0', 'Fairs & Events'),
(17, 10, 16, 1, 1, 'Aid & Relief Services 01', '0', 'Aid & Relief Services'),
(18, 11, 45, 1, 1, 'Environment protection 01', '0', NULL),
(19, 12, 43, 1, 1, 'Culture Support 01', '0', NULL),
(21, 14, 18, 1, 3, 'Nazha Logistics 03', '0', 'Nazha Logistics'),
(22, 15, 19, 1, 1, 'Quality Assurance 01', '0', 'Quality Assurance'),
(23, 16, 20, 1, 1, 'Insurance 01', '0', NULL),
(24, 17, 21, 1, 1, 'Contact Us', '0', 'Contact Us'),
(25, 1, 23, 1, 3, 'Air Freight 02', '0', NULL),
(26, 1, 22, 1, 4, 'Air Freight 03', '#CECECE', NULL),
(27, 1, 24, 1, 6, 'Air Freight 04', '0', NULL),
(28, 13, 25, 1, 1, 'SYDI 01', '0', NULL),
(29, 13, 26, 1, 6, 'SYDI 06', '#CECECE', NULL),
(30, 13, 27, 1, 7, 'SYDI 07', '0', NULL),
(31, 13, 28, 1, 4, 'SYDI 04', '#CECECE', NULL),
(32, 13, 29, 1, 5, 'SYDI 05', '0', NULL),
(33, 2, 30, 0, 2, 'Ocean Freight 02', '0', NULL),
(34, 2, 31, 1, 4, 'Ocean Freight 03', '0', NULL),
(35, 2, 32, 1, 5, 'Ocean Freight 04', '#CECECE', NULL),
(36, 3, 33, 1, 4, 'Road Freight 03', '#CECECE', NULL),
(38, 6, 35, 1, 3, 'Warehousing 02', '0', NULL),
(39, 6, 36, 1, 1, 'Warehousing 01', '0', NULL),
(40, 6, 37, 1, 6, 'Warehousing 04', '0', NULL),
(41, 7, 39, 1, 3, 'Packing & Removal 02', '0', NULL),
(42, 7, 38, 1, 4, 'Packing & Removal 03', '#CECECE', NULL),
(43, 8, 40, 1, 3, 'Projects 02', '0', NULL),
(44, 8, 41, 1, 4, 'Projects 03', '#CECECE', NULL),
(45, 3, 42, 1, 3, 'Road Freight 02', '0', NULL),
(46, 12, 44, 1, 2, 'Culture Support 02', '0', NULL),
(47, 11, 46, 1, 2, 'Environment protection 02', '0', NULL),
(48, 9, 47, 1, 2, 'Fairs & Events 02', '0', NULL),
(49, 9, 48, 1, 3, 'Fairs & Events 03', '0', NULL),
(50, 9, 49, 1, 4, 'Fairs & Events 04', '0', NULL),
(51, 16, 50, 1, 2, 'Insurance 02', '0', NULL),
(52, 4, 51, 1, 3, 'Multimodal Transport 02', '0', NULL),
(53, 4, 52, 1, 4, 'Multimodal Transport 03', '#CECECE', NULL),
(54, 14, 53, 1, 2, 'Nazha Logistics 02', '0', NULL),
(55, 14, 54, 1, 1, 'Nazha Logistics 01', '0', NULL),
(56, 14, 55, 1, 5, 'Nazha Logistics 04', '0', NULL),
(57, 14, 56, 1, 6, 'Nazha Logistics 05', '#CECECE', NULL),
(58, 15, 57, 1, 2, 'Quality Assurance 02', '0', NULL),
(59, 5, 58, 1, 3, 'Customs Clearance 02', '0', NULL),
(60, 5, 59, 1, 4, 'Customs Clearance 03', '#CECECE', NULL),
(61, 5, 60, 1, 6, 'Customs Clearance 04', '0', NULL),
(62, 10, 62, 1, 2, 'Aid & Relief Services 02', '0', NULL),
(63, 10, 61, 1, 3, 'Aid & Relief Services 03', '0', NULL),
(64, 10, 63, 1, 4, 'Aid & Relief Services 04', '0', NULL),
(65, 13, 64, 1, 2, 'SYDI 02', '#CECECE', NULL),
(66, 13, 65, 1, 3, 'SYDI 03', '0', NULL),
(67, 11, 66, 1, 3, 'Environment protection 03', '#CECECE', NULL),
(68, 9, 67, 1, 5, 'Fairs & Events 05', '#CECECE', NULL),
(69, 1, 68, 1, 5, 'Contact BTNs', '#CECECE', NULL),
(70, 2, 68, 1, 6, 'Contact BTNs', '#CECECE', NULL),
(71, 3, 68, 1, 5, 'Contact BTNs', '#CECECE', NULL),
(72, 5, 68, 1, 5, 'Contact BTNs', '#CECECE', NULL),
(73, 6, 68, 1, 5, 'Contact BTNs', '#CECECE', NULL),
(74, 8, 68, 1, 5, 'Contact BTNs', '#CECECE', NULL),
(75, 7, 68, 1, 5, 'Contact BTNs', '#CECECE', NULL),
(76, 4, 68, 1, 5, 'Contact BTNs', '#CECECE', NULL),
(77, 1, 69, 1, 2, 'Complete Logistics Services Brochure', '0', NULL),
(78, 2, 69, 1, 3, 'Complete Logistics Services Brochure', '0', NULL),
(79, 7, 69, 1, 2, 'Complete Logistics Services Brochure', '0', NULL),
(80, 3, 69, 1, 2, 'Complete Logistics Services Brochure', '0', NULL),
(81, 4, 69, 1, 2, 'Complete Logistics Services Brochure', '0', NULL),
(82, 5, 69, 1, 2, 'Complete Logistics Services Brochure', '0', NULL),
(83, 8, 69, 1, 2, 'Complete Logistics Services Brochure', '0', NULL),
(84, 14, 70, 1, 4, 'Code & Vision', '0', NULL),
(85, 6, 69, 1, 2, 'Complete Logistics Services Brochure', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_slider_mst`
--

DROP TABLE IF EXISTS `cpy_slider_mst`;
CREATE TABLE IF NOT EXISTS `cpy_slider_mst` (
  `slid_id` int(11) NOT NULL AUTO_INCREMENT,
  `slid_name` varchar(200) NOT NULL,
  `slid_rem` text,
  PRIMARY KEY (`slid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_slider_mst`
--

INSERT INTO `cpy_slider_mst` (`slid_id`, `slid_name`, `slid_rem`) VALUES
(1, 'Main Slider', 'Main Slider'),
(2, 'Air Freight', 'Air Freight'),
(3, 'Syrian Youth Development initiative', NULL),
(4, 'Ocean Freight', NULL),
(5, 'Warehousing', NULL),
(6, 'Road Freight', NULL),
(7, 'Projects', NULL),
(8, 'Packing, Removal', NULL),
(9, 'Culture Support', NULL),
(10, 'Environment protection', NULL),
(11, 'Fairs, Events', NULL),
(12, 'Insurance', NULL),
(13, 'Multimodal Transport', NULL),
(14, 'Nazha Logistics', NULL),
(15, 'Quality Assurance', NULL),
(16, 'Customs Clearance', NULL),
(17, 'Aid & Relief Services', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cpy_slider_trn`
--

DROP TABLE IF EXISTS `cpy_slider_trn`;
CREATE TABLE IF NOT EXISTS `cpy_slider_trn` (
  `tslid_id` int(11) NOT NULL AUTO_INCREMENT,
  `slid_id` int(11) NOT NULL,
  `slid_order` smallint(6) NOT NULL DEFAULT '0',
  `slid_header` varchar(200) DEFAULT NULL,
  `slid_text` text,
  `slid_photo` varchar(200) NOT NULL,
  `slid_link` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`tslid_id`),
  KEY `slid_id` (`slid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cpy_slider_trn`
--

INSERT INTO `cpy_slider_trn` (`tslid_id`, `slid_id`, `slid_order`, `slid_header`, `slid_text`, `slid_photo`, `slid_link`) VALUES
(1, 1, 1, NULL, NULL, 'img01.jpg', NULL),
(2, 1, 2, NULL, NULL, 'img02.jpg', NULL),
(3, 1, 3, NULL, NULL, 'img03.jpg', NULL),
(5, 2, 2, NULL, NULL, 'Upper.jpg', NULL),
(6, 3, 1, NULL, NULL, 'Page header photo(7).jpg', NULL),
(7, 4, 0, NULL, NULL, 'Page header photo.jpg', NULL),
(8, 5, 0, NULL, NULL, 'Page header photo(1).jpg', NULL),
(9, 6, 0, NULL, NULL, 'Page header photo(2).jpg', NULL),
(10, 7, 0, NULL, NULL, 'Page header photo(3).jpg', NULL),
(11, 8, 0, NULL, NULL, 'Page header photo(4).jpg', NULL),
(12, 9, 0, NULL, NULL, 'Page header photo(5).jpg', NULL),
(13, 10, 0, NULL, NULL, 'Page header photo(6).jpg', NULL),
(14, 11, 0, NULL, NULL, '01-Header 1920 x 600.jpg', NULL),
(15, 12, 0, NULL, NULL, 'Page header photo(8).jpg', NULL),
(16, 13, 0, NULL, NULL, 'Page header photo(9).jpg', NULL),
(17, 14, 1, NULL, NULL, 'Page header photo(10).jpg', NULL),
(18, 15, 1, NULL, NULL, 'Page header photo(11).jpg', NULL),
(19, 16, 1, NULL, NULL, 'Page header photo(12).jpg', NULL),
(20, 17, 1, NULL, NULL, 'Page header photo(13).jpg', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vall`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vall`;
CREATE TABLE IF NOT EXISTS `cpy_vall` (
`page_id` int(11)
,`page_name` varchar(200)
,`page_status` smallint(6)
,`slid_id` int(11)
,`page_stext` text
,`pblk_id` int(11)
,`pblk_status` smallint(6)
,`pblk_order` smallint(6)
,`pblk_name` varchar(200)
,`pblk_bgcolor` varchar(50)
,`pblk_stext` text
,`blk_id` int(11)
,`blk_name` varchar(200)
,`blk_status` smallint(6)
,`blk_type` smallint(6)
,`blk_stext` text
,`dblk_id` int(11)
,`dblk_order` smallint(6)
,`dblk_status` smallint(6)
,`dblk_type` smallint(6)
,`dblk_name` varchar(200)
,`dblk_image` varchar(200)
,`dblk_text` text
,`dblk_stext` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vblock`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vblock`;
CREATE TABLE IF NOT EXISTS `cpy_vblock` (
`blk_id` int(11)
,`blk_name` varchar(200)
,`blk_status` smallint(6)
,`blk_type` smallint(6)
,`blk_stext` text
,`dblk_id` int(11)
,`dblk_order` smallint(6)
,`dblk_status` smallint(6)
,`dblk_type` smallint(6)
,`dblk_name` varchar(200)
,`dblk_image` varchar(200)
,`dblk_text` text
,`dblk_stext` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vmenu`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vmenu`;
CREATE TABLE IF NOT EXISTS `cpy_vmenu` (
`menu_id` int(11)
,`menu_pid` int(11)
,`menu_pname` varchar(200)
,`menu_rid` int(11)
,`mode_id` int(11)
,`mode_name` varchar(200)
,`type_id` int(11)
,`type_name` varchar(200)
,`srch_id` int(11)
,`srch_name` varchar(200)
,`menu_order` int(11)
,`menu_status` smallint(6)
,`menu_name` varchar(200)
,`menu_icon` varchar(50)
,`page_id` int(11)
,`menu_href` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vpage`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vpage`;
CREATE TABLE IF NOT EXISTS `cpy_vpage` (
`page_id` int(11)
,`page_name` varchar(200)
,`page_status` smallint(6)
,`slid_id` int(11)
,`page_stext` text
,`pblk_id` int(11)
,`blk_id` int(11)
,`pblk_status` smallint(6)
,`pblk_order` smallint(6)
,`pblk_name` varchar(200)
,`pblk_bgcolor` varchar(50)
,`pblk_stext` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `cpy_vslider`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `cpy_vslider`;
CREATE TABLE IF NOT EXISTS `cpy_vslider` (
`slid_id` int(11)
,`slid_name` varchar(200)
,`slid_rem` text
,`tslid_id` int(11)
,`slid_order` smallint(6)
,`slid_header` varchar(200)
,`slid_text` text
,`slid_photo` varchar(200)
,`slid_link` varchar(200)
);

-- --------------------------------------------------------

--
-- Table structure for table `phs_metta`
--

DROP TABLE IF EXISTS `phs_metta`;
CREATE TABLE IF NOT EXISTS `phs_metta` (
  `mtta_id` int(11) NOT NULL AUTO_INCREMENT,
  `metta_name` varchar(200) NOT NULL,
  `metta_value` text NOT NULL,
  PRIMARY KEY (`mtta_id`),
  UNIQUE KEY `metta_name` (`metta_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_metta`
--

INSERT INTO `phs_metta` (`mtta_id`, `metta_name`, `metta_value`) VALUES
(1, 'Autor', 'Nazha'),
(2, 'phsoft', 'phsoft'),
(3, 'keywords', 'software erp solutions accounting finance manufacture crm account-payable account-receivable');

-- --------------------------------------------------------

--
-- Table structure for table `phs_perms`
--

DROP TABLE IF EXISTS `phs_perms`;
CREATE TABLE IF NOT EXISTS `phs_perms` (
  `perm_id` int(11) NOT NULL AUTO_INCREMENT,
  `pgrp_id` int(11) NOT NULL,
  `perm_table` varchar(255) NOT NULL,
  `perm_perm` int(11) NOT NULL,
  PRIMARY KEY (`perm_id`),
  KEY `pgrp_id` (`pgrp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phs_pgroup`
--

DROP TABLE IF EXISTS `phs_pgroup`;
CREATE TABLE IF NOT EXISTS `phs_pgroup` (
  `pgrp_id` int(11) NOT NULL,
  `pgrp_name` varchar(255) NOT NULL,
  PRIMARY KEY (`pgrp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_pgroup`
--

INSERT INTO `phs_pgroup` (`pgrp_id`, `pgrp_name`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `phs_setting`
--

DROP TABLE IF EXISTS `phs_setting`;
CREATE TABLE IF NOT EXISTS `phs_setting` (
  `set_id` int(11) NOT NULL AUTO_INCREMENT,
  `set_name` varchar(100) NOT NULL,
  `set_val` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`set_id`),
  UNIQUE KEY `set_name` (`set_name`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_setting`
--

INSERT INTO `phs_setting` (`set_id`, `set_name`, `set_val`) VALUES
(7, 'Disp-Header', '1'),
(8, 'Disp-Footer', '1'),
(10, 'Search-Result-Lines', '3'),
(27, 'Main-Menu-Left', '100'),
(28, 'Main-Menu-Right', '200'),
(29, 'Site-Name', 'DHL - Syria'),
(30, 'Disp-Facebook', '1'),
(31, 'URL-facebook', 'https://www.facebook.com/DHLSYR?fref=ts'),
(32, 'Disp-Search', '1'),
(33, 'Disp-Home', '1'),
(34, 'Default-Slider', 'Main Slider');

-- --------------------------------------------------------

--
-- Table structure for table `phs_users`
--

DROP TABLE IF EXISTS `phs_users`;
CREATE TABLE IF NOT EXISTS `phs_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `pgrp_id` int(11) DEFAULT NULL,
  `user_logon` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phs_users`
--

INSERT INTO `phs_users` (`user_id`, `pgrp_id`, `user_logon`, `user_password`, `user_email`) VALUES
(3, -1, 'haytham', '964dfe818a21e507d424ac718218fbf0', 'h.phsoft@gmail.com'),
(4, -1, 'admin', 'eb0a191797624dd3a48fa681d3061212', 'site_admin@nazha.com');

-- --------------------------------------------------------

--
-- Structure for view `cpy_vall`
--
DROP TABLE IF EXISTS `cpy_vall`;

CREATE VIEW `cpy_vall`  AS  select `p`.`page_id` AS `page_id`,`p`.`page_name` AS `page_name`,`p`.`page_status` AS `page_status`,`p`.`slid_id` AS `slid_id`,`p`.`page_stext` AS `page_stext`,`p`.`pblk_id` AS `pblk_id`,`p`.`pblk_status` AS `pblk_status`,`p`.`pblk_order` AS `pblk_order`,`p`.`pblk_name` AS `pblk_name`,`p`.`pblk_bgcolor` AS `pblk_bgcolor`,`p`.`pblk_stext` AS `pblk_stext`,`b`.`blk_id` AS `blk_id`,`b`.`blk_name` AS `blk_name`,`b`.`blk_status` AS `blk_status`,`b`.`blk_type` AS `blk_type`,`b`.`blk_stext` AS `blk_stext`,`b`.`dblk_id` AS `dblk_id`,`b`.`dblk_order` AS `dblk_order`,`b`.`dblk_status` AS `dblk_status`,`b`.`dblk_type` AS `dblk_type`,`b`.`dblk_name` AS `dblk_name`,`b`.`dblk_image` AS `dblk_image`,`b`.`dblk_text` AS `dblk_text`,`b`.`dblk_stext` AS `dblk_stext` from (`cpy_vpage` `p` left join `cpy_vblock` `b` on((`b`.`blk_id` = `p`.`blk_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `cpy_vblock`
--
DROP TABLE IF EXISTS `cpy_vblock`;

CREATE VIEW `cpy_vblock`  AS  select `b`.`blk_id` AS `blk_id`,`b`.`blk_name` AS `blk_name`,`b`.`blk_status` AS `blk_status`,`b`.`blk_type` AS `blk_type`,`b`.`blk_stext` AS `blk_stext`,`d`.`dblk_id` AS `dblk_id`,`d`.`dblk_order` AS `dblk_order`,`d`.`dblk_status` AS `dblk_status`,`d`.`dblk_type` AS `dblk_type`,`d`.`dblk_name` AS `dblk_name`,`d`.`dblk_image` AS `dblk_image`,`d`.`dblk_text` AS `dblk_text`,`d`.`dblk_stext` AS `dblk_stext` from (`cpy_block` `b` left join `cpy_block_detail` `d` on((`d`.`blk_id` = `b`.`blk_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `cpy_vmenu`
--
DROP TABLE IF EXISTS `cpy_vmenu`;

CREATE VIEW `cpy_vmenu`  AS  select `m`.`menu_id` AS `menu_id`,`p`.`menu_id` AS `menu_pid`,`p`.`menu_name` AS `menu_pname`,`m`.`menu_rid` AS `menu_rid`,`md`.`mode_id` AS `mode_id`,`md`.`mode_name` AS `mode_name`,`tp`.`type_id` AS `type_id`,`tp`.`type_name` AS `type_name`,`sr`.`srch_id` AS `srch_id`,`sr`.`srch_name` AS `srch_name`,`m`.`menu_order` AS `menu_order`,`m`.`menu_status` AS `menu_status`,`m`.`menu_name` AS `menu_name`,`m`.`menu_icon` AS `menu_icon`,`m`.`page_id` AS `page_id`,`m`.`menu_href` AS `menu_href` from ((((`cpy_menu` `m` join `cpy_menu` `p`) join `cpy_menu_mode` `md`) join `cpy_menu_search` `sr`) join `cpy_menu_type` `tp`) where ((`m`.`menu_pid` = `p`.`menu_id`) and (`m`.`mode_id` = `md`.`mode_id`) and (`m`.`srch_id` = `sr`.`srch_id`) and (`m`.`type_id` = `tp`.`type_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `cpy_vpage`
--
DROP TABLE IF EXISTS `cpy_vpage`;

CREATE VIEW `cpy_vpage`  AS  select `p`.`page_id` AS `page_id`,`p`.`page_name` AS `page_name`,`p`.`page_status` AS `page_status`,`p`.`slid_id` AS `slid_id`,`p`.`page_stext` AS `page_stext`,`b`.`pblk_id` AS `pblk_id`,`b`.`blk_id` AS `blk_id`,`b`.`pblk_status` AS `pblk_status`,`b`.`pblk_order` AS `pblk_order`,`b`.`pblk_name` AS `pblk_name`,`b`.`pblk_bgcolor` AS `pblk_bgcolor`,`b`.`pblk_stext` AS `pblk_stext` from (`cpy_page` `p` left join `cpy_page_block` `b` on((`b`.`page_id` = `p`.`page_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `cpy_vslider`
--
DROP TABLE IF EXISTS `cpy_vslider`;

CREATE VIEW `cpy_vslider`  AS  select `m`.`slid_id` AS `slid_id`,`m`.`slid_name` AS `slid_name`,`m`.`slid_rem` AS `slid_rem`,`t`.`tslid_id` AS `tslid_id`,`t`.`slid_order` AS `slid_order`,`t`.`slid_header` AS `slid_header`,`t`.`slid_text` AS `slid_text`,`t`.`slid_photo` AS `slid_photo`,`t`.`slid_link` AS `slid_link` from (`cpy_slider_mst` `m` join `cpy_slider_trn` `t`) where (`t`.`slid_id` = `m`.`slid_id`) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cpy_menu`
--
ALTER TABLE `cpy_menu`
  ADD CONSTRAINT `cpy_menu_ibfk_1` FOREIGN KEY (`menu_pid`) REFERENCES `cpy_menu` (`menu_id`),
  ADD CONSTRAINT `cpy_menu_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `cpy_page` (`page_id`),
  ADD CONSTRAINT `cpy_menu_ibfk_3` FOREIGN KEY (`mode_id`) REFERENCES `cpy_menu_mode` (`mode_id`),
  ADD CONSTRAINT `cpy_menu_ibfk_4` FOREIGN KEY (`type_id`) REFERENCES `cpy_menu_type` (`type_id`),
  ADD CONSTRAINT `cpy_menu_ibfk_5` FOREIGN KEY (`srch_id`) REFERENCES `cpy_menu_search` (`srch_id`),
  ADD CONSTRAINT `cpy_menu_ibfk_6` FOREIGN KEY (`menu_rid`) REFERENCES `cpy_menu` (`menu_id`);

--
-- Constraints for table `cpy_news`
--
ALTER TABLE `cpy_news`
  ADD CONSTRAINT `cpy_news_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `cpy_news_type` (`type_id`);

--
-- Constraints for table `cpy_news_images`
--
ALTER TABLE `cpy_news_images`
  ADD CONSTRAINT `cpy_news_images_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `cpy_news` (`news_id`);

--
-- Constraints for table `cpy_page`
--
ALTER TABLE `cpy_page`
  ADD CONSTRAINT `cpy_page_ibfk_1` FOREIGN KEY (`slid_id`) REFERENCES `cpy_slider_mst` (`slid_id`);

--
-- Constraints for table `phs_perms`
--
ALTER TABLE `phs_perms`
  ADD CONSTRAINT `phs_perms_ibfk_1` FOREIGN KEY (`pgrp_id`) REFERENCES `phs_pgroup` (`pgrp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
