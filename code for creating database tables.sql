--
CREATE TABLE Students (
    StudentID int NOT NULL AUTO_INCREMENT,
    FirstName varchar(255),
    LastName varchar(255),
   	ActiveProgram varchar(255),
    Major1 varchar(255),
    Major2 varchar(255),
    Minor varchar(255),
    ClassStanding varchar(255),
    EmailAddress varchar(255),
    PRIMARY KEY (StudentID)
);

--create table for curriculum
CREATE TABLE Curriculum (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Curriculum varchar(255)
);

--insert statement to add distinct curriculums (not active)
INSERT INTO Curriculum (Curriculum)
  SELECT DISTINCT Major1 FROM Students WHERE Major1 <> ''
  UNION
  SELECT DISTINCT Major2 FROM Students WHERE Major2 <> ''
  UNION
  SELECT DISTINCT Minor FROM Students WHERE Minor <> '';

--create table for class standing 
CREATE TABLE Class_Standing (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  Standing varchar(255)
);

--insert distinct class standings into the table (not active)
INSERT INTO Class_Standing  (Standing)
  SELECT DISTINCT ClassStanding FROM Students WHERE ClassStanding <> '';

--create tracking
CREATE TABLE `Tracking` (
  `StudentID` int(11) NOT NULL,
  `EmailID` int(11) NOT NULL,
  `Opened` tinyint(1) DEFAULT 0,
  `Clicked` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`StudentID`,`EmailID`)
) 

--create login
CREATE TABLE `Login` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Account_Type` varchar(10) DEFAULT NULL,
  `Email_Address` varchar(50) DEFAULT NULL,
  `Password` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`ID`)
)


--