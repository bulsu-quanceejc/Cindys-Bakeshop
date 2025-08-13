-- Table structure for table `refund`
CREATE TABLE `refund` (
  `Refund_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Order_ID` int(11) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Reason` text DEFAULT NULL,
  `Refund_Date` date DEFAULT NULL,
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  PRIMARY KEY (`Refund_ID`),
  KEY `Order_ID` (`Order_ID`),
  KEY `User_ID` (`User_ID`),
  CONSTRAINT `refund_ibfk_1` FOREIGN KEY (`Order_ID`) REFERENCES `order` (`Order_ID`),
  CONSTRAINT `refund_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
