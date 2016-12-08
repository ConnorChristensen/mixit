CREATE TABLE IF NOT EXISTS Users (
    `username` VARCHAR(30) UNIQUE NOT NULL,
    `password` VARCHAR(120) NOT NULL,
    `email` VARCHAR(60) NOT NULL,
    `status` VARCHAR(60) DEFAULT "user",
    PRIMARY KEY (`username`),
    FOREIGN KEY (`username`) references Fav_Bevs(`username`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Bevs (
    `bevName` VARCHAR(30) UNIQUE NOT NULL,
    `type` VARCHAR(30),
    `glass` VARCHAR(20),
    `photo` VARCHAR(30),
    `description` VARCHAR(50),
    `instructions` VARCHAR(50),
    `ingredientList` VARCHAR(50),
    PRIMARY KEY (`bevName`),
    FOREIGN KEY (`bevName`) references Bev_Likes(`bevName`) 
);


CREATE TABLE IF NOT EXISTS User_Liked (
    `username` VARCHAR(30) NOT NULL,
    `bevName` VARCHAR(30) NOT NULL,                  
    PRIMARY KEY (`username`, `bevName`),
    FOREIGN KEY (`bevName`) references Bevs(`bevName`)
);


CREATE TABLE IF NOT EXISTS Ingredients (
    `ingredName` VARCHAR(30) NOT NULL,
    `bevName` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`ingredName`, `bevName`),
    FOREIGN KEY (`bevName`) references Bevs(`bevName`)
        ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Type (
    `typeName` VARCHAR(30) NOT NULL,
    `bevName` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`typeName`, `bevName`),
    FOREIGN KEY (`bevName`) references Bevs(`bevName`)
);


CREATE TABLE IF NOT EXISTS Bev_Likes (
    `bevName` VARCHAR(30) NOT NULL,
    `likes` INT(10) DEFAULT 0,
    PRIMARY KEY (`bevName`)
);


DELIMITER ||
CREATE TRIGGER addBevsToTables AFTER INSERT ON Bevs
FOR EACH ROW
BEGIN
    INSERT INTO Bev_Likes (bevName) VALUES (New.bevName);
    INSERT INTO Type VALUES (New.type, New.bevName);
END||

CREATE TRIGGER userLiked AFTER INSERT ON User_Liked
FOR EACH ROW
BEGIN
    UPDATE Bev_Likes
        SET likes = likes + 1
        WHERE bevName = New.bevName;
END||

CREATE TRIGGER userUnliked AFTER DELETE ON User_Liked
FOR EACH ROW
BEGIN
    UPDATE Bev_Likes
        SET likes = likes - 1
        WHERE bevName = old.bevName;
END||