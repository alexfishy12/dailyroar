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


-- LOGIN STORED PROCEDURE (USE THIS FOR AUTHENTICATION)
DELIMITER //
CREATE PROCEDURE `Try_Login`(
	IN p_email NVARCHAR(50), 
    IN p_password NVARCHAR(50)
)
`whole_proc`:
BEGIN
	-- Set variables
	SET @responseMessage = "";
	Set @p_email = p_email;
	Set @p_password = p_password;
    
    -- Define error handler to set responseMessage in case of error
	BEGIN
		DECLARE EXIT HANDLER FOR SQLEXCEPTION 
		GET DIAGNOSTICS CONDITION 1
			@p1 = RETURNED_SQLSTATE, 
			@p2 = MESSAGE_TEXT;
		SET @responseMessage = CONCAT_WS('Database Error: ', @p1, @p2);
	END;
    
	-- Check if username exists
	PREPARE stmt FROM "select count(ID) > 0 into @userExists from Login where Email_Address = ?;";
	EXECUTE stmt using @p_email;
	DEALLOCATE PREPARE stmt;
	IF @userExists = false THEN -- if username doesn't exist, return error
		SET @responseMessage = CONCAT("ERROR: Username doesn't exist.");
        SELECT @responseMessage;
		LEAVE whole_proc;
	END IF;
	
	-- Check if password is correct
	PREPARE stmt FROM "select count(ID) > 0 into @passwordCorrect from Login where Email_Address = ? and 
	password = UNHEX(SHA2(CONCAT(?, Salt), 512));";
	EXECUTE stmt using @p_email, @p_password;
	DEALLOCATE PREPARE stmt;
	IF @passwordCorrect = false THEN  -- if password isn't correct, return error
		SET @responseMessage = 'ERROR: Incorrect Password.'; 
        SELECT @responseMessage;
		LEAVE whole_proc;
	END IF;
	
	-- If the procedure gets this far, then the login was successful.
     SET @responseMessage = 'Success.'; 
	 SELECT @responseMessage;
END //


-- ADD NEW USER STORED PROCEDURE (USE THIS FOR CREATING A USER -- IT AUTOMATICALLY SALTS AND HASHES PASSWORD)
DELIMITER //
CREATE PROCEDURE `Add_Login`(
	IN p_account_type NVARCHAR(50),
	IN p_email NVARCHAR(200),
    IN p_password NVARCHAR(50)
)
`whole_proc`:
BEGIN
		SET @responseMessage = "";
		SET @p_account_type = p_account_type;
		-- check to see if account type is valid
		IF @p_account_type != "GA" AND @p_account_type != "FA" THEN
			SET @responseMessage = CONCAT("ERROR: Invalid account type.");
            SELECT @responseMessage;
            LEAVE whole_proc;
		END IF;
        
		SET @p_email = p_email;
		-- Check if username exists
		PREPARE stmt FROM "select count(ID) > 0 into @userExists from Login where Email_Address = ?;";
        EXECUTE stmt using @p_email;
        DEALLOCATE PREPARE stmt;
        IF @userExists = 1 THEN -- if username exists, return error
			SET @responseMessage = CONCAT("ERROR: Email already taken.");
            SELECT @responseMessage;
            LEAVE whole_proc;
		END IF;
    BEGIN 
    
        DECLARE EXIT HANDLER FOR SQLEXCEPTION  -- Define an error handler to set the responseMessage variable in case of error
            GET DIAGNOSTICS CONDITION 1
                @p1 = RETURNED_SQLSTATE, 
                @p2 = MESSAGE_TEXT;
            SET @responseMessage = CONCAT_WS('Database Error: ', @p1, @p2);
		
        -- set variables
        SET @p_password = p_password;
        SET @p_email    = p_email;
        SET @salt = UUID();
        SET @passhash = UNHEX(SHA2(CONCAT(@p_password, @salt), 512));  -- Hash the password with salt and convert to binary
        
        PREPARE stmt FROM "INSERT INTO Login (Account_Type, Email_Address, Password, Salt) VALUES(?, ?, ?, ?)";
        EXECUTE stmt using @p_account_type, @p_email, @passhash , @salt;
        DEALLOCATE PREPARE stmt;

		-- Set responseMessage variable to Success if the insert was successful
        SET @responseMessage = 'Success.'; 
        SELECT @responseMessage;
    END;
END //