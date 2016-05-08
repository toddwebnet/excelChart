CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob NOT NULL,
  PRIMARY KEY (id),
  KEY `ci_sessions_timestamp` (`timestamp`)
);



CREATE TABLE IF NOT EXISTS Users
(
  UserID            INT AUTO_INCREMENT NOT NULL,
  UserName          VARCHAR(16)        NOT NULL,
  Password          VARCHAR(64)        NOT NULL,
  ActiveInd         TINYINT DEFAULT 1,
  PRIMARY KEY (UserID)
);

delete from Users;
insert into Users (UserName, Password, ActiveInd) values ('admin', '$2a$07$IwishIwereanOscarMayee/fiwhz9Y1/TRQ3UuZPlH72mnwPKbTIS', 1);

/*
initial password is "trippleH"
 */